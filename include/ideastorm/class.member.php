<?php

class iMember extends ADOdb_Active_Record{
	
	var $_table = 'member';

}

class iMemberUtil {

	function memberExist($openid_identity){
		$obmem=new iMember();
		$obmem->Load("openid = ? ",array($openid_identity));
		if (($obmem->memid)>0) {
			$res=true;
		} else {
			$res=false;
		}
		return $res;
	}
	
	function loadMember($openid_identity) {
		$obmem=new iMember();
		$obmem->Load("openid = ? ",array($openid_identity));
		return $obmem;
	}
	
}

?>