<!-- HEADER -->
<header>
    <h1 style="float:left;">Surnom des enseignants</h1>
    <?php if ($currentUser) :
        if ($currentUser['useAdministrator']) {
            $role = "admin";
        } else {
            $role = "user";
        }
    ?>
        <p style="padding-top: 20px;padding-left:50%;">
            <?= $currentUser['useLogin'] . " (" . $role . ")" ?>
            <a style="margin-left:5px;" class="btn btn-warning" href="/login/logout.php">Se déconnecter</a>
        </p>
        <hr style="clear:both" />

        <ul style="float:left; margin-right:30px;" class="header-menu">
            <li class=<?= $_SERVER['REQUEST_URI'] === '/teacher/nickname.php' ? 'active' : '' ?>>
                <a href="/index.php">Voir la liste des enseignants</a>
            </li>
            <?php if ($currentUser['useAdministrator']) : ?>
                <li class=<?= $_SERVER['REQUEST_URI'] === '/teacher/add-teacher.php' ? 'active' : '' ?>>
                    <a href="/teacher/add-teacher.php">Ajouter un nouvel enseignant</a>
                </li>
            <?php endif ?>
        </ul>
        <ul class="header-menu">
            <li class=<?= $_SERVER['REQUEST_URI'] === '/section/manage-section.php' ? 'active' : '' ?>>
                <a href="/section/manage-section.php">Voir la liste des sections</a>
            </li>
            <?php if ($currentUser['useAdministrator']) : ?>
                <li class=<?= $_SERVER['REQUEST_URI'] === '/section/add-section.php' ? 'active' : '' ?>>
                    <a href="/section/add-section.php">Ajouter une nouvelle section</a>
                </li>
            <?php endif ?>
        </ul>

        <hr style="clear:both" />

    <?php else : ?>
        <form style="padding-top: 20px;padding-left:50%" class="form-inline" method="POST" action="index.php">
            <input style="display:inline-block; width: auto;" type="text" name="username" class="form-control" value="<?= $username ?>" id="username" placeholder="nom d'utilisateur">
            <span id="show-error">
                <?= array_key_exists("username", $loginErrors) && $loginErrors["username"] ? '<p style="color:red;">' . $loginErrors["username"] . '</p>' : '' ?>
            </span>

            <input style="display:inline-block; width: auto;" type="password" name="password" class="form-control" value="<?= $password ?>" id="password" placeholder="mot de passe">
            <span id="password">
                <?= array_key_exists("password", $loginErrors) && $loginErrors["password"] ? '<p style="color:red;">' . $loginErrors["password"] . '</p>' : '' ?>
            </span>

            <?= array_key_exists("userNotFound", $loginErrors) && $loginErrors["userNotFound"] ? '<p style="color:red;">' . $loginErrors["userNotFound"] . '</p>' : '' ?>
            <input style="vertical-align:baseline" type="submit" name="login" class="btn btn-info" value="Se connecter">
        </form>
        <hr style="clear:both" />

    <?php endif; ?>

</header>