<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{

    public function __construct()
    {
        $this->am = model('App\Models\Api_m');
        $this->session = \Config\Services::session();
        if (isset($_SESSION['sts_login']) && $_SESSION['sts_login'] == "TRUE") {
            $this->login = true;
        } else {
            $this->login = false;
        }
    }

    public function index()
    {
        if ($this->login) {
            return redirect()->route("load");
        } else {
            // echo "dd";
            // echo view('header');
            echo view('login');
            // echo view('footer');
        }
    }
    public function do_login()
    {
        // print_r($_POST);
        $data_login = array(
            'nama' => $_POST['val_username'],
            'passwd' => md5($_POST['val_password'])
        );
        // print_r($data_login);
        // $this->request->post();
        if ($this->am->auth($data_login)->getNumRows() > 0) {
            $login = $this->am->auth($data_login)->getRow();
            $token = $this->am->get_generated_token();
            $data_sess = array(
                'kd_user' => $login->kd_user,
                'nama' => $login->nama,
                'kd_group' => $login->kd_group,
                'group_user' => $login->group_user,
                'lampiran' => $login->lampiran,
                'deskripsi' => $login->deskripsi,
                'kd_divisi' => $login->kd_divisi,
                'divisi' => $login->divisi,
                'kd_pegawai' => $login->kd_pegawai,
                'pegawai' => $login->pegawai,
                'lokasi_def' => $login->lokasi_def,
                'kd_lokasi' => $login->kd_lokasi,
                'sts_login' => "TRUE",
                'token' => '123',
            );
            // print_r($data_sess);
            $this->session->set($data_sess);
            $this->am->set_user_login($data_sess['kd_user'], $data_sess['token']);
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Login Berhasil';
            $response['error_desc'] = '';
            // $this->error_occured('login_success', false);
            // print_r($_SESSION);
            // print_r($data_sess);
        } else {
            $response['status'] = 407;
            $response['error'] = true;
            $response['message'] = 'Gagal Login, Username atau Password Salah';
            $response['error_desc'] = '';
        }
        print(json_encode($response));
    }
    function do_logout()
    {
        $this->session->destroy();
        return redirect()->route("/");
    }
}