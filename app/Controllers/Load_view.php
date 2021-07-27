<?php

namespace App\Controllers;

use App\Models\user_group_model;

class Load_view extends BaseController
{
    


    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->am = model('App\Models\Api_m');
        // print_r($_SESSION);
        // $sess = array('sts_login' => "TRUE");
        // $this->session->set($sess);
        
        

        if (isset($_SESSION['sts_login']) && $_SESSION['sts_login'] == "TRUE") {
            $this->login = true;
            $this->am->refresh_table();
            date_default_timezone_set('Asia/Jakarta');
        // print_r($this->am->get_table());
        } else {
            $this->login = false;
        }
    }
    public function index()
    {
        // echo "sdfasdjh";
        if ($this->login) {
            $this->load_page(false);
        } else {
            return redirect()->route("login");
        }
    }

    public function load_page($act = '', $page = '', $jenis = '', $key = -1)
    {

        // $uri = current_url(true);
        // echo (string) $uri;
        // echo base_url().;

        if ($this->login) {
            $data_permission=array();
            if (!empty($act) && !empty($page)) {
                $arr_permission=array(
                    'tbl_name'=>$this->am->route_param()[$page],
                    'col'=>'v_'.$act,
                    'kd_group'=>$_SESSION['kd_group'],
                );
                $data_permission=$this->am->get_permission($arr_permission)->getRow();
                $status=false;
                // print_r($data_permission);
                $col= $arr_permission['col'];
                // echo $data_permission->$col;
                if (!empty($data_permission)) {
                    if ($data_permission->$col==0) {
                        $this->session->setFlashdata('page_failed', "Sory, you don't have permission to access this page");
                        return redirect()->route("/");
                        ;
                    }
                }
                // echo "<pre>";
                // print_r($data_permission);
                // echo "</pre>";
            }
            

            // $this->load_page(false);
        } else {
            return redirect()->route("login");
        }
        define('EXT', '.php');
        if (!empty($jenis)) {
            if ($jenis == "null") {
                $jenis = '';
            } else {
                $jenis = $jenis . "/";
            }
        }
        if (!empty($page) && !empty($this->am->route_param()[$page])) {
            $table = $this->am->route_param()[$page];
            $data = array();

            // if (!empty($this->am->table_foreign()[$table])) {
            //      foreach ($this->am->table_foreign()[$table] as $key_foreign => $value_foreign) {
            //          $data[substr($value_foreign, 2)] = $this->am->get_data($value_foreign)->getResult();
            //      }
            //      // print_r($data);
            //  }

            $file_path = $jenis . $page . '/home_' . $page;
            if (file_exists(APPPATH . "views/{$file_path}" . EXT)) {
                if ($act == "add" || $act == "edit" || $act == "view") {
                    $data['act'] = $act;
                    $data['key'] = $key;
                    $data['page_header'] = $this->am->get_alias($page);
                    // echo view('header');
                    // print_r($data);
                    if ($act == "edit" && $data['key'] == '-1') {
                        return redirect()->route("/");
                    } else {
                        echo view($file_path, $data);
                    }
                    // echo view('footer');
                } else {
                    echo view('errors/html/error_404');
                }
            } else {
                echo view('errors/html/error_404');
            }
            // echo view();
        } else {
            $bulan_ini = date('Y-m-d', strtotime('first day of this month'))." - ".date('Y-m-d', strtotime('last day of this month'));
            $bulan_lalu = date('Y-m-d', strtotime('first day of last month'))." - ".date('Y-m-d', strtotime('last day of last month'));
            
            $data_dashboard1=$this->am->get_data('v_dashboard', '')->getResultArray();
            $data_dashboard2=$this->am->get_data_dashboard_laba_rugi($bulan_ini)->getResultArray();
            $data_dashboard3=$this->am->get_data_dashboard_laba_rugi($bulan_lalu)->getResultArray();
            foreach ($data_dashboard2 as $key_dashboard2 => $value_dashboard2) {
                $laporan_rugi1[$value_dashboard2['Keterangan']][]=$value_dashboard2['Nominal'];
            }
            foreach ($data_dashboard3 as $key_dashboard3 => $value_dashboard3) {
                $laporan_rugi2[$value_dashboard3['Keterangan']][]=$value_dashboard3['Nominal'];
            }
            foreach ($data_dashboard1 as $key_dashboard1 => $value_dashboard1) {
                $laporan_general[$value_dashboard1['title']][]=array($value_dashboard1['key_dashboard']=>$value_dashboard1['value_dashboard'],'keterangan'=>$value_dashboard1['keterangan']);
            }
            
            foreach ($laporan_general as $key_general => $value_general) {
                $data_laporan['laporan'][$key_general]=$value_general;
            }
            $data_laporan['laporan']['laba'][]=array(
                'Bulan Ini'=>$laporan_rugi1['Laba Bersih'][0],
                'keterangan'=>'Rp',
            );
            $data_laporan['laporan']['laba'][]=array(
                'Bulan Lalu'=>$laporan_rugi2['Laba Bersih'][0],
                'keterangan'=>'Rp'
            );
            $data_laporan['link']=array(
                'pengiriman'=>"load/laporan/omzet_pengiriman",
                'invoice'=>"load/view/invoice/pengiriman",
                'laba'=>"load/laporan/laba_rugi"
            );
            // $data_laporan['laporan']
            // echo "<pre>";
            // print_r($data_laporan);
            // print_r($laporan_general);
            // echo "</pre>";

            // echo view('header');
            echo view('dashboard', $data_laporan);
            // echo view('modal');
            // echo view('footer');
        }
    }
    public function login()
    {
        echo view('header');
        echo view('login');
        echo view('footer');
    }
    public function ajax_load($act, $page, $jenis, $key = -1, $modal = false)
    {
        define('EXT', '.php');
        if (!empty($jenis)) {
            if ($jenis == 'null') {
                $jenis = '';
            } else {
                $jenis = $jenis . "/";
            }
        }


        if (!empty($page)) {
            $table = $this->am->route_param()[$page];
            $data = array();
            // if (($this->am->master_detail_table($page))) {
            //     $data_detail=$this->am->master_detail_table($page);
            // }else{
            //     $data_detail=array();
            // }
            $data_divisi = array();
            if ($this->am->get_data_perdivisi($table) && !empty($this->kd_divisi)) {
                // $data_divisi = array('kd_divisi' => $_SESSION['kd_divisi']);
                $data_divisi = array('kd_divisi' => $this->kd_divisi);
            }
            $data_detail = $this->am->master_detail_table($page);
            // print_r($data_detail);
            // $data_detail=array_key_exists($this->am->master_detail_table($page)) ? $this->am->master_detail_table($page):array();
            if (!empty($data_detail)) {
                foreach ($data_detail as $key_data_detail => $value_data_detail) {
                    $data[substr($value_data_detail, 2)] = $this->am->get_data($value_data_detail, $data_divisi)->getResult();
                }
            } else {
                if (in_array($table, $this->am->get_table())) {
                    $data[$page] = $this->am->get_data($table, $data_divisi)->getResult();
                }
            }

            if ($act == "view") {
            } else {
                if (!empty($this->am->table_foreign()[$table])) {
                    foreach ($this->am->table_foreign()[$table] as $key_table => $value_table) {
                        // print_r($key_table);
                        $data_divisi_foreign = array();
                        if ($this->am->get_data_perdivisi($key_table) && !empty($this->kd_divisi)) {
                            $data_divisi_foreign = array('kd_divisi' => $this->kd_divisi);
                            // $data_divisi_foreign = array('kd_divisi' => $_SESSION['kd_divisi']);
                        }
                        if (!empty($value_table)) {
                            $data[substr($key_table, 2)] = $this->am->get_data_where($key_table, $value_table)->getResult();
                        } else {
                            $data[substr($key_table, 2)] = $this->am->get_data($key_table, $data_divisi_foreign)->getResult();
                        }
                    }
                }
            }
            if ($key != -1 && $act == 'edit') {
                if ($page=='manifest_in') {
                    $condition=array('no_transaksi'=>$key);
                    $data['edit_data'] = $this->am->get_data_update('v_t_manifest', $condition)->getRow();
                    $link_view = site_url('load/view/manifest_out/'.$jenis);
                } else {
                    $condition = array(
                        $this->am->get_key_table($table) => $key,
                    );
                    $link_view = site_url('load/view/'.$page."/".$jenis);

                    $data['edit_data'] = $this->am->get_data_update($table, $condition)->getRow();
                }
                
                // print_r($data['edit_data']);
            }
            // if (!empty($this->am->get_custom_data($page))) {
            //     $custom_data=$this->am->get_custom_data($page);
            //     foreach ($custom_data['table'] as $key_custom => $value_custom) {
            //         $key_table_custom=(preg_match('/manifest/', $value_custom))?'no_transaksi':$this->am->get_key_table($value_custom);
            //         $data[substr($value_custom, 2)] = $this->am->get_data($value_custom, $data_divisi)->getResult();
            //         $custom_stats=$custom_data['custom_col'][$value_custom]??array();
            //         $data[substr($value_custom, 2)."_detail"]=array();
            //         if (!empty($custom_stats) && count($data[substr($value_custom, 2)])>0) {
            //             $data_detail_splitted=array();
            //             foreach ($data[substr($value_custom, 2)] as $key_data_pr => $value_data_pr) {
            //                 $cnt_col=array();
            //                 foreach ($custom_data['custom_col'][$value_custom] as $key_special_col => $value_special_col) {
            //                     $data_detail_splitted[$value_special_col]=explode(',', $value_data_pr->$value_special_col);
            //                     $cnt_col[]=count($data_detail_splitted[$value_special_col]);

            //                 }
            //                 // print_r($value_data_pr);
            //                 $detail["detail_".$value_data_pr->$key_table_custom]=$this->custom_group_concat($data_detail_splitted,$cnt_col);
            //             }
            //             $data[substr($value_custom, 2)."_detail"]=json_encode($detail);
                        
            //         }
            //     }
            // }
            if (!empty($_POST['master_key'])) {
                $data['master_key'] = $_POST['master_key'];
            }
            $data['modal'] = $modal;
            $data['page'] = $page;
            $data['jenis'] = $jenis;
            $data['act'] = $act;
            $data['key'] = ($key != -1) ? $key : '';
            $file_path = $jenis . $page . '/ajax_' . $page;
            // echo "views/{$file_path}";
            // print_r($data);
            if (file_exists(APPPATH . "views/{$file_path}" . EXT)) {
                if ($act=="edit" && empty($data['edit_data'])) {
                    echo "Sory, Your Key is NOT VALID";
                    echo '<a href="'.$link_view.'" class="btn btn-light"><i style="color:black" class="fa fa-arrow-left"></i> BACK TO HOMEPAGE</a>';
                // return redirect()->to($link_view);
                } else {
                    echo view($file_path, $data);
                }
            } else {
                echo view('errors/html/error_404');
            }
        }
    }
    public function ajax_load_edit_master_detail($page, $key, $jenis_data)
    {
        define('EXT', '.php');
        $data_get = $this->am->edit_master_detail_single_page_list($page);
        if (!empty($data_get)) {
            $view_name = $data_get['name'];
            $file_path = $data_get['file_path'];
            $param_condition = array($data_get['primary_key'] => $key);
            if ($jenis_data == 'single') {
                $data_response = $this->am->get_data_where_general($view_name, $param_condition)->getRow();
            } else {
                $data_response = array();
            }

            // if (!empty($data_response)) {
            $data['act'] = 'edit';
            $data['edit_data'] = $data_response;
            $data['get_ready_ongkir'] = $this->am->get_data('v_get_ready_ongkir', '')->getResult();
            $data['kas'] = $this->am->get_data('m_kas', '')->getResult();
            $data['jenis_bayar'] = $this->am->get_data('m_jenis_bayar', '')->getResult();
            $data['divisi'] = $this->am->get_data('m_divisi', '')->getResult();
            $data['page'] = '';
            // }
            if (file_exists(APPPATH . "views/{$file_path}" . EXT)) {
                if (empty($data['edit_data'])) {
                    $link_view = site_url('load/view/'.$page."/".$jenis);
                    return redirect()->to($link_view);
                } else {
                    echo view($file_path, $data);
                }
            } else {
                echo view('errors/html/error_404');
            }
        }
    }
    public function custom_group_concat($data, $cnt_col)
    {
        $max_cnt =max($cnt_col);
        for ($i=0; $i < $max_cnt; $i++) {
            foreach ($data as $key => $value) {
                $detail[$i][$key]=$value[$i]??'';
            }
        }
        return $detail;
    }
    public function load_laporan($page)
    {
        if ($this->login) {
            // $this->load_page(false);
        } else {
            return redirect()->route("login");
        }
        date_default_timezone_set('Asia/Jakarta');
        define('EXT', '.php');
        $data['filter_tanggal']="hide";
        if ($page!="saldo_akhir") {
            $data['filter_tanggal']="show";
        }
        $data['page']=$page;
        $data['subheader']=$this->am->get_sub_alias($page);
        $file_path="laporan/".$this->lm->list_page($page);
        if (file_exists(APPPATH . "views/{$file_path}" . EXT)) {
            $data['page_header'] = 'Laporan '.$this->am->get_alias($page);
            echo view("laporan/home_laporan", $data);
        } else {
            echo view('errors/html/error_404');
        }
    }
    public function ajax_load_laporan()
    {
        $date_filter=$_POST['date_filter'];
        $divisi_filter=$_POST['filter_divisi'];
        $page=$_POST['page'];
        $filter_tanggal=$_POST['filter_tanggal'];
        if ($filter_tanggal=="hide") {
            $date_filter='';
        }

        $divisi=array();
        if (!empty($divisi_filter)) {
            $divisi=$divisi_filter;
        }
        $jenis_laporan=$this->lm->list_laporan($page);
        $data=array();
        if (!empty($jenis_laporan)) {
            if ($page=="laba_rugi") {
                $data['laporan']=$this->lm->get_laba_rugi($jenis_laporan, $date_filter)->getResult();
            } else {
                $data['laporan']=$this->lm->get_data($jenis_laporan, $date_filter, $divisi)->getResult();
            }
        }
        $data['page']=$page;
        $data['act']='view';
        
        echo view("laporan/".$this->lm->list_page($page), $data);
    }
}