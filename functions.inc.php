<?php 
/* $Id $ */

/* paging_init - Is run every time the page is loaded, checks
   to make sure that the database is current and loaded, if not,
   it propogates it. I expect that extra code will go here to 
   check for version upgrades, etc, of the paging database, to
   allow for easy upgrades. */

//	Generates dialplan for paging  - is called from retrieve_conf

function paging_get_config($engine) {
	global $db;
	global $ext; 
	switch($engine) {
		case "asterisk":
			// setup for intercom
			$fcc = new featurecode('paging', 'intercom-prefix');
			$intercom_code = $fcc->getCodeActive();
			unset($fcc);

			// Since these are going down channel local, set ALERT_INFO and SIPADDHEADER which will be set in dialparties.agi
			// no point in even setting the headers here they will get lost in channel local
			//
			$extpaging = 'ext-paging';
			if (!empty($intercom_code)) {
				$code = '_'.$intercom_code.'.';
				$context = 'ext-intercom';
				$ext->add($context, $code, '', new ext_macro('user-callerid'));
				$ext->add($context, $code, '', new ext_setvar('dialnumber', '${EXTEN:'.strlen($intercom_code).'}'));
				$ext->add($context, $code, '', new ext_gotoif('$["${DB(AMPUSER/${AMPUSER}/intercom/block)}" = "blocked"]', 'end'));
				$ext->add($context, $code, '', new ext_gotoif('$["${DB(DND/${dialnumber})}" = "YES"]', 'end'));
				$ext->add($context, $code, '', new ext_gotoif('$["${DB(AMPUSER/${dialnumber}/intercom/${AMPUSER})}" = "allow" ]', 'allow'));
				$ext->add($context, $code, '', new ext_gotoif('$["${DB(AMPUSER/${dialnumber}/intercom/${AMPUSER})}" = "deny" ]', 'nointercom'));
				$ext->add($context, $code, '', new ext_gotoif('$["${DB(AMPUSER/${dialnumber}/intercom)}" = "disabled" ]', 'nointercom'));
				$ext->add($context, $code, 'allow', new ext_dbget('DEVICES','AMPUSER/${dialnumber}/device'));
				$ext->add($context, $code, '', new ext_gotoif('$["${DEVICES}" = "" ]', 'end'));
				$ext->add($context, $code, '', new ext_setvar('LOOPCNT', '${FIELDQTY(DEVICES,&)}'));
				$ext->add($context, $code, '', new ext_gotoif('$[${LOOPCNT} > 1 ]', 'pagemode'));
				$ext->add($context, $code, '', new ext_macro('autoanswer','${DEVICES}'));
				$ext->add($context, $code, 'check', new ext_chanisavail('${DIAL}', 'sj'));
				$ext->add($context, $code, '', new ext_dial('${DIAL}','5,A(beep)'));
				$ext->add($context, $code, 'end', new ext_busy());
				$ext->add($context, $code, '', new ext_macro('hangupcall'));
				$ext->add($context, $code, '', new ext_busy(), 'check',101);
				$ext->add($context, $code, '', new ext_macro('hangupcall'));
				$ext->add($context, $code, 'pagemode', new ext_setvar('ITER', '1'));
				$ext->add($context, $code, '', new ext_setvar('DIALSTR', ''));
				$ext->add($context, $code, 'begin', new ext_setvar('DIALSTR', '${DIALSTR}&LOCAL/PAGE${CUT(DEVICES,&,${ITER})}@'.$extpaging));
				$ext->add($context, $code, '', new ext_setvar('ITER', '$[${ITER} + 1]'));
				$ext->add($context, $code, '', new ext_gotoif('$[${ITER} <= ${LOOPCNT}]', 'begin'));
				$ext->add($context, $code, '', new ext_setvar('DIALSTR', '${DIALSTR:1}'));
				$ext->add($context, $code, '', new ext_setvar('_FORCE_PAGE', '0'));
				$ext->add($context, $code, '', new ext_setvar('_AMPUSER', '${AMPUSER}'));
				$ext->add($context, $code, '', new ext_page('${DIALSTR},d'));
				$ext->add($context, $code, '', new ext_busy());
				$ext->add($context, $code, '', new ext_macro('hangupcall'));
				$ext->add($context, $code, 'nointercom', new ext_noop('Intercom disallowed by ${dialnumber}'));
				$ext->add($context, $code, '', new ext_playback('intercom&for&extension'));
				$ext->add($context, $code, '', new ext_saydigits('${dialnumber}'));
				$ext->add($context, $code, '', new ext_playback('is&disabled'));
				$ext->add($context, $code, '', new ext_congestion());

				$extintercomusers = 'ext-intercom-users';
				$userlist = core_users_list();
				if (is_array($userlist)) {
					foreach($userlist as $item) {
						$ext_intercom_code = $intercom_code.$item[0];
						$ext->add($extintercomusers, $ext_intercom_code, '', new ext_goto($context.',${EXTEN},1'));
					}
				}

				$context = $extintercomusers;
				$ext->addInclude('from-internal-additional', $context);
			}
			
			$fcc = new featurecode('paging', 'intercom-on');
			$oncode = $fcc->getCodeActive();
			unset($fcc);

			if ($oncode) {
				$ext->add($context, $oncode, '', new ext_answer(''));
				$ext->add($context, $oncode, '', new ext_wait('1'));
				$ext->add($context, $oncode, '', new ext_macro('user-callerid'));
				$ext->add($context, $oncode, '', new ext_setvar('DB(AMPUSER/${AMPUSER}/intercom)', 'enabled'));
				$ext->add($context, $oncode, '', new ext_playback('intercom&enabled'));
				$ext->add($context, $oncode, '', new ext_macro('hangupcall'));

				$target = '${EXTEN:'.strlen($oncode).'}';
				$oncode = "_".$oncode.".";
				$ext->add($context, $oncode, '', new ext_answer(''));
				$ext->add($context, $oncode, '', new ext_wait('1'));
				$ext->add($context, $oncode, '', new ext_macro('user-callerid'));
				$ext->add($context, $oncode, '', new ext_gotoif('$["${DB(AMPUSER/${AMPUSER}/intercom/'.$target.')}" = "allow" ]}','unset'));
				$ext->add($context, $oncode, '', new ext_gotoif('$[${DB_EXISTS(AMPUSER/${EXTEN:3}/device)} != 1]','invaliduser'));
				$ext->add($context, $oncode, '', new ext_dbput('AMPUSER/${AMPUSER}/intercom/'.$target, 'allow'));
				$ext->add($context, $oncode, '', new ext_playback('intercom&enabled&for&extension&number'));
				$ext->add($context, $oncode, '', new ext_saydigits($target));
				$ext->add($context, $oncode, '', new ext_macro('hangupcall'));
				$ext->add($context, $oncode, 'unset', new ext_dbdeltree('AMPUSER/${AMPUSER}/intercom/'.$target));
				$ext->add($context, $oncode, '', new ext_playback('intercom&enabled&cancelled&for&extension&number'));
				$ext->add($context, $oncode, '', new ext_saydigits($target));
				$ext->add($context, $oncode, '', new ext_macro('hangupcall'));
				$ext->add($context, $oncode, 'invaliduser', new ext_playback('extension&number'));
				$ext->add($context, $oncode, '', new ext_saydigits($target));
				$ext->add($context, $oncode, '', new ext_playback('is&invalid'));
				$ext->add($context, $oncode, '', new ext_macro('hangupcall'));
			}
			
			$fcc = new featurecode('paging', 'intercom-off');
			$offcode = $fcc->getCodeActive();
			unset($fcc);
	
			if ($offcode) {
				$ext->add($context, $offcode, '', new ext_answer(''));
				$ext->add($context, $offcode, '', new ext_wait('1'));
				$ext->add($context, $offcode, '', new ext_macro('user-callerid'));
				$ext->add($context, $offcode, '', new ext_setvar('DB(AMPUSER/${AMPUSER}/intercom)', 'disabled'));
				$ext->add($context, $offcode, '', new ext_playback('intercom&disabled'));
				$ext->add($context, $offcode, '', new ext_macro('hangupcall'));

				$target = '${EXTEN:'.strlen($offcode).'}';
				$offcode = "_".$offcode.".";
				$ext->add($context, $offcode, '', new ext_answer(''));
				$ext->add($context, $offcode, '', new ext_wait('1'));
				$ext->add($context, $offcode, '', new ext_macro('user-callerid'));
				$ext->add($context, $offcode, '', new ext_gotoif('$["${DB(AMPUSER/${AMPUSER}/intercom/'.$target.')}" = "deny" ]}','unset2'));
				$ext->add($context, $offcode, '', new ext_gotoif('$[${DB_EXISTS(AMPUSER/${EXTEN:3}/device)} != 1]','invaliduser2'));
				$ext->add($context, $offcode, '', new ext_dbput('AMPUSER/${AMPUSER}/intercom/'.$target, 'deny'));
				$ext->add($context, $offcode, '', new ext_playback('intercom&disabled&for&extension&number'));
				$ext->add($context, $offcode, '', new ext_saydigits($target));
				$ext->add($context, $offcode, '', new ext_macro('hangupcall'));
				$ext->add($context, $offcode, 'unset2', new ext_dbdeltree('AMPUSER/${AMPUSER}/intercom/'.$target));
				$ext->add($context, $offcode, '', new ext_playback('intercom&disabled&cancelled&for&extension&number'));
				$ext->add($context, $offcode, '', new ext_saydigits($target));
				$ext->add($context, $offcode, '', new ext_macro('hangupcall'));
				$ext->add($context, $offcode, 'invaliduser2', new ext_playback('extension&number'));
				$ext->add($context, $offcode, '', new ext_saydigits($target));
				$ext->add($context, $offcode, '', new ext_playback('is&invalid'));
				$ext->add($context, $offcode, '', new ext_macro('hangupcall'));
			}

			/* Create macro-autoanswer that will try to intelligently set the
		   	required parameters to handle paging. Eventually it will use
			 	known device information.

				This macro does the following:

				Input:  FreePBX Device number to be called requiring autoanswer
				Output: ${DIAL} Channel Variable with the dial string to be called
				        Appropriate SIP headers added
								Other special requirements that may be custom for this device

				1. Set ${DIAL} to the device's dial string
				2. If there is a device specific macro defined in the DEVICE's object
				   (DEVICE/<devicenum>/autoanswer/macro) then execute that macro and end
				3. Set defaults for Alert-Info and Call-Info headers and SIP_URI_OPTIONS
				4. Try to identify endpoints by their useragents that may need known
				   changes and make those changes. These are generated from the
					 paging_autoanswer table so users can extend them
				5. Set the variables and end unless a useragent specific ANSWERMACRO is
				   defined in which case call it and end.

				This macro is called for intercoming and paging to try and enable the
				target device to auto-answer. Devices with special needs can be handled
				with the device specific macro. For example, if you have a device that
				can not auto-answer except by specifically configuring a line key on
				the device that always answers, you could use a device specific macro
				to change the dialstring. If you had a set of such devices, you could
				standardize on the device numbers (e.g. nnnn for normal calls and 2nnnn
				for auto-answer calls). You could then create a general purpose macro
				to modify the dial string accordingly. Provisioning tools will be able
				to take advantage of setting and creating such an ability.
				If you have a set of devices that can be identified with a SIP useragent
				then you can use a general macro without setting info in each device.
		 	*/

			// Get the default values from the SQL table
			//
			$alertinfo = 'Alert-Info: Ring Answer';
			$callinfo  = 'Call-Info: <uri>\;answer-after=0';
			$sipuri    = 'intercom=true';
			$autoanswer_arr = paging_get_autoanswer_defaults();
			foreach ($autoanswer_arr as $autosetting) {
				switch (trim($autosetting['var'])) {
					case 'ALERTINFO':
						$alertinfo = trim($autosetting['setting']);
						break;
					case 'CALLINFO':
						$callinfo = trim($autosetting['setting']);
						break;
					case 'SIPURI':
						$sipuri = trim($autosetting['setting']);
						break;
				default:
				}
			}

			$macro = 'macro-autoanswer';
			$ext->add($macro, "s", '', new ext_setvar('DIAL', '${DB(DEVICE/${ARG1}/dial)}'));
			$ext->add($macro, "s", '', new ext_gotoif('$["${DB(DEVICE/${ARG1}/autoanswer/macro)}" != "" ]', 'macro'));
			$ext->add($macro, "s", '', new ext_setvar('phone', '${SIPPEER(${CUT(DIAL,/,2)}:useragent)}'));
			$ext->add($macro, "s", '', new ext_setvar('ALERTINFO', $alertinfo));
			$ext->add($macro, "s", '', new ext_setvar('CALLINFO', $callinfo));
			$ext->add($macro, "s", '', new ext_setvar('SIPURI', $sipuri));
			$ext->add($macro, "s", '', new ext_setvar('ANSWERMACRO', ''));

			// Defaults are setup, now make specific adjustments for detected phones
			// These come from the SQL table as well where installations can make customizations
			//
			$autoanswer_arr = paging_get_autoanswer_useragents();
			foreach ($autoanswer_arr as $autosetting) {
				$useragent   = trim($autosetting['useragent']);
				$autovar     = trim($autosetting['var']);
				$data        = trim($autosetting['setting']);
				switch (trim($autovar)) {
					case 'ALERTINFO':
					case 'CALLINFO':
					case 'SIPURI':
					case 'ANSWERMACRO':
						$ext->add($macro, "s", '', new ext_execif('$["${phone:0:'.strlen($useragent).'}" = "'.$useragent.'"]', 'Set',$autovar.'='.$data));
						break;
				default:
				}
			}

			// Now any adjustments have been made, set the headers and done
			//
			$ext->add($macro, "s", '', new ext_gotoif('$["${ANSWERMACRO}" != ""]','macro2'));
			$ext->add($macro, "s", '', new ext_execif('$["${ALERTINFO}" != ""]', 'SipAddHeader','${ALERTINFO}'));
			$ext->add($macro, "s", '', new ext_execif('$["${CALLINFO}" != ""]', 'SipAddHeader','${CALLINFO}'));
			$ext->add($macro, "s", '', new ext_execif('$["${SIPURI}" != ""]', 'Set','__SIP_URI_OPTIONS=${SIPURI}'));
			$ext->add($macro, "s", 'macro', new ext_macro('${DB(DEVICE/${ARG1}/autoanswer/macro)}','${ARG1}'), 'n',2);
			$ext->add($macro, "s", 'macro2', new ext_macro('${ANSWERMACRO}','${ARG1}'), 'n',2);


			// Create the paging context that is used in the paging application for each phone to auto-answer
			//
			$ext->addInclude('from-internal-additional',$extpaging);
				
			$ext->add($extpaging, "_PAGE.", '', new ext_gotoif('$[ ${AMPUSER} = ${EXTEN:4} ]','skipself'));
			$ext->add($extpaging, "_PAGE.", '', new ext_gotoif('$[ ${FORCE_PAGE} != 1 ]','AVAIL'));
			$ext->add($extpaging, "_PAGE.", '', new ext_setvar('AVAILSTATUS', 'not checked'));
			$ext->add($extpaging, "_PAGE.", '', new ext_goto('SKIPCHECK'));
			$ext->add($extpaging, "_PAGE.", 'AVAIL', new ext_chanisavail('${DB(DEVICE/${EXTEN:4}/dial)}', 'js'));
			$ext->add($extpaging, "_PAGE.", 'SKIPCHECK', new ext_noop('Seems to be available (state = ${AVAILSTATUS}'));
				
			$ext->add($extpaging, "_PAGE.", '', new ext_macro('autoanswer','${EXTEN:4}'));
		
			$ext->add($extpaging, "_PAGE.", '', new ext_dial('${DIAL}', '5, A(beep)'));
			$ext->add($extpaging, "_PAGE.", 'skipself', new ext_noop('Not paging originator'));
			$ext->add($extpaging, "_PAGE.", '', new ext_hangup());
				
			$ext->add($extpaging, "_PAGE.", '', new ext_noop('Channel ${AVAILCHAN} is not available (state = ${AVAILSTATUS})'), 'AVAIL',101);
			//
			// Now get a list of all the paging groups...
			$sql = "SELECT page_group, force_page, duplex FROM paging_config";
			$paging_groups = $db->getAll($sql, DB_FETCHMODE_ASSOC);
			foreach ($paging_groups as $thisgroup) {
				$grp=trim($thisgroup['page_group']);
				$sql = "SELECT ext FROM paging_groups WHERE page_number='$grp'";
				$all_exts = $db->getAll($sql);
				$dialstr='';
				foreach($all_exts as $local_dial) {
					if (strtoupper(substr($local_dial[0],-1)) == "X") {
						$local_dial[0] = rtrim($local_dial[0],"xX");
					}

					$dialstr .= "LOCAL/PAGE".trim($local_dial[0])."@".$extpaging."&";
				}
				// It will always end with an &, so lets take that off.
				$dialstr = rtrim($dialstr, "&");

				if ($thisgroup['duplex']) {
					$dialstr .= ",d";
				}
				$ext->add($extpaging, "Debug", '', new ext_noop("dialstr is $dialstr"));
				$ext->add($extpaging, $grp, '', new ext_setvar("_FORCE_PAGE", ($thisgroup['force_page']?1:0)));
				$ext->add($extpaging, $grp, '', new ext_macro('user-callerid'));
				// make AMPUSER inherited here, so we can skip the proper 'self' if using cidnum masquerading
				$ext->add($extpaging, $grp, '', new ext_setvar('_AMPUSER', '${AMPUSER}'));
				$ext->add($extpaging, $grp, '', new ext_page($dialstr));
			}
			
		break;
	}
}

