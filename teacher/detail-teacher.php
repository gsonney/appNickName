<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant d'afficher les détails d'un enseignant
 */

include_once(__DIR__ . "/../database.php");

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idTeacher = $_GET['idTeacher'] ?? '';
if (!$idTeacher) {
    header('Location: /');
} else {
    include_once(__DIR__ . "/../login/isLoggedin.php");
    $currentUser = isLoggedIn();

    if (!$currentUser) {
        header('HTTP/1.0 403 Forbidden', true, 403);
        require_once(__DIR__ . "/../includes/403.php");
        exit();
    }

    // Get teacher
    $teacher = Database::getInstance()->getOneTeacher($idTeacher);

    // Get icon gender https://icons8.com/icons/set/gender
    $genderIcon = "";
    if ($teacher["teaGender"] === "w") {
        $genderIcon = "../images/female.png";
    } else if ($teacher["teaGender"] === "m") {
        $genderIcon = "../images/male.png";
    } else {
        $genderIcon = "../images/other.png";
    }

    // Get section
    $section = Database::getInstance()->getOneSection($teacher['fkSection']);
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

        <table>
            <tbody>
                <tr>
                    <td>
                        <h2>Détail : <?= $teacher['teaFirstname'] . " " . $teacher['teaName'] ?></h2>
                    </td>
                    <td><img width="40%" src="<?= $genderIcon ?>"></td>
                    <td><?= $section['secName'] ?></td>
                    <td>
                        <?php
                        if ($currentUser['useAdministrator'] === "1") {
                            $html  = "<a href=update-teacher.php?idTeacher=" . $teacher["idTeacher"] . "><i class=\"bi bi-pencil\"></i></a>";
                            $html .= " <a onclick=\"return confirm('Etes-vous sûr de vouloir supprimer l\'enseignant ?');\" href=delete-teacher.php?idTeacher=" . $teacher["idTeacher"] . "><i class=\"bi bi-trash\"></i></a>";
                            echo $html;
                        }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <p>Surnom : <?= $teacher["teaNickname"] ?></p>
        <p><?= $teacher["teaOrigine"] ?></p>

        <p><a href="../index.php">Retour à la page d'accueil</a></p>
        <?php require_once __DIR__ . '/../includes/footer.inc.php' ?>
    </div>
</body>

</html>