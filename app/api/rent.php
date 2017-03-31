<?php

  $app->post('/api/rent',function($request,$response,$args)
  {

    require_once('dbconnect.php');
    $body=$request->getParsedBody();
    //echo $uname."".$pass;

    $cityErr=$areaErr=$minErr=$maxErr="";

    if(empty($body))
    {
      $ret["err"]="*Body cannot be empty";
    }
    elseif(!isset($body['city']) || !isset($body['area']) || !isset($body['min']) || !isset($body['max']))
        {
            if(!isset($body['city']))
            {
              $cityErr="*Provide city information!";
            }

            if(!isset($body['area']))
            {
              $areaErr="*Provide area information!";

            }

            if(!isset($body['min']))
            {
              $minErr="*Provide minimum budget!";

            }

            if(!isset($body['max']))
            {
              $maxErr="*Provide maximum budget!";
            }
        }
      else
      {
        $city=$body['city'];
        $area=$body['area'];
        $min=$body['min'];
        $max=$body['max'];
      //  $min=(int)$min;
      //  $max=(int)$max;

        if(empty($city) || empty($area) || !isset($min) ||  !isset($max) || !preg_match("/^[0-9]+$/",$min) || !preg_match("/^[0-9]+$/",$max) || $min>$max)
        {
          //echo '1230';
          if(empty($city))
          {
            $cityErr="*City cannot be empty";

          }

          if(empty($area))
          {
            $areaErr="*Area cannot be empty";
          }

          if(!isset($min))
          {
            $minErr="*Minimum budget cannot be empty";
          }
          elseif(!preg_match("/^[0-9]+$/",$min))
          {
            $minErr="*Minimum budget should be in numbers";
          }

          if(!isset($max))
          {
            $maxErr="*Maximum budget cannot be empty";
          }
          elseif(!preg_match("/^[0-9]+$/",$max))
          {
            $maxErr="*Maximum budget should be in numbers";
          }

          if($min>=$max)
          {
            $minErr="*Minimum budget cannot be greater than maximum budget";
          }

          $ret["e"]=true;
          $ret["cityErr"]=$cityErr;
          $ret["areaErr"]=$areaErr;
          $ret["minErr"]=$minErr;
          $ret["maxErr"]=$maxErr;

          echo json_encode($ret);

        }
        else
        {
          $sql="select * from property where city=:city and area=:area and price>= :min and price<=:max";
          $stmt=$con->prepare($sql);
          $stmt->bindValue(':city',$city);
          $stmt->bindValue(':area',$area);
          $stmt->bindValue(':min',$min);
          $stmt->bindValue(':max',$max);
          $stmt->execute();

          if($stmt->rowCount()>0)
          {
            while($result=$stmt->fetch(PDO::FETCH_ASSOC))
            {

              $sql1="select firstname,lastname,contact from users where username=:username";
              $stmt1=$con->prepare($sql1);
              $stmt1->bindValue(':username',$result['username']);
              $stmt1->execute();

              $result1=$stmt1->fetch(PDO::FETCH_ASSOC);


              $sql2="select name from category where type=:type";
              $stmt2=$con->prepare($sql2);
              $stmt2->bindValue(':type',$result['type']);
              $stmt2->execute();

              $result2=$stmt2->fetch(PDO::FETCH_ASSOC);


              $array= array('firstname'=>$result1['firstname'],
                            'lastname'=>$result1['lastname'],
                            'contact'=>$result1['contact'],
                            'type'=> $result2['name'],
                            'bhk'=>$result['bhk'],
                            'description'=>$result['description'],
                            'city'=>$result['city'],
                            'area'=>$result['area'],
                            'price'=>$result['price']);
              $arrayObject= new ArrayObject($array);
              $data[]=$arrayObject;
            }
          }

          $ret['e']=false;
          if(isset($data))
          {
            $count=count($data);
            $data['count']=$count;
            $data['suc']= true;

            echo json_encode($data);
          }
          else {
            $data['suc']=false;
            $data['count']=0;
            $data['msg']="No records found!";
            echo json_encode($data);
          }
        }
    }
  });
?>
