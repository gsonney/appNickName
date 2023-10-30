<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant l'ajout d'un nouvel enseignant
 */

include_once(__DIR__ . "/../login/isLoggedin.php");
$currentUser = isLoggedIn();

$userData = [
    "gender" => '',
    "firstName" => '',
    "lastName"  => '',
    "nickname"  => '',
    "origine"  => '',
    "section"  => '',
];

$errors  = [];

if (!$currentUser || $currentUser['useAdministrator'] === "0") {
    header('HTTP/1.0 403 Forbidden', true, 403);
    require_once(__DIR__ . "/../includes/403.php");
    exit;
}

include_once(__DIR__ . "/../database.php");
$sections = Database::getInstance()->getAllSections();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include_once(__DIR__ . "/../validation-form.php");
    $result = validationTeacherForm();
    $errors = $result["errors"];
    $userData = $result["userData"];

    // Si aucune erreur de validation 
    // Cela signifie que les données sont propres et validées
    // Nous pouvons insérer les données en BD
    if (count($errors) === 0) {
        Database::getInstance()->insertTeacher($userData);
        header("Location: /index.php");
    }
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
        <h2>Ajout d'un enseignant</h2>
        <form class="mt-4" style="width:50%" method="POST" action="add-teacher.php">
            <?php include_once(__DIR__ . "/../includes/teacher/form-add-update.inc.php"); ?>
        </form>
        <?php require_once __DIR__ . '/../includes/footer.inc.php' ?>
    </div>
</body>

</html>