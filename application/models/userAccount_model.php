<?php

class userAccount_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getUser($email = null) {
        $sql = "select * from user_account";

        if (!empty($email)) {
            $sql = "select * from user_account where email = '{$email}'";

            $query = $this->db->query($sql);
            return $query->first_row('array');
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getUserPassword($id) {
        $sql = "select password from user_account where id = '{$id}'";

        $query = $this->db->query($sql);
        return $query->first_row('array');
    }

    public function insertUser($namaUser, $email, $password, $aksesMenu) {
        $sql = "insert into user_account (email, password, nama, akses_menu) values ('{$email}', '{$password}', '{$namaUser}', '{$aksesMenu}')";

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateUser($id, $namaUser, $email, $password, $aksesMenu) {
        $sql = "update user_account set email = '{$email}', password = '{$password}', nama = '{$namaUser}', akses_menu = '{$aksesMenu}' where id = '{$id}'";

        if (empty($password)) {
            $sql = "update user_account set email = '{$email}', nama = '{$namaUser}', akses_menu = '{$aksesMenu}' where id = '{$id}'";
        }

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }
    
    public function updatePassword($id, $password) {
        $sql = "update user_account set password = '{$password}' where id = '{$id}'";
        
        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }
    
    public function deleteUser($id) {
        $this->db->query("delete from user_account where id = '{$id}'");

        return $this->db->affected_rows();
    }

}
