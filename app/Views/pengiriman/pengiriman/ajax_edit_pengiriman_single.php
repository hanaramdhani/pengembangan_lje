<?php

use CodeIgniter\Database\MySQLi\Result;

if (isset($act) && $act == 'edit') {
    // print_r($edit_data);
    foreach ($get_ready_ongkir as $key => $value) {
        $kota_asal[$value->kd_kota_asal] = (object)['kd_lokasi' => $value->kd_kota_asal, "nama" => $value->kota_asal];
        // $m_kota_asal[$value->kd_kota_asal]=;
        $kota_tujuan[$value->kd_kota_tujuan] = (object)['kd_lokasi' => $value->kd_kota_tujuan, "nama" => $value->kota_tujuan];
        $layanan[$value->kd_layanan] = (object)['kd_layanan' => $value->kd_layanan, "nama" => $value->layanan];
        $jenis_kirim_t[$value->kd_jenis] = (object)['kd_jenis' => $value->kd_jenis, "nama" => $value->jenis_kirim];
    }
    $volume = $edit_data->panjang * $edit_data->lebar * $edit_data->tinggi;
    $volume_ = $volume * $edit_data->harga_volume;

    //item
    $harga_jumlah = $edit_data->harga_koli * $edit_data->jumlah_item;

    //berat
    $harga_berat = $edit_data->harga_berat * $edit_data->jumlah_berat;



    $result = $volume_ + $harga_jumlah + $harga_berat;
    if ($edit_data->diskon_dt < 1) {
        $diskon_tampil = $edit_data->diskon_dt * 100;
    } else {
        $diskon_tampil = $edit_data->diskon_dt;
    }
    if ($edit_data->diskon_dt < 1) {
        $total = $result - ($edit_data->diskon_dt * $result);
    } else {
        $total = $result - $diskon_tampil;
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
<div class="card card-outline card-danger">
    <div class="card-body">

        <form class="form-horizontal" id="frm-pengiriman-edit" autocomplete="off">
            <div class="card-body">
                <div class="tab-content" id="tab-pengirimanContent">
                    <!-- form data pengiriman -->
                    <input type="hidden" id="key-update" name="mt[key_no_transaksi]"
                        value="<?= $edit_data->no_transaksi ?>">

                    <input type="hidden" name="mt[val_tanggal]" class="data" value="<?= date('Y-m-d H:i:s') ?>">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Lokasi Asal</label>
                                <input type="text" class="form-control data" name="" value="<?= $edit_data->asal ?>"
                                    id="kota-asal" placeholder="Area pengirim" required>
                                <div id="kota-asal-list" style="z-index: 999;" class="position-relative"></div>
                                <input type="hidden" value="<?= $edit_data->kd_lokasi_asal ?>" id="kd-lokasi_asal"
                                    name="mt[val_kd_lokasi_asal]">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Lokasi Tujuan</label>
                                <input type="text" class="form-control data" id="kota-tujuan" name=""
                                    placeholder="Area penerima" value="<?= $edit_data->tujuan ?>" required>
                                <div id="kota-tujuan-list" style="z-index: 999;" class="position-relative">
                                </div>
                                <input type="hidden" id="kd-lokasi_tujuan" value="<?= $edit_data->kd_lokasi_tujuan ?>"
                                    name="mt[val_kd_lokasi_tujuan]">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Jenis Layanan</label>
                                <select name="mt[val_kd_layanan]" id="layanan" param="val_kd_layanan"
                                    class="form-control data-dt">
                                    <?php foreach ($layanan as $ly => $value) : ?>
                                    <option value="<?php echo $value->kd_layanan; ?>"
                                        <?= $edit_data->kd_layanan == $value->kd_layanan ? 'selected' : '' ?>>
                                        <?php echo $value->nama ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- mengambil kd_layanan -->
                                <input type="hidden" id="lyn">


                            </div>
                        </div>
                    </div>

                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <div class=" form-group">
                                <label class="control-label">Kode Referensi</label>
                                <input type="text" value="<?= $edit_data->no_transaksi_reff ?>"
                                    class="form-control data" id="val_no_transaksi_reff"
                                    name="mt[val_no_transaksi_reff]" value="-" required>
                            </div>
                            <div class="form-group" style="margin-top: 2rem">
                                <label class="control-label">Divisi</label>
                                <select name="mt[val_kd_divisi]" id="val_kd_divisi" param="val_kd_divisi"
                                    class="form-control data">
                                    <?php foreach ($divisi as $d => $value) : ?>
                                    <option value="<?php echo $value->kd_divisi; ?>"
                                        <?= $edit_data->kd_divisi == $value->kd_divisi ? 'selected' : '' ?>>
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
                                        <label for="val_status" class="col-sm-7">Status</label>
                                        <div class="col-sm-6" id="radio-aktif">
                                            <input type='radio' class="form-check-label" name="mt[val_status]"
                                                onclick="coba()" value="1"
                                                <?= ($edit_data->status == '1') ? 'checked' : '' ?>>
                                            <label class="form-check-label">Tunai</label>
                                        </div>
                                        <div class="col-sm-6" id="radio-aktif1">
                                            <input type='radio' name="mt[val_status]" onclick="coba1()" value="0"
                                                <?= ($edit_data->status == '0') ? 'checked' : '' ?>>
                                            <label class="form-check-label">Kredit</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group <?=($edit_data->status==0)?'display-hide':'' ?>"
                                        id="input-jenis-pembayaran" style="">
                                        <label class="col-sm-12">Jenis Bayar</label>
                                        <select id="sc-jenis-pembayaran" name="mt[val_kd_jenis_bayar]"
                                            param="val_kd_jenis_bayar" class="form-control data">
                                            <?php foreach ($jenis_bayar as $cs => $value) : ?>
                                            <option value="<?php echo $value->kd_jenis_bayar; ?>"
                                                <?= $edit_data->kd_jenis_bayar == $value->kd_jenis_bayar ? 'selected' : '' ?>>
                                                <?php echo $value->nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group <?=($edit_data->status==0)?'display-hide':'' ?>" id="group-class"
                                style="margin-top: 1rem">
                                <label class="control-label">KAS</label>
                                <select name="mt[val_kd_kas]" id="val_kd_kas" class="form-control data">
                                    <?php foreach ($kas as $k => $value) : ?>
                                    <option value="<?php echo $value->kd_kas; ?>"
                                        <?= $edit_data->kd_kas == $value->kd_kas ? 'selected' : '' ?>>
                                        <?php echo $value->no_rekening ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group <?=($edit_data->status==1)?'display-hide':'' ?>"
                                id="lama-kredit-group" style="margin-top: 2rem">
                                <label style="display: none;" id="lbl-lm" class="col-sm-7">Lama Kredit</label>
                                <div class="input-group">
                                    <input type="hidden" class="form-control data" id="lama-kredit"
                                        value="<?= $edit_data->lama_kredit ?>" name="mt[val_lama_kredit]"
                                        placeholder="Masukkan Lama Kredit" required>
                                    <div class="input-group-append <?=($edit_data->status==1)?'display-hide':'' ?>"
                                        style="cursor: pointer;" id="lim-kredit">
                                        <span class="input-group-text">Hari</span>
                                    </div>
                                </div>

                            </div>
                            <script>
                            if ($('#lama-kredit').val() != 0) {
                                $('#lama-kredit').attr('type', 'text')
                                $('#lbl-lm').show()
                            } else {
                                $('#lama-kredit').attr('type', 'hidden')
                                $('#lbl-lm').hide()
                            }
                            </script>
                            <div class="form-group row">
                                <label style="display: none;" class="col-sm-7 col-form-label">Diskon</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input style="display: none;" type="text" min="0"
                                                class="form-control data data-dt" id="val_diskon_t"
                                                oninput="Check(this)" param="val_diskon_t" maxlength="3" max="99"
                                                value="<?= $edit_data->diskon ?>" name="mt[val_diskon]" readonly
                                                placeholder="Masukkan Diskon" onkeyup="total()" value="0">
                                        </div>
                                        <div class="col-md-3">
                                            <button style="display: none;" id="persen_master"
                                                class="btn btn-secondary w-80">%</button>
                                        </div>
                                        <div class="col-md-3">
                                            <button style="display: none;" id="rupiah_master"
                                                class="btn btn-secondary w-80">Rp</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <textarea id="val_keterangan" name="mt[val_keterangan]" param="val_keterangan" style=""
                                    rows="1" class="form-control data"
                                    placeholder="Masukkan Keterangan"><?= $edit_data->keterangan ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="subject">Lampiran</label>
                                <!-- <div class="col pl-0 mb-2">
                            <div class="img-preview">
                                <img id="lampiran" src="/assets/dist/img/fa-solid_image.png" class="w-100 p-4">
                            </div>
                        </div> -->
                                <div class="col pl-0">
                                    <input type="file" name="val_lampiran" id="val_lampiran" param="val_lampiran"
                                        class="data" onchange="addlamp()">
                                </div>
                            </div>
                            <script>
                            function addlamp() {
                                let frame = document.getElementById('lampiran');
                                frame.src = URL.createObjectURL(event.target.files[0]);
                            }
                            </script>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- pengirim dan penerima -->
                    <hr />
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-0">
                                <input type="hidden" class="form-control data" id="val_kd_customer"
                                    value="<?= $edit_data->kd_customer ?>" name="mt[val_kd_customer]">
                                <h3 class="mr-3 mb-0">Data Pengirim</h3>
                                <div class="">
                                    <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                        id="pengirim"><span id="pengirim-text"><?= $edit_data->nama_pengirim ?></span>
                                        <i class="fa fa-sync-alt pl-2" aria-hidden="true"></i></button>
                                </div>


                            </div>
                            <div class="mb-3" style="color: green"><input type="radio" name="checked_customer"
                                    class="checked-customer" id="checked-pengirim" value="pengirim"> Set Sebagai
                                Customer</div>
                            <div class=" form-group row">
                                <label class="col-sm-7 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="hidden" id="kd-selected-pengirim" value="">
                                    <input type="text" value="<?= $edit_data->nama_pengirim ?>"
                                        class="form-control data" id="val_nama_pengirim" param="val_nama_pengirim"
                                        name="mt[val_nama_pengirim]" placeholder="Nama pengirim" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-7 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea id="val_alamat_pengirim" name="mt[val_alamat_pengirim]"
                                        param="val_alamat_pengirim" class="form-control data"
                                        placeholder="Alamat pengirim"><?= $edit_data->alamat_pengirim ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-7 col-form-label">No. Hp</label>
                                <div class="col-sm-10">
                                    <input type="text" value="<?= $edit_data->no_hp_pengirim ?>"
                                        class="form-control data" id="val_hp_pengirim" name="mt[val_no_hp_pengirim]"
                                        placeholder="No. HP pengirim">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-0">
                                <h3 class="mr-3 mb-0">Data Penerima</h3>
                                <div>
                                    <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                        id="penerima"><span id="penerima-text"><?= $edit_data->nama_penerima ?></span>
                                        <i class="fa fa-sync-alt pl-2" aria-hidden="true"></i></button>
                                </div>


                            </div>
                            <div class="mb-3" style="color: green"><input type="radio" name="checked_customer"
                                    class="checked-customer" id="checked-penerima" value="penerima" checked> Set Sebagai
                                Customer</div>
                            <div class=" form-group row">
                                <label class="col-sm-7 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="hidden" id="kd-selected-penerima"
                                        value="<?=$edit_data->kd_customer ?>">
                                    <input type="text" class="form-control data" id="val_nama_penerima"
                                        name="mt[val_nama_penerima]" param="val_nama_penerima"
                                        value="<?= $edit_data->nama_penerima ?>" placeholder="Nama penerima" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-7 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea id="val_alamat_penerima" name="mt[val_alamat_penerima]"
                                        param="val_alamat_penerima" class="form-control data"
                                        placeholder="Alamat penerima"><?= $edit_data->alamat_penerima ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-7 col-form-label">No. Hp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control data" id="val_hp_penerima"
                                        value="<?= $edit_data->no_hp_penerima ?>" name="mt[val_no_hp_penerima]"
                                        placeholder="No. HP penerima">
                                </div>
                            </div>


                        </div>

                    </div>

                    <!-- </div> -->


                    <input type="hidden" id="key-update" name="dt[key_no_transaksi]"
                        value="<?= $edit_data->no_transaksi ?>">
                    <input type="hidden" id="key-update" name="dt[val_no_transaksi]"
                        value="<?= $edit_data->no_transaksi ?>">
                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Jenis Kirim</label>
                                <select id="val-kd-jenis" name="dt[val_kd_jenis]" param="dt[val_kd_jenis]"
                                    class="form-control data-dt ongkir" required>
                                    <?php foreach ($jenis_kirim_t as $jk => $value) : ?>
                                    <option class="jenis_krm" value="<?php echo $value->kd_jenis; ?>"
                                        <?= $edit_data->kd_jenis == $value->kd_jenis ? 'selected' : '' ?>>
                                        <?php echo $value->nama ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <!-- <input type="text" name="val_jumlah_item" id="jumlah-item" value="0" param="val_jumlah_item" class="form-control data-dt" onkeyup="total()" placeholder="Masukkan Jumlah Item">
                    <input type="text" class="data-dt" onkeyup="total()" param="val_harga_koli"
                    id="harga_koli"> -->
                                <input class="form-control" name="dt[val_keterangan1]" id="keterangan-id"
                                    placeholder="Keterangan" value="<?=$edit_data->keterangan_dt ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Koli</label>
                                <!-- <input type="text" id="jumlah-item" param="val_jumlah_item" class="form-control data-dt" onkeyup="resultsubtotal()"> -->
                                <div class="input-group">
                                    <div class="input-group-append" style="cursor: pointer;"
                                        title="Double click untuk ubah harga">
                                        <span class="input-group-text" id="label-harga-koli">Rp
                                            <?=number_format($edit_data->harga_koli,0,',','.') ?></span>
                                    </div>
                                    <input type="text" value="0" id="harga-koli-custom"
                                        class="form-control display-hide allow-numeric">
                                    <div class="input-group-append display-hide" id="label-qty-koli">
                                        <span class="input-group-text"> C: </span>
                                    </div>
                                    <input type="text" name="dt[val_jumlah_item]" value="<?= $edit_data->jumlah_item ?>"
                                        id="jumlah-item" param="dt[val_jumlah_item]"
                                        class="form-control data-dt allow-numeric" onkeyup="total1()"
                                        placeholder="Masukkan Jumlah Item">
                                    <input type="hidden" class="data-dt" onkeyup="total1()" name="dt[val_harga_koli]"
                                        value="<?= $edit_data->harga_koli ?>" id="harga_koli">

                                </div>
                            </div>
                            <input type="hidden" id="jenis_k" value="<?= $edit_data->kd_jenis ?>">
                            <div id="jenis-kirim-container"></div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group" style="margin-bottom: 0.6rem">
                                <label>Berat (kg)</label><span style="font-size: 14px;" id="label_min_berat"></span>
                                <div class="row align-items-center">
                                    <input type="hidden" value="<?= $edit_data->harga_berat ?>" class="data-dt"
                                        id="val_harga_berat" name="dt[val_harga_berat]" param="dt[val_harga_berat]"
                                        onkeyup="total1()">
                                    <input type="hidden" id="min">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="input-group-append" style="cursor: pointer;"
                                                    title="Double click untuk ubah harga">
                                                    <span id="label_harga_berat" class="input-group-text"> Rp
                                                        <?= number_format($edit_data->harga_berat,0,',','.') ?></span>
                                                </div>
                                                <input type="text" value="0" id="harga-berat-custom"
                                                    class="form-control display-hide allow-numeric">
                                                <div class="input-group-append display-hide" id="label-qty-berat">
                                                    <span class="input-group-text"> W: </span>
                                                </div>
                                                <input type="text" id="val_jumlah_berat" param="dt[val_jumlah_berat]"
                                                    name="dt[val_jumlah_berat]" value="<?= $edit_data->jumlah_berat ?>"
                                                    class="data-dt form-control <?=($edit_data->panjang==-1)?'display-hide':'' ?> allow-numeric"
                                                    placeholder="Masukkan berat" onkeyup="total1()"
                                                    <?=($edit_data->jumlah_berat==-1)?'readonly':'' ?>>
                                                <input type="text"
                                                    class="form-control <?=($edit_data->panjang!=-1)?'display-hide':'' ?>"
                                                    id="berat-min" value="min" disabled>
                                            </div>
                                            <input type="hidden" class="data-dt" id="harga_berat" param="harga_berat"
                                                onkeyup="total1()">

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-1">
                                                <input type="checkbox" id="chk-min-berat"
                                                    <?=($edit_data->jumlah_berat==-1)?'checked':'' ?>> min
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dimensi</label>
                                <div class="row">
                                    <div class="col-md-4 volume-r <?=($edit_data->panjang==-1)?'display-hide':'' ?>">
                                        <input type="text" class="form-control data-dt allow-numeric" id="val_panjang"
                                            param="dt[val_panjang]" name="dt[val_panjang]"
                                            value="<?= $edit_data->panjang ?>" placeholder="Panjang (m)"
                                            onkeyup="total1()" <?=($edit_data->panjang==-1)?'readonly':'' ?>>
                                    </div>
                                    <div class="col-md-4 volume-r <?=($edit_data->panjang==-1)?'display-hide':'' ?>">
                                        <input type="text" class="form-control data-dt allow-numeric" id="val_lebar"
                                            param="dt[val_panjang]" name="dt[val_lebar]" placeholder="Lebar (m)"
                                            onkeyup="total1()" value="<?= $edit_data->lebar ?>"
                                            <?=($edit_data->lebar==-1)?'readonly':'' ?>>
                                    </div>
                                    <div class="col-md-4 volume-r <?=($edit_data->panjang==-1)?'display-hide':'' ?>">
                                        <input type="text" class="form-control data-dt allow-numeric" id="val_tinggi"
                                            param="dt[val_tinggi]" name="dt[val_tinggi]" placeholder="Tinggi (m)"
                                            onkeyup="total1()" value="<?= $edit_data->tinggi ?>"
                                            <?=($edit_data->tinggi==-1)?'readonly':'' ?>>
                                    </div>
                                    <div class="col-md-12 <?=($edit_data->panjang!=-1)?'display-hide':'' ?>"
                                        id="plt-min">
                                        <input type="text" class="form-control" value="min" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Volume (<span class="min-volume"></span>&#13221;)</label>
                                <span class="min-volume" style="font-size: 14px;" id="label_min_volume"></span>
                                <div class="row align-items-center">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="input-group-append" style="cursor: pointer;"
                                                    title="Double click untuk ubah harga">
                                                    <span id="label_harga_volume" class="input-group-text">Rp
                                                        <?= number_format($edit_data->harga_volume,0,',','.') ?></span>
                                                </div>
                                                <input type="text" value="0" id="harga-volume-custom"
                                                    class="form-control display-hide allow-numeric">
                                                <div class="input-group-append display-hide" id="label-qty-volume">
                                                    <span class="input-group-text"> V: </span>
                                                </div>
                                                <input type="text"
                                                    class="form-control data-dt <?=($edit_data->tinggi==-1)?'display-hide':'' ?>"
                                                    id="hrg_volume" param="hrg_volume" name="dt[hrg_volume]"
                                                    value="<?= $volume ?>" readonly value="">
                                                <input type="text"
                                                    class="form-control <?=($edit_data->tinggi!=-1)?'display-hide':'' ?>"
                                                    id="volume-min" value="min" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-1">
                                                <input type="checkbox" id="chk-min-volume"
                                                    <?=($volume==-1)?'checked':'' ?>> min
                                            </div>
                                        </div>

                                    </div>
                                    <!-- <label>hidden</label> -->
                                    <input type="hidden" id="val_harga_volume" value="<?= $edit_data->harga_volume ?>"
                                        param="dt[val_harga_volume]" onkeyup="total1()" class="data-dt"
                                        name="dt[val_harga_volume]" onchange="total1()">
                                    <input type="hidden" id="min_volum" onkeyup="total1()">
                                    <div>
                                        <!-- <label>hidden</label> -->
                                        <input type="hidden" id="harga_volume" class="data-dt" param="harga_volume"
                                            onkeyup="total1()">
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
                                    <input type="text" class="form-control data-dt" id="val_subtotal"
                                        param="val_subtotal" value="<?php echo number_format($result, 0, ',', '.') ?>"
                                        readonly>
                                </div>

                            </div>
                            <div class="form-group">
                                <input type="hidden" min="0" class="data-dt" param="val_diskon" id="discount-val"
                                    value="<?= $edit_data->diskon_dt ?>" name="dt[val_diskon]">
                                <label class="form-label">Diskon</label>
                                <div class="input-group">
                                    <input type="text" min="0" maxlength="<?=($edit_data->diskon_dt<1)?2:10 ?>"
                                        oninput="Check(this)" class="form-control allow-numeric" id="diskon"
                                        onkeyup="total()" maxlength="<?=($edit_data->diskon_dt<1)?2:10 ?>"
                                        oninput="Check(this)"
                                        value="<?php echo number_format($diskon_tampil, 0, ',', '.') ?>" readonly
                                        placeholder="Diskon" aria-label="Recipient's username with two button addons">
                                    <button class="btn btn-outline-secondary" id="persen" type="button">%</button>
                                    <button class="btn btn-outline-secondary" id="rupiah" type="button">Rp</button>
                                </div>
                            </div>


                            <div class="form-group">

                                <label class="form-label">Total</label>
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Rp </span>
                                    </div>
                                    <input type="text" class="form-control data-dt" id="val_total" name="val_total"
                                        param="val_total" value="<?= $total ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="btn-batal">
                    <button type="button" name="simpan" style="" class="btn btn-light" onclick="history.back(-1)"
                        id="btn-close"><i style="color:black" class="fa fa-arrow-left"></i> Kembali</button>
                    <button type="submit" name="simpan" id="btn-save" style="float: right;margin-right: 20px"
                        class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(".allow-numeric").bind("keypress", function(e) {
    var key = event.keyCode || event.which;
    let val = $(this).val().split('.').length;
    // alert(key)
    if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key >= 95 && key < 123) || (key > 218 && key <
            223) || (key > 190 && key < 193) || (key == 130) || (key == 181) || (key == 144) || (key == 214) ||
        (key == 224) || (key == 233) || (key == 173) || (key == 61) || (key == 188) || (key == 59) || key ==
        189 || key == 187 || key == 190 || (key >= 91 && key <= 94) || key == 47 || key == 59 || (key >= 123 &&
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
$('.checked-customer').click(function() {
    if ($(this).is(':checked')) {
        if ($(this).val() == 'penerima') {
            $('#val_kd_customer').val($('#kd-selected-penerima').val())
        } else {
            if ($('#kd-selected-pengirim').val() != "") {
                $('#val_kd_customer').val($('#kd-selected-pengirim').val())

            } else {
                alert('maaf, silahkan pilih customer sebagai pengirim terlebih dahulu')
                $('#checked-penerima').prop('checked', true);
            }
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
$(document).ready(function() {

    $('#kota-asal').keyup(function() {
        var query = $(this).val();
        if (query != '') {
            $.ajax({
                method: "POST",
                url: `<?= base_url() ?>/api/lokasi`,
                data: {
                    token: '123',
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
                    token: '123',
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
        clean();
    });
    $(document).on('click', '.li-kota-tujuan', function() {
        $('#kota-tujuan').val($(this).text());
        $('#kd-lokasi_tujuan').val($(this).data('key'));
        $('#kota-tujuan-list').fadeOut();
        get_jenis_kirim();
        clean();
    });
    // get_jenis_kirim();
    panggil1();
    // resultberat();
    // resultvolume();
    // resultsubtotal();
    // total1();
    // get_diskon();
    // testing();
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
$('#layanan').click(function() {
    document.getElementById('lyn').value = document.getElementById(
        'layanan').value;
});

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

function diskon_first_load() {
    if ($('#discount-val').val() < 1) {
        $('#persen').attr('class', 'btn btn-warning')
        $('#rupiah').attr('class', 'btn btn-outline-secondary')

    } else {
        $('#rupiah').attr('class', 'btn btn-warning')
        $('#persen').attr('class', 'btn btn-outline-secondary')
    }
}
$('#label_harga_berat').dblclick(function() {
    $('#label_harga_berat').html(
        `<button class="btn btn-xs btn-success"><i class="fas fa-save" aria-hidden="true"></i></button>`);
    $('#harga-berat-custom').val($('#val_harga_berat').val());
    $('#label-qty-berat').removeClass('display-hide');
    $('#harga-berat-custom').removeClass('display-hide');
    $('#harga-berat-custom').focus();
    $('#harga-berat-custom').select();
});
$('#harga-berat-custom').blur(function() {
    let value = ($('#harga-berat-custom').val() == '') ? parseInt(0) : parseInt($('#harga-berat-custom').val());
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
        `<button class="btn btn-xs btn-success"><i class="fas fa-save" aria-hidden="true"></i></button>`);
    $('#harga-volume-custom').val($('#val_harga_volume').val());
    $('#label-qty-volume').removeClass('display-hide');
    $('#harga-volume-custom').removeClass('display-hide');
    $('#harga-volume-custom').focus();
    $('#harga-volume-custom').select();
});
$('#harga-volume-custom').blur(function() {
    let value = ($('#harga-volume-custom').val() == '') ? parseInt(0) : parseInt($('#harga-volume-custom')
    .val());
    $('#label-qty-volume').addClass('display-hide');
    $('#harga-volume-custom').addClass('display-hide');
    $('#label_harga_volume').text('Rp ' + currencyFormat(value));
    $('#val_harga_volume').val(value);
    total();
});
$('#label-harga-koli').dblclick(function() {
    $('#label-harga-koli').html(
        `<button class="btn btn-xs btn-success"><i class="fas fa-save" aria-hidden="true"></i></button>`);
    $('#harga-koli-custom').val($('#harga_koli').val().split('.').join(''));
    $('#label-qty-koli').removeClass('display-hide');
    $('#harga-koli-custom').removeClass('display-hide');
    $('#harga-koli-custom').focus();
    $('#harga-koli-custom').select();
});
$('#harga-koli-custom').blur(function() {
    let value = ($('#harga-koli-custom').val() == '') ? parseInt(0) : parseInt($('#harga-koli-custom').val());
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
            token: 123,
        },
        success: function(r) {
            if (r == '') {
                option += `<option value="">Pilih Lokasi</option>`;
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
            token: 123,
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

function panggil1() {
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/get_ongkir`,
        data: {
            layanan: <?= $edit_data->kd_layanan ?>,
            lokasi_asal: <?= $edit_data->kd_lokasi_asal ?>,
            lokasi_tujuan: <?= $edit_data->kd_lokasi_tujuan ?>,
            jenis_kirim: <?= $edit_data->kd_jenis ?>,
            token: 123
        },
        dataType: 'JSON',
        success: function(r) {
            console.log(r);
            // $('#label_harga_berat').html("Rp " +currencyFormat(parseFloat(r.harga_berat)));
            $('#label_min_berat').html("Minimum Berat : " + r.min_berat + " kg");
            // $('#label_harga_volume').html("Rp " +currencyFormat(parseFloat(r.harga_volume)));
            $('#label_min_volume').html("Minimum Volume : " + r.min_volume + " ");
            // $('#label-harga-koli').html("Rp " +currencyFormat(parseFloat(r.harga_koli)));
            // $('#val_harga_berat').val(r.harga_berat);
            // $('#val_harga_volume').val(r.harga_volume);
            $('#min').val(r.min_berat);
            $('#min_volum').val(r.min_volume);
            // $('#harga_koli').val(currencyFormat(parseFloat(r.harga_koli)));
            total1();
            diskon_first_load();
        }
    });
}

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
                token: 123
            },
            dataType: 'JSON',
            success: function(r) {
                console.log(r);
                $('#label_harga_berat').html("Rp " +
                    currencyFormat(parseFloat(r.harga_berat)));

                $('#label_min_berat').html("Minimum Berat : " +
                    r.min_berat + " kg");
                $('#label_harga_volume').html("Rp " +
                    currencyFormat(
                        parseFloat(r.harga_volume)));
                $('#label_min_volume').html("Minimum Volume : " +
                    r.min_volume + " ");
                $('#val_harga_berat').val(r.harga_berat);
                $('#val_harga_volume').val(r.harga_volume);
                $('#min').val(r.min_berat);
                $('#min_volum').val(r.min_volume);
                $('#harga_koli').val(currencyFormat(parseFloat(r
                    .harga_koli)));
                resultberat();
                get_rp();
                clean();
            }
        });
    }
});

$('#butonn').click(function() {
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/get_customer`,
        data: {
            token: 123,
            kd_customer: $('#cari').val(),
        },
        success: function(r) {
            $('#m-container-panggil').html(r);
        }
    });
});

$('.call-modal').click(function() {
    let key = $(this).data('key');
    let page = 'ajax_edit_pengiriman_single';
    let jenis = `pengiriman`;
    let jenis_modal = $(this).attr('id');
    let act = "add";
    let title_modal = "";
    $('#start-customer').val(0);
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/ajax_load_customer/0`,
        data: {
            token: `<?= $_SESSION['token'] ?>`,
            file_name: `pengiriman/pengiriman/ajax_edit_pengiriman_single`,
            page: page,
            jenis: jenis,
            act: act
        },
        success: function(r) {
            $('#m-crud-title-panggil').text(title_modal);
            $('#m-customer').text(jenis_modal);
            $('#m-container-panggil').html(r);
            $('#modal-panggil').modal('show');
            $('#start-customer').val(10);
        }
    });
});

function get_rp() {
    $('#diskon').attr('maxlength', '12');
    $('#diskon').attr('readonly', false);
    $('#rupiah').attr('class', 'btn btn-success')
    $('#persen').attr('class', 'btn btn-outline-secondary')
    $('#diskon').val('0')
}
var dt_final = [];
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
    $('#val-kd-jenis').val('');
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

function clean() {
    $('#jumlah-item').val('0');
    $('#val_jumlah_berat').val('0');
    $('#val_lebar').val('0');
    $('#val_panjang').val('0');
    $('#val_tinggi').val('0');
    $('#hrg_volume').val('0');
    $('#val_subtotal').val('0');
    $('#diskon').val('0');
    $('#val_total').val('0');
    $('#discount-val').val('0');
    $('#harga_volume').val('0');
    $('#harga_berat').val('0');
}

function addRow() {
    var object = {};
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

$('#frm-pengiriman-edit').submit(function(e) {
    e.preventDefault();

    let loading_button = `
        <div style="width:50px;margin-left:30%">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span></div>`;
    e.preventDefault();
    $('#btn-save').prop('disabled', true);
    $('#btn-save').html(loading_button);
    form_data = new FormData($('#frm-pengiriman-edit')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'pengiriman');
    for (var i = 0; i < dt_final.length; i++) {
        for (var property in dt_final[i]) {
            form_data.append(`detail[${i}][${property}]`, dt_final[i][property]);
        }
    }
    $.ajax({
        type: 'post',
        url: `<?= base_url() ?>/api/update_md`,
        data: form_data,
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(r) {
            console.log(r);
            if (r.status == 200) {
                tes_sweet('Update data berhasil');
                location.href = `<?= base_url() ?>/load/view/pengiriman/pengiriman`;
            } else {
                $('#btn-save').prop('disabled', false);
                $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
            }
        }
    });
});
// hasil kali diskon 0,

$(':input').click(function() {
    $(this).select()
})

// diskon master
$('#val_diskon_t').keyup(function() {
    if ($(this).val() == "") {
        $(this).val(0);
    }
});
$('#persen_master').click(function() {
    $('#val_diskon_t').attr('maxlength', '3');
    $('#val_diskon_t').attr('readonly', false);
    $('#persen_master').attr('class', 'btn btn-success w-80 form-control')
    $('#rupiah_master').attr('class', 'btn btn-secondary w-80 form-control')
});
$('#rupiah_master').click(function() {
    $('#val_diskon_t').attr('maxlength', '10');
    $('#val_diskon_t').attr('readonly', false);
    $('#rupiah_master').attr('class', 'btn btn-success w-80 form-control')
    $('#persen_master').attr('class', 'btn btn-secondary w-90 form-control')
});
$('#persen').click(function() {
    $('#diskon').attr('maxlength', '2');
    $('#diskon').attr('readonly', false);
    $('#persen').attr('class', 'btn btn-success')
    $('#rupiah').attr('class', 'btn btn-outline-secondary')
    $('#diskon').val(0);
    $('#discount-val').val(0);
    total1();
    // $('#diskon').val() = $(this).val();
});
$('#rupiah').click(function() {
    $('#diskon').attr('maxlength', '12');
    $('#diskon').attr('readonly', false);
    $('#rupiah').attr('class', 'btn btn-success')
    $('#persen').attr('class', 'btn btn-outline-secondary')
    $('#diskon').val(0);
    $('#discount-val').val(0);
    total1();
    // $('#diskon').val() = $(this).val();
});

function currencyFormat(num) {
    return (num
        .toFixed(0)
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    );
}
$('#diskon').blur(function() {
    if ($(this).val() == "") {
        $(this).val(0);
    } else {
        get_diskon();
    }
});
</script>

<?php
} elseif (isset($act) && $act == 'add' && $modal) {
    $no = $last_start;
    foreach ($customer as $cs => $value) : ?>
<input type="hidden" value="<?php echo $value->kd_customer ?>" id="customer-id-<?php echo $no ?>">
<input type="hidden" value="<?php echo $value->nama ?>" id="customer-name-<?php echo $no ?>">
<input type="hidden" value="<?php echo $value->alamat ?>" id="customer-alamat-<?php echo $no ?>">
<input type="hidden" value="<?php echo $value->hp ?>" id="customer-hp-<?php echo $no ?>">
<input type="hidden" value="<?php echo $value->kabupaten ?>" id="customer-kabupaten-<?php echo $no ?>">

<button type="button" data-id="<?php echo $no ?>" class="btn btn-sm panggil" id="pilih-customer" data-dismiss="modal"
    data-key="<?= $value->kd_customer ?>"
    style="border: solid darkgray 1px; height: 80px; width: 100%; margin-top: 10px;">

    <div class="row">
        <div class="col-md-2 mt-4">
            <i class="fas fa-image text-center"></i>
        </div>
        <div class="col-md-3">
            <li style="padding: 1px; font-size: 16px; text-align: left; list-style: none;">
                <strong><?php echo $value->nama ?></strong>
            </li>
            <li style="padding: 1px; text-align: left; list-style: none;"><?php echo $value->hp ?></li>
            <li style="padding: 1px; text-align: left; list-style: none;"><?php echo $value->kabupaten ?></li>
        </div>
    </div>
</button>
<?php
        $no++;
    endforeach;
    ?>
<button style="width: 100%;color: navy" id="btn-load-more_<?= $no ?>" class="btn btn-light mt-2 mb-4"
    onclick="load_more_customer(`<?= ($no) ?>`)">Load More
</button>
<script type="text/javascript">
function load_more_customer(start) {
    let key = $(this).data('key');
    let page = `ajax_edit_pengiriman_single`;
    let jenis = `pengiriman`;
    let jenis_modal = $(this).attr('id');
    let act = "add";
    let title_modal = "";

    $('#btn-load-more_' + start).html(loading);
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/ajax_load_customer/` + start,
        data: {
            token: `<?= $_SESSION['token'] ?>`,
            file_name: `pengiriman/pengiriman/ajax_edit_pengiriman_single`,
            page: page,
            jenis: jenis,
            act: act
        },
        success: function(r) {
            $('#btn-load-more_' + start).remove();
            $('#m-container-panggil').append(r);
        }
    });
}
$('.panggil').on('click', function() {
    let key = $(this).data('key');
    let page = `<?= $page ?>`;
    let jenis = `<?= $jenis ?>`;
    let jenis_modal = $(this).attr('id');
    let title_modal = "";
    let id = $(this).data('id');
    let tujuan = $('#m-customer').text();
    if (tujuan == "pengirim") {
        $('#kd-selected-pengirim').val($("#customer-id-" + id).val());
        $('#val_nama_pengirim').val($("#customer-name-" + id).val());
        $('#val_alamat_pengirim').val($("#customer-alamat-" + id).val());
        $('#val_kabupaten_pengirim').val($("#customer-kabupaten-" + id)
            .val());
        $('#val_hp_pengirim').val($("#customer-hp-" + id).val());
        $('#pengirim-text').text($("#customer-name-" + id).val());
    } else {
        $('#kd-selected-penerima').val($("#customer-id-" + id).val());
        $('#val_nama_penerima').val($("#customer-name-" + id).val());
        $('#val_alamat_penerima').val($("#customer-alamat-" + id).val());
        $('#val_kabupaten_penerima').val($("#customer-kabupaten-" + id)
            .val());
        $('#val_hp_penerima').val($("#customer-hp-" + id).val());
        $('#penerima-text').text($("#customer-name-" + id).val());
    }
    cek_selected_customer();
});

function hitung() {
    let jumlah_item = $('#jumlah-item').val();
    let jumlah_berat = $('#val_jumlah_berat').val();
    let volume = $('#val_panjang').val() * $('#val_tinggi').val() * $('#val_lebar').val();
}
</script>
<?php
} else {
    echo view('errors/html/error_404');
}
?>