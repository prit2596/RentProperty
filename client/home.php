



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.js"></script>
     <style>
     </style>
  </head>


  <script type="text/javascript">
  function del(id)
  {

      jQuery.ajax({
        url:'../public/api/property/'+id,
        type:'DELETE',
        dataType:'json',
        success:function(data)
        {
          console.log(data);
          if(data.err==false)
          {
            if(data.suc==true)
            {
              Materialize.toast('Your AD is succesfully deleted',5000,'rounded');
            }
          }
        },
        error:function(error)
        {
          console.log('error');
        }
      });
  }
  </script>



  <?php
    ob_start();
  //  $username="prit2596";

    if(isset($_GET['d']))
    {
      $id=($_GET['d']);
      ?><script>
        del('<?php echo $id;?>');
      </script>
    <?php }
    ?>

  <script type="text/javascript">


      if(localStorage)
      {
        if(!localStorage.getItem('sessionVar'))
        {
          window.location="login.php";
        }
        else {
          uname=localStorage.getItem('username');
        }
      }

      function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

    $(document).ready(function()
  {
    $(".button-collapse").sideNav(
      {
        menuWidth: 300, // Default is 300
      edge: 'right', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true // Choose whether you can drag to open on touch screens
      }
    );
    jQuery.ajax({
      url:'../public/api/user/'+uname,
      type:'get',
      dataType:'json',
      success:function(data)
      {
        if(data.suc==true)
        {
          var obj = data[0];
          //console.log(obj);
          $('#firstname').append(capitalizeFirstLetter(obj.firstname));
          $('#lastname').append(capitalizeFirstLetter(obj.lastname));
          $('#address').append(capitalizeFirstLetter(obj.address));
          $('#city').append(capitalizeFirstLetter(obj.city));
          $('#state').append(capitalizeFirstLetter(obj.state));
          $('#contact').append(capitalizeFirstLetter(obj.contact));
          $('#zipcode').append(capitalizeFirstLetter(obj.zipcode));

        }
      },
      error:function(error)
      {
        console.log(error);
      }
    });

    jQuery.ajax({
      url:'../public/api/property/'+uname,
      type:'get',
      dataType:'json',
      success:function(data)
      {
        console.log(data);
        if(data.suc==true)
        {
          $('#MyProperty').append('<div class="col s12"><h1 align="center">Your Posted AD<h5 align="right"><a class="waves-light btn">'+data.count+' Post</a></h5></h1></div><hr />');
          for(i=0;i<data.count;i++)
          {
            var newObj2=data[i];
            $('#MyProperty').append('<div class="divider"></div><div class="section"><div class="row"><div class="col s5"><h5>Type: '+newObj2.type+'</h5></div><div class="col s5"><h5>BHK: '+newObj2.bhk+'</h5></div><div class="col s8"><h5>Address: '+newObj2.description+'</h5></div><div class="col s5"><h5>City: '+newObj2.city+'</h5></div><div class="col s5"><h5>Area: '+newObj2.area+'</h5></div><div class="col s5"><h5>Price: <i class="fa fa-inr"></i>'+newObj2.price+'</h5></div></div><a href="home.php?d='+newObj2.id+'" class="waves-effect waves-light btn">Delete</a></div>');

          }
        }
      },
      error:function(error)
      {

        console.log(error);
      }
    });

    $('#logout').click(function()
  {
      window.location="login.php";
  });
});


  </script>

  <body>
    <div class="container" style="padding-top:1cm">
      <ul id="dropdown1" class="dropdown-content">
        <li id="logout"><a href="#!">Logout</a></li>

        </ul>
        <nav>
        <div class="nav-wrapper">
            <a href="#" data-activates="nav-mobile" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
          <a href="#!" class="brand-logo">Home</a>
          <ul class="right hide-on-med-and-down" >
            <li><a href="rent.php">Rent</a></li>
            <li><a href="property.php">Post Free Ad</a></li>
            <!-- Dropdown Trigger -->
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Welcome <script>document.write(localStorage.getItem('username'));</script><i class="material-icons right">perm_identity</i><i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
        </div>
        </nav>

        <h1 align="center">Your Profile</h1>
        <hr />
        <br />
        <div class="row">
          <div class="col s6 offset-s1">
            <h5>First Name:&nbsp;&nbsp;&nbsp;<span class="flow-text" id="firstname"></span></h5>
            </div>

        <div class="col s5">
          <h5>Last Name:&nbsp;&nbsp;&nbsp;<span class="flow-text" id="lastname"></span></h5>
        </div>
      </div>
        <div class="row">
            <div class="col s11 offset-s1">
              <h5>Address:&nbsp;&nbsp;&nbsp;<span class="flow-text" id="address"></span></h5>
            </div>
      </div>

      <div class="row">
        <div class="col s6 offset-s1">
          <h5>City:&nbsp;&nbsp;&nbsp;<span class="flow-text" id="city"></span></h5>
          </div>

      <div class="col s5">
        <h5>State:&nbsp;&nbsp;&nbsp;<span class="flow-text" id="state"></span></h5>
      </div>
    </div>

    <div class="row">
      <div class="col s6 offset-s1">
        <h5>Contact:&nbsp;&nbsp;&nbsp;<span class="flow-text" id="contact"></span></h5>
        </div>

    <div class="col s5">
      <h5>zipcode:&nbsp;&nbsp;&nbsp;<span class="flow-text" id="zipcode"></span></h5>
    </div>
  </div>


      <br>
      <br>
      <br>

      <div id="MyProperty" class="col s12">


      </div>

    </div>
  </body>
</html>
