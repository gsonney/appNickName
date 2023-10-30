<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant la suppression d'un enseignant
 */

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idTeacher = $_GET['idTeacher'] ?? '';

// Si il n'y a pas de idTeacher dans la requête en GET alors on redirige sur la homepage
if (!$idTeacher) {
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

    // Suppression de l'enseignant
    include_once(__DIR__ . "/../database.php");
    $teacher = Database::getInstance()->deleteTeacher($idTeacher);
    header('Location: /index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once(__DIR__ . "/../includes/head.inc.php"); ?>
</head>

<body>
    <div class="container">
        <?php require_once __DIR__ . '/../includes/header.inc.php' ?>
        <h2>Détail : <?= $teacher['teaFirstname'] . " " . $teacher['teaName'] . " " . $teacher['teaGender'] ?></h2>
        <p>Surnom : <?= $teacher["teaNickname"] ?></p>
        <p><?= $teacher["teaOrigine"] ?></p>
        <?php require_once __DIR__ . '/../includes/footer.php' ?>
    </div>
</body>

</html>