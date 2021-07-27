<?php

namespace App\Models;

use CodeIgniter\Model;

class Laporan_model extends Model
{
    public function get_data($table,$date_filter,$divisi_filter){

        $date_filter_splitted=explode(' - ', $date_filter);
        // $sql="SELECT * FROM $table HERE DATE(tanggal) BETWEEN ".$date_filter_splitted[0]." AND ".$date_filter_splitted[1];
        $sql="SELECT * FROM $table";
        if (!empty($date_filter)) {
            $sql.=" WHERE DATE(tanggal) BETWEEN '".$date_filter_splitted[0]."' AND '".$date_filter_splitted[1]."'";
            if (!empty($condition)) {
                $sql.= "AND kd_divisi='$divisi_filter'";
            }
        }else{
            if (!empty($condition)) {
                $sql.= "WHERE kd_divisi='$divisi_filter'";
            }
        }
        

        return $this->db->query($sql);
    }

    public function list_laporan($jenis_laporan)
    {
        $laporan=array(
            'omzet_pengiriman'=>'v_lap_omzet_pengiriman',
            'piutang_aktif'=>'v_lap_piutang_aktif',
            'saldo_akhir'=>'v_lap_saldo_akhir',
            'histori_kas'=>'v_lap_histori_kas',
            'laba_rugi'=>'proc_mon_laba_rugi_jasa'
        );
        return $laporan[$jenis_laporan] ?? '';
    }

    public function list_page($jenis_laporan){
        $pages=array(
            'omzet_pengiriman'=>'ajax_lap_pengiriman',
            'piutang_aktif'=>'ajax_lap_piutang_aktif',
            'saldo_akhir'=>'ajax_lap_saldo_akhir',
            'histori_kas'=>'ajax_lap_histori_kas',
            'laba_rugi'=>'ajax_lap_laba_rugi',
        );
        return $pages[$jenis_laporan] ?? '';
    }
    public function get_laba_rugi($table,$date_filter){
        $date_filter_splitted=explode(' - ', $date_filter);
        $sql="CALL $table('".$date_filter_splitted[0]."','".$date_filter_splitted[1]."')";
        return $this->db->query($sql);
    }

}

/* End of file Laporan_model.php */