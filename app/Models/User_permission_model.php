<?php

// use App\Controllers\BaseController;

// defined('BASEPATH') OR exit('No direct script access allowed');
namespace App\Models;


use CodeIgniter\Model;

class User_permission_model extends Model
{
    // private $_table = 'm_user_permission';
    
    public $id;
    public $table_name;
    public $v_view;
    public $v_add;
    public $v_edit;
    public $kd_group;


    protected $table = 'm_user_permission';
    protected $allowedFields = ['v_view', 'v_add', 'v_edit'];
    
    // public function __construct()
    // {
    //     $this->load->database();
    // }

    public function update_data($data)
    {   
        
        $this->db->transStart();

        foreach ($data as $key => $value) {
            $this->db->table($this->table)->update($value, array('table_name' => $key));
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }



    }

    // function update_data($where, $dt, $table) {
    //     $this->db->where($where);
    //     $this->db->update($table, $dt);
    // }
}

?>