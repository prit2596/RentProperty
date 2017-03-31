<html>
<head>
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
   <!--<script src="js/login.js"></script>
   <link href="css/main.css" rel="stylesheet" />-->
  <style>
    .box{
      position: absolute;
      width:700px;
      height:400px;
      background-color:#f0f0f0;
      opacity:0.7;
      border:1px solid;
      border-radius: 25px
    }
  </style>
</head>

<script type="text/javascript">

  $(document).ready(function()
  {
    localStorage.removeItem('username');
    localStorage.removeItem('sessionVar');
  });

      function login(uname,password)
      {

        var obj= {uname:uname,pass:password};
        jQuery.ajax(
          {
            url:'../public/api/login',
            type: "post",
            dataType:"json",
            data:obj,
            success:function(data){
              if(data.e==true)
              {
                $('#unameErr').append(data.unameErr);
                $('#passErr').append(data.passErr);
              }
              else {


                  if(data.suc==true)
                  {
                    var sess={sessionVar:data.suc,username:data.uname}
                      localStorage.setItem('username',data.uname);
                      localStorage.setItem('sessionVar',data.suc);
                      window.location="home.php";
                      //console.log($('#myHidden').val());
                  }
                  else{
                      $(".alert").show();
                      $('#myHidden').val('false');
                      }
                    }
            },
            error:function(){
              console.log('error');
            }

          });


      }


</script>


<?php
  include 'functions.php';
  $unameErr=$passErr="";
  $uname=$pass="";
  $log=false;
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    $uname=$_POST["uname"];
    $pass=$_POST["pass"];

    //echo $_POST["mob"]."".$_POST["pass"];
      ?>
        <script>

          login('<?php echo $_POST["uname"]; ?>','<?php echo $_POST["pass"]; ?>');
          console.log(localStorage.getItem('sessionVar'));
          // if(localStorage.getItem('sessionVar'))
          // {
          //   window.location="home.php";
          // }

          //}
        </script>
        <?php
              // $_SESSION["user"] =  "<script type='text/javascript'>document.write(localStorage.getItem('username'));</script>";
              //
              // //echo $_SESSION["user"];
              //
              // if(!($_SESSION["user"]==null))
              // {
              //   header('location:http://localhost/project/client/home.php');
              // }
    }
 ?>


<body background="image/background.jpg">
  <div class="container" style="padding-top:4cm">

      <div class="row">
        <div class="col-md-4 col-md-offset-2">
          <div class="box">
              <h2 style="text-align:center">Login</h2>
              <br /><br />

              <form class="col-md-6 col-md-offset-3" action="#" method="post">
                <div class="form-group">
                  <label for="username">Username:</label>
                  <input type="text" id="uname" name="uname" class="form-control" placeholder="Username" value="<?php echo $uname;?>"/>

                  <p id="unameErr" style="color:red"></p>
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" value="<?php echo $pass;?>"/>

                  <p  id="passErr" style="color:red"></p>
                </div>
                <br />
                <input type="submit" value="Login" class="btn btn-primary col-md-offset-5" /><br/>
            <br />
                <div>
                  <h4 align="center">Not registered?<a href="register.php">Create an Account</a></h4>
                </div>
                <div class="alert alert-danger" hidden>
                    Username/Password incorrect
                </div>
              </form>
          </div>
          <input type="hidden" id="myHidden" value="0">
        </div>
     </div>
  </div>
</body>
</html>
