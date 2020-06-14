<?php
class Emails extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getEmail($id_subscriber, $id) {
        $sql = "SELECT * 
                FROM   emails 
                WHERE  id_subscriber = $id_subscriber AND
                       id = $id";
        $sql = $this->db->query($sql);
        $data = array();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
        }
        return $data;
    }

    public function getCount($id_subscriber) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   emails 
                WHERE  id_subscriber = $id_subscriber";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }
    
    public function getList($id_subscriber, $offset) {
        $data = array();

        if ($offset == -1) {
            $sql = "SELECT u.*
                    FROM   emails u
                    WHERE  u.id_subscriber = $id_subscriber"; 
        } else {
            $sql = "SELECT u.*
                    FROM   emails u
                    WHERE  u.id_subscriber = $id_subscriber
                    LIMIT $offset, 10"; 
        }

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }
    
    public function searchEmails($id_subscriber, $search) {
        $data = array();

        $sql = "SELECT u.* 
                FROM   emails u
                WHERE  u.id_subscriber = $id_subscriber AND
                       u.name like '$search' OR
                       u.id = '$search'
                LIMIT 10"; 

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }

    public function add($id_subscriber, $id, $recipient, $subject_matter, $body) {
        $id_user = $_SESSION['ccUser'];
        
        if ($id > 0) {
            $sql = "UPDATE emails
                    SET    recipient = '$recipient', 
                           subject_matter = '$subject_matter', 
                           body = '$body',
                           changed_id_user = $id_user,
                           changed_date = Now()
                    WHERE  id_subscriber = $id_subscriber AND
                           id = $id";

        } else {
            $sql = "INSERT INTO emails 
                    SET id_subscriber = $id_subscriber,
                        recipient = '$recipient', 
                        subject_matter = '$subject_matter', 
                        body = '$body',
                        created_id_user = $id_user,
                        created_date = Now()";
        }

        $sql = $this->db->query($sql);
        if ($id == 0) {
            $id = $this->db->lastInsertId();
        }

        return $id; 
    }

    public function delete($id_subscriber, $id) {
        $sql = "DELETE FROM emails
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);
    }

    public function sendemail($id_subscriber, $id) {
        $email = $this->getEmail($id_subscriber, $id);

        $html = "E-mail: " . $email['recipient'] . "<br/> Mensagem: " . $email['body'];

        $headers = 'From: contato@teleconbr.com.br' . "\r\n";
        $headers .= 'Reply-To: ' . $email['recipient'] . "\r\n";
        $headers .= 'X-Mailer: PHP'.phpversion();
        
        mail("contato@teleconbr.com.br", $email['subject_matter'], $headers, $headers);

        $participant = new Prticipant();
        $participant->updateDtSendEmail();

        return 'E-mail enviado com sucesso';
    }
    
}
