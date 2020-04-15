<?php
session_start();

try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=zigaming;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $id_message = intval($_GET['id']);
        $msg = $bdd->prepare('DELETE FROM messages WHERE id = ? AND id_destinataire = ?');
        $msg->execute(array($_GET['id'], $_SESSION['id']));
        header('Location:../receptionMessage/');
    }
}
?>