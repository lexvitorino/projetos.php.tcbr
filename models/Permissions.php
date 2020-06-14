 <?php
class Permissions extends model {

    public $group;
    public $permissions;

    public function __construct() {
        parent::__construct();
    }

    public function setGroup($id_subscriber, $id) {
        $this->group = $id;
        $this->permissions = array();

        if (empty($id)) {
            $id = 0;
        }

        $sql = "SELECT params 
                FROM   permission_groups 
                WHERE  id_subscriber = $id_subscriber AND
                       id = $id";

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();

            $params = $row['params'];
            if (empty($params)){
                $params = '0';
            }

            $sql = "SELECT name 
                    FROM   permission_params
                    WHERE  id in ($params)";                          

            $sql = $this->db->query($sql);
            if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $item) {
                    $this->permissions[] = $item['name'];
                }
            }
        }         
    }

    public function hasPermission($name) {
        if (in_array($name, $this->permissions)) {
            return true;
        } else {
            return false;
        }
    }

    public function getListParams() {
        $data = array();

        $sql = "SELECT * 
                FROM   permission_params";    

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }

    public function getListGroups() {
        $data = array();

        $sql = "SELECT * 
                FROM   permission_groups";    

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }

    public function getPermissionGroup($id) {
        $data = array();

        $sql = "SELECT * 
                FROM   permission_groups
                WHERE  id = $id";    

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
            $data["params"] = explode(',', $data["params"]);
        }        

        return $data;
    }

    public function addParam($id, $name) {
        $id_user = $_SESSION['ccUser'];

        if ($id > 0) {
            $sql = "UPDATE permission_params 
                    SET    name = '$name' 
                    WHERE  id = $id";
        } else {
            $sql = "INSERT INTO permission_params 
                    SET name = '$name'";
        }
        
        $sql = $this->db->query($sql);
        if ($id == 0) {
            $id = $this->db->lastInsertId();
        }
        return $id;
    }

    public function addGroup($id_subscriber, $id, $name, $plist) {
        $id_user = $_SESSION['ccUser'];
        
        $params = implode(',', $plist);
        if ($id > 0) {
            $sql = "UPDATE permission_groups 
                    SET    name = '$name',
                           params = '$params',
                           changed_id_user = $id_user,
                           changed_date = Now()
                    WHERE  id_subscriber = $id_subscriber AND
                           id = $id";
        } else {
            $sql = "INSERT INTO permission_groups 
                    SET id_subscriber = $id_subscriber AND
                        params = '$params', 
                        name = '$name',
                        created_id_user = $id_user,
                        created_date = Now()";
        }

        $sql = $this->db->query($sql);
        if ($id == 0) {
            $id = $this->db->lastInsertId();
        }
        return $id;
    }

    public function deleteParam($id) {
        $sql = "DELETE FROM permission_params
                WHERE id = $id";
        $this->db->query($sql);
    }

    public function deleteGroup($id) {
        $users = new Users();
        if ($users->findUsersInGroup($id) == false) {
            $sql = "DELETE FROM permission_groups
                    WHERE id = $id";
            $this->db->query($sql);
        } else {
            return "Grupo vinculado a um usuário";
        }
    }
 
}
