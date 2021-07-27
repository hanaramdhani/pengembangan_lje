<?php

namespace App\Models;

use CodeIgniter\Model;

class Api_m extends Model
{

    private $table_name = array();
    private $rule = array();
    private $key_table = array();
    private $divisi='';
    public function validate_token($token)
    {
        $token_get = '123';
        if ($token == $token_get) {
            return true;
        } else {
            return false;
        }
    }

    public function auth($condition)
    {
        return $this->db->table('v_user_login')->getWhere($condition);
    }

    public function get_data($table, $divisi)
    {
        if (!empty($this->table_foreign()[$table])) {
            if (!empty($divisi)) {
                return $this->db->table('v_' . $table)->getWhere($divisi);
            } else {

                return $this->db->table('v_' . $table)->get();
            }
        } else {
            if (!empty($divisi)) {
                return $this->db->table($table)->getWhere($divisi);
            } else {

                return $this->db->table($table)->get();
            }
        }
    }
    function get_data_where($table, $condition)
    {
        if (!empty($this->table_foreign()[$table])) {
            return $this->db->table('v_' . $table)->getWhere($condition);
        } else {

            return $this->db->table($table)->getWhere($condition);
        }
    }
    public function insert_single($table, $data)
    {
        // foreach ($data as $key => $value) {
        //     $value = $this->db->escapeString($value);
        //     $data[$key] = $value;
        // }
        $this->db->transStart();
        $this->db->table($table)->insert($data);
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }
        // return $this->db->affected_rows() > 0;
    }
    public function get_data_update($table, $key)
    {
        return $this->db->table($table)->getWhere($key);
        // return $this->db->get($table);
    }

    public function update_data($table, $data, $key_update)
    {
        // foreach ($data as $key => $value) {
        //     $value = $this->db->escapeString($value);
        //     $data[$key] = $value;
        // }
        $this->db->transStart();
        // $this->db->where($key_update);
        // $this->db->update($table, $data);
        // $builder->where('id', $id);
        $this->db->table($table)->update($data, $key_update);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }
    }
    public function delete_data($table, $key_delete)
    {
        // $this->db->delete($table, $key_delete);
        $res=array();
        try {
            if ($this->db->table($table)->delete($key_delete)) {
                $res=array(
                    'row_affected'=>$this->db->affectedRows() > 0,
                    'err'=>''
                );
                return $res;
            }else{
                $res=array(
                    'row_affected'=>0,
                    'err'=>$this->db->error()
                );
                throw new Exception($res);
                
            }
        } catch (Exception $e) {
            return $res;
        }
    }

    public function multi_insert($table, $data)
    {
        $this->db->transStart();
        $group_table = $this->master_detail_table($table);
        // print_r($group_table);
        $last_inserted_id = 0;
        $this->db->query("SET FOREIGN_KEY_CHECKS=0");
        foreach ($group_table as $key_table => $value_table) {
            if (!preg_match('/_detail/', $value_table)) {
                $last_inserted_id = ($this->insert_master($value_table, $data[$value_table]));
            } else {
                $i = 0;
                foreach ($data[$value_table] as $key_detail => $value_detail) {
                    $key_foreign = $this->master_detail_reff($value_table);
                    $data[$value_table][$i][$key_foreign] = $last_inserted_id;
                    $this->db->table($value_table)->insert($data[$value_table][$i]);
                    $i++;
                }
            }
        }
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }
    }

    public function insert_master($table, $data)
    {
        // foreach ($data as $key => $value) {
        //     $value = $this->db->escapeString($value);
        //     $data[$key] = $value;
        // }
        // print_r($data);
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }
    // public function escapeString($data)
    // {
    //     foreach ($data as $key => $value) {
    //         $value = $this->db->escapeString($value);
    //         $data[$key] = $value;
    //     }
    //     return $data;
    // }

    public function set_default_divisi(){
        $kd_group=$_SESSION['kd_group'];
        $divisi='';
        if ($kd_group!=1) {
            $divisi=$_SESSION['kd_divisi'];
        }
        $this->divisi=$divisi;
    }
    public function refresh_table()
    {
        $db_name = $this->db->getDatabase();
        $table = $this->db->query("SHOW TABLES")->getResult('array');
        $key_table = array();
        foreach ($table as $key => $value) {
            $table_name[] = $value['Tables_in_' . $db_name];
            $sql_get_desc = "DESC " . $value['Tables_in_' . $db_name];
            $desc_table = $this->db->query($sql_get_desc)->getResult('array');
            foreach ($desc_table as $key_desc => $value_desc) {
                if ($value_desc['Field'] != 'date_add' && $value_desc['Field'] != 'date_modif' && $value_desc['Extra'] != 'auto_increment') {
                    $data[$value['Tables_in_' . $db_name]][] = $value_desc['Field'];
                    $rule[$value['Tables_in_' . $db_name]][$value_desc['Field']]['allow_null'] = $value_desc['Null'];
                } else {
                    if ($value_desc['Key'] == "PRI") {
                        $key_table[$value['Tables_in_' . $db_name]] = $value_desc['Field'];
                    }
                }
            }
        }
        $this->key_table = $key_table;
        $this->rule = $rule;
        $this->table_name = $table_name;
        $this->set_default_divisi();
        return $data;
    }
    public function master_detail_table($frm_table)
    {
        $table_data = array(
            'invoice' => array('t_invoice', 't_invoice_detail'),
            'manifest' => array('t_manifest', 't_manifest_detail'),
            'penagihan' => array('t_penagihan', 't_penagihan_detail'),
            'pengiriman' => array('t_pengiriman', 't_pengiriman_detail'),
            'kirim' => array('m_kirim', 'm_kirim_detail'),
            'manifest_out' => array('v_t_manifest', 'v_manifest_out_pending'),
        );
        return ($table_data[$frm_table]) ?? array();
    }
    public function master_detail_reff($table)
    {
        $reff_data = array(
            't_invoice_detail' => 'no_invoice',
            't_manifest_detail' => 'no_manifest',
            't_penagihan_detail' => 'no_tagihan',
            't_pengiriman_detail' => 'no_transaksi',
            'm_kirim_detail' => 'kd_kirim',
        );
        return $reff_data[$table] ?? array();
    }
    public function table_foreign()
    {
        $table_foreign = array(
            'm_userx' => array('m_user_group' => array(), 'v_pegawai_non_user' => array()),
            'm_lokasi' => array('m_kabupaten' => array()),
            'm_kirim' => array('m_lokasi' => array('status' => 1), 'm_jenis_kirim' => array('status' => 1), 'm_layanan' => array('status' => 1)),
            'm_kirim_detail' => array('m_jenis_kirim' => array('status' => 1), 'm_layanan' => array('status' => 1), 'm_lokasi' => array('status' => 1)),
            'm_customer' => array('m_customer_kategori' => array('status' => 1), 'm_kabupaten' => array()),
            'm_pegawai' => array('m_pegawai_kategori' => array('status' => 1), 'm_userx' => array('status' => 1), 'm_divisi' => array('status' => 1)),
            'm_divisi' => array('m_lokasi' => array('status' => 1)),
            't_invoice' => array('m_customer' => array('status' => 1), 'm_divisi' => array('status' => 1), 'v_data_pengiriman' => array()),
            't_penagihan' => array('m_pegawai' => array('status' => 1), 'm_divisi' => array('status' => 1), 'v_data_pengiriman' => array()),
            't_mutasi_kas' => array('m_kas' => array('status' => 1)),
            't_pembayaran' => array('v_customer_pengiriman' => array(), 'm_jenis_bayar' => array('status' => 1), 'm_kas' => array('status' => 1), 'v_pengiriman_belum_lunas' => array()),
            't_invoice_detail' => array('t_pengiriman' => array()),
            't_penagihan_detail' => array('t_pengiriman' => array()),
            't_pengiriman' => array('m_customer' => array('status' => 1), 'm_jenis_bayar' => array('status' => 1), 'm_kas' => array('status' => 1), 'm_divisi' => array('status' => 1), 'm_jenis_kirim' => array('status' => 1), 'v_get_ready_ongkir' => array()),
            't_pengiriman_detail' => array('m_jenis_kirim' => array('status' => 1)),
            't_biaya_operasional' => array('m_kas' => array('status' => 1), 'm_jenis_bayar' => array('status' => 1), 'm_biaya' => array('status' => 1), 'm_divisi' => array('status' => 1)),
            't_pendapatan' => array('m_kas' => array('status' => 1), 'm_jenis_bayar' => array('status' => 1), 'm_pendapatan' => array('status' => 1)),
            't_manifest_detail' => array('t_pengiriman' => array()),
            't_manifest' => array('m_divisi' => array('status' => 1), 't_manifest_detail' => array(), 'v_data_pengiriman_manifest_out' => array()),
            't_manifest_in' => array('v_manifest_in' => array()),
            't_pengiriman2' => array('m_customer' => array('status' => 1), 'm_jenis_bayar' => array('status' => 1), 'm_kas' => array('status' => 1), 'm_divisi' => array('status' => 1), 'm_jenis_kirim' => array('status' => 1), 'v_get_ready_ongkir' => array()),
            // 'm_kirim'=>'m_lokasi',
        );
        return $table_foreign;
    }

    public function route_param()
    {
        $route_table = array();
        foreach ($this->table_name as $key => $value) {
            // echo substr($value,2);
            if (array_key_exists(substr($value, 2), $route_table)) {
                $route_table['t' . substr($value, 2)] = $value;
            } else {
                $route_table[substr($value, 2)] = $value;
            }
        }
        $route_table['manifest_in'] = 't_manifest_in';
        $route_table['manifest_out'] = 't_manifest';
        $route_table['pengiriman2'] = 't_pengiriman';
        return $route_table;
    }
    public function get_generated_token()
    {
        //Generate a random string.
        $token = bin2hex(random_bytes(64));
        return $token;
    }
    public function set_user_login($kd_user, $token)
    {
        $this->db->query("INSERT INTO x_token_login(kd_user,token) VALUES('$kd_user','$token')");
    }
    public function get_rule($table)
    {
        return $this->rule[$table];
    }
    public function get_key_table($table)
    {
        return $this->key_table[$table] ?? array();
    }
    public function get_table()
    {
        return $this->table_name;
    }
    public function get_last_id($table, $col)
    {
        $sql = "SELECT max($col) AS id FROM $table";
        return $this->db->query($sql);
    }
    public function get_ongkir($kd_layanan, $kd_jenis_kirim, $kd_kota_asal, $kd_kota_tujuan)
    {
        $sql = "SELECT harga_berat,min_berat,harga_volume,min_volume,harga_koli FROM v_get_ready_ongkir
        WHERE kd_layanan=$kd_layanan AND kd_jenis=$kd_jenis_kirim AND kd_kota_asal=$kd_kota_asal AND kd_kota_tujuan=$kd_kota_tujuan";
        // echo $sql;
        return $this->db->query($sql);
    }
    public function get_lokasi_auto_complete($condition, $search, $groupby)
    {
        // echo $groupby;
        // echo $condition;
        $db = \Config\Database::connect();
        $builder = $db->table('v_get_ready_ongkir');
        $builder->where($condition);
        $builder->like($search);
        $builder->groupBy($groupby);
        return $builder->get();
    }
    public function do_update_manifest_in($no_transaksi, $no_pengiriman)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->db->transStart();
        $this->db->table('t_manifest')->update(array('tanggal_sampai' => date('Y-m-d H:i:s')), array('no_transaksi' => $no_transaksi));
        foreach ($no_pengiriman as $key_no_pengiriman => $value_no_pengiriman) {
            $this->db->table('t_manifest_detail')->update(array('tanggal_terima' => date('Y-m-d H:i:s')), array('no_manifest' => $no_transaksi, 'no_pengiriman' => $value_no_pengiriman));
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }
    }
    public function get_pengiriman_all($no_transaksi)
    {
        $sql = "SELECT t_kirim.no_transaksi,
        dt_kirim.harga_bersih_dt-(dt_kirim.harga_bersih_dt*diskon) AS subtotal,lama_kredit,tanggal, volume,jumlah_berat AS berat,
        CONCAT((SELECT nama FROM m_kabupaten WHERE kd_kabupaten=t_kirim.kab_asal),\" - \",(SELECT nama FROM m_kabupaten WHERE kd_kabupaten=t_kirim.kab_tujuan)) AS from_to,alamat_pengirim as tujuan,jumlah_item,harga_berat,harga_volume
        FROM
        (
        SELECT no_transaksi, nama_pengirim AS pengirim,alamat_pengirim,
        diskon,lama_kredit,tanggal,

        (SELECT kd_kabupaten FROM m_lokasi WHERE kd_lokasi = t_pengiriman.kd_lokasi_asal) AS kab_asal,
        (SELECT kd_kabupaten FROM m_lokasi  WHERE kd_lokasi = t_pengiriman.kd_lokasi_tujuan) AS kab_tujuan
        FROM t_pengiriman   WHERE no_transaksi='" . $no_transaksi . "'
        )
        t_kirim
        INNER JOIN
        (
        SELECT no_transaksi,COUNT(no_transaksi) AS jumlah_item,GROUP_CONCAT(jumlah_berat) as  jumlah_berat,GROUP_CONCAT(harga_volume) AS harga_volume,GROUP_CONCAT(CONCAT (panjang,\" * \",lebar,\" * \",tinggi)) AS volume,
        GROUP_CONCAT(harga_berat) AS harga_berat,
        SUM(
        ((IFNULL(harga_berat,0) * IFNULL(jumlah_berat,0))+(IFNULL(harga_volume,0) * IFNULL(panjang,0) * IFNULL(lebar,0) * IFNULL(tinggi,0)))
        -
        CASE
        WHEN diskon>1 THEN diskon
        ELSE
        ((IFNULL(harga_berat,0) * IFNULL(jumlah_berat,0))+(IFNULL(harga_volume,0) * IFNULL(panjang,0) * IFNULL(lebar,0) * IFNULL(tinggi,0))) * diskon
        END
        )
        AS harga_bersih_dt
        FROM t_pengiriman_detail
        GROUP BY no_transaksi
        ) dt_kirim
        ON t_kirim.no_transaksi=dt_kirim.no_transaksi ";
        return $this->db->query($sql);
    }
    public function get_min_wv($condition)
    {
        return $this->db->table('v_get_ready_ongkir')->getWhere($condition);
    }
    public function get_alias($alias_key)
    {
        $alias_table = array(
            'biaya' => 'Biaya',
            'customer' => 'Customer',
            'customer_kategori' => 'Kategori Customer',
            'divisi' => 'Divisi',
            'jenis_bayar' => 'Jenis Bayar',
            'jenis_kirim' => 'Jenis Kirim',
            'kabupaten' => 'Kabupaten',
            'kas' => 'Kas',
            'kirim' => 'Ongkos Kirim',
            'kirim_detail' => 'Detail Ongkos Kirim',
            'layanan' => 'Jenis Layanan Ekspedisi',
            'lokasi' => 'Lokasi',
            'pegawai' => 'Pegawai ',
            'pegawai_kategori' => 'Kategori Pegawai',
            'pendapatan' => 'Pendapatan',
            'permission_web' => 'Permission',
            'provinsi' => 'Provinsi',
            'satuan' => 'Satuan',
            'user_group' => 'Group User',
            'userx' => 'Kelola User',
            'userxlevel' => 'Hak Akses User',
            'biaya_operasional' => 'Biaya Operasional',
            'invoice' => 'Invoice',
            'invoice_detail' => 'Detail Invoice',
            'manifest' => 'Manifest',
            'manifest_detail' => 'Detail Manifest',
            'manifest_in' => 'Manifest Masuk',
            'manifest_out' => 'Manifest',
            'mutasi_kas' => 'Mutasi Kas',
            'pembayaran' => 'Pembayaran',
            'penagihan' => 'Tagihan',
            'penagihan_detail' => 'Detail Tagihan',
            'tpendapatan' => 'Pendapatan',
            'pengiriman' => 'Pengiriman',
            'pengiriman2' => 'Pengiriman',
            'pengiriman_detail' => 'Detail Pengiriman',
        );
        return $alias_table[$alias_key] ?? '';
    }
    public function get_data_perdivisi($table)
    {
        $array_table_divisi = array(
            't_pendapatan'=>true,
            't_biaya_operasional'=>true,
            't_mutasi_kas'=>true,
            't_pengiriman'=>true,
            't_manifest'=>true,
        );
        return $array_table_divisi[$table] ?? false;
    }
    public function get_jenis_cetak($pilih_cetak)
    {
        $jenis_cetak = array(
            'invoice' => '',
            'manifest' => '',
            'tagihan' => '',
            'pengiriman' => '',
        );
    }

    public function get_cust($cst)
    {
        $coba = "SELECT * FROM v_m_customer WHERE  kd_customer LIKE '%$cst%' OR nama LIKE '%$cst%' ";
        return $this->db->query($coba);
    }
    public function get_where_like($table, $search_key)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->like($search_key);
        return $builder->get();
    }
    public function edit_master_detail_single_page_list($table_alias)
    {
        $table_list = array(
            'invoice' => array('name' => 'v_invoice_dt', 'primary_key' => 'no_transaksi', 'file_path' => 'pengiriman/invoice/ajax_edit_invoice_single'),
            'manifest' => array('name' => 'v_manifest_dt', 'primary_key' => 'no_transaksi', 'file_path' => 'pengiriman/manifest/ajax_edit_manifest_single'),
            'penagihan' => array('name' => 'v_penagihan_dt', 'primary_key' => 'no_transaksi', 'file_path' => 'pengiriman/penagihan/ajax_edit_penagihan_single'),
            'pengiriman' => array('name' => 'v_pengiriman_dt', 'primary_key' => 'no_transaksi', 'file_path' => 'pengiriman/pengiriman/ajax_edit_pengiriman_single'),
            'kirim' => array('name' => 'v_kirim_dt', 'primary_key' => 'kd_kirim', 'file_path' => 'master/kirim/edit_kirim_single'),
        );
        return $table_list[$table_alias] ?? array();
    }
    public function get_data_where_general($table, $key_where)
    {
        return $this->db->table($table)->getWhere($key_where);
    }
    public function update_data_mt_single($table_selected, $data_save, $key_table)
    {
        // print_r($data_save);
        // print_r($key_table);
        $this->db->transStart();

        $this->db->table($table_selected[1])->delete($key_table['detail']);
        $this->db->table($table_selected[1])->insert($data_save['detail']);
        $this->db->table($table_selected[0])->update($data_save['master'], $key_table['master']);

        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }
    }
    public function get_custom_data($alias_table)
    {
        $custom_data = array(
            'manifest_out' => array(
                'table' => array('v_manifest_out_pending', 't_manifest_detail'),
                'custom_col' => array(
                    'v_manifest_out_pending' => array('nomor', 'nomor_reff', 'no_pengiriman', 'deskripsi')
                ),
            ),
        );
        return $custom_data[$alias_table] ?? array();
    }
    public function user_crud($data_user, $data_pegawai)
    {
        $this->db->transStart();
        $last_inserted_id = 0;
        if (empty($data_user['key'])) {
            $last_inserted_id = $this->insert_master($data_user['table'], $data_user['val']);
            // $this->db->table($data_user['table'])->insert($data_user['val']);

            $data_pegawai['val']['kd_user'] = $last_inserted_id;
            if (!empty($data_pegawai)) {
                $this->db->table($data_pegawai['table'])->update($data_pegawai['val'], $data_pegawai['key']);
            }
        } else {
            $this->db->table($data_user['table'])->update($data_user['val'], $data_user['key']);
            if (!empty($data_pegawai)) {
                $data_pegawai['key']['kd_user'] = $data_user['key'];
                $this->db->table($data_pegawai['table'])->update($data_pegawai['val'], $data_pegawai['key']);
            }
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }
    }
    public function multi_insert_general($data){
        $this->db->transStart();

        foreach ($data as $key_table => $value_table) {
            foreach ($value_table as $key_data => $value_data) {
                $this->db->table($key_table)->insert($value_data);
            }
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }
    }
    public function report_routing($route){
        $t_name=array(
            'pengiriman'=>'v_pengiriman_dt',
            'manifest'=>'v_cetak_manifest',
            'invoice' => 'v_cetak_invoice',
        );
        return $t_name[$route]??'';
    }
    public function get_data_where_order_limit($table,$condition,$order,$start,$limit){
        $db = \Config\Database::connect();
        $builder = $db->table($table);
        $builder->where($condition);
        $builder->orderBy($order, 'ASC');
        $builder->limit($limit,$start);
        return $builder->get();
    }
    public function get_data_dashboard_laba_rugi($range){
        $range_splitted=explode(' - ', $range);
        $awal=$range_splitted[0];
        $akhir=$range_splitted[1];
        $sql="CALL proc_mon_laba_rugi_jasa('$awal','$akhir')";
        return $this->db->query($sql);
    }
    public function get_permission($arr_permission){
        $table_name=$arr_permission['tbl_name'];
        $column=$arr_permission['col'];
        $group=$arr_permission['kd_group'];
        $sql="SELECT $column FROM m_user_permission WHERE table_name='$table_name' AND kd_group='$group'";
        return $this->db->query($sql);
    }
    public function get_sub_alias($page){
        $alias=array(
            'omzet_pengiriman'=>'Omzet Pengiriman',
            'piutang_aktif'=>'Piutang Aktif',
            'saldo_akhir'=>'Saldo Akhir',
            'histori_kas'=>'Histori Kas',
            'laba_rugi'=>'Laba Rugi',
        );
        return $alias[$page]??'';
    }
}

/* End of file home_model.php */