<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant la modification d'un enseignant
 */

include_once(__DIR__ . "/../database.php");

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idTeacher = $_GET['idTeacher'] ?? '';

if (!$idTeacher) {
    header('Location: /');
} else {

    include_once(__DIR__ . "/../login/isLoggedin.php");
    $currentUser = isLoggedIn();
    if (!$currentUser || $currentUser['useAdministrator'] === "0") {
        header('HTTP/1.0 403 Forbidden', true, 403);
        require_once(__DIR__ . "/../includes/403.php");
        exit;
    }

    $sections = Database::getInstance()->getAllSections();
    $teacher = Database::getInstance()->getOneTeacher($idTeacher);

    $userData = [
        "gender"    => $teacher["teaGender"],
        "firstName" => $teacher["teaFirstname"],
        "lastName"  => $teacher["teaName"],
        "nickname"  => $teacher["teaNickname"],
        "origine"   => $teacher["teaOrigine"],
        "section"   => $teacher["fkSection"],
    ];

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include_once(__DIR__ . "/../validation-form.php");
        $result = validationTeacherForm();
        $errors = $result["errors"];
        $userData = $result["userData"];

        if (count($errors) === 0) {
            $_POST["idTeacher"] = $idTeacher;
            Database::getInstance()->updateTeacher($_POST);
            header('Location: /index.php');
        }
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
        <form style="width:50%" method="POST" action="update-teacher.php?idTeacher=<?= $teacher["idTeacher"] ?>">
            <?php include_once(__DIR__ . "/../includes/teacher/form-add-update.inc.php"); ?>
        </form>
        <?php require_once __DIR__ . '/../includes/footer.inc.php' ?>
    </div>
</body>

</html>