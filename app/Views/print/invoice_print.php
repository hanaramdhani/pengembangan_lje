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
  <title>Invoice</title>
  <link rel="stylesheet" href="assets/print/css/bootstrap.min.css">
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
    <div class="row" style="margin-bottom: 1rem; font-weight: bold ">
      <div class="col-xs-1 logo" style="padding-right: 0px">
        <img src="assets/dist/img/lancar-jaya.png" alt="" style="max-width: 50px;">
      </div>
      <div class="col-xs-3">
        <h4 class="text-uppercase">Invoice</h4>
        <span class="text-uppercase">Lancar Jaya Express</span>
      </div>
      <div class="col-xs-3" style="padding-right: 0%">
        <table style="">
          <tr>
            <td style="width: 50px; padding-bottom: 1px;">No.</td>
            <td style="">: <?= $data[0]['no_transaksi']; ?></td>
          </tr>
          <tr>
            <td style="width: 50px;">Tanggal</td>
            <td>: <?= date('Y-m-d', strtotime($data[0]['tanggal'])) ?></td>
          </tr>
        </table>
      </div>
      <div class="col-xs-3">
        <table style="width: 100%;">
          <tr>
            <td style="width: 50px;padding-bottom: 1px;">Customer</td>
            <td style="">: <?= $data[0]['customer']; ?></td>
          </tr>
          <tr>
            <td style="width: 50px;">Alamat</td>
            <td>: <?= $data[0]['alamat'] ?></td>
          </tr>
        </table>
      </div>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr class="text-uppercase">
          <th class="text-center">no</th>
          <th class="text-center">tanggal</th>
          <th class="text-center">no. pengiriman / SA</th>
          <th class="text-center">info isi</th>
          <th class="text-center">total</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; ?>
        <?php foreach ($data as $key => $item) : ?>
          <tr>
            <td class="text-center"><?= $key + 1; ?></td>
            <td class="text-center"><?= $item['tanggal']; ?></td>
            <td class="text-center"><?= $item['no_pengiriman_r']." / ".$item['sa']; ?></td>
            <td></td>
            <td class="text-right">
              <?php $subtotal = ($item['berat'] * $item['harga_berat']) + ($item['koli'] * $item['harga_koli']) + ($item['harga_volume'] * ($item['panjang'] * $item['lebar'] * $item['tinggi']));  ?>
              <?= rupiah($subtotal); ?>
            </td>
            <?php $total +=  $subtotal ?>
          </tr>
        <?php endforeach ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3">Jumlah: <?= count($data); ?> Transaksi</th>
          <th class="text-center">Total</th>
          <th class="text-right"><?= rupiah($total); ?></th>
        </tr>
        <tr>
          <th colspan="5" class="text-capitalize">Terbilang: ( <?= terbilang($total) ?> )</th>
        </tr>
      </tfoot>
    </table>

    <div class="row">
      <div class="col-xs-6">
        <p>Mataram, <?= date('d/m/Y'); ?></p>
        <p>Hormat Kami,</p>
        <br><br><br>
        Lancar Jaya Express
      </div>
      <div class="col-xs-4">
        <div class="catatan">
          Catatan tambahan:
        </div>
      </div>
    </div>

  </div>
</body>

</html>