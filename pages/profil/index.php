<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_GET['id']) and $_GET['id'] > 0) {
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
    <!-- HEADER -->
    <?php
    include "../../partials/php/headerCo.php";
    ?>

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <!-- PROFIL -->
            <div id="profil">
                <h1>Profil de <?php echo $userinfo['pseudo']; ?></h1>
                <br>
                <?php
                if (!empty($userinfo['avatar'])) {
                ?>
                    <img src="../../assets/membres/avatars/<?php echo $userinfo['avatar']; ?>" alt="Avatar">
                <?php
                }
                ?>
                <br>
                Pseudo = <?php echo $userinfo['pseudo']; ?>
                <br />
                Mail = <?php echo $userinfo['mail']; ?>
                <br />
                Description profil = <?php echo $userinfo['descriptionProfil']; ?>
                <br />
                <?php
                if (isset($_SESSION['id']) and $userinfo['id'] == $_SESSION['id']) {
                ?>
                    <a href="../annonce/">Vendre un jeu</a>
                    <br>
                    <a href="../annonce/gestionAnnonces/choixGestion.php">Gérer mes annonces</a>
                    <br>
                    <a href="../editProfil/">Editer mon profil</a>
                    <br />
                    <a href="deconnexion.php">Se déconnecter</a>
                    <br>
                    <a href="../../">Retour à l'Accueil</a>
                <?php
                } else {
                ?>
                    <br>
                    <a href="../../">Retour à l'Accueil</a>
                <?php
                }
                ?>
            </div>
            <!-- CASES -->
            <div id="case-container">
                <!-- <?php
                        // $variable = "";
                        // while ($variable = $reponse->fetch())
                        // {
                        ?> -->
                <div class="case">
                    <div class="case-img">
                        <!-- <a href="pages/annonce/pageAnnonce.php?annonce=<?php echo $variable['numeroAnnonce'] ?>" class="case-img">
                    <img src="assets/membres/annonce/<?php echo $variable['photo'] ?>" class="case-img"style="height:100%; width:100%;">
                </a> -->
                    </div>
                    <div class="case-infos">
                        <div class="case-infos-titre">
                            <!-- <?php echo $variable['titre'] ?> -->
                        </div>
                        <div class="case-infos-console">
                            <!-- <?php echo $variable['console'] ?> -->
                        </div>
                    </div>
                    <div class="case-price">
                        <!-- <?php echo $variable['prix'] ?>€ -->
                    </div>
                </div>
                <!-- <?php
                        // }
                        ?> -->
            </div>
        </div>
    </div>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>
<?php
}
?>