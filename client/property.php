<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Property</title>
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  </head>
  <style>

  .box{
    width: auto;
    height:40px;
    background-color: white;
    opacity:0.7
  }

  </style>

    <script type="text/javascript">

    function postAD(district,area,type,bhk,desc,price)
    {
      var obj={city:district,area:area,type:type,bhk:bhk,desc:desc,price:price,username:"prit2596"};
      jQuery.ajax({
        url:'../public/api/property',
        type:'post',
        dataType:'json',
        data:obj,
        success:function(data)
        {
          console.log(data);
          if(data.suc==false)
          {
            console.log(data.descErr);
            $('#districtErr').append(data.cityErr);
            $('#areaErr').append(data.areaErr);
            $('#descErr').append(data.descErr);
            $('#priceErr').append(data.priceErr);
            $('#typeErr').append(data.typeErr);
            $('#bhkErr').append(data.bhkErr);
            }
            else if(data.suc==true)
            {
              $('#desc').val('');
              $('#type').val('');
              $('#bhk').val('');
              $('#price').val('');


              $('#successMsg').removeAttr('hidden');
              $('#successMsg').append('Your Ad has been posted!Redirecting.....');

              setTimeout(function(){
                $('#successMsg').hide('fadeOut');
              },3000);
              setTimeout(function(){
                window.location = 'home.php';
              },5000);
            }
          }
        });
      }

  var count=0;
  $(document).ready(function(){
    $('#district').click(function(){
      console.log('123');

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
              $('#district').append('<option class="'+ newObj.city +'">'+ newObj.city +'</option>');
          }
        }count++;

        },
        error:function(error)
        {
          console.log(error);
        }

      });
    });


    $('#district').change(function(){

      $('#area').empty();

      var distId=$(this).val();
        if(distId)
        {
          jQuery.ajax({
            url:'dist.json',
            type:'get',
            dataType:'json',
            success:function(data){
              var arr=[];
                for(var obj in data)
                {
                    var newObj = data[obj];
                    if(newObj.city==distId)
                    {
                      //console.log(newObj.name);
                        for(var l in newObj.areas)
                        {
                          arr.push(newObj.areas[l]);
                        }
                    }
                }

                arr.sort();
                for(var k in arr)
                {
                  $('#area').append('<option>'+arr[k]+'</option>');
                }
              }
          });
        }
    });


  });
  </script>

<?php
  $district=$area=$type=$bhk=$desc=$price="";
  $districtErr=$areaErr=$descErr=$priceErr="";
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    $district=isset($_POST["district"])?$_POST["district"]:"";
    $area=isset($_POST["area"])?$_POST["area"]:"";
    $type=$_POST["type"];
    $bhk=$_POST["bhk"];
    $desc=$_POST["desc"];
    $price=$_POST["price"];
    ?>
    <script type="text/javascript">
      postAD('<?php echo $district; ?>','<?php echo $area; ?>','<?php echo $type; ?>','<?php echo $bhk; ?>','<?php echo $desc; ?>','<?php echo $price; ?>')
    </script>
    <?php

  }
 ?>

<!--<body background="image/property.jpg" style="background-size:100% 50%;background-repeat:no-repeat">
-->
<body>

    <div class="container" style="padding-top:4cm">
        <h1 align="center"><label for="ad" class="box">Post your free ad</label></h1>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />

        <form method="post" action="<?php  echo $_SERVER['PHP_SELF'];?>">

          <div class="alert alert-success" id="successMsg" hidden>
          </div>
          <br />
          <div class="form-group col-md-4 col-md-offset-1">

            <label for="District">District:</label>
            <select name="district" id="district" class="form-control">
            </select>
            <p   id="districtErr" style="color:red"></p>

          </div>

          <div class="form-group col-md-4 col-md-offset-1">
            <label for="Area">Area:</label>
            <select name="area" id="area" class="form-control">
            </select>
            <p   id="areaErr" style="color:red"></p>

          </div>

          <br><br />

          <div class="form-group col-md-4 col-md-offset-1">

            <label for="Type">Type:</label>
            <select name="type" id="type" class="form-control">
              <option></option>
              <option value="1">Flat</option>
              <option value="2">Tenament</option>
              <option value="3">Bunglow</option>

            </select>
              <p   id="typeErr" style="color:red"></p>

          </div>

          <div class="form-group col-md-4 col-md-offset-1">
            <label for="Bhk">BHK:</label>
            <select name="bhk" id="bhk" class="form-control">
              <option></option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <p   id="bhkErr" style="color:red"></p>

          </div>


          <br />

          <div class="form-group col-md-9 col-md-offset-1">
            <label for="Description">Description:</label>
            <textarea rows="4" cols="60" id="desc" name="desc" class="form-control" placeholder="Say something about your house...."><?php echo $desc;?></textarea>
            <p  id="descErr" style="color:red"></p>
          </div>
          <br>

          <div class="form-group col-md-3 col-md-offset-4">

            <label for="Price">Price:</label>
            <i class="fa fa-inr"></i>
            <input type="text" name="price" id="price" class="form-control" placeholder="7500" value="<?php echo $price;?>"/>/Month
            <p   id="priceErr" style="color:red"></p>
          </div>

          <div class="form-group col-md-3 col-md-offset-4">
            <input type="submit" class="btn btn-success btn-block" value="Post" />
          </div>
        </form>
    </div>

  </body>
</html>
