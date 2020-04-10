<?php
if(!isset($_SESSION['id']) AND isset($_COOKIE['email'], $_COOKIE['password']) AND !empty($_COOKIE['email']) AND !empty($_COOKIE['password'])){
    $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
    $requser->execute(array($_COOKIE['email']));
    $userexist = $requser->rowCount();
    $result = $requser->fetch();
    if($userexist == 1)
    {
        $_SESSION['id'] = $result['id'];
        $_SESSION['pseudo'] = $result['pseudo'];
        $_SESSION['mail'] = $result['mail'];
    }
}
?>