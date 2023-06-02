<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user'])) {
    // User is not logged in - redirect them to the login page
    echo '<script>alert("You are have not logged in") ;window.location.assign("login.php");</script>';
} else {
    // User is logged in

    // Check if the user is an admin
    if ($_SESSION['user']['role'] == 'admin') {
        // User is an admin - redirect them to the admin page
        echo '<script>alert("You are an admin not a user") ;window.location.assign("admin.php");</script>';
    }
}



$select = "SELECT `fullname`,`photo` FROM `users` WHERE `id`='" . $_SESSION['user']['id'] . "'";
$query=mysqli_query($conn, $select);
$row=mysqli_fetch_array($query);
$fullname = $row['fullname'];
$photoname = $row['photo'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserPage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="imges/icon.png"/>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <span class="navbar-brand paranav">User Page</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>   
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <a class="nav-link" aria-current="page" href="updateuser.php">Update</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><button class="btn btn-outline-danger">Log out</button></a>
                    </li>
                </ul>
            </div>         
        </div>
    </nav>
    
    <section style="background-image: url(imges/userpage.jpg); height: 100vh;background-repeat: no-repeat; background-size: cover;height: 100vh;display: flex; align-items: center;">
        <div class="container" style="font-family: 'Raleway', sans-serif;">
            <div class="row justify-content-between">
                <h2 class="text-white col-md-5">Welcome , <?php echo $fullname; ?>. We are glad to see you today</h2>
                <div class="card col-md-5" style="width: 18rem;">
                    <img src="imges/usersimges/<?php echo $photoname; ?>" class="card-img-top" width = "300" height ="300" alt="...">
                    <div class="card-body">
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                  </div>
            </div>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>