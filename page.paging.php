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

$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$force_page = isset($_REQUEST['force_page']) ? $_REQUEST['force_page']:0;
$duplex = isset($_REQUEST['duplex']) ? $_REQUEST['duplex']:0;
$default_group = isset($_REQUEST['default_group']) ? $_REQUEST['default_group']:0;
$selection = isset($_REQUEST['selection'])?$_REQUEST['selection']:'';
$pagelist = isset($_REQUEST['pagelist'])?$_REQUEST['pagelist']:'';
$pagenbr = isset($_REQUEST['pagenbr'])?$_REQUEST['pagenbr']:'';
$pagegrp = isset($_REQUEST['pagegrp'])?$_REQUEST['pagegrp']:'';
$description = isset($_REQUEST['description'])?$_REQUEST['description']:'';

?>

</div>
<?php
// Check to make sure that the paging database is propogated and
// up to date.

switch ($action) {
	case "add":
		paging_sidebar($selection, $type, $display);
		paging_show(null, $display, $type);
		break;
	case "delete":
		paging_del($selection);
		redirect_standard();
		break;
	case "modify":
		paging_sidebar($selection, $type, $display);
		paging_show($selection, $display, $type);
		break;
	case "submit":
		//TODO: issue, we are deleting and adding at the same time so remeber later to check
		//      if we are deleting a destination
		$usage_arr = array();
		if (trim($pagegrp) != trim($pagenbr)) {
			$usage_arr = framework_check_extension_usage($pagenbr);
		}
		if (!empty($usage_arr)) {
			$conflict_url = array();
			$conflict_url = framework_display_extension_usage_alert($usage_arr);
			paging_sidebar($selection, $type, $display);
			paging_show($pagegrp, $display, $type, $conflict_url);
		} else {
			paging_modify($pagegrp, $pagenbr, $pagelist, $force_page, $duplex, $description, $default_group);
			redirect_standard();
		}
		break;
	default:
		paging_sidebar($selection, $type, $display);
		paging_text();
}

function paging_text() {

	$fcc = new featurecode('paging', 'intercom-prefix');
	$intercom_code = $fcc->getCodeActive();
	unset($fcc);
	$fcc = new featurecode('paging', 'intercom-on');
	$oncode = $fcc->getCodeActive();
	unset($fcc);
	$fcc = new featurecode('paging', 'intercom-off');
	$offcode = $fcc->getCodeActive();
	unset($fcc);
?>
<p>
<?php 
	echo _("This module is for specific phones that are capable of Paging or Intercom. This section is for configuring group paging, intercom is configured through <strong>Feature Codes</strong>. Intercom must be enabled on a handset before it will allow incoming calls. It is possible to restrict incoming intercom calls to specific extensions only, or to allow intercom calls from all extensions but explicitly deny from specific extensions.<br /><br />This module should work with Aastra, Grandstream, Linksys/Sipura, Mitel, Polycom, SNOM , and possibly other SIP phones (not ATAs). Any phone that is always set to auto-answer should also work (such as the console extension if configured).") 
?><br /><br /><?php
	if ($intercom_code != '') {
		echo sprintf(_("Example usage:<br /><table><tr><td><strong>%snnn</strong>:</td><td>Intercom extension nnn</td></tr><tr><td><strong>%s</strong>:</td><td>Enable all extensions to intercom you (except those explicitly denied)</td></tr><tr><td><strong>%snnn</strong>:</td><td>Explicitly allow extension nnn to intercom you (even if others are disabled)</td></tr><tr><td><strong>%s</strong>:</td><td>Disable all extensions from intercoming you (except those explicitly allowed)</td></tr><tr><td><strong>%snnn</strong>:</td><td>Explicitly deny extension nnn to intercom you (even if generally enabled)</td></tr></table>"),$intercom_code,$oncode,$oncode,$offcode,$offcode);
	} else {
		echo _("Intercom mode is currently disabled, it can be enabled in the Feature Codes Panel.");
	}
?>
</p>
<?php
}

