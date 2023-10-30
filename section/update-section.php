<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant la modification d'une section
 */

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idSection = $_GET['idSection'] ?? '';

if (!$idSection) {
    header('Location: /');
} else {
    include_once(__DIR__ . "/../database.php");

    include_once(__DIR__ . "/../login/isLoggedin.php");
    $currentUser = isLoggedIn();
    if (!$currentUser || $currentUser['useAdministrator'] === "0") {
        header('HTTP/1.0 403 Forbidden', true, 403);
        require_once(__DIR__ . "/../includes/403.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include_once(__DIR__ . "/../validation-form.php");
        $result = validationSectionForm();
        $errors = $result["errors"];
        $name = $result["name"];

        if (count($errors) === 0) {
            Database::getInstance()->updateSection($idSection, $name);
            header('Location: /section/manage-section.php');
        }
    } else {

        $section = Database::getInstance()->getOneSection($idSection);
        $name = $section["secName"];
        $errors = [];
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
        <h2>Modifier un enseignant</h2>
        <form style="width:50%" method="POST" action="update-section.php?idSection=<?= $idSection ?>">
            <?php include_once(__DIR__ . "/../includes/section/form-add-update.inc.php"); ?>
        </form>
        <?php require_once __DIR__ . '/../includes/footer.inc.php' ?>
    </div>
</body>

</html>