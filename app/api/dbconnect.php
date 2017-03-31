<?php
$servername="localhost";
$username="root";
$password="";

try{
  $con=new PDO("mysql:host=$servername;dbname=redem",$username,$password);
  $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //echo "connection succesfull";

}catch(PDOException $e)
{
  echo "Conncetion failed". $e->getMessage();

}
 ?>
