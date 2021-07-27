<?php
// echo "<pre>";
// print_r($manifest_detail);
// echo "</pre>";

// echo "<pre>";
// print_r($manifest_out);
// echo "</pre>";
// print_r($manifest_detail);

// print_r($manifest_out_pending);
// print_r($manifest_out_pending_detail);


use PhpParser\Node\Expr\Cast\Array_;

if (isset($act) && $act == "view") {
    $dt_append = array();

    foreach ($manifest_detail as $key_row => $value_row) {
        $dt_append["detail" . $value_row->no_manifest][] = $value_row;
    }
    $dt_detail = json_encode($dt_append);
?>

<script type="text/javascript">

</script>
<div class="card">
    <div class="card-body">
        <a href="<?= site_url() ?>/load/add/manifest_out/pengiriman" class="btn btn-primary"><i
                class="fas fa-plus-circle"></i> Buat Manifest Keluar</a>
        <a href="<?= site_url() ?>/load/add/manifest_in/pengiriman" class="btn btn-primary"><i
                class="fas fa-plus-circle"></i> Buat Manifest Masuk</a>
    </div>
</div>
<div class="card card-danger card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link text-dark px-3 active" id="manifest-tab" data-toggle="pill"
                    href="#manifest-tab-content" role="tab" aria-controls="manifest-tab-content" aria-selected="true">
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
    <div class="card-body">
        <div class="tab-content" id="">
            <div class="tab-pane fade active show" id="manifest-tab-content" role="tabpanel"
                aria-labelledby="manifest-tab">
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

                            <td class="text-center"><?= $data + 1 ?></td>
                            <td><?= $value->no_transaksi_reff ?></td>
                            <td><?= $value->tanggal_berangkat  ?></td>
                            <td><?= $value->kendaraan ?></td>
                            <td><?= $value->kd_asal ?></td>
                            <td><?= $value->kd_tujuan ?></td>

                            <td class="text-center">
                                <button class="btn btn-xs btn-warning edit-manifest" id="edit-modal"
                                    data-key="<?= $value->no_transaksi ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-xs btn-info lihat-data" id="lihat-data"
                                    data-key="<?= $value->no_transaksi ?>"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-xs btn-danger delete" data-key="<?= $value->no_transaksi ?>"> <i
                                        class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="history-manifest-tab-content" role="tabpanel"
                aria-labelledby="history-manifest-tab">
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

                            <td class="text-center"><?= $data + 1 ?></td>
                            <td><?= $value->no_transaksi_reff ?></td>
                            <td><?= $value->tanggal_berangkat  ?></td>
                            <td><?= $value->kendaraan ?></td>
                            <td><?= $value->kd_asal ?></td>
                            <td><?= $value->kd_tujuan ?></td>

                            <td class="text-center">
                                <button type="button" class="btn btn-xs btn-info dtl-histori" id="dtl-histori"
                                    data-key="<?= $value->no_transaksi ?>"><i class="fas fa-eye"></i></button>
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




function dtl(data) {
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
    <td> <button class="btn btn-xs btn-warning edit-detail" id="edit-detail" onClick="edit_detail_manifest(` +
                manifest_detail[i]['nomor'] + `)" ><i class="fas fa-edit"></i></button>
    </tr>`;
        }
    }
    let html_content = `<div class="slider container-fluid" name>
    <table class="table table-responsive table-condensed" style="opacity:0.9">
        <tr>
            <th> Nomor Pengiriman Referensi </th>
            <th> Nomor Pengiriman </th>
            <th> Deskripsi </th>
        </tr>
        ` + content + `
    </table>
    </div>`;
    return html_content;
}

