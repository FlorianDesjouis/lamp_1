<?php session_start();

if(isset($_POST['logout'])){
    unset($_SESSION['user']);
}

if(isset($_SESSION['user'])){
    header("location: /");
    exit;
}

$errormessage = null;
if(isset($_POST['username'])){
    if($_SESSION['user'] = $_POST == "Drekkness"){
        $_SESSION['user'] = $_POST['username'];
        header("location: /");
        exit;
    }else{
        $errormessage = "Wrong Username";
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Document</title>
</head>
<body>
    Merci de vous connecter :
    <form method="post">
        Login : <input type="text" name="username"><br>
        <input type="submit" value="Log in">
    </form>
    <?php echo $errormessage; ?>
</body>
</html>
