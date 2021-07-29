<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

namespace App\Controllers;
use App\Models\User_permission_model;
use App\Models\user_group_model;
class User_permission extends BaseController
{
    protected $user;
    //tambahan
    protected $usergroup;

    public function __construct()
    {
    $this->user = model('App\Models\User_permission_model');
    $this->usergroup = new user_group_model();
    }   
    public function pengaturan()
    {
        $data['user_group'] = $this->usergroup->findAll(); 
        return view('/setting/index', $data);
    }
	public function index()
	{
        $data['user_permission'] = $this->user->findAll();
        // dd($data);
		return view('/user_permission/test', $data);
	}
    public function edit()
    {
        //tanpa model
        $db = \Config\Database::connect();
        $data['result'] = $db->query("SELECT * FROM m_user_permission WHERE kd_group='$_GET[kd_group]'")->getResultArray();
        foreach ($data as $row => $value){
            // echo '<pre>';
            // print_r($value);
            // echo '</pre>';
        }
        return view('/user_permission/change', $data);
    }
    function update() {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // $kd_group='kd_group';
      $this->user->update_data($_POST['update'], $_POST['val_kd_group']);
      return redirect()->to('/pengaturan');
    }
}