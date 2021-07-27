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
?>
<div class="card card-outline card-danger">
    <div class="card-body">
        <div class="card-header">
            <a class="btn btn-primary" style="padding-top: 10px; padding-bottom: 10px;"
                href="<?= site_url('load/add/pengiriman/pengiriman') ?>">
                <i class="fas fa-plus-circle"></i> Tambah</a>
        </div>
        <table id="data-tampil" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>Transaksi Referensi</th>
                    <th>Customer</th>
                    <th>Jenis Bayar</th>
                    <th>No. Rekening</th>
                    <th>Divisi</th>
                    <th>Lokasi Asal</th>
                    <th>Lokasi Tujuan</th>
                    <th>Layanan</th>
                    <th>Diskon</th>
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
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pengiriman as $key => $value) : ?>

                <tr>
                    <td><?= $value->no_transaksi ?></td>
                    <td><?= $value->no_transaksi_reff ?></td>
                    <td><?= $value->customer ?></td>
                    <td><?= $value->jenis_bayar ?></td>
                    <td><?= $value->kas ?></td>
                    <td><?= $value->divisi ?></td>
                    <td><?= $value->asal ?></td>
                    <td><?= $value->tujuan ?></td>
                    <td><?= $value->layanan ?></td>
                    <td><?= $value->diskon ?></td>
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
                            class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-default btn-xs data-tampil"
                            data-key="<?= $value->no_transaksi ?>" data-layanan="<?= $value->kd_layanan ?>"
                            data-kota_asal="<?= $value->kd_lokasi_asal ?>"
                            data-kota_tujuan="<?= $value->kd_lokasi_tujuan ?>">
                            <i class="fa fa-eye"></i>
                        </button>
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
<td>Aksi<td>
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

}


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
    $kota_asal = [];
    $kota_tujuan = [];
    $layanan = [];
    $jenis_kirim_t = [];
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
                        <input type="hidden" id="val_tanggal" name="val_tanggal" class="data"
                            value="<?= date('Y-m-d H:i:s') ?>">
                        <!-- dsr -->

                        <div class="tab-pane fade active show" id="tab-pengiriman-dsr-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-dsr">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class=" form-group row">
                                        <label class="col-sm-3 col-form-label">Kode Referensi</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_no_transaksi_reff"
                                                name="val_no_transaksi_reff" value="-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">KAS</label>
                                        <div class="col-sm-7">
                                            <select name="val_kd_kas" id="val_kd_kas" class="form-control data">
                                                <?php foreach ($kas as $k => $value) : ?>
                                                <option value="<?php echo $value->kd_kas; ?>">
                                                    <?php echo $value->no_rekening ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Divisi</label>
                                        <div class="col-sm-7">
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
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Keterangan</label>
                                        <div class="col-sm-7">
                                            <textarea id="val_keterangan" name="val_keterangan" param="val_keterangan"
                                                style="height:80px" class="form-control data"
                                                placeholder="Masukkan Keterangan"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Lampiran</label>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <img id="lampiran" src="" style=" width: 100px; height:100px;">
                                            </div>
                                            <div class="row mt-2">
                                                <input type="file" name="val_lampiran" id="val_lampiran"
                                                    param="val_lampiran" class="data" onchange="addlamp()">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                    function addlamp() {
                                        let frame = document.getElementById('lampiran');
                                        frame.src = URL.createObjectURL(event.target.files[0]);
                                    }
                                    </script>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="val_status" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-3" id="radio-aktif">
                                            <p><input type='radio' name="val_status" onclick="coba()" value='1'
                                                    class="data" checked />
                                                Tunai</p>
                                        </div>
                                        <div class="col-sm-3" id="radio-aktif1">
                                            <p><input type='radio' name="val_status" onclick="coba1()" value='0'
                                                    class="data" />
                                                Kredit</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Jenis
                                            Pembayaran</label>
                                        <div class="col-sm-7">
                                            <select name="val_kd_jenis_bayar" param="val_kd_jenis_bayar"
                                                class="form-control data">
                                                <?php foreach ($jenis_bayar as $cs => $value) : ?>
                                                <option value="<?php echo $value->kd_jenis_bayar; ?>">
                                                    <?php echo $value->nama ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Lama Kredit</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="lama-kredit"
                                                name="val_lama_kredit" placeholder="Masukkan Lama Kredit" readonly
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Diskon</label>
                                        <div class="col-sm-7">
                                            <input type="number" min="0" class="form-control data data-dt"
                                                id="val_diskon_t" oninput="Check(this)" param="val_diskon_t"
                                                maxlength="3" max="99" name="val_diskon" placeholder="Masukkan Diskon"
                                                onkeyup="total()" value="0">
                                        </div>
                                    </div>
                                    <!-- <script type="text/javascript"> -->

                                    <!-- </script> -->

                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Jenis Layanan</label>
                                        <div class="col-sm-7">
                                            <select name="val_kd_layanan" id="layanan" param="val_kd_layanan"
                                                class="form-control data-dt">
                                                <?php foreach ($layanan as $ly => $value) : ?>
                                                <option value="<?php echo $value->kd_layanan; ?>">
                                                    <?php echo $value->nama ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>

                                        <!-- mengambil kd_layanan -->
                                        <input type="hidden" id="lyn">
                                        <script type="text/javascript">
                                        $('#layanan').click(function() {
                                            document.getElementById('lyn').value = document.getElementById(
                                                'layanan').value;
                                        });


                                        // $('#radio-aktif').on('click', function() {
                                        //     $('#lama-kredit').prop('disabled', true);
                                        // });
                                        // $('#radio-aktif1').on('click', function() {
                                        //     $('#lama-kredit').prop('disabled', false);
                                        // });


                                        function coba() {
                                            $('#lama-kredit').prop('readonly', true);
                                        }

                                        function coba1() {
                                            $('#lama-kredit').prop('readonly', false);
                                        }
                                        </script>

                                    </div>

                                </div>
                            </div>
                        </div>



                        <!-- pengirim dan penerima -->
                        <div class="tab-pane fade" id="tab-pengiriman-dasar-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-dasar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <h3 class="mr-3 mb-0">Data Pengirim</h3>
                                        <div>
                                            <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                                id="pengirim">Pilih dari
                                                Customer</button>
                                        </div>

                                    </div>
                                    <input type="hidden" class="form-control data" id="val_kd_customer"
                                        name="val_kd_customer" param="val_kd_customer" required>
                                    <div class=" form-group row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_nama_pengirim"
                                                param="val_nama_pengirim" name="val_nama_pengirim"
                                                placeholder="Nama pengirim" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <textarea id="val_alamat_pengirim" name="val_alamat_pengirim"
                                                param="val_alamat_pengirim" style="height:80px"
                                                class="form-control data" placeholder="Alamat pengirim"></textarea>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">No. Hp</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_hp_pengirim"
                                                name="val_no_hp_pengirim" placeholder="No. HP pengirim">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" name="val_kd_lokasi_asal"
                                                id="kota-asal" placeholder="Area pengirim" required>
                                            <div id="kota-asal-list" class="position-relative"></div>
                                            <input type="hidden" id="kd-lokasi_asal" name="val_kd_lokasi_asal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <h3 class="mr-3 mb-0">Data Penerima</h3>
                                        <div>
                                            <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                                id="penerima">Pilih dari
                                                Customer</button>
                                        </div>

                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_nama_penerima"
                                                name="val_nama_penerima" param="val_nama_penerima"
                                                placeholder="Nama penerima" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <textarea id="val_alamat_penerima" name="val_alamat_penerima"
                                                param="val_alamat_penerima" style="height:80px"
                                                class="form-control data" placeholder="Alamat penerima"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">No. Hp</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_hp_penerima"
                                                name="val_no_hp_penerima" placeholder="No. HP penerima">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="kota-tujuan"
                                                name="val_kd_lokasi_tujuan" placeholder="Area penerima" required>
                                            <div id="kota-tujuan-list" class="position-relative"></div>
                                            <input type="hidden" id="kd-lokasi_tujuan" name="val_kd_lokasi_tujuan">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <style>
                        .autocomplete_li:hover {
                            background-color: #7FFFD4;
                        }
                        </style>
                        <script type="text/javascript">
                        $('#val_diskon_t').keyup(function() {
                            if ($(this).val() == "") {
                                $(this).val(0);

                            }
                        });
                        $('#diskon').keyup(function() {
                            if ($(this).val() == "") {
                                $(this).val(0);
                            }
                        });
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
                        <!-- ./form data pengirim dan penerima -->

                        <!-- informasi paket -->
                        <div class="tab-pane fade" id="tab-pengiriman-paket-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-paket">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kirim</label>
                                        <select name="val_kd_jenis" id="val-kd-jenis" param="val_kd_jenis"
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
                                        <input type="text" id="jumlah-item" param="val_jumlah_item"
                                            class="form-control data-dt" onkeyup="resultsubtotal()">
                                        <input type="text" class="data-dt" onkeyup="resultsubtotal()"
                                            param="val_harga_koli" id="harga_koli">
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
                                                    $('#label_harga_berat').html("Rp. " + r
                                                        .harga_berat + " x " + r.min_berat);
                                                    $('#label_harga_volume').html("Rp. " + r
                                                        .harga_volume + " x " + r.min_volume
                                                    );
                                                    $('#val_harga_berat').val(r.harga_berat);
                                                    $('#val_harga_volume').val(r.harga_volume);
                                                    $('#min').val(r.min_berat);
                                                    $('#min_volum').val(r.min_volume);
                                                    $('#harga_koli').val(r.harga_koli);
                                                }
                                            });
                                        }
                                    });
                                    </script>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Berat</label>
                                        <div class="row align-items-center">
                                            <input type="text" class="data-dt" id="val_harga_berat"
                                                param="val_harga_berat" onkeyup="resultberat()">
                                            <input type="text" id="min" onkeyup="resultberat()">
                                            <!-- <div class="row"> -->
                                            <div class="col-md-6">
                                                <input type="text" id="val_jumlah_berat" param="val_jumlah_berat"
                                                    class="data-dt form-control" placeholder="Masukkan berat" value=""
                                                    required onkeyup="resultberat()">
                                            </div>
                                            <div class="col-md-6">
                                                <label id="label_harga_berat" class="form-label"></label>
                                            </div>

                                            <!-- </div> -->
                                            <div>
                                                <!-- <label>hidden</label> -->
                                                <input type="text" class="data-dt" id="harga_berat" param="harga_berat"
                                                    onkeyup="resultsubtotal()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Dimensi</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control data-dt" id="val_panjang"
                                                    param="val_panjang" name="val_panjang" placeholder="Panjang"
                                                    onkeyup="volume()" value="">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control data-dt" id="val_lebar"
                                                    param="val_lebar" name="val_lebar" placeholder="Lebar"
                                                    onkeyup="volume()" value="">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control data-dt" id="val_tinggi"
                                                    param="val_tinggi" name="val_tinggi" placeholder="Tinggi"
                                                    onkeyup="volume()" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Volume</label>
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control data-dt" id="hrg_volume"
                                                    param="hrg_volume" value="" readonly value="">
                                            </div>
                                            <div>
                                                <!-- <label>hidden</label> -->
                                                <input type="text" id="val_harga_volume" param="val_harga_volume"
                                                    onkeyup="resultvolume()" class="data-dt" onchange="resultvolume()">
                                                <input type="text" id="min_volum" onkeyup="resultvolume()">
                                            </div>
                                            <div class="col-md-6">
                                                <label id="label_harga_volume" class="form-label"></label>
                                            </div>
                                            <div>
                                                <!-- <label>hidden</label> -->
                                                <input type="text" id="harga_volume" class="data-dt"
                                                    param="harga_volume" onkeyup="resultsubtotal()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" class="form-control data-dt" id="val_subtotal"
                                            param="val_subtotal" value="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Diskon</label>
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <input type="number" min="0" max="99" maxlength="3"
                                                    oninput="Check(this)" class="form-control data-dt" id="diskon"
                                                    onkeyup="total()" param="val_diskon" placeholder="diskon(%)"
                                                    value="0">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">%</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Total</label>
                                        <input type="text" class="form-control data-dt" id="val_total" name="val_total"
                                            param="val_total" value="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-5">
                                <button type="button" class="btn btn-success" name="tambah" data-row="-1"
                                    data-aksi="tambah" id="add-detail"><i class="fas fa-plus-circle"></i> Tambah
                                    Detail</button>
                            </div>

                        </div>
                    </div>

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
                            <div class="btn-simpan form-control">
                                <button type="submit" id="send-ajax-array-js"
                                    style="display: block; margin: auto; width: 200px;" name="simpan"
                                    class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <script type="text/javascript">
            // $('#table-detail').DataTable();
            $('#val_diskon').keyup(function() {
                if ($(this).val() == "") {
                    $(this).val(0);
                }
            });

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
                $('#val_panjang').val('');
                $('#val_jumlah_berat').val('');
                $('#val_lebar').val('');
                $('#val_tinggi').val('');
                $('#hrg_volume').val('');
                $('#val_subtotal').val('');
                $('#diskon').val('');
                $('#val_total').val('');
                $('#jumlah-item').val('');
                // $('#val_harga_koli').val('');




                // document.getElementById('val_panjang').value = " ";
                // document.getElementById('val_jumlah_berat').value = " ";
                // document.getElementById('val_lebar').value = " ";
                // document.getElementById('val_tinggi').value = " ";
                // document.getElementById('hrg_volume').value = " ";
                // document.getElementById('diskon').value = " ";
                // document.getElementById('val_total').value = " ";


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
                        `)"><i class=" fas fa-trash"></i></button></td>`;
                    data_dtl += `</tr>`;
                }
                let table_template = data_dtl;
                $('#table-container').html(table_template);
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

            $('#frm-pengiriman').submit(function(e) {
                e.preventDefault();
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
                            tes_sweet('simpan data berhasil');
                            location.href = `<?= base_url() ?>/load/view/pengiriman/pengiriman`;
                        }
                        // print_r($kirim);
                    }
                });
            });
            </script>
        </div>

    </div>
