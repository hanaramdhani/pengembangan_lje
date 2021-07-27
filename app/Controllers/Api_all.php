<?php

namespace App\Controllers;

header("Access-Control-Allow-Methods: GET, OPTIONS,POST");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

use CodeIgniter\HTTP\Request;

class Api_all extends BaseController
{
    private $file_upload = '';
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->am = model('App\Models\Api_m');

        // if (isset($_SESSION['sts_login']) && $_SESSION['sts_login'] == "TRUE") {
        if (!empty($_POST['token'])) {
            if (!$this->am->validate_token($_POST['token'])) {
                $this->error_occured('false_token', false);
                exit(0);
            } else {
                $this->refresh_api();
            }
        } else {
            $this->error_occured('false_token', false);
            exit(0);
        }
        // } else {
        // redirect('Load_view/login', 'refresh');
        // }

    }
    public function index()
    {
    }

    public function do_insert()
    {
        if (!is_null($this->request->getPost())) {
            $jenis_table = $this->request->getPost('jenis_table') ?? 'default';
            $error = array();
            if (!empty($this->route[$this->request->getPost('frm_table')])) {
                if ($jenis_table == "default") {
                    $table_selected = $this->route[$this->request->getPost('frm_table')];
                } else {
                    $table_selected = $this->route["t" . $this->request->getPost('frm_table')];
                }

                $table_rule = $this->am->get_rule($table_selected);
                //proses data
                foreach ($this->tables[$table_selected] as $key => $value) {
                    if (!is_null($this->request->getPost('val_' . $value))) {
                        $data_save[$value] = $this->request->getPost('val_' . $value);
                    } else {
                        if ($table_rule[$value]['allow_null'] == "NO") {
                            $error[] = $value . "wajib diisi";
                        }
                    }
                }
                $sts_upload = 1;
                // print_r($_FILES['val_lampiran']['name']);
                // print_r(empty($_FILES['val_lampiran']['name']));
                if (isset($_FILES['val_lampiran']) && !empty($_FILES['val_lampiran']['name'])) {
                    // print_r($_FILES);
                    $file = $this->request->getFile('val_lampiran');
                    $this->upload_file($file, $this->request->getPost('frm_table'));
                    if (!empty($this->file_upload)) {
                        $data_save['lampiran'] = $this->file_upload;
                    } else {
                        $sts_upload = 0;
                    }
                }
                // echo $table_selected;
                // print_r($data_save);
                //proses data
                if (!empty($data_save) && empty($error) && $sts_upload) {
                    if ($this->am->insert_single($table_selected, $data_save)) {
                        $this->error_occured('save_success', false);
                    }
                } else {
                    $this->error_occured('wrong_input', $error);
                }
            } else {
                $this->error_occured('paramater_failed', $error);
            }
        }
    }

    public function do_update($key_update, $edit_stat = '')
    {
        // echo $key_update;
        if (!is_null($this->request->getPost('frm_table'))) {
            $error = array();
            if (!empty($this->route[$this->request->getPost('frm_table')])) {
                $table_selected = $this->route[$this->request->getPost('frm_table')];
                $table_rule = $this->am->get_rule($table_selected);
                $key_selected = $this->am->get_key_table($table_selected);
                if ($edit_stat != '') {
                    foreach ($this->tables[$table_selected] as $key => $value) {
                        if (!is_null($this->request->getPost('val_' . $value))) {
                            $data_save[$value] = $this->request->getPost('val_' . $value);
                        } else {
                            if ($table_rule[$value]['allow_null'] == "NO") {
                                $error[] = $value . "wajib diisi";
                            }
                        }
                    }
                    $sts_upload = 1;
                    if (isset($_FILES['val_lampiran']) && !empty($_FILES['val_lampiran']['name'])) {
                        $file = $this->request->getFile('val_lampiran');
                        $this->upload_file($file, $this->request->getPost('frm_table'));
                        if (!empty($this->file_upload)) {
                            $data_save['lampiran'] = $this->file_upload;
                        } else {
                            $sts_upload = 0;
                        }
                    }
                    // print_r($data_save);
                    if (!is_null($this->request->getPost('key_' . $key_selected)) && !empty($data_save) && $sts_upload) {
                        $key_table = [$this->am->get_key_table($table_selected) => $this->request->getPost('key_' . $key_selected)];
                        if (empty($error)) {
                            if ($this->am->update_data($table_selected, $data_save, $key_table)) {
                                $this->error_occured('update_success', false);
                            } else {
                                $this->error_occured('wrong_input', $error);
                            }
                        } else {
                            $this->error_occured('wrong_input', $error);
                        }
                    }
                } else {
                    $key_updateable = [$key_selected => $key_update];
                    $data_updateable = $this->am->get_data_update($table_selected, $key_updateable)->getRow();
                    print json_encode($data_updateable);
                }
            } else {
                $this->error_occured('paramater_failed', $error);
            }
        }
    }

    public function do_delete($key_delete)
    {
        if (!is_null($this->request->getPost('frm_table'))) {
            $error = array();
            if (!empty($this->route[$this->request->getPost('frm_table')])) {
                $table_selected = $this->route[$this->request->getPost('frm_table')];
                $key_table = [$this->am->get_key_table($table_selected) => $key_delete];
                $del_stats=$this->am->delete_data($table_selected, $key_table);
                // print_r($del_stats);
                if ($del_stats['row_affected']) {
                    $this->error_occured('delete_success', false);
                } else {
                    $this->error_occured('failed_delete', $del_stats['err']);
                }
            } else {
                $this->error_occured('paramater_failed', $error);
            }
        }
        // $key_delete=explode('__', $key);
    }
    public function do_multi_insert_old()
    {
        $error = array();
        if (!empty($this->route[$this->request->getPost('frm_table')])) {
            foreach ($this->request->getPost('master') as $key_master => $value_master) {
                $table_selected = $this->route[$this->request->getPost('frm_table')];
                $table_rule = $this->am->get_rule($table_selected);
                foreach ($this->tables[$table_selected] as $key_validate => $value_validate) {
                    if (!empty($value_master["val_" . $value_validate])) {
                        $data_save[$table_selected][str_replace('val_', '', $value_validate)] = $value_master["val_" . $value_validate];
                    } else {

                        if ($table_rule[str_replace('val_', '', $value_validate)]['allow_null'] == "NO") {
                            $error[] = str_replace('val_', '', $value_validate) . "wajib diisi";
                        }
                    }
                }
            }

            foreach ($this->request->getPost('detail') as $key_detail => $value_detail) {
                $table_selected = $this->route[$this->request->getPost('frm_table')] . "_detail";
                $table_rule = $this->am->get_rule($table_selected);
                $data_save_tmp = array();
                foreach ($this->tables[$table_selected] as $key_dt_validate => $value_dt_validate) {
                    if (!empty($value_detail["val_" . $value_dt_validate])) {
                        $data_save_tmp[str_replace('val_', '', $value_dt_validate)] = $value_detail["val_" . $value_dt_validate];
                    } else {

                        if ($table_rule[str_replace('val_', '', $value_dt_validate)]['allow_null'] == "NO") {
                            $error[] = str_replace('val_', '', $value_dt_validate) . "wajib diisi";
                        }
                    }
                }
                if (!empty($data_save_tmp)) {
                    $data_save[$table_selected][] = $data_save_tmp;
                }
            }
            if (!empty($data_save) && empty($error)) {
                if ($this->am->multi_insert($this->request->getPost('frm_table'), $data_save)) {
                    $this->error_occured('save_success', false);
                }
            } else {
                $this->error_occured('wrong_input', $error);
            }
        } else {
            $this->error_occured('paramater_failed', $error);
        }
    }

    public function do_multi_insert()
    {
        if (!is_null($this->request->getPost())) {
            $error = array();
            if (!empty($this->route[$this->request->getPost('frm_table')])) {
                $table_selected = $this->route[$this->request->getPost('frm_table')];
                $table_rule = $this->am->get_rule($table_selected);
                if (!is_null($this->request->getPost('detail'))) {
                    foreach ($this->tables[$table_selected] as $key => $value) {
                        if (!is_null($this->request->getPost('val_' . $value))) {
                            $data_save[$table_selected][$value] = $this->request->getPost('val_' . $value);
                        } else {
                            if ($table_rule[$value]['allow_null'] == "NO") {
                                $error[] = $value . "wajib diisi";
                            }
                        }
                    }
                    //add gambar
                    $sts_upload = 1;
                    if (!empty($_FILES['val_lampiran']['name'])) {
                        $file = $this->request->getFile('val_lampiran');
                        $this->upload_file($file, $this->request->getPost('frm_table'));
                        if (!empty($this->file_upload)) {
                            $data_save[$table_selected]['lampiran'] = $this->file_upload;
                        } else {
                            $sts_upload = 0;
                        }
                    }
                    //for detail
                    $table_selected_dt = $table_selected . "_detail";
                    $table_rule = $this->am->get_rule($table_selected_dt);

                    $data_detail = $this->request->getPost('detail');
                    for ($i = 0; $i < count($data_detail); $i++) {
                        foreach ($this->tables[$table_selected_dt] as $key => $value) {
                            $value_input = ($data_detail[$i]['val_' . $value]) ?? null;
                            if (!is_null($value_input)) {
                                $data_save[$table_selected_dt][$i][$value] = $data_detail[$i]['val_' . $value];
                            } else {
                                if ($table_rule[$value]['allow_null'] == "NO") {
                                    $error[$i][] = $value . " wajib diisi";
                                }
                            }
                        }
                    }
                    if (!empty($data_save) && empty($error) && $sts_upload) {
                        if ($this->am->multi_insert($this->request->getPost('frm_table'), $data_save)) {
                            $this->error_occured('save_success', false);
                        }
                    } else {
                        $this->error_occured('wrong_input', $error);
                    }
                } else {
                    $this->error_occured('no_detail', $error);
                }
            } else {
                $this->error_occured('paramater_failed', $error);
            }
        }
    }

    public function get_data_all_post($code)
    {
        $this->am->load_data_all($code);
    }

    public function get_data_where($t_code, $code)
    {
        $this->am->load_data_where($t_code, $code);
    }

    public function refresh_api()
    {
        // print_r($this->am->refresh_table());
        // $file_json = fopen("./assets/file_json/tables.json", "w+");
        // fclose($file_json);
        // $file_path = "./assets/file_json/tables.json";
        // file_put_contents($file_path, "");
        // $file_contents = json_encode($this->am->refresh_table());
        // file_put_contents($file_path, $file_contents, FILE_APPEND | LOCK_EX);
        $this->tables = $this->am->refresh_table();
        $this->route = $this->am->route_param();
    }

    public function error_occured($err_type, $error_desc = '')
    {
        if ($err_type == "error_db") {
            $response['status'] = 1049;
            $response['error'] = true;
            $response['message'] = 'Cannot Access Database, Unknown company id';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == 'not_found') {
            $response['status'] = 404;
            $response['error'] = true;
            $response['message'] = 'not_found';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == 'false_token') {
            $response['status'] = 403;
            $response['error'] = true;
            $response['message'] = 'Forbidden access';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == 'wrong_input') {
            $response['status'] = 400;
            $response['error'] = true;
            $response['message'] = 'Wrong Input';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == 'save_success') {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Simpan Data Berhasil';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == 'update_success') {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Ubah Data Berhasil';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == 'delete_success') {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Berhasil Dihapus';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == 'failed_delete') {
            $response['status'] = 200;
            $response['error'] = true;
            $response['message'] = 'Data Gagal Dihapus';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == "paramater_failed") {
            $response['status'] = 401;
            $response['error'] = true;
            $response['message'] = 'Unknown Command Parameter';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == "login_success") {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Login Berhasil';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == "login_failed") {
            $response['status'] = 407;
            $response['error'] = true;
            $response['message'] = 'Gagal Login, Username atau Password Salah';
            $response['error_desc'] = $error_desc;
        } elseif ($err_type == "no_detail") {
            $response['status'] = 408;
            $response['error'] = true;
            $response['message'] = "Master Detail, Doesn't have detail";
            $response['error_desc'] = $error_desc;
        }
        print(json_encode($response));
    }

    public function upload_file($file, $page)
    {
        $name = $file->getName(); // Mengetahui Nama File
        $originalName = $file->getClientName(); // Mengetahui Nama Asli
        $tempfile = $file->getTempName(); // Mengetahui Nama TMP File name
        $ext = $file->getClientExtension(); // Mengetahui extensi File
        $type = $file->getClientMimeType(); // Mengetahui Mime File
        $size_kb = $file->getSize('kb'); // Mengetahui Ukuran File dalam kb
        $size_mb = $file->getSize('mb'); // Mengetahui Ukuran File dalam mb

        //$namabaru = $file->getRandomName();//define nama fiel yang baru secara acak

        if ($type == (('image/png') or ('image/jpeg'))) //cek mime file
        { // File Tipe Sesuai
            $image = \Config\Services::image('gd'); //Load Image Libray
            $info = $image->withFile($file)->getFile()->getProperties(true); //Mendapatkan Files Propertis
            $width = $info['width']; // Mengetahui Image Width
            $height = $info['height']; // Mengetahui Image Height

            helper('filesystem'); // Load Helper File System
            $direktori = ROOTPATH . '/public/img/' . $page; //definisikan direktori upload
            $namabaru = $originalName; //definisikan nama fiel yang baru
            $map = directory_map($direktori, false, true); // List direktori

            /* Cek File apakah ada */
            foreach ($map as $key) {
                if ($key == $namabaru) {
                    delete_files($direktori, $namabaru); //Hapus terlebih dahulu jika file ada
                }
            }
            //Metode Upload Pilih salah satu
            //$path = $this->request->getFile('uploadedFile')->store($direktori, $namabaru);
            //$file->move($direktori, $namabaru)
            if ($file->move($direktori, $namabaru)) {
                $this->file_upload = $namabaru;
                // return 1;
                // return redirect()->to(base_url('uploadfile?msg=Upload Berhasil'));
            } else {
                // return "upload gagal"
                // return redirect()->to(base_url('uploadfile?msg=Upload Gagal'));
            }
        } else {
            // return "Format File Salah";
            // File Tipe Tidak Sesuai
            // return redirect()->to(base_url('uploadfile?msg=Format File Salah'));
        }
    }
    public function get_ongkir()
    {
        $layanan = $_POST['layanan'];
        $jenis_kirim = $_POST['jenis_kirim'];
        $lokasi_asal = $_POST['lokasi_asal'];
        $lokasi_tujuan = $_POST['lokasi_tujuan'];
        $ongkir = $this->am->get_ongkir($layanan, $jenis_kirim, $lokasi_asal, $lokasi_tujuan)->getRow();
        if (!empty($ongkir)) {
            $ongkir->status = 200;
        } else {
            $ongkir['status'] = 500;
        }
        echo json_encode($ongkir);
    }
    public function get_lokasi_auto_complete()
    {
        $condition = array();
        $result = array();
        $search_key = $this->request->getPost('search_key');
        $find_type = $this->request->getPost('find_type');
        $find_condition = $this->request->getPost('find_condition');
        if (!empty($find_condition)) {
            if ($find_type == 'kota_asal') {
                $condition['kota_tujuan'] = $find_condition;
                $class_ul = "li-kota-asal";
                $search_like['kota_asal'] = $search_key;
            } elseif ($find_type = 'kota_tujuan') {
                $condition['kota_asal'] = $find_condition;
                $class_ul = "li-kota-tujuan";
                $search_like['kota_tujuan'] = $search_key;
            }
        } else {
            if ($find_type == 'kota_asal') {
                $class_ul = "li-kota-asal";
                $search_like['kota_asal'] = $search_key;
            } elseif ($find_type = 'kota_tujuan') {
                $class_ul = "li-kota-tujuan";
                $search_like['kota_tujuan'] = $search_key;
            }
        }

        $result = $this->am->get_lokasi_auto_complete($condition, $search_like, $find_type)->getResultArray();
        $output = '<ul class="list-unstyled" style="background-color:white;cursor:pointer;width:100%; position:absolute;box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);border-radius: 0px 0px 5px 5px;">';
        if (count($result) > 0) {
            foreach ($result as $key_result => $value_result) {
                $output .= '<li class="autocomplete_li ' . $class_ul . '" data-key="' . $value_result['kd_' . $find_type] . '" style="padding:12px;">' . $value_result[$find_type] . '</li>';
            }
        } else {
            $output .= '<li class="autocomplete_li" data-key="" style="padding:12px;border:thin solid #F0F8FF;">Tidak ada yang cocok.</li>';
        }
        $output .= '</ul>';
        echo $output;
    }
    public function get_jenis_kirim()
    {
        $condition['kd_kota_asal'] = $_POST['kd_kota_asal'];
        $condition['kd_kota_tujuan'] = $_POST['kd_kota_tujuan'];
        if (!empty($_POST['kd_layanan'])) {
            $condition['kd_layanan'] = $_POST['kd_layanan'];
        }
        $jenis_kirim = $this->am->get_data_update('v_get_ready_ongkir', $condition)->getResult();
        $output = '';
        if (count($jenis_kirim) > 0) {
            foreach ($jenis_kirim as $key_jenis_kirim => $value_jk) {
                $output .= '<option value="' . $value_jk->kd_jenis . '">' . $value_jk->jenis_kirim . '</option>';
            }
        } 
        echo $output;
    }
    public function get_layanan()
    {
        $condition['kd_kota_asal'] = $_POST['kd_kota_asal'];
        $condition['kd_kota_tujuan'] = $_POST['kd_kota_tujuan'];
        if (!empty($_POST['kd_jenis_kirim'])) {
            $condition['kd_jenis'] = $_POST['kd_jenis_kirim'];
        }
        $layanan = $this->am->get_data_update('v_get_ready_ongkir', $condition)->getResult();
        $output = '';
        if (count($layanan) > 0) {
            foreach ($layanan as $key_layanan => $value_jk) {
                $output .= '<option value="' . $value_jk->kd_jenis . '">' . $value_jk->layanan . '</option>';
            }
        }
        // else {
        //     $output .= '<option value="">Pilih Lokasi</option>';
        // }
        echo $output;
    }

    public function get_data_manifest()
    {
        $manifest_reff = $_POST['reff_manifest'];
        $manifest = array();
        if (!empty($manifest_reff)) {
            $result_manifest = $this->am->get_data_update('v_manifest_in', array('no_transaksi' => $manifest_reff))->getResult();
            $no_pengiriman = array();
            $refferensi = array();
            $deskripsi = array();
            $subtotal = array();
            if (!empty($result_manifest)) {
                foreach ($result_manifest as $key_manifest => $value_manifest) {
                    $no_pengiriman = explode(',', $value_manifest->no_pengiriman);
                    $refferensi = explode(',', $value_manifest->refferensi);
                    $deskripsi = explode(',', $value_manifest->deskripsi);
                    $subtotal = explode(',', $value_manifest->subtotal);
                }
                $manifest['master'] = $result_manifest;
                $detail_manifest = array();
                if (count($no_pengiriman) > 0) {
                    for ($i = 0; $i < count($no_pengiriman); $i++) {
                        $detail_manifest[$i]['no_pengiriman'] = $no_pengiriman[$i];
                        $detail_manifest[$i]['refferensi'] = (isset($refferensi[$i])) ? $refferensi[$i] : '';
                        $detail_manifest[$i]['deskripsi'] = (isset($deskripsi[$i])) ? $deskripsi[$i] : '';
                        $detail_manifest[$i]['tanggal_pengiriman'] = (isset($tanggal_pengiriman[$i])) ? $tanggal_pengiriman[$i] : '';
                        $detail_manifest[$i]['subtotal'] = (isset($subtotal[$i])) ? $subtotal[$i] : '';
                    }
                }

                $manifest['detail'] = json_decode(json_encode($detail_manifest));
            }
        }

        if (count($manifest) > 0) {
            $manifest['status'] = 200;
        } else {
            $manifest['status'] = 0;
            $manifes['message'] = "0 record(s) found";
        }
        // echo "<pre>";
        // print_r($manifest);
        // echo "<pre>";
        echo json_encode($manifest);
    }
    public function save_manifest_in()
    {
        $no_transaksi = $_POST['no_transaksi'];
        $no_pengiriman = $_POST['no_pengiriman'];
        if ($this->am->do_update_manifest_in($no_transaksi, $no_pengiriman)) {
            $this->error_occured('save_success', false);
        } else {
            $this->error_occured('wrong_input', false);
        }
    }

    public function cek_no_pengiriman($no_transaksi)
    {
        $data_pembelian = $this->am->get_pengiriman_all($no_transaksi)->getRow();
        // print_r(count($data_pembelian);
        if ($data_pembelian) {

            $data_pembelian->status = 200;
            // print_r($data_pembelian);

        } else {
            $data_pembelian['status'] = 500;
        }
        echo json_encode($data_pembelian);
    }
    public function get_minimal_wv($kd_asal, $kd_tujuan, $kd_jenis, $kd_layanan, $key_update)
    {
        $condition = array(
            'kd_kota_asal' => $kd_asal,
            'kd_kota_tujuan' => $kd_tujuan,
            'kd_layanan' => $kd_layanan,
            'kd_jenis' => $kd_jenis,
        );
        $data['kirim_selected'] = $this->am->get_min_wv($condition)->getRow();
        $data['edit_data'] = $this->am->get_data_update('v_t_pengiriman_detail', array('nomor' => $key_update))->getRow();
        $data['modal'] = true;
        $data['page'] = 'pengiriman_detail';
        $data['jenis'] = 'pengiriman';
        $data['act'] = 'edit';
        $data['key'] = $key_update;
        $file_path = $data['jenis'] . "/" . $data['page'] . '/ajax_' . $data['page'];
        echo view($file_path, $data);
        // echo json_encode($response);
    }

    public function get_customer()
    {
        $kd_customer = $_POST['kd_customer'];
        $data['customer'] = $this->am->get_cust($kd_customer)->getResult();
        $data['type'] = 'cari_customer';
        echo view('pengiriman/pengiriman/cari_customer', $data);
        // print_r($data);
    }
    public function get_kabupaten_auto_complete()
    {

        $search_key['nama'] = $this->request->getPost('kabupaten_name');
        $result = $this->am->get_where_like('m_kabupaten', $search_key)->getResultArray();
        $output = '<ul class="list-unstyled" style="background-color:white;cursor:pointer;width:100%; position:absolute">';
        if (count($result) > 0) {
            foreach ($result as $key_result => $value_result) {
                $output .= '<li class="autocomplete_li kabupaten-list" data-key="' . $value_result['kd_kabupaten'] . '" style="padding:12px;border:thin solid #F0F8FF;">' . $value_result['nama'] . '</li>';
            }
        } else {
            $output .= '<li class="autocomplete_li" data-key="" style="padding:12px;border:thin solid #F0F8FF;">Tidak ada yang cocok.</li>';
        }
        $output .= '</ul>';
        echo $output;
    }
    public function save_update_master_detail()
    {

        $master = $_POST['mt'];
        $detail = $_POST['dt'];
        
        if (!empty($this->request->getPost('frm_table'))) {
            $table_selected = $this->am->master_detail_table($this->request->getPost('frm_table'));
            $table_rule_master = $this->am->get_rule($table_selected[0]);
            $table_rule_detail = $this->am->get_rule($table_selected[1]);
            $key_selected = $this->am->get_key_table($table_selected[0]);
            $data_save=array();
            $error=array();
            $data_key='';
            
            $key_update_master=$this->am->get_key_table('t_'.$this->request->getPost('frm_table'));
            $key_update_detail=$this->am->master_detail_reff('t_'.$this->request->getPost('frm_table').'_detail');
            foreach ($this->tables[$table_selected[0]] as $key_master_selected => $value_master_selected) {
                $col_data=$master['val_'.$value_master_selected] ?? null;     
                if (!is_null($col_data)) {
                    $data_save['master'][$value_master_selected] = $master['val_' . $value_master_selected];
                } else {
                    if ($table_rule_master[$value_master_selected]['allow_null'] == "NO") {
                        $error[] = $value_master_selected . "wajib diisi";
                    }
                }
            }

            foreach ($this->tables[$table_selected[1]] as $key_detail_selected => $value_detail_selected) {
                // echo $detail['key_no_transaksi'];
                $col_data=$detail['val_'.$value_detail_selected] ?? null;

                if (!is_null($col_data)) {
                    $data_save['detail'][$value_detail_selected] = $detail['val_' . $value_detail_selected];
                } else {
                    if ($table_rule_detail[$value_detail_selected]['allow_null'] == "NO") {
                        $error[] = $value_detail_selected . "wajib diisi";
                    }
                }
                
            }
            // print_r($key_update_detail) ;

            // print_r($master);
            // print_r($key_update);
            $sts_upload = 1;
            if (isset($_FILES['val_lampiran']) && !empty($_FILES['val_lampiran']['name'])) {
                $file = $this->request->getFile('val_lampiran');
                $this->upload_file($file, $this->request->getPost('frm_table'));
                if (!empty($this->file_upload)) {
                    $data_save['master']['lampiran'] = $this->file_upload;
                } else {
                    $sts_upload = 0;
                }
            }
            // echo "<pre>";
            // print_r($data_save);
            // echo "</pre>";
            if (!empty($key_update_master) && !empty($key_update_detail) && !empty($data_save['master']) && !empty($data_save['detail']) && $sts_upload) {
                $key_table['master'] = [$key_update_master => $this->request->getPost('mt')['key_' . $key_update_master]];
                $key_table['detail'] = [$key_update_detail => $this->request->getPost('dt')['key_' . $key_update_detail]];
                
                if (empty($error)) {
                    // print_r($data_save);
                    if ($this->am->update_data_mt_single($table_selected, $data_save, $key_table)) {
                        $this->error_occured('update_success', false);
                    } else {
                        $this->error_occured('wrong_input', $error);
                    }
                } else {
                    $this->error_occured('wrong_input', $error);
                }
            }


        }
    }
    public function save_user_pegawai(){
        // print_r($_POST);
        $error = array();
        $data_post=$_POST;
        $data_user['table']='m_userx';
        $data_user['val']=array(
            'nama'=>$data_post['val_nama'],
            'passwd'=>md5($data_post['val_passwd']),
            'kd_group'=>$data_post['val_kd_group'],
            'status'=>1
        );
        if ($data_post['frm_type']=="add") {
            $data_user['key']='';
        }else{
            $data_user['key']=$data_post['key_kd_user'];
        }
        $data_pegawai=array();
        $data_pegawai['table'] = 'm_pegawai';
        $data_pegawai['key']['kd_pegawai'] = $data_post['val_kd_pegawai'];
        $sts_upload = 1;
        if (isset($_FILES['val_lampiran']) && !empty($_FILES['val_lampiran']['name'])) {
            $file = $this->request->getFile('val_lampiran');
            $this->upload_file($file, $this->request->getPost('frm_table'));
            if (!empty($this->file_upload)) {
                $data_pegawai['val']['lampiran'] = $this->file_upload;
            } else {
                $sts_upload = 0;
            }
        }
        if (!empty($data_user) && $sts_upload) {
            if ($this->am->user_crud($data_user,$data_pegawai)) {
                $this->error_occured('save_success', false);
            }
        } else {
            $this->error_occured('wrong_input', $error);
        }
        
    }
    public function get_cicilan_piutang($no_pengiriman){
        $condition=array('no_pengiriman'=>$no_pengiriman);
        $data_cicilan=$this->am->get_data_where_general('v_t_pembayaran',$condition)->getResult();
        echo json_encode($data_cicilan);
    }
    public function get_detail_piutang_aktif($key){
        $condition=array('no_pengiriman'=>$key);
        $data['pembayaran']=$this->am->get_data_where_general('v_t_pembayaran',$condition)->getResult();
        $data['invoice']=$this->am->get_data_where_general('v_t_invoice_detail',$condition)->getResult();
        $data['act']='show_detail';
        echo view('laporan/ajax_lap_piutang_aktif',$data);
    }
    public function get_tagihan_pembayaran(){
        // $this->am->get_data_where_general('')
    }
    public function get_invoice_belum_dibayar(){
        $result_invoice=$this->am->get_data('v_invoice_belum_terbayar','')->getResult();
        $no_invoice_dt = array();
        $reff_dt = array();
        $subtotal_dt = array();
        $total_bayar_dt = array();
        $tanggal_bayar_dt = array();
        $invoice['master'] = $result_invoice;
        $detail_invoice = array();
        if (!empty($result_invoice)) {
            foreach ($result_invoice as $key_invoice => $value_invoice) {

                $no_invoice_dt = explode(',', $value_invoice->no_transaksi_dt_invoice);
                $reff_dt = explode(',', $value_invoice->reff_pengiriman);
                $subtotal_dt = explode(',', $value_invoice->subtotal_dt_invoice);
                $total_bayar_dt = explode(',', $value_invoice->total_bayar_dt_invoice);
                $angsuran_dt= explode(',', $value_invoice->angsuran_dt_invoice);
                $tanggal_bayar_dt= explode(',', $value_invoice->tanggal_bayar_dt_invoice);

                if (count($no_invoice_dt) > 0) {
                    for ($i = 0; $i < count($no_invoice_dt); $i++) {
                        $detail_invoice["detail_".$value_invoice->no_invoice][$i]['no_invoice_dt'] = $no_invoice_dt[$i];
                        $detail_invoice["detail_".$value_invoice->no_invoice][$i]['reff_pengiriman_dt'] = $reff_dt[$i];
                        $detail_invoice["detail_".$value_invoice->no_invoice][$i]['subtotal_dt'] = (isset($subtotal_dt[$i])) ? $subtotal_dt[$i] : '';
                        $detail_invoice["detail_".$value_invoice->no_invoice][$i]['total_bayar_dt'] = (isset($total_bayar_dt[$i])) ? $total_bayar_dt[$i] : '';
                        $detail_invoice["detail_".$value_invoice->no_invoice][$i]['angsuran_dt'] = (isset($angsuran_dt[$i])) ? $angsuran_dt[$i] : '';
                        $detail_invoice["detail_".$value_invoice->no_invoice][$i]['tanggal_bayar_dt'] = (isset($tanggal_bayar_dt[$i])) ? $tanggal_bayar_dt[$i] : '';
                    }
                }
            }
            $invoice['detail'] = json_decode(json_encode($detail_invoice));
        }
        $invoice['kas']=$this->am->get_data('m_kas','')->getResult(); 
        $invoice['jenis_bayar']=$this->am->get_data('m_jenis_bayar','')->getResult(); 
        $invoice['act']="show_invoice_pending";
        echo view('pengiriman/invoice/ajax_invoice',$invoice);
        // echo "<pre>";
        // print_r($invoice);
        // echo "</pre>";
    }
    public function save_pembayaran_invoice(){
        // print_r($_POST);
        $get_pengiriman_invoice=$this->am->get_data_where_general('v_pengiriman_invoice_belum_lunas',array('no_invoice'=>$_POST['val_no_invoice']))->getResult();
        $nominal_bayar=$_POST['val_nominal'];
        // print_r($get_pengiriman_invoice);
        $data_save=array();
        foreach ($get_pengiriman_invoice as $key => $value) {
            if ($nominal_bayar>0) {
                if ($nominal_bayar > $value->sisa_cicilan) {
                    $nominal_save=$value->sisa_cicilan;
                    $nominal_bayar-=$nominal_save;
                }else{
                    $nominal_save=$nominal_bayar;
                }
                $data_save[]=array(
                    'nomor_reff'=>$_POST['val_nomor_reff'],
                    'no_pengiriman'=>$value->no_pengiriman,
                    'kd_jenis_bayar'=>$_POST['val_kd_jenis_bayar'],
                    'kd_kas'=>$_POST['val_kd_kas'],
                    'nominal'=>$nominal_save,
                    'keterangan'=>$_POST['val_keterangan']
                );
            }
        }
        $data_save_final['t_pembayaran']=$data_save;
        if ($this->am->multi_insert_general($data_save_final)) {
            $this->error_occured('save_success', false);
        }else{
            $this->error_occured('wrong_input', false);
        }
    }
    public function get_pengiriman_belum_lunas(){
        $data['pengiriman_belum_lunas']=$this->am->get_data_where_general('v_pengiriman_belum_lunas',array('kd_customer'=>$_POST['kd_customer']))->getResult();
        $data['act']='show_pengiriman';
        echo view('pengiriman/pembayaran/ajax_pembayaran',$data);
    }
    public function ajax_load_customer($start){
        $target_file=$_POST['file_name'];
        $condition=array('status'=>1);
        $data['customer']=$this->am->get_data_where_order_limit('v_m_customer',$condition,'nama',$start,20)->getResult();
        $data['act']=$_POST['act'];
        $data['modal']=true;
        $data['page']=$_POST['page'];
        $data['jenis']=$_POST['jenis'];
        $data['last_start']=$start;
        // print_r($data);
        echo view($target_file,$data);
    }
    function load_invoice_by_customer(){
        $kd_customer=$_POST['kd_customer'];
        $data['data_pengiriman']=$this->am->get_data_where_general('v_data_pengiriman',array('kd_customer'=>$kd_customer))->getResult();
        $data['act']='load_pengiriman';
        echo view('pengiriman/invoice/ajax_invoice_load_pengiriman',$data);
    }
    public function load_pengiriman_manifest(){
        $divisi=$_POST['divisi'];
        $data['data_pengiriman_manifest_out']=$this->am->get_data('v_data_pengiriman_manifest_out',array('kd_divisi'=>$divisi))->getResult();
        $data['act']='load_pengiriman';
        echo view('pengiriman/manifest_out/ajax_load_pengiriman_manifest',$data);
    }
    public function load_manifest_out_for_in(){
        $filter=$_POST['no_manifest']=$_POST['reff_manifest'];
        $data['manifest_dt']=$this->am->get_data_where_general('v_load_manifest_out_for_in',array('no_manifest'=>$filter))->getResult();
        if (count($data['manifest_dt'])>0) {
            $data['act']="load_detail_manifest_out";
            echo view('pengiriman/manifest_in/ajax_load_detail_manifest_out',$data);
        }
    }
    public function load_manifest_out_dt(){
        $filter=$_POST['key_manifest'];
        $data['manifest_dt']=$this->am->get_data_where_general('v_load_manifest_out_for_in',array('no_manifest'=>$filter))->getResult();
        if (count($data['manifest_dt'])>0) {
            $data['act']="load_detail_manifest_out_general";
            echo view('pengiriman/manifest_in/ajax_load_detail_manifest_out',$data);
        }
    }
    public function load_invoice_dt(){
        $filter=$_POST['key_invoice'];
        $data['manifest_dt']=$this->am->get_data_where_general('v_load_invoice_dt',array('no_invoice'=>$filter))->getResult();
        if (count($data['manifest_dt'])>0) {
            $data['act']="load_detail_manifest_out_general";
            echo view('pengiriman/manifest_in/ajax_load_detail_manifest_out',$data);
        }
    }

}