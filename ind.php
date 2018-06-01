<?php

if(!isset($_FILES['fileToUpload'])) {
  echo "
<!DOCTYPE html>
<html>
<body>

<form action='".htmlspecialchars($_SERVER['PHP_SELF'])."' method='post' enctype='multipart/form-data'>
    Select image to upload:
    <input type='file' name='fileToUpload' id='fileToUpload'>
    <input type='submit' value='Upload Image' name='submit'>
</form>

</body>
</html>";
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
//// echo "http://www.rmkec.ac.in/dem/bpa/{$target_file}";

require_once "photoapi.php";

require_once "photoapi.php";
$apidata["dedection"]= json_decode(dedection("http://rmkec.ac.in/dem/bpa/{$target_file}"));
$apidata["face"]=json_decode(face("http://rmkec.ac.in/dem/bpa/{$target_file}"));
$apidata["emotion"]=json_decode(emotion("http://rmkec.ac.in/dem/bpa/{$target_file}"));
print_r(json_encode($apidata));
}
?>