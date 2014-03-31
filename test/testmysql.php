<?php 
// $link = mysql_connect('hostname','dbuser','dbpassword'); 
// if (!$link) { 
// 	die('Could not connect to MySQL: ' . mysql_error()); 
// } 
// echo 'Connection OK'; mysql_close($link); 

// $serverName = "awshydrogen.c4qvrgf59bbx.us-east-1.rds.amazonaws.com"; //serverName\instanceName

// // Since UID and PWD are not specified in the $connectionInfo array,
// // The connection will be attempted using Windows Authentication.
// $connectionInfo = array( "Database"=>"AWS_Content_TEST");
// $conn = sqlsrv_connect( $serverName, $connectionInfo, "brent", "@rchVisi0n");

// if( $conn ) {
//      echo "Connection established.<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }

$user = "brent";
$pass = "@rchVisi0n";

try {
    $dbh = new PDO('sqlsrv:Server=awshydrogen.c4qvrgf59bbx.us-east-1.rds.amazonaws.com;Database=AWS_Content_TEST', $user, $pass);
    echo "yaaaaay";
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?> 