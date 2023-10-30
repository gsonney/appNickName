<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant la suppression d'une section
 */

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idSection = $_GET['idSection'] ?? '';

// Si il n'y a pas de idSection dans la requête en GET alors on redirige sur la homepage
if (!$idSection) {
    header('Location: /');
} else {

    // Récupère l'utilisateur connecté (si il existe)
    include_once(__DIR__ . "/../login/isLoggedin.php");
    $currentUser = isLoggedIn();

    // Si pas d'utilisateur ou pas les droits admin
    if (!$currentUser || $currentUser['useAdministrator'] === "0") {
        header('HTTP/1.0 403 Forbidden', true, 403);
        require_once(__DIR__ . "/../includes/403.php");
        exit;
    }

    // Suppression de la section
    include_once(__DIR__ . "/../database.php");
    $teacher = Database::getInstance()->deleteSection($idSection);
    header('Location: /section/manage-section.php');
}
