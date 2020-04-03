<?php
session_start();
// requete ANNONCE
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$getAnnonce = intval($_GET['annonce']);
$requser = $bdd->prepare('SELECT A.id, A.numeroAnnonce, A.titre, A.console, A.prix, A.photo, A.descriptionJeu
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

$reponse = $bdd->query("SELECT A.numeroAnnonce, M.avatar, M.pseudo, M.descriptionProfil, M.mail 
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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>

    <?php
    if (isset($_SESSION['id'])) {
    ?>
        <!-- HEADER -->
        <?php
        include "../../partials/php/headerCo.php";
        ?>
    <?php
    } else {
        include "../../partials/php/header.php";
    }
    ?>

    <div id="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-8" id="titre">
                    <h2 id="nomJeu"> Acheter <?php echo $userinfo['titre'] ?> sur <?php echo strtoupper($userinfo['console']) ?> </h2>
                </div>
                <div class="col-md-8" id="image">
                    <img src="../../assets/membres/annonce/<?php echo $userinfo['photo'] ?> " class="img-fluid" style="width:auto;" alt="Responsive image">
                </div>
                <div class="hidden-xs col-md-4">

                    <?php
                    $variable = "";
                    while ($variable = $reponse->fetch()) {
                    ?>


                        <div class="card" id="card_vendeur">

                            <img src="/assets/membres/avatars/<?php echo $variable['avatar'] ?>" class="img-fluid card-img-top" style="border-top-left-radius: inherit;border-top-right-radius: inherit; max-height:70%" alt="photoJeu">
                            <div class="card-body text-center" style="background-color: #333;max-height: 70%;">
                                <h5 class="card-title text-break" style="color: white"><?php echo "INFO" ?></h5>
                            </div>
                            <div class="card-body text-truncate text-center" style="height: 50%;background-color: #333; color:white;">
                                <p class="card-text text-align" style="color: white">
                                    <p>
                                        <?php echo $variable['descriptionProfil'] ?>
                                    </p>
                                </p>
                            </div>
                            <div class="card-footer text-right" style="height: 12%;background-color: #ea732b;border-bottom-left-radius: inherit;border-bottom-right-radius: inherit; ">
                                <div class="row">
                                    <div class="col text-center" style="color: white;">
                                        <a href="../profil/index.php?id=<?php ?>" style="color:white;">
                                            <p>VOIR PROFIL</p>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php } ?>


                </div>
            </div>

            <div class="row" style="margin-top:3em;">
                <div class="md-10">
                    <h3 id="descriptionTitre">Description</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" id="description">
                    <?php echo stripslashes($userinfo['descriptionJeu']) ?>
                </div>
            </div>                        
            </div>



        </div>
    </div>


    <!-- FOOTER -->
    <?php

    include "../../partials/php/footer.php";
    ?>

    <!-- SLIDESHOW SCRIPT -->
    <script src="script.js"></script>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>