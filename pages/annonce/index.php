<?php
session_start();

// requete ANNONCE
require_once('../../partials/php/bdd.php');
include_once('../login/cookieconnect.php');

$getAnnonce = intval($_GET['annonce']);
$requser = $bdd->prepare('SELECT A.id, A.numeroAnnonce, A.titre, A.console, A.prix, A.photo, A.descriptionJeu, A.etat
FROM annonce A
WHERE numeroAnnonce = ?
');

$requser->execute(array($getAnnonce));
$userinfo = $requser->fetch();

// REQUETE VENDEUR
require_once('../../partials/php/bdd.php');
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
    <title><?php echo $userinfo['titre'] ?> sur <?php echo strtoupper($userinfo['console']) ?></title>
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
                        <img src="/assets/membres/annonce/<?php echo $userinfo['photo'] ?>" alt="photo annonce <?php echo $variable['titre'] ?> sur zigaming">
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
                while ($variable = $reponse->fetch())
                {
                ?>
                <div id="profil-card">
                    <div id="pc-img">
                        <?php
                        if (!empty($variable['avatar'])) {
                        ?>
                            <img src="/assets/membres/avatars/<?php echo $variable['avatar'] ?>" alt="Avatar">
                        <?php
                        }
                        else
                        {
                        ?>
                        <img src="/assets/images/profil-default.png" alt="Avatar par default">
                        <?php
                        }
                        ?>
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