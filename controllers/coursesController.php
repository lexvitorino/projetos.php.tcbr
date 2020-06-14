<?php
class coursesController extends controller {
    
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
        $data["has_courses_add"] = $users->hasPermission('courses_add');
        $data["has_courses_edit"] = $users->hasPermission('courses_edit');

        if ($users->hasPermission('courses')) {
            $offiset = 0; 

            $data['pagina'] = 1;
            if (isset($_GET['p']) && !empty($_GET['p'])) {
                $data['pagina'] = intval($_GET['p']);
                if ($data['pagina'] == '0') {
                    $data['pagina'] = 1;
                }
            }

            $offiset = (10 * ($data['pagina']-1));

            $courses = new Courses();
            $data["courses_list"] = $courses->getList($users->getSubscriber(), $offiset);

            $data["courses_count"] = $courses->getCount($users->getSubscriber());
            $data["paginas_count"] = ceil( $data["courses_count"] / 10 );

            $this->loadTamplate('courses', $data);
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

        if ($users->hasPermission('courses') && $users->hasPermission('courses_add')) {
            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                
                $courses = new Courses();
                $id = $courses->add($users->getSubscriber(), 0, $name);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/courses");
                } else {
                    $data['error'] = "Curso já existe!";
                }
            }

            $this->loadTamplate('/courses/courses_add', $data);
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

        if ($users->hasPermission('courses') && $users->hasPermission('courses_edit')) {
            $courses = new Courses();
            $data['course'] = $courses->getCourse($users->getSubscriber(), $id);

            if (isset($_POST['name'])) {
                $name = addslashes($_POST['name']);
                
                $id = $courses->add($users->getSubscriber(), $id, $name);
                if ($id > 0) {
                    header("Location: ".BASE_URL."/courses");
                } else {
                    $data['error'] = "Empresa já existe!";
                }
            }

            $this->loadTamplate('/courses/courses_edit', $data);
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

        if ($users->hasPermission('courses') && $users->hasPermission('courses_delete')) {
            $courses = new Courses();
            $courses->delete($users->getSubscriber(), $id);

            header("Location: ".BASE_URL."/courses");
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    
}
