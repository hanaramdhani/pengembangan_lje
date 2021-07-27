<?php
// echo "<pre>";

use PhpParser\Node\Expr\Cast\Array_;

if (isset($act) && $act == "view") {
    $dt_append = array();

    foreach ($manifest_detail as $key_row => $value_row) {
        $dt_append["detail" . $value_row->no_manifest][] = $value_row;
    }
    $dt_detail = json_encode($dt_append);
    // print_r($dt_detail);
    ?>

    <script type="text/javascript">

    </script>
    <?php if ($_SESSION['kd_group']=="1" || $_SESSION['kd_group']==2): ?>    
        <div class="card">
            <div class="card-body">
                <a href="<?= site_url() ?>/load/add/manifest_out/pengiriman" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Buat Manifest Keluar
                </a>
            </div>
        </div>
    <?php endif ?>
    <div class="card card-danger card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark px-3 active" id="manifest-tab" data-toggle="pill" href="#manifest-tab-content" role="tab" aria-controls="manifest-tab-content" aria-selected="true">
                        <i class="fas fa-tasks mr-2"></i> Manifest
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" id="history-manifest-tab" data-toggle="pill"
                    href="#history-manifest-tab-content" role="tab" aria-controls="history-manifest-tab-content"
                    aria-selected="false"><i class="fas fa-history mr-2"></i> History Manifest</a>
                </li>
            </ul>
        </div>
        <div class="card-body" >
            <div class="tab-content" id="">
                <div class="tab-pane fade active show" id="manifest-tab-content" role="tabpanel" aria-labelledby="manifest-tab">
                    <table id="table-manifest" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Referensi</th>
                                <th>Tanggal Berangkat</th>
                                <th>Kendaraan</th>
                                <th>Divisi Asal</th>
                                <th>Divisi Tujuan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($manifest_out_pending as $data => $value) : ?>
                                <tr>

                                    <td class="text-center">
                                        <?= $data + 1 ?>
                                    </td>
                                    <td><?= $value->no_transaksi_reff ?></td>
                                    <td><?= $value->tanggal_berangkat  ?></td>
                                    <td><?= $value->kendaraan ?></td>
                                    <td><?= $value->asal ?></td>
                                    <td><?= $value->tujuan ?></td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-info lihat-data" id="lihat-data"
                                        data-key="<?= $value->no_transaksi ?>"><i class="fas fa-eye"></i></button>
                                        <?php if ($_SESSION['kd_group']=="1" || $_SESSION['kd_group']=="3"): ?>
                                            <a href="<?= site_url('/load/edit/manifest_in/pengiriman/') . $value->no_transaksi ?>" data-key="<?= $value->no_transaksi ?>" class="btn btn-xs btn-secondary">
                                                <i class="fas fa-arrow-down"></i>
                                            </a>    
                                        <?php endif ?>
                                        <?php if ($_SESSION['kd_group']==1): ?>
                                            <button class="btn btn-xs btn-warning edit-manifest" id="edit-modal" data-key="<?= $value->no_transaksi ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-xs btn-danger delete" data-key="<?= $value->no_transaksi ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>    
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="history-manifest-tab-content" role="tabpanel" aria-labelledby="history-manifest-tab">
                    <table id="table-history" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Referensi</th>
                                <th>Tanggal Berangkat</th>
                                <th>Kendaraan</th>
                                <th>Divisi Asal</th>
                                <th>Divisi Tujuan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($manifest_out as $data => $value) : ?>
                                <tr>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-info dtl-histori" id="dtl-histori"
                                        data-key="<?= $value->no_transaksi ?>"><i class="fas fa-eye"></i></button>
                                        <?= $data + 1 ?>
                                    </td>
                                    <td><?= $value->no_transaksi_reff ?></td>
                                    <td><?= $value->tanggal_berangkat  ?></td>
                                    <td><?= $value->kendaraan ?></td>
                                    <td><?= $value->divisi_asal ?></td>
                                    <td><?= $value->divisi_tujuan ?></td>
                                    <td>
                                        <button class="btn btn-xs show-image <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>" data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar" data-src="<?= base_url("/img/manifest/" . $value->lampiran) ?>">
                                            <i class=" fa fa-image"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
        <!-- /.card -->
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-manifest').DataTable();
            $('#table-history').DataTable();
        });
        $('.show-image').click(function() {
            // $('#imagepreview').attr('src', '');
            // $('#imagepreview').removeClass('after-load');
            // $('#imagepreview').addClass('before-load');

            let url = $(this).data('src');
            $('#imagepreview').attr('src', url);
            $('#imagepreview').addClass('after-load');
            $('#imagepreview').removeClass('before-load');
            $('#imagemodal').modal('show');
        });
        function lihat(data) {
            let manifest_detail = <?= (!empty($dt_detail)) ? $dt_detail : '' ?>['detail' + data];
            console.log(manifest_detail);
            let content = ``;
            if (manifest_detail != "") {
                for (var i = 0; i < manifest_detail.length; i++) {
                    content += `
                    <tr style="background-color:azure">
                    <td>` + manifest_detail[i]['nomor_reff'] + `</td>
                    <td>` + manifest_detail[i]['no_pengiriman'] + `</td>
                    <td>` + manifest_detail[i]['deskripsi'] + `</td>

                    </tr>`;
                }
            }
            let html_content = `<div class="slider container-fluid" name>
            <table class="table table-responsive table-condensed" style="opacity:0.9">
            <tr>
            <th> Refferensi </th>
            <th> Nomor Pengiriman </th>
            <th> Deskripsi </th>
            </tr>
            ` + content + `
            </table>
            </div>`;
            return html_content;
        }

        function dtl(data) {
            let dtl_mn = <?= (!empty($manifest_out_pending_detail)) ? $manifest_out_pending_detail : '' ?>['detail_' + data];
            console.log(dtl_mn);
            let content = ``;
            if (dtl_mn != "") {
                for (var i = 0; i < dtl_mn.length; i++) {
                    content += `
                    <tr style="background-color:azure">
                    <td>` + dtl_mn[i]['nomor_reff'] + `</td>
                    <td>` + dtl_mn[i]['no_pengiriman'] + `</td>
                    <td>` + dtl_mn[i]['deskripsi'] + `</td>
                    <td> <button class="btn btn-xs btn-warning edit-detail" id="edit-detail" onClick="edit_detail_manifest(` +
                    dtl_mn[i]['nomor'] + `)" ><i class="fas fa-edit"></i></button>
                    </tr>`;
                }
            }
            let html_content = `<div class="slider container-fluid" name>
            <table class="table table-responsive table-condensed" style="opacity:0.9">
            <tr>
            <th> Nomor Transaksi Referensi </th>
            <th> Nomor Pengriman </th>
            <th> Deskripsi </th>
            </tr>
            ` + content + `
            </table>
            </div>`;
            return html_content;
        }
        $('#table-manifest').on('click', '.lihat-data', function() {
            var tbl = $('#table-manifest').DataTable();
            var tr = $(this).closest('tr');
            var row = tbl.row(tr);

            if (row.child.isShown()) {
                $('div.slider', row.child()).slideUp(function() {
                    row.child.hide();
                    tr.removeClass('shown');
                })
            } else {
                row.child(dtl($(this).data('key'))).show();
                tr.addClass('shown');
                $('div.slider', row.child()).slideDown();
            }

        });

        $('#table-history').on('click', '.dtl-histori', function() {
            var tabel = $('#table-history').DataTable();
            var tr = $(this).closest('tr');
            var row = tabel.row(tr);

            if (row.child.isShown()) {
                $('div.slider', row.child()).slideUp(function() {
                    row.child.hide();
                    tr.removeClass('shown');
                })
            } else {
                row.child(lihat($(this).data('key'))).show();
                tr.addClass('shown');
                $('div.slider', row.child()).slideDown();
            }
        });

        function edit_detail_manifest(key_update) {
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/ajax_load/edit/manifest_detail/pengiriman/` + key_update + `/true`,
                success: function(r) {
                    $('#m-crud-title').text('Edit Detail Manifest');
                    $('#m-crud-key').text(key_update);
                    $('#m-crud-act').text('edit');
                    $('#m-crud-page').text('manifest_detail');
                    $('#m-crud-jenis').text('master');
                    $('#m-container-crud').html(r);
                    $('#modal-crud').modal('show');
                }
            });
        }

        $('#table-manifest').on('click', '.edit-manifest', function() {
            let key_update = $(this).data('key');
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/ajax_load/edit/manifest_out/pengiriman/` + key_update + `/true`,
                success: function(r) {
                    $('#m-crud-title').text('Edit Data Manifest');
                    $('#m-crud-key').text(key_update);
                    $('#m-crud-act').text('edit');
                    $('#m-crud-page').text('manifest');
                    $('#m-crud-jenis').text('master');
                    $('#m-container-crud').html(r);
                    $('#modal-crud').modal('show');
                }
            })
        });

        $('#table-manifest').on('click','.delete', function() {
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
                        data: `frm_table=manifest&token=<?=$_SESSION['token']?>`,
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
    // print_r($_SESSION);
    // echo "<pre>";
    // print_r($data_pengiriman_manifest_out);
    // echo "</pre>";
    ?>

    <br>
    <form id="frm-manifest-out" action="#">
        <div class="row">
            <div class="col">
                <div class="card card-danger card-outline">
                    <div class="card-body" style="padding-bottom: 0.5rem">
                        <div class="tab-content" id="tab-pengirimanContent">
                            <!-- form data pengiriman -->
                            <!-- <input type="hidden" id="val_tanggal" name="val_tanggal" class="data"
                            value="<?= date('Y-m-d H:i:s') ?>">
                            dsr
                            <div class="tab-pane fade active show" id="tab-pengiriman-dsr-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-dsr"> -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class=" form-group row">
                                        <label class="col-sm-4 col-form-label">Kode Referensi</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" name="val_no_transaksi_reff"
                                            value="-" required>
                                        </div>
                                    </div>
                                    <?php 
                                    if ($_SESSION['kd_group']==1) {
                                        ?>
                                        <div class="form-group row">
                                            <label for="subject" class="col-sm-4 col-form-label">Divisi Asal</label>
                                            <div class="col-sm-7">
                                                <select id="val-kd-asal" name="val_kd_asal" class="form-control select2">
                                                    <?php foreach ($divisi as $div => $value) : ?>
                                                        <option value="<?= $value->kd_divisi ?>" <?=($value->kd_divisi==$_SESSION['kd_divisi'])?'selected':'' ?>><?php echo $value->nama ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                        <?php
                                    }else{
                                        ?>
                                        <div class="form-group row">
                                            <label for="subject" class="col-sm-4 col-form-label">Divisi Asal</label>
                                            <div class="col-sm-7">
                                                <input class="form-control" type="text" name="" value="<?=$_SESSION['divisi'] ?>" readonly="">
                                                <input type="hidden" id="val-kd-asal" name="val_kd_asal" value="<?=$_SESSION['kd_divisi'] ?>">
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                    
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Divisi Tujuan</label>
                                        <div class="col-sm-7">
                                            <select name="val_kd_tujuan" id="val_kd_tujuan" class="form-control select2">
                                                <?php foreach ($divisi as $div => $value) : ?>
                                                    <option value="<?php echo $value->kd_divisi ?>"><?php echo $value->nama ?> </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Tanggal
                                        berangkat</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control data" value="<?php echo date("Y-m-d") ?>"
                                            name="val_tanggal_berangkat" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="val_status" class="col-sm-3 col-form-label">Kendaraan</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" placeholder="Masukkan Kendaraan"
                                            name="val_kendaraan" value="-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-3 col-form-label">Kontak</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" placeholder="Masukkan Kontak"
                                            name="val_kontak" value="-" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Keterangan</label>
                                        <div class="col-sm-7">
                                            <textarea name="val_keterangan" class="form-control">-</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Lampiran</label>
                                        <div class="col-sm-7">
                                            <input type="file" name="val_lampiran" class="data">
                                        </div>
                                    </div>
                                    <input type="hidden" name="val_kd_user" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="title col-10">
                        <h3 style="text-align: left;">Detail Pengiriman</h3>
                    </div>
                    <div class="col-2">
                        <button type="button" id="add-modal-coba" style="margin-left: auto;"
                        class="form-control btn btn-success cari-manifest">Tambah</button>
                    </div>
                </div>
                <div class="card card-danger card-outline">
                    <div class="card-body" id="load-pengiriman-container">

                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $(function(){
            load_pengiriman_manifest($('#val-kd-asal').val());
            $('.select2').select2();
        });
        $('#val-kd-asal').change(function(){
            let val=$(this).val();
            load_pengiriman_manifest(val);
        });
        function load_pengiriman_manifest(kd_divisi){
            $('#load-pengiriman-container').html(loading);
            $.ajax({
                type:'POST',
                url:`<?=base_url() ?>/api/get_pengiriman_manifest`,
                data:{token:`<?=$_SESSION['token'] ?>`,divisi:kd_divisi},
                success:function(r){
                    $('#load-pengiriman-container').html(r);
                }
            });
        }
        $('.datepicker').datepicker();
        $('.cari-manifest').click(function() {
            $('#modal-tambah').modal('show');
            cb();
        });
        var detail_manifest_out = [];


        $('#frm-manifest-out').submit(function(e) {
            e.preventDefault();
            let loading_button = `
            <div style="width:50px;margin-left:30%">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span></div>`;
            $('#btn-save').prop('disabled',true);
            $('#btn-save').html(loading_button);
            if (detail_manifest_out.length>0) {
                form_data = new FormData($('#frm-manifest-out')[0]);
                form_data.append('token', `<?=$_SESSION['token'] ?>`);
                form_data.append('frm_table', 'manifest');
                for (var i = 0; i < detail_manifest_out.length; i++) {
                    for (var property in detail_manifest_out[i]) {
                        form_data.append(`detail[${i}][${property}]`, detail_manifest_out[i][property]);
                    }
                }
                $.ajax({
                    type: 'POST',
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
                            tes_sweet(r.message);
                            swal2_confirm(`<?= base_url() ?>/load/view/manifest_out/pengiriman`);
                        }else{
                            $('#btn-save').prop('disabled',false);
                            $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
                        }

                    }
                });    
            }else{
                alert('Tidak Ada Pengiriman yang dipilih')
                $('#btn-save').prop('disabled',false);
                $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
            }
            
        })

        var ambilID = [];
        $('#cariIDPengiriman').click(function(e) {
            let tambahdata = '';

            const loading = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;

            $('#cariIDPengiriman').html(loading);

            let recordrow = $('.cb-child').length;
            $.ajax({
                type: 'post',
                url: `<?= base_url() ?>/api/cek_pengiriman/${$('input[name=val_no_transaksi]').val()}`,
                data: {
                    token: '<?= $_SESSION['token']; ?>'
                },
                dataType: 'json',
                success: function(r) {
                    console.log(r);
                    if (r.status == 200) {
                        $('#cariIDPengiriman').html(`<i class="fas fa-check"></i>`)
                        document.getElementById("modal-btn-1").disabled = false;
                        tambahdata += '<tr class="data-dt-' + (recordrow + 1) +
                        ' selected-dt" data-pengiriman=' + r.no_transaksi + ' data-keterangan="-">'
                        tambahdata +=
                        `<td><input type="checkbox" class="cb-child" value="click_key_${recordrow+1}" data-click="${recordrow+1}"></td>`
                        tambahdata += `<td class="cobaA">` + r.no_transaksi + `</td>`
                        tambahdata += `<td>` + r.jumlah_item + `</td>`
                        tambahdata += `<td>` + r.from_to + `</td>`
                        tambahdata += `<td>` + r.tujuan + `</td>`
                        tambahdata += `<td>` + r.subtotal + `</td>`
                        tambahdata += '</tr>'
                    } else {

                        alert('ID Pengiriman Tidak Ditemukan!')
                        document.getElementById("modal-btn-1").disabled = true;
                        $('#cariIDPengiriman').html(`<i class="fas fa-search"></i>`)
                        document.getElementById("ID").value = "";
                    }
                }
            });
        });

        function cb() {
            ambilID = []
            $('.cobaA').each(function() {
                ambilID.push($(this).text())
            })
            console.log(ambilID);
        }
    </script>
    <?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>

    <input type="hidden" name="key_no_transaksi" value="<?= $edit_data->no_transaksi ?>">
    <div class="row">
        <div class="col-md-10">
            <div class=" form-group row">
                <label class="col-sm-4 col-form-label">Kode Referensi</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control data" name="val_no_transaksi_reff"
                    value="<?= $edit_data->no_transaksi_reff ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="subject" class="col-sm-4 col-form-label">Divisi Asal</label>
                <div class="col-sm-7">
                    <select name="val_kd_asal" class="form-control select2">
                        <?php foreach ($divisi as $div => $value) : ?>
                            <option value="<?php echo $value->kd_divisi ?>" <?= $edit_data->kd_asal == $value->kd_divisi ? 'selected' : '' ?>> <?php echo $value->nama ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="subject" class="col-sm-4 col-form-label">Divisi Tujuan</label>
                <div class="col-sm-7">
                    <select name="val_kd_tujuan" id="val_kd_tujuan" class="form-control select2">
                        <?php foreach ($divisi as $div => $value) : ?>
                            <option value="<?php echo $value->kd_divisi ?>" <?= $edit_data->kd_tujuan == $value->kd_divisi ? 'selected' : '' ?>> <?php echo $value->nama ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="subject" class="col-sm-4 col-form-label">Tanggal
                berangkat</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control data" value="<?= $edit_data->tanggal_berangkat ?>"
                    name="val_tanggal_berangkat" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="val_status" class="col-sm-4 col-form-label">Kendaraan</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="<?= $edit_data->kendaraan ?>"
                    placeholder="Masukkan Kendaraan" name="val_kendaraan" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="subject" class="col-sm-4 col-form-label">Kontak</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="<?= $edit_data->kontak ?>" placeholder="Masukkan Kontak"
                    name="val_kontak" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Keterangan</label>
                <div class="col-sm-7">
                    <textarea name="val_keterangan" class="form-control"><?= $edit_data->keterangan ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Lampiran</label>
                <div class="col-sm-7">
                    <input type="file" name="val_lampiran">
                </div>
            </div>
            <input type="hidden" name="val_kd_user" value="0">
        </div>
    </div>
    <script type="">
       $('.select2').select2();
   </script>
   <?php
} else {
    echo view('errors/html/error_404');
}

?>
<!-- <script type="text/javascript">
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
                    data: `frm_table=manifest&token=<?=$_SESSION['token']?>`,
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
</script> -->