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
        //pakai model
        // $data['user_permission'] = $this->user->findAll();
        // return view('/user_permission/change', $data);

        // $data['user_permission'] = $this->user->where('kd_group' == "$_GET[kd_group]");
    }

    function update($id) {
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        $this->user->update_data($_POST['update']);


        // dd($this->request->getVar());


        // $this->user->save([
        //     'id' => $id,
        //     // $table_name = $this->input->post('table_name');
        //     'v_view' => $_POST['v_view'],
        //     'v_add' => $_POST['v_add'],
        //     'v_edit' => $_POST['v_edit']
        //     // $kd_group = array();
        // ]);

        // return view('/user_permission/change');


        // $id = $this->input->post('id');
        // // $table_name = $this->input->post('table_name');
        // $v_view = $this->input->post('v_view');
        // $v_add = $this->input->post('v_add');
        // $v_edit = $this->input->post('v_edit');
        // // $kd_group = array();

        // $dt = array(
        //     'v_view' => $v_view,
        //     'v_add' => $v_add,
        //     'v_edit' => $v_edit
        // );
        
        // $where = array(
        //     'id' => $id
        // );
        // $this->User_permission_model->update_data($where,$dt, 'result');
    }

	
}