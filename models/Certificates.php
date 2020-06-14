<?php
class Certificates extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getCertificate($id_subscriber, $id) {
        $sql = "SELECT * 
                FROM   certificates 
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
                FROM   certificates 
                WHERE  id_subscriber = $id_subscriber";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }

    public function getList($id_subscriber, $offset) {
        $data = array();

        if ($offset == -1) {
            $sql = "SELECT u.*
                    FROM   certificates u
                    WHERE  u.id_subscriber = $id_subscriber"; 
        } else {
            $sql = "SELECT u.*
                    FROM   certificates u
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
                FROM   certificates u
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

    public function add($id_subscriber, $id, $name, $id_course, $amount) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   certificates 
                WHERE  id_subscriber = $id_subscriber AND
                       name = '$name' AND
                       id <> $id";
        $sql = $this->db->query($sql);

        $row = $sql->fetch();
        if ($row['qtde'] == '0') {  

            $id_user = $_SESSION['ccUser'];
            
            if ($id > 0) {
                $sql = "UPDATE certificates
                        SET    name = '$name',
                               id_course = $id_course,
                               amount = $amount,
                               changed_id_user = $id_user,
                               changed_date = Now()
                        WHERE  id_subscriber = $id_subscriber AND
                               id = $id";

            } else {
                $sql = "INSERT INTO certificates 
                        SET    id_subscriber = $id_subscriber,
                               name = '$name',
                               id_course = $id_course,
                               amount = $amount,
                               created_id_user = $id_user,
                               created_date = Now()";
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
        $certificatesItens = new CertificatesItens();
        $count = $certificatesItens->getCountByCertificate($id_subscriber, $id);
        if ($count == 0) {
            $sql = "DELETE FROM certificates
                    WHERE id_subscriber = $id_subscriber AND
                          id = $id";
            $this->db->query($sql);
        } else {
            return "Existem movimentos para este certificado"."\r\n"."Operação canelada!";
        }
    }
    
    public function getCompaniesForReport($id_subscriber,$name,$order) {
        $data = array();

        $sql = "SELECT u.*
                FROM   certificates u
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

    public function balance($id_subscriber, $id, $tipo_movimento, $amount) {
        if ($tipo_movimento == 'S') {
            $amount = $amount * (-1);
        }
        $sql = "UPDATE certificates
                SET    amount = amount + $amount
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);
    }

}
