<?php 
$page_id=0;
$pagetitle ="Login";
include('../header.php'); 
 

if( $_REQUEST['u']!=""){
	$_SESSION['msg']="Your Account is activated now please login and upgrate your account.";
	$db->query("update ".TBL_PREFIX."user set user_status='y' where user_id='".(int)$_REQUEST['u']."'");
	 $general_func->header_redirect($site_name); 
}
 
?>
  