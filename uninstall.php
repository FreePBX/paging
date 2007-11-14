<?php

// Enable intercom as a feature code
echo "removing featurecode intercom-prefix..";
$fcc = new featurecode('paging', 'intercom-prefix');
$fcc->delete();
unset($fcc);
echo "done<br>\n";

// User intercom enable code
echo "removing featurecode intercom-on..";
$fcc = new featurecode('paging', 'intercom-on');
$fcc->delete();
unset($fcc);
echo "done<br>\n";

// User intercom disable 
echo "removing featurecode intercom-off..";
$fcc = new featurecode('paging', 'intercom-off');
$fcc->delete();
unset($fcc);	
echo "done<br>\n";

echo "dropping table paging_overview..";
$sql = "DROP TABLE IF EXISTS paging_overview";
$result = $db->query($sql);
if(DB::IsError($result)) {
	echo "ERROR DELETING TABLE: ".$result->getDebugInfo();
}
echo "done<br>\n";

echo "dropping table paging_groups..";
$sql = "DROP TABLE IF EXISTS paging_groups";
$result = $db->query($sql);
if(DB::IsError($result)) {
	echo "ERROR DELETING TABLE: ".$result->getDebugInfo();
}
echo "done<br>\n";

echo "dropping table paging_phones..";
$sql = "DROP TABLE IF EXISTS paging_phones";
$result = $db->query($sql);
if(DB::IsError($result)) {
	echo "ERROR DELETING TABLE: ".$result->getDebugInfo();
}
echo "done<br>\n";

echo "dropping table paging_config..";
$sql = "DROP TABLE IF EXISTS paging_config";
$result = $db->query($sql);
if(DB::IsError($result)) {
	echo "ERROR DELETING TABLE: ".$result->getDebugInfo();
}
echo "done<br>\n";

echo "dropping table paging_autoanswer..";
$sql = "DROP TABLE IF EXISTS paging_autoanswer";
$result = $db->query($sql);
if(DB::IsError($result)) {
	echo "ERROR DELETING TABLE: ".$result->getDebugInfo();
}
echo "done<br>\n";

?>
