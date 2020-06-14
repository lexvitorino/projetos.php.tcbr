<?php
class loginController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();

        if (isset($_POST['login']) && !empty($_POST['login'])) {
            $login = addslashes($_POST['login']);
            $password = addslashes($_POST['password']);

            $users = new Users();

            if ($users->doLogin($login, $password)) {
                header("Location: ".BASE_URL);
                exit;
            } else {
                $data['error'] = 'Login ou Password não conferem!';
            }
        }

        $this->loadView('login', $data);
    }
    
    public function logout() {
        $users = new Users();
        $users->logout();
        header("Location: ".BASE_URL);
    }

}
