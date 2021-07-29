<?php 
$kota_asal = array();
$kota_tujuan = array();
$layanan = array();
$jenis_kirim_t = array();
$jenis_kirim_js = array();
foreach ($jenis_kirim as $key_row => $value_row) {
    $jenis_kirim_js["detail_" . $value_row->kd_jenis] = $value_row->nama;
}
$arr_jenis_kirim = json_encode($jenis_kirim_js);

foreach ($get_ready_ongkir as $key => $value) {
    $kota_asal[$value->kd_kota_asal] = (object)['kd_lokasi' => $value->kd_kota_asal, "nama" => $value->kota_asal];
    $kota_tujuan[$value->kd_kota_tujuan] = (object)['kd_lokasi' => $value->kd_kota_tujuan, "nama" => $value->kota_tujuan];
    $layanan[$value->kd_layanan] = (object)['kd_layanan' => $value->kd_layanan, "nama" => $value->layanan];
    $jenis_kirim_t[$value->kd_jenis] = (object)['kd_jenis' => $value->kd_jenis, "nama" => $value->jenis_kirim];
}
?>
<style>
.autocomplete_li:hover {
    background-color: #dc3545;
}

.display-hide {
    display: none;
}

.display-show {
    display: inline-block;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card card-danger card-tabs">
            <div class="card-header p-0 pl-1 pt-1">
                <ul class="nav nav-tabs" id="tab-pengiriman" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active px-5 font-weight-bold" id="tab-pengiriman-dsr" data-toggle="pill"
                            href="#tab-pengiriman-dsr-form" role="tab" aria-controls="tab-pengiriman-dsr-form"
                            aria-selected="true">Dasar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-5 font-weight-bold" id="tab-pengiriman-dasar" data-toggle="pill"
                            href="#tab-pengiriman-dasar-form" role="tab" aria-controls="tab-pengiriman-dasar-form"
                            aria-selected="false">Pengirim & Penerima</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-5 font-weight-bold" id="tab-pengiriman-paket" data-toggle="pill"
                            href="#tab-pengiriman-paket-form" role="tab" aria-controls="tab-pengiriman-paket-form"
                            aria-selected="false">Paket</a>
                    </li>
                </ul>
            </div>
            <form class="form-horizontal" id="frm-pengiriman">
                <div class="card-body">
                    <div class="tab-content" id="tab-pengirimanContent">
                        <!-- form data pengiriman -->
                        <input type="hidden" name="val_tanggal" class="data" value="<?= date('Y-m-d H:i:s') ?>">

                        <div class="tab-pane fade active show" id="tab-pengiriman-dsr-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-dsr">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Lokasi asal</label>
                                        <input type="text" class="form-control data" name="val_kd_lokasi_asal"
                                            id="kota-asal" placeholder="Area pengirim" required
                                            value="<?=$_SESSION['lokasi_def'] ?>"
                                            <?=($_SESSION['kd_group']!=1)?'readonly':'' ?>>
                                        <!-- <div> -->
                                        <div id="kota-asal-list" style="z-index: 999;" class="position-relative"></div>
                                        <!-- </div> -->
                                        <input type="hidden" id="kd-lokasi_asal" name="val_kd_lokasi_asal"
                                            value="<?=$_SESSION['kd_lokasi'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Lokasi Tujuan</label>
                                        <input type="text" class="form-control data" id="kota-tujuan"
                                            name="val_kd_lokasi_tujuan" placeholder="Area penerima" required>
                                        <div id="kota-tujuan-list" style="z-index: 999;" class="position-relative">
                                        </div>
                                        <input type="hidden" id="kd-lokasi_tujuan" name="val_kd_lokasi_tujuan">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Jenis Layanan</label>
                                        <select name="val_kd_layanan" id="layanan" param="val_kd_layanan"
                                            class="form-control data-dt select2">
                                            <?php foreach ($layanan as $ly => $value) : ?>
                                            <option value="<?php echo $value->kd_layanan; ?>">
                                                <?php echo $value->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- mengambil kd_layanan -->
                                        <input type="hidden" id="lyn">
                                        <script type="text/javascript">
                                        $('#layanan').click(function() {
                                            document.getElementById('lyn').value = document.getElementById(
                                                'layanan').value;
                                        });
                                        </script>

                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-md-4">
                                    <div class=" form-group">
                                        <label class="control-label">Kode Referensi</label>
                                        <input type="text" class="form-control data" id="val_no_transaksi_reff"
                                            name="val_no_transaksi_reff" value="-" required>
                                    </div>

                                    <div class="form-group" style="margin-top: 2rem">
                                        <label class="control-label">Divisi</label>
                                        <select name="val_kd_divisi" id="val_kd_divisi" param="val_kd_divisi"
                                            class="form-control data">
                                            <?php foreach ($divisi as $d => $value) : ?>
                                            <option value="<?php echo $value->kd_divisi ?>"
                                                <?= ($value->kd_divisi == $_SESSION['kd_divisi']) ? 'selected' : '' ?>>
                                                <?php echo $value->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="val_status" class="col-sm-7 ">Status</label>
                                                <div class="col-sm-6" id="radio-aktif">
                                                    <input type='radio' class="form-check-label" name="val_status"
                                                        onclick="coba()" value="1" checked>
                                                    <label class="form-check-label">Tunai</label>
                                                </div>
                                                <div class="col-sm-6" id="radio-aktif1">
                                                    <input type='radio' name="val_status" onclick="coba1()" value="0">
                                                    <label class="form-check-label">Kredit</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row" id="input-jenis-pembayaran" style="">
                                                <label id="lbl-jenis-pembayaran" class="col-sm-12">Jenis Bayar</label>
                                                <select id="sc-jenis-pembayaran" name="val_kd_jenis_bayar"
                                                    param="val_kd_jenis_bayar" class="form-control data select2">
                                                    <?php foreach ($jenis_bayar as $cs => $value) : ?>
                                                    <option value="<?php echo $value->kd_jenis_bayar; ?>">
                                                        <?php echo $value->nama ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="form-group display-hide" id="lama-kredit-group"
                                        style="margin-top: 2rem ">
                                        <label style="display: none;" id="lbl-lm">Lama Kredit</label>
                                        <div class="input-group">
                                            <input type="hidden" class="form-control data" id="lama-kredit"
                                                name="val_lama_kredit" placeholder="Masukkan Lama Kredit" value="0"
                                                required>
                                            <div class="input-group-append display-hide" style="cursor: pointer;"
                                                id="lim-kredit">
                                                <span class="input-group-text">Hari</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="group-class" style="margin-top: 1rem">
                                        <label class="control-label">KAS</label>
                                        <select name="val_kd_kas" id="val_kd_kas" class="form-control data">
                                            <?php foreach ($kas as $k => $value) : ?>
                                            <option value="<?php echo $value->kd_kas; ?>">
                                                <?php echo $value->no_rekening ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-7 col-form-label">Diskon</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" min="0" class="form-control data data-dt"
                                                        id="val_diskon_t" oninput="Check(this)" param="val_diskon_t"
                                                        maxlength="3" max="99" name="val_diskon" readonly
                                                        placeholder="Masukkan Diskon" onkeyup="total()" value="0">
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="persen_master" class="btn btn-secondary w-80">%</button>
                                                </div>
                                                <div class="col-md-3">
                                                    <button id="rupiah_master"
                                                        class="btn btn-secondary w-80">Rp</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Keterangan</label>
                                        <textarea id="val_keterangan" name="val_keterangan" class="form-control data"
                                            placeholder="Masukkan Keterangan" rows="1">-</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">Lampiran</label>
                                        <!-- <div class="col pl-0 mb-2">
                                    <div class="img-preview">
                                        <img id="lampiran" src="/assets/dist/img/fa-solid_image.png" class="w-100 p-4">
                                    </div>
                                </div> -->
                                        <div class="col pl-0">
                                            <input type="file" name="val_lampiran" id="val_lampiran"
                                                param="val_lampiran" class="data" onchange="addlamp()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- pengirim dan penerima -->
                        <div class="tab-pane fade" id="tab-pengiriman-dasar-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-dasar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-0">
                                        <input type="hidden" class="form-control data" id="val_kd_customer"
                                            name="val_kd_customer" value="-1">

                                        <h3 class="mr-3 mb-0">
                                            Data Pengirim
                                        </h3>

                                        <div class="">
                                            <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                                id="pengirim"><span id="pengirim-text">Pilih Data Customer</span> <i
                                                    class="fa fa-sync-alt pl-2" aria-hidden="true"></i></button>
                                        </div>

                                    </div>
                                    <div class="mb-3" style="color: green"><input type="radio" name="checked_customer"
                                            class="checked-customer" value="pengirim"> Set Sebagai Customer</div>
                                    <div class=" form-group row">
                                        <label class="col-sm-7 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" id="kd-selected-pengirim" value="">
                                            <input type="text" class="form-control data" id="val_nama_pengirim"
                                                param="val_nama_pengirim" name="val_nama_pengirim"
                                                placeholder="Nama pengirim" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-7 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
                                            <textarea id="val_alamat_pengirim" name="val_alamat_pengirim"
                                                param="val_alamat_pengirim" class="form-control data"
                                                placeholder="Alamat pengirim"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-7 col-form-label">No. Hp</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control data" id="val_hp_pengirim"
                                                name="val_no_hp_pengirim" placeholder="No. HP pengirim">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mr-3 mb-0">Data Penerima</h3>
                                        <div>
                                            <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                                id="penerima"><span id="penerima-text">Tunai</span> <i
                                                    class="fa fa-sync-alt pl-2" aria-hidden="true"></i></button>
                                        </div>

                                    </div>
                                    <div class="mb-3" style="color: green"><input type="radio" name="checked_customer"
                                            class="checked-customer" value="penerima" checked> Set Sebagai Customer
                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-sm-7 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" id="kd-selected-penerima" value="-1">
                                            <input type="text" class="form-control data" id="val_nama_penerima"
                                                name="val_nama_penerima" param="val_nama_penerima"
                                                placeholder="Nama penerima" required value="Tunai - Mataram">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-7 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
                                            <textarea id="val_alamat_penerima" name="val_alamat_penerima"
                                                param="val_alamat_penerima" class="form-control data"
                                                placeholder="Alamat penerima">Mataram</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-7 col-form-label">No. Hp</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control data" id="val_hp_penerima"
                                                name="val_no_hp_penerima" placeholder="No. HP penerima" value="-">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <!-- ./form data pengirim dan penerima -->

                        <!-- informasi paket -->
                        <div class="tab-pane fade" id="tab-pengiriman-paket-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-paket">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kirim</label>
                                        <select id="val-kd-jenis" name="val_kd_jenis" param="val_kd_jenis"
                                            class="form-control data-dt ongkir select2" required>
                                            <option>Pilih Kota Asal dan Tujuan</option>
                                            <!-- <?php foreach ($jenis_kirim_t as $jk => $value) : ?>
                                    <option class="jenis_krm" value="<?php echo $value->kd_jenis; ?>">
                                        <?php echo $value->nama ?>
                                    </option>
                                    <?php endforeach; ?> -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Keterangan</label>
                                        <!-- <input type="text" name="val_jumlah_item" id="jumlah-item" value="0" param="val_jumlah_item" class="form-control data-dt" onkeyup="total()" placeholder="Masukkan Jumlah Item">
                                <input type="text" class="data-dt" onkeyup="total()" param="val_harga_koli"
                                id="harga_koli"> -->
                                        <input class="form-control data-dt" param="val_keterangan1" id="keterangan-id"
                                            placeholder="Keterangan" value="-">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Koli</label>
                                        <!-- <input type="text" id="jumlah-item" param="val_jumlah_item"
                                    class="form-control data-dt" onkeyup="total()"> -->
                                        <div class="input-group">
                                            <div class="input-group-append" style="cursor: pointer;"
                                                title="Double click untuk ubah harga">
                                                <span class="input-group-text" id="label-harga-koli">Rp</span>
                                            </div>
                                            <input type="text" value="0" id="harga-koli-custom"
                                                class="form-control display-hide allow-numeric">
                                            <div class="input-group-append display-hide" id="label-qty-koli">
                                                <span class="input-group-text"> C: </span>
                                            </div>
                                            <input type="text" name="val_jumlah_item" id="jumlah-item" value="0"
                                                param="val_jumlah_item" class="form-control data-dt allow-numeric"
                                                onkeyup="total()" placeholder="Masukkan Jumlah Item">
                                            <input type="hidden" class="form-control data-dt" onkeyup="total()"
                                                name="val_harga_koli" value="0" param="val_harga_koli" id="harga_koli"
                                                readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" id="jenis_k">
                                    <div id="jenis-kirim-container"></div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group " style="margin-bottom: 0.6rem">
                                        <label>Berat (kg)</label> <span style="font-size: 14px;"
                                            id="label_min_berat"></span>
                                        <div class="row align-items-center">
                                            <input type="hidden" value="0" class="data-dt" id="val_harga_berat"
                                                name="val_harga_berat" param="val_harga_berat" onkeyup="total()">
                                            <input type="hidden" value="0" id="min" onkeyup="total()">

                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <div class="input-group-append" style="cursor: pointer;"
                                                            title="Double click untuk ubah harga">
                                                            <span id="label_harga_berat" class="input-group-text"> Rp
                                                            </span>
                                                        </div>
                                                        <input type="text" value="0" id="harga-berat-custom"
                                                            class="form-control display-hide allow-numeric">
                                                        <div class="input-group-append display-hide"
                                                            id="label-qty-berat">
                                                            <span class="input-group-text"> W: </span>
                                                        </div>
                                                        <input type="text" value="0" id="val_jumlah_berat"
                                                            param="val_jumlah_berat" name="val_jumlah_berat"
                                                            class="data-dt form-control allow-numeric"
                                                            placeholder="Masukkan berat" value="" onkeyup="total()">
                                                        <input type="text" class="form-control display-hide"
                                                            id="berat-min" value="min" disabled>
                                                    </div>
                                                    <input type="hidden" class="data-dt" value="0" id="harga_berat"
                                                        param="harga_berat" onkeyup="total()">
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox" id="chk-min-berat"> min
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Dimensi</label>
                                        <div class="row">
                                            <div class="col-md-4 volume-r">
                                                <input type="text" class="form-control data-dt allow-numeric" value=""
                                                    id="val_panjang" param="val_panjang" name="val_panjang"
                                                    placeholder="Panjang (m)" onkeyup="total()">
                                            </div>
                                            <div class="col-md-4 volume-r">
                                                <input type="text" class="form-control data-dt allow-numeric" value=""
                                                    id="val_lebar" param="val_lebar" name="val_lebar"
                                                    placeholder="Lebar (m)" onkeyup="total()">
                                            </div>
                                            <div class="col-md-4 volume-r">


                                                <input type="text" class="form-control data-dt allow-numeric"
                                                    id="val_tinggi" param="val_tinggi" value="" name="val_tinggi"
                                                    placeholder="Tinggi (m)" onkeyup="total()">
                                            </div>
                                            <div class="col-md-12 display-hide" id="plt-min">
                                                <input type="text" class="form-control" value="min" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Volume (<span
                                                class="min-volume"></span>&#13221;)</label>
                                        <span class="min-volume" style="font-size: 14px;" id="label_min_volume"></span>
                                        <div class="row align-items-center">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <div class="input-group-append" style="cursor: pointer;"
                                                            title="Double click untuk ubah harga">
                                                            <span id="label_harga_volume" class="input-group-text">Rp
                                                            </span>
                                                        </div>
                                                        <input type="text" value="0" id="harga-volume-custom"
                                                            class="form-control display-hide allow-numeric">
                                                        <div class="input-group-append display-hide"
                                                            id="label-qty-volume">
                                                            <span class="input-group-text"> V: </span>
                                                        </div>
                                                        <input type="text" value="0" class="form-control"
                                                            id="hrg_volume" name="hrg_volume" readonly>
                                                        <input type="text" class="form-control display-hide"
                                                            id="volume-min" value="min" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox" id="chk-min-volume"> min
                                                    </div>
                                                </div>

                                            </div>


                                            <!-- <label>hidden</label> -->
                                            <input type="hidden" value="0" id="val_harga_volume"
                                                param="val_harga_volume" onkeyup="total()" class="data-dt"
                                                name="val_harga_volume" onchange="total()">
                                            <input type="hidden" value="0" id="min_volum" onkeyup="total()">
                                            <!-- <div class="col-md-6">
                                        <label id="label_harga_volume" class="form-label"></label>
                                    </div> -->
                                            <div>
                                                <!-- <label>hidden</label> -->
                                                <input type="hidden" value="0" id="harga_volume" class="data-dt"
                                                    param="harga_volume" onkeyup="total()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Subtotal</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp </span>
                                            </div>
                                            <input type="text" class="form-control data-dt number-format" value="0"
                                                id="val_subtotal" param="val_subtotal" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" value="0" id="discount-val" name="diskon"
                                            param="val_diskon" class="data-dt">
                                        <label class="form-label">Diskon</label>
                                        <div class="input-group">
                                            <input type="text" min="0" maxlength="" oninput="Check(this)"
                                                class="form-control allow-numeric data-dt" param="val_diskon"
                                                id="diskon" onkeyup="total()" value="0" readonly placeholder="Diskon"
                                                aria-label="Recipient's username with two button addons">
                                            <button class="btn btn-outline-secondary" id="persen"
                                                type="button">%</button>
                                            <button class="btn btn-outline-secondary" id="rupiah"
                                                type="button">Rp</button>
                                        </div>
                                    </div>
                                    <script type="text/javascript">

                                    </script>

                                    <div class="form-group">
                                        <label class="form-label">Total</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" param="val_total" class="form-control data-dt" value="0"
                                                id="val_total" name="val_total" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-5">
                                <button type="button" class="btn btn-success" name="tambah" data-row="-1"
                                    data-aksi="tambah" id="add-detail"><i class="fas fa-plus-circle"></i> Tambah
                                    Detail</button>
                            </div>
                            <div>
                                <h3>Detail Paket</h3>
                                <div class="row">
                                    <div class="col">
                                        <div class="card card-outline card-danger">
                                            <table class="table table-striped mb-0" id="table-detail">
                                                <!-- <table class="table table table-bordered"> -->
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>#</th>
                                                        <th>Jenis Kirim</th>
                                                        <th>Berat</th>
                                                        <th>Panjang</th>
                                                        <th>Lebar</th>
                                                        <th>Tinggi</th>
                                                        <th>Subtotal</th>
                                                        <th>Diskon (%)</th>
                                                        <th>Harga Berat</th>
                                                        <th>Harga Volume</th>
                                                        <th>Harga Koli</th>
                                                        <th>Jumlah Item</th>
                                                        <th>Total</th>
                                                        <!-- <td>Aksi</td> -->
                                                    </tr>
                                                </thead>
                                                <tbody id="table-container">
                                                </tbody>
                                                <!-- </table> -->
                                            </table>

                                        </div>
                                        <div class="">
                                            <div class="btn-batal">
                                                <button type="button" name="simpan" style="" class="btn btn-light"
                                                    onclick="history.back(-1)" id="btn-close"><i style="color:black"
                                                        class="fa fa-arrow-left"></i> Kembali</button>
                                                <button type="submit" name="simpan"
                                                    style="float: right;margin-right: 20px" class="btn btn-primary"
                                                    id="btn-save"><i class="fas fa-save"></i>
                                                    Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </form>


            <script type="text/javascript">
            $(".allow-numeric").bind("keypress", function(e) {
                var key = event.keyCode || event.which;
                let val = $(this).val().split('.').length;
                // alert(key)
                if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key >= 95 && key < 123) || (key >
                        218 &&
                        key <
                        223) || (key > 190 && key < 193) || (key == 130) || (key == 181) || (key == 144) || (
                        key ==
                        214) ||
                    (key == 224) || (key == 233) || (key == 173) || (key == 61) || (key == 188) || (key ==
                        59) ||
                    key ==
                    189 || key == 187 || key == 190 || (key >= 91 && key <= 94) || key == 47 || key == 59 || (
                        key >=
                        123 &&
                        key <= 126) || key == 64 || (key >= 32 && key <= 44) || key == 58 || key == 63) {
                    event.preventDefault();
                } else {
                    if (key === 46 && val > 1) {
                        event.preventDefault();
                    } else {
                        return true;
                    }
                }
            });
            $('#label_harga_berat').dblclick(function() {
                $('#label_harga_berat').html(
                    `<button class="btn btn-xs btn-success"><i class="fas fa-save" aria-hidden="true"></i></button>`
                );
                $('#harga-berat-custom').val($('#val_harga_berat').val());
                $('#label-qty-berat').removeClass('display-hide');
                $('#harga-berat-custom').removeClass('display-hide');
                $('#harga-berat-custom').focus();
                $('#harga-berat-custom').select();
            });
            $('#harga-berat-custom').blur(function() {
                let value = ($('#harga-berat-custom').val() == '') ? parseInt(0) : parseInt($(
                        '#harga-berat-custom')
                    .val());
                $('#label-qty-berat').addClass('display-hide');
                $('#harga-berat-custom').addClass('display-hide');
                $('#label_harga_berat').text('Rp ' + currencyFormat(value));
                $('#val_harga_berat').val(value);
                total();
            });
            $('#chk-min-berat').click(function() {
                if ($(this).is(':checked')) {
                    $('#val_jumlah_berat').attr('readonly', true);
                    $('#val_jumlah_berat').val(-1);
                    $('#berat-min').removeClass('display-hide');
                    $('#val_jumlah_berat').addClass('display-hide');
                } else {
                    $('#val_jumlah_berat').attr('readonly', false);
                    $('#val_jumlah_berat').val(0);
                    $('#val_jumlah_berat').focus();
                    $('#val_jumlah_berat').select();
                    $('#berat-min').addClass('display-hide');
                    $('#val_jumlah_berat').removeClass('display-hide');
                }
                total();
            });
            $('#label_harga_volume').dblclick(function() {
                $('#label_harga_volume').html(
                    `<button class="btn btn-xs btn-success"><i class="fas fa-save" aria-hidden="true"></i></button>`
                );
                $('#harga-volume-custom').val($('#val_harga_volume').val());
                $('#label-qty-volume').removeClass('display-hide');
                $('#harga-volume-custom').removeClass('display-hide');
                $('#harga-volume-custom').focus();
                $('#harga-volume-custom').select();
            });
            $('#harga-volume-custom').blur(function() {
                let value = ($('#harga-volume-custom').val() == '') ? parseInt(0) : parseInt($(
                        '#harga-volume-custom')
                    .val());
                $('#label-qty-volume').addClass('display-hide');
                $('#harga-volume-custom').addClass('display-hide');
                $('#label_harga_volume').text('Rp ' + currencyFormat(value));
                $('#val_harga_volume').val(value);
                total();
            });
            $('#label-harga-koli').dblclick(function() {
                $('#label-harga-koli').html(
                    `<button class="btn btn-xs btn-success"><i class="fas fa-save" aria-hidden="true"></i></button>`
                );
                $('#harga-koli-custom').val($('#harga_koli').val().split('.').join(''));
                $('#label-qty-koli').removeClass('display-hide');
                $('#harga-koli-custom').removeClass('display-hide');
                $('#harga-koli-custom').focus();
                $('#harga-koli-custom').select();
            });
            $('#harga-koli-custom').blur(function() {
                let value = ($('#harga-koli-custom').val() == '') ? parseInt(0) : parseInt($(
                        '#harga-koli-custom')
                    .val());
                $('#label-qty-koli').addClass('display-hide');
                $('#harga-koli-custom').addClass('display-hide');
                $('#label-harga-koli').text('Rp ' + currencyFormat(value));
                $('#harga_koli').val(value);
                total();
            });
            $('#chk-min-volume').click(function() {
                if ($(this).is(':checked')) {
                    $('#val_jumlah_volume').attr('readonly', true);
                    $('#val_panjang').attr('readonly', true);
                    $('#val_lebar').attr('readonly', true);
                    $('#val_tinggi').attr('readonly', true);
                    $('#val_panjang').val(-1);
                    $('#val_lebar').val(-1);
                    $('#val_tinggi').val(-1);
                    $('#hrg_volume').val(-1);
                    $('#volume-min').removeClass('display-hide');
                    $('#plt-min').removeClass('display-hide');
                    $('.volume-r').addClass('display-hide');
                    $('#hrg_volume').addClass('display-hide');
                } else {
                    $('#val_jumlah_volume').attr('readonly', false);
                    $('#val_panjang').attr('readonly', false);
                    $('#val_lebar').attr('readonly', false);
                    $('#val_tinggi').attr('readonly', false);
                    $('#val_panjang').val(0);
                    $('#val_lebar').val(0);
                    $('#val_tinggi').val(0);
                    $('#hrg_volume').val(0);
                    $('#val_panjang').focus();
                    $('#val_panjang').select();
                    $('#volume-min').addClass('display-hide');
                    $('#plt-min').addClass('display-hide');
                    $('.volume-r').removeClass('display-hide');
                    $('#hrg_volume').removeClass('display-hide');
                }
                total();
            });

            function get_jenis_kirim() {
                let option = ``;
                $.ajax({
                    type: 'POST',
                    url: `<?= base_url() ?>/api/get_jenis_kirim`,
                    data: {
                        layanan: $("#layanan").val(),
                        kd_kota_asal: $('#kd-lokasi_asal').val(),
                        kd_kota_tujuan: $('#kd-lokasi_tujuan')
                            .val(),
                        token: `<?=$_SESSION['token'] ?>`,
                    },
                    success: function(r) {
                        if (r == '') {
                            // option += `<option value="">Pilih Lokasi</option>`;
                        } else {
                            option += `<option value="">Pilih Jenis</option>`;
                            option += r;
                            $('#val-kd-jenis').html(option);
                        }
                    }
                });
            }

            function get_layanan() {
                let option = ``;
                $.ajax({
                    type: 'POST',
                    url: `<?= base_url() ?>/api/get_layanan`,
                    data: {
                        jenis_kirim: $("#val-kd-jenis").val(),
                        kd_kota_asal: $('#kd-lokasi_asal').val(),
                        kd_kota_tujuan: $('#kd-lokasi_tujuan').val(),
                        token: `<?=$_SESSION['token'] ?>`,
                    },
                    success: function(r) {
                        if (r == '') {
                            option += `<option value="">Pilih Lokasi</option>`;
                        } else {
                            option += `<option value="">Pilih Layanan</option>`;
                            option += r;
                            $('#layanan').html(option);
                        }
                    }
                });
            }
            $('.select2').select2();

            $('#val-kd-jenis').change(function() {
                if ($(this).val() != '') {
                    document.getElementById('jenis_k').value =
                        document.getElementById('val-kd-jenis').value;
                    $.ajax({
                        type: 'POST',
                        url: `<?= base_url() ?>/api/get_ongkir`,
                        data: {
                            layanan: $("#layanan").val(),
                            lokasi_asal: $('#kd-lokasi_asal').val(),
                            lokasi_tujuan: $('#kd-lokasi_tujuan').val(),
                            jenis_kirim: $('#jenis_k').val(),
                            token: `<?=$_SESSION['token'] ?>`
                        },
                        dataType: 'JSON',
                        success: function(r) {
                            console.log(r);
                            $('#label_harga_berat').html("Rp " +
                                currencyFormat(parseFloat(r.harga_berat)));
                            $('#label_min_berat').html("Minimum Berat : " +
                                r.min_berat + " kg");
                            $('#label_harga_volume').html("Rp " + currencyFormat(
                                parseFloat(r.harga_volume)));
                            $('#label_min_volume').html("Minimum Volume : " +
                                r.min_volume + " ");
                            $('#label-harga-koli').html("Rp " + currencyFormat(
                                parseFloat(r.harga_koli)));
                            $('#val_harga_berat').val(r.harga_berat);
                            $('#val_harga_volume').val(r.harga_volume);
                            $('#min').val(r.min_berat);
                            $('#min_volum').val(r.min_volume);
                            $('#harga_koli').val(currencyFormat(parseFloat(r.harga_koli)));
                            total();
                            // volume();
                            // total();
                            // total();
                            get_rp();
                            // total();
                            // $('#harga_koli').val(this(currencyFormat()));
                        }
                    });
                }
            });

            $('#butonn').click(function() {
                $.ajax({
                    type: 'POST',
                    url: `<?= base_url() ?>/api/get_customer`,
                    data: {
                        token: `<?=$_SESSION['token'] ?>`,
                        kd_customer: $('#cari').val(),
                    },
                    success: function(r) {
                        $('#m-container-panggil').html(r);
                        // $('#cari').append(this['nama']);
                    }
                });
            });

            $('.call-modal').click(function() {
                let key = $(this).data('key');
                let page = `<?= $page ?>`;
                let jenis = `pengiriman`;
                let jenis_modal = $(this).attr('id');
                let act = "add";
                let title_modal = "";
                $('#start-customer').val(0);
                $.ajax({
                    type: 'POST',
                    url: `<?= base_url() ?>/api/ajax_load_customer/0`,
                    data: {
                        token: `<?=$_SESSION['token']?>`,
                        file_name: `pengiriman/pengiriman/ajax_pengiriman`,
                        page: page,
                        jenis: jenis,
                        act: act
                    },
                    success: function(r) {
                        $('#m-crud-title-panggil').text(title_modal);
                        $('#m-customer').text(jenis_modal);
                        $('#m-container-panggil').html(r);
                        $('#modal-panggil').modal('show');
                        $('#cari').val('');
                        $('#cari').focus();
                        $('#start-customer').val(10);
                    }
                });
            });

            function addlamp() {
                let frame = document.getElementById('lampiran');
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            $('.checked-customer').click(function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 'pengirim') {
                        $('#val_kd_customer').val($('#kd-selected-pengirim').val())
                    } else {
                        $('#val_kd_customer').val($('#kd-selected-penerima').val())
                    }
                }
            });

            function cek_selected_customer() {
                let selected_customer = $("input[name='checked_customer']:checked").val();
                if (selected_customer == "pengirim") {
                    $('#val_kd_customer').val($('#kd-selected-pengirim').val())
                } else {
                    $('#val_kd_customer').val($('#kd-selected-penerima').val())
                }
            }

            function coba() {
                // $('#lama-kredit').prop('readonly', true);
                $('#lama-kredit').attr('type', 'hidden');
                // $('#lbl-lm').attr('type', 'hidden')
                $('#lbl-lm').hide();
                $('#input-jenis-pembayaran').removeClass('display-hide');
                $('#group-class').removeClass('display-hide');
                $('#lim-kredit').addClass('display-hide');
                $('#lama-kredit-group').addClass('display-hide');
            }

            function coba1() {
                // $('#lama-kredit').prop('readonly', false); //
                $('#lbl-lm').attr('type', 'hidden');
                $('#lama-kredit').attr('type', 'text');
                $('#lama-kredit').attr('value', '7');
                $('#lama-kredit').attr('style', 'display', false);
                $('#lbl-lm').show();
                $('#input-jenis-pembayaran').addClass('display-hide');
                $("#sc-jenis-pembayaran").val($("#sc-jenis-pembayaran option:first").val());
                $('#group-class').addClass('display-hide');
                $("#val_kd_kas").val($("#val_kd_kas option:first").val());
                $('#lim-kredit').removeClass('display-hide');
                $('#lama-kredit-group').removeClass('display-hide');
            }

            $(document).ready(function() {
                get_rp();
            })
            $(document).ready(function() {
                $('#kota-asal').keyup(function() {
                    var query = $(this).val();
                    if (query != '') {
                        $.ajax({
                            method: "POST",
                            url: `<?= base_url() ?>/api/lokasi`,
                            data: {
                                token: `<?=$_SESSION['token'] ?>`,
                                search_key: query,
                                find_type: 'kota_asal',
                                find_condition: $('#kota-tujuan').val()
                            },
                            success: function(r) {
                                console.log(r);

                                $('#kota-asal-list').html(r);
                                $('#kota-asal-list').fadeIn();
                                set_autocomplete_id(query,
                                    'kota-asal');
                            }
                        });
                    } else {
                        $('#kota-asal-list').fadeOut();
                    }
                });
                $('#kota-tujuan').keyup(function() {
                    var query = $(this).val();
                    if (query != '') {
                        $.ajax({
                            url: `<?= base_url() ?>/api/lokasi`,
                            method: "POST",
                            data: {
                                token: `<?=$_SESSION['token'] ?>`,
                                search_key: query,
                                find_type: 'kota_tujuan',
                                find_condition: $('#kota-asal').val()
                            },
                            success: function(r) {
                                console.log(r);

                                $('#kota-tujuan-list').html(r);
                                $('#kota-tujuan-list').fadeIn();
                                set_autocomplete_id(query, 'kota-tujuan');
                            }
                        });
                    } else {
                        $('#kota-tujuan-list').fadeOut();
                    }
                });
                $(document).on('click', '.li-kota-asal', function() {
                    $('#kota-asal').val($(this).text());
                    $('#kd-lokasi_asal').val($(this).data('key'));
                    $('#kota-asal-list').fadeOut();
                    get_jenis_kirim();
                });
                $(document).on('click', '.li-kota-tujuan', function() {
                    $('#kota-tujuan').val($(this).text());
                    $('#kd-lokasi_tujuan').val($(this).data('key'));
                    $('#kota-tujuan-list').fadeOut();
                    get_jenis_kirim();
                });


                function set_autocomplete_id(search, type) {
                    $('.autocomplete_li').each(function() {
                        if ($(this).text().toUpperCase() == search.toUpperCase()) {
                            $('#kd-' + type).val($(this).data('key'));
                            $('#' + type).val($(this).text());
                            $('#' + type + '-list').fadeOut();
                            get_jenis_kirim();
                        } else {
                            $('#kd-' + type).val('');
                        }
                    });
                }
            });
            $(':input').click(function() {
                $(this).select();
            });
            // diskon master
            $('#val_diskon_t').keyup(function() {
                if ($(this).val() == "") {
                    $(this).val(0);
                }
            });
            $('#persen_master').click(function() {
                $('#val_diskon_t').attr('maxlength', '3');
                $('#val_diskon_t').attr('readonly', false);
                $('#persen_master').attr('class', 'btn btn-success')
                $('#rupiah_master').attr('class', 'btn btn-outline-secondary')
            });
            $('#rupiah_master').click(function() {
                $('#val_diskon_t').attr('maxlength', '10');
                $('#val_diskon_t').attr('readonly', false);
                $('#rupiah_master').attr('class', 'btn btn-success')
                $('#persen_master').attr('class', 'btn btn-outline-secondary')
            });

            // detail
            $('#persen').click(function() {
                $('#diskon').attr('maxlength', '2');
                $('#diskon').attr('readonly', false);
                $('#persen').attr('class', 'btn btn-success')
                $('#rupiah').attr('class', 'btn btn-outline-secondary')
                $('#diskon').val('0')
                total();
            });

            $('#rupiah').click(function() {
                $('#diskon').attr('maxlength', '12');
                $('#diskon').attr('readonly', false);
                $('#rupiah').attr('class', 'btn btn-success')
                $('#persen').attr('class', 'btn btn-outline-secondary');
                $('#diskon').val('0');
                total();
            });

            function get_rp() {
                $('#diskon').attr('maxlength', '12');
                $('#diskon').attr('readonly', false);
                $('#rupiah').attr('class', 'btn btn-success')
                $('#persen').attr('class', 'btn btn-outline-secondary')
                $('#diskon').val('0')
                // $('#diskon').keyup(function() {
                //     $('#diskon').val().split('.').join('')
                //     this.value = parseFloat(this.value.replace(/,/g, ""))
                //         .toFixed(0)
                //         .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                //     // .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                //     // document.getElementById("number").value = this.value.replace(/,/g, "")
                // })
            }
            $('#diskon').blur(function() {
                if ($(this).val() == "") {
                    $(this).val(0);
                } else {
                    get_diskon();
                }
            });

            //data detail
            var dt_final = [];
            var dt_err = [];
            $("#add-detail").click(function() {
                let row = $(this).attr('data-row');
                let aksi = $(this).attr('data-aksi');
                if (aksi == "tambah") {
                    addRow();
                } else if (aksi == "ubah") {
                    updateRow(row);
                }
                reload_tbl_tmp_dt();
                $(this).attr('data-row', '-1');
                $(this).attr('data-aksi', 'tambah');
                // $('#val-kd-jenis').val('');
                $('#val_panjang').val('');
                $('#val_jumlah_berat').val('');
                $('#val_lebar').val('');
                $('#val_tinggi').val('');
                $('#hrg_volume').val('');
                $('#val_subtotal').val('');
                $('#diskon').val('');
                $('#val_total').val('');
                $('#jumlah-item').val('');


            });

            function reload_tbl_tmp_dt() {
                let data_dtl = ``;
                let jenis_kirim_js = <?= (!empty($arr_jenis_kirim)) ? $arr_jenis_kirim : '' ?>;
                for (var i = 0; i < dt_final.length; i++) {

                    data_dtl += `<tr>`;
                    data_dtl += `<td>` + (i + 1) + `</td>`;
                    data_dtl += `<td>` + jenis_kirim_js['detail_' + dt_final[i]['val_kd_jenis']] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_jumlah_berat'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_panjang'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_lebar'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_tinggi'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_subtotal'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_diskon'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_harga_berat'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_harga_volume'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_harga_koli'] + `</td>`;
                    // data_dtl += `<td>` + dt_final[i]['val_jumlah_item'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_jumlah_item'] + `</td>`;
                    data_dtl += `<td>` + dt_final[i]['val_total'] + `</td>`;

                    data_dtl += `<td> <button type="button" class="btn btn-xs btn-warning" onclick="getRow(` +
                        i + `)"><i class="fas fa-edit"></i></button> 
                            <button type="button" class="btn btn-xs btn-danger" onclick="deleteNRefresh(` + i +
                        `)"><i class="fas fa-trash"></i></button></td>`;
                    data_dtl += `</tr>`;
                }
                let table_template = data_dtl;
                $('#table-container').html(table_template);
            }


            function addRow() {
                var object = {};
                // let validation = true;
                // // let val_dt='';
                // $(".data-dt").each(function() {
                //     let name = $(this).attr("param");
                //     val = $(this).val();
                //     if ((name == "val_panjang" || name == "val_lebar" || name == "val_tinggi") && val == "") {
                //         val = 0;
                //     }
                //     if (val === "" || val === "none") {
                //         alert(val);
                //         validation = false;
                //         dt_err.push(name + 'wajib diisi');
                //         console.log(dt_err);
                //     } else {
                //         if (name == 'val_harga_koli') {
                //             object[name] = val.split('.').join('');
                //             // object[name] = $(this).val();
                //         } else {
                //             // alert(val);
                //             object[name] = val;
                //         }
                //     }
                // });
                // if (validation) {
                //     dt_final.push(object);
                // }
                $(".data-dt").each(function() {
                    let name = $(this).attr("param");
                    object[name] = $(this).val();
                });
                dt_final.push(object);
            }

            function updateRow(row) {
                var object = {};
                $(".data-dt").each(function() {
                    let name = $(this).attr("param");
                    object[name] = $(this).val();
                });
                dt_final[row] = object;
                $("#add-detail").attr('data-row', '-1');
                $("#add-detail").attr('data-aksi', 'tambah');

            }

            function deleteRow(row) {
                dt_final.splice(row, 1);
            }

            function deleteNRefresh(row) {
                deleteRow(row);
                reload_tbl_tmp_dt();
            }

            function getRow(row) {
                $('#val_kd_jenis').val(dt_final[row]['val_kd_jenis']);
                $('#val_jumlah_berat').val(dt_final[row]['val_jumlah_berat']);
                $('#val_panjang').val(dt_final[row]['val_panjang']);
                $('#val_lebar').val(dt_final[row]['val_lebar']);
                $('#val_tinggi').val(dt_final[row]['val_tinggi']);
                $('#val_subtotal').val(dt_final[row]['val_subtotal']);
                $('#val_diskon').val(dt_final[row]['val_diskon']);
                $('#val_total').val(dt_final[row]['val_total']);
                $('#val_harga_berat').val(dt_final[row]['val_harga_berat']);
                $('#val_harga_volume').val(dt_final[row]['val_harga_volume']);
                $('#add-detail').attr('data-row', row);
                $('#add-detail').attr('data-aksi', 'ubah');
                $('#add-detail').html('Simpan Perubahan');
            }

            $('#frm-pengiriman').submit(function(e) {
                e.preventDefault();
                // $('#btn-save').prop('disabled',true);
                let loading_button = `
                    <div style="width:50px;margin-left:30%">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="sr-only">Loading...</span></div>`;
                e.preventDefault();
                $('#btn-save').prop('disabled', true);
                $('#btn-save').html(loading_button);
                // dt_final = [];
                // addRow();
                // console.log(dt_final);
                // alert('aaaaa');
                console.log(dt_final);

                if (dt_err.length !== 0) {
                    for (var i = 0; i < dt_err.length; i++) {
                        alert(dt_err[i]);
                    }
                    $('#btn-save').prop('disabled', false);
                    $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
                } else {
                    form_data = new FormData($('#frm-pengiriman')[0]);
                    form_data.append('token', `<?=$_SESSION['token'] ?>`);
                    form_data.append('frm_table', 'pengiriman');
                    for (var i = 0; i < dt_final.length; i++) {
                        for (var property in dt_final[i]) {
                            form_data.append(`detail[${i}][${property}]`, dt_final[i][property]);
                        }
                    }
                    $.ajax({
                        type: 'post',
                        url: `<?= base_url() ?>/api/multi_insert`,
                        data: form_data,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        enctype: 'multipart/form-data',
                        success: function(r) {
                            console.log(r);
                            if (r.status == 200) {
                                tes_sweet('Simpan data berhasil');
                                swal2_confirm(`<?= base_url() ?>/load/view/pengiriman/pengiriman`);
                                // location.href = `<?= base_url() ?>/load/view/pengiriman/pengiriman`;
                            } else {
                                $('#btn-save').prop('disabled', false);
                                $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
                            }
                            // print_r($kirim);
                        }
                    });
                }

            });
            </script>
        </div>