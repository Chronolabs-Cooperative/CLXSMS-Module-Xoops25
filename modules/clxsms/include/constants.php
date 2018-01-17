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

	// Plugin Actions Constants
	define('_CLXSMS_PLUGINS_USERNUMBER', 'user.number');
	define('_CLXSMS_PLUGINS_ReceiveDMESSAGE', 'received.message');
	define('_CLXSMS_PLUGINS_ReceiveDNOTICE', 'received.notice');
	define('_CLXSMS_PLUGINS_QUEUEDMESSAGE', 'queued.message');
	define('_CLXSMS_PLUGINS_SENTMESSAGE', 'sent.message');
	
	// SMS Level/Priority Constants
	define('_CLXSMS_REQUIRED', 'required');
	define('_CLXSMS_IMPORTANT', 'important');
	define('_CLXSMS_NORMAL', 'normal');
	define('_CLXSMS_LOW', 'low');
	
	// module definations and behaviours
	$GLOBALS['_CLXSMS_LEVEL_ORDER'] = array(_CLXSMS_REQUIRED, _CLXSMS_IMPORTANT, _CLXSMS_NORMAL, _CLXSMS_LOW);
?>
	