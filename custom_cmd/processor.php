<?php
ob_start();
session_start();
echo $_SESSION['link_adr']; 
echo '<script language="javascript">';
echo 'alert("Upload to cloud successfull! Click OK to continue")';
echo '</script>';
#exec("sudo /usr/local/hadoop/bin/hadoop dfs -mkdir /alpha_omega/web_out 2>&1",$output, $return_var); #makes new folder for o/p
exec("sudo /usr/local/hadoop/bin/hadoop dfs -rmr /alpha_omega/web_out");
exec("sudo /usr/local/hadoop/bin/hadoop jar /usr/local/hadoop/share/hadoop/tools/lib/hadoop-streaming-2.7.3.jar -file /opt/lampp/htdocs/web/alpha_omega/custom_cmd/mapper.py   -mapper 'python /opt/lampp/htdocs/web/alpha_omega/custom_cmd/mapper.py' -file /opt/lampp/htdocs/web/alpha_omega/custom_cmd/reducer.py   -reducer 'python /opt/lampp/htdocs/web/alpha_omega/custom_cmd/reducer.py' -input /alpha_omega/*  -output /alpha_omega/web_out 2>&1",$output, $return_var);
#exec("sudo /usr/local/hadoop/Pig/bin/pig -X 2>&1",$output, $return_var);
#exec("sudo hduser /usr/local/hadoop/Pig/bin/pig -X 2>&1",$output, $return_var);
#exec("su -l hduser -c pig -X 2>&1",$output, $return_var);
$count_=count($output);

for($i=0;$i<$count_;$i++)
echo $output[$i];

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'final.php';
header("Location: http://$host$uri/$extra");
exit;
?>
