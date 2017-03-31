<?php
  ob_start();
  $username="prit2596";
  /*if(!isset($_SESSION["user"]))
  {
    echo "hello";
    //echo "<script type='text/javascript'>windows.location='login.php';</script>";
    header('location:http://localhost/project/client/login.php');
  }*/

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Home</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.js"></script>

  </head>

  <script type="text/javascript">

    var count=0;

    function search()
    {
      //console.log($('#city').val());
      //console.log($('#area').val());
      //console.log($('#min').val());
      $('#area').val()==null?"":$('#area').val();
      $('#city').val()==null?"":$('#city').val();
      $('#min').val()==null?"":$('#min').val();
      $('#max').val()==null?"":$('#max').val();
      console.log($('#min').val()==null?"":$('#min').val());
      var obj={city:$('#city').val(),area:$('#area').val(),min:$('#min').val(),max:$('#max').val()};

      jQuery.ajax({
        url:'../public/api/rent',
        type:'post',
        data:obj,
        dataType:'json',
        success:function(data)
        {
          console.log(data);
          if(data.e==true)
          {
            Materialize.toast(data.areaErr,5000,'rounded');
            Materialize.toast(data.cityErr,5000,'rounded');
            Materialize.toast(data.minErr,5000,'rounded');
            Materialize.toast(data.maxErr,5000,'rounded');
          }
          else
          {
            console.log(data.count);
            $('#printing_results').empty();
            $('#printing_results').append('<h3 align="center">'+data.count+" results found</h3><hr />");
            for(i=0;i<data.count;i++)
            {
              var retObj=data[i];
              $('#printing_results').append('<div class="divider"></div><div class="section"><h4>'+retObj.bhk+' bhk '+retObj.type+' &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<i class="fa fa-inr"></i>'+retObj.price+'/MONTH</h4><br /><p><h5><strong>Description:</strong>&nbsp;'+retObj.description+'</h5><br /><h5>Owner:'+retObj.firstname+' '+retObj.lastname+'</h5><br /><h5>Contact:'+retObj.contact+'</h5></p></div>');
            }
          }
        },
        error:function(error)
        {
          console.log(error);
        }

      });
    }

    function abc()
    {
      var l;
      l=document.getElementById('min').value;
      //console.log(l);
      document.getElementById('minVal').innerHTML="Minimum "+l;
    }

    function def()
    {
      var l;
      l=document.getElementById('max').value;
      //console.log(l);
      document.getElementById('maxVal').innerHTML="Maximum "+l;
    }

      $(document).ready(function() {
     $('select').material_select();

     $('#homeBut').on('click',function(){
       console.log('123');
       $('#hideDetails').show();
       $('#but').hide();
      //  $('#areaDiv').show();
       jQuery.ajax({
         url:'dist.json',
         type:'get',
         dataType:'json',
         success:function(data)
         {
           //$('#district').empty();
           console.log('hey');
           if(count==0)
           {
           for(var obj in data)
           {
             var newObj = data[obj];
             //console.log(newObj.city);
             //$('#area').val(newObj.city);
             $('#city').append('<option class="'+newObj.city+'">'+newObj.city+'</option>');

           }
            $('#city').material_select();
         }count++;

         },
         error:function(error)
         {
           console.log(error);
         }
        });


     });

     $('#city').on('change',function()
     {
        $cityId=$(this).val();
        //console.log($cityId);
        $('#area').empty();
        if($cityId)
        {
          jQuery.ajax({
            url:'dist.json',
            type:'get',
            dataType:'json',
            success:function(data)
            {
              for(var obj in data)
              {
                var newObj1=data[obj];
                if(newObj1.city==$cityId)
                {
                  for(var a in newObj1.areas)
                  {
                    $('#area').append('<option class="'+newObj1.areas[a]+'">'+newObj1.areas[a]+'</option>');
                  }
                  $('#area').material_select();
                }
              }
            }
          });
        }
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
          <a href="home.php" class="brand-logo">Home</a>
          <ul class="right hide-on-med-and-down">
            <li><a href="rent.php">Rent</a></li>
            <li><a href="property.php">Post Free Ad</a></li>
            <!-- Dropdown Trigger -->
            <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Welcome prit2596<i class="material-icons right">perm_identity</i><i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
        </div>
        </nav>
        <br />
        <br />

        <div class="row" id="but">
          <div class="">
            <a  id="homeBut" class="waves-effect waves-light btn-large col s5 offset-s3"><i class="material-icons left">store</i>Find Your Home</a>
          </div>
        </div>

        <div class="row">
          <div id="hideDetails" hidden>
              <div class="input-field col s4 offset-s1" id="cityDiv">
                  <select name="city" id="city">
                    <option value="" disabled>Select City</option>

                  </select>
                  <label>City:</label>

                </div>

                <div class="input-field col s4 offset-s2" id="areaDiv">
                    <select name="area" id="area">
                      <option value="" disabled selected>Select Area</option>
                    </select>
                    <label>Area:</label>

                  </div>

              <div class="input-field col s4 offset-s1" id="minDiv" >
                <label for="minimum">Select Minimum Budget:</label>
                <br />
                <p class="range-field">
                  <input type="range" min="0" max="50000" id="min" step="1000" onchange="abc()"/>
                </p>
                <p class="flow-text" id="minVal">

                </p>
              </div>

              <div class="input-field col s4 offset-s2" id="maxDiv" >
                <label for="maximum">Select Maximum Budget:</label>
                <br />
                <p class="range-field">
                  <input type="range" min="0" max="50000" id="max" step="1000" onchange="def()"/>
                </p>
                <p class="flow-text" id="maxVal">

                </p>
              </div>
              <div class="" onclick="search()">
                <a  id="res" class="waves-effect waves-light btn-large col s4 offset-s4">Find Results</a>
              </div>

              <div id="printing_results" class="col s12">

              </div>
          </div>
        </div>

    </div>
  </body>
  </html>