function paging_get_autoanswer_defaults() {
	global $db;

	$sql = "SELECT * FROM paging_autoanswer WHERE useragent = 'default'";
	$results = $db->getAll($sql,DB_FETCHMODE_ASSOC);
	if(DB::IsError($results)) {
		$results = array();
	} 
	return $results;
}

function paging_get_autoanswer_useragents($useragent = '') {
	global $db;

	$sql = "SELECT * FROM paging_autoanswer WHERE useragent != 'default' ";
	if ($useragent != "") {
		$sql .= "AND useragent = $useragent ";
	}
	$results = $db->getAll($sql,DB_FETCHMODE_ASSOC);
	if(DB::IsError($results)) {
		$results = array();
	} 
	return $results;
}

function paging_list() {
	global $db;

	$sql = "SELECT page_group, description FROM paging_config ORDER BY page_group";
	$results = $db->getAll($sql,DB_FETCHMODE_ASSOC);
	if(DB::IsError($results)) {
		$results = null;
	} else {
		foreach ($results as $key => $list) {
			$results[$key][0] = $list['page_group'];
		}
	}
	// There should be a checkRange here I think, but I haven't looked into it yet.
	//	return array('999', '998', '997');
	return $results;
}

function paging_check_extensions($exten=true) {
	global $active_modules;

	$extenlist = array();
	if (is_array($exten) && empty($exten)) {
		return $extenlist;
	}

	$sql = "SELECT page_group, description FROM paging_config ";
	if (is_array($exten)) {
		$sql .= "WHERE page_group in ('".implode("','",$exten)."')";
	}
	$sql .= " ORDER BY page_group";
	$results = sql($sql,"getAll",DB_FETCHMODE_ASSOC);

	$type = isset($active_modules['paging']['type'])?$active_modules['paging']['type']:'setup';
	foreach ($results as $result) {
		$thisexten = $result['page_group'];
		$extenlist[$thisexten]['description'] = _("Page Group: ").$result['description'];
		$extenlist[$thisexten]['status'] = 'INUSE';
		$extenlist[$thisexten]['edit_url'] = 'config.php?type='.urlencode($type).'setup&display=paging&selection='.urlencode($thisexten).'&action=modify';
	}
	return $extenlist;
}

