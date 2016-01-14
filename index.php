<?php
require_once("config/dbconf.php");
session_start();
try {
    $pdo = new PDO($config['host'], $config['user'], $config['password']);
} catch (PDOException $e){
    echo 'Erreur :' .$e;
}
global $config;
if(!isset($_SESSION['user'])){
    header("Location: /login.php");
    exit;
}
if(isset($_POST['reset_best'])){
    unset($_SESSION['best_score']);
}
if(empty($_SESSION['choice']) || isset($_POST['reset'])){
    $choice  =  rand(0,100);
    $_SESSION['score'] = 0;
    $_SESSION['choice'] = $choice;
}else{
    $choice = $_SESSION['choice'];
}

$response = null;
if( !isset($_POST['guess'])
    || empty($_POST['guess'])){
    $response = "Pas de nombre";
}else{
    $guess = $_POST['guess'];
    $_SESSION['score']++;
    if($guess > $choice) {
        $response = "C'est moins";
    }elseif($guess < $choice){
        $response = "C'est plus";
    }else {
        $response = "C'est gagné";
        if (!isset($_SESSION['best_score']) || $_SESSION['best_score'] > $_SESSION['score']){
            $_SESSION['best_score'] = $_SESSION['score'];
        }
        $best = $_SESSION['best_score'];
        $login = $_SESSION['user'];
        try {
          $tumsoules = "UPDATE users SET best_score = '$best' WHERE users.login = '$login'";
           $stmt = $pdo->prepare($tumsoules);
        } catch (PDOException $e){
          echo 'Erreur' .$e;
        }
        $stmt->execute();
        unset($_SESSION['choice']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Des papiers dans un bol </title>
</head>
<body>

<?php echo $response;?><br>
Nombre de coup : <?php echo $_SESSION['score']; ?>
<form method="POST">
    <input type="text" name="guess" autofocus>
    <input type="submit">
    <input type="submit" name="reset" value="reset">
    <input type="submit" name="reset_best" value="reset best">
</form>
<em>(La réponse est <?php echo $choice?>)</em>
<em>Meilleur coup : <?php
    echo !isset($_SESSION['best_score'])
        ? "Pas de meilleur score"
        : $_SESSION['best_score'];
    ?></em>
<form method="post" action="/login.php">
    <input type="submit" name="logout" value="Logout">
</form> <br>
<style>
table {
  border: solid #000000 2px;
  border-collapse: collapse;
  text-align: center;
}
td {
  border: solid #000000 2px;
  border-collapse: collapse;
}
tr {
  border: solid #000000 2px;
  border-collapse: collapse;
}
</style>
<table>
  <tr>
    <td>Joueur</td>
    <td>Best Score</td>
  </tr>
<?php $leaderbord = $pdo->prepare("SELECT * FROM users");
      $leaderbord->execute();
      while ($leaderdata = $leaderbord->fetch()) {
        echo '<tr><td>'.$leaderdata['login'].'</td><td>'.$leaderdata['best_score'].'</td></tr>';
      }
      ?>



</body>
</html>
