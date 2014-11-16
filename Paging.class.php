<?php
// vim: set ai ts=4 sw=4 ft=php:
namespace FreePBX\modules;

class Paging extends \FreePBX_Helpers implements \BMO {

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
		if ($page == "extensions" || $page == "users") {
			// Catch the POST.
			if (isset($_REQUEST['extdisplay'])) {
				if (preg_match('/override=(.+)/', $_REQUEST['intercom_override'], $match)) {
					$this->setOverride($_REQUEST['extdisplay'], $match[1]);
				}
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
			throw new \Exception("No Extension given");
		}
		$or = $this->getConfig("intercom-override", $ext);
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
		$astman = $this->FreePBX->astman;
		$astman->database_put('AMPUSER', "$ext/intercom/override", $override);
	}
}
