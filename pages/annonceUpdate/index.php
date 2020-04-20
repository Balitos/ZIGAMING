<?php
session_start();
require_once '../../includes/functions.php';

// REQUETE
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'dbu525275', '^pc%MAjwsWVhc3pM', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

include_once('../login/cookieconnect.php');

$getAnnonce = intval($_GET['annonce']);
$requser = $bdd->prepare('SELECT id, numeroAnnonce, titre, console, prix, photo, descriptionJeu FROM annonce WHERE numeroAnnonce = ?');
$requser->execute(array($getAnnonce));
$userinfo = $requser->fetch();

// GESTION D'ERREURS
if (isset($_POST['update_titre']) and !empty($_POST['update_titre'])) {
    $update_titre = htmlspecialchars($_POST['update_titre']);
    update('annonce', 'titre', $update_titre, $getAnnonce);
    header("Location: ../profil/index.php?id=".$_SESSION['id']);
}

if (isset($_POST['update_description']) and !empty($_POST['update_description'])) {
    $update_description = htmlspecialchars(addslashes($_POST['update_description']));
    update('annonce', 'descriptionJeu', $update_description, $getAnnonce);
    header("Location: ../profil/index.php?id=".$_SESSION['id']);
}

if (isset($_POST['update_prix']) and !empty($_POST['update_prix'])) {
    $update_prix = htmlspecialchars($_POST['update_prix']);
    update('annonce', 'prix', $update_prix, $getAnnonce);
    header("Location: ../profil/index.php?id=".$_SESSION['id']);
}

if (isset($_POST['update_console']) and !empty($_POST['update_console'])) {
    $update_console = $_POST['update_console'];
    update('annonce', 'console', $update_console, $getAnnonce);
    header("Location: ../profil/index.php?id=".$_SESSION['id']);
}

if (isset($_FILES['update_photo']) and !empty($_FILES['update_photo']['name'])) {
    $tailleMax = 2097152;
    $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
    if ($_FILES['update_photo']['size'] <= $tailleMax) {
        $extensionUpload = strtolower(substr(strrchr($_FILES['update_photo']['name'], '.'), 1));
        if (in_array($extensionUpload, $extensionsValides)) {
            $chemin = "/assets/membres/annonce/" . $getAnnonce . "." . $extensionUpload;
            $resultat = move_uploaded_file($_FILES['update_photo']['tmp_name'], $chemin);
            if ($resultat) {
                $updatephoto = $bdd->prepare("UPDATE annonce SET photo = :update_photo WHERE numeroAnnonce ='$getAnnonce'");
                $updatephoto->execute([
                    'update_photo' => $getAnnonce . "." . $extensionUpload,
                ]);
                header("Location: ../profil/index.php?id=".$_SESSION['id']);
            } else {
                $msg = "Erreur durant l'importation de votre photo";
            }
        } else {
            $msg = "Votre photo doit être au format jpg, jpeg, gif ou png";
        }
    } else {
        $msg = "Votre photo ne doit pas dépasser 2Mo";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
    <title>Modifié votre annonce zigaming</title>
</head>

<body>
    <!-- HEADER -->
    <?php
    if (isset($_SESSION['id'])) {
        include "../../partials/php/headerCo.php";
    } else {
        include "../../partials/php/header.php";
    }
    ?>

    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="contener">
            <?php
            if (isset($_SESSION['id'])) {
            ?>
            <!-- CASES -->
            <div id="case-container">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="case">
                        <div class="case-img">
                            <input type="file" name="update_photo" id="form-entry-img">
                        </div>
                        <div class="case-infos">
                            <div class="case-infos-titre">
                                <input type="text" name="update_titre" id="form-entry-titre" value="<?php echo $userinfo['titre']; ?>" />
                            </div>
                            <div class="case-infos-description">
                                <textarea name="update_description" id="form-entry-description"><?php echo stripslashes($userinfo['descriptionJeu']); ?></textarea>
                            </div>
                            <div class="case-infos-console">
                                <select name="update_console" id="form-entry-console">
                                    <option>PS4</option>
                                    <option>XBOXONE</option>
                                    <option>PS3</option>
                                    <option>xbox360</option>
                                </select>
                            </div>
                        </div>
                        <div class="case-price">
                            <input type="text" name="update_prix" value="<?php echo $userinfo['prix']; ?>" id="form-entry-prix"/>€
                        </div>
                    </div>
                    <input type="submit" id="form-entry-submit" name="submit_annonce" value="Modifier">
                </form>
            </div>
            <?php
            } else {
                header('Location: ../login/');
            }
            ?>
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