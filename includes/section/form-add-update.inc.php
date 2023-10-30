<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: ce fichier permet de factoriser le HTML du formulaire permettant l'ajout et la mise à jour d'une section
 */

?>

<div class="mb-3">
    <label for="name" class="form-label">Nom</label>
    <input type="text" class="form-control" id="name" aria-describedby="nameHelp" name="name" value="<?= $name ?>">
    <span id="show-error">
        <?= array_key_exists("name", $errors) && $errors["name"] ? '<p style="color:red;">' . $errors["name"] . '</p>' : '' ?>
    </span>
</div>
<button type="submit" class="btn btn-primary">Ajouter</button>