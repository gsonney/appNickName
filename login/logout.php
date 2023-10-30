<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fonction permettant de déconnecté un utilisateur
 */

// On récupère l'id de la session (table t_session) stocké dans le cookie session
$sessionId = $_COOKIE['session'] ?? '';

if ($sessionId) {
    include_once(__DIR__ . "/../database.php");

    // on supprime le record correspondant dans la table t_session
    Database::getInstance()->deleteSession($sessionId);

    // on invalide le cookie
    setcookie('session', '', time() - 1);

    // on redirige sur la home page
    header('Location: /index.php');
}
