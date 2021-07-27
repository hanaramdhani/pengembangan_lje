<?php
function penyebut($nilai)
{
  $nilai = abs($nilai);
  $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($nilai < 12) {
    $temp = " " . $huruf[$nilai];
  } else if ($nilai < 20) {
    $temp = penyebut($nilai - 10) . " belas";
  } else if ($nilai < 100) {
    $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
  } else if ($nilai < 200) {
    $temp = " seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
    $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
    $temp = " seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
    $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
    $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
    $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
  } else if ($nilai < 1000000000000000) {
    $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
  }
  return $temp;
}

function terbilang($nilai)
{
  if ($nilai < 0) {
    $hasil = "minus " . trim(penyebut($nilai));
  } else {
    $hasil = trim(penyebut($nilai)) . ' rupiah';
  }
  return $hasil;
}

function rupiah($angka)
{
  $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
  return $hasil_rupiah;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Pengiriman</title>
  <link rel="stylesheet" href="<?=base_url() ?>/assets/print/css/bootstrap.min.css">
  <style>
    body {
      font-size: 12px;
    }

    .logo {
      display: block;
    }

    .logo>img {
      margin-top: 1.5rem;
      vertical-align: middle;
    }

    .catatan {
      border: 1px solid rgba(0, 0, 0, 0.5);
      width: 250px;
      height: 125px;
      margin-right: 15px;
      padding: 5px;
      border-radius: 5px;
    }

    .outline-span {
      padding: 5px 10px;
      color: red;
      border: 1px solid red;
      text-align: center;
      vertical-align: middle;
      margin-top: 1rem;
      font-size: 10px;
    }

    p.dll {
      font-size: 9px;
      line-height: 0.2rem;
    }
     table{
      /*border: 1px solid black;*/
      border-collapse: collapse;
    }
    th, td {
      padding: 7px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row" style="margin-bottom: 0;font-weight: bold">
      <div class="col-xs-2" style="padding-top: 10px;">
        <img src="/assets/dist/img/lancar-jaya.png" alt="" style="max-width: 150px;">
        <div class="outline-span">Untuk Penagihan</div>
      </div>
      <div class="col-xs-6 text-center">
        <h4 style="margin-bottom: 0px; line-height: 0.2rem;">Pengangkutan Umum</h4>
        <h4 style="margin-top: 3px;">CV. LANCAR JAYA EXPRESS</h4>
        <p class="dll">Jurusan Surabaya Lombok PP</p>
        <p class="dll">KANTOR SURABAYA:</p>
        <p class="dll">Kompleks Pergudangan Mergomulya Jaya</p>
        <p class="dll">Blok D. No. 29 Surabaya Tlp. 00000 </p>
        <p class="dll">KANTOR LOMBOK:</p>
        <p class="dll" style="margin-bottom: 0px;">Jl. Sandubaya 12 B</p>
        <h4 class="text-underline" style="margin-top: 5px;">SURAT ANGKUTAN</h4>
      </div>
      <div class="col-xs-2" style="padding-top: 40px;">
        <p style="margin-bottom: 0px;">Dimuat Truck</p>
        <p>Tanggal:</p>
        <p>Kepada YTH:</p>
      </div>
    </div>
    <?php 
    $ongkir=0;
    $satuan='';
    $ongkir_satuan='';
    if ($data[0]['harga_koli']>0) {
      $ongkir=$data[0]['harga_koli'];
      $satuan='@';
    }
    if ($data[0]['harga_berat']>0) {
      $ongkir=$data[0]['harga_berat'];
      $satuan='kg';
    }
    if ($data[0]['harga_volume']>0) {
      $ongkir=$data[0]['harga_volume'];
      $satuan='m3';
    }
    if ($satuan=='@') {
      $ongkir_satuan=$satuan." Rp ".number_format($ongkir,0,',','.');
    }else{
      $ongkir_satuan="Rp ".number_format($ongkir,0,',','.')." /".$satuan;
    }
    ?>
    <div class="row">
      <div class="col-xs-6">
        <table>
          <tr>
            <td>Pengirim</td>
            <td>: <?= $data[0]['nama_pengirim']; ?></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>: <?= $data[0]['alamat_pengirim']; ?></td>
          </tr>
        </table>
      </div>
      <div class="col-xs-4" style="float: right;">
        <table>
          <tr>
            <td>Penerima</td>
            <td>: <?= $data[0]['nama_penerima']; ?></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>: <?= $data[0]['alamat_penerima']; ?></td>
          </tr>
        </table>
      </div>
    </div>
    <table class="table table-striped table-bordered" style="margin-bottom: 0px;">
      <thead>
        <tr style="text-align: center">
          <td style="text-align: center">NO</th>
          <th>KOLI</th>
          <th>JENIS BARANG</th>
          <th>BERAT (KG)</th>
          <th>ONGKOS KIRIM</th>
          <th>TOTAL</th>
          <th>KETERANGAN</th>
        </tr>
      </thead>
      <tbody>
        <tr class="text-center">
          <td><?= $data[0]['no_transaksi']; ?></td>
          <td><?= $data[0]['jumlah_item']; ?></td>
          <td><?= $data[0]['item']; ?></td>
          <td><?= $data[0]['jumlah_berat']; ?></td>
          <td class="text-right"><?= $ongkir_satuan ?></td>
          <td class="text-right"><?= rupiah($data[0]['total']) ?></td>
          <td><?= $data[0]['keterangan']; ?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="2" class="text-capitalize">Terbilang:</th>
          <th colspan="4" class="text-capitalize"><?= terbilang($data[0]['total']) ?></th>
        </tr>
      </tfoot>
    </table>
    <div class="row" style="margin-top: 0px;">
      <div class="col-xs-12" style="margin-top: 0;">
        <img src="/assets/dist/img/footer-SA.png" alt="" style="width: 100%; height: auto;">
      </div>
    </div>
    <!-- <?php print_r($data) ?> -->
  </div>
</body>

</html>