<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */
$module_handler =& xoops_gethandler('module');
$GLOBALS['clxsmsModule'] =& XoopsModule::getByDirname('clxsms');
$moduleInfo =& $module_handler->get($GLOBALS['clxsmsModule']->getVar('mid'));
$GLOBALS['clxsmsImageAdmin'] = $moduleInfo->getInfo('icons32');

global $adminmenu;
$adminmenu=array();
$adminmenu[0]['title'] = _MI_CLXSMS_ADMENU1;
$adminmenu[0]['icon'] = '../../'.$moduleInfo->getInfo('system_icons32').'/home.png';
$adminmenu[0]['image'] = '../../'.$moduleInfo->getInfo('system_icons32').'/home.png';
$adminmenu[0]['link'] = "admin/index.php?op=dashboard";
$adminmenu[8]['title'] = _MI_CLXSMS_ADMENU2;
$adminmenu[8]['icon'] = '../../'.$moduleInfo->getInfo('system_icons32').'/about.png';
$adminmenu[8]['image'] = '../../'.$moduleInfo->getInfo('system_icons32').'/about.png';
$adminmenu[8]['link'] = "admin/index.php?op=about";

?>