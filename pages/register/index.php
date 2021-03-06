<?php
include_once('../../partials/php/bdd.php');

if(isset($_POST['register_submit']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
    $hashedpass = password_hash($mdp, PASSWORD_DEFAULT);
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
                            $longueurKey = 15;
                            $key = "";
                            for($i = 1 ; $i < $longueurKey ; $i++)
                            {
                                $key .= mt_rand(0, 9);
                            }

                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, mot_de_passe, confirmkey) VALUES(?, ?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $mail, $hashedpass, $key));
                            header('Location: ../login/');

                            $header="MIME-Version: 1.0\r\n";
                            $header.='From:"zigaming.com"<llorens.31600@gmail.com>'."\n";
                            $header.='Content-Type:text/html; charset="utf-8"'."\n";
                            $header.='Content-Transfer-Encoding: 8bit';
                        
                            $message='
                            <html>
                                <body>
                                    <div align="center">
                                        <a href="https://www.zigaming.fr/pages/confirmation/index.php?pseudo='.urlencode($pseudo).'&key='.$key.'">Confirmez votre compte !</a>
                                    </div>
                                </body>
                            </html>
                            ';
                            ini_set('llorens.31600@gmail.com','llorens.31600@gmail.com');
                            mail($mail, "Confirmation de compte", $message, $header);
                        }
                        else
                        {
                            $erreur = "Vos mots de passe ne correspondent pas !";
                        }
                    }
                    else
                    {
                        $erreur = "Pseudo d??j?? utilis??e !";
                    }
                }
                else
                {
                    $erreur = "Adresse mail d??j?? utilis??e !";
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
        $erreur = "Tous les champs doivent ??tre compl??t??s !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
    <title>Cr??er un compte sur zigaming</title>
</head>

<body>
    <!-- FORMULAIRE -->
    <div id="formulaire-container">
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
                <button class="form-submit" type="submit" name="register_submit">Cr??er</button>
                <p class="register-login">ou <a href="../login/" title="Login">Se connecter</a></p>
            </form>
        </div>
    </div>
    
    <!-- FONT AWESOME KIT -->
    <script src="https://kit.fontawesome.com/e6c2645393.js" crossorigin="anonymous"></script>
</body>

</html>