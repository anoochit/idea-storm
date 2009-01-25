<?php
/*
Copyright (C) 2008 Anoochit Chalothorn <anoochit@redlinesoft.net>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

session_start();

/**
 * load APIs
 */
include_once("config.inc.php");
include_once('include/adodb/adodb.inc.php');
include_once('include/adodb/adodb-pager.inc.php');
require_once('include/adodb/adodb-active-record.inc.php');
include_once('include/adodb/adodb-exceptions.inc.php');

$db = NewADOConnection("mysql://".$cfg_username.":".$cfg_password."@".$cfg_host."/".$cfg_db);
ADOdb_Active_Record::SetDatabaseAdapter($db);
$db->debug=1;

/**
 * load ideastorm ORM
 */
include_once('include/ideastorm/class.category.php');
include_once('include/ideastorm/class.comment.php');
include_once('include/ideastorm/class.member.php');
include_once('include/ideastorm/class.node.php');
include_once('include/ideastorm/class.relation.php');
include_once('include/ideastorm/class.system.php');

/**
 * Initial iSystem
 */
$obsys=new iSystem($cfg_url,$cfg_theme);

/**
 *  Align URI if deploy in sub directory
 */
if (!empty($cfg_subdir)) {
	$_SERVER['REQUEST_URI']=substr($_SERVER['REQUEST_URI'],strlen($cfg_subdir)+1);
}

/**
 *  Create strap value
 */
$strap=split("/",$_SERVER['REQUEST_URI']);
$mod=$strap[1]; // mod
$act=$strap[2]; // command or action
$file=$strap[3]; // files
$item=$strap[4]; // item id

/**
 * load language file
 */
if (file_exists("language/lang-".$cfg_lang.".php")) {
	include_once("language/lang-".$cfg_lang.".php");
} else {
	include_once("language/lang-en.php");
}


/**
 *  load bootstrape
 */
include_once("include/bootstrap.inc.php");


/**
 *  load module
 */
if (($mod!="") AND ($act=="") AND ($file=="") AND ($item=="")) {
	$res=loadmod();
	$template=$res["template"];
	$pagefile=$res["pagefile"];
} else if (($mod!="") AND ($act!="") AND ($file=="") AND ($item=="")) { 
	$res=loadmodact();
	$template=$res["template"];
	$pagefile=$res["pagefile"];	
} else if (($mod!="") AND ($act!="") AND ($file!="")  AND ($item=="")) { 
	$res=loadmodact();
	$template=$res["template"];
	$pagefile=$res["pagefile"];	
} else if (($mod=="") AND ($act=="")  AND ($file=="") AND ($item=="")) {
	// index page
	$template="index";
	$pagefile="home";
}

function loadmod() {
	global $cfg_theme,$mod;
	// find template 
	if (file_exists("theme/".$cfg_theme."/page-".$mod.".tpl")) {
		// assign template file
		$template="page-".$mod;
	} else {
		// cannot fine template file use page default
		$template="page";
	}
	// find pagefile
	if (file_exists("module/".$mod.".php")) {
		// assign page filename
		$pagefile=$mod;		
	} else {
		// assign page filename to page not found
		$pagefile="page-not-found";
	}
	$res=array("template"=>$template,"pagefile"=>$pagefile);
	return $res;
}

function loadmodact() {
	global $cfg_theme,$mod,$act;
	// find template 
	if (file_exists("theme/".$cfg_theme."/page-".$mod."-".$act.".tpl")) {
		// assign template file
		$template="page-".$mod."-".$act;
	} else {
		// cannot fine template file use page default
		$template="page";
	}
	if (preg_match("/openid/",$act)) {
		$act="openid";
	}
	// find pagefile
	if (file_exists("module/".$mod."-".$act.".php")) {
		// assign page filename
		$pagefile=$mod."-".$act;		
	} else {
		// assign page filename to page not found
		$pagefile="page-not-found";
	}
	$res=array("template"=>$template,"pagefile"=>$pagefile);
	return $res;
}


/**
 * load smarty
 */
define ("SMARTY_DIR", "include/smarty/");
require_once (SMARTY_DIR."Smarty.class.php");
$smarty = new Smarty;
$smarty->compile_dir = "cache";
$smarty->template_dir = "theme/".$cfg_theme."/";
$smarty->assign("site_theme", $cfg_theme);


/**
 * set value to template engine
 */
$smarty->assign("site_url", $cfg_url);


/**
 *  set footer value
 * */
ob_start();			
require_once("include/footer.inc.php");
$content = ob_get_contents();
ob_end_clean();
$smarty->assign("site_footer", $content);


/**
 * set body value
 */
ob_start();	
include("module/".$pagefile.".php");
$content = ob_get_contents();
ob_end_clean();
$smarty->assign("site_body", $content);

$smarty->display($template.".tpl");	

?>