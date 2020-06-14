<?php
class certificatesController extends controller {
    
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
        $data["has_certificates_add"] = $users->hasPermission('certificates_add');
        $data["has_certificates_edit"] = $users->hasPermission('certificates_edit');

        if ($users->hasPermission('certificates')) {
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));

            $certificates = new Certificates();
            $data["certificates_list"] = $certificates->getList($users->getSubscriber(), $offiset);

            $data["certificates_count"] = $certificates->getCount($users->getSubscriber());
            $data["paginas_count"] = ceil( $data["certificates_count"] / 10 );

            $this->loadTamplate('certificates', $data);
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

        if ($users->hasPermission('certificates') && $users->hasPermission('certificates_add')) {
            $courses = new Courses();
            $data["courses_list"] = $courses->getList($users->getSubscriber(), -1);
            
            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $amount = addslashes($_POST['amount']);
                
                $id_course = 'NULL';
                if (isset($_POST['id_course']) && !empty($_POST['id_course'])) {
                    $id_course = addslashes($_POST['id_course']);
                }
                
                $certificates = new Certificates();
                $id = $certificates->add($users->getSubscriber(), 0, $name, $id_course, $amount);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/certificates");
                } else {
                    $data['error'] = "Certificado já existe!";
                }
            }

            $this->loadTamplate('/certificates/certificates_add', $data);
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

        if ($users->hasPermission('certificates') && $users->hasPermission('certificates_edit')) {
            $courses = new Courses();
            $data["courses_list"] = $courses->getList($users->getSubscriber(), -1);
            $certificates = new Certificates();
            $data['certificate'] = $certificates->getCertificate($users->getSubscriber(), $id);

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $amount = addslashes($_POST['amount']);
                
                $id_course = 'NULL';
                if (isset($_POST['id_course']) && !empty($_POST['id_course'])) {
                    $id_course = addslashes($_POST['id_course']);
                }
                
                $id = $certificates->add($users->getSubscriber(), $id, $name, $id_course, $amount);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/certificates");
                } else {
                    $data['error'] = "Empresa já existe!";
                }
            }

            $this->loadTamplate('/certificates/certificates_edit', $data);
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

        if ($users->hasPermission('certificates') && $users->hasPermission('certificates_delete')) {
            $certificates = new Certificates();
            $data['mensagem'] = $certificates->delete($users->getSubscriber(), $id);

            if (isset($data['mensagem']) && !empty($data['mensagem'])) {
                $this->loadTamplate('nopermission', $data);
            } else {
                header("Location: ".BASE_URL."/certificates");
            }
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    
}
