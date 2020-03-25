<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if(isset($_GET['id']) AND $_GET['id'] > 0)
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- PROFIL -->
        <div id="profil">
            <h1>Profil de <?php echo $userinfo['pseudo']; ?></h1>
            Pseudo = <?php echo $userinfo['pseudo']; ?>
            <br/>
            Mail = <?php echo $userinfo['mail']; ?>
            <br/>
            <?php
            if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
            {
            ?>
            <a href="#">Editer mon profil</a>
            <br/>
            <a href="deconnexion.php">Se déconnecter</a>
            <?php
            }
            ?>
        </div>
    </div>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>
<?php
}
?>