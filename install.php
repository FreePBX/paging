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

?>
