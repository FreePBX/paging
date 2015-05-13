<?php
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2015 Sangoma Technologies.
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
$request = $_REQUEST;
$request['view'] = isset($request['view'])?$request['view']:'';
switch ($request['view']) {
	case 'form':
		$content = load_view(__DIR__.'/views/formwrap.php', array('request' => $request, 'amp_conf'=> $amp_conf,));
	break;
	default:
		$content = load_view(__DIR__.'/views/overview.php', array('request' => $request));
	break;
}


echo $content;
