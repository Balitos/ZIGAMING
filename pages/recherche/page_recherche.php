<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
    <title>Recherche sur zigaming</title>
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

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <?php if ($articles->rowCount() == 0) {
                echo "<h3 id='resultat'> AUCUN RESULTAT POUR : " . $recherche . " </h3>";
            } else {
                echo "<h3 id='resultat'>RESULTAT POUR : " . $recherche . " </h3>";
            }

            ?>
            <!-- CASES -->
            <div id="case-container">
                <?php
                $variable = "";
                while ($variable = $articles->fetch()) {
                ?>
                    <div class="case">
                        <div class="case-img">
                            <a href="../annonce/index.php?annonce=<?php echo $variable['numeroAnnonce'] ?>" class="case-img">
                                <img src="/assets/membres/annonce/<?php echo $variable['photo'] ?>" class="case-img" alt="annonce <?php echo $variable['titre'] ?> sur zigaming">
                            </a>
                        </div>
                        <div class="case-infos">
                            <div class="case-infos-titre">
                                <?php echo $variable['titre'] ?>
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