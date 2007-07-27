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

$sql = "CREATE TABLE IF NOT EXISTS paging_overview 
	( config VARCHAR(50), 
	  detail VARCHAR(25)
	)";
$result = $db->query($sql);
if(DB::IsError($result)) {
	die($result->getDebugInfo());
}

$sql = "CREATE TABLE IF NOT EXISTS paging_groups 
	( page_number VARCHAR(50), 
	  ext VARCHAR(25)
	)";
$result = $db->query($sql);
if(DB::IsError($result)) {
	die($result->getDebugInfo());
}

$sql = "CREATE TABLE IF NOT EXISTS paging_phones 
	( phone_name VARCHAR(50), 
	  priority INT, 
		command VARCHAR(50)
	)";
$result = $db->query($sql);
if(DB::IsError($result)) {
	die($result->getDebugInfo());
}

// version 1.6 upgrade
$sql = "SELECT page_group FROM paging_config";
$check = $db->getRow($sql, DB_FETCHMODE_ASSOC);
if(DB::IsError($check)) {
	// this table wasn't used up to this point, replace it with the new one
	$sql = "DROP TABLE IF EXISTS paging_config;";
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		die($result->getDebugInfo());
	}
	
	$sql = "CREATE TABLE IF NOT EXISTS paging_config 
		( page_group VARCHAR(255), 
	  	force_page INTEGER(1) NOT NULL
		)";
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
// These are the three most common ways of auto answering.
// Set them up for now - this will all change when paging gets modified
// (I don't think this is even being used)
//
$sql = "INSERT INTO paging_phones VALUES ('GXP-2000', 1, 'Set(SIPADDHEADER=\"Call-Info: answer-after=0\")')";
$result = $db->query($sql);
if(DB::IsError($result)) {
	die($result->getDebugInfo());
}
$sql = "INSERT INTO paging_phones VALUES ('Polycom', 1, 'Set(ALERT_INFO=\"Ring Answer\")')";
$result = $db->query($sql);
if(DB::IsError($result)) {
	die($result->getDebugInfo());
}
$sql = "INSERT INTO paging_phones VALUES ('Snom', 1, 'Set(SIP_URI_OPTIONS=\"intercom=true\")')";
$result = $db->query($sql);
if(DB::IsError($result)) {
	die($result->getDebugInfo());
}

// Now mark the version - again, not even sure if this is in use anymore
//
$sql = "INSERT INTO paging_overview VALUES ('version', 1)";
$result = $db->query($sql);
if(DB::IsError($result)) {
	die($result->getDebugInfo());
}

?>
