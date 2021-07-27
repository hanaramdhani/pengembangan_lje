<?php

// print_r($layanan);
// print_r($jenis_kirim);
// print_r($pengiriman_detail);
// print_r($kirim_detail);
date_default_timezone_set('Asia/Jakarta');
if (isset($act) && $act == "view") {
    // print_r($pengiriman);
    $data_append = array();
    foreach ($pengiriman_detail as $key_row => $value_row) {
        $data_append["detail_" . $value_row->no_transaksi][] = $value_row;
    }
    $test = json_encode($data_append);

    // echo "<pre>";
    // print_r($pengiriman_detail);
    // echo "</pre>";
?>
<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= site_url('load/add/pengiriman/pengiriman') ?>">
            <i class="fas fa-plus-circle"></i> Pengiriman Baru</a>
    </div>
</div>
</div>

<div class="card card-outline card-danger">
    <div class="card-body">
        <table id="data-tampil" class="table table-striped" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>No Transaksi</th>
                    <th>Transaksi Referensi</th>
                    <th>Customer</th>
                    <th>Jenis Bayar</th>
                    <th>No. Rekening</th>
                    <th>Divisi</th>
                    <th>Lokasi Asal</th>
                    <th>Lokasi Tujuan</th>
                    <th>Layanan</th>
                    <!-- <th>Diskon</th> -->
                    <!-- <th>Nama Pengirim</th>
                    <th>Nama Penerima</th>
                    <th>Alamat Pengirim</th>
                    <th>Alamat Penerima</th>
                    <th>NO. Tlp Pengirim</th>
                    <th>No. Tlp Penerima</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>status</th>
                    <th>Lama Kredit</th>
                    <th>Diskon</th>
                    <th>Keterangan</th>
                    <th>Lampiran</th>
                    <th>User</th>-->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pengiriman as $key => $value) : ?>

                <tr>
                    <td><button type="button" class="btn btn-info btn-xs data-tampil text-left"
                            data-key="<?= $value->no_transaksi ?>" data-layanan="<?= $value->kd_layanan ?>"
                            data-kota_asal="<?= $value->kd_lokasi_asal ?>"
                            data-kota_tujuan="<?= $value->kd_lokasi_tujuan ?>">
                            <i class="fa fa-eye"></td>
                    <td><?= $value->no_transaksi_reff ?></td>
                    <td><?= $value->customer ?></td>
                    <td><?= $value->jenis_bayar ?></td>
                    <td><?= $value->kas ?></td>
                    <td><?= $value->divisi ?></td>
                    <td><?= $value->asal ?></td>
                    <td><?= $value->tujuan ?></td>
                    <td><?= $value->layanan ?></td>
                    <!-- <td><?= $value->diskon ?></td> -->
                    <!-- <td><?= $value->nama_pengirim ?></td>
                        <td><?= $value->nama_penerima ?></td>
                        <td><?= $value->alamat_pengirim ?></td>
                        <td><?= $value->alamat_penerima ?></td>
                        <td><?= $value->no_hp_pengirim ?></td>
                        <td><?= $value->no_hp_penerima ?></td>
                        <td><?= $value->nomor ?></td>
                        <td><?= $value->tanggal ?></td>
                        <td><?= $value->status ?></td>
                        <td><?= $value->lama_kredit ?></td>
                        <td><?= $value->diskon ?></td>
                        <td><?= $value->keterangan ?></td>
                        <td><?= $value->lampiran ?></td>
                        <td><?= $value->kd_user ?></td> -->

                    <td class="text-center" width="160px">
                        <a href="<?= site_url('load/edit/pengiriman/pengiriman/') . $value->no_transaksi ?>"
                            class="btn btn-warning btn-xs" data-key="<?= $value->no_transaksi ?>"><i
                                class="fa fa-edit"></i></a>
                        <button class="btn btn-xs btn-danger delete" data-key="<?= $value->no_transaksi ?>"> <i
                                class="fa fa-trash"></i></button>



                        <!-- edit modal
                            <button type="button" class="btn btn-warning btn-xs edit-master"
                                data-key="<?= $value->no_transaksi ?>">
                                <i class="fa fa-edit"></i>
                            </button> -->

                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#data-tampil').DataTable();
});
</script>

