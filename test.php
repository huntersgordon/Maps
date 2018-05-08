<html>
    <title>juulmaps</title>
    <style>
   
    
    
        .button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 40px;
}
    </style>
    
    <img src = "juulmaps.png" style = "height:200px;text-align:center">
    <br>    <br>    <br>    
    
    <body style = "background-color: green;color:white;">
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
if ($boundsnumber > 150){
    echo "too many juuls!<br><a style = 'text-decoration: none; color:white;' href = 'juul'><br><div style = 'cursor:pointer;' class = 'button'>Go Back</div'></a>";
    exit();

    
}
$boundsname = "bounds" . $boundsnumber;
$target_dir = "juulpics/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
 
        $uploadOk = 1;
    } else {
        echo "Try again bro.";
        $uploadOk = 0;
        exit();
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
    exit();
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
   $file_name = "juul".(string)$boundsnumber; // New unique file name
   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "juulpics/{$file_name}.jpg")){
    /*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file. "meow"))*/ 
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        
    } else {
        echo "Sorry, there was an error uploading your file.";
         exit();
    }
}



///////////////

$url = 'http://freegeoip.net/json/'.$ip; // path to your JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$characters = json_decode($data); // decode the JSON feed
$lat =  $characters->latitude;
$lon =  $characters->longitude;
 //new google.maps.LatLng($lat + 0.118652, $lon + 0.181524));
 
 $hunter = file_get_contents("ips");
 $a = 'How are you?';

if (strpos($hunter, $lat . ", " . $lon) !== false) {
    echo 'people have juuled on this ip!'. "\r\n";
    
    echo "<a style = 'text-decoration: none; color:white;' href = 'juul'><br><div style = 'cursor:pointer;' class = 'button'>add juul</div'></a>";
    exit();
}
file_put_contents('ips', "\r\n". $lat . ", " . $lon."\r\n".PHP_EOL , FILE_APPEND | LOCK_EX);



 

$starter = file_get_contents("starterkit");
$starter2 = file_get_contents("starter2");
$essential = " 

             var srcImage = 'juulpics/juul". (string)$boundsnumber.".jpg';
              
               var bounds".(string)$boundsnumber." = new google.maps.LatLngBounds(
              new google.maps.LatLng($lat, $lon),  
              new google.maps.LatLng($lat + 0.007652, $lon + 0.0101524));
              
               overlay = new USGSOverlay(bounds".(string)$boundsnumber.", srcImage, map);
              
              
                ";
                
                //$txt = "user id date";
                file_put_contents('juulpicdata', $essential.PHP_EOL , FILE_APPEND | LOCK_EX);
                $lgi = file_get_contents('juulpicdata');
                
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
        $poop = fopen("juul", "w");
                fwrite($poop,$starter.$lgi. $starter2);
                fclose($poop);
                //increment counter in startercounter
//echo $txt;
//header("Location: finalproduct");
echo "success!<br><a style = 'text-decoration: none; color:white;' href = 'juul'><br><div style = 'cursor:pointer;' class = 'button'>Go Back</div'></a>";


?>
</body>
</html>