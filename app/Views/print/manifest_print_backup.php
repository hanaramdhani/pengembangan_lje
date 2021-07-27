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
  <title>Data Manifest</title>
  <link rel="stylesheet" href="/assets/print/css/bootstrap.min.css">
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
    <div class="row" style="margin-bottom: 1rem; ">
      <div class="col-xs-1 logo">
        <img src="/assets/dist/img/lancar-jaya.png" alt="" style="max-width: 50px;">
      </div>
      <div class="col-xs-3">
        <h4 class="text-uppercase">Manifest</h4>
        <span class="text-uppercase">Lancar Jaya Express</span>
      </div>
      <div class="col-xs-3">
        <table border="0" style="width: 100%;margin-top: 1.5rem;">
          <tr>
            <td style="width: 50px;">No. Plat</td>
            <td>: <?=$data[0]['kendaraan'] ?></td>
          </tr>
          <tr>
            <td style="width: 50px;">Supir</td>
            <td>: <?=$data[0]['kontak'] ?></td>
          </tr>
        </table>
      </div>
      <div class="col-xs-3">
        <table style="width: 100%;margin-top: 1.5rem;">
          <tr>
            <td style="width: 75px;">Tgl muat:</td>
            <td style="text-align: right;"> <?= date('d/m/Y') ?></td>
          </tr>
          <tr>
            <td style="width: 75px;">No. Manifest:</td>
            <td style="text-align: right;"> <?= $data[0]['no_transaksi'] ?></td>
          </tr>
        </table>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr class="text-uppercase" >
          <th class="text-center">SA</th>
          <th class="text-center">KOLI</th>
          <th class="text-center">JENIS BARANG</th>
          <th class="text-center">PENGIRIM</th>
          <th class="text-center">PENERIMA</th>
          <th class="text-center">BERAT</th>
          <th class="text-center">ONGKOS</th>
          <th class="text-center">TOTAL</th>
          <th class="text-center">KETERANGAN</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0 ?>
        <?php foreach ($data as $item) : ?>
          <tr>
            <td class="text-center"><?= $item['pengiriman_reff'] ?></td>
            <td class="text-center"><?= $item['koli'] ?></td>
            <td class="text-center"><?= $item['item'] ?></td>
            <td class="text-center"><?= $item['nama_pengirim'] ?></td>
            <td class="text-center"><?= $item['nama_penerima'] ?></td>
            <td class="text-center"><?= $item['berat'] ?> Kg</td>
            <td class="text-right">
              <?php $ongkos =  $item['harga_berat'] > 0 ? $item['harga_berat'] : ($item['harga_koli'] > 0 ? $item['harga_koli'] : $item['harga_volume']) ?>
              <?= rupiah($ongkos) ?>
            </td>
            <td class="text-right">
              <?php $subtotal = ($item['berat'] * $item['harga_berat']) + ($item['koli'] * $item['harga_koli']) + ($item['harga_volume'] * ($item['panjang'] * $item['lebar'] * $item['tinggi']));  ?>
              <?= rupiah($subtotal); ?>
            </td>
            <td></td>
            <?php $total += $subtotal ?>
          </tr>
        <?php endforeach ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="7">Total</th>
          <th colspan="2" class="text-right"> <?= rupiah($total); ?></th>
        </tr>
      </tfoot>
    </table>
  </div>


</body>

</html>