<?

require 'include/openidoo/class.openid.php';

if (isset($_GET['openid_mode']) && isset($_GET['openid_identity']) && isset($_GET['openid_assoc_handle']) && isset($_GET['openid_signed']) && isset($_GET['openid_sig']) && ($_GET['openid_mode'] == 'id_res') && ($_GET['openid_identity']) && ($_GET['openid_assoc_handle']) && ($_GET['openid_signed']) && ($_GET['openid_sig'])) {
	$openid = new OpenID_Login;
	$openid->OpenID_Identity($_GET['openid_identity']);

	if ($openid->OpenID_Test_Server()) {
		$openid_validation = $openid->OpenID_Validation();
		if ($openid_validation === true) {
			$obmem=new iMemberUtil();						
			$res=$obmem->memberExist($_GET['openid_identity']);
			if (!$res) {
				// register / sesession and redirect
				$obmem=new iMember();				
				$obmem->fname=$_GET['openid_sreg_fullname'];
				$obmem->openid=$_GET['openid_identity'];
				$obmem->email=$_GET['openid_sreg_email'];
				$obmem->date=date("Y-m-d H:i:s");
				$obmem->priv="u";
				$res =$obmem->Save();
				if (!$res) { 
					// if error show it
					$err = $obmem->ErrorMsg();
					$obsys->showMessage(1,$err);
				} else {
					// set session and redirect
					$obsys->setSession($_GET['openid_sreg_fullname'],$obmem->memid,$_GET['openid_sreg_email']);
					$obsys->showMessage(3,_LC_MEMBER_REGISTERED);
					$obsys->goPageDelay("",1);
				}
			} else {
				$obmem=new iMemberUtil();
				$res=$obmem->loadMember($_GET['openid_identity']);
				$obsys->setSession($res->fname,$res->memid,$res->email);
				// set session and redirect
				$obsys->showMessage(3,_LC_ALREADY_MEMBER);
				$obsys->goPageDelay("",1);
			}
		} else {
?><?=$obsys->showMessage(2,_LC_ERROR_OPENID_INVALID);?><?
		}
	} else {
?><?=$obsys->showMessage(2,_LC_ERROR_OPENID_SERVER);?><?
	}
}


?>