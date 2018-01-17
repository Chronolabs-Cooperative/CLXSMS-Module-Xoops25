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
 * @copyright       Chronolabs Co-Op http://www.chronolabs.com.au/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.com.au>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */	
	include('header.php');
	error_reporting(E_ERROR);
	xoops_cp_header();
	
	$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
	
	xoops_loadLanguage('admin', 'clxsms');
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:'dashboard';
	
	switch($op) {
	case "dashboard":
	default:
		
		loadModuleAdminMenu(0);
		
	    $statistics_handler = xoops_getmodulehandler('statistics', 'clxsms');
	
	 	$indexAdmin = new ModuleAdmin();	
		
	    $parts = array(	'send' => _AM_CLXSMS_SEND, 'receive' => _AM_CLXSMS_ReceiveD, 'delievered'  => _AM_CLXSMS_DELIEVERY, 'queued' => _AM_CLXSMS_QUEUED, 'system' => _AM_CLXSMS_SYSTEM);
	    foreach($parts as $type => $title) {
	    	$indexAdmin->addInfoBox(sprintf(_AM_CLXSMS_STATISTICS, $title));
	    	foreach(array((3600*1)=>_AM_CLXSMS_LASTHOUR, (3600*12)=>_AM_CLXSMS_12HOURS, (3600*24)=>_AM_CLXSMS_24HOURS, (3600*24*7)=>_AM_CLXSMS_WEEK, (3600*24*7*2)=>_AM_CLXSMS_FORTNIGHT, (3600*24*4)=>_AM_CLXSMS_MONTH, (3600*24*4*3)=>_AM_CLXSMS_QUARTER, (3600*24*4*6)=>_AM_CLXSMS_HALFYEAR, (3600*24*4*12)=>_AM_CLXSMS_YEAR) as $seconds => $name) {
	    		$indexAdmin->addInfoBoxLine(sprintf(_AM_CLXSMS_STATISTICS, $title), "<label>".sprintf(_AM_CLXSMS_STATISTICS_FOR, $name).": %s</label>", $statistics_handler->SumCountStatistic($type, time()-$seconds, time()), 'Purple');
	    	}
	    }
	    echo $indexAdmin->renderIndex();	
		
		break;	
	case "about":
		loadModuleAdminMenu(8);
		$paypalitemno='XPAYMENTABOUT100';
		$aboutAdmin = new ModuleAdmin();
		$about = $aboutAdmin->renderabout($paypalitemno, false);
		$donationform = array(	0 => '<form name="donation" id="donation" action="https://web.labs.coop/modules/xpayment/" method="post" onsubmit="return xoopsFormValidate_donation();">',
								1 => '<table class="outer" cellspacing="1" width="100%"><tbody><tr><th colspan="2">'.constant('_AM_CLXSMS_ABOUT_MAKEDONATE').'</th></tr><tr align="left" valign="top"><td class="head"><div class="xoops-form-element-caption-required"><span class="caption-text">Donation Amount</span><span class="caption-marker">*</span></div></td><td class="even"><select size="1" name="item[A][amount]" id="item[A][amount]" title="Donation Amount"><option value="5">5.00 AUD</option><option value="10">10.00 AUD</option><option value="20">20.00 AUD</option><option value="40">40.00 AUD</option><option value="60">60.00 AUD</option><option value="80">80.00 AUD</option><option value="90">90.00 AUD</option><option value="100">100.00 AUD</option><option value="200">200.00 AUD</option></select></td></tr><tr align="left" valign="top"><td class="head"></td><td class="even"><input class="formButton" name="submit" id="submit" value="'._SUBMIT.'" title="'._SUBMIT.'" type="submit"></td></tr></tbody></table>',
								2 => '<input name="op" id="op" value="createinvoice" type="hidden"><input name="plugin" id="plugin" value="donations" type="hidden"><input name="donation" id="donation" value="1" type="hidden"><input name="drawfor" id="drawfor" value="Chronolabs Co-Operative" type="hidden"><input name="drawto" id="drawto" value="%s" type="hidden"><input name="drawto_email" id="drawto_email" value="%s" type="hidden"><input name="key" id="key" value="%s" type="hidden"><input name="currency" id="currency" value="AUD" type="hidden"><input name="weight_unit" id="weight_unit" value="kgs" type="hidden"><input name="item[A][cat]" id="item[A][cat]" value="XDN%s" type="hidden"><input name="item[A][name]" id="item[A][name]" value="Donation for %s" type="hidden"><input name="item[A][quantity]" id="item[A][quantity]" value="1" type="hidden"><input name="item[A][shipping]" id="item[A][shipping]" value="0" type="hidden"><input name="item[A][handling]" id="item[A][handling]" value="0" type="hidden"><input name="item[A][weight]" id="item[A][weight]" value="0" type="hidden"><input name="item[A][tax]" id="item[A][tax]" value="0" type="hidden"><input name="return" id="return" value="http://www.chronolabs.com.au/modules/donations/success.php" type="hidden"><input name="cancel" id="cancel" value="http://www.chronolabs.com.au/modules/donations/success.php" type="hidden"></form>',																'D'=>'',
								3 => '',
								4 => '<!-- Start Form Validation JavaScript //-->
<script type="text/javascript">
<!--//
function xoopsFormValidate_donation() { var myform = window.document.donation; 
var hasSelected = false; var selectBox = myform.item[A][amount];for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected == true && selectBox.options[i].value != \'\') { hasSelected = true; break; } }if (!hasSelected) { window.alert("Please enter Donation Amount"); selectBox.focus(); return false; }return true;
}
//--></script>
<!-- End Form Validation JavaScript //-->');
		$paypalform = array(	0 => '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">',
								1 => '<input name="cmd" value="_s-xclick" type="hidden">',
								2 => '<input name="hosted_button_id" value="%s" type="hidden">',
								3 => '<img alt="" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" height="1" border="0" width="1">',
								4 => '<input src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" border="0" type="image">',
								5 => '</form>');
		for($key=0;$key<=4;$key++) {
			switch ($key) {
				case 2:
					$donationform[$key] =  sprintf($donationform[$key], $GLOBALS['xoopsConfig']['sitename'] . ' - ' . (strlen($GLOBALS['xoopsUser']->getVar('name'))>0?$GLOBALS['xoopsUser']->getVar('name'). ' ['.$GLOBALS['xoopsUser']->getVar('uname').']':$GLOBALS['xoopsUser']->getVar('uname')), $GLOBALS['xoopsUser']->getVar('email'), XOOPS_LICENSE_KEY, strtoupper($GLOBALS['xoopsModule']->getVar('dirname')),  strtoupper($GLOBALS['xoopsModule']->getVar('dirname')). ' '.$GLOBALS['xoopsModule']->getVar('name'));
					break;
			}
		}
		
		$istart = strpos($about, ($paypalform[0]), 1);
		$iend = strpos($about, ($paypalform[5]), $istart+1)+strlen($paypalform[5])-1;
		echo (substr($about, 0, $istart-1));
		echo implode("\n", $donationform);
		echo (substr($about, $iend+1, strlen($about)-$iend-1));
		break;
	}
		
	xoops_cp_footer();
?>