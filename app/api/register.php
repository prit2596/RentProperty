<?php

  $app->post('/api/register',function($request,$response,$args){
    require_once('dbconnect.php');
    $uname=$fname=$lname=$pass=$pass2=$add=$zip=$contact=$country=$city="";
    $body=$request->getParsedBody();
    if(empty($body))
    {
      $ret["error"]="body is empty";
      echo json_encode($ret);
    }
     elseif (!isset($body["username"]) || !isset($body["firstName"]) || !isset($body["lastName"]) || !isset($body["password"]) || !isset($body["confirmPassword"]) || !isset($body["address"]) || !isset($body["zipCode"]) || !isset($body["contact"]) || !isset($body["state"]) || !isset($body["city"])) {

        $ret["err"]="*incomplete information";

         if(!isset($body["username"]))
         {
           $ret["username"]="provide username";
         }

         if(!isset($body["firstName"]))
         {
           $ret["firstName"]="provide firstName";
         }

         if(!isset($body["lastName"]))
         {
           $ret["lastName"]="provide lastName";
         }

         if(!isset($body["password"]))
         {
           $ret["password"]="provide password";
         }

         if(!isset($body["confirmPassword"]))
         {
           $ret["confirmPassword"]="provide confirmPassword";
         }

         if(!isset($body["address"]))
         {
           $ret["address"]="provide address";
         }

         if(!isset($body["zipCode"]))
         {
           $ret["zipCode"]="provide zipCode";
         }

         if(!isset($body["contact"]))
         {
           $ret["contact"]="provide contact";
         }

         if(!isset($body["state"]))
         {
           $ret["state"]="provide state";
         }

         if(!isset($body["city"]))
         {
           $ret["city"]="provide city";
         }

         echo json_encode($ret);
    }

    else {


        $uname=$body["username"];
        $fname=$body["firstName"];
        $lname=$body["lastName"];

        $pass=$body["password"];
        $pass2=$body["confirmPassword"];
        $add=$body["address"];
        $zip=$body["zipCode"];
        $contact=$body["contact"];
        $country=$body["state"];
        $city=$body["city"];




        $unameErr=$fnameErr=$lnameErr=$passErr=$pass2Err=$addErr=$zipErr=$cityErr=$countryErr=$contactErr="";

        if(empty($uname) || empty($fname) || empty($lname) || empty($pass) || empty($pass2) || empty($country) || empty($city) || empty($add) || empty($zip) || empty($contact) || !preg_match("/^[a-zA-Z]+$/",$fname) || !preg_match("/^[a-zA-Z]+$/",$lname) || strlen($pass) < 8 || strlen($pass) > 20 || strlen($pass2) > 20 || strlen($pass2) < 8 || strlen($contact)!= 10 || $pass!=$pass2 || !preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/",$pass) || !preg_match("/^[0-9]*$/",$zip))
            {

                if(empty($uname))
                {
                  $unameErr="*Username cannot be empty";
                }

                if(empty($fname))
                {
                  $fnameErr="*First Name cannot be empty";
                }
                else if(!preg_match("/^[a-zA-Z]+$/",$fname))
                {
                  $fnameErr="*First Name should contain only letters";
                }

                if(empty($country))
                {
                  $countryErr="*Select state";
                }

                if(empty($city))
                {
                  $cityErr="*select city";
                }


                if(empty($lname))
                {
                  $lnameErr="*Last Name cannot be empty";
                }
                else if(!preg_match("/^[a-zA-Z]+$/",$lname))
                {
                  $lnameErr="*First Name should contain only letters";
                }

                if(empty($pass))
                {
                  $passErr="*Password cannot be empty";
                }
                else if(strlen($pass) > 20 || strlen($pass) < 8)
                {
                  $passErr="*Password must be 8  to 10 characters long";
                }
                else if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/",$pass))
                {
                  $passErr="*Password must contain atleast 1 number and atleast 1 special characters";
                }

                if(empty($pass2))
                {
                  $pass2Err="*Confirm Password cannot be empty";
                }
                else if(strlen($pass2) > 20 || strlen($pass2) < 8)
                {
                  $pass2Err="*Password must be 8  to 10 characters long";
                }
                elseif ($pass!=$pass2) {
                  $pass2Err="*Password and confirm password must be same";
                }

                if(empty($add))
                {
                  $addErr="*Address cannot be empty";
                }

                if(empty($zip))
                {
                  $zipErr="*Zipcode cannot be empty";
                }
                elseif(!preg_match("/^[0-9]*$/",$zip))
                {
                  $zipErr="*Zipcode must be number";
                }

                if(empty($contact))
                {
                  $contactErr="*Contact Info cannot be empty";
                }
                else if(strlen($contact)!=10)
                {
                  $contactErr="*Contact number must be 10 digits long";
                }

                $response->withStatus(200);
                $ret["suc"]=false;
                $ret["unameErr"]=$unameErr;
                $ret["fnameErr"]=$fnameErr;
                $ret["lnameErr"]=$lnameErr;
                $ret["passErr"]=$passErr;
                $ret["pass2Err"]=$pass2Err;
                $ret["addErr"]=$addErr;
                $ret["zipErr"]=$zipErr;
                $ret["contactErr"]=$contactErr;
                $ret["cityErr"]=$cityErr;
                $ret["countryErr"]=$countryErr;

                echo json_encode($ret);


            }
            else {



                $sql1="select * from users where username=:uname";
                $stmt1=$con->prepare($sql1);
                $stmt1->bindValue(':uname',$uname);
                $stmt1->execute();

                if($stmt1->rowCount() > 0)
                {
                  $ret["suc"]=false;
                  $ret["unameErr"]="*Username must be unique";
                  echo json_encode($ret);
                }
                else {



              //  $salt="sagro-batku";
              //  $encPass=md5($pass,$salt);
                $sql="INSERT INTO `users` (`username`, `firstname`, `lastname`, `password`, `address`, `city`, `state`, `zipcode`, `contact`) VALUES (:uname, :fname, :lname, :pass, :add, :city, :state, :zip, :contact)";

                $stmt=$con->prepare($sql);
                $stmt->bindParam(':uname',$uname);
                $stmt->bindParam(':fname',$fname);
                $stmt->bindParam(':lname',$lname);
                $stmt->bindParam(':pass',$pass);
                $stmt->bindParam(':add',$add);
                $stmt->bindParam(':zip',$zip);
                $stmt->bindParam(':contact',$contact);
                $stmt->bindParam(':city',$city);
                $stmt->bindParam(':state',$country);

                $stmt->execute();

                $ret["suc"]=true;
                $ret["username"]=$uname;
                echo json_encode($ret);

              }
            }
      }
  });

 ?>
