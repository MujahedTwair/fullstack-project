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
$select = "SELECT * FROM `users` WHERE `id`='" . $_SESSION['user']['id'] . "'";
$query=mysqli_query($conn, $select);
$row=mysqli_fetch_array($query);
$fullname = htmlspecialchars($row['fullname']);
$username = htmlspecialchars($row['username']);
$email = htmlspecialchars($row['email']);
$phonenumber = htmlspecialchars($row['phonenumber']);
$password = htmlspecialchars($row['password']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="imges/icon.png"/>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <span class="navbar-brand paranav">Update user</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>   
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <a class="nav-link" aria-current="page" href="user.php">User Page</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><button class="btn btn-outline-danger">Log out</button></a>
                    </li>
                </ul>
    
            </div>         
        </div>
    </nav>

    <section style="background-image: url(imges/uu.webp); height: 100vh;background-repeat: no-repeat;background-size: cover;display: flex;height: 100vh;align-items: center;">
        <div class="container text-white">
            <div class="row justify-content-center">
                <div class="col-sm-6 pt-5">
                    <h2>Update</h2><br>
                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data">
                    <div class="form-group"> 
                            <label for="">Full Name</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                            
                            <script>document.querySelectorAll('input')[0].value =`<?php echo $fullname; ?>`;
                            </script>

                        </div><br>
                        <div class="form-group">
                            <label for="">Username</label> 
                            <input type="text" name="username" class="form-control" placeholder="Username">

                            <script>document.querySelectorAll('input')[1].value =`<?php echo $username; ?>`;
                            </script>

                        </div><br>
                        <div class="form-group">
                            <label for="">Email</label> 
                            <input type="email" name="email" class="form-control" placeholder="Email">

                            <script>document.querySelectorAll('input')[2].value =`<?php echo $email; ?>`;
                            </script>

                        </div><br>
                        <div class="form-group"> 
                            <label for="">Phone Number</label>
                            <input type="number" name="phonenumber" class="form-control" placeholder="Phone Number">

                            <script>document.querySelectorAll('input')[3].value =`<?php echo $phonenumber; ?>`;
                            </script>

                        </div><br>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">

                            <script>document.querySelectorAll('input')[4].value =`<?php echo $password; ?>`;
                            </script>

                        </div><br>
                        <div class="form-group">
                            <label for="photo">Profile Photo:</label>
                            <input type="file" id="photo" name="photo" class="form-control-file" accept=".png,.jpg,.jpeg">
                        </div><br>
                        <button type="submit" name="updateuser" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php


if(isset($_POST['updateuser'])){
    
    $id = $_SESSION['user']['id'];

    $newfullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $newusername = mysqli_real_escape_string($conn, $_POST['username']);
    $newemail = mysqli_real_escape_string($conn, $_POST['email']);
    $newphonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $newpassword = mysqli_real_escape_string($conn, $_POST['password']);

    $newphoto_name = $_FILES ['photo']['name']; 
    $newphoto_path = $_FILES ['photo']['tmp_name'];
    

    if($newfullname && $newusername && $newemail && $newphonenumber && $newpassword ){    
        $currentsql= "SELECT * from `users` where `id`='$id'";
        $select=mysqli_query($conn,$currentsql); 
        $row=mysqli_fetch_array($select);

        $isUsernameUnique = true;
        $isEmailUnique = true;

        if($newusername != $row['username']){
            $checkUsernameQuery = "SELECT * FROM users WHERE username = '$newusername' AND id != '$id'";
            $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);
            if(mysqli_num_rows($checkUsernameResult) >0){
                $isUsernameUnique = false;
                echo '<script>alert("the username used");</script>';
            }
        }     
        if($newemail != $row['email']){
            $checkEmailQuery = "SELECT * FROM users WHERE email = '$newemail' AND id != '$id'";
            $checkEmailResult = mysqli_query($conn, $checkEmailQuery);
            if(mysqli_num_rows($checkEmailResult) >0){
                $isEmailUnique = false;
                echo '<script>alert("the email used");</script>';
            }
        }
        if($isUsernameUnique && $isEmailUnique){
            $updateQuery = "UPDATE `users` SET `fullname` = '$newfullname', `username` = '$newusername', `email` = '$newemail', `phonenumber` = '$newphonenumber', `password` = '$newpassword' WHERE id = '$id'";
            $doneUpdate = mysqli_query($conn, $updateQuery);

            if($newphoto_name && $newphoto_path){

                $sql = "SELECT photo FROM users WHERE id = '$id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $currentPhotoName = $row['photo'];
                
                // delete current file
                $currentPhotoPath = "imges/usersimges/$currentPhotoName";
                if(file_exists($currentPhotoPath)) {
                    unlink($currentPhotoPath);
                }
                $newphoto_name = $id . '_' . $newphoto_name;
                if(move_uploaded_file($newphoto_path,"imges/usersimges/$newphoto_name")){
                    // update file path in database
                    $sql = "UPDATE users SET photo = '$newphoto_name' WHERE id = '$id'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script>alert("The photo has been updated.");</script>';
                    } else {
                        echo '<script>alert("Sorry, there was an error updating your record.");</script>';
                    }
                } else {
                    echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
                }

            }
            if($doneUpdate){
                echo '<script>alert("the user is updated ");window.location.assign("user.php");</script>';
            }
        }
    } 
    else{
        echo '<script>alert("Not Complete Data");</script>';
    }   
}
?>