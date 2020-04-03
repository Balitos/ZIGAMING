<?php
session_start();


// REQUETE PROFIL
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


// REQUETE ANNONCE
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query("SELECT id ,numeroAnnonce, console, titre, prix, photo, descriptionJeu FROM annonce WHERE id = '$getid'");
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
                <!-- PROFIL -->
                <div id="profil">
                    <h1>Profil de <?php echo $userinfo['pseudo']; ?></h1>
                    <?php
                    if (isset($_SESSION['id']) and $userinfo['id'] == $_SESSION['id']) {
                    ?>
                        <div class="profil-icons">
                            <a href="../editProfil/"><i class="fas fa-user-edit"></i></a>
                            <a href="deconnexion.php"><i class="fas fa-sign-out-alt"></i></a>
                        </div>
                    <?php
                    }
                    ?>
                    <div id="profil-content-container">
                        <div id="profil-img">
                            <?php
                            if (!empty($userinfo['avatar'])) {
                            ?>
                                <img src="../../assets/membres/avatars/<?php echo $userinfo['avatar']; ?>" alt="Avatar">
                            <?php
                            }
                            ?>
                        </div>
                        <div id="profil-infos">
                            <ul>
                                <li>
                                    <span>Pseudo : </span><?php echo $userinfo['pseudo']; ?>
                                </li>
                                <li>
                                    <span>Mail : </span><?php echo $userinfo['mail']; ?>
                                </li>
                                <li>
                                    <span>Description profil : </span><?php echo $userinfo['descriptionProfil']; ?>
                                </li>
                                <li>
                                    <span>Adresse : </span><?php echo $userinfo['adresse']; ?>
                                </li>
                                <?php
                                if (isset($_SESSION['id']) and $userinfo['id'] == $_SESSION['id']) {
                                ?>
                                    <li>
                                        <!-- <a href="../../">Retour à l'Accueil</a> -->
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- CASES -->
                <div id="case-master-container">
                    <h1>Annonces</h1>
                    <?php
                    if (isset($_SESSION['id']) and $userinfo['id'] == $_SESSION['id']) {
                    ?>
                        <div class="profil-icons">
                            <a href="../annonce/"><i class="fas fa-plus-square"></i></a>
                            <a href="../annonce/gestionAnnonces/choixGestion.php"><i class="fas fa-edit"></i></a>
                        </div>
                    <?php
                    }
                    ?>
                    <div id="case-container">
                        <?php
                        $variable = "";
                        while ($variable = $reponse->fetch()) {
                        ?>
                            <div class="case">
                                <div class="case-img">
                                    <a href="../../pages/annonce/pageAnnonce.php?annonce=<?php echo $variable['numeroAnnonce'] ?>" class="case-img">
                                        <img src="/assets/membres/annonce/<?php echo $variable['photo'] ?>" class="case-img" style="height:100%; width:100%;">
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
}
?>