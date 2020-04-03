<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=zigaming;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query("SELECT id ,numeroAnnonce, console, titre, prix, photo, descriptionJeu FROM annonce");
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "partials/php/head.php";
    ?>
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
            <div class="slideshow-master-container">
                <div id="dot-container">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>

                <div class="slideshow-container">
                    <div class="mySlides fade">
                        <div class="numbertext">1 / 3</div>
                        <img src="/assets/images/slideshow/1.jpg">
                    </div>

                    <div class="mySlides fade">
                        <div class="numbertext">2 / 3</div>
                        <img src="/assets/images/slideshow/2.jpg">
                    </div>

                    <div class="mySlides fade">
                        <div class="numbertext">3 / 3</div>
                        <img src="/assets/images/slideshow/3.jpg">
                    </div>
                </div>

            </div>
            <!-- CASES -->
            <div id="case-container">
                <?php
                $variable = "";
                while ($variable = $reponse->fetch()) {
                ?>
                    <div class="case">
                        <div class="case-img">
                            <a href="pages/annonce/pageAnnonce.php?annonce=<?php echo $variable['numeroAnnonce'] ?>" class="case-img">
                                <img src="assets/membres/annonce/<?php echo $variable['photo'] ?>" class="case-img" style="height:100%; width:100%;">
                            </a>
                        </div>
                        <div class="case-infos">
                            <?php echo $variable['titre'] ?>
                            <br>
                            <br>
                            <?php echo $variable['console'] ?>
                        </div>
                        <div class="case-price">
                            <?php echo $variable['prix'] ?> €
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
    include "partials/php/footer.php";
    ?>
    <!-- SLIDESHOW SCRIPT -->
    <script src="script.js"></script>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>