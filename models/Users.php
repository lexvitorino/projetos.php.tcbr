<?php
class Users extends model {

    private $userInfo;
    private $permissions;

    public function __construct() {
        parent::__construct();
    }

    public function isLogged() {
        if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        unset($_SESSION['ccUser']);
    }

    public function hasPermission($name) {
        if ($this->userInfo['is_admin'] == 1) {
            return true;
        } else {
            return $this->permissions->hasPermission($name);
        }
    }

    public function doLogin($login, $password = '') {
        $login = addslashes($login);
               
        if (!empty($password)) {
            $password = md5(addslashes($_POST['password']));
            $sql = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
        } else {
            $sql = "SELECT * FROM users WHERE login = '$login'";
        }

        $sql = $this->db->query($sql);
        
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            
            $_SESSION['ccUser'] = $row['id'];

            $participant = new Participants();
            $participant->setCursosAVencerNextmonths($this->getSubscriber(), 1);

            return true;
        } else {
            return false;
        }
    }
    
    public function getSubscriber() {
        if (isset($this->userInfo['id_subscriber'])) {
            return $this->userInfo['id_subscriber'];
        } else {
            return 0;
        }
    } 

    public function getName() {
        if(isset($this->userInfo['name'])) {
            return $this->userInfo['name'];
        } else {
            return '';  
        }
    }

    public function isAdmin() {
        if(isset($this->userInfo['is_admin']) && ($this->userInfo['is_admin']=='1')) {
            return true;
        } else {
            return false;  
        }
    }

    public function setLoggedUser() {
        if(isset($_SESSION['ccUser']) && !empty($_SESSION['ccUser'])) {
            $this->userInfo = $this->getUser(0, $_SESSION['ccUser']);

            $this->permissions = new Permissions();
            $this->permissions->setGroup($this->userInfo['id_subscriber'], $this->userInfo['id_group']);

            $has_dashboard = $this->hasPermission('dashboard');
            $has_emails = $this->hasPermission('emails');
            $has_permissions = $this->hasPermission('permissions');
            $has_users = $this->hasPermission('users');
            $has_courses = $this->hasPermission('courses');
            $has_certificates = $this->hasPermission('certificates');
            $has_certificatesItens = $this->hasPermission('certificatesItens');
            $has_companies = $this->hasPermission('companies');
            $has_clients = $this->hasPermission('clients');
            $has_participants = $this->hasPermission('participants');
            $has_reports = $this->hasPermission('reports');

            $_SESSION['has_dashboard'] = !empty($has_dashboard)?1:0;
            $_SESSION['has_emails'] = !empty($has_emails)?1:0;
            $_SESSION['has_permissions'] = !empty($has_permissions)?1:0;
            $_SESSION['has_users'] = !empty($has_users)?1:0;
            $_SESSION['has_courses'] = !empty($has_courses)?1:0;
            $_SESSION['has_certificates'] = !empty($has_certificates)?1:0;
            $_SESSION['has_certificatesItens'] = !empty($has_certificatesItens)?1:0;
            $_SESSION['has_companies'] = !empty($has_companies)?1:0;
            $_SESSION['has_clients'] = !empty($has_clients)?1:0;
            $_SESSION['has_participants'] = !empty($has_participants)?1:0;
            $_SESSION['has_reports'] = !empty($has_reports)?1:0;
        }
    }
    
    public function getUser($id_subscriber, $id) {
        $sql = "SELECT * 
                FROM   users 
                WHERE  ($id_subscriber = 0 OR id_subscriber = $id_subscriber) AND
                       id = $id";
        $sql = $this->db->query($sql);
        $usuario = array();
        if ($sql->rowCount() > 0) {
            $usuario = $sql->fetch();
        }
        return $usuario;
    }
    
    public function findUsersInGroup($id_group) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   users 
                WHERE  id_group = $id_group";

        $sql = $this->db->query($sql);

        $row = $sql->fetch();
        if ($row['qtde'] == '0') {
            return false;
        } else {
            return true;
        }
    }

    public function add($id_subscriber, $id, $name, $login, $password, $id_group) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   users 
                WHERE  id_subscriber = $id_subscriber AND
                       login = '$login' AND
                       id <> $id";
        $sql = $this->db->query($sql);

        $row = $sql->fetch();
        if ($row['qtde'] == '0') {  

            $id_user = $_SESSION['ccUser'];

            if ($id > 0) {
                $sql = "UPDATE users
                        SET    name = '$name',
                               login = '$login', 
                               password = md5('$password'),
                               id_group = $id_group,
                               changed_id_user = $id_user,
                               changed_date = Now()
                        WHERE  id_subscriber = $id_subscriber AND
                               id = $id";

            } else {
                $sql = "INSERT INTO users 
                        SET id_subscriber = $id_subscriber,
                            name = '$name',
                            login = '$login', 
                            password = md5('$password'),
                            id_group = $id_group,
                            is_admin = 0,
                            created_id_user = $id_user,
                            created_date = Now()";
            }

            $sql = $this->db->query($sql);
            if ($id == 0) {
                $id = $this->db->lastInsertId();
            }

            return $id; 
        } else {

            return 0;
        }
    }
    
    public function getLogin($id_subscriber, $login) {
        $array = array();
        $login = addslashes($login);
        
        $sql = "SELECT * 
                FROM   users 
                WHERE  id_subscriber = $id_subscriber AND
                       login = '$login'";
       
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }
        
        return $array;
    }

    public function getList($id_subscriber, $offiset) {
        $data = array();

        $sql = "SELECT u.*, pg.name as grupo 
                FROM   users u
                  LEFT JOIN permission_groups pg on pg.id = u.id_group
                WHERE  u.id_subscriber = $id_subscriber AND
                       is_admin = 0
                LIMIT  $offiset, 10"; 

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }

    public function delete($id_subscriber, $id) {
        $sql = "DELETE FROM users
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);
    }

    public function getCount($id_subscriber) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   users 
                WHERE  id_subscriber = $id_subscriber";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }

}