function lihat(data) {
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
                data: `frm_table=manifest&token=123`,
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
            <div class="card card-danger card-tabs">
                <div class="card-body">
                    <div class="card-body">
                        <!-- <div class="tab-content" id="tab-pengirimanContent"> -->

                        <!-- form data pengiriman -->
                        <!-- <input type="hidden" id="val_tanggal" name="val_tanggal" class="data"
                                value="<?= date('Y-m-d H:i:s') ?>"> -->
                        <!-- dsr -->
                        <!-- <div class="tab-pane fade active show" id="tab-pengiriman-dsr-form" role="tabpanel"
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
                                <div class="form-group row">
                                    <label for="subject" class="col-sm-4 col-form-label">Divisi Asal</label>
                                    <div class="col-sm-7">
                                        <select name="val_kd_asal" class="form-control">
                                            <?php foreach ($divisi as $div => $value) : ?>
                                            <option value="<?php echo $value->kd_divisi ?>">
                                                <?php echo $value->nama ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subject" class="col-sm-4 col-form-label">Divisi Tujuan</label>
                                    <div class="col-sm-7">
                                        <select name="val_kd_tujuan" id="val_kd_tujuan" class="form-control ">
                                            <?php foreach ($divisi as $div => $value) : ?>
                                            <option value="<?php echo $value->kd_divisi ?>">
                                                <?php echo $value->nama ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subject" class="col-sm-4 col-form-label">Tanggal
                                        berangkat</label>
                                    <div class="col-sm-7">
                                        <input type="date" class="form-control data" name="val_tanggal_berangkat"
                                            required>
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label for="subject" class="col-sm-4 col-form-label">Tanggal Sampai</label>
                                    <div class="col-sm-7">
                                        <input type="date" class="form-control" name="val_tanggal_sampai" required>
                                    </div>
                                </div> -->

                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="val_status" class="col-sm-3 col-form-label">Kendaraan</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Kendaraan"
                                            name="val_kendaraan" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="subject" class="col-sm-3 col-form-label">Kontak</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" placeholder="Masukkan Kontak"
                                            name="val_kontak" required>
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
                                        <input type="file" name="val_lampiran" class="form-control data">
                                    </div>
                                </div>
                                <input type="hidden" name="val_kd_user" value="0">
                            </div>
                        </div>
                        <!-- </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="title col-10">
                    <h3 style="text-align: left;">Detail Pengiriman</h3>
                </div>
                <div class="col-2">
                    <button type="button" id="add-modal-coba" style="margin-left: auto;"
                        class="form-control btn btn-success cari-manifest">Tambah</button>
                </div>
            </div>


            <div class="card card-danger card-tabs">

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="table-manifest-out" class="table">
                                <thead class="bg-danger text-center ">
                                    <tr>
                                        <th><input type="checkbox" id="head-cb"></th>
                                        <th>No. Transaksi</th>
                                        <th>Customer</th>
                                        <th>Jenis Bayar</th>
                                        <th>Divisi</th>
                                        <th>Tanggal transaksi</th>
                                        <th>From - To</th>
                                        <th>Tujuan</th>
                                    </tr>
                                </thead>
                                <?php foreach ($data_pengiriman_manifest_out as $data => $value) : ?>
                                <tbody class="bg-azure">
                                    <tr class="text-center data-dt-<?= $data ?> selected-dt details"
                                        data-pengiriman="<?= $value->no_transaksi ?>"
                                        data-tanggal="<?= $value->tanggal ?>">
                                        <td><input type="checkbox" class="child-cb" value="click_key_<?= $data ?>"
                                                data-click="<?= $data ?>"></td>
                                        <td><?= $value->no_transaksi ?></td>
                                        <td><?= $value->customer ?></td>
                                        <td><?= $value->jenis_bayar ?></td>
                                        <td><?= $value->divisi ?></td>
                                        <td><?= $value->tanggal ?></td>
                                        <td><?= $value->from_to ?></td>
                                        <td><?= $value->tujuan ?></td>

                                    </tr>
                                </tbody>
                                <?php endforeach; ?>
                            </table>
                            <div class="card-footer text-center">
                                <button type="submit" name="btn_submit" value="Simpan" class="btn btn-primary"><i
                                        class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<script type="text/javascript">
$('.cari-manifest').click(function() {
    $('#modal-tambah').modal('show');
    cb();



});



var detail_manifest_out = [];
$(document).ready(function() {
    first_load()
    get_menifest_out_detail()
});

function first_load() {
    $('#table-manifest-out').DataTable();
    $('#head-cb').prop('checked', true)
    $('.child-cb').prop('checked', true)
    get_menifest_out_detail();
}
$('#head-cb').click(function() {
    if ($('#head-cb').prop('checked') == true) {
        console.log('aktif')
        // $('#head-cb').prop('checked', true)
        $('.child-cb').prop('checked', true)
        $('.details').addClass('selected-dt')
    } else {
        // $('#head-cb').prop('checked', false)
        $('.child-cb').prop('checked', false)
        $('.details').removeClass('selected-dt')

    }

    get_menifest_out_detail();
});
$('#table-manifest-out').on('click', '.child-cb', function() {
    console.log('klik');
    let key = $(this).data('click');
    if ($(this).prop('checked') != true) {
        $('#head-cb').prop('checked', false)
        $('.data-dt-' + key).removeClass('selected-dt');
    } else {
        $('.data-dt-' + key).addClass('selected-dt');
        let child = $('.child-cb').length;
        let selected_dt = $('.selected-dt').lenght;
        if (child === selected_dt) {
            $('#head-cb').prop('checked', true);
        }
    }
    get_menifest_out_detail();
})

function get_menifest_out_detail() {
    detail_manifest_out = [];
    var object = {};
    $('.selected-dt').each(function() {
        object = {};
        object['val_no_pengiriman'] = $(this).data('pengiriman');
        object['val_tanggal_terima'] = $(this).data('tanggal');
        detail_manifest_out.push(object);
    });
    console.log(detail_manifest_out);
}

$('#frm-manifest-out').submit(function(e) {
    e.preventDefault();
    form_data = new FormData($('#frm-manifest-out')[0]);
    form_data.append('token', '123');
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
                tes_sweet('Data Berhasil Disimpan');
                location.href = `<?= base_url() ?>/load/add/manifest_out/pengiriman`;
                location.reload();
            }
        }
    });
})

