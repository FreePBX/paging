<?php
// vim: set ai ts=4 sw=4 ft=php:
namespace FreePBX\modules;

class Paging extends \FreePBX_Helpers implements \BMO {

	public function __construct($freepbx = null) {
		$this->freepbx = $freepbx;
	}

	public function install() {

	}
	public function uninstall() {

	}
	public function backup(){

	}
	public function restore($backup){

	}

	// User and Extensions page, which are part of core.
	public static function myGuiHooks() {
		return array("core");
	}

	// Which also means we need to catch POST's from those pages.
	public static function myConfigPageInits() {
		return array("extensions", "users");
	}

	// Called when generating the page
	public function doGuiHook(&$cc) {
		if ($_REQUEST['display'] == "extensions" || $_REQUEST['display'] == "users") {
			if (isset($_REQUEST['tech_hardware']) || $_REQUEST['extdisplay']) {
				$this->addOverridesToPage($cc);
			}
		}
		return;
	}

	public function doConfigPageInit($page) {
		$conf = \FreePBX::Config();
		$ramp_conf = $conf->get_conf_settings();
		foreach ($ramp_conf as $key => $value) {
			$amp_conf[$key] = $value['value'];
		}
		$request = $_REQUEST;
		$action = isset($request['action'])?$request['action']:null;
		$extdisplay = isset($request['extdisplay'])?$request['extdisplay']:null;

		if ($page == "extensions" || $page == "users") {
			// Catch the POST.
			if (isset($request['extdisplay'])) {
				if (preg_match('/override=(.+)/', $request['intercom_override'], $match)) {
					$this->setOverride($request['extdisplay'], $match[1]);
				}
			}
		}
		if($page == "paging"){
			$get_vars = array(
				'action'		=> '',
				'announce'		=> '',
				'conflict_url'	=> '',
				'default_group'	=> 0,
				'description'	=> '',
				'display'		=> 'paging',
				'duplex'		=> 0,
				'extdisplay'	=> '',
				'force_page'	=> 0,
				'pagegrp'		=> '',
				'pagelist'		=> '',
				'pagenbr'		=> '',
				'Submit'		=> '',
				'type'			=> 'tool',

			);

			foreach ($get_vars as $k => $v) {
				$vars[$k] = isset($request[$k]) ? $request[$k] : $v;
			}
			$vars['pagenbr'] = trim($vars['pagenbr']);
			if ($vars['Submit'] == _('Delete')) {
				$vars['action'] = 'delete';
				$request['action'] = 'delete';
			}

			//action actions
			switch ($vars['action']) {
				case 'delete':
					paging_del($vars['extdisplay']);
					break;
				case 'submit':
					//TODO: issue, we are deleting and adding at the same time so remeber later to check
					//      if we are deleting a destination
					$usage_arr = array();
					if ($vars['pagegrp'] != $vars['pagenbr']) {
						$usage_arr = framework_check_extension_usage($vars['pagenbr']);
					}
					if ($usage_arr) {
						$vars['conflict_url'] = framework_display_extension_usage_alert($usage_arr);
						break;
					} else {
						//limit saved devices to PAGINGMAXPARTICIPANTS
						if (isset($amp_conf['PAGINGMAXPARTICIPANTS'])
							&& $amp_conf['PAGINGMAXPARTICIPANTS']
						) {
							$vars['pagelist'] = array_slice(
												$vars['pagelist'],
												0,
												$amp_conf['PAGINGMAXPARTICIPANTS']);
						}

						paging_modify(
							$vars['pagegrp'],
							$vars['pagenbr'],
							$vars['pagelist'],
							$vars['force_page'],
							$vars['duplex'],
							$vars['description'],
							$vars['default_group']
						);
						$request['action'] = $vars['action'] = 'modify';
						if ($vars['extdisplay'] == '' || ($vars['pagegrp'] != $vars['pagenbr'])) {
							$request['extdisplay'] = $vars['extdisplay'] = $vars['pagenbr'];
						}
						$_REQUEST['extdisplay'] = $vars['extdisplay'];
						$this->freepbx->View->redirect_standard('extdisplay');
					}
					break;
				case 'save_settings':
					$def = paging_get_autoanswer_defaults(true);
					$doptions = 'b(autoanswer^s^1(${ALERTINFO},${CALLINFO}))';

					if (ctype_digit($vars['announce'])) {
						$r = recordings_get($vars['announce']);
						if ($r) {
							$vars['announce'] = $r['filename'];
						} else {
							$vars['announce'] = 'beep';
						}
						$a = 'A(' . $vars['announce'] . ')'.$doptions;
					} elseif ($vars['announce'] == 'none') {
						$a = "A()$doptions";
					} elseif ($vars['announce'] == 'beep') {
						$a = "A(beep)$doptions";
					}

					paging_set_autoanswer_defaults(array('DOPTIONS' => $a));
					needreload();
					break;
				case 'getJSON':
					header('Content-Type: application/json');
					switch ($request['jdata']) {
						case 'grid':
								$pagelist = paging_list();
    							$rdata = array();
    							foreach($pagelist as $pg){
									$rdata[] = array('description' => $pg['description'],'page_group' => $pg['page_group'],'is_default' => $pg['is_default'] , 'link' => array($pg['description'],$pg['page_group']));
    							}
							echo json_encode($rdata);
							exit();
						break;

						default:
							echo json_encode(array('error' => _("Unknown Request")));
							exit();
						break;
					}
				break;
				default:
					break;
			}
		}
	}

