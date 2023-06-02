<?php
session_start();
require_once ('connection.php');

if(isset($_POST['login'])){
$logvalue =mysqli_real_escape_string($conn,$_POST['loginvalue']);
$password = mysqli_real_escape_string($conn,$_POST['password']);
//check for admin
$select="SELECT `id`, `email`,`password` from `admins` where  `email`='$logvalue' ";
$query=mysqli_query($conn, $select);
$row=mysqli_fetch_array($query);

//check for user email
$select2="SELECT `id`, `fullname`, `email`,`password` from `users` where  `email`='$logvalue' ";
$query2=mysqli_query($conn, $select2);
$row2=mysqli_fetch_array($query2);

//check for user username
$select3="SELECT `id`, `fullname`, `email`,`password` from `users` where  `username`='$logvalue' ";
$query3=mysqli_query($conn, $select3);
$row3=mysqli_fetch_array($query3);


if(mysqli_num_rows($query)>0){
    if($row["password"]=="$password"){
        // Store user data in the session.
        $_SESSION['user'] = array(
            'id' => $row["id"],
            'role' => 'admin'
        );
        echo '<script>alert("Welcome Admin");window.location.assign("admin.php");</script>';
    }
    else{
        echo '<script>alert("incorrect information")</script>';
    }
}
elseif(mysqli_num_rows($query2)>0){
    if($row2["password"]=="$password"){
        // Store user data in the session.
        $_SESSION['user'] = array(
            'id' => $row2["id"],
            'role' => 'user'
        );
        echo '<script>alert("Welcome user('.$row2["fullname"].')");window.location.assign("user.php");</script>';
    }
    else{
        echo '<script>alert("incorrect user information")</script>';
    }
}
elseif(mysqli_num_rows($query3)>0){
    if($row3["password"]=="$password"){
        // Store user data in the session.
        $_SESSION['user'] = array(
            'id' => $row3["id"],
            'role' => 'user'
        );
        echo '<script>alert("Welcome user('.$row3["fullname"].')");window.location.assign("user.php");</script>';
    }
    else{
        echo '<script>alert("incorrect user information")</script>';
    }
}
else{
    echo '<script>alert("you dont have account , must create account")</script>';
}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="imges/icon.png"/>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container">
            <span class="navbar-brand paranav">Login</span>
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
                        <a class="nav-link" href="signup.php">Register</a>
                    </li>
                </ul>
    
            </div>         
        </div>
    </nav>

    <section style="background-image: url(imges/login.jpg); height: 100vh;background-repeat: no-repeat;background-size: cover;display: flex;height: 100vh;align-items: center;">
        <div class="container text-white">
            <div class="row justify-content-center">
                <div class="col-sm-6 pt-5">
                    <h2>Login</h2>
                    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>">
                        <div class="form-group">
                            <label for="username">Enter your account details:</label><br><br>
                            <input type="text" id="username" name="loginvalue" class="form-control" placeholder="Username or email"><br>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password"><br>
                        </div>
                        <input type="submit" name="login" value="Login" class="btn btn-success"/><br><br>
                        <p>Don't have an account?<a href="signup.php" class="btn btn-outline-primary ms-2">Create New</a></p>
                        
                    </form>
                </div>
            </div>
        </div>
    </section>











    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>