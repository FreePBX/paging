<?
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
//
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }

?>
<div class="container-fluid">
	<h1><?php echo _("Page Group") ?></h1>
	<div class = "display full-border">
		<div class="row">
			<div class="col-sm-9">
				<div class="fpbx-container">
					<div class="display full-border">
						<?php echo load_view(__DIR__.'/form.php', array('request' => $request, 'amp_conf' => $amp_conf ))?>
					</div>
				</div>
			</div>
			<div class="col-sm-3 hidden-xs bootnav <?php echo isset($request['fw_popover'])?'hidden':''?>">
				<div class="list-group">
					<?php echo load_view(__DIR__.'/bootnav.php', array('request' => $request ))?>
				</div>
			</div>
		</div>
	</div>
</div>
