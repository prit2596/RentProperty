<?php
$servername="localhost";
$username="root";
$password="";

$cleardb_url=parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server=$cleardb_url["host"];
$cleardb_username=$cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db=substr($cleardb_url["path"],1);

$active_group='default';
$active_record=TRUE;

try{
  $con=new PDO("mysql:host=$cleardb_server;dbname=redem",$cleardb_username,$cleardb_password);
  $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //echo "connection succesfull";

}catch(PDOException $e)
{
  echo "Conncetion failed". $e->getMessage();

}
 ?>
