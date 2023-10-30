<?php


/**
 * ETML
 * Auteur: GCR
 * Date: 21.02.2022
 * Description: Fichier permettant la gestion de la base de données
 */

class Database
{
    private $connector;

    private static $instance = null;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $configs = include(__DIR__ . "/config.php");
        try {
            $this->connector = new PDO(
                $configs['dns'],
                $configs['user'],
                $this->getPassword()
            );
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Met en place un singleton pour l'instance Database
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Retourne le mot de passe de l'utilisateur
     * 
     * Une bonne pratique consiste à stocker les secrets
     * dans des variables d'environnements ou dans un fichier json
     */
    private function getPassword()
    {
        //read json file from url in php
        $readJSONFile = file_get_contents(__DIR__ . "/secrets.json");

        //convert json to array in php
        $array = json_decode($readJSONFile, TRUE);

        return $array["dbUserPassword"];
    }


    /**
     * Permet de préparer et d’exécuter une requête de type simple (sans where)
     */
    private function querySimpleExecute($query)
    {
        return $this->connector->query($query);
    }

    /**
     * Permet de préparer, de binder et d’exécuter une requête (select avec where ou insert, update et delete)
     */
    private function queryPrepareExecute($query, $binds)
    {
        $req = $this->connector->prepare($query);
        foreach ($binds as $key => $element) {
            $req->bindValue($key, $element["value"], $element["type"]);
        }
        $req->execute();
        return $req;
    }

    /**
     * Traiter les données pour les retourner par exemple en tableau associatif (avec PDO::FETCH_ASSOC)
     */
    private function formatData($req)
    {
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vider le jeu d’enregistrement
     */
    private function unsetData($req)
    {
    }

    /**
     * Retourne la liste des sections
     */
    public function getAllSections()
    {
        $req = $this->querySimpleExecute("SELECT * FROM t_section");
        return $this->formatData($req);
    }

    public function getOneSection($idSection)
    {
        $binds = [];
        $binds["idSection"] = ["value" => $idSection, "type" => PDO::PARAM_INT];
        $req = $this->queryPrepareExecute("SELECT * FROM t_section WHERE idSection = :idSection", $binds);
        return $this->formatData($req)[0];
    }

    /**
     * Retourne la liste des professeurs
     */
    public function getAllTeachers()
    {
        $req = $this->querySimpleExecute("SELECT * FROM t_teacher");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un enseignant dont l'ID vaut '$idTeacher'
     */
    public function getOneTeacher($idTeacher)
    {
        $binds = [];
        $binds["idTeacher"] = ["value" => $idTeacher, "type" => PDO::PARAM_INT];
        $req = $this->queryPrepareExecute("SELECT * FROM t_teacher WHERE idTeacher = :idTeacher", $binds);
        return $this->formatData($req)[0];
    }

    /**
     * Supprime un enseignant dont l'ID vaut '$idTeacher'
     */
    public function deleteTeacher($idTeacher)
    {
        $binds = [];
        $binds["idTeacher"] = ["value" => $idTeacher, "type" => PDO::PARAM_INT];
        $req = $this->queryPrepareExecute("DELETE FROM t_teacher WHERE idTeacher = :idTeacher", $binds);
        return $this->formatData($req)[0];
    }

    /**
     * Supprime une section dont l'ID vaut '$idTeacher'
     */
    public function deleteSection($idSection)
    {
        $binds = [];
        $binds["idSection"] = ["value" => $idSection, "type" => PDO::PARAM_INT];
        $req = $this->queryPrepareExecute("DELETE FROM t_section WHERE idSection = :idSection", $binds);
        return $this->formatData($req)[0];
    }

    public function insertSection($data)
    {
        $binds = [];
        $binds["secName"] = ["value" => $data['name'], "type" => PDO::PARAM_STR];

        // Requête pour l'insertion d'une nouvelle section
        $query = "INSERT INTO t_section VALUES (DEFAULT, :secName);";

        $req = $this->queryPrepareExecute($query, $binds);
        return $this->formatData($req);
    }

    /**
     * Insère un nouvel enseignant
     */
    public function insertTeacher($data)
    {
        // Construction d'un tableau associatif pour le bind des paramètres de la requête
        // [
        //      "firstName" => [ "value" => "Grégory", "type" = "PDO::PARAM_STR"],
        //      ...
        // ]
        $binds = [];
        foreach ($data as $key => $element) {
            if ($key === "gender") {
                $type = PDO::PARAM_STR_CHAR;
            } else if ($key === "section" || $key === "idTeacher") {
                $type = PDO::PARAM_INT;
            } else {
                $type = PDO::PARAM_STR;
            }
            $binds[$key] = ["value" => $element, "type" => $type];
        }

        // Requête pour l'insertion d'un nouvel enseignant
        $query = "INSERT INTO t_teacher (idTeacher, teaFirstname, teaName, teaGender, teaNickname, teaOrigine, fkSection) VALUES (NULL, :firstName, :lastName, :gender, :nickname, :origine, :section);";

        $req = $this->queryPrepareExecute($query, $binds);
        return $this->formatData($req);
    }

    public function updateTeacher($data)
    {
        // Construction d'un tableau associatif pour le bind des paramètres de la requête
        // [
        //      "firstName" => [ "value" => "Grégory", "type" = "PDO::PARAM_STR"],
        //      ...
        // ]
        $binds = [];
        foreach ($data as $key => $element) {
            if ($key === "gender") {
                $type = PDO::PARAM_STR_CHAR;
            } else if ($key === "section") {
                $type = PDO::PARAM_INT;
            } else {
                $type = PDO::PARAM_STR;
            }
            $binds[$key] = ["value" => $element, "type" => $type];
        }

        // Requête pour l'update d'un enseignant
        $query = "UPDATE t_teacher SET teaFirstname = :firstName, teaName = :lastName, teaGender = :gender, teaNickname = :nickname, teaOrigine = :origine, fkSection = :section WHERE idTeacher = :idTeacher";
        $req = $this->queryPrepareExecute($query, $binds);
        return $this->formatData($req);
    }

    public function updateSection($idSection, $name)
    {
        $binds = [
            "idSection" => ["value" => $idSection, "type" => PDO::PARAM_INT],
            "name" => ["value" => $name, "type" => PDO::PARAM_STR],
        ];

        // Requête pour l'update d'une section
        $query = "UPDATE t_section SET secName = :name WHERE idSection = :idSection";
        $req = $this->queryPrepareExecute($query, $binds);
        return $this->formatData($req);
    }


    /**
     * Retourne un user dont le username vaut '$username'
     */
    public function getOneUser($username)
    {
        $binds = [];
        $binds["useLogin"] = ["value" => $username, "type" => PDO::PARAM_STR];
        $query = "SELECT * FROM t_user WHERE useLogin = :useLogin";
        $req = $this->queryPrepareExecute($query, $binds);
        $users = $this->formatData($req);
        if (sizeof($users) !== 1) {
            return false;
        }
        return $users[0];
    }

    public function getOneUserById($idUser)
    {
        $binds = [];
        $binds["idUser"] = ["value" => $idUser, "type" => PDO::PARAM_STR];
        $query = "SELECT * FROM t_user WHERE idUser = :idUser";
        $req = $this->queryPrepareExecute($query, $binds);
        $users = $this->formatData($req);
        if (sizeof($users) !== 1) {
            return false;
        }
        return $users[0];
    }

    public function getOneSession($sessionId)
    {
        $binds = [];
        $binds["idSession"] = ["value" => $sessionId, "type" => PDO::PARAM_STR];
        $query = "SELECT * FROM t_session WHERE idSession = :idSession";
        $req = $this->queryPrepareExecute($query, $binds);
        $sessions = $this->formatData($req);
        if (sizeof($sessions) !== 1) {
            return false;
        }
        return $sessions[0];
    }

    public function createSession($idUser)
    {
        $binds = [];
        $binds["userId"] = ["value" => $idUser, "type" => PDO::PARAM_INT];
        $query = "INSERT INTO t_session VALUES ( DEFAULT, :userId)";
        $this->queryPrepareExecute($query, $binds);
        return $this->connector->lastInsertId();
    }

    public function deleteSession($sessionId)
    {
        $binds = [];
        $binds["idSession"] = ["value" => $sessionId, "type" => PDO::PARAM_INT];
        $this->queryPrepareExecute("DELETE FROM t_session WHERE idSession = :idSession", $binds);
    }
}
