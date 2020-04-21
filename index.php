<?php
session_start();

include_once('partials/php/bdd.php');
include_once('pages/login/cookieconnect.php');

$reponse = $bdd->query("SELECT id ,numeroAnnonce, console, titre, prix, photo, descriptionJeu FROM annonce ORDER BY numeroAnnonce DESC LIMIT 12");
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "partials/php/head.php";
    ?>
    <title>ZIGAMING, vente de jeux et d'high-tech - zigaming</title>
</head>

<body>

    <?php
    if (isset($_SESSION['id']))
    {
    ?>
        <!-- HEADER -->
        <?php
        include "partials/php/headerCo.php";
        ?>
    <?php
    }
    else
    {
        include "partials/php/header.php";
    }
    ?>

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <!-- SLIDESHOW -->
            <div id="slideshow-wrap">
                <div class="slideshow-master-container">
                    <div id="dot-container">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                    </div>

                    <div class="slideshow-container">
                        <div class="mySlides fade">
                            <div class="numbertext">1 / 3</div>
                            <img src="/assets/images/slideshow/csgo.jpg" alt="image d'annonce 1 sur zigaming">
                        </div>

                        <div class="mySlides fade">
                            <div class="numbertext">2 / 3</div>
                            <img src="/assets/images/slideshow/r6.jpg" alt="image d'annonce 2 sur zigaming">
                        </div>

                        <div class="mySlides fade">
                            <div class="numbertext">3 / 3</div>
                            <img src="/assets/images/slideshow/tw3.jpg" alt="image d'annonce 2 sur zigaming">
                        </div>
                    </div>
                </div>
            </div>
            <!-- CASES -->
            <div id="case-container-title">
                <h2>Dernières annonces :</h2>
            </div>
            <div id="case-container">
                <?php
                $variable = "";
                while ($variable = $reponse->fetch()) {
                ?>
                    <div class="case">
                        <a href="pages/annonce/index.php?annonce=<?php echo $variable['numeroAnnonce'] ?>">
                            <div class="case-img">
                                <img src="/assets/membres/annonce/<?php echo $variable['photo'] ?>" alt="photo annonce <?php echo $variable['titre'] ?> sur zigaming">
                            </div>
                        </a>
                        <div class="case-infos">
                                <div class="case-infos-titre">
                                    <a href="pages/annonce/index.php?annonce=<?php echo $variable['numeroAnnonce'] ?>">
                                        <?php echo $variable['titre'] ?>
                                    </a>  
                                </div>
                                <div class="case-infos-console">
                                    <?php echo $variable['console'] ?>
                                </div>
                            </div>
                        <div class="case-price">
                            <?php echo $variable['prix'] ?>€
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div id="voir-plus">
                <a href="pages/recherche/?filtre_console=0&recherche=">Voir plus -></a>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php
    include "partials/php/footer.php";
    ?>
    
    <!-- SLIDESHOW SCRIPT -->
    <script src="script.js"></script>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>