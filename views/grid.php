<?php
$groups = paging_list();
foreach ($groups as $g) {
	$grows .= '<tr><td>'.$g['page_group'].'</td><td>'.$g['description'].'</td><td><a href="?display=paging&view=form&extdisplay='.urlencode($g['page_group']).'"><i class="fa fa-edit"></i></a>&nbsp;<a href="config.php?display=paging&action=delete&extdisplay='.urlencode($g['page_group']).'" class="delAction"><i class="fa fa-trash"></i></a></td><td>'.($g['is_default']?'<i class="fa fa-check"></i>':'').'</td></tr>';
}
?>

<table class="table table-striped">
<thead>
	<tr>
		<th><?php echo _("Page Group")?></th>
		<th><?php echo _("Description")?></th>
		<th><?php echo _("Actions")?></th>
		<th><?php echo _("Default")?></th>
	</tr>	
</thead>
<tbody>
	<?php echo $grows ?>
</tbody>
</table>