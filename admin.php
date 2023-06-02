<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user'])) {
    // User is not logged in - redirect them to the login page
echo '<script>alert("You are have not logged in") ;window.location.assign("login.php");</script>';
} else {
    // User is logged in

    // Check if the user is an admin
    if ($_SESSION['user']['role'] != 'admin') {
        // User is not an admin - redirect them to the user page or wherever you want non-admin users to go
        echo '<script>alert("You are a user not an admin") ;window.location.assign("user.php");</script>';
    }
}

if(isset($_POST['creatuser'])){
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

                $squserid = "SELECT `id` FROM `users` WHERE `username` ='$username'";
                $queryidquery = mysqli_query($conn,$squserid);
                $rowid=mysqli_fetch_array($queryidquery);
                $id = $rowid["id"];
                $photo_name = $id . '_' . $photo_name;

                $updateph = "UPDATE `users` SET `photo` = '$photo_name' WHERE `id` = '$id'";
                $queryphoto = mysqli_query($conn,$updateph);

                $move=move_uploaded_file($photo_path,"imges/usersimges/$photo_name");
                if(!$move) {
                    echo '<script>alert("error uploading file");</script>';
                }
                if($move){
                    echo '<script>alert("Create Successfully Done") ;window.location.assign("admin.php");</script>';
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
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="imges/icon.png"/>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <span class="navbar-brand paranav">Admin Page</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>   
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#updatesec">UpdateUsers</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#add">Add users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><button class="btn btn-outline-danger">Log out</button></a>
                    </li>
                </ul>
            </div>         
        </div>
    </nav>

    <section id="add" class="pt-4 mb-0" style="background: linear-gradient(135deg, #17EAD9, #6078EA);height:100vh;">
        <div class="container" style="width: 70%;">
            <h1>CRUD System</h1>
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" autocomplete="off" enctype="multipart/form-data">
                <h2 id="htable">Create</h2>
                <div class="mb-3">
                    <label for="">Full Name</label>
                    <input class="inputs form-control" type="text" placeholder="Full Name" id="fullname" name="fullname"/>
                </div>

                <div class="mb-3">
                    <label for="">Username</label>
                    <input class="inputs form-control" type="text" placeholder="Username" id="username" name="username"/>
                </div>
    
                <div class="mb-3">
                    <label for="">Email</label>
                    <input class="inputs form-control" type="email" placeholder="Email" id="email" name="email"/>
                </div>
    
                <div class="mb-3">
                    <label for="">Phone Number</label>
                    <input class="inputs form-control" type="number" placeholder="PhoneNumber" id="phonenumber" name="phonenumber"/>
                </div>
                <div class="mb-3">
                    <label for="">Password</label>
                    <input class="inputs form-control" type="password" placeholder="Password" id="password" name="password"/>
                </div>
                <div class="mb-3">
                    <label for="photo">Profile Photo:</label>
                    <input type="file" id="photo" name="photo" class="form-control-file" accept=".png,.jpg,.jpeg">
                </div>
    
                <input type="submit" value="Add User" class="btn btn-outline-secondary mt-3" id="click" name = "creatuser" >
                <input type="submit" value="Update User" class="btn btn-success mt-3" style="display: none;" id="update" name="updateuser">
                <button class="btn btn-outline-secondary mt-3" id="restart" type="reset">Clear</button>
            </form>
        </div>
    </section>

    <section id="updatesec" class= "pb-4" style="background: linear-gradient(135deg, #B2FEF7, #66D8B9);">
        <div class="container">
            <br>
            <h2>Read-Update-Delete</h2>
            <input type="search" placeholder="Search by username" id="search" class="form-control my-3" autocomplete="off">
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="GET" >
                <table class="table table-striped text-decoration-none">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>FullName</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Password</th>
                            <th>ProfilePhoto</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                
                    <tbody id="data"> 
                    <?php 
    
                        $sql= "SELECT * from `users`";
                        $select=mysqli_query($conn,$sql);
        
                        if($select){
        
                            while($row=mysqli_fetch_assoc($select)){ // give row after row from database and eah one store ir in $row
                                  
                                 // Map htmlspecialchars over each item in the row.
                                $escaped_row = array_map('htmlspecialchars', $row);
                                    
                                // Append the escaped row to the data array.
                                $data[] = $escaped_row;
                            } 
                        }
                        ?>
                    <script>var dataArray = <?php echo json_encode($data); ?>;</script>
                    </tbody>
                </table> 
            </form>       
        </div>
    </div>
    </section>



     <script src="js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

if(isset($_POST['updateuser'])){
    $id = mysqli_real_escape_string($conn, $_POST['id']);

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
                echo '<script>alert("the user is updated ");window.location.assign("admin.php");</script>';
            }
        }
    } 
    else{
        echo '<script>alert("Not Complete Data");</script>';
    }   
}

if(isset($_GET['deletedid'])){
    $id=$_GET['deletedid'];

    // fetch photo filename from database
    $sql = "SELECT photo FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $photo_name = $row['photo'];

        // delete file from server
        $photo_path = "imges/usersimges/$photo_name";
        if(file_exists($photo_path)) {
            unlink($photo_path);
        }
    }

    // delete user from database
    $sql="DELETE FROM `users` where `id`='$id'";
    $query=mysqli_query($conn,$sql);
    if ($query){
        echo '<script>alert("the user is deleted");window.location.assign("admin.php");</script>';
    }
}


?>
