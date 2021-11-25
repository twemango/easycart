<?php
include_once("pdo/Db.class.php");

/**
 * 帳號會員類
 * @author      ken <ken@gogotdi.com>
 */
Class Member
{
    public $db;
    public function __construct()
    {
        $this->db = new DB;
    }
    
    /**
     * 登入帳號
     *
     * @param integer $account  帳號
     * @param integer $password  密碼
     * @return array
     */
    public function login($account, $password)
    {
        $this->db->bindMore(array("ac"=>$account, "pw"=>$password));
        $user_arr = $this->db->query("SELECT id FROM finder_user WHERE ac = :ac AND pw = :pw");
        return $user_arr;
    }
    
} 
?>