function paging_get_devs($grp) {
	global $db;

	// Just in case someone's trying to be smart with a SQL injection.
	$grp = addslashes($grp); 

	$sql = "SELECT ext FROM paging_groups where page_number='$grp'";
	$results = $db->getAll($sql);
	if(DB::IsError($results)) 
		$results = null;
	foreach ($results as $val)
		$tmparray[] = $val[0];
	return $tmparray;
}

function paging_get_pagingconfig($grp) {
	global $db;

	// Just in case someone's trying to be smart with a SQL injection.
	$grp = addslashes($grp); 

	$sql = "SELECT * FROM paging_config WHERE page_group='$grp'";
	$results = $db->getRow($sql, DB_FETCHMODE_ASSOC);
	if(DB::IsError($results)) 
		$results = null;
	return $results;
}

function paging_modify($oldxtn, $xtn, $plist, $force_page, $duplex, $description='') {
	global $db;

	// Just in case someone's trying to be smart with a SQL injection.
	$xtn = addslashes($xtn);

	// Delete it if it's there.
	paging_del($oldxtn);

	// Now add it all back in.
	paging_add($xtn, $plist, $force_page, $duplex, $description);

	// Aaad we need a reload.
	needreload();

}

function paging_del($xtn) {
	global $db;
	$sql = "DELETE FROM paging_groups WHERE page_number='$xtn'";
	$res = $db->query($sql);
	if (DB::isError($res)) {
		var_dump($res);
		die_freepbx("Error in paging_del(): ");
	}
	
	$sql = "DELETE FROM paging_config WHERE page_group='$xtn'";
	$res = $db->query($sql);
	if (DB::isError($res)) {
		var_dump($res);
		die_freepbx("Error in paging_del(): ");
	}
	
	needreload();
}

