<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if(isset($_POST['connect_submit']))
{
    $mailConnect = htmlspecialchars($_POST['mailConnect']);
    $mdpConnect = sha1($_POST['mdpConnect']);
    if(!empty($mailConnect) AND !empty($mdpConnect))
    {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND mot_de_passe = ?");
        $requser->execute(array($mailConnect, $mdpConnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: ../profil/index.php?id=".$_SESSION['id']);
        }
        else
        {
            $erreur = "Mauvais mail ou mot de passe !";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés !";
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
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- FORMULAIRE -->
        <div id="formulaire">
            <form method="POST" action="">
                <h1>Bon retour parmis nous</h1>
                <div class="register-form-inputs">
                    <div class="register-input-box">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="mailConnect" placeholder="Email" value="<?php if(isset($mail)) { echo $mail; } ?>">
                    </div>

                    <div class="register-input-box">
                        <i class="fas fa-unlock"></i>
                        <input type="password" name="mdpConnect" placeholder="Mot de passe">
                    </div>

                </div>
                <div id="gestion-erreurs">
                    <?php
                        if(isset($erreur))
                        {
                            echo $erreur;
                        }
                    ?>
                </div>
                <button class="form-submit" type="submit" name="connect_submit">Connection</button>
                <p class="register-login">ou <a href="../register/" title="Login">Créer un compte</a></p>
            </form>
        </div>
    </div>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>