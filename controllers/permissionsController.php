<?php
class permissionsController extends controller {
    
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

        if ($users->hasPermission('permissions')) {
            $permissions = new Permissions();
            $data["permission_params_list"] = $permissions->getListParams();
            $data["permission_groups_list"] = $permissions->getListGroups();

            $this->loadTamplate('permissions', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function add_param() {
        $data = array();

        $users = new Users(); 
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions') && $users->hasPermission('permission_params_add')) {
            $permissions = new Permissions();

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $id = $permissions->addParam(0, $name);
                header("Location: ".BASE_URL."/permissions");
            }

            $this->loadTamplate('/permissions/permission_params_add', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function add_group() {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions') && $users->hasPermission('permission_groups_add')) {
            $permissions = new Permissions();
            $data["permission_params_list"] = $permissions->getListParams();

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                if (isset($_POST['permissions'])) {
                    $plist = $_POST['permissions'];
                } else {
                    $plist = [];
                }
                
                $id = $permissions->addGroup($users->getSubscriber(), 0, $name, $plist);
                header("Location: ".BASE_URL."/permissions");
            }

            $this->loadTamplate('/permissions/permission_groups_add', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function edit_group($id) {
        $data = array();

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('permissions') && $users->hasPermission('permission_groups_edit')) {
            $permissions = new Permissions();
            $data["permission_params_list"] = $permissions->getListParams();
            $data["permission_group"] = $permissions->getPermissionGroup($id);

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                if (isset($_POST['permissions'])) {
                    $plist = $_POST['permissions'];
                } else {
                    $plist = [];
                }

                $id = $permissions->addGroup($users->getSubscriber(), $id, $name, $plist);
                header("Location: ".BASE_URL."/permissions");
            }

            $this->loadTamplate('/permissions/permission_groups_edit', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete_param($id) {
        $data = array();

        $user = new Users();
        $user->setLoggedUser();
        $subscriber = new Subscribers($user->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $user->getName();

        if ($user->hasPermission('permissions') && $user->hasPermission('permission_params_delete')) {
            $permissions = new Permissions();
            $permissions->deleteParam($id);
            header("Location: ".BASE_URL."/permissions");
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function delete_group($id) {
        $data = array();

        $user = new Users();
        $user->setLoggedUser();
        $subscriber = new Subscribers($user->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $user->getName();

        $retorno = '';
        if ($user->hasPermission('permissions') && $user->hasPermission('permission_groups_delete')) {
            $permissions = new Permissions();
            $retorno = $permissions->deleteGroup($id);
            if (!empty($retorno)) {
                $data['mensagem'] = $retorno;
                $this->loadTamplate('nopermission', $data);
            } else {
                header("Location: ".BASE_URL."/permissions");
            }
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }
    
}
