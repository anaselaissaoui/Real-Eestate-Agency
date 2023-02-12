<?php
$conn = new PDO("mysql:host=localhost;dbname=annonces;port=3306;charset=UTF8", 'root', '');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = $conn->query("DELETE FROM `annonces` WHERE `Id`='$id'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css" type="text/css">
    <title>HomeSeek</title>
    <script>
        function confirmDeleting(id) {
            let html = "";
            var adsList = document.getElementById("cardsaffiche");
            html += "<div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>" +
                "<div class='modal-dialog'> <div class='modal-content'> <div class='modal-header'>" +
                " <h2 class='modal-title fs-5' id='exampleModalLabel'>Assurance de décision</h2>" + "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Clos'></button></div>" +
                " <div class='modal-body'>êtes-vous sûr de vouloir supprimer celui-ci? </div>" +
                "<div class='modal-footer'>" + " <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>" +
                " <button type='button' class='btn btn-primary' id='confirmDeleteBtn'>Supprimer</button>" +
                "</div></div></div></div>";

            adsList.insertAdjacentHTML("afterbegin", html);

            document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
                window.location = "index.php?id=" + id;
            });

        }
    </script>
</head>

<body class="bg-white">

    <nav class="navbar navbar-expand-lg  bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img style="height: 80px;" src="img/logo.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a href='./formAdd.php' class="btn btn-lg btn-danger mx-2 active" aria-current="page" href="form.php">Add announcements</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container d-flex justify-content-center border border-secondary p-3 mb-5">
        <form action="" method="post"  class="justify-content-center d-flex " enctype="multipart/form-data">
            <div class="form-group justify-content-center align-middle gap-5  d-flex">
                <div class="input-group mx-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="minPrice" id="floatingInputGroup1" placeholder="Min Price">
                        <label for="floatingInputGroup1">$-Min Price</label>
                    </div>
                </div>
                <span class="m-auto fw-bold text-secondary p-2 ">-</span>
                <div class="input-group mx-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="maxPrice" id="floatingInputGroup2" placeholder="Max Price">
                        <label for="floatingInputGroup2">$-Max Price</label>
                    </div>
                </div>
                <span class="m-auto fw-bold text-secondary p-2  ">Or/And</span>
            </div>
            
            <div class="checkbox-wrapper-24 d-flex mx-5 justify-content-around">
                    <input type="checkbox" id="sale" name="check" value="Sale" />
                    <label for="sale">
                        <span></span>Sale
                    </label>
                    <input type="checkbox"  id="rental" name="check" value="Rental" />
                    <label for="rental">
                        <span></span>Rental
                    </label>
                </div>
            <input type="submit" value="Filter" name="Submit" class="btn btn-danger w-25" style="height:50px;">
    </div>
    </div>

    <div class="container" id="test">
        <div class="row justify-content-center mt-2" id="cardsaffiche"></div>


    </div>
    </form>
    </div>

    <?php
    if (isset($_POST['Submit'])) {
        if (isset($_POST['minPrice']) && isset($_POST['maxPrice'])) {
            $minValue = $_POST['minPrice'];
            $maxValue = $_POST['maxPrice'];

            try {
                $conn = new PDO("mysql:host=localhost;dbname=annonces;port=3306;charset=UTF8", 'root', '');
                // set the PDO error mode to exception
                $content = $conn->prepare("SELECT * FROM `annonces` WHERE  `Price` >=:minValue AND`Price` <=:maxValue ");
                $content->bindParam(':minValue', $minValue);
                $content->bindParam(':maxValue', $maxValue);


                $content->execute();

                echo "<div class='container'>";
                echo "<div class='row  '>";
                while ($row = $content->fetch()) {
                    echo "
                    <div class='card bg-light  col-lg-3  col-md-4  col-sm-6  mb-3'>
                    <img src=" . $row['Picture'] . " class='card-img-top' style='height:25%;'>
                    <div class='card-body '>
                    <h2 class='card-title mt-3 text-danger'>" . $row['Title'] . " " . $row['Surface'] . "m²</h2>
                    <h3 class='mt-2 ' >" . $row['OfferType'] . "</h3>
                    <h5>" . $row['Address'] . "</h5>
                    <p class='card-text '>" . $row['Description'] . "</p>
                    <h3 class='text-success'>Price : " . $row['Price'] . "DH </h3>  
                    <div class='d-flex justify-content-around'>
                    <a href='formEdit.php?id=" . $row['Id'] . "' class='btn btn-lg btn-danger px-4'>Edit</a>
                    <a onclick='confirmDeleting(" . $row['Id'] . ")' data-bs-toggle='modal' data-bs-target='#exampleModal' class='btn btn-lg btn-danger px-4'>Delete</a>
                    </div> 
                    <h6 class='text-secondary d-flex justify-content-end mt-3'>" . $row['OfferDate'] . "</h6>
                    </div>
                    </div>";
                }
                echo "</div> </div>";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {

        $conn = new PDO("mysql:host=localhost;dbname=annonces;port=3306;charset=UTF8", 'root', '');
        echo "<div class='container'>";
        echo "<div class='row  '>";

        $content = $conn->query("SELECT * FROM annonces");

        while ($row = $content->fetch()) {
            echo "
                    <div class='card bg-light col-lg-3  col-md-4  col-sm-6  mb-3'>
                    <img src=" . $row['Picture'] . " class='card-img-top' style='height:25%;'>
                    <div class='card-body '>
                    <h2 class='card-title mt-3 text-danger'>" . $row['Title'] . " " . $row['Surface'] . "m² </h2>
                    <h3 class='mt-2 ' >" . $row['OfferType'] . "</h3>
                    <h5>" . $row['Address'] . "</h5>
                    <p class='card-text '>" . $row['Description'] . "</p>
                    <h3 class='text-success'>Price : " . $row['Price'] . "DH </h3>  
                    <div class='d-flex justify-content-around'>
                    <a href='formEdit.php?id=" . $row['Id'] . "' class='btn btn-lg btn-danger px-4'>Edit</a>
                    <a onclick='confirmDeleting(" . $row['Id'] . ")' data-bs-toggle='modal' data-bs-target='#exampleModal' class='btn btn-lg btn-danger px-4'>Delete</a>
                    </div> 
                    <h6 class='text-secondary d-flex justify-content-end mt-3'>" . $row['OfferDate'] . "</h6>
                    </div>
                    </div>";
        }
    }

    ?>
</body>

</html>