	public function addOverridesToPage(&$cc) {
		$cc->addoptlistitem('intercom_override_options', 'reject', _("Reject"));
		$cc->addoptlistitem('intercom_override_options', 'ring', _("Ring"));
		$cc->addoptlistitem('intercom_override_options', 'force', _("Force"));
		$cc->setoptlistopts('intercom_override_options', 'sort', false);

		$section = _("Paging and Intercom");
		$name = _("Intercom Override");
		$info  = _("When using Intercom to page an extension, if the extension is in use, you have three options.")."<ul>\n";
		$info .= "<li>"._("<strong>Reject</strong><br> Return a BUSY signal to the caller")."</li>\n";
		$info .= "<li>"._("<strong>Ring</strong><br> Treat the page as a normal call, and ring the extension (if Call Waiting is disabled, this will return BUSY")."</li>\n";
		$info .= "<li>"._("<strong>Force</strong><br> Send the headers telling the phone to go into auto answer mode. This may not work, and is dependant on the phone.")."</li>\n";
		$info .= "</ul>";
		$stat = $this->getOverride($_REQUEST['extdisplay']);
		$cc->addguielem($section, new \gui_radio('intercom_override', $cc->getoptlist('intercom_override_options'), $stat, $name, $info));

	}

	public function getOverride($ext = false) {
		if ($ext === false) {
			$or = "reject";
		} else {
			$or = $this->getConfig("intercom-override", $ext);
		}
		if (!$or) {
			return "reject";
		} else {
			return $or;
		}
	}

	private function setOverride($ext = false, $override = "reject") {
		if ($ext === false) {
			throw new \Exception("No Extension given");
		}
		$this->setConfig("intercom-override", $override, $ext);
		$astman = $this->freepbx->astman;
		$astman->database_put('AMPUSER', "$ext/intercom/override", $override);
	}

	public function getActionBar($request) {
		$buttons = array();
		switch($request['display']) {
			case 'paging':
				$buttons = array(
					'delete' => array(
						'name' => 'delete',
						'id' => 'delete',
						'value' => _("Delete")
					),
					'reset' => array(
						'name' => 'reset',
						'id' => 'reset',
						'value' => _("Reset")
					),
					'submit' => array(
						'name' => 'submit',
						'id' => 'submit',
						'value' => _("Submit")
					)
				);
				if(empty($request['extdisplay'])){
					unset($buttons['delete']);
				}
				if($request['view'] != 'form'){
					unset($buttons);
				}
				return $buttons;
			break;
		}
	}
}
