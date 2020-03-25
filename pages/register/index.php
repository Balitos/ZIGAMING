<?php
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if(isset($_POST['register_submit']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);

    $pseudolength = strlen($pseudo);
    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {
        if($pseudolength <= 255)
        {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                $reqmail->execute(array($mail));
                $mailExist = $reqmail->rowCount();
                if($mailExist == 0)
                {
                    $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?");
                    $reqpseudo->execute(array($pseudo));
                    $pseudoExist = $reqpseudo->rowCount();
                    if($pseudoExist == 0)
                    {
                        if($mdp == $mdp2)
                        {
                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, mot_de_passe) VALUES(?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $mail, $mdp));
                            header('Location: ../../');
                        }
                        else
                        {
                            $erreur = "Vos mots de passe ne correspondent pas !";
                        }
                    }
                    else
                    {
                        $erreur = "Pseudo déjà utilisée !";
                    }
                }
                else
                {
                    $erreur = "Adresse mail déjà utilisée !";
                }
            }
            else
            {
                $erreur = "Votre addresse mail n'est pas valide";
            }
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
                <h1>Devient un membre de la famille</h1>
                <div class="register-form-inputs">
                    <div class="register-input-box">
                        <i class="fas fa-user"></i>
                        <input type="text" name="pseudo" placeholder="Pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>">
                    </div>

                    <div class="register-input-box">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="mail" placeholder="Email" value="<?php if(isset($mail)) { echo $mail; } ?>">
                    </div>

                    <div class="register-input-box">
                        <i class="fas fa-unlock"></i>
                        <input type="password" name="mdp" placeholder="Mot de passe">
                    </div>

                    <div class="register-input-box">
                        <i class="fas fa-unlock"></i>
                        <input type="password" name="mdp2" placeholder="Confirmez votre mot de passe">
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
                <button class="form-submit" type="submit" name="register_submit">Créer</button>
                <p class="register-login">ou <a href="../login/" title="Login">Se connecter</a></p>
            </form>
        </div>
    </div>
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>