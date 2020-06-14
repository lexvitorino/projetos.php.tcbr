<?php
class Subscribers extends model {

	private $subscribrInfo;

    public function __construct($id) {
        parent::__construct();

        $this->subscribrInfo = $this->getSubscriberById($id);
    }

    public function getSubscriberById($id) {
    	$sql = "SELECT * FROM subscribers WHERE id = '$id'";
        $sql = $this->db->query($sql);

        $subscriber = array();
        if ($sql->rowCount() > 0) {
            $subscriber = $sql->fetch();
        }
        return $subscriber;
    }

    public function getName() {
    	if(isset($this->subscribrInfo['name'])) {
            return $this->subscribrInfo['name'];
        } else {
        	return '';	
        }
    }
 
}
