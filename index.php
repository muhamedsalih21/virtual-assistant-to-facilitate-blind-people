<?php

if(!isset($_FILES['fileToUpload'])) {
  echo <<<eoa
<!DOCTYPE html>
<html lang="en">
<head>
  <title>BLind People Assistance Serverside Demo:</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</head>
<body style="background-color: beige;">

<div class="container-fluid" style="background-color: beige;">
  <h1 style="background-color:#4caf4f;">BLIND PEOPLE ASSISTANCE DEMO</h1>
  
  <div class="row">
    <div class="col-sm-12" style="">

    <form action='' method='post' enctype='multipart/form-data' id='form'>
    <div class="form-group">
      <label for="email">SUBMIT FILE HERE:</label>
      <input type="file" name='fileToUpload' class="form-control" id="email" placeholder="Enter email">
    </div>
    <button type="submit" class="btn btn-default submitbtn">Submit & Analyse</button>
  </form>
    </div>
  </div>
  
  <br/>
  <div class="row">
    <div class="col-sm-6" style="background-color:lightgrey;">
    <p><b>EXTRACTED DATA:</b></p>
    <textarea id="responseTextArea" class="UIInput" style="width:100%; height:500px;overflow:scroll"></textarea>
    
    </div>
    <div class="col-sm-6" style="background-color:pink;">
      <p><b>Response</b></p>
      <img src="" alt="Uploaded any thing to analyse" style="height:600px;width:100%;">
      </div>
  </div>
</div>
 </body>
</html>
eoa;


 exit;
}
if(isset($_FILES['fileToUpload'])){
$target_dir = "upload/";
$target_file = $target_dir.str_replace(" ",'_',basename( $_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
       //  "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
// if (file_exists($target_file)) {
//     // echo "Sorry, file already exists.";
//     $uploadOk = 0;
// }
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    // echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    // echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //// echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        // echo "Sorry, there was an error uploading your file.";
    }
}
$src="http://www.rmkec.ac.in/dem/bpa/{$target_file}";

require_once "photoapi.php";
$apidata["dedection"]= json_decode(dedection("http://rmkec.ac.in/dem/bpa/{$target_file}"));
$apidata["face"]=json_decode(face("http://rmkec.ac.in/dem/bpa/{$target_file}"));
$apidata["emotion"]=json_decode(emotion("http://rmkec.ac.in/dem/bpa/{$target_file}"));

echo <<<eoa
<!DOCTYPE html>
<html lang="en">
<head>
  <title>BLind People Assistance Serverside Demo:</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://rmkec.ac.in/dem/bpa/pretty.js"></script>
  <script src="http://rmkec.ac.in/dem/bpa/speak.js"></script>
  <script src="http://rmkec.ac.in/dem/bpa/underscore.js"></script>
  
</head>
<body style="background-color: beige;">

<div class="container-fluid" style="background-color: beige;">
  <h1 style="background-color:#4caf4f;">BLIND PEOPLE ASSISTANCE DEMO</h1>
  
  <div class="row">
    <div class="col-sm-12" style="">

    <form action='' method='post' enctype='multipart/form-data' id='form'>
    <div class="form-group">
      <label for="email">SUBMIT FILE HERE:</label>
      <input type="file" name='fileToUpload' class="form-control" id="email" placeholder="Enter email">
    </div>
    <button type="submit" class="btn btn-default submitbtn">Submit & Analyse</button>
  </form>
    </div>
  </div>
  <button type="button" id="read" class="btn btn-default submitbtn">Speak</button>
  <button type="button" id="read" class="btn btn-default submitbtn" onclick="responsiveVoice.cancel();">Stop</button>
  
  
  <br/>
  <div class="row">
    <div class="col-sm-6" style="background-color:lightgrey;">
    <p><b>EXTRACTED DATA:</b></p>
    <div id="responseTextArea" class="UIInput" style="width:100%; height:500px;overflow:scroll"></div>
    
    </div>
    <div class="col-sm-6" style="background-color:pink;">
      <p><b>Response:</b></p>
      <img src="" alt="Uploaded any thing to analyse" id='edit-save' style="height:450px;width:100%;"><br/>
      </div>
  </div>
</div>
eoa;

$dta["Analysed_Data"]=$apidata;


echo '
<script>
 var edit_save = document.getElementById("edit-save");
    edit_save.src = "'.$src.'";
   try {
   
   var meta='.stripslashes(json_encode($dta)).';


var jsoon=prettyPrint(meta, {
		// Config
		maxArray: 20, // Set max for array display (default: infinity)
		expanded: false, // Expanded view (boolean) (default: true),
		maxDepth: 5 // Max member depth (when displaying objects) (default: 3)
	})
$("#responseTextArea").append(jsoon) ;}
catch(err){
    
    $("#responseTextArea").text("Error occurred!") ;
}

// window.addEventListener("error", function (evt) {
//      $("#responseTextArea").text("Error occurred!") ;   
// });


if(meta["Analysed_Data"]["emotion"].length !=0){
var min = Infinity, max = -Infinity;
let input=meta["Analysed_Data"]["emotion"][0]["scores"];

for( x in input) {
    if( input[x] < min) min = input[x];
    if( input[x] > max) max = input[x];
}


function findKey(obj, value){
    var key;

    _.each(_.keys(obj), function(k){
      var v = obj[k];
      if (v === value){
        key = k;
      }
    });

    return key;
}
var emo="The person\'s  Emotion is"+findKey(input,max);
}

$("#read").on("click",function(){

   // responsiveVoice.speak("", "UK English Male", {volume: 1}); 
 
    responsiveVoice.speak(meta["Analysed_Data"]["dedection"]["description"]["captions"][0]["text"], "UK English Male", {volume: 1});
    
    responsiveVoice.speak("The Dedected object are ", "UK English Male", {volume: 1});
    for(var i=0;i<meta["Analysed_Data"]["dedection"]["description"]["tags"].length;i++)
        responsiveVoice.speak(meta["Analysed_Data"]["dedection"]["description"]["tags"][i], "UK English Male", {volume: 1}); 
        
       
        
    // responsiveVoice.speak("Group status is"+meta["Analysed_Data"]["dedection"][0]["name"], "UK English Male", {volume: 1});
    responsiveVoice.speak(emo, "UK English Male", {volume: 1});
    responsiveVoice.speak("The Gender of person is"+meta["Analysed_Data"]["face"][0]["faceAttributes"]["gender"], "UK English Male", {volume: 1});
    responsiveVoice.speak("The Age of person is"+meta["Analysed_Data"]["face"][0]["faceAttributes"]["age"], "UK English Male", {volume: 1});

    

    
});
</script>
 </body>
</html>';


//print_r(json_encode($dta));
}
?>