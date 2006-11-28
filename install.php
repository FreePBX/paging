<?php

// Enable intercom as a feature code
$fcc = new featurecode('paging', 'intercom-prefix');
$fcc->setDescription('Intercom prefix');
$fcc->setDefault('*80',false);
$fcc->update();
unset($fcc);

// User intercom enable code
$fcc = new featurecode('paging', 'intercom-on');
$fcc->setDescription('User Intercom Allow');
$fcc->setDefault('*54',false);
$fcc->update();
unset($fcc);

// User intercom disable 
$fcc = new featurecode('paging', 'intercom-off');
$fcc->setDescription('User Intercom Disallow');
$fcc->setDefault('*55',false);
$fcc->update();
unset($fcc);	


// version 1.6 upgrade
$sql = "SELECT page_group FROM paging_config";
$check = $db->getRow($sql, DB_FETCHMODE_ASSOC);
if(DB::IsError($check)) {
	// this table wasn't used up to this point, replace it with the new one
	$sql = "DROP TABLE paging_config;";
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		die($result->getDebugInfo());
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS paging_config ( page_group VARCHAR(50), force_page INTEGER(1) NOT NULL);";
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		die($result->getDebugInfo());
	}

	// insert default values
	$sql = "INSERT INTO paging_config  SELECT DISTINCT page_number, 0 FROM paging_groups;";
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		die($result->getDebugInfo());
	}
}
				    

?>
