<?php 
/* $Id$ */
//Copyright (C) 2006 Rob Thomas (xrobau@gmail.com)
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of version 2 of the GNU General Public
//License as published by the Free Software Foundation.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

//Both of these are used for switch on config.php
$display = isset($_REQUEST['display'])?$_REQUEST['display']:'paging';
$type = isset($_REQUEST['type'])?$_REQUEST['type']:'tool';

$tabindex = 0;

$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$force_page = isset($_REQUEST['force_page']) ? $_REQUEST['force_page']:0;
$duplex = isset($_REQUEST['duplex']) ? $_REQUEST['duplex']:0;
$default_group = isset($_REQUEST['default_group']) ? $_REQUEST['default_group']:0;
$extdisplay = isset($_REQUEST['extdisplay'])?$_REQUEST['extdisplay']:'';
$pagelist = isset($_REQUEST['pagelist'])?$_REQUEST['pagelist']:'';
$pagenbr = isset($_REQUEST['pagenbr'])?$_REQUEST['pagenbr']:'';
$pagegrp = isset($_REQUEST['pagegrp'])?$_REQUEST['pagegrp']:'';
$description = isset($_REQUEST['description'])?$_REQUEST['description']:'';

?>


<?php
// Check to make sure that the paging database is propogated and
// up to date.

switch ($action) {
	case "add":
		paging_sidebar($extdisplay, $type, $display);
		paging_show(null, $display, $type);
		break;
	case "delete":
		paging_del($extdisplay);
		redirect_standard();
		break;
	case "modify":
		paging_sidebar($extdisplay, $type, $display);
		paging_show($extdisplay, $display, $type);
		break;
	case "submit":
		//TODO: issue, we are deleting and adding at the same time so remeber later to check
		//      if we are deleting a destination
		$usage_arr = array();
		if (trim($pagegrp) != trim($pagenbr)) {
			$usage_arr = framework_check_extension_usage($pagenbr);
		}
		if (!empty($usage_arr)) {
			$conflict_url = framework_display_extension_usage_alert($usage_arr);
			paging_sidebar($extdisplay, $type, $display);
			paging_show($pagegrp, $display, $type, $conflict_url);
		} else {
			paging_modify($pagegrp, $pagenbr, $pagelist, $force_page, $duplex, $description, $default_group);
      $_REQUEST['action'] = 'modify';
      if ($extdisplay == '') {
        $_REQUEST['extdisplay'] = $pagenbr;
      }
			redirect_standard('extdisplay','action');
		}
		break;
	default:
		paging_sidebar($extdisplay, $type, $display);
		paging_text();
}

function paging_text() {

	$fcc = new featurecode('paging', 'intercom-prefix');
	$intercom_code = $fcc->getCodeActive();
	unset($fcc);
	$fcc = new featurecode('paging', 'intercom-on');
	$oncode = $fcc->getCodeActive();
	unset($fcc);
	if ($oncode === '') {
		$oncode = "("._("Disabled").")";
	}
	$fcc = new featurecode('paging', 'intercom-off');
	$offcode = $fcc->getCodeActive();
	unset($fcc);
	if ($offcode === '') {
		$offcode = "("._("Disabled").")";
	}
	echo _("This module is for specific phones that are capable of Paging or Intercom. This section is for configuring group paging, intercom is configured through <strong>Feature Codes</strong>. Intercom must be enabled on a handset before it will allow incoming calls. It is possible to restrict incoming intercom calls to specific extensions only, or to allow intercom calls from all extensions but explicitly deny from specific extensions.<br /><br />This module should work with Aastra, Grandstream, Linksys/Sipura, Mitel, Polycom, SNOM , and possibly other SIP phones (not ATAs). Any phone that is always set to auto-answer should also work (such as the console extension if configured).") 
?><br /><br /><?php
	if ($intercom_code != '') {
		echo sprintf(_("Example usage:<br /><table><tr><td><strong>%snnn</strong>:</td><td>Intercom extension nnn</td></tr><tr><td><strong>%s</strong>:</td><td>Enable all extensions to intercom you (except those explicitly denied)</td></tr><tr><td><strong>%snnn</strong>:</td><td>Explicitly allow extension nnn to intercom you (even if others are disabled)</td></tr><tr><td><strong>%s</strong>:</td><td>Disable all extensions from intercom you (except those explicitly allowed)</td></tr><tr><td><strong>%snnn</strong>:</td><td>Explicitly deny extension nnn to intercom you (even if generally enabled)</td></tr></table>"),$intercom_code,$oncode,$oncode,$offcode,$offcode);
	} else {
		echo _("Intercom mode is currently disabled, it can be enabled in the Feature Codes Panel.");
	}
?>
<?php
}

