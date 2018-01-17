<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 xoops.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //


$modversion['name']		    	= _MI_CLXSMS_NAME;
$modversion['version']			= _MI_CLXSMS_VERSION;
$modversion['releasedate'] 		= _MI_CLXSMS_RELEASDATE;
$modversion['status'] 			= _MI_CLXSMS_STATUS;
$modversion['author'] 			= _MI_CLXSMS_AUTHOR;
$modversion['credits'] 			= _MI_CLXSMS_CREDITS;
$modversion['teammembers'] 		= _MI_CLXSMS_TEAMMEMBERS;
$modversion['license'] 			= _MI_CLXSMS_LICENSE;
$modversion['official'] 		= _MI_CLXSMS_OFFICIAL;
$modversion['description']		= _MI_CLXSMS_DESCRIPTION;
$modversion['help']		    	= _MI_CLXSMS_HELP;
$modversion['image']			= _MI_CLXSMS_IMAGE;
$modversion['dirname']			= _MI_CLXSMS_DIRNAME;
$modversion['website'] 			= _MI_CLXSMS_WEBSITE;

$modversion['system_dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['system_icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['system_icons32'] = 'Frameworks/moduleclasses/icons/32';

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'modules/'.$modversion['dirname'].'/images/icons/16';
$modversion['icons32'] = 'modules/'.$modversion['dirname'].'/images/icons/32';


$modversion['release_info'] = "Development 2018/01/17";
$modversion['release_file'] = XOOPS_URL.'/modules/'.$modversion['dirname'].'/docs/changelog.txt';
$modversion['release_date'] = "2014/05/11";

$modversion['author_realname'] = "Simon Roberts";
$modversion['author_website_url'] = "https://chrono.labs.coop";
$modversion['author_website_name'] = "Chronolabs Cooperative";
$modversion['author_email'] = "simon@snails.email";
$modversion['demo_site_url'] = "";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "https://sourceforge.net/p/chronolabs/";
$modversion['support_site_name'] = "Chronolabs Sourceforge";
$modversion['submit_bug'] = "https://sourceforge.net/p/chronolabs/tickets/?source=navbar";
$modversion['submit_feature'] = "https://sourceforge.net/p/chronolabs/discussion/";
$modversion['usenet_group'] = "sci.chronolabs";
$modversion['maillist_announcements'] = "";
$modversion['maillist_bugs'] = "";
$modversion['maillist_features'] = "";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$i=-1;
$modversion['tables'][++$i]	= 'clxsms_content';
$modversion['tables'][++$i]	= 'clxsms_delievery';
$modversion['tables'][++$i]	= 'clxsms_numbers';
$modversion['tables'][++$i]	= 'clxsms_received';
$modversion['tables'][++$i]	= 'clxsms_responses';
$modversion['tables'][++$i]	= 'clxsms_sent';
$modversion['tables'][++$i]	= 'clxsms_statistics';

// Admin things
$modversion['hasAdmin']		= 1;
$modversion['adminindex']	= "admin/index.php";
$modversion['adminmenu']	= "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

// Smarty
$modversion['use_smarty'] = 0;

// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'clxsms_index.html';
$modversion['templates'][$i]['description'] = 'CLX SMS homepage index';

$i=0;
$i++;
$modversion['config'][$i]['name'] = 'username';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_USERNAME';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_USERNAME_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'password';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_PASSWORD';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_PASSWORD_DESC';
$modversion['config'][$i]['formtype'] = 'password';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'sms_node_one';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_SMS_NODE_ONE_URL';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_SMS_NODE_ONE_URL_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'http://sms1.cardboardclx.com:9001/HTTPSMS';

$i++;
$modversion['config'][$i]['name'] = 'sms_node_two';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_SMS_NODE_TWO_URL';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_SMS_NODE_TWO_URL_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'http://sms2.cardboardclx.com:9001/HTTPSMS';

$i++;
$modversion['config'][$i]['name'] = 'sms_node_three';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_SMS_NODE_THREE_URL';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_SMS_NODE_THREE_URL_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'http://sms3.cardboardclx.com:9001/HTTPSMS';

$i++;
$modversion['config'][$i]['name'] = 'sms_node_recommended';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_SMS_NODE_RECOMMENDED';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_SMS_NODE_RECOMMENDED_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'two';
$modversion['config'][$i]['options'] = array(_MI_CLXSMS_SMS_NODE_ONE=>'one', _MI_CLXSMS_SMS_NODE_TWO=>'two', _MI_CLXSMS_SMS_NODE_THREE=>'three');

$i++;
$modversion['config'][$i]['name'] = 'max_sms_per_day';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_MAXIMUM_SMS_PER_DAY';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_MAXIMUM_SMS_PER_DAY_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 250;

$i++;
$modversion['config'][$i]['name'] = 'max_sms_per_month';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_MAXIMUM_SMS_PER_MONTH';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_MAXIMUM_SMS_PER_MONTH';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = $modversion['config'][$i-1]['default'] * 31;

$i++;
$modversion['config'][$i]['name'] = 'virtual_number';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_VIRTUAL_NUMBER';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_VIRTUAL_NUMBER_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = (defined('XOOPS_SITE_NUMBER')?XOOPS_SITE_NUMBER:44);

$i++;
$modversion['config'][$i]['name'] = 'retry_seconds';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_RETRY_SECONDS';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_RETRY_SECONDS_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(45,89)*mt_rand(9,25);

$i++;
$modversion['config'][$i]['name'] = 'receive_method';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_RECIEVE_METHOD';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_RECIEVE_METHOD_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'callback';
$modversion['config'][$i]['options'] = array(_MI_CLXSMS_RECIEVE_METHOD_CALLBACK=>'callback', _MI_CLXSMS_RECIEVE_METHOD_POLL=>'poll');

$i++;
$modversion['config'][$i]['name'] = 'polling_seconds';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_POLLING_SECONDS';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_POLLING_SECONDS_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*15;

$i++;
$modversion['config'][$i]['name'] = 'api_method';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_API_METHOD';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_API_METHOD_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'curl';
$modversion['config'][$i]['options'] = array(_MI_CLXSMS_API_METHOD_FURL=>'furl', _MI_CLXSMS_API_METHOD_CURL=>'curl');
											
$i++;
$modversion['config'][$i]['name'] = 'cron_method';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_CRON_METHOD';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_CRON_METHOD_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'system';
$modversion['config'][$i]['options'] = array(_MI_CLXSMS_CRON_METHOD_PRELOADER=>'preloader', _MI_CLXSMS_CRON_METHOD_SYSTEM=>'system');

$i++;
$modversion['config'][$i]['name'] = 'cron_seconds';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_CRON_SECONDS';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_CRON_SECONDS_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*mt_rand(5,21);

$i++;
$modversion['config'][$i]['name'] = 'sms_levels_anyway';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_SMS_LEVELS_ANYWAY';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_SMS_LEVELS_ANYWAY_DESC';
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array('required');
$modversion['config'][$i]['options'] = array(_MI_CLXSMS_SMS_LEVELS_REQUIRED=>'required', _MI_CLXSMS_SMS_LEVELS_IMPORTANT=>'important', _MI_CLXSMS_SMS_LEVELS_NORMAL=>'normal', _MI_CLXSMS_SMS_LEVELS_LOW=>'low');

$i++;
$modversion['config'][$i]['name'] = 'no_credit_notify';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_NO_CREDIT_NOTIFY';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_NO_CREDIT_NOTIFY_DESC';
$modversion['config'][$i]['formtype'] = 'group_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array(XOOPS_GROUP_ADMIN=>XOOPS_GROUP_ADMIN);

$i++;
$modversion['config'][$i]['name'] = 'responses_deleted';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_RESPONSES_DELETED';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_RESPONSES_DELETED_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*mt_rand(15,60)*24*7;

$i++;
$modversion['config'][$i]['name'] = 'sms_deleted';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_SMS_DELETED';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_SMS_DELETED_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*7*mt_rand(4,12);

$i++;
$modversion['config'][$i]['name'] = 'curl_connecttimeout';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_CURL_CONNECT_TIMEOUT';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_CURL_CONNECT_TIMEOUT_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(25,45);

$i++;
$modversion['config'][$i]['name'] = 'curl_timeout';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_CURL_TIMEOUT';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_CURL_TIMEOUT_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(25,45);

$i++;
$modversion['config'][$i]['name'] = 'curl_user_agent';
$modversion['config'][$i]['title'] = '_MI_CLXSMS_CURL_USER_AGENT';
$modversion['config'][$i]['description'] = '_MI_CLXSMS_CURL_USER_AGENT_DESC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'string';
$modversion['config'][$i]['default'] = 'Cardboardclx XOOPS Module ' . _MI_CLXSMS_VERSION . '/PHP ' . PHP_VERSION;
?>