function paging_add($xtn, $plist, $force_page, $duplex, $description='') {
	global $db;

	// $plist contains a string of extensions, with \n as a seperator. 
	// Split that up first.
	if (is_array($plist)) {
		$xtns = $plist;
	} else {
		$xtns = explode("\n",$plist);
	}
	foreach (array_keys($xtns) as $val) {
		$val = addslashes(trim($xtns[$val]));
		// Sanity check input.
		
		$sql = "INSERT INTO paging_groups(page_number, ext) VALUES ('$xtn', '$val')";
		$db->query($sql);
	}
	
	$description = addslashes(trim($description));
	$sql = "INSERT INTO paging_config(page_group, force_page, duplex, description) VALUES ('$xtn', '$force_page', '$duplex', '$description')";
	$db->query($sql);
	
	needreload();
}
	
// this can be removed in 2.2 and put back to just runModuleSQL which is in admin/functions.inc.php
// I didn't want to do it in 2.1 as there's a significant user base out there, and it will break
// them if we do it here.

function pagingrunModuleSQL($moddir,$type){
        global $db;
        $data='';
        if (is_file("modules/{$moddir}/{$type}.sql")) {
                // run sql script
                $fd = fopen("modules/{$moddir}/{$type}.sql","r");
                while (!feof($fd)) {
                        $data .= fread($fd, 1024);
                }
                fclose($fd);

                preg_match_all("/((SELECT|INSERT|UPDATE|DELETE|CREATE|DROP).*);\s*\n/Us", $data, $matches);

                foreach ($matches[1] as $sql) {
                                $result = $db->query($sql);
                                if(DB::IsError($result)) {
                                        return false;
                                }
                }
                return true;
        }
                return true;
}