function paging_show($xtn, $display, $type, $conflict_url=array()) {
	if ($xtn) {
		$selected = paging_get_devs($xtn);
		$rows = count($selected)+1;
		if ($rows < 5) 
			$rows = 5;
		if ($rows > 20)
			$rows = 20;
		echo "<a href='".$_SERVER['PHP_SELF']."?type=${type}&amp;display=${display}&amp;action=delete";
		echo "&amp;selection=${xtn}'>"._("Delete Group")." $xtn</a>";
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
	echo "<input type='hidden' name='action' value='submit'>\n";
	echo "<table><tr><td colspan=2><h5>";
	echo ($xtn)?_("Modify Paging Group"):_("Add Paging Group")."</h5></td></tr>\n";  ?>
	<tr>
		<td><a href='#' class='info'><?php echo _("Paging Extension") ?><span><?php echo _("The number users will dial to page this group") ?></span></a></td>
		<td><input size='5' type='text' name='pagenbr' value='<?php echo $xtn ?>'></td>
	</tr>
	<tr>
    <td> <a href="#" class="info"><?php echo _("Group Description:")?>:<span><?php echo _("Provide a descriptive title for this Page Group.")?></span></a></td>
		<td><input size="24" maxlength="24" type="text" name="description" id="description" value="<?php echo htmlspecialchars($description); ?>"></td>
	</tr>
	<tr><td valign='top'><a href='#' class='info'><?php echo _("Device List:")."<span><br>"._("Select Device(s)to page. This is the phone that should be paged. In most installations, this is the same as the Extension. If you are configured to use \"Users & Devices\" this is the acutal Device and not the User.  Use Ctrl key to select multiple..") ?> 
	<br><br></span></a></td>
	<td valign="top"> 
	
	<select multiple="multiple" name="pagelist[]" id="xtnlist" >
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

	<tr><td><label for="force_page"><a href='#' class='info'><?php echo _("Force if busy") ?><span>
	<?php echo _("If selected, will not check if the device is in use before paging it. This means conversations can be interrupted by a page (depending on how the device handles it). This is useful for \"emergency\" paging groups ") ?></span></a></label></td>
	<td><input type='checkbox' name='force_page' id="force_page" value='1' <?php if ($force_page) { echo 'CHECKED'; } ?>></td>

	<tr><td><label for="duplex"><a href='#' class='info'><?php echo _("Duplex") ?><span>
	<?php echo _("Paging is typically one way for annoucements only. Checking this will make the paging duplex, allowing all phones in the paging group to be able to talk and be heard by all. This makes it like an \"instant conference\"") ?></span></a></label></td>
	<td><input type='checkbox' name='duplex' id="duplex" value='1' <?php if ($duplex) { echo 'CHECKED'; } ?>></td>

	<tr><td><label for="default_group"><a href='#' class='info'><?php echo _("Default Page Group") ?><span>
	<?php echo _("Each PBX system can have a single Default Page Group. If specified, extensions can be automatically added (or removed) from this group in the Extensions (or Devices) tab.<br />Making this group the default will uncheck the option from the current default group if specified.") ?></span></a></label></td>
	<td><input type='checkbox' name='default_group' id="default_group" value='1' <?php if ($default_group) { echo 'CHECKED'; } ?>></td>
	
	<tr>
	<td colspan="2"><br><h6><input type="submit" name="Submit" type="button" value="<?php echo _("Submit Changes")?>"></h6></td>
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

function paging_sidebar($selection, $type, $display) {
	echo "<div class='rnav'><ul>\n";
	echo "<li><a id='".($selection==''?'current':'std')."' ";
	echo "href='config.php?type=${type}&amp;display=${display}&amp;action=add'>"._("Add Paging Group")."</a></li>"; 
	//get the list of paging groups
	$presults = paging_list();
	if ($presults) {
		foreach ($presults as $grouparr) {
			$group = $grouparr['page_group'];
			echo "<li><a id=\"".($selection==$group ? 'current':'std');
			echo "\" href=\"config.php?type=${type}&amp;display=";
			echo "${display}&amp;selection=${group}&amp;action=modify\">";
			echo $group." ".((trim($grouparr['description']) != '')?htmlspecialchars($grouparr['description']):_("Page Group"))."</a></li>";
		}
	} 
	echo "</ul></div><div class='content'><h2>"._("Paging and Intercom")."</h2>\n";
}
?>
