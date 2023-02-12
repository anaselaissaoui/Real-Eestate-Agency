<?php 
 require "database.php";
$AdId = $_GET['id'];
try {
    $query = "SELECT * FROM annonces";
    $query_run = mysqli_query($conn , $query);

    if (mysqli_num_rows($query_run) > 0) {

        foreach ($query_run as $row) {
            if ($row['Id'] == $AdId) {
                $Title = $row['Title'];
                $Picture = $row['Picture'];
                $Description = $row['Description'];
                $Surface = $row['Surface'];
                $Address = $row['Address'];
                $Price = $row['Price'];
                $OfferDate = $row["OfferDate"];
                $OfferType = $row['OfferType'];
            }
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

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
    <div class="container bg-danger" style="width: 50%; border: 2px solid #000; border-radius: 8px; box-shadow: 2px 2px 5px #000;">
        <h1 class="text-center text-light my-5" style="text-shadow:  2px 2px 5px #000;">Formulaire D'édition</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titre">Title</label>
                <input type="text" class="form-control" id="titre" name="Title" value="<?php echo $Title; ?>">
            </div>
            <div class="form-group">
                <label for="image">Picture</label>
                <input type="file" class="form-control" id="image" name="file" value="<?php echo $Picture; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="Description" rows="3"><?php echo $Description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="superficie">Surface</label>
                <input type="text" class="form-control" id="superficie" name="Surface" value="<?php echo $Surface; ?>">
                <div class="form-group">
                    <label for="adresse">Address</label>
                    <input type="text" class="form-control" id="adresse" name="Address" value="<?php echo $Address; ?>">
                </div>
                <div class="form-group">
                    <label for="montant">Price</label>
                    <input type="text" class="form-control" id="montant" name="Price" value="<?php echo $Price; ?> ">
                </div>
                <div class="form-group">
                    <label for="dateAnnonce">offer Date</label>
                    <input type="date" class="form-control" id="dateAnnonce" name="offerDate" value="<?php echo $OfferDate; ?>">
                </div>
                <div class="form-group">
                    <label for="type">Offer Type</label>
                    <select class="form-control" id="type" name="offerType">
                        <option value="<?php echo $OfferType; ?>">Current Offer :<?php echo $OfferType; ?> </option>
                        <option value="Sale">Sale</option>
                        <option value="Rental">Rental</option>
                    </select>
                    <button type="submit" name="submit" class="btn btn-dark-subtle m-4">Modifier</button>
                </div>
            </div>
        </form>

    </div>

    <?php
     require "database.php";

if (isset($_POST['submit'])) {
    $img = mysqli_real_escape_string($conn ,$_FILES['file']['tmp_name']);
    $Title = mysqli_real_escape_string($conn ,$_POST['Title']);
    $Description = mysqli_real_escape_string($conn ,$_POST['Description']);
    $Surface = mysqli_real_escape_string($conn ,$_POST['Surface']);
    $Address = mysqli_real_escape_string($conn ,$_POST['Address']);
    $Price = mysqli_real_escape_string($conn ,$_POST['Price']);
    $offerDate = mysqli_real_escape_string($conn ,$_POST['offerDate']);
    $offerType = mysqli_real_escape_string($conn ,$_POST['offerType']);
    
    
        
    
        #validation of image input
        $filename = $_FILES["file"]["name"];
        $fileExtension = explode('.', $filename);
        $fileExtension = end($fileExtension);
        $allowedExtensions = array('jpg', 'png', 'jpeg');
    
    
    
        #validation of title input
        if(strlen($_POST['Title']) == 0 || strlen($_POST['Title']) > 150){
        echo " <span class='error-message'>Title Length must be more than 0 letters and less than 100 letters</span>";
        }else if(!in_array($fileExtension, $allowedExtensions)){
            echo " <span class='error-message'>Only JPG and PNG and JPEG Extensions are allowed!'</span>";
        }elseif($_POST['Surface'] == 0){
            echo " <span class='error-message'>Surface Cannot be 0m²!</span>";
        }elseif($_POST['Price'] == 0){
            echo " <span class='error-message'>Price cannot be 0dh!</span>";
        } elseif ($_POST['offerDate'] == '') {
            echo " <span class='error-message'>Date cannot be empty!</span>";
        }
        else{
           
            $filename = uniqid('', true). ".$fileExtension";
            $tempname = $_FILES['file']['tmp_name'];
            $folder = "./img/" . $filename;
    
            move_uploaded_file($tempname, $folder);
            $updatedData = "UPDATE annonces SET 
                Title = '$Title',
                Picture = '$folder',
                Description = '$Description',
                Surface = '$Surface',
                Address = '$Address',
                Price = '$Price',
                offerDate = '$offerDate',
                offerType = '$offerType' 
                where id = '$AdId'";
    
            mysqli_query($conn, $updatedData);
            mysqli_close($conn);
            if ($query_run){
                header("Location:index.php");
        }
    
        }
}
    ?>
</body>

</html>