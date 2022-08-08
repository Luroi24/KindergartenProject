<?php 
    $nombre = $_POST['nom'];
    $filename = $_FILES['file']['name'];
    $info = pathinfo($_FILES['file']['name']);
    $ext = $info['extension'];
    $newName = $nombre.'.'.$ext;
    $location = "../img/customerImages/".$newName;
    $uploadOk = 1;
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
            echo $location;
        }else{
            echo 0;
        }
  ?>