<?php
session_start();

include_once('../../partials/php/bdd.php');

if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $id_message = intval($_GET['id']);
        $msg = $bdd->prepare('DELETE FROM messages WHERE id = ? AND id_destinataire = ?');
        $msg->execute(array($_GET['id'], $_SESSION['id']));
        header('Location:../receptionMessage/');
    }
}
?>