let tambahdata = '';
var ambilID = [];
$('#cariIDPengiriman').click(function(e) {
    // alert('berhasil');
    const loading = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;

    $('#cariIDPengiriman').html(loading);

    let recordrow = $('.cb-child').length;
    // alert(recordrow);
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

                // alert('data ditemukan');
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
                //    alert(tambahdata);

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
                <select name="val_kd_asal" class="form-control">
                    <?php foreach ($divisi as $div => $value) : ?>
                    <option value="<?php echo $value->kd_divisi ?>"
                        <?= $edit_data->kd_asal == $value->kd_divisi ? 'selected' : '' ?>>
                        <?php echo $value->nama ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="subject" class="col-sm-4 col-form-label">Divisi Tujuan</label>
            <div class="col-sm-7">
                <select name="val_kd_tujuan" id="val_kd_tujuan" class="form-control ">
                    <?php foreach ($divisi as $div => $value) : ?>
                    <option value="<?php echo $value->kd_divisi ?>"
                        <?= $edit_data->kd_tujuan == $value->kd_divisi ? 'selected' : '' ?>>
                        <?php echo $value->nama ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="subject" class="col-sm-4 col-form-label">Tanggal
                berangkat</label>
            <div class="col-sm-7">
                <input type="text" class="form-control data" value="<?= $edit_data->tanggal_berangkat ?>"
                    name="val_tanggal_berangkat" readonly required>
            </div>
        </div>
        <div class="form-group row">
            <label for="subject" class="col-sm-4 col-form-label">Tanggal Sampai</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" value="<?= $edit_data->tanggal_sampai ?>"
                    name="val_tanggal_sampai" readonly required>
            </div>
        </div>

        <!-- </div>
    <div class="col-md-6"> -->
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
                <input type="file" name="val_lampiran" required>
            </div>
        </div>
        <input type="hidden" name="val_kd_user" value="0">
    </div>
</div>



<?php
} else {
    echo view('errors/html/error_404');
}

?>


<script type="text/javascript">
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
                data: `frm_table=manifest&token=123`,
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