<?php
class BaseSql{

    private $db;
    private $table;
    private $columns = [];

    public function __construct(){
        try {
            $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PWD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
            die();
        }

            //Récupérer le nom de la table dynamiquement
            $this->table = strtolower(get_class($this));

            //Récupérer le nom des colonnesde la table dynamiquement
            $varObject = get_class_vars($this->table);
            $varParent = get_class_vars(get_parent_class($this));
            $this->columns = array_diff_key($varObject, $varParent);
    }

    public function getDb() {
        return $this->db;
    }

    public function save() {
        if ($this->id == -1) {
            unset($this->columns['id']);
            $sqlCol = null;
            $sqlKey = null;
            foreach ($this->columns as $columns => $value) {
                $data[$columns] = $this->$columns;
                $sqlCol .= ",".$columns;
                $sqlKey .= ", :".$columns;
            }
            $sqlCol = trim($sqlCol, ",");
            $sqlKey = trim($sqlKey, ",");
            try {
                $req = $this->db->prepare("INSERT INTO ".$this->table." (".$sqlCol.") VALUES (".$sqlKey.");");
                $req->execute($data);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            $sqlQuery = null;
            foreach ($this->columns as $columns => $value) {
                $data[$columns] = $this->$columns;
                $sqlQuery .= $columns . " = :" . $columns . ", ";
            }
            $sqlQuery = trim($sqlQuery, ", ");
            $req = $this->db->prepare("UPDATE ".$this->table." SET ".$sqlQuery." WHERE id = :id;");
            $req->execute($data);
        }
    }


    public function populate( $search = [] ){
        //Requete SQL
        //Vérification
        //Alimentation de l'Objet
        $query = $this->getOneBy($search, true);
        //PDO::FETCH_PROPS_LATE : appeler le constructor apres l'alimentation de l'objet
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->table);
        $object = $query->fetch();
        return $object;
    }

    public function getOneBy($search = [], $returnQuery = false){
        foreach($search as $key => $value){
            $where[] = $key.'=:'.$key;
        }
        $query = $this->db->prepare("SELECT * FROM ".$this->table." WHERE ".implode(" AND ", $where));

        $query->execute($search);

        if($returnQuery){
            return $query;
        }
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * Appeler getAllBy() dans un contrôleur :
     * $users = array();
       $user = new User();
       foreach ($user->getAllBy() as $oneUser) {
           array_push($users, $oneUser);
       }
       $v = new View();
       $v->assign('users', $users);
     * ----------------------------
     * Se servir de l'array $users dans une vue :
     * foreach ($users as $user) {
            if ($user['username'] == "toto") {
                $theUser = $user;
                break;
            }
        }
        echo $theUser['email'];
     *
     */
    public function getAllBy($search = [], $order = null, $limit = null, $returnQuery = false){
        if (empty($search)) {
            $query = $this->db->prepare("SELECT * FROM ".$this->table.($order != null ? " ORDER BY created_at ".$order : " ").($limit != null ? " LIMIT ".$limit : ""));
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            foreach($search as $key => $value){
                $where[] = $key.'=:'.$key;
            }
            $query = $this->db->prepare("SELECT * FROM ".$this->table." WHERE ".implode(" AND ", $where).($order != null ? " ORDER BY created_at ".$order : "").($limit != null ? " LIMIT ".$limit : ""));
            $query->execute($search);
            if($returnQuery){
                return $query;
            }
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function like($search = [], $order = null, $limit = null, $returnQuery = false){
        if (empty($search)) {
            $query = $this->db->prepare("SELECT * FROM ".$this->table.($order != null ? " ORDER BY created_at ".$order : " ").($limit != null ? " LIMIT ".$limit : ""));
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            foreach($search as $key => $value){
                $where[] = $key." LIKE '%".$value."%'";
            }
            $query = $this->db->prepare("SELECT * FROM ".$this->table." WHERE ".implode(" OR ", $where).($order != null ? " ORDER BY created_at ".$order : "").($limit != null ? " LIMIT ".$limit : ""));
            $query->execute($search);

            if($returnQuery){
                return $query;
            }
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //if archived = true : SET is_archived to 1
    public function deleteOneBy($search = [], $archived = false, $returnQuery = false){

        foreach($search as $key => $value){
            $where[] = $key.'=:'.$key;
        }
        if($archived == true){
            $query = $this->db->prepare("UPDATE ".$this->table." SET is_archived = 1 WHERE ".implode(" AND ", $where));
        } else {
            $query = $this->db->prepare("DELETE FROM ".$this->table." WHERE ".implode(" AND ", $where));
        }

        $query->execute($search);

        if($returnQuery){
            return $query;
        }
        return true;
    }

    //Clean for every slug/url
    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    //Get last instance
    public function last($user_id = null){
        $query = $this->db->prepare("SELECT * FROM ".$this->table.($user_id != null ? " WHERE `user_id` = ".$user_id : "")." ORDER BY id DESC LIMIT 1 ");

        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