<script type="text/javascript">
function format(data, layanan, kota_asal, kota_tujuan) {

    let pengiriman_detail = <?= (!empty($test)) ? $test : '' ?>['detail_' + data];
    console.log(pengiriman_detail);
    let content = ``;
    if (pengiriman_detail != "") {
        for (var i = 0; i < pengiriman_detail.length; i++) {
            content += `
                    <tr style="background-color:azure">
                    <td>` + (i + 1) + `</td>
                    <td>` + pengiriman_detail[i]['jenis_kirim'] + `</td>
                    <td>` + pengiriman_detail[i]['panjang'] + `</td>
                    <td>` + pengiriman_detail[i]['lebar'] + `</td>
                    <td>` + pengiriman_detail[i]['tinggi'] + `</td>
                    <td>` + pengiriman_detail[i]['jumlah_berat'] + `</td>
                    <td>` + pengiriman_detail[i]['diskon'] + `</td>
                    <td>` + pengiriman_detail[i]['harga_berat'] + `</td>
                    <td>` + pengiriman_detail[i]['harga_volume'] + `</td>
                    <td>` + pengiriman_detail[i]['harga_koli'] + `</td>
                    <td>` + pengiriman_detail[i]['jumlah_item'] + `</td>
                    <td><button class="btn btn-xs btn-warning" onclick="edit_pengiriman_detail(` +
                pengiriman_detail[i]['nomor'] + `,'` + layanan + `','` + `${kota_asal}','${kota_tujuan}` + `','` +
                pengiriman_detail[i]['kd_jenis'] + `')"><i class="fa fa-edit"></i></button></td></tr>
                    `;
        }
    }
    let html_content = `<div class="slider container-fluid" name>
            <table class="table table-responsive table-condensed" style="opacity:0.9">
            <tr>
            <th>#</th>
            <td>Jenis Kirim</td>
            <td>Panjang</td>
            <td>Lebar</td>
            <td>Tinggi</td>
            <td>Berat</td>
            <td>Diskon</td>
            <td>Harga Berat</td>
            <td>Harga Volume</td>
            <td>Harga Koli</td>
            <td>Jumlah Item</td>
            </tr>
            ` + content + `
            </table>
            </div>`;
    // console.log(html_content);
    return html_content;

}

$("#data-tampil").on('click', '.data-tampil', function() {
    var table = $('#data-tampil').DataTable();
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var layanan = $(this).data('layanan');
    var kota_asal = $(this).data('kota_asal');
    var kota_tujuan = $(this).data('kota_tujuan');

    if (row.child.isShown()) {
        // This row is already open - close it
        $('div.slider', row.child()).slideUp(function() {
            row.child.hide();
            tr.removeClass('shown');
        });
    } else {
        row.child(format($(this).data('key'), layanan, kota_asal, kota_tujuan)).show();
        tr.addClass('shown');
        $('div.slider', row.child()).slideDown();
    }
});
$("#data-tampil").on('click', '.edit-master', function() {
    let key_update = $(this).data('key');
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/edit/pengiriman/pengiriman/` + key_update + `/true`,
        success: function(r) {
            $('#m-crud-title').text('Edit Pengiriman');
            $('#m-crud-key').text(key_update);
            $('#m-crud-act').text('edit');
            $('#m-crud-page').text('pengiriman');
            $('#m-crud-jenis').text('master');
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
        }
    });
    if (row.child.isShown()) {
        // This row is already open - close it
        $('div.slider', row.child()).slideUp(function() {
            row.child.hide();
            tr.removeClass('shown');
        });
    } else {
        row.child(format($(this).data('key'))).show();
        tr.addClass('shown');
    }
});

function edit_pengiriman_detail(key_update, kd_layanan, kd_kota_asal, kd_kota_tujuan, kd_jenis) {
    // console.log(kd_layanan);
    // $.ajax({
    //     type: 'POST',
    //     url: `<?= base_url() ?>/ajax_load/edit/pengiriman_detail/pengiriman/` + key_update + `/true`,
    //     success: function(r) {
    //         alert('ss')
    //         $('#m-crud-title').text('Edit Detail Pengiriman');
    //         $('#m-crud-key').text(key_update);
    //         $('#m-crud-act').text('edit');
    //         $('#m-crud-page').text('pengiriman_detail');
    //         $('#m-crud-jenis').text('master');
    //         $('#m-container-crud').html(r);
    //         $('#modal-crud').modal('show');
    //         $('#hrg_volume').change(function() {
    //             volume();

    //         });

    //     }

    // })

    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/get_min/${kd_kota_asal}/${kd_kota_tujuan}/${kd_jenis}/${kd_layanan}/${key_update}`,
        data: {
            token: 123,
        },
        // dataType: 'JSON',
        success: function(r) {
            $('#m-crud-title').text('Edit Detail Pengiriman');
            $('#m-crud-key').text(key_update);
            $('#m-crud-act').text('edit');
            $('#m-crud-page').text('pengiriman_detail');
            $('#m-crud-jenis').text('master');
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
            $('#hrg_volume').change(function() {
                volume();
            });

        }
    });
};

