<?php
session_start();

try {
    $bdd = new PDO('mysql:host=db5000380300.hosting-data.io;dbname=dbs367003;charset=utf8', 'dbu525275', '^pc%MAjwsWVhc3pM', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

include_once('cookieconnect.php');

if(isset($_POST['connect_submit']))
{
    $mailConnect = htmlspecialchars($_POST['mailConnect']);
    $mdpConnect = $_POST['mdpConnect'];
    $hashedpass = password_hash($mdpConnect, PASSWORD_DEFAULT);
    if(!empty($mailConnect) AND !empty($mdpConnect))
    {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
        $requser->execute(array($mailConnect));
        $userexist = $requser->rowCount();
        $result = $requser->fetch();
        if($userexist == 1 && password_verify($mdpConnect, $result['mot_de_passe']))
        {
            $confirme = $result['confirme'];
            if($confirme == 1)
            {
                if(isset($_POST['rememberme'])){
                    setcookie('email', $mailConnect, time()+365*24*3600, null, null, false, true);
                    setcookie('password', $hashedpass, time()+365*24*3600, null, null, false, true);
                }
                $_SESSION['id'] = $result['id'];
                $_SESSION['pseudo'] = $result['pseudo'];
                $_SESSION['mail'] = $result['mail'];
                header("Location: ../profil/index.php?id=".$_SESSION['id']);
            }
            else
            {
                $erreur = "Veuillez confirmer votre compte !";
            }
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
    <title>zigaming - connexion</title>
</head>

<body>
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
            <div id="rester-connecte">
                <input type="checkbox" name="rememberme" id="remembercheckbox"><label for="remembercheckbox">Se souvenir de moi</label>
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
            <p class="mdp_oublie"><a href="../recuperation/">Mot de passe oublié</a></p>
        </form>
    </div>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>