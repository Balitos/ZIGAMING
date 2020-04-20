<?php

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'dbu525275', '^pc%MAjwsWVhc3pM', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if(isset($_GET['pseudo'], $_GET['key']) AND !empty($_GET['pseudo']) AND !empty($_GET['key']))
{
    $pseudo = htmlspecialchars(urldecode($_GET['pseudo']));
    $key = htmlspecialchars($_GET['key']);

    $requser = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? AND confirmkey = ?");
    $requser->execute(array($pseudo, $key));
    $userexist = $requser->rowCount();

    if($userexist == 1)
    {
        $user = $requser->fetch();
        if($user['confirme'] == 0)
        {
            $updateuser = $bdd->prepare("UPDATE membres SET confirme = 1 WHERE pseudo = ? AND confirmkey = ?");
            $updateuser->execute(array($pseudo, $key));
            echo "Votre compte a bien été confirmé !";
        }
        else
        {
            echo "Votre compte a déjà été confirmé !";
        }
    }
    else
    {
        echo "L'utilisateur n'existe pas !";
    }
}
?>