<?php

if(isset($_POST['mailform']))
{
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $mail = htmlspecialchars($_POST['mail']);
    $message = htmlspecialchars($_POST['message']);
    if(!empty($nom) AND !empty($mail) AND !empty($message))
    {
        $header="MIME-Version: 1.0\r\n";
        $header.='From:"zigaming.com"<llorens.31600@gmail.com>'."\n";
        $header.='Content-Type:text/html; charset="utf-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';
    
        $message='
        <html>
        <head>
            <meta charset="utf-8" />
        </head>
            <body>
                <div align="center">
                    <br />
                    <u>Nom de l\'expéditeur : </u>'.$nom.'<br />
                    <u>Prénom de l\'expéditeur : </u>'.$prenom.'<br />
                    <u>Mail de l\'expéditeur : </u>'.$mail.'<br />
                    <br />
                    '.nl2br($message).'
                    <br />
                </div>
            </body>
        </html>
        ';
    
        mail("llorens.31600@gmail.com", "Contact", $message, $header);
        $msg = "Votre message a bien été envoyé !";
    }
    else
    {
        $msg = "Tous les champs doivent être complétés !";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    include "../../partials/php/head.php";
    ?>
    <title>Support - zigaming</title>
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
            <!-- CONTACT -->
            <h2 id="form-title">Formulaire de contact</h2>
            <div id="contact-wrap">
                <div class="contact-box">
                    <form id="form" action="" method="post">
                        <label>Nom</label>
                        <input class="form-item" type="text" name="nom" value="<?php if(isset($_POST['nom'])) { echo $_POST['nom']; } ?>">
                        <label>Prénom</label>
                        <input class="form-item" type="text" name="prenom" value="<?php if(isset($_POST['prenom'])) { echo $_POST['prenom']; } ?>">
                        <label>Email</label>
                        <input class="form-item" type="email" name="mail" value="<?php if(isset($_POST['mail'])) { echo $_POST['mail']; } ?>">
                        <label>Votre message</label>
                        <textarea class="form-item" name="message"><?php if(isset($_POST['message'])) { echo $_POST['message']; } ?></textarea>
                        <input type="submit" value="Envoyer" name="mailform" id="submit">
                    </form>
                    <div id="msg-box">
                        <?php
                        if(isset($msg))
                        {
                            echo $msg;
                        }
                        ?>
                    </div>
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