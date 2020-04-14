<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=zigaming;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


if (isset($_GET['recherche']) and !empty($_GET['recherche'])) {
    $filtre_vide = "no";
    $recherche = htmlspecialchars($_GET['recherche']);


    $articles = $bdd->query('SELECT * FROM annonce WHERE titre LIKE "%' . $recherche . '%" ');

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
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
                                <img src="/assets/membres/annonce/<?php echo $variable['photo'] ?>" class="case-img">
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
        include "../../partials/php/footer.php";
    ?>

    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>


<?php
} else {
    header("Location: ../../");;
}
?>