function paging_show($xtn, $display, $type, $conflict_url=array()) {
	global $module_hook;

	if ($xtn) {
		$selected = paging_get_devs($xtn);
		$rows = count($selected)+1;
		if ($rows < 5) {
			$rows = 5;
		}
		if ($rows > 20) {
			$rows = 20;
		}

		$delURL = $_SERVER['PHP_SELF']."?type=${type}&amp;display=${display}&amp;action=delete&amp;extdisplay=${xtn}";
		$tlabel = sprintf(_("Delete Group %s"),$xtn);
		$label = '<span><img width="16" height="16" border="0" title="'.$tlabel.'" alt="" src="images/core_delete.png"/>&nbsp;'.$tlabel.'</span>';
		echo "<a href=".$delURL.">".$label."</a>";

	} else {
		$rows = 5;
	}
	if (!empty($conflict_url)) {
		echo "<h5>"._("Conflicting Extensions")."</h5>";
		echo implode('<br />',$conflict_url);
	}
	
	$config = paging_get_pagingconfig($xtn);

	$force_page = $config['force_page'];
	$duplex = $config['duplex'];
	$default_group = $config['default_group'];
	$description = $config['description'];
	
	echo "<form name='page_edit' action='".$_SERVER['PHP_SELF']."' method='post' onsubmit='return page_edit_onsubmit();'>\n";
	echo "<input type='hidden' name='display' value='${display}'>\n";
	echo "<input type='hidden' name='type' value='${type}'>\n";
	echo "<input type='hidden' name='pagegrp' value='{$xtn}'>\n";
	echo "<input type='hidden' name='extdisplay' value='{$xtn}'>\n";
	echo "<input type='hidden' name='action' value='submit'>\n";
	echo "<table><tr><td colspan=2><h5>";
	echo ($xtn)?_("Modify Paging Group"):_("Add Paging Group")."</h5></td></tr>\n";  ?>
	<tr>
		<td><a href='#' class='info'><?php echo _("Paging Extension") ?><span><?php echo _("The number users will dial to page this group") ?></span></a></td>
		<td><input size='5' type='text' name='pagenbr' value='<?php echo $xtn ?>' tabindex="<?php echo ++$tabindex;?>"></td>
	</tr>
	<tr>
    <td> <a href="#" class="info"><?php echo _("Group Description")?>:<span><?php echo _("Provide a descriptive title for this Page Group.")?></span></a></td>
		<td><input size="24" maxlength="24" type="text" name="description" id="description" value="<?php echo htmlspecialchars($description); ?>" tabindex="<?php echo ++$tabindex;?>"></td>
	</tr>
	<tr><td valign='top'><a href='#' class='info'><?php echo _("Device List:")."<span><br>"._("Select Device(s) to page. This is the phone that should be paged. In most installations, this is the same as the Extension. If you are configured to use \"Users & Devices\" this is the actual Device and not the User.  Use Ctrl key to select multiple..") ?> 
	<br><br></span></a></td>
	<td valign="top"> 
	
	<select multiple="multiple" name="pagelist[]" id="xtnlist"  tabindex="<?php echo ++$tabindex;?>">
	<?php 
	if (!isset($selected)) {
		$selected = paging_get_devs($xtn); 
	}
	if (is_null($selected)) $selected = array();
	foreach (core_devices_list() as $device) {
		echo '<option value="'.$device[0].'" ';
		if (array_search($device[0], $selected) !== false) echo ' selected="selected" ';
		echo '>'.$device[0].' - '.$device[1].'</option>';
	}
	?>
	</select>
		
		<br>
	</td></tr>

	<tr><td>
		<?php echo fpbx_label(_("Busy Extensions"), 
			_('<ul><li>"Skip" will not page any busy extension. All other extensions will '
			. 'be paged as normal</li>'
			. '<li>"Force" will not check if the device is in use before paging it. '
			. 'This means conversations can be interrupted by a page (depending '
			. 'on how the device handles it). This is useful for "emergency" '
			. 'paging groups.</li>'
			. '<li>"Whisper" will attempt to use the ChanSpy '
			. 'capability on SIP channels, resulting in the page being sent to '
			. 'the device\'s ear piece but not heard by the remote party. If '
			. 'ChanSpy is not supported on the device or otherwise fails, no page '
			. 'will get through. It probably does not make too much sense to choose '
			. 'duplex if using Whisper mode.</li></ul>')
			. ' ' 
			. _('The Whisper mode is new and considered experimental.')
			); ?>
	</td>
  <td>
	<span class="radioset">
	    <input id="force_page_no" type="radio" name="force_page" value="0" <?php echo $force_page == 0 ? "checked=\"yes\"":""?>/>
	    <label for="force_page_no"><?php echo _("Skip") ?></label>
	    <input id="force_page_yes" type="radio" name="force_page" value="1" <?php echo $force_page == 1 ? "checked=\"yes\"":""?>/>
	    <label for="force_page_yes"><?php echo _("Force") ?></label>
	    <input id="force_page_whisper" type="radio" name="force_page" value="2" <?php echo $force_page == 2 ? "checked=\"yes\"":""?>/>
	  	<label for="force_page_whisper"><?php echo _("Whisper") ?></label>
	</span>
  </td></tr>
	<tr><td><label for="duplex"><a href='#' class='info'><?php echo _("Duplex") ?><span>
	<?php echo _("Paging is typically one way for announcements only. Checking this will make the paging duplex, allowing all phones in the paging group to be able to talk and be heard by all. This makes it like an \"instant conference\"") ?></span></a></label></td>
	<td><input type='checkbox' name='duplex' id="duplex" value='1' <?php if ($duplex) { echo 'CHECKED'; } ?> tabindex="<?php echo ++$tabindex;?>"></td></tr>

	<tr><td><label for="default_group"><a href='#' class='info'><?php echo _("Default Page Group") ?><span>
	<?php echo _("Each PBX system can have a single Default Page Group. If specified, extensions can be automatically added (or removed) from this group in the Extensions (or Devices) tab.<br />Making this group the default will uncheck the option from the current default group if specified.") ?></span></a></label></td>
	<td><input type='checkbox' name='default_group' id="default_group" value='1' <?php if ($default_group) { echo 'CHECKED'; } ?> tabindex="<?php echo ++$tabindex;?>"></td></tr>

<?php
			// implementation of module hook
			// object was initialized in config.php
			echo $module_hook->hookHtml;
?>
	
	<tr>
	<td colspan="2"><br><h6><input type="submit" name="Submit" type="button" value="<?php echo _("Submit Changes")?>" tabindex="<?php echo ++$tabindex;?>"></h6></td>
	</tr>
	</table>
<script language="javascript">
<!--
var theForm = document.page_edit;
theForm.pagenbr.focus();

function page_edit_onsubmit() {
	var msgInvalidPageExt = "<?php echo _('Please enter a valid Paging Extension'); ?>";
	var msgInvalidExtList = "<?php echo _('Please select at least one extension'); ?>";

	defaultEmptyOK = false;
	if (!isInteger(theForm.pagenbr.value))
		return warnInvalid(theForm.pagenbr, msgInvalidPageExt);
	
	var selected = 0;
	for (var i=0; i < theForm.xtnlist.options.length; i++) {
		if (theForm.xtnlist.options[i].selected) selected += 1;
	}
	if (selected < 1) {
    theForm.xtnlist.focus();
		alert(msgInvalidExtList);
		return false;
	}
		
	return true;
}

-->
</script>
	</form>
<?php
}

function paging_sidebar($extdisplay, $type, $display) {
	echo "<div class='rnav'><ul>\n";
	echo "<li><a id='".($extdisplay==''?'current':'std')."' ";
	echo "href='config.php?type=${type}&amp;display=${display}&amp;action=add'>"._("Add Paging Group")."</a></li>"; 
	//get the list of paging groups
	$presults = paging_list();
  $default_grp = paging_get_default();



	if ($presults) {
		foreach ($presults as $grouparr) {
			$group = $grouparr['page_group'];
      $hl = $group == $default_grp ? _(' [DEFAULT]') : '';
			echo "<li><a class=\"".($extdisplay==$group ? 'current':'std');
			echo "\" href=\"config.php?type=${type}&amp;display=";
			echo "${display}&amp;extdisplay=${group}&amp;action=modify\">";
			echo $group." ".((trim($grouparr['description']) != '')?htmlspecialchars($grouparr['description']):_("Page Group"))."$hl</a></li>";
		}
	} 
	echo "</ul></div><h2>"._("Paging and Intercom")."</h2>\n";
}
?>
