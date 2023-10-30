<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant l'affichage et la gestion (CRUD) des enseignants
 */

session_start();

include_once(__DIR__ . "/login/isLoggedin.php");

// Récupère l'utilisteur connecté (si il existe un cookie)
$currentUser = isLoggedIn();

const ERROR_USERNAME_REQUIRED = "Veuillez renseigner le champ nom de l'utilisateur";
const ERROR_PASSWORD_REQUIRED = "Veuillez renseigner le champ mot de passe";
const ERROR_LENGTH = "Le champ doit avoir un nombre de caractères entre 2 et 30";
const ERRO_USER_NOT_FOUND = "L'utilisateur n'existe pas";

// Si pas d'utilisateur connecté ...
if (!$currentUser) {

    $loginErrors = [];
    $username = '';
    $password = '';

    // Si la requête HTTP est un POST pour l'autentification
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Désinfecte les données saisies par l'utilisateur
        $input = filter_input_array(INPUT_POST, [
            'username' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);

        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        // Détermine les erreurs de saisies lors de l'authentification
        if (!$username) {
            $loginErrors['username'] = ERROR_USERNAME_REQUIRED;
        } elseif (mb_strlen($username) < 2 || mb_strlen($username) > 30) {
            $loginErrors['username'] = ERROR_LENGTH;
        }
        if (!$password) {
            $loginErrors['password'] = ERROR_PASSWORD_REQUIRED;
        } elseif (mb_strlen($password) < 2 || mb_strlen($password) > 30) {
            $loginErrors['password'] = ERROR_LENGTH;
        }

        // Si pas d'erreur 
        if (sizeof($loginErrors) == 0) {

            // On recherche le user à partir du username/password saisies
            include_once(__DIR__ . "/database.php");
            $user = Database::getInstance()->getOneUser($username);

            // Si un user existe
            if ($user && password_verify($password, $user['usePassword'])) {

                // Création de la session
                $sessionId = Database::getInstance()->createSession($user['idUser']);

                // Session de 30 jours
                setcookie('session', $sessionId, time() + 60 * 60 * 24 * 30, "", "", false, true);

                // redirection sur la home page
                header('Location: /index.php');

                // si aucun user trouvé à partir du username/password saisies
            } else {
                $loginErrors['userNotFound'] = ERRO_USER_NOT_FOUND;
            }
        }
    }

    // Si utilisateur connecté ...
} else {

    // On récupére la liste des enseignants
    include_once(__DIR__ . "/database.php");
    $teachers = Database::getInstance()->getAllTeachers();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once(__DIR__ . "/includes/head.inc.php"); ?>
</head>

<body>
    <div class="container">
        <?php require_once(__DIR__ . "/includes/header.inc.php"); ?>
        <?php if ($currentUser): ?>
            <h2>Liste des enseignants</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Surnom</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($teachers as $teacher) {
                        $html = "<tr>";
                        $html .= "<td>" . $teacher["teaName"] . " " . $teacher["teaFirstname"] . "</td>";
                        $html .= "<td>" . $teacher["teaNickname"] . "</td>";
                        $html .= "<td>";
                        if ($currentUser && $currentUser['useAdministrator']) {
                            $html .= "<a href=teacher/update-teacher.php?idTeacher=" . $teacher["idTeacher"] . "><i class=\"bi bi-pencil\"></i></a>";
                            $html .= " <a ";
                            $html .= " onclick=\"return confirm('Etes-vous sûr de vouloir supprimer l\'enseignant " . $teacher["teaFirstname"] . " " . $teacher["teaName"] . "?');\" ";
                            $html .= " href=teacher/delete-teacher.php?idTeacher=" . $teacher["idTeacher"] . "><i class=\"bi bi-trash\"></i></a>";
                        }
                        $html .= " <a href=teacher/detail-teacher.php?idTeacher=" . $teacher["idTeacher"] . "><i class=\"bi bi-search\"></i></a></td>";
                        $html .= "</tr>";
                        echo $html;
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <h3>Vous devez vous identifier avec un des utilisateurs suivants :</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Password</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Albert</td>
                        <td>Albert</td>
                        <td>User</td>
                    </tr>
                    <tr>
                        <td>Edouard</td>
                        <td>Edouard</td>
                        <td>Admin</td>
                    </tr>
                </tbody>
            </table>


        <?php endif ?>
        <?php require_once(__DIR__ . "/includes/footer.inc.php"); ?>


        <?php

        //Call getenv() function without argument
        
        $env_array = getenv();

        echo "<h3>The list of environment variables with values are :</h3>";

        //Print all environment variable names with values
        
        foreach ($env_array as $key => $value) {

            echo "$key => $value <br />";

        }

        ?>

    </div>

</body>

</html>