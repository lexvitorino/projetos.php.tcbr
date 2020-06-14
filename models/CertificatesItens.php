<?php
class CertificatesItens extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getCertificateItem($id_subscriber, $id) {
        $sql = "SELECT * 
                FROM   certificates_itens 
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
                FROM   certificates_itens 
                WHERE  id_subscriber = $id_subscriber";

        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }

    public function getList($id_subscriber, $offset) {
        $data = array();

        if ($offset == -1) {
            $sql = "SELECT u.*, c.name as 'certificate'
                    FROM   certificates_itens u
                        INNER JOIN certificates c on c.id = u.id_certificates
                    WHERE  u.id_subscriber = $id_subscriber"; 
        } else {
            $sql = "SELECT u.*, c.name as 'certificate'
                    FROM   certificates_itens u
                        INNER JOIN certificates c on c.id = u.id_certificates
                    WHERE  u.id_subscriber = $id_subscriber
                    LIMIT $offset, 10"; 
        }

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }
    
    public function searchCoueses($id_subscriber, $search) {
        $data = array();

        $sql = "SELECT u.* 
                FROM   certificates_itens u
                WHERE  u.id_subscriber = $id_subscriber AND
                       u.id = '$search'
                LIMIT 10"; 

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }

    public function add($id_subscriber, $id, $id_certificates, $tipo_movimento, $amount, $comment) {
        $certificate = new Certificates();
        $old = $certificate->getCertificate($id_subscriber, $id_certificates);
        $amountold = $old['amount'];

        $id_user = $_SESSION['ccUser'];

        if ($id > 0) {
            $sql = "UPDATE certificates_itens
                    SET    id_certificates = $id_certificates,
                           tipo_movimento = '$tipo_movimento',
                           amount = $amount,
                           current_balance = $amountold,
                           comment = '$comment',
                           changed_id_user = $id_user,
                           changed_date = Now()
                    WHERE  id_subscriber = $id_subscriber AND
                           id = $id";

        } else {
            $sql = "INSERT INTO certificates_itens 
                    SET    id_subscriber = $id_subscriber,
                           id_certificates = $id_certificates,
                           tipo_movimento = '$tipo_movimento',
                           amount = $amount,
                           current_balance = $amountold,
                           comment = '$comment',
                           created_id_user = $id_user,
                           created_date = Now()";
        }

        $sql = $this->db->query($sql);
        if ($id == 0) {
            $id = $this->db->lastInsertId();

            if ($id > 0) {
                $certificate->balance($id_subscriber, $id_certificates, $tipo_movimento, $amount);
            }
        }

        return $id; 
    }

    public function delete($id_subscriber, $id) {
        $old = $this->getCertificateItem($id_subscriber, $id);

        $sql = "DELETE FROM certificates_itens
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);

        $certificate = new Certificates();
        $certificate->balance($id_subscriber, $old['id_certificates'], ($old['tipo_movimento']=='E')?'S':'E', $old['amount']);
    }

    public function getCountByCertificate($id_subscriber, $id_certificates) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   certificates_itens 
                WHERE  id_subscriber = $id_subscriber
                AND    id_certificates = $id_certificates";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }

}