</div>



<script>
$(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

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
    style="border: solid darkgray 1px; height: 90px; width: 100%; margin-top: 10px;">
    <!-- <img src="" alt=""> -->
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
    <!-- <li style=" padding: 1px;"><?php echo $value->lampiran ?></li> -->

</button>
<?php endforeach; ?>


<?php
    // print_r($pengiriman);
} elseif (isset($act) && $act == "edit" && !$modal) {
    $kota_asal = [];
    $kota_tujuan = [];
    $layanan = [];
    $jenis_kirim_t = [];

    foreach ($get_ready_ongkir as $key => $value) {
        $kota_asal[$value->kd_kota_asal] = (object)['kd_lokasi' => $value->kd_kota_asal, "nama" => $value->kota_asal];
        // $m_kota_asal[$value->kd_kota_asal]=;
        $kota_tujuan[$value->kd_kota_tujuan] = (object)['kd_lokasi' => $value->kd_kota_tujuan, "nama" => $value->kota_tujuan];
        $layanan[$value->kd_layanan] = (object)['kd_layanan' => $value->kd_layanan, "nama" => $value->layanan];
        $jenis_kirim_t[$value->kd_jenis] = (object)['kd_jenis' => $value->kd_jenis, "nama" => $value->jenis_kirim];
    }
?>
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
                </ul>
            </div>
            <form class="form-horizontal" id="frm-pengiriman-edit">
                <div class="card-body">
                    <div class="tab-content" id="tab-pengirimanContent">
                        <!-- form data pengiriman -->
                        <input type="hidden" id="val_tanggal" name="val_tanggal" class="data"
                            value="<?= date('Y-m-d H:i:s') ?>">
                        <!-- dsr -->

                        <div class="tab-pane fade active show" id="tab-pengiriman-dsr-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-dsr">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" value="<?= $edit_data->no_transaksi ?>" id="key-update"
                                        name="key_no_transaksi" readonly>
                                    <input type="hidden" id="val_tanggal" name="val_tanggal" class="data"
                                        value="<?= $edit_data->tanggal ?>" readonly>
                                    <div class=" form-group row">
                                        <label class="col-sm-3 col-form-label">Kode Referensi</label>
                                        <div class="col-sm-7">
                                            <input type="text" value="<?= $edit_data->no_transaksi_reff ?>"
                                                class="form-control data" id="val_no_transaksi_reff"
                                                name="val_no_transaksi_reff" value="-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">KAS</label>
                                        <div class="col-sm-7">
                                            <select name="val_kd_kas" id="val_kd_kas" class="form-control">
                                                <?php foreach ($kas as $k => $value) : ?>
                                                <option value="<?php echo $value->kd_kas; ?>"
                                                    <?= $edit_data->kd_kas == $value->kd_kas ? 'selected' : '' ?>>
                                                    <?php echo $value->no_rekening ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Divisi</label>
                                        <div class="col-sm-7">
                                            <select name="val_kd_divisi" id="val_kd_divisi" param="val_kd_divisi"
                                                class="form-control data">
                                                <?php foreach ($divisi as $d => $value) : ?>
                                                <option value="<?php echo $value->kd_divisi ?>"
                                                    <?= $edit_data->kd_divisi == $value->kd_divisi ? 'selected' : '' ?>>
                                                    <?php echo $value->nama ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Keterangan</label>
                                        <div class="col-sm-7">
                                            <textarea id="val_keterangan" name="val_keterangan" param="val_keterangan"
                                                style="height:80px" class="form-control data"
                                                placeholder="Masukkan Keterangan"><?= $edit_data->keterangan ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Lampiran</label>
                                        <div class="col-sm-7">
                                            <div class="row">
                                                <img id="lampiran" src="" style=" width: 100px; height:100px;">
                                            </div>
                                            <div class="row mt-2">
                                                <input type="file" name="val_lampiran" id="val_lampiran"
                                                    param="val_lampiran" class="data" onchange="addlamp()">
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                    function addlamp() {
                                        let frame = document.getElementById('lampiran');
                                        frame.src = URL.createObjectURL(event.target.files[0]);
                                    }
                                    </script>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="val_status" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-3" id="radio-aktif">
                                            <p><input type='radio' name="val_status" value='1'
                                                    <?= $edit_data->status == '1' ? 'checked' : ''  ?> class="data" />
                                                Aktif</p>
                                        </div>
                                        <div class="col-sm-3" id="radio-aktif1">
                                            <p><input type='radio' name="val_status" value='0'
                                                    <?= $edit_data->status == '0' ? 'checked' : ''  ?> class="data" />
                                                Non-Akif</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Jenis
                                            Pembayaran</label>
                                        <div class="col-sm-7">
                                            <select name="val_kd_jenis_bayar" param="val_kd_jenis_bayar"
                                                class="form-control data">
                                                <?php foreach ($jenis_bayar as $cs => $value) : ?>
                                                <option value="<?php echo $value->kd_jenis_bayar ?>"
                                                    <?= $edit_data->kd_jenis_bayar == $value->kd_jenis_bayar ? 'selected' : '' ?>>
                                                    <?php echo $value->nama ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Lama Kredit</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_lama_kredit"
                                                name="val_lama_kredit" value="<?= $edit_data->lama_kredit ?>"
                                                placeholder="Masukkan lama kredit" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Diskon</label>
                                        <div class="col-sm-7">
                                            <input type="number" min="0" class="form-control data data-dt"
                                                id="val_diskon_t" param="val_diskon_t" name="val_diskon"
                                                placeholder="Masukkan Diskon" value="<?= $edit_data->diskon ?>"
                                                onkeyup="total()" value="">
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <input type="text" class="form-control data-dt" id="diskon"
                                                onkeyup="total()" param="diskon" placeholder="diskon(%)" value="">
                                            </div> -->
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Jenis Layanan</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_kd_layanan"
                                                name="val_kd_layanan" value="<?= $edit_data->kd_layanan ?>" required>

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
                                    <div class="d-flex align-items-center mb-3">
                                        <h3 class="mr-3 mb-0">Data Pengirim</h3>
                                        <div>
                                            <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                                id="pengirim">Pilih dari
                                                Customer</button>
                                        </div>

                                    </div>
                                    <input type="hidden" class="form-control data" id="val_kd_customer"
                                        name="val_kd_customer" param="val_kd_customer"
                                        value="<?= $edit_data->kd_customer ?>" required>
                                    <input type="hidden" class="form-control data" id="val_kd_customer"
                                        name="val_kd_customer" param="val_kd_customer" required>
                                    <div class=" form-group row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data"
                                                value="<?= $edit_data->nama_pengirim ?>" id="val_nama_pengirim"
                                                param="val_nama_pengirim" name="val_nama_pengirim"
                                                placeholder="Nama pengirim" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <textarea id="val_alamat_pengirim" name="val_alamat_pengirim"
                                                param="val_alamat_pengirim" style="height:80px"
                                                class="form-control data"
                                                placeholder="Alamat pengirim"><?= $edit_data->alamat_pengirim ?></textarea>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">No. Hp</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_hp_pengirim"
                                                name="val_no_hp_pengirim" value="<?= $edit_data->no_hp_pengirim ?>"
                                                placeholder="No. HP pengirim">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" name="val_kd_lokasi_asal"
                                                id="kota-asal" placeholder="Area pengirim" required>
                                            <div id="kota-asal-list" class="position-relative"></div>
                                            <input type="hidden" id="kd-lokasi_asal" name="val_kd_lokasi_asal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-3">
                                        <h3 class="mr-3 mb-0">Data Penerima</h3>
                                        <div>
                                            <button type="button" class="btn btn-outline-success btn-xs call-modal"
                                                id="penerima">Pilih dari
                                                Customer</button>
                                        </div>

                                    </div>
                                    <div class=" form-group row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_nama_penerima"
                                                name="val_nama_penerima" param="val_nama_penerima"
                                                placeholder="Nama penerima" value="<?= $edit_data->nama_penerima ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Alamat</label>
                                        <div class="col-sm-7">
                                            <textarea id="val_alamat_penerima" name="val_alamat_penerima"
                                                param="val_alamat_penerima" style="height:80px"
                                                class="form-control data"
                                                placeholder="Alamat penerima"><?= $edit_data->alamat_penerima ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">No. Hp</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val_hp_penerima"
                                                name="val_no_hp_penerima" value="<?= $edit_data->no_hp_penerima ?>"
                                                placeholder="No. HP penerima">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Area</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="kota-tujuan"
                                                name="val_kd_lokasi_tujuan" placeholder="Area penerima" required>
                                            <div id="kota-tujuan-list" class="position-relative"></div>
                                            <input type="hidden" id="kd-lokasi_tujuan" name="val_kd_lokasi_tujuan">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <style>
                        .autocomplete_li:hover {
                            background-color: #7FFFD4;
                        }
                        </style>
                        <script type="text/javascript">
                        $('#diskon').keyup(function() {
                            if ($(this).val() == "") {
                                $(this).val(0);
                            }
                        });
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
                        <!-- ./form data pengirim dan penerima -->
                    </div>
                </div>
            </form>

            <script>
            $('#frm-pengiriman-edit').submit(function(e) {
                e.preventDefault();
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
                            tes_sweet('simpan data berhasil');
                            location.href = `<?= base_url() ?>/load/view/pengiriman/pengiriman`;
                        }
                        // print_r($kirim);
                    }
                });
            });
            </script>
        </div>
        <!-- ./informasi paket -->
    </div>
