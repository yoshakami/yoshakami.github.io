<html>
  <head>
</head>
<body>
  
<?php
//$target_file = "../uploaded/" . basename($_FILES["fileToUpload"]["name"]);
print_r($_POST);
//print_r($target_file);
print_r($_FILES);
if(isset($_POST["submit"]))
{
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }

}
?>
</body>