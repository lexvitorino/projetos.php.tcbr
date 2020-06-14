<?php
class participantsController extends controller {
    
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
        $data["has_participants_add"] = $users->hasPermission('participants_add');
        $data["has_participants_edit"] = $users->hasPermission('participants_edit');

        if ($users->hasPermission('participants')) {
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));

            $participants = new Participants();
            $data["participants_list"] = $participants->getList($users->getSubscriber(), $offiset);

            $data["participants_count"] = $participants->getCount($users->getSubscriber());
            $data["paginas_count"] = ceil( $data["participants_count"] / 10 );

            $this->loadTamplate('participants', $data);
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

        if ($users->hasPermission('participants') && $users->hasPermission('participants_add')) {
            $participants = new Participants();
            $clients = new Clients();
            $data["clients_list"] = $clients->getList($users->getSubscriber(), -1);
            $courses = new Courses();
            $data["courses_list"] = $courses->getList($users->getSubscriber(), -1);
            
            if (isset($_POST['id_client'])) {
                $id_client = addslashes($_POST['id_client']);
                $id_course = addslashes($_POST['id_course']);
                $date_start = addslashes($_POST['date_start']);
                $date_end = addslashes($_POST['date_end']);
                $expiration_date = addslashes($_POST['expiration_date']);
                $value = addslashes($_POST['value']);
                $discount_value = addslashes($_POST['discount_value']);
                $payment_form = addslashes($_POST['payment_form']);
                $discount_manager = addslashes($_POST['discount_manager']);
                
                $id = $participants->add($users->getSubscriber(), 0, $id_client, $id_course, $date_start, $date_end, $expiration_date, $value, $discount_value, $discount_manager, $payment_form);
                
                if ($id > 0) {
                    header("Location: ".BASE_URL."/participants");
                } else {
                    $data['error'] = "Usuário já existe!";
                }
            }

            $this->loadTamplate('/participants/participants_add', $data);
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

        if ($users->hasPermission('participants') && $users->hasPermission('participants_edit')) {
            $participants = new Participants();
            $data['participant'] = $participants->getParticipant($users->getSubscriber(), $id);
            $clients = new Clients();
            $data["permission_clients_list"] = $clients->getList($users->getSubscriber(), -1);
            $courses = new Courses();
            $data["permission_courses_list"] = $courses->getList($users->getSubscriber(), -1);

            if (isset($_POST['id_client'])) {
                $id_client = addslashes($_POST['id_client']);
                $id_course = addslashes($_POST['id_course']);
                $date_start = addslashes($_POST['date_start']);
                $date_end = addslashes($_POST['date_end']);
                $expiration_date = addslashes($_POST['expiration_date']);
                $value = addslashes($_POST['value']);
                $discount_value = addslashes($_POST['discount_value']);
                $payment_form = addslashes($_POST['payment_form']);
                $discount_manager = addslashes($_POST['discount_manager']);
                
                $participants = new Participants();
                $id = $participants->add($users->getSubscriber(), $id, $id_client, $id_course, $date_start, $date_end, $expiration_date, $value, $discount_value, $discount_manager, $payment_form);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/participants");
                } else {
                    $data['error'] = "Empresa já existe!";
                }
            }

            $this->loadTamplate('/participants/participants_edit', $data);
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
            $participants = new Participants();
            $participants->delete($users->getSubscriber(), $id);

            header("Location: ".BASE_URL."/participants");
        } else {
            header("Location: ".BASE_URL);
        }
    }

    
}
