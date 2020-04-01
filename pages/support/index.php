<?php

if(isset($_POST['mailform']))
{
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
    $message = htmlspecialchars($_POST['message']);
    if(!empty($nom) AND !empty($mail) AND !empty($message))
    {
        $header="MIME-Version: 1.0\r\n";
        $header.='From:"ZIgaming.com"<support@ZIgaming.com>'."\n";
        $header.='Content-Type:text/html; charset="utf-8"'."\n";
        $header.='Content-Transfer-Encoding: 8bit';
    
        $message='
        <html>
            <body>
                <div align="center">
                    <br />
                    <u>Nom de l\'expéditeur :</u>'.$nom.'<br />
                    <u>Mail de l\'expéditeur :</u>'.$mail.'<br />
                    <br />
                    '.nl2br($message).'
                    <br />
                </div>
            </body>
        </html>
        ';
    
        mail("support.zigaming@gmail.com", "Contact", $message, $header);
        $msg = "Votre message a bien été envoyé !";
    }
    else
    {
        $msg = "Tous les champs doivent être complétés !";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Formulaire de contact</h2>
    <form method="POST" action="">
        <input type="text" name="nom" placeholder="Votre nom" value="<?php if(isset($_POST['nom'])) { echo $_POST['nom']; } ?>"><br><br>
        <input type="email" name="mail" placeholder="Votre mail" value="<?php if(isset($_POST['mail'])) { echo $_POST['mail']; } ?>"><br><br>
        <textarea name="message" placeholder="Votre message"><?php if(isset($_POST['message'])) { echo $_POST['message']; } ?></textarea><br><br>
        <input type="submit" value="Envoyer" name="mailform">
    </form>
    <?php
    if(isset($msg))
    {
        echo $msg;
    }
    ?>
</body>
</html>