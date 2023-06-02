<?php
require_once('connection.php');

if(isset($_POST['signup'])){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $photo_name=$_FILES ['photo']['name']; 
    $photo_path=$_FILES ['photo']['tmp_name'];
    
    if($fullname && $username && $email && $phonenumber && $password && $photo_name && $photo_path ){
        $sqlemail = "SELECT `email` FROM `users` WHERE `email` ='$email'";
        $queryemail=mysqli_query($conn, $sqlemail);
 
        $squsername = "SELECT `username` FROM `users` WHERE `username` ='$username'";
        $quereusername = mysqli_query($conn,$squsername);

        if (mysqli_num_rows($queryemail)>0) {
            echo '<script>alert("The Email used");</script>';
        }
        elseif(mysqli_num_rows($quereusername)>0){
            echo '<script>alert("The username used");</script>';
        }
        else{
            $insert = "INSERT INTO `users`(`fullname` , `username` , `email` , `phonenumber`,`password`) 
            VALUES ('$fullname', '$username', '$email', '$phonenumber', '$password')";
            $queryinsert = mysqli_query($conn,$insert);
            
            if($queryinsert){
                echo '<script>alert("stilll herrree Done")</script>';
                $squserid = "SELECT `id` FROM `users` WHERE `username` ='$username'";
                $queryidquery = mysqli_query($conn,$squserid);
                $rowid=mysqli_fetch_array($queryidquery);
                $id = $rowid["id"];
                $photo_name = $id . '_' . $photo_name;

                $updateph = "UPDATE `users` SET `photo` = '$photo_name' WHERE `id` = '$id'";
                $queryphoto = mysqli_query($conn,$updateph); 
                $move=move_uploaded_file($photo_path,"imges/usersimges/$photo_name");
                if($move){
                    echo '<script>alert("Register Successfully Done") ;window.location.assign("login.php");</script>';
                }
            }

        }
    }
    else{
        echo '<script>alert("Not Complete Data");</script>';
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="js/sweetalert2.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="imges/icon.png"/>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <span class="navbar-brand paranav">Sign up</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>   
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-4">
                        <a class="nav-link" aria-current="page" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
    
            </div>         
        </div>
    </nav>
    
    <section style="background-image: url(imges/signup.jpg); height: 100vh;background-repeat: no-repeat;background-size: cover;display: flex;height: 100vh;align-items: center;">
        <div class="container text-white">
            <div class="row justify-content-center">
                <div class="col-sm-6">
                    <h2 style="padding-top:30px;">Register</h2><br>
                    <form autocomplete='off' method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="multipart/form-data">
                        <div class="form-group"> 
                            <label for="">Full Name</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Full Name">
                        </div><br>
                        <div class="form-group">
                            <label for="">Username</label> 
                            <input type="text" name="username" class="form-control" placeholder="Username">
                        </div><br>
                        <div class="form-group">
                            <label for="">Email</label> 
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div><br>
                        <div class="form-group"> 
                            <label for="">Phone Number</label>
                            <input type="number" name="phonenumber" class="form-control" placeholder="Phone Number">
                        </div><br>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div><br>
                        <div class="form-group">
                            <label for="photo">Profile Photo:</label>
                            <input type="file" id="photo" name="photo" class="form-control-file" accept=".png,.jpg,.jpeg">
                        </div><br>
                        <input type="submit" value="Register" name="signup" class="btn btn-primary" />
                    </form>
                </div>
            </div>
        </div>
    </section>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>