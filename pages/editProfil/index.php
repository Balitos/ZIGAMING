<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_SESSION['id'])) {
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();

    if (isset($_POST['newpseudo']) and !empty($_POST['newpseudo']) and $_POST['newpseudo'] != $user['pseudo']) {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $pseudolength = strlen($newpseudo);
        if ($pseudolength <= 255) {
            $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?");
            $reqpseudo->execute(array($newpseudo));
            $pseudoExist = $reqpseudo->rowCount();
            if ($pseudoExist == 0) {
                $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
                $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
                header('Location: ../profil/index.php?id=' . $_SESSION['id']);
            } else {
                $msg = "Pseudo déjà utilisée !";
            }
        }
    }

    if (isset($_POST['newmail']) and !empty($_POST['newmail']) and $_POST['newmail'] != $user['mail']) {
        $newmail = htmlspecialchars($_POST['newmail']);
        if (filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
            $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
            $reqmail->execute(array($newmail));
            $mailExist = $reqmail->rowCount();
            if ($mailExist == 0) {
                $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
                $insertmail->execute(array($newmail, $_SESSION['id']));
                header('Location: ../profil/index.php?id=' . $_SESSION['id']);
            } else {
                $msg = "Adresse mail déjà utilisée !";
            }
        } else {
            $msg = "Votre addresse mail n'est pas valide";
        }
    }

    if (isset($_POST['adresse']) and !empty($_POST['adresse'])) {
        $adresse = htmlspecialchars($_POST['adresse']);
        $adresseLength = strlen($adresse);
        if ($adresseLength <= 255) {
            $insertadresse = $bdd->prepare("UPDATE membres SET adresse = ? WHERE id = ?");
            $insertadresse->execute(array($adresse, $_SESSION['id']));
            header('Location: ../profil/index.php?id=' . $_SESSION['id']);
        }
    }


    if (isset($_POST['descriptionProfil']) and !empty($_POST['descriptionProfil'])) {
        $descriptionProfil = htmlspecialchars($_POST['descriptionProfil']);
        $descriptionProfilLength = strlen($descriptionProfil);
        if ($descriptionProfilLength <= 255) {
            $insertdescriptionProfil = $bdd->prepare("UPDATE membres SET descriptionProfil = ? WHERE id = ?");
            $insertdescriptionProfil->execute(array($descriptionProfil, $_SESSION['id']));
            header('Location: ../profil/index.php?id=' . $_SESSION['id']);
        }
    }

    if (isset($_POST['newmdp1']) and !empty($_POST['newmdp1']) and isset($_POST['newmdp2']) and !empty($_POST['newmdp2'])) {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);

        if ($mdp1 == $mdp2) {
            $insertmdp = $bdd->prepare("UPDATE membres SET mot_de_passe = ? WHERE id = ?");
            $insertmdp->execute(array($mdp1, $_SESSION['id']));
            header('Location: ../profil/index.php?id=' . $_SESSION['id']);
        } else {
            $msg = "Vos mots de passe ne correspondent pas !";
        }
    }

    if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {
        $tailleMax = 2097152;
        $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
        if ($_FILES['avatar']['size'] <= $tailleMax) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if (in_array($extensionUpload, $extensionsValides)) {
                $chemin = "../../assets/membres/avatars/" . $_SESSION['id'] . "." . $extensionUpload;
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                if ($resultat) {
                    $updateavatar = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE id = :id');
                    $updateavatar->execute(array(
                        'avatar' => $_SESSION['id'] . "." . $extensionUpload,
                        'id' => $_SESSION['id']
                    ));
                    header('Location: ../profil/index.php?id=' . $_SESSION['id']);
                } else {
                    $msg = "Erreur durant l'importation de votre avatar";
                }
            } else {
                $msg = "Votre avatar doit être au format jpg, jpeg, gif ou png";
            }
        } else {
            $msg = "Votre avatar ne doit pas dépasser 2Mo";
        }
    }
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
            <!-- EDITION PROFIL -->
            <h2>Edition de mon profil</h2>
            <div id="ed-profil">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-section">
                        <div id="form-avatar">
                            <label>Avatar</label>
                            <div id="form-avatar-img">
                                <img src="/assets/images/photo-avatar-profil.png" alt="Avatar profil">
                                <input type="file" name="avatar">
                            </div>
                        </div>
                        <div class="form-field">
                            <label>Pseudo</label>
                            <input type="text" name="newpseudo" value="<?php echo $user['pseudo']; ?>" />
                        </div>
                        <div class="form-field">
                            <label>Description profil</label>
                            <textarea name="descriptionProfil"><?php echo $user['descriptionProfil']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-section">
                        <div class="form-field">
                            <label>Mail</label>
                            <input type="text" name="newmail" value="<?php echo $user['mail']; ?>" />
                        </div>
                        <div class="form-field">
                            <label>Adresse</label>
                            <input type="text" name="adresse" value="<?php echo $user['adresse']; ?>"/>
                        </div>

                        <div class="form-field">
                            <label>Mot de passe</label>
                            <input type="password" name="newmdp1"/>
                        </div>
                        <div class="form-field">
                            <label>Confirmation mot de passe</label>
                            <input type="password" name="newmdp2"/>
                        </div>
                        <input type="submit" value="Mettre à jour" id="submit">
                    </div>
                </form>
                <?php if (isset($msg)) {
                    echo $msg;
                } ?>
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
    header("Location: ../login/");
}
?>