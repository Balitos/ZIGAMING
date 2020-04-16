<?php
session_start();
// requete ANNONCE
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

include_once('../login/cookieconnect.php');

$getAnnonce = intval($_GET['annonce']);
$requser = $bdd->prepare('SELECT A.id, A.numeroAnnonce, A.titre, A.console, A.prix, A.photo, A.descriptionJeu, A.etat
FROM annonce A
WHERE numeroAnnonce = ?
');

$requser->execute(array($getAnnonce));
$userinfo = $requser->fetch();

// REQUETE VENDEUR
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query("SELECT A.numeroAnnonce, M.avatar, M.pseudo, M.descriptionProfil, M.mail, M.id 
FROM annonce A 
JOIN membres M on M.id = A.id
WHERE A.numeroAnnonce = '$getAnnonce'");
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
</head>

<body>
    <!-- HEADER -->
    <?php
    if (isset($_SESSION['id']))
    {
        include "../../partials/php/headerCo.php";
    }
    else
    {
        include "../../partials/php/header.php";
    }
    ?>

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <div id="cards-title">
                <h2 id="nomJeu"> Acheter <?php echo $userinfo['titre'] ?> sur <?php echo strtoupper($userinfo['console']) ?> </h2>
            </div>
            <div id="cards-container">
                <!-- GAME CARD -->
                <div id="game-card">
                    <div id="gc-img">
                        <img src="/assets/membres/annonce/<?php echo $userinfo['photo'] ?>">
                    </div>
                    <div id="gc-description-title">
                        <h3>Description</h3>
                    </div>
                    <div id="gc-description">
                        <p>
                            <?php echo stripslashes($userinfo['descriptionJeu']) ?>
                        </p>
                    </div>
                    <div id="gc-bottom">
                        <p>
                            <?php echo stripslashes($userinfo['console']) ?>
                        </p>
                        <p>
                            <?php echo stripslashes($userinfo['etat']) ?>
                        </p>
                        <p>
                            <?php echo stripslashes($userinfo['prix']) ?>€
                        </p>
                    </div>
                </div>
                <!-- PROFIL CARD -->
                <?php
                $variable = "";
                while ($variable = $reponse->fetch())
                {
                ?>
                <div id="profil-card">
                    <div id="pc-img">
                        <img src="/assets/membres/avatars/<?php echo $variable['avatar'] ?>">
                    </div>
                    <div id="pc-title">
                        <p>
                            <?php echo $variable['pseudo'] ?>
                        </p>
                    </div>
                    <div id="pc-description">
                        <p>
                            <?php echo $variable['descriptionProfil'] ?>
                        </p>
                    </div>
                    <div id="pc-link">
                        <a href="../profil/index.php?id=<?php echo $variable['id'] ?>">Voir profil</a>
                        <a href="../envoiMessage/"><i class="far fa-comment-alt"></i></a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>


    <!-- FOOTER -->
    <?php
    include "../../partials/php/footer.php";
    ?>

    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>