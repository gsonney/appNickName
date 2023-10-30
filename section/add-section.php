<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant l'ajout d'une nouvelle section
 */

include_once(__DIR__ . "/../login/isLoggedin.php");
$currentUser = isLoggedIn();
if (!$currentUser || $currentUser['useAdministrator'] === "0") {
    header('HTTP/1.0 403 Forbidden', true, 403);
    require_once(__DIR__ . "/../includes/403.php");
    exit;
}

include_once(__DIR__ . "/../database.php");
$sections = Database::getInstance()->getAllSections();

$name = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include_once(__DIR__ . "/../validation-form.php");
    $result = validationSectionForm();
    $errors = $result["errors"];
    $name = $result["name"];

    if (count($errors) === 0) {
        Database::getInstance()->insertSection($_POST);

        header("Location: /section/manage-section.php");
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
        <h2>Ajout d'une section</h2>
        <form class="mt-4" style="width:50%" method="POST" action="add-section.php">
            <?php require_once __DIR__ . '/../includes/section/form-add-update.inc.php' ?>
        </form>
        <?php require_once __DIR__ . '/../includes/footer.inc.php' ?>
    </div>
</body>

</html>