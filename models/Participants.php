<?php
class Participants extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getParticipant($id_subscriber, $id) {
        $sql = "SELECT p.*, cli.name as 'client', cou.name as 'course' 
                FROM   participants p
                  INNER JOIN clients cli ON cli.id = p.id_client
                  INNER JOIN courses cou ON cou.id = p.id_course
                WHERE  p.id_subscriber = $id_subscriber AND
                       p.id = $id";
        $sql = $this->db->query($sql);
        $data = array();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetch();
        }
        return $data;
    }

    public function getCount($id_subscriber) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   participants 
                WHERE  id_subscriber = $id_subscriber";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }
    
    public function getList($id_subscriber, $offset) {
        $data = array();

        if ($offset == -1) {
            $sql = "SELECT p.*, cli.name as 'client', cou.name as 'course' 
                    FROM   participants p
                      INNER JOIN clients cli ON cli.id = p.id_client
                      INNER JOIN courses cou ON cou.id = p.id_course
                    WHERE  p.id_subscriber = $id_subscriber"; 
        } else {
            $sql = "SELECT p.*, cli.name as 'client', cou.name as 'course' 
                    FROM   participants p
                      INNER JOIN clients cli ON cli.id = p.id_client
                      INNER JOIN courses cou ON cou.id = p.id_course
                    WHERE  p.id_subscriber = $id_subscriber
                    LIMIT $offset, 10"; 
        }

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }
    
    public function getListByClient($id_subscriber, $id_client) {
        $data = array();

        $sql = "SELECT p.*, cli.name as 'client', cou.name as 'course' 
                FROM   participants p
                  INNER JOIN clients cli ON cli.id = p.id_client
                  INNER JOIN courses cou ON cou.id = p.id_course
                WHERE  p.id_subscriber = $id_subscriber
                AND    p.id_client = $id_client"; 
        
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }
    
    public function searchParticipants($id_subscriber, $search) {
        $data = array();

        $sql = "SELECT u.* 
                FROM   participants u
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

    public function add($id_subscriber, $id, $id_client, $id_course, $date_start, $date_end, $expiration_date, $value, $discount_value, $discount_manager, $payment_form) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   participants
                WHERE  id_subscriber = $id_subscriber AND
                       id_client = $id_client AND
                       id_course = $id_course AND
                       id <> $id";

        $sql = $this->db->query($sql);

        $row = $sql->fetch();
        if ($row['qtde'] == '0') {       
            
            $certificate_url = '';
            if (isset($_FILES['certificate_url']) && !empty($_FILES['certificate_url']['tmp_name'])) {            
                $permitidos = array('image/jpeg', 'image/jpg', 'image/png');
                if (in_array($_FILES['certificate_url']['type'], $permitidos)) {
                    $destination = md5(time().rand(1, 999)) . '.jpg';
                    move_uploaded_file($_FILES['certificate_url']['tmp_name'], 'assets/images/certificates/' . $destination);
                    $certificate_url = $destination;
                }
            }

            $id_user = $_SESSION['ccUser'];

            if ($id > 0) {
                
                $old = $this->getParticipant($id_subscriber, $id);
                if (!empty($certificate_url)) {            
                    unlink('assets/images/certificates/'.$old['certificate_url']);
                } else {
                    $certificate_url = $old[certificate_url];
                }

                $sql = "UPDATE participants
                        SET    id_client = $id_client, 
                               id_course = $id_course, 
                               date_start = '$date_start', 
                               date_end = '$date_end', 
                               expiration_date = '$expiration_date', 
                               certificate_url = '$certificate_url',
                               value = $value,
                               changed_id_user = $id_user,
                               changed_date = Now(),
                               discount_value = $discount_value, 
                               discount_manager = '$discount_manager',
                               payment_form = '$payment_form'
                        WHERE  id_subscriber = $id_subscriber AND
                               id = $id";
            } else {
                $sql = "INSERT INTO participants 
                        SET id_subscriber = $id_subscriber,
                            id_client = $id_client, 
                            id_course = $id_course, 
                            date_start = '$date_start', 
                            date_end = '$date_end', 
                            expiration_date = '$expiration_date', 
                            certificate_url = '$certificate_url',
                            value = $value,
                            created_id_user = $id_user,
                            created_date = Now(),
                            discount_value = $discount_value, 
                            discount_manager = '$discount_manager',
                            payment_form = '$payment_form'";
            }

            $sql = $this->db->query($sql);
            if ($id == 0) {
                $id = $this->db->lastInsertId();
            }

            return $id; 
        } else {

            return 0;
        }
    }

    public function delete($id_subscriber, $id) {
        $sql = "DELETE FROM participants
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);
    }
    
    public function getParticipantsForReport($id_subscriber,$name,$order) {
        $data = array();

        $sql = "SELECT u.*
                FROM   participants u
                WHERE ";

        $where = array();
        $where[] = "u.id_subscriber = $id_subscriber"; 

        if(!empty($name)) {
          $where[] = "u.name like '$name'"; 
        }

        $sql .= implode(" AND ", $where);
        $sql .= " ORDER BY u.".$order;

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }

    public function getCursosEfetuados($id_subscriber, $dtinicial, $dtfinal) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   participants 
                WHERE  id_subscriber = $id_subscriber AND
                       date_start between '$dtinicial' AND '$dtfinal'";

        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }
    
    public function getCursosEfetuadosLastMonths($id_subscriber, $months) {
        $data = array();
        $q = 1;

        $monthyear = date('m/Y'); 
        while($q<=$months) {
          $data[$monthyear] = 0;
          $monthyear = date('m/Y', strtotime('-'.$q.' month'));
          $q++;
        }
        $data = array_reverse($data);

        $sql = "SELECT DATE_FORMAT(date_start, '%m/%Y') as date_start, COUNT(id) as qtde
                FROM   participants
                WHERE  id_subscriber = $id_subscriber AND
                       date_start >= DATE_SUB(now(), INTERVAL $months MONTH)
                GROUP BY DATE_FORMAT(date_start, '%Y-%m')";

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll();

            foreach ($rows as $item) {
              $data[$item['date_start']] = $item['qtde'];
            }
        }

        return $data;
    }
    
    public function getQtdeCursosAVencerNextmonths($id_subscriber, $months) {
        $data = array();
        $q = 1;

        $monthyear = date('m/Y'); 
        while($q<=$months) {
          $data[$monthyear] = 0;
          $monthyear = date('m/Y', strtotime('+'.$q.' month'));
          $q++;
        }
        $data = array_reverse($data);

        $sql = "SELECT DATE_FORMAT(expiration_date, '%m/%Y') as expiration_date, COUNT(id) as qtde
                FROM   participants
                WHERE  id_subscriber = $id_subscriber AND
                       expiration_date <= DATE_ADD(now(), INTERVAL $months MONTH) AND
                       expiration_date <> '0000-00-00'
                GROUP BY DATE_FORMAT(expiration_date, '%Y-%m')";

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll();

            foreach ($rows as $item) {
              $data[$item['expiration_date']] = $item['qtde'];
            }
        }

        return $data;
    }
    
    public function getCursosAVencerNextmonths($id_subscriber, $months) {
        $data = array();

        $sql = "SELECT p.*, cli.name as 'client', cou.name as 'course' 
                FROM   participants p
                  INNER JOIN clients cli ON cli.id = p.id_client
                  INNER JOIN courses cou ON cou.id = p.id_course
                WHERE  p.id_subscriber = $id_subscriber AND
                       p.expiration_date <= DATE_ADD(now(), INTERVAL $months MONTH) AND
                       p.expiration_date <> '0000-00-00'";

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        return $data;
    }

    public function updateDataSendEmail($id_subscriber, $id) {
        $sql = "UPDATE participants
                SET    date_send_email = now()
                WHERE  id_subscriber = $id_subscriber AND
                       id = $id";
        
        $this->db->query($sql);
    }
    
    public function setCursosAVencerNextmonths($id_subscriber, $months) {
        $data = array();

        $sql = "SELECT p.*, cli.email, cli.name as 'client', cou.name as 'course' 
                FROM   participants p
                  INNER JOIN clients cli ON cli.id = p.id_client
                  INNER JOIN courses cou ON cou.id = p.id_course
                WHERE  p.id_subscriber = $id_subscriber AND
                       p.expiration_date <= DATE_ADD(now(), INTERVAL $months MONTH) AND
                       (p.date_send_email IS NULL or DATEDIFF(p.date_send_email, DATE_ADD(CURDATE(), INTERVAL -7 DAY))>7) AND
                       p.expiration_date <> '0000-00-00'";

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll();
            
            $emails = new Emails();
            foreach ($rows as $item) {
               $id = $emails->add($id_subscriber, 
                                  0, 
                                  $item['email'],
                                  'Curso a Vencer.: '.$item['course'],
                                  'Oi, '.$item['client']."\r\n".
                                  'Seu curso de '.$item['course'].' vence dia '.date('d/m/Y', strtotime($item['expiration_date']))."\r\n".
                                  'Não perca tempo e nos procure para ficar em dia com suas obrigações.');
               
               $this->updateDataSendEmail($id_subscriber, $item['id']); 
               $emails->sendemail($id_subscriber, $id);
            }
        }

        return $data;
    }

}
