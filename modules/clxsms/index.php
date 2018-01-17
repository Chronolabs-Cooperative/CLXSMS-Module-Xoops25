<?php
require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'header.php');

if (count($_POST)>0) {
	if (file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dump.txt'))
		unlink(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dump.txt');
	$f = fopen(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'dump.txt', 'w');
	fwrite($f, print_r($_POST, true), strlen(print_r($_POST, true)));
	fclose($f);
}

switch(determineType($_POST)) {
	
	case _CLXSMS_NONE:
	default:

		xoops_loadLanguage('modinfo', 'clxsms');
		$xoopsOption['template_main'] = 'clxsms_index.html';
		include $GLOBALS['xoops']->path('header.php');
		$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/'._MI_CLXSMS_DIRNAME.'/css/style.css');
		$GLOBALS['xoopsTpl']->assign('virtual_number', '+'.getCLXSMSConfig('virtual_number'));
		include $GLOBALS['xoops']->path('footer.php');
		exit(0);
		break;
	
	case _CLXSMS_RECIEPT:

		$delievery_handler = xoops_getmodulehandler('delievery', 'clxsms');
		$sms = $received_handler->create();		
		foreach(array('msgid', 'source', 'destination', 'status', 'errorcode', 'datetime', 'userref') as $variable) 
			$sms->setVar($variable, substr($_POST[strtoupper($variable)], 50, 0));
		if ($delievery_id = $delievery_handler->insert($sms, true)) {
			echo json_encode(array('delievery_id'=>$delievery_id, 'errors' => 0));
		} else {
			echo json_encode(array('delievery_id'=>0, 'errors' => 1));
		}
		exit(0);
		break;
		
	case _CLXSMS_SMS:

		$from = getNumberArray($_POST['SOURCE']);
		$to = getNumberArray($_POST['DESTINATION']);
		
		$content_handler = xoops_getmodulehandler('content', 'clxsms');
		$content = $content_handler->create();
		$content->setVar('content', $_POST['MESSAGE']);
		$content->setVar('method', 'received');
		$content = $content_handler->get($content_handler->insert($content, true));
		
		$received_handler = xoops_getmodulehandler('received', 'clxsms');
		$sms = $received_handler->create();
		$sms->setVar('from_uid', $from['uid']);
		$sms->setVar('from_number_id', $from['number_id']);
		$sms->setVar('to_number_id', $to['number_id']);
		$sms->setVar('sms_content_id', $content->getVar('content_id'));
		$sms->setVar('response_id', 0);
		$sms->setVar('method', 'callback');
		if ($received_id = $received_handler->insert($sms, true)) {
			echo json_encode(array('received_id'=>$received_id, 'errors' => 0));
		} else {
			echo json_encode(array('received_id'=>0, 'errors' => 1));
		}
		exit(0);
		break;
}


?>