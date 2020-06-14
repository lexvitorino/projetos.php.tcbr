<?php
class usersController extends controller {
    
    public function __construct() {
        parent::__construct();

        $users = new Users();
        if ($users->isLogged() == false) {
        	header("Location: ".BASE_URL."/login");
        }
    }

    public function index() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();
        $data["has_users_add"] = $users->hasPermission('users_add');
        $data["has_users_edit"] = $users->hasPermission('users_edit');

        if ($users->hasPermission('users')) {
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));
            $data["users_list"] = $users->getList($users->getSubscriber(), $offiset);

            $data["users_count"] = $users->getCount($users->getSubscriber());
            $data["paginas_count"] = ceil( $data["users_count"] / 10 );

            $this->loadTamplate('users', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function add() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('users') && $users->hasPermission('users_add')) {
            $permissions = new Permissions();
            $data["permission_groups_list"] = $permissions->getListGroups();

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $login = addslashes($_POST['login']);
                $password = addslashes($_POST['password']);
                $id_group = addslashes($_POST['id_group']);
                
                $id = $users->add($users->getSubscriber(), 0, $name, $login, $password, $id_group);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/users");
                } else {
                    $data['error'] = "Usuário já existe!";
                }
            }

            $this->loadTamplate('/users/users_add', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function edit($id) {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('users') && $users->hasPermission('users_edit')) {
            $permissions = new Permissions();
            $data["permission_groups_list"] = $permissions->getListGroups();
            $data["user"] = $users->getUser($users->getSubscriber(), $id);

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $login = addslashes($_POST['login']);
                $password = addslashes($_POST['password']);
                $id_grupo = addslashes($_POST['id_group']);

                if (empty($password)) {
                    $olduser = $users->getUser($users->getSubscriber(), $id);
                    $password = $olduser['password'];
                }
                

                $id = $users->add($users->getSubscriber(), $id, $name, $login, $password, $id_grupo);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/users");
                } else {
                    $data['error'] = "Usuário já existe!";
                }
            }

            $this->loadTamplate('/users/users_edit', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($id) {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions') && $users->hasPermission('permissions_delete')) {
            $users->delete($users->getSubscriber(), $id);
            header("Location: ".BASE_URL."/users");
        } else {
            header("Location: ".BASE_URL);
        }
    }

    
}
