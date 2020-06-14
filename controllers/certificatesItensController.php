<?php
class certificatesItensController extends controller {
    
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
        $data["has_certificatesItens_add"] = $users->hasPermission('certificatesItens_add');
        $data["has_certificatesItens_edit"] = $users->hasPermission('certificatesItens_edit');

        if ($users->hasPermission('certificatesItens')) {
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));

            $certificatesItens = new CertificatesItens();
            $data["certificatesItens_list"] = $certificatesItens->getList($users->getSubscriber(), $offiset);

            $data["certificatesItens_count"] = $certificatesItens->getCount($users->getSubscriber());

            $data["paginas_count"] = ceil( $data["certificatesItens_count"] / 10 );

            $this->loadTamplate('certificates_itens', $data);
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

        if ($users->hasPermission('certificatesItens') && $users->hasPermission('certificatesItens_add')) {
            $certificates = new Certificates();
            $data["certificates_list"] = $certificates->getList($users->getSubscriber(), 0);
            

            if (isset($_POST['id_certificates'])) {
                $id_certificates = addslashes($_POST['id_certificates']);
                $tipo_movimento = addslashes($_POST['tipo_movimento']);
                $amount = addslashes($_POST['amount']);
                $comment = addslashes($_POST['comment']);
                
                $certificatesItens = new CertificatesItens();
                $id = $certificatesItens->add($users->getSubscriber(), 0, $id_certificates, $tipo_movimento, $amount, $comment);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/certificatesItens");
                } else {
                    $data['error'] = "Certificado já existe!";
                }
            }

            $this->loadTamplate('/certificates/certificatesItens_add', $data);
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

        if ($users->hasPermission('permissionsItens') && $users->hasPermission('permissionsItens_delete')) {
            $certificatesItens = new CertificatesItens();
            $certificatesItens->delete($users->getSubscriber(), $id);

            header("Location: ".BASE_URL."/certificatesItens");
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    
}
