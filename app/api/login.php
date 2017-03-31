<?php
    //login request
    $app->post('/api/login',function($request,$response,$args){
      require_once('dbconnect.php');
      $body=$request->getParsedBody();
      $uname=$body['uname'];
      $pass=$body['pass'];

      //echo $uname."".$pass;

      $unameErr=$passErr="";
      if(empty($uname) || empty($pass))
      {
        //echo '1230';
        if(empty($uname))
        {
          $unameErr="*Username cannot be empty";

        }

        if(empty($pass))
        {
          $passErr="*Password cannot be empty";
        }

        $ret["e"]=true;
        $ret["unameErr"]=$unameErr;
        $ret["passErr"]=$passErr;
        echo json_encode($ret);

      }
      else {

        $ret["e"]=false;

      $sql="select * from users where username=:uname and password=:pass";
      $stmt=$con->prepare($sql);
      $stmt->bindValue(':uname',$uname);
      $stmt->bindValue(':pass',$pass);
      $stmt->execute();

      if($stmt->rowCount()>0)
      {
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $data=$result;

      }
      $response->withHeader('Content-Type','application/json');

      if(isset($data))
      {
        $ret['suc']= true;
        $ret['uname']=$data['username'];
        echo json_encode($ret);
      }
      else {
        $ret['suc']=false;
        echo json_encode($ret);
      }
    }
    });

 ?>
