<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: ce fichier permet de factoriser le HTML du formulaire permettant l'ajout et la mise à jour d'un enseignant
 */

?>

<div class="mb-3 mt-3">

    <input class="form-check-input" type="radio" name="gender" value="m" id="m" <?php if ($userData["gender"] == "m") :
                                                                                    echo "checked";
                                                                                endif; ?>>
    <label class="form-check-label" for="m">
        Homme
    </label>

    <input class="form-check-input" type="radio" name="gender" value="w" id="w" <?php if ($userData["gender"] == "w") :
                                                                                    echo "checked";
                                                                                endif; ?>>
    <label class="form-check-label" for="w">
        Femme
    </label>

    <input class="form-check-input" type="radio" name="gender" value="o" id="o" <?php if ($userData["gender"] == "o") :
                                                                                    echo "checked";
                                                                                endif; ?>>
    <label class="form-check-label" for="o">
        Autre
    </label>

    <span id="show-error">
        <?= array_key_exists("gender", $errors) && $errors["gender"] ? '<p style="color:red;">' . $errors["gender"] . '</p>' : '' ?>
    </span>
</div>
<div class="mb-3">
    <label for="lastName" class="form-label">Nom</label>
    <input type="text" class="form-control" id="lastName" aria-describedby="nameHelp" name="lastName" value="<?= $userData["lastName"] ?>">
    <span id="show-error">
        <?= array_key_exists("lastName", $errors) && $errors["lastName"] ? '<p style="color:red;">' . $errors["lastName"] . '</p>' : '' ?>
    </span>
</div>
<div class="mb-3">
    <label for="firstName" class="form-label">Prénom</label>
    <input type="text" class="form-control" id="firstName" aria-describedby="firstNameHelp" name="firstName" value="<?= $userData["firstName"] ?>">
    <span id="show-error">
        <?= array_key_exists("firstName", $errors) && $errors["firstName"] ? '<p style="color:red;">' . $errors["firstName"] . '</p>' : '' ?>
    </span>
</div>
<div class="mb-3">
    <label for="nickname" class="form-label">Surnom</label>
    <input type="text" class="form-control" id="nickname" aria-describedby="nicknameHelp" name="nickname" value="<?= $userData["nickname"] ?>">
    <span id="show-error">
        <?= array_key_exists("nickname", $errors) && $errors["nickname"] ? '<p style="color:red;">' . $errors["nickname"] . '</p>' : '' ?>
    </span>
</div>
<div class="mb-3">
    <label for="origine">Origine</label>
    <textarea class="form-control" placeholder="Saisir ici l'origine du surnom" id="origine" name="origine"><?= $userData["origine"] ?></textarea>
    <span id="show-error">
        <?= array_key_exists("origine", $errors) && $errors["origine"] ? '<p style="color:red;">' . $errors["origine"] . '</p>' : '' ?>
    </span>
</div>
<select name="section" class="form-select mb-3" aria-label="section">
    <option <?php if ($userData["section"] === "") {
                echo "selected";
            } ?>>Section</option>
    <?php
    $html = "";
    foreach ($sections as $section) {
        $html .= "<option ";
        if ($userData["section"] === $section["idSection"]) {
            $html .= " selected ";
        }
        $html .= "value=\"" . $section["idSection"] . "\">" . $section["secName"] . "</option>";
    }
    echo $html;
    ?>
</select>
<span id="show-error">
    <?= array_key_exists("section", $errors) && $errors["section"] ? '<p style="color:red;">' . $errors["section"] . '</p>' : '' ?>
</span>
<button type="submit" class="btn btn-primary">Enregistrer</button>