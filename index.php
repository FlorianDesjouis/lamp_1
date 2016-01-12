<?php
    session_start();
    if(empty($_SESSION['choice'])) {
        $choice = rand(0, 100);
        $_SESSION['choice'] = $choice;
    }else{
        $choice = $_SESSION['choice'];
    }
    $response = null;
    if(empty($_SESSION['count'])) {
        $count = 0;
        $_SESSION['count'] = $count;
    }else{
        $count = $_SESSION['count'];
    }
    if(empty($_SESSION['best'])) {
        $best = 100;
        $_SESSION['best'] = $best;
    }else{
        $best = $_SESSION['best'];
    }
    if(!isset($_POST['guess']) || empty($_POST['guess'])){
        $response = 'pas de nombre';
    }
    else{
        $guess = $_POST['guess'];
        if($guess > $choice){
            $response = "C'est moins";
            $count++;
            $_SESSION['count'] = $count;
        }elseif($guess < $choice){
            $response = "C'est plus";
            $count++;
            $_SESSION['count'] = $count;
        }else{
            $response = "C'est gagné";
            unset($_SESSION['choice']);
            $count++;
            $_SESSION['count'] = $count;
            unset($_SESSION['count']);
        }
        if($count < $best){
            $best = $count;
            $_SESSION['best']=$best;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
<title>Des papiers dans un bol</title>
</head>
<body>
    <?php echo $response;?>
    <form method="post">
        <input type="text" name="guess">
        <input type="submit"><br>
        (la réponse est <?php echo $choice ?>)<br>
        Nombre d'essais <?php echo $count ?><br>
        Meilleur score <?php echo $best ?>
    </form>
</body>
</html>
