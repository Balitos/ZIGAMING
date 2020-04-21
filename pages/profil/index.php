<?php
session_start();
ob_start();

// REQUETE PROFIL
include_once('../../partials/php/bdd.php');
include_once('../login/cookieconnect.php');

if (isset($_GET['id']) and $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();


// REQUETE ANNONCE
include_once('../../partials/php/bdd.php');

$reponse = $bdd->query("SELECT id ,numeroAnnonce, console, titre, prix, photo, descriptionJeu FROM annonce WHERE id = '$getid' ORDER BY numeroAnnonce");
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
    <title>Profil - zigaming</title>
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
                        <a href="../login/deconnexion.php"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                <?php
                }
                else
                {
                ?>
                    <div class="whitespace"></div>
                <?php
                }
                ?>
                <div id="profil-content-container">
                    <div id="profil-img">
                        <?php
                        if (!empty($userinfo['avatar'])) {
                        ?>
                            <img src="/assets/membres/avatars/<?php echo $userinfo['avatar']; ?>" alt="Avatar">
                        <?php
                        }
                        else
                        {
                        ?>
                        <img src="/assets/images/avatar-default.png" alt="Avatar par default">
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
                        <a href="../annonceAdd/"><i class="fas fa-plus-square"></i></a>
                    </div>
                <div id="case-container">
                    <?php
                    $variable = "";
                    while ($variable = $reponse->fetch()) {
                        $jeuToDell = $variable['numeroAnnonce'];
                    ?>
                        <div class="case">
                            <a href="../annonce/index.php?annonce=<?php echo $variable['numeroAnnonce'] ?>">
                                <div class="case-img">
                                    <img src="/assets/membres/annonce/<?php echo $variable['photo'] ?> " alt="photo annonce <?php echo $variable['titre'] ?> sur zigaming">
                                </div>
                            </a>    
                            <div class="case-infos">
                                <div class="case-infos-titre">
                                    <a href="../annonce/index.php?annonce=<?php echo $variable['numeroAnnonce'] ?>">
                                        <?php echo $variable['titre'] ?>
                                    </a>  
                                </div>
                                <div class="case-infos-console">
                                    <?php echo $variable['console'] ?>
                                </div>
                            </div>
                            <div class="case-price">
                                <form method="post">
                                    <button type="submit" id="case-price-delete" name="supprimer_jeu<?php echo $variable['numeroAnnonce'] ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <p>
                                    <?php echo $variable['prix'] ?>€
                                </p>
                                <a href="../annonceUpdate/index.php?annonce=<?php echo $variable['numeroAnnonce'] ?>">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        <?php
                        if (isset($_POST['supprimer_jeu' . $variable['numeroAnnonce']]))
                        {
                            include_once('../../partials/php/bdd.php');

                            $req = $bdd->prepare("DELETE FROM annonce WHERE numeroAnnonce= '$jeuToDell'");
                            $req->execute(['numeroAnnonce' => $jeuToDell]);
                            $req->closeCursor();
                            header("Location: index.php?id=".$_SESSION['id']);
                        }
                    }
                    $reponse->closeCursor();
                    ?>
                </div>
                <?php
                }
                else
                {
                ?>
                <div class="whitespace"></div>
                <div id="case-container">
                    <?php
                    $variable = "";
                    while ($variable = $reponse->fetch()) {
                    ?>
                        <div class="case">
                            <a href="../annonce/index.php?annonce=<?php echo $variable['numeroAnnonce'] ?>">
                                <div class="case-img">
                                    <img src="/assets/membres/annonce/<?php echo $variable['photo'] ?>">
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
                            </a>
                        </div>
                    <?php
                    }
                    ?>
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
}
?>