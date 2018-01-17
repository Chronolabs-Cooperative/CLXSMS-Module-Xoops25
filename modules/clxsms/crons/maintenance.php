<?php
/**
 * CLXsms Class to
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Cooperative http://sourceforge.net/projects/chronolabs/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         CLXSMS
 * @since           1.0.2
 * @author          Simon Roberts
 */

require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'mainfile.php';
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

$content_handler = xoops_getmodulehandler('content', 'clxsms');
$received_handler = xoops_getmodulehandler('received', 'clxsms');
$response_handler = xoops_getmodulehandler('response', 'clxsms');
$sent_handler = xoops_getmodulehandler('sent', 'clxsms');

$content_handler->maintenance();
$received_handler->maintenance();
$response_handler->maintenance();
$sent_handler->maintenance();

?>