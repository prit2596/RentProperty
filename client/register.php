<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
     </style>
  </head>

<script type="text/javascript">

  function register(uname,fname,lname,add,pass,pass2,zip,contact,state,city)
  {
      var obj={username:uname,firstName:fname,lastName:lname,address:add,password:pass,confirmPassword:pass2,zipCode:zip,contact:contact,state:state,city:city};
      jQuery.ajax({
        url:'../public/api/register',
        type:'post',
        data:obj,
        dataType:'json',
        success:function(data)
        {
          if(data.suc==false)
          {
            if(data.unameErr!="")
            {
              $('#unameErr').append(data.unameErr);
            }
            else {


            $('#fnameErr').append(data.fnameErr);
            $('#lnameErr').append(data.lnameErr);
            $('#passErr').append(data.fnameErr);
            $('#pass2Err').append(data.pass2Err);
            $('#addErr').append(data.addErr);
            $('#zipErr').append(data.zipErr);
            $('#contactErr').append(data.contactErr);
            $('#countryErr').append(data.countryErr);
            $('#cityErr').append(data.cityErr);
            console.log(data);
          //  console.log('displaying error');
          }
          }
          else {
            //session_start();
            //$_SESSION["username"]=data.username;
            window.location="http://localhost/project/client/login.php";
          }

        },
        error:function(err)
        {
          console.log(err);
        }
      });
  }

var count = 0;
  $(document).ready(function(){
    $('#country').click(function(){
      //console.log('123');
      jQuery.ajax({
        url:'IndianStates.json',
        type:'get',
        dataType:'json',
        success:function(data)
        {
          console.log('hey');
          if(count == 0){
          for(var key in data)
          {
                var d=data[key];
                //console.log(d);
                $('#country').append('<option class="'+ d +'">'+ d +'</option>');
          }
        }
          count++;
        },
        error:function()
        {
          console.log('error');
        }

      });
    });

    $('#country').change(function(){

      $('#city').empty();

      var stateId=$(this).val();
        if(stateId)
        {
          jQuery.ajax({
            url:'cities.json',
            type:'get',
            dataType:'json',
            success:function(data){
              var arr=[];
                for(var obj in data)
                {
                    var newObj = data[obj];
                    if(newObj.state==stateId)
                    {
                      //console.log(newObj.name);
                      arr.push(newObj.name);
                    }
                }

                arr.sort();
                for(var k in arr)
                {
                  $('#city').append('<option>'+arr[k]+'</option>');
                }
              }
          });
        }
    });

  });
</script>

<?php
$unameErr=$fnameErr=$lnameErr=$passErr=$pass2Err=$addErr=$zipErr=$contactErr=$cityErr=$countryErr="";
$uname=$fname=$lname=$pass=$pass2=$add=$zip=$contact=$city=$country="";
  require_once('functions.php');
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    $uname=test_input($_POST["uname"]);
    $fname=test_input($_POST["fname"]);
    $lname=test_input($_POST["lname"]);
    $pass=test_input($_POST["pass"]);
    $pass2=test_input($_POST["pass2"]);
    $add=test_input($_POST["add"]);
    $zip=test_input($_POST["zip"]);
    $contact=$_POST["contact"];
    $country=isset($_POST["country"])?$_POST["country"]:"";
    $city=isset($_POST["city"])?$_POST["city"]:"";
    ?>

        <script>register('<?php echo $uname;?>','<?php echo $fname;?>','<?php echo $lname;?>','<?php echo $add;?>','<?php echo $pass;?>','<?php echo $pass2;?>','<?php echo $zip;?>','<?php echo $contact;?>','<?php echo $country;?>','<?php echo $city;?>');</script>

      <?php
  }
 ?>

  <body>
    <div class="container" style="padding-top:2cm">
      <div class="col-md-offset-2">
        <h2>Register</h2>
        <hr />

      <br />
      <form class="col-md-6" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post">

      <div class="form-group">
        <label for="Username">Username:</label>
        <input type="text" name="uname" class="form-control" placeholder="Username" value="<?php echo $uname;?>"/>
        <p  id="unameErr" style="color:red"></p>
      </div>
      <br />
      <div class="form-group">
        <label for="fname">First Name:</label>
        <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $fname;?>"/>
        <p  id="fnameErr" style="color:red"></p>
      </div>

      <br />
      <div class="form-group">
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $lname;?>"/>
        <p  id="lnameErr" style="color:red"></p>
      </div>

      <br />
      <div class="form-group">
        <label for="Password">Password:</label>
        <input type="password" name="pass" class="form-control" placeholder="Password" value="<?php echo $pass;?>"/>
        <p  id="passErr" style="color:red"></p>
      </div>

      <br />
      <div class="form-group">
        <label for="ConfirmPassword">Confirm Password:</label>
        <input type="password" name="pass2" class="form-control" placeholder="Confirm Password" value="<?php echo $pass2;?>"/>
        <p  id="pass2Err" style="color:red"></p>
      </div>

      <br />
      <div class="form-group">
        <label for="Address">Address:</label>
        <textarea rows="4" cols="50" name="add" class="form-control" placeholder="Address"><?php echo $add;?></textarea>
        <p  id="addErr" style="color:red"></p>
      </div>

      <br />
      <div class="form-group">
        <label for="Country">State:</label>
        <select name="country" id="country" class="form-control">
        </select>
        <p   id="countryErr" style="color:red"></p>

      </div>

      <br />
      <div class="form-group">
        <label for="city">City:</label>
        <select name="city" id="city" class="form-control" value="<?php echo $city;?>">
        </select>
        <p  id="cityErr" style="color:red"></p>

      </div>


      <br />
      <div class="form-group">
        <label for="ZipCode">Zip Code:</label>
        <input type="number" name="zip" class="form-control" placeholder="Zip Code" value="<?php echo $zip;?>"/>
        <p   id="zipErr" style="color:red"></p>
      </div>



      <br />
      <div class="form-group">
        <label for="Contact">Contact:</label>
        <input type="number" name="contact" class="form-control" placeholder="Contact Info" value="<?php echo $contact;?>"/>
        <p  id="contactErr" style="color:red"></p>
      </div>
      <br />
      <div>

      <input type="submit" class="btn btn-primary btn-block btn-lg" />
    </div>
    <br />
    <br />

    </form>

    </div>
    </div>
  </body>
</html>
