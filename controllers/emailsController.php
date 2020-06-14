<?php
class emailsController extends controller {
    
    public function __construct() {
        parent::__construct();

        $emails = new Users();
        if ($emails->isLogged() == false) {
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
        $data["has_emails_edit"] = $users->hasPermission('emails_edit');
        $data["has_emails_resend"] = $users->hasPermission('emails_resend');

        if ($users->hasPermission('emails')) {
            $emails = new Emails();
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));
            $data["emails_list"] = $emails->getList($users->getSubscriber(), $offiset);

            $data["emails_count"] = $emails->getCount($users->getSubscriber());
            $data["paginas_count"] = ceil( $data["emails_count"] / 10 );

            $this->loadTamplate('emails', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function resend($id) {
        $data = array('msg' => '');

        $users = new Users();
        $users->setLoggedUser();
        $subscriber = new Subscribers($users->getSubscriber());

        $data['subscriber_name'] = $subscriber->getName();
        $data['user_name'] = $users->getName();

        if ($users->hasPermission('emails') && $users->hasPermission('emails_resend')) {
            $emails = new Emails();
            $data['msg'] = $emails->sendmail($users->getSubscriber(), $id);
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

        if ($users->hasPermission('emails') && $users->hasPermission('emails_edit')) {
            $emails = new Emails();
            $data['email'] = $emails->getEmail($users->getSubscriber(), $id);

            if (isset($_POST['recipient'])) {
                $recipient = addslashes($_POST['recipient']);
                $subject_matter = addslashes($_POST['subject_matter']);
                $body = addslashes($_POST['body']);
                
                $id = $emails->add($users->getSubscriber(), $id, $recipient, $subject_matter, $body);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/emails");
                } else {
                    $data['error'] = "E-mail já existe!";
                }
            }

            $this->loadTamplate('/emails/emails_edit', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }



}
