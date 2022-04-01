<html>
    <title>submit picture</title>
    <style>

    ul.images {
    margin: 0 auto;
    padding: 0;
    white-space: nowrap;
    width: 1000px;
    height:1000px;
    overflow-x: scroll;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    background-color: white;
  }
  ul.images li {
    display: inline;
    width: 150px;
    height: 150px;
  }


        .button {
    background-color: #00d351; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 40px;
}
    </style>

    <a href = "index.html"><img src = "logo.png" style = "height:100px;text-align:center"></a>


    <body style = "background-color: #4CAF50;color:white; font-family:Lucida Grande;text-align:center;margin:auto;font-size:26px;>
<h1 style = "color:white;text-align: center;text-decoration: none;"><?php


if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


///////////////////


$boundsnumber = intval(file_get_contents("startercounter"));
if ($boundsnumber > 250){
    echo "too many pictures!<br><a style = 'text-decoration: none; color:white;' href = 'index.html'><br><div style = 'cursor:pointer;' class = 'button'>back</div'></a>";
    exit();


}
$saveme = "";
$boundsname = "bounds" . $boundsnumber;
$target_dir = "picture_data/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

$url = 'http://freegeoip.net/json/'.$ip; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$characters = json_decode($data); // decode the JSON feed
$lat =  $characters->latitude;
$lon =  $characters->longitude;
 //new google.maps.LatLng($lat + 0.118652, $lon + 0.181524));

 $hunter = file_get_contents("ips");


//if (strpos($hunter, $lat . ", " . $lon) !== false) {


 $cats = file_get_contents('picture_cache');
     $array = array();

     $x = substr_count ($cats , (string)$lat ) /2;
     $exists = 1;




$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {

        $uploadOk = 1;
    } else {
        echo "<p style = 'text-align:center;'>Try again bro. </p> <br><br><a style = 'text-decoration: none; color:white;' href = 'index.html'><br><div style = 'cursor:pointer;' class = 'button'>back</div'></a>";
        $uploadOk = 0;
        exit();
    }
}
// Check if file already exists
/*
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    exit();
}*/
    if ($x > 9){
         echo "<p>max pics have been hit on " . $_SERVER['REMOTE_ADDR'] . "! (10 max)</p>";
    //$uploadOk = 0;
    $exists = 0;
     }
// Check file size
if ($_FILES["fileToUpload"]["size"] > 2000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
    exit();
}
// Allow certain file formats
/*
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    exit();
}*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Don't use the 'take photo or video' feature on iPhone to upload pics.";
    exit();
// if everything is ok, try to upload file
} else {
   // move_uploaded_file($_FILES["file"]["tmp_name"], "../img/imageDirectory/");
   $file_name = "picture".(string)$boundsnumber; // New unique file name
   $saveme = $filename;

   //bring back here
  if ($exists){
   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "picture_data/{$file_name}.jpg")){

    /*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file. "meow"))*/
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

    } else {
        echo "Sorry, there was an error uploading your file.";
         //exit();
    }}
}



///////////////

    function GetBetween($var1="",$var2="",$pool){
    $temp1 = strpos($pool,$var1)+strlen($var1);
    $result = substr($pool,$temp1,strlen($pool));
    $dd=strpos($result,$var2);
    if($dd == 0){
        $dd = strlen($result);
    }

    return substr($result,0,$dd);
}


     for ($i = 0; $i < $x; ++$i) {


        $array[] = "'". GetBetween("'","'",substr($cats,strpos( $cats ,$lat . ", " . $lon)-140,31)) . "'";

       // $array[] = substr($cats,strpos( $cats ,$lat . ", " . $lon)-135,21);

        $cats = substr($cats,strpos($cats, $lat . ", " . $lon ) + 50);

     }

    //echo "this ip is:" .  $lat . ", " . $lon;

    //output all images found.

    /*
     for ($i = 0; $i < $x; ++$i) {
          echo   $array[$i] . "<br>";
        }*/

    echo $saveme;
    if ($exists){
    if ($x == 0){
        echo "
    <p>Success! " . $x+1 ." picture. (max 10 pics)</p>";
    }
    else{
    echo "
    <p>Success! " . (string)(((int)$x) + 1) ." pics. (max 10 pics)</p>";
    }
    }
    //echo "image is called : " . "'juul".(string)$boundsnumber . ".jpg'";
    //sleep(1);
    echo"<br>



       <ul class='images'>

       ";
       if ($exists == 1){
       echo "<li>  <img style = 'height:1000px; width:900px;' src = 'picture_data/picture".(string)$boundsnumber .".jpg'></li>";}

       for ($i = $x-1; $i >= 0; --$i) {

           echo "<li>  <img style = 'height:1000px; width:900px;' src = ". $array[$i] ."></li>";
       }




echo "</ul>";



   if($exists == 0){

       echo "<a style = 'text-decoration: none; color:white;' href = 'index.html?lati=". $lat ."&longi=". $lon ."&zoom=13'><br><div style = 'cursor:pointer;' class = 'button'>back</div'></a>";
       exit();}
//}



//uploads file
file_put_contents('ips', "\r\n". $lat . ", " . $lon."\r\n".PHP_EOL , FILE_APPEND | LOCK_EX);





$starter = file_get_contents("starterkit");
$starter2 = file_get_contents("starter2");
$essential = "

             var srcImage = 'picture_data/picture". (string)$boundsnumber.".jpg';

               var bounds".(string)$boundsnumber." = new google.maps.LatLngBounds(
              new google.maps.LatLng(0, 0),
              new google.maps.LatLng($lat + 0.007652, $lon + 0.0101524));

               overlay = new USGSOverlay(bounds".(string)$boundsnumber.", srcImage, map);


                ";

                //$txt = "user id date";
                if ($exists){
                file_put_contents('picture_cache', $essential.PHP_EOL , FILE_APPEND | LOCK_EX);}
                $lgi = file_get_contents('picture_cache');

/*$txt = $starter . "

             var srcImage = 'juul". (string)$boundsnumber.".jpg';

               var bounds".(string)$boundsnumber." = new google.maps.LatLngBounds(
              new google.maps.LatLng($lat, $lon),
              new google.maps.LatLng($lat + 0.007652, $lon + 0.0101524));

               overlay = new USGSOverlay(bounds".(string)$boundsnumber.", srcImage, map);


                " . $starter2 ;*/
                $myfile = fopen("startercounter", "w");
                fwrite($myfile, (string)($boundsnumber+1));
                fclose($myfile);
        $opener = fopen("index.html", "w");
                fwrite($opener,$starter.$lgi. $starter2);
                fclose($opener);
                //increment counter in startercounter

//echo $txt;
//header("Location: finalproduct");
echo "<a style = 'text-decoration: none; color:white;' href = 'index.html?lati=". $lat ."&longi=". $lon ."&zoom=13'><br><div style = 'cursor:pointer;' class = 'button'>back</div'></a>";


?>
</body>
</html>