</div>


<script type="text/javascript">
$('#frm-pengiriman-edit-').submit(function(e) {
    e.preventDefault();
    form_data = new FormData($('#frm-pengiriman-edit-')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'pengiriman');
    key = $('#key-update').val();
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/update/${key}/execute`,
        data: form_data,
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(r) {
            console.log(r);
            if (r.status == 200) {
                alert('success');
                location.href = `<?= base_url() ?>/load/view/pengiriman/pengiriman`;
            } else {
                alert('gagal');
            }
        }
    });
})
</script>

<?php
} else {
    echo view('errors/html/error_404');
}
?>

<script type="text/javascript">
$('.call-modal').click(function() {
    let key = $(this).data('key');
    let page = `<?= $page ?>`;
    let jenis = `pengiriman`;
    let jenis_modal = $(this).attr('id');
    let act = "add";
    let title_modal = "";
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}/` + key + '/true',
        success: function(r) {
            $('#m-crud-title-panggil').text(title_modal);
            $('#m-customer').text(jenis_modal);
            $('#m-container-panggil').html(r);
            $('#modal-panggil').modal('show');
        }
    });
});
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
        $('#val_kabupaten_pengirim').val($("#customer-kabupaten-" + id).val());
        $('#val_hp_pengirim').val($("#customer-hp-" + id).val());
    } else {
        $('#val_kd_customer').val($("#customer-id-" + id).val());
        $('#val_nama_penerima').val($("#customer-name-" + id).val());
        $('#val_alamat_penerima').val($("#customer-alamat-" + id).val());
        $('#val_kabupaten_penerima').val($("#customer-kabupaten-" + id).val());
        $('#val_hp_penerima').val($("#customer-hp-" + id).val());
    }
});
</script>

<script>

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