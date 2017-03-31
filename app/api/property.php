<?php

  $app->post('/api/property',function($request,$response,$args){

    require_once('dbconnect.php');
    $body=$request->getParsedBody();


    if(empty($body))
    {
        //check if all required feilds are provided or not
      $ret["err"]="body cannot be empty";
      echo json_encode($ret);
    }
  elseif (!isset($body["username"]) || !isset($body["city"]) || !isset($body["area"]) || !isset($body["type"]) || !isset($body["bhk"]) || !isset($body["price"]) || !isset($body["desc"]) || !isset($body["address"]) /* || !isset($body["image"])*/) {


      //validation checking
      $ret["err"]="Incomplete information";

      if(!isset($body["username"]))
      {
        $ret["username"]="*provide username";
      }


      if(!isset($body["city"]))
      {
        $ret["city"]="provide city";
      }

      if(!isset($body["area"]))
      {
        $ret["area"]="provide area";
      }

      if(!isset($body["type"]))
      {
        $ret["type"]="provide type";
      }

      if(!isset($body["bhk"]))
      {
        $ret["bhk"]="provide bhk";
      }

      if(!isset($body["price"]))
      {
        $ret["price"]="provide price";
      }

      if(!isset($body["desc"]))
      {
        $ret["desc"]="*Provide desc";
      }

      if(!isset($body["address"]))
      {
        $ret["adr"]="*Provide address";
      }
      /*if(!isset($body["image"]))
      {
        $ret["image"]="provide image";
      }*/

      echo json_encode($ret);

    }
    else {
      $uname=$body["username"];
      $city=$body["city"];
      $area=$body["area"];
      $type=$body["type"];
      $bhk=$body["bhk"];
      $price=$body["price"];
      $desc=$body["desc"];
      $adr=$body["address"];
    //  $image=$body["image"];

      $unameErr=$cityErr=$areaErr=$typeErr=$bhkErr=$priceErr=$imageErr=$descErr=$adrErr="";

      //validation check
      if(empty($uname) || empty($city) || empty($area) || empty($type) || empty($bhk) || empty($price) || empty($desc)  || empty($desc)/* || empty($image)*/ || !preg_match("/^[1-9][0-9]*$/",$price))
      {
        if(empty($uname))
        {
          $unameErr="*username cannot be empty";
        }

        if(empty($city))
        {
          $cityErr="*Select city";
        }

        if(empty($area))
        {
          $areaErr="*Select area";

        }

        if(empty($type))
        {
          $typeErr="*Select type of house";
        }

        if(empty($bhk))
        {
          $bhkErr="*Select bhk";

        }

        if(empty($price))
        {
          $priceErr="*Provide price";
        }
        else if(!preg_match("/^[0-9]+$/",$price))
        {
          $priceErr="*price should be numbers";
        }

        if(empty($desc))
        {
          $descErr="*description cannot be empty";
        }

        if(empty($adr))
        {
          $adrErr="*Address field cannot be empty";
        }

        $ret["suc"]=false;
        $ret["unameErr"]=$unameErr;
        $ret["cityErr"]=$cityErr;
        $ret["areaErr"]=$areaErr;
        $ret["typeErr"]=$typeErr;
        $ret["bhkErr"]=$bhkErr;
        $ret["priceErr"]=$priceErr;
        $ret["descErr"]=$descErr;
          $ret["adrErr"]=$adrErr;
        echo json_encode($ret);

      }
      else
      {
          //entry into database

          $sql="INSERT INTO `property` (`username`, `type`, `bhk`, `area`, `city`, `description`,`address`, `price`) VALUES (:uname, :type, :bhk, :area, :city, :description, :address, :price)";

          $stmt=$con->prepare($sql);
          $stmt->bindValue(':uname',$uname);
          $stmt->bindValue(':type',$type);
          $stmt->bindValue(':bhk',$bhk);
          $stmt->bindValue(':area',$area);
          $stmt->bindValue(':city',$city);
          $stmt->bindValue(':price',$price);
          $stmt->bindValue(':description',$desc);
          $stmt->bindValue(':address',$adr);

          $stmt->execute();

          $ret["suc"]=true;
          echo json_encode($ret);
      }

    }

  });

  $app->get('/api/property/{uname}',function($request,$response,$args){

    $uname=$args['uname'];

    require_once('dbconnect.php');

    $sql="select * from property where username=:username";
    $stmt=$con->prepare($sql);
    $stmt->bindValue(':username',$uname);
    $stmt->execute();

    if($stmt->rowCount()>0)
    {
      $ret["count"]=$stmt->rowCount();
      //echo json_encode($ret);
      while($result=$stmt->fetch(PDO::FETCH_ASSOC))
      {
        $sql2="select name from category where type=:type";
        $stmt2=$con->prepare($sql2);
        $stmt2->bindValue(':type',$result['type']);
        $stmt2->execute();

        $result2=$stmt2->fetch(PDO::FETCH_ASSOC);

        $array=array( 'id'=>$result['id'],
                      'bhk'=>$result['bhk'],
                      'type'=>$result2['name'],
                      'address'=>$result['address'],
                      'description'=>$result['description'],
                      'area'=>$result['area'],
                      'city'=>$result['city'],
                      'price'=>$result['price']);
        $arrayObject= new ArrayObject($array);
        $data[]=$arrayObject;
      }
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
      //  $data['msg']="No records found!";
        echo json_encode($data);
      }


    }
      //echo json_encode("error");
  });

  $app->delete('/api/property/{id}',function($request,$response,$args)
  {
    require_once('dbconnect.php');
    if(!isset($args['id']))
    {
      $ret['err']=true;
    }
    else
    {
      $ret['err']=false;
      $id=$args['id'];

      $sql="delete from property where id=:id";
      $stmt=$con->prepare($sql);
      $stmt->bindValue(':id',$id);
      $stmt->execute();

      if($stmt->rowCount()>0)
      {
        $ret['suc']=true;
        $ret['id']=$id;

      }
      else
      {
        $ret['suc']=false;
        $ret['id']=$id;
      }
    }
    echo json_encode($ret);

  });

 ?>
