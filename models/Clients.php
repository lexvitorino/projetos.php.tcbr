<?php
class Clients extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getClient($id_subscriber, $id) {
        $sql = "SELECT * 
                FROM   clients 
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
                FROM   clients 
                WHERE  id_subscriber = $id_subscriber";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }
    
    public function getList($id_subscriber, $offset) {
        $data = array();

        $sql = "SELECT u.*, c.name as company 
                FROM   clients u
                  LEFT JOIN companies c on c.id = u.id_company
                WHERE  u.id_subscriber = $id_subscriber";
        
        if ($offset>=0) {
          $sql .= " LIMIT $offset, 10";
        } 

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }
    
    public function searchClients($id_subscriber, $search) {
        $data = array();

        $sql = "SELECT u.*, c.name as company 
                FROM   clients u
                  LEFT JOIN companies c on c.id = u.id_company
                WHERE  u.id_subscriber = $id_subscriber AND
                       u.name like '%$search%' OR
                       u.id = '$search' OR
                       c.name like '$search'
                LIMIT 10"; 

        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }        

        return $data;
    }

    public function add($id_subscriber, $id, $name, $cpf, $rg, $email, $phone, $stars, $internal_obs, $address, $address_number, $address2, $address_zipcode, $address_neighb, $address_city, $address_country, $id_company) {
        $id_user = $_SESSION['ccUser'];

        if ($id > 0) {
            $sql = "UPDATE clients
                    SET    name = '$name',
                           cpf = '$cpf', 
                           rg = '$rg',
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
                           id_company = $id_company,
                           changed_id_user = $id_user,
                           changed_date = Now()
                    WHERE  id_subscriber = $id_subscriber AND
                           id = $id";

        } else {
            $sql = "INSERT INTO clients 
                    SET id_subscriber = $id_subscriber,
                        name = '$name',
                        cpf = '$cpf', 
                        rg = '$rg',
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
                        id_company = $id_company,
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
        $sql = "DELETE FROM clients
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);
    }
    
    public function getClientsForReport($id_subscriber,$dtInicial,$dtFinal,$name,$id_company,$order) {
        $data = array();

        $sql = "SELECT u.*, c.name as company 
                FROM   clients u
                  LEFT JOIN companies c on c.id = u.id_company
                WHERE ";

        $where = array();
        $where[] = "u.id_subscriber = $id_subscriber"; 

        if(!empty($name)) {
          $where[] = "u.name like '$name'"; 
        }

        if(!empty($dtInicial) && !empty($dtFinal)) {
          $where[] = "u.course_date between '$dtInicial' AND '$dtFinal'"; 
        }

        if(!empty($id_company)) {
          $where[] = "u.id_company = $id_company"; 
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
