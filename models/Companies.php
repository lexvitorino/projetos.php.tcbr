<?php
class Companies extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getCompany($id_subscriber, $id) {
        $sql = "SELECT * 
                FROM   companies 
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
                FROM   companies 
                WHERE  id_subscriber = $id_subscriber";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }
    
    public function getList($id_subscriber, $offset) {
        $data = array();

        if ($offset == -1) {
            $sql = "SELECT u.*
                    FROM   companies u
                    WHERE  u.id_subscriber = $id_subscriber"; 
        } else {
            $sql = "SELECT u.*
                    FROM   companies u
                    WHERE  u.id_subscriber = $id_subscriber
                    LIMIT $offset, 10"; 
        }

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }
    
    public function searchCompanies($id_subscriber, $search) {
        $data = array();

        $sql = "SELECT u.* 
                FROM   companies u
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

    public function add($id_subscriber, $id, $name, $cnpj, $ie, $im, $email, $phone, $stars, $internal_obs, $address, $address_number, $address2, $address_zipcode, $address_neighb, $address_city, $address_country) {
        $id_user = $_SESSION['ccUser'];
        
        if ($id > 0) {
            $sql = "UPDATE companies
                    SET    name = '$name',
                           cnpj = '$cnpj', 
                           ie = '$ie',
                           im = '$im',
                           email = '$email', 
                           phone = '$phone', 
                           stars = '$stars', 
                           internal_obs = '$internal_obs', 
                           address = '$address', 
                           address_number = '$address_number', 
                           address2 = '$address2', 
                           address_zipcode = '$address_zipcode', 
                           address_neighb =' $address_neighb', 
                           address_city = '$address_city', 
                           address_country = '$address_country',
                           changed_id_user = $id_user,
                           changed_date = Now()
                    WHERE  id_subscriber = $id_subscriber AND
                           id = $id";

        } else {
            $sql = "INSERT INTO companies 
                    SET id_subscriber = $id_subscriber,
                        name = '$name',
                        cnpj = '$cnpj', 
                        ie = '$ie',
                        im = '$im',
                        email = '$email', 
                        phone = '$phone', 
                        stars = '$stars', 
                        internal_obs = '$internal_obs', 
                        address = '$address', 
                        address_number = '$address_number', 
                        address2 = '$address2', 
                        address_zipcode = '$address_zipcode', 
                        address_neighb =' $address_neighb', 
                        address_city = '$address_city', 
                        address_country = '$address_country',
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
        $sql = "DELETE FROM companies
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);
    }
    
    public function getCompaniesForReport($id_subscriber,$name,$order) {
        $data = array();

        $sql = "SELECT u.*
                FROM   companies u
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

}
