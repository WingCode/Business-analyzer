<?php
session_start();
$_SESSION['link_adr'] = $_GET['link'];
$link_adr=$_SESSION['link_adr'];
$upload_status=False;

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'processor.php';
#echo $link_adr;

exec("/usr/local/hadoop/bin/hadoop fs -rm /alpha_omega/'{$link_adr}'");
$status_upload=exec("sudo /usr/local/hadoop/bin/hadoop fs -copyFromLocal /opt/lampp/htdocs/web/alpha_omega/wp-content/uploads/'{$link_adr}' /alpha_omega/ 2>&1",$output, $return_var);

if(isset($output[0])==False)
{
	$upload_status=True;
}
if($upload_status==True)
header("Location: http://$host$uri/$extra");
exit;
?>