$('.delete').on('click', function() {
    let key_delete = $(this).data('key');
    Swal.fire({
        title: '?',
        text: "Apakah anda Yakin?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/api/delete/` + key_delete,
                data: `frm_table=pengiriman&token=123`,
                dataType: 'json',
                success: function(r) {
                    // alert(r.status);
                    if (r.status == 200) {
                        tes_sweet('hapus data berhasil');
                        first_load();
                        // first_load();
                    }
                }
            });
        }
    })
});
</script>













<?php
} elseif (isset($act) && $act == "add" && !$modal) {
    // print_r($get_ready_ongkir);
    $kota_asal = array();
    $kota_tujuan = array();
    $layanan = array();
    $jenis_kirim_t = array();
    $jenis_kirim_js = array();
    foreach ($jenis_kirim as $key_row => $value_row) {
        $jenis_kirim_js["detail_" . $value_row->kd_jenis] = $value_row->nama;
    }
    $arr_jenis_kirim = json_encode($jenis_kirim_js);
    // print_r($arr_jenis_kirim);
    foreach ($get_ready_ongkir as $key => $value) {
        $kota_asal[$value->kd_kota_asal] = (object)['kd_lokasi' => $value->kd_kota_asal, "nama" => $value->kota_asal];
        // $m_kota_asal[$value->kd_kota_asal]=;
        $kota_tujuan[$value->kd_kota_tujuan] = (object)['kd_lokasi' => $value->kd_kota_tujuan, "nama" => $value->kota_tujuan];
        $layanan[$value->kd_layanan] = (object)['kd_layanan' => $value->kd_layanan, "nama" => $value->layanan];
        $jenis_kirim_t[$value->kd_jenis] = (object)['kd_jenis' => $value->kd_jenis, "nama" => $value->jenis_kirim];
    }

?>

<div class="card card-outline card-danger">
    <div class="card-body">

        <form class="form-horizontal" id="frm-pengiriman">
            <div class="card-body">
                <div class="tab-content" id="tab-pengirimanContent">
                    <!-- form data pengiriman -->


                    <input type="hidden" name="val_tanggal" class="data" value="<?= date('Y-m-d H:i:s') ?>">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Lokasi asal</label>
                                <input type="text" class="form-control data" name="val_kd_lokasi_asal" id="kota-asal"
                                    placeholder="Area pengirim" required>
                                <!-- <div> -->
                                <div id="kota-asal-list" style="z-index: 999;" class="position-relative"></div>
                                <!-- </div> -->
                                <input type="hidden" id="kd-lokasi_asal" name="val_kd_lokasi_asal">
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
                                    class="form-control data-dt">
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

                                function coba() {
                                    // $('#lama-kredit').prop('readonly', true);
                                    $('#lama-kredit').attr('style', 'display', true);
                                    $('#lbl-lama-kredit').attr('style', 'display', true);
                                    $('#lama-kredit').attr('value', 0);

                                }

                                function coba1() {
                                    // $('#lama-kredit').prop('readonly', false);
                                    // $('#lama-kredit').attr('style', 'display', true);
                                    $('#lama-kredit').attr('style', 'display', false);
                                    $('#lbl-lama-kredit').attr('style', 'display', false);
                                }

                                $(document).ready(function() {
                                    resultberat();
                                    volume();
                                    resultvolume();
                                    resultsubtotal();
                                    total();
                                })
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
                            <div class="form-group">
                                <label class="control-label">KAS</label>
                                <select name="val_kd_kas" id="val_kd_kas" class="form-control data">
                                    <?php foreach ($kas as $k => $value) : ?>
                                    <option value="<?php echo $value->kd_kas; ?>">
                                        <?php echo $value->no_rekening ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Divisi</label>
                                <select name="val_kd_divisi" id="val_kd_divisi" param="val_kd_divisi"
                                    class="form-control data">
                                    <?php foreach ($divisi as $d => $value) : ?>
                                    <option value="<?php echo $value->kd_divisi; ?>">
                                        <?php echo $value->nama ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="val_status" class="col-sm-7 col-form-label">Status</label>
                                <div class="col-sm-6" id="radio-aktif">
                                    <input type='radio' class="form-check-label" name="val_status" onclick="coba()"
                                        value="1" checked>
                                    <label class="form-check-label">Tunai</label>
                                </div>
                                <div class="col-sm-6" id="radio-aktif1">
                                    <input type='radio' name="val_status" onclick="coba1()" value="0">
                                    <label class="form-check-label">Kredit</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jenis Pembayaran</label>
                                <select name="val_kd_jenis_bayar" param="val_kd_jenis_bayar" class="form-control data">
                                    <?php foreach ($jenis_bayar as $cs => $value) : ?>
                                    <option value="<?php echo $value->kd_jenis_bayar; ?>">
                                        <?php echo $value->nama ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-7 col-form-label" style="display: none;">Lama Kredit</label>
                                <input type="text" class="form-control data" style="display: none;" id="lama-kredit"
                                    name="val_lama_kredit" placeholder="Masukkan Lama Kredit" readonly required>
                            </div>
                            <div class="form-group row">
                                <label style="display: none;" class="col-sm-7 col-form-label">Diskon</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input style="display: none;" type="number" min="0"
                                                class="form-control data data-dt" id="val_diskon_t"
                                                oninput="Check(this)" param="val_diskon_t" maxlength="3" max="99"
                                                name="val_diskon" readonly placeholder="Masukkan Diskon"
                                                onkeyup="total()" value="0">
                                        </div>
                                        <div class="col-md-3">
                                            <button style="display: none;" id="persen_master"
                                                class="btn btn-secondary w-80">%</button>
                                        </div>
                                        <div class="col-md-3">
                                            <button style="display: none;" id="rupiah_master"
                                                class="btn btn-secondary w-80">Rp.</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <textarea id="val_keterangan" name="val_keterangan" param="val_keterangan"
                                    style="height:80px" class="form-control data"
                                    placeholder="Masukkan Keterangan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="subject">Lampiran</label>
                                <div class="col pl-0 mb-2">
                                    <div class="img-preview">
                                        <img id="lampiran" src="/assets/dist/img/fa-solid_image.png" class="w-100 p-4">
                                    </div>
                                </div>
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
                            <div class="d-flex align-items-center mb-3">
                                <input type="hidden" class="form-control data" id="val_kd_customer"
                                    name="val_kd_customer">
                                <h3 class="mr-3 mb-0">Data Pengirim</h3>
                                <div>
                                    <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                        id="pengirim">Pilih dari Customer</button>
                                </div>

                            </div>
                            <div class=" form-group row">
                                <label class="col-sm-7 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control data" id="val_nama_pengirim"
                                        param="val_nama_pengirim" name="val_nama_pengirim" placeholder="Nama pengirim"
                                        required>
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
                            <div class="d-flex align-items-center mb-3">
                                <h3 class="mr-3 mb-0">Data Penerima</h3>
                                <div>
                                    <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                        id="penerima">Pilih
                                        dari
                                        Customer</button>
                                </div>

                            </div>
                            <div class=" form-group row">
                                <label class="col-sm-7 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control data" id="val_nama_penerima"
                                        name="val_nama_penerima" param="val_nama_penerima" placeholder="Nama penerima"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-sm-7 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea id="val_alamat_penerima" name="val_alamat_penerima"
                                        param="val_alamat_penerima" class="form-control data"
                                        placeholder="Alamat penerima"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-7 col-form-label">No. Hp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control data" id="val_hp_penerima"
                                        name="val_no_hp_penerima" placeholder="No. HP penerima">
                                </div>
                            </div>


                        </div>

                    </div>

                    <!-- </div> -->
                    <style>
                    .autocomplete_li:hover {
                        background-color: #dc3545;
                    }
                    </style>
                    <script type="text/javascript">
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
                    </script>

                    <hr />
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Jenis Kirim</label>
                                <select id="val-kd-jenis" name="val_kd_jenis" param="val_kd_jenis"
                                    class="form-control data-dt ongkir">
                                    <?php foreach ($jenis_kirim_t as $jk => $value) : ?>
                                    <option class="jenis_krm" value="<?php echo $value->kd_jenis; ?>">
                                        <?php echo $value->nama ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jumlah Item</label>
                                <input type="text" name="val_jumlah_item" id="jumlah-item" param="val_jumlah_item"
                                    class="form-control data-dt" onkeyup="resultsubtotal()"
                                    placeholder="Masukkan Jumlah Berat">
                                <!-- <input type="text" class="data-dt" onkeyup="resultsubtotal()" param="val_harga_koli"
                                        id="harga_koli"> -->
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Koli</label>
                                <!-- <input type="text" id="jumlah-item" param="val_jumlah_item"
                                        class="form-control data-dt" onkeyup="resultsubtotal()"> -->
                                <input type="text" class="form-control data-dt" onkeyup="resultsubtotal()"
                                    name="val_harga_koli" param="val_harga_koli" id="harga_koli" readonly>
                            </div>
                            <input type="hidden" id="jenis_k">
                            <div id="jenis-kirim-container"></div>
                            <script type="text/javascript">
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
                                            $('#label_harga_berat').html("Rp. " + r.harga_berat);
                                            $('#label_min_berat').html("Minimum Berat : " +
                                                r.min_berat);
                                            $('#label_harga_volume').html("Rp. " + r.harga_volume);
                                            $('#label_min_volume').html("Minimum Volume : " +
                                                r.min_volume);
                                            $('#val_harga_berat').val(r.harga_berat);
                                            $('#val_harga_volume').val(r.harga_volume);
                                            $('#min').val(r.min_berat);
                                            $('#min_volum').val(r.min_volume);
                                            $('#harga_koli').val(r.harga_koli);
                                            resultberat();
                                            volume();
                                            resultvolume();
                                            resultsubtotal();
                                            total();

                                        }
                                    });
                                }
                            });

                            $('#butonn').click(function() {
                                $.ajax({
                                    type: 'POST',
                                    url: `<?= base_url() ?>/api/get_customer/`,
                                    data: {
                                        token: 123,
                                        kd_customer: $('#cari').val(),
                                    },
                                    // dataType: 'JSON',
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
                                $.ajax({
                                    type: 'POST',
                                    url: `<?= base_url() ?>/ajax_load/add/pengiriman/pengiriman/-1/true`,
                                    success: function(r) {
                                        $('#m-crud-title-panggil').text(title_modal);
                                        $('#m-customer').text(jenis_modal);
                                        $('#m-container-panggil').html(r);
                                        $('#modal-panggil').modal('show');
                                    }
                                });
                            });
                            </script>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Berat</label>
                                <div class="row align-items-center">
                                    <input type="hidden" class="data-dt" id="val_harga_berat" name="val_harga_berat"
                                        param="val_harga_berat" onkeyup="resultberat()">
                                    <input type="hidden" id="min" onkeyup="resultberat()">

                                    <div class="input-group">
                                        <input type="text" id="val_jumlah_berat" param="val_jumlah_berat"
                                            name="val_jumlah_berat" class="data-dt form-control"
                                            placeholder="Masukkan berat" value="" onkeyup="resultberat()">
                                        <div class="input-group-append">
                                            <span id="label_harga_berat" class="input-group-text"> Rp. </span>
                                        </div>
                                    </div>
                                    <span style="font-size: 14px; color: red;" id="label_min_berat"></span>
                                    <input type="hidden" class="data-dt" id="harga_berat" param="harga_berat"
                                        onkeyup="resultsubtotal()">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dimensi</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control data-dt" id="val_panjang"
                                            param="val_panjang" name="val_panjang" placeholder="Panjang"
                                            onkeyup="volume()">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control data-dt" id="val_lebar" param="val_lebar"
                                            name="val_lebar" placeholder="Lebar" onkeyup="volume()">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control data-dt" id="val_tinggi"
                                            param="val_tinggi" name="val_tinggi" placeholder="Tinggi"
                                            onkeyup="volume()">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Volume</label>
                                <div class="row align-items-center">
                                    <div class="input-group">
                                        <input type="text" class="form-control data-dt" id="hrg_volume"
                                            name="hrg_volume" value="" readonly value="">
                                        <div class="input-group-append">
                                            <span id="label_harga_volume" class="input-group-text"></span>
                                        </div>
                                    </div>
                                    <span style="font-size: 14px; color: red;" id="label_min_volume"></span>
                                    <div>
                                        <!-- <label>hidden</label> -->
                                        <input type="hidden" id="val_harga_volume" param="val_harga_volume"
                                            onkeyup="resultvolume()" class="data-dt" name="val_harga_volume"
                                            onchange="resultvolume()">
                                        <input type="hidden" id="min_volum" onkeyup="resultvolume()">
                                    </div>
                                    <div class="col-md-6">
                                        <label id="label_harga_volume" class="form-label"></label>
                                    </div>
                                    <div>
                                        <!-- <label>hidden</label> -->
                                        <input type="hidden" id="harga_volume" class="data-dt" param="harga_volume"
                                            onkeyup="resultsubtotal()">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Subtotal</label>
                                <input type="text" class="form-control data-dt" id="val_subtotal" param="val_subtotal"
                                    value="" readonly>
                            </div>
                            <div class="form-group">
                                <input type="text" id="discount-val" name="diskon">
                                <label class="form-label">Diskon</label>
                                <div class="input-group">
                                    <input type="number" min="0" maxlength="10" oninput="Check(this)"
                                        class="form-control data-dt" id="diskon" onkeyup="total()" value="0"
                                        param="val_diskon" name="diskon" readonly placeholder="Diskon"
                                        aria-label="Recipient's username with two button addons">
                                    <button class="btn btn-outline-secondary" id="persen" type="button">%</button>
                                    <button class="btn btn-outline-secondary" id="rupiah" type="button">Rp.</button>
                                </div>
                            </div>
                            <script type="text/javascript">
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


                            // detail
                            $('#persen').click(function() {
                                $('#diskon').attr('maxlength', '2');
                                $('#diskon').attr('readonly', false);
                                $('#persen').attr('class', 'btn btn-outline-success')
                                $('#rupiah').attr('class', 'btn btn-outline-secondary')
                                $('#diskon').val('')
                            });
                            $('#rupiah').click(function() {
                                $('#diskon').attr('maxlength', '6');
                                $('#diskon').attr('readonly', false);
                                $('#rupiah').attr('class', 'btn btn-outline-success')
                                $('#persen').attr('class', 'btn btn-outline-secondary')
                                $('#diskon').val('')
                            });
                            $('#diskon').keyup(function() {
                                if ($(this).val() == "") {
                                    $(this).val(0);
                                }
                            });
                            </script>

                            <div class="form-group">
                                <label class="form-label">Total</label>
                                <input type="text" class="form-control data-dt" id="val_total" name="val_total"
                                    param="val_total" value="" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="btn-simpan">
                    <button type="submit" name="simpan" style="display: block; margin: auto; width: 150px;"
                        class="form-control btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
    </div>
</div>
</form>
<!-- <form id="cobaa">
    <button type="submit">test</button>
</form> -->
<script>
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

$('#frm-pengiriman').submit(function(e) {
    e.preventDefault();
    addRow();
    // alert('aaaaa');
    form_data = new FormData($('#frm-pengiriman')[0]);
    form_data.append('token', '123');
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
                location.href = `<?= base_url() ?>/load/view/pengiriman/pengiriman`;
            }
            // print_r($kirim);
        }
    });
});
</script>

