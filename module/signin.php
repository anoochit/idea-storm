<?php

/* if session exist goto home */

if (($_SESSION['memid']>0) && ($_SESSION['fullname']!="")) {
	$obsys->showMessage(3,_LC_MEMBER_REGISTERED);
	$obsys->goPageDelay("",1);
} else {

/* Configure the return URL after a request on the server (OPTIONAL) */
$config_return_to = $cfg_url."/signin/openid";
/*
* Configure the trust root URL of your site(OPTIONAL) */
$config_trust_root = '';
/*
*
* You can choose in the following fields for the Required and Optionel Fields (OPTIONAL) :
* nickname / email / fullname / dob / gender / postcode / country / language / timezone
*
* REQUIRED FIELDS (separated by a comma) */
$config_required_fields = 'email,fullname';
/*
* OPTIONAL FIELDS (separated by a comma) */
$config_optional_fields = '';
/*
*/

require 'include/openidoo/class.openid.php';


if (isset($_POST['openid_action']) && isset($_POST['openid_url']) && ($_POST['openid_action'] == 'login') && ($_POST['openid_url'])) {

	$openid = new OpenID_Login;
	$openid->OpenID_Identity($_POST['openid_url']);
	$openid->OpenID_Return_To($config_return_to);
	$openid->OpenID_Trust_Root($config_trust_root);
	$openid->OpenID_Required_Fields($config_required_fields);
	$openid->OpenID_Optional_Fields($config_optional_fields);

	if ($openid->OpenID_Test_Server()) {
		$openid->OpenID_Send_Request();
    	} else {
?><?=$obsys->showMessage(2,_LC_OPENID_SERVER_ERROR); ?><?php
    	}
	
} 

?>
<!-- openid form -->
<div id="openid">
<form  method="post" onSubmit="this.login.disabled=true;">
<input type="hidden" name="openid_action" value="login">
<div>
<input type="text" name="openid_url" class="openid_login" value="">
<input type="submit" name="login" value="<?=_LC_SIGNIN_OPENID;?>"></div>
<div><a href="http://www.myopenid.com/" class="link" target="_blank"><?=_LC_GET_OPENID;?></a></div>
</form>
</div>
<!-- openid form -->	
<?php

} // check session exist 

?>