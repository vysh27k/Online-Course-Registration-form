<?php
    session_start();
    include("db.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $Username = $_POST['Username'];
        $Password = $_POST['Password'];

        if (!empty($Username) && !empty($Password)) {
            $query = "SELECT * FROM login_credentials WHERE Username='$Username' LIMIT 1";
            $result = $conn->query($query);
            
            if ($result) {
                if ($result && mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);

                    // Check if password matches
                    if ($user_data['Password'] == $Password) {
                        // Redirect based on the first character of the username
                        if (substr($Username, 0, 1) == '1') {
                            header("location: linkpage1.html");
                        } elseif (substr($Username, 0, 1) == 'n') {
                            header("location: linkpage2.html");
                        }  elseif (substr($Username, 0, 1) == 'h') {
                            header("location: linkpage6.html");
                        }  
                        die;
                    }
                }
            }
            echo "<script type='text/javascript'> alert('Wrong Username or Password');</script>";
        } else {
            echo "<script type='text/javascript'> alert('Please fill in both fields');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <style>
  
    *{
            margin: 0px;
            padding:px;
            box-sizing: border-box;
    }
    body{
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        text-align:center;
        background: url('https://ncet.co.in/wp-content/uploads/2023/06/CRT01676-HDR-Edit-1024x683.jpg') ;
        background-position: center;
        backdrop-filter: blur(6px);
    }
    .container{
        margin: auto;
        width:500px;
        height: 270px;
        border: 3px solid black;
    }
    .container form {
        width: 100%;
        height: 120%;
        background:transparent;
        padding: 20px;
        
    }
    .container form h1{
        text-align: center;
        margin-bottom: 24px;
        color: black;
    }
    .container form .Username{
        background:transparent;
        border:2px solid black;
        height: 40px;
        width: 70%;
        margin-bottom: 10px;
        margin-left: 10px;

    }
    .container form .Password{
        background:transparent;
        border:2px solid black;
        height: 40px;
        width: 70%;
        margin-bottom: 10px;
        margin-left: 10px;
    }
    .container form .Button{
        background: #1cc21c;
        border: 3px;
        height: 38px;
        width: 60px;
        cursor: pointer;
        margin-top: 15px;
        transition: .3s;
        color:white;
        font-size: 15px;
    }
    .container form .Button:hover{
        opacity: .8;
    }
   </style>
</head>
<body>
    
    <div class="container">
    <form  method="POST">
        <h1>Login Form</h1>
            <div>
                <b><label for="" >User name:</label></b>
                <input type="text" class="Username" name="Username"  placeholder= "Enter Username" required>
                <i class='bx bxs-user'></i>
                </div>
                <br>
            <div>
                <b><label for="" >Password:</label></b>
                <input type="password" class="Password" name="Password" placeholder="DD-MM-YYYY" autocomplete="off" required>
               
                <i class='bx bxs-lock-alt'></i>
                </div>
        <center><button type="submit" class ="Button">Login</button> </center> 
        
    </form>
    </div>
    
</body>
</html>