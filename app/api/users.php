<?php

/*  $app->get('/api/users',function($request,$response){
    require_once('dbconnect.php');
    $sql="select firstname,lastname,address,city,state,zipcode from users order by firstname";
    $stmt=$con->prepare($sql);
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($result as $row)
    {
      $data[]=$row;
    }

    if(isset($data))
    {
      $response->withHeader('Content-Type','application/json');
      echo json_encode($data);
    }
  });
*/

  $app->get('/api/user/{username}',function($request,$response,$args)
  {
    require_once('dbconnect.php');
    $username=$args['username'];
    $sql="select firstname,lastname,address,city,state,zipcode,contact from users where username=:username";
    $stmt=$con->prepare($sql);
    $stmt->bindValue(':username',$username);
    $stmt->execute();

    if($stmt->rowCount()>0)
    {
      $result=$stmt->fetch(PDO::FETCH_ASSOC);
      $data[]=$result;
    }

    if(isset($data))
    {
      $data["suc"]=true;
      $response->withHeader('Content-Type','application/json');
      echo json_encode($data);
    }
    else
    {
      $data["suc"]=false;
      $data["usernameErr"]="*Username not registered";
      echo json_encode($data);
    }

  });

 ?>
