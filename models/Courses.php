<?php
class Courses extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getCourse($id_subscriber, $id) {
        $sql = "SELECT * 
                FROM   courses 
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
                FROM   courses 
                WHERE  id_subscriber = $id_subscriber";
        
        $sql = $this->db->query($sql);
        
        $row = $sql->fetch();
        return $row['qtde'];
    }

    public function getList($id_subscriber, $offset) {
        $data = array();

        if ($offset == -1) {
            $sql = "SELECT u.*
                    FROM   courses u
                    WHERE  u.id_subscriber = $id_subscriber"; 
        } else {
            $sql = "SELECT u.*
                    FROM   courses u
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
                FROM   courses u
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

    public function add($id_subscriber, $id, $name) {
        $sql = "SELECT COUNT(*) as qtde 
                FROM   courses 
                WHERE  id_subscriber = $id_subscriber AND
                       name = '$name' AND
                       id <> $id";
        $sql = $this->db->query($sql);

        $row = $sql->fetch();
        if ($row['qtde'] == '0') {  
            $id_user = $_SESSION['ccUser'];
            
            if ($id > 0) {
                $sql = "UPDATE courses
                        SET    name = '$name',
                               changed_id_user = $id_user,
                               changed_date = Now()
                        WHERE  id_subscriber = $id_subscriber AND
                               id = $id";

            } else {
                $sql = "INSERT INTO courses 
                        SET id_subscriber = $id_subscriber,
                            name = '$name',
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
        $sql = "DELETE FROM courses
                WHERE id_subscriber = $id_subscriber AND
                      id = $id";
        $this->db->query($sql);
    }
    
    public function getCompaniesForReport($id_subscriber,$name,$order) {
        $data = array();

        $sql = "SELECT u.*
                FROM   courses u
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
