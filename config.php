<?php

/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant la gestion de la configuration de la base de données
 */

// $configs = array(
//     'db'      => "mysql",
//     'host'    => "localhost",
//     'dbname'  => "db_nickname",
//     'charset' => "utf8",
//     'user'    => 'root',
// );

$configs = array(
    'db'      => "mysql",
    'host'    => "webtestcloud-server.mysql.database.azure.com",
    'dbname'  => "db_nickname",
    'charset' => "utf8",
    'user'    => 'dtpftqnhiz',
);

$configs["dns"] = $configs["db"] . ":host=" . $configs["host"] . ";dbname=" . $configs["dbname"] . ";charset=" . $configs["charset"];

return $configs;
