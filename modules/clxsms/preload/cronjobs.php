<?php

defined('XOOPS_ROOT_PATH') or die('Restricted access');

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

class CLXsmsCronjobsPreload extends XoopsPreloadItem
{
	function eventCoreHeaderCheckcache($args)
    {
		if (getCLXSMSConfig('cron_method')=='preloader' && empty($_POST)) {
			xoops_load('XoopsCache');
			if (!$cache=XoopsCache::read('clxsms_preloader_crons')) {
				if (getCLXSMSConfig('receive_method')!='callback') {
					include dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'crons' . DIRECTORY_SEPARATOR . 'receive.php';
				}
				include dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'crons' . DIRECTORY_SEPARATOR . 'send.php';
				include dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'crons' . DIRECTORY_SEPARATOR . 'maintenance.php';
				XoopsCache::write('clxsms_preloader_crons', array('ran'=>microtime(true)), getCLXSMSConfig('cron_seconds'));
			}
		}    	
    }
    
    
}
?>