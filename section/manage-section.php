<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant l'affichage et la gestion (CRUD) des sections
 */


include_once(__DIR__ . "/../login/isLoggedin.php");
$currentUser = isLoggedIn();
if (!$currentUser) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    require_once(__DIR__ . "/../includes/403.php");
    exit;
}

include_once(__DIR__ . "/../database.php");
$sections = Database::getInstance()->getAllSections();
$currentUser = isLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once(__DIR__ . "/../includes/head.inc.php"); ?>
</head>

<body>
    <div class="container">
        <?php require_once(__DIR__ . "/../includes/header.inc.php"); ?>
        <h2>Liste des sections</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($sections as $section) {
                    $html  = "<tr>";
                    $html .= "<td>" . $section["secName"] . "</td>";
                    $html .= "<td>";
                    if ($currentUser['useAdministrator']) {
                        $html .= "<a href=update-section.php?idSection=" . $section["idSection"]  . "><i class=\"bi bi-pencil\"></i></a>";
                        $html .= " <a onclick=\"return confirm('Etes-vous sûr de vouloir supprimer la section ?');\" href=delete-section.php?idSection=" . $section["idSection"] . "><i class=\"bi bi-trash\"></i></a> ";
                    }
                    $html .= "</td>";
                    $html .= "</tr>";
                    echo $html;
                }
                ?>
            </tbody>
        </table>
        <?php require_once(__DIR__ . '/../includes/footer.inc.php'); ?>
    </div>
</body>

</html>