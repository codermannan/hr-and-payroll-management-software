<?php
class Login_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function checkUser($username, $password)
    {
        $this -> db -> select('u_user_id, u_type, u_status');
        $this -> db -> from('users');
        $this -> db -> where('u_username', $username);
        $this -> db -> where('u_password', $password);
        $this -> db -> limit(1);
        $query = $this -> db -> get();
        $queryResult = $query->result();
        if($query -> num_rows() == 1)
        {
            return $queryResult;
        }
        else
        {
            return FALSE;
        }
    }
}