<?php
} elseif (isset($act) && $act == 'add' && $modal) {
?>

<?php foreach ($customer as $cs => $value) : ?>
<input type="hidden" value="<?php echo $value->kd_customer ?>" id="customer-id-<?php echo $cs ?>">
<input type="hidden" value="<?php echo $value->nama ?>" id="customer-name-<?php echo $cs ?>">
<input type="hidden" value="<?php echo $value->alamat ?>" id="customer-alamat-<?php echo $cs ?>">
<input type="hidden" value="<?php echo $value->hp ?>" id="customer-hp-<?php echo $cs ?>">
<input type="hidden" value="<?php echo $value->kabupaten ?>" id="customer-kabupaten-<?php echo $cs ?>">

<button type="button" data-id="<?php echo $cs ?>" class="btn btn-sm panggil" id="pilih-customer" data-dismiss="modal"
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
<?php endforeach; ?>
<script type="text/javascript">
$('.panggil').on('click', function() {
    let key = $(this).data('key');
    let page = `<?= $page ?>`;
    let jenis = `<?= $jenis ?>`;
    // let jenis_modal = $(this).attr('id');
    let jenis_modal = $(this).attr('id');
    let title_modal = "";
    let id = $(this).data('id');
    let tujuan = $('#m-customer').text();
    if (tujuan == "pengirim") {
        $('#val_kd_customer').val($("#customer-id-" + id).val());
        $('#val_nama_pengirim').val($("#customer-name-" + id).val());
        $('#val_alamat_pengirim').val($("#customer-alamat-" + id).val());
        $('#val_kabupaten_pengirim').val($("#customer-kabupaten-" + id)
            .val());
        $('#val_hp_pengirim').val($("#customer-hp-" + id).val());
    } else {
        $('#val_kd_customer').val($("#customer-id-" + id).val());
        $('#val_nama_penerima').val($("#customer-name-" + id).val());
        $('#val_alamat_penerima').val($("#customer-alamat-" + id).val());
        $('#val_kabupaten_penerima').val($("#customer-kabupaten-" + id)
            .val());
        $('#val_hp_penerima').val($("#customer-hp-" + id).val());
    }
});
</script>



<?php
} else {
    echo view('errors/html/error_404');
}
?>


</script>








<!-- <script>
const data = [];

const rows = () => {
    let html = '';
    for (let i = 0; i < data.length; i++) {
        html += `< tr >`;
        html += `< td >${i + 1}</td>`
        for (let j = 0; j < data[i].length; j++) {
            html += `< td >${data[i][j]}< /td>`;
        }
        html += `< /tr>`;
    }
    return html;
}

$('#btnSubmit').on('click', function(e) {
    const form = $(this).parent();
    form.on('click', function(e) {
        e.preventDefault()
    });

    form.find('input').val('tes');
    const inner = []
    $('form.form-horizontal :input').each(function(e) {
        if ($(this).val() !== '') {
            inner[e] = $(this).val()
        } else {
            alert('kosong cuy')
        }
    })
    data.push(inner)
    console.log(data);

    $('#table-detail tbody').html(rows());

});
</script> -->