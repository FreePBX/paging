<?php 
extract($request);
if($extdisplay){
	$thisGRP = paging_get_pagingconfig($extdisplay);
	$devices = paging_get_devs($extdisplay);
	extract($thisGRP);
	$pagenbr = $extdisplay;
	$pagegrp = $extdisplay;
	$delURL = '?display=paging&action=delete&extdisplay='.urlencode($extdisplay);
}

$device_list = array();
foreach (core_devices_list() as $d) {
	$device_list[$d[0]] = $d[0] . ' - ' . $d[1];
}
$devhtml ='';
$selected_dev = $notselected_dev = '';
foreach ($device_list as $ext => $name) {
	//Passing true in in_array to make this strict otherwise 1234 matches on 1234 and 01234
	if (in_array((string)$ext, $devices,true)) {
		$selected_dev .= '<span data-ext="' . $ext . '">' . $name .'</span>';
	} else {
		$notselected_dev .= '<span data-ext="' . $ext . '">' . $name .'</span>';
	}
}
$class = ' class="device_list ui-sortable ui-menu ui-widget ui-widget-content ui-corner-all" ';
$devhtml .= '<h4>'._('Selected').'</h4><fieldset id="selected_dev" '.$class.'>'.$selected_dev.'</fieldset>';
$devhtml .= '<h4>'._('Not Selected').'</h4><fieldset id="notselected_dev" '.$class.'>'.$notselected_dev.'</fieldset>';
?>
<form class="fpbx-submit" name="page_opts_form" id="page_opts_form" data-fpbx-delete="<?php echo $delURL?>" method="POST">
<input type="hidden" name="view" value="form"> 
<input type="hidden" name="display" value="paging"> 
<input type="hidden" name="action" value="submit"> 
<input type="hidden" name="pagegrp" value="<?php echo $pagegrp?>"> 

<!--Paging Extension-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="pagenbr"><?php echo _("Paging Extension") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="pagenbr"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="pagenbr" name="pagenbr" value="<?php echo $pagenbr ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="pagenbr-help" class="help-block fpbx-help-block"><?php echo _("The number users will dial to page this group")?></span>
		</div>
	</div>
</div>
<!--END Paging Extension-->
<!--Group Description-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="description"><?php echo _("Group Description") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="description"></i>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" id="description" name="description" value="<?php echo $description?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="description-help" class="help-block fpbx-help-block"><?php echo _("Description")?></span>
		</div>
	</div>
</div>
<!--END Group Description-->
<!--Device List-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="dlwraper"><?php echo _("Device List") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="dlwraper"></i>
					</div>
					<div class="col-md-9">
						<?php echo $devhtml ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="dlwraper-help" class="help-block fpbx-help-block"><?php echo _('Devices to page. Please note, paging calls the '
			. 'actual device (and not the user). Amount of pagable devices is '
			. 'restricted by the advanced setting key PAGINGMAXPARTICIPANTS '
			. 'and is currently set to ') . $amp_conf['PAGINGMAXPARTICIPANTS']?></span>
		</div>
	</div>
</div>
<!--END Device List-->
<!--Busy Extensions-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="force_page"><?php echo _("Busy Extensions") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="force_page"></i>
					</div>
					<div class="col-md-9 radioset">
						<input type="radio" name="force_page" id="force_page_no" value="0" <?php echo ($force_page == "0"?"CHECKED":"") ?>>
						<label for="force_page_no"><?php echo _("Skip");?></label>
						<input type="radio" name="force_page" id="force_page_yes" value="1" <?php echo ($force_page == "1"?"CHECKED":"") ?>>
						<label for="force_page_yes"><?php echo _("Force");?></label>
						<input type="radio" name="force_page" id="force_page_whisper" value="2" <?php echo ($force_page == "2"?"CHECKED":"") ?>>
						<label for="force_page_whisper"><?php echo _("Whisper");?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="force_page-help" class="help-block fpbx-help-block"><?php echo _("<ul>
<li><b>\"Skip\"</b> will not page any busy extension. All other extensions will be paged as normal</li>
<li><b>\"Force\"</b> will not check if the device is in use before paging it. This means conversations can be interrupted by a page (depending on how the device handles it). This is useful for \"emergency\" paging groups.</li>
<li><b>\"Whisper\"</b> will attempt to use the ChanSpy capability on SIP channels, resulting in the page being sent to the device's earpiece \"whispered\" to the user but not heard by the remote party. If ChanSpy is not supported on the device or otherwise fails, no page will get through. It probably does not make too much sense to choose duplex if using Whisper mode.</li>
</ul>")?></span>
		</div>
	</div>
</div>
<!--END Busy Extensions-->
<!--Duplex-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="duplex"><?php echo _("Duplex") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="duplex"></i>
					</div>
					<div class="col-md-9 radioset">
						<input type="radio" name="duplex" id="duplexyes" value="1" <?php echo ($duplex == "1"?"CHECKED":"") ?>>
						<label for="duplexyes"><?php echo _("Yes");?></label>
						<input type="radio" name="duplex" id="duplexno" value="0" <?php echo ($duplex == "1"?"":"CHECKED") ?>>
						<label for="duplexno"><?php echo _("No");?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="duplex-help" class="help-block fpbx-help-block"><?php echo _('Paging is typically one way for announcements only. '
			. 'Checking this will make the paging duplex, allowing all '
			. 'phones in the paging group to be able to talk and be '
			. 'heard by all. This makes it like an "instant conference"')?></span>
		</div>
	</div>
</div>
<!--END Duplex-->
<!--Default Page Group-->
<div class="element-container">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="form-group">
					<div class="col-md-3">
						<label class="control-label" for="default_group"><?php echo _("Default Page Group") ?></label>
						<i class="fa fa-question-circle fpbx-help-icon" data-for="default_group"></i>
					</div>
					<div class="col-md-9 radioset">
						<input type="radio" name="default_group" id="default_groupyes" value="1" <?php echo ($default_group == $pagegrp ?"CHECKED":"") ?>>
						<label for="default_groupyes"><?php echo _("Yes");?></label>
						<input type="radio" name="default_group" id="default_groupno" value="0" <?php echo ($default_group == $pagegrp ?"":"CHECKED") ?>>
						<label for="default_groupno"><?php echo _("No");?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span id="default_group-help" class="help-block fpbx-help-block"><?php echo _('Paging is typically one way for announcements only. '
			. 'Checking this will make the paging duplex, allowing all '
			. 'phones in the paging group to be able to talk and be '
			. 'heard by all. This makes it like an "instant conference"')?></span>
		</div>
	</div>
</div>
<!--END Default Page Group-->
</form>