function paging_configpageinit($pagename) {
	global $currentcomponent;

	$action = isset($_REQUEST['action'])?$_REQUEST['action']:null;
	$extdisplay = isset($_REQUEST['extdisplay'])?$_REQUEST['extdisplay']:null;
	$extension = isset($_REQUEST['extension'])?$_REQUEST['extension']:null;
	$tech_hardware = isset($_REQUEST['tech_hardware'])?$_REQUEST['tech_hardware']:null;

	// We only want to hook 'users' or 'extensions' pages.
	if ($pagename != 'devices' && $pagename != 'extensions') {
		return true;
	}

	if ($extdisplay != '') {
		$currentcomponent->addprocessfunc('pagings_configprocess', 8);
	}
}

function pagings_configprocess() {
	global $db;

	//create vars from the request
	//
	$action = isset($_REQUEST['action'])?$_REQUEST['action']:null;
	$ext = isset($_REQUEST['extdisplay'])?$_REQUEST['extdisplay']:null;
	$extn = isset($_REQUEST['extension'])?$_REQUEST['extension']:null;
	$langcode = isset($_REQUEST['langcode'])?$_REQUEST['langcode']:null;

	$extdisplay = ($ext==='') ? $extn : $ext;
	if ($action == "del") {
		$sql = "DELETE FROM paging_groups WHERE ext = '$extdisplay'";
		$res = $db->query($sql);
		if (DB::isError($res)) {
			var_dump($res);
			die_freepbx("Error in paging_del(): ");
		}
	}
}

?>
