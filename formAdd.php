<?php 
  require "database.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Edit Ad</title>
</head>

<body>

<nav class="navbar navbar-expand-lg  bg-light">
  <div class="container">
    <a class="navbar-brand" href="#"><img style="height: 80px;" src="img/logo.png" alt="Logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a href='./index.php' class="btn btn-lg btn-danger mx-2 active" aria-current="page">Home</a>
      </div>
    </div>
  </div>
</nav>


<div class="container bg-secondary my-5" style="width: 50%; border: 2px solid #000; border-radius: 8px; box-shadow: 2px 2px 5px #000;">
        <h1 class="text-center text-light my-5" style="text-shadow:  2px 2px 5px #000;">Add Announcement</h1>
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="form-group">
                <label class="text-light" for="titre">Title</label>
                <input type="text" class="form-control" name="Title" >
            </div>
            <div class="form-group">
                <label class="text-light" for="image">Picture</label>
                <input type="file" class="form-control"  name="imag" >
            </div>
            <div class="form-group">
                <label class="text-light" for="description">Description</label>
                <textarea class="form-control" id="description" name="Description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label class="text-light" for="superficie">Surface</label>
                <input type="number" class="form-control" id="superficie" name="Surface">
</div>
            <div class="form-group">
                    <label class="text-light" for="adresse">Address</label>
                    <input type="text" class="form-control" id="adresse" name="Address" >
            </div>
            <div class="form-group">
                    <label class="text-light" for="montant">Price</label>
                    <input type="number" class="form-control" id="montant" name="Price" >
            </div>
            <div class="form-group">
                    <label class="text-light" for="dateAnnonce">Offer Date</label>
                    <input type="date" class="form-control" id="dateAnnonce" name="offerDate" >
            </div>
            <div class="form-group">
                    <label class="text-light" for="type">Offer Type</label>
                    <select class="form-control" id="type" name="offerType">
                        <option value="Sale">Sale</option>
                        <option value="Rental">Rental</option>
                    </select>
                    
            </div>
            <input type="submit" name="submit" class="btn text-light bg-dark m-4" value="Add"/>
        </form>
</div>

    <?php
    if(isset($_POST['submit']) && isset ($_FILES['imag'])){
        echo "wa walo walo";
        $title = mysqli_real_escape_string($conn ,$_POST['Title']);
        $Description = mysqli_real_escape_string($conn ,$_POST['Description']);
        $surface = mysqli_real_escape_string($conn ,$_POST['Surface']);
        $Address = mysqli_real_escape_string($conn ,$_POST['Address']);
        $Amount = mysqli_real_escape_string($conn ,$_POST['Price']);
        $Ad = mysqli_real_escape_string($conn ,$_POST['offerDate']);
        $Type = mysqli_real_escape_string($conn ,$_POST['offerType']);
    
        $img= $_FILES['imag']['name'];
        echo $img;
        $tmpImage = $_FILES["imag"]['tmp_name'];

        $fileError = $_FILES['imag']['error'];
        echo $fileError;
        $fileType  = $_FILES['imag']['type'];
        $fileExt = explode(".", $img);
        $fileActual = strtolower(end($fileExt));
        $allowedEx = array("jpg", "png", "gif", "jpeg");
        if(in_array($fileActual, $allowedEx)){
            if($fileError===0){
                
                    $newImage = uniqid("IMG-", true).".".$fileActual;
                    $fileDestination = 'img/'.$newImage;
                    move_uploaded_file($tmpImage, $fileDestination);
                    $query = "INSERT INTO annonces(Title,Picture,Description,Surface,Address,Price,offerDate,offerType)
            VALUES('$title','$fileDestination','$Description','$surface','$Address','$Amount','$Ad','$Type')";
            $query_run = mysqli_query($conn,$query);
        if ($query_run){
            header("Location:index.php");
    }
                    
    

            }else{
                echo "there was an error uploading your file!";
            }

        }else{
            echo "you canno't upload files of this type!";
    }

    } else {
        echo "madaz walo";}
    ?>

</body>

</html>