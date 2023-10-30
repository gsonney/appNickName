<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fonction permettant de récupérer l'utilisateur connecté
 */

/**
 * Cette fonction permet de récupérer l'id de la session (table t_session) présent dans le cookie 'session'
 * lorsqu'un utilisateur s'est précédement connecté. 
 * Avec l'id de session, on peut récupérer le record correspondant dans la table t_session. 
 * Comme la table t_session possède uniquement 2 champs:
 * - id de la session
 * - id de l'utilisateur
 * on peut récupérer le record de l'utilisateur correspondant
 */
function isLoggedIn()
{

    // Récupère l'id de session dans le cookie
    $sessionId = $_COOKIE['session'] ?? '';

    if ($sessionId) {
        include_once(__DIR__ . "/../database.php");
        // Récupére la session en DB grâce à l'id de session
        $session = Database::getInstance()->getOneSession($sessionId);

        if ($session) {
            // Récupère le user grâce à l'id du user contenu dans la session
            $user = Database::getInstance()->getOneUserById($session['idUser']);
        }
    }
    return $user ?? false;
}
