<?php
date_default_timezone_set('Asia/Jakarta');
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= site_url('load/add/tpendapatan/other') ?>"><i
                class="fas fa-plus-circle"></i>
            Tambah Pendapatan</a>
    </div>
</div>
<div class="card card-danger card-outline">
    <div class="card-body">
        <table id="table-pendapatan" class="table table-striped table-bordered">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>#</th>
                    <th>NO. TRANSAKSI</th>
                    <th>JENIS PENDAPATAN</th>
                    <th>KAS</th>
                    <th>TANGGAL</th>
                    <th>NOMINAL</th>
                    <th>KETERANGAN</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tpendapatan as $key => $value) : ?>
                <tr>
                    <td class="text-center"><?= ($key + 1) ?></td>
                    <td class="text-center"><?= $value->no_transaksi ?></td>
                    <td><?= $value->pendapatan ?></td>
                    <td><?= $value->kas ?></td>
                    <td><?= $value->tanggal ?></td>
                    <td class="text-right"><?= $value->nominal ?></td>
                    <td><?= $value->keterangan ?></td>

                    <td class="text-center">
                        <a class="btn btn-xs btn-warning"
                            href="<?= site_url('load/edit/tpendapatan/other/') . $value->no_transaksi ?>">
                            <i class="fas fa-edit" aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete" data-key="<?= $value->no_transaksi ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button
                            class="btn btn-xs show-image <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>"
                            data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar"
                            data-src="<?= base_url("/img/$page/" . $value->lampiran) ?>">
                            <i class=" fa fa-image"></i>
                        </button>


                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#table-pendapatan').DataTable();
});
$('.show-image').click(function() {
    let url = $(this).data('src');
    $('#imagepreview').attr('src', url);
    $('#imagepreview').addClass('after-load');
    $('#imagepreview').removeClass('before-load');
    $('#imagemodal').modal('show');
});
</script>

<script type="text/javascript">
$('.call-modal').click(function() {
    let key = $(this).data('key');
    let page = `<?= $page ?>`;
    let jenis = `<?= ($jenis == '') ? 'null' : $jenis ?>`;
    let jenis_modal = $(this).attr('id');
    let act = '';
    let title_modal = '';
    if (jenis_modal == "add-modal") {
        act = "add";
        title_modal = "Tambah " + page;
    } else if (jenis_modal == "edit-modal") {
        act = "edit";
        title_modal = "Ubah " + page;
    }
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}/` + key + '/true',
        success: function(r) {
            $('#m-crud-title').text(title_modal);
            $('#m-crud-key').text(key);
            $('#m-crud-act').text(act);
            $('#m-crud-page').text(page);
            $('#m-crud-jenis').text(jenis);
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
        }
    });
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
                data: `frm_table=tpendapatan&token=123`,
                dataType: 'json',
                success: function(r) {
                    if (r.status == 200) {
                        tes_sweet('hapus data berhasil');
                        first_load();
                    }
                }
            });
        }
    })
});
</script>
<?php
} elseif (isset($act) && $act == 'add' && !$modal) {
    ?>
<form id="frm-pendapatan" action="#">
    <div class="card card-danger card-outline">
        <div class="card-body">
            <input type="hidden" name="val_tanggal" value="<?= date('Y-m-d H:i:s') ?>">
            <input type="hidden" name="val_kd_divisi" value="0">

            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Kode Referensi</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" id="val_kd_customer_reff" name="val_no_transaksi_reff"
                        placeholder="Kode Refferensi" value="-" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Jenis Pendapatan</label>
                <div class="col-sm-8 col-md-4">
                    <select name="val_kd_pendapatan" class="form-control select2">
                        <!-- <option selected="0">pilih..</option> -->
                        <?php foreach ($pendapatan as $key => $value) : ?>
                        <option value="<?= $value->kd_pendapatan ?>"><?= $value->nama ?></option>
                        <?php endforeach; ?>
                        <option value="" class="add-foreign" data-table="pendapatan">+ Tambah</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Jenis Bayar</label>
                <div class="col-sm-8 col-md-4">
                    <select name="val_kd_jenis_bayar" class="form-control select2">
                        <!-- <option selected="0">pilih..</option> -->
                        <?php foreach ($jenis_bayar as $key => $value) : ?>
                        <option value="<?= $value->kd_jenis_bayar ?>"><?= $value->nama ?></option>
                        <?php endforeach ?>
                        <option value="" class="add-foreign" data-table="jenis_bayar">+ Tambah</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">No. Rekening</label>
                <div class="col-sm-8 col-md-4">
                    <select name="val_kd_kas" class="form-control select2">
                        <!-- <option selected="0">pilih..</option> -->
                        <?php foreach ($kas as $key => $value) : ?>
                        <option value="<?= $value->kd_kas ?>"><?= $value->no_rekening ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Nominal</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" name="val_nominal" id="val_kd_customer_reff" value="0" min="0"
                        placeholder="Kode Refferensi" value="-" class="form-control allow-numeric">
                </div>
            </div>



            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Keterangan</label>
                <div class="col-sm-8 col-md-4">
                    <textarea name="val_keterangan" class="form-control" placeholder="Keterangan">-</textarea>
                </div>
            </div>

            <!-- <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Kode Referensi</label>
                <div class="col-sm-8 col-md-4">
                    <input class="form-control" type="text" name="val_no_transaksi_reff" placeholder="Kode Refferensi"
                        value="-">
                </div>
            </div> -->
            <div class="form-group row">
                <label class="col-sm-2 col-md-2 col-md-2 col-form-label">Lampiran</label>
                <div class="col-sm">
                    <div class="row col-sm-8">
                        <img id="customeredit" src="" style=" width: 100px; height:100px;">
                    </div>
                    <div class="row mt-2 col-md-2">
                        <input type="file" name="val_lampiran" id="file" onchange="previewELK12()">
                    </div>
                </div>
            </div>

            <!-- <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-3 col-form-label">Lampiran</label>
                <div class="col-sm-8">
                    <div class="row">
                        <img id="frameELK12" src="" style=" width: 100px; height:100px;" />
                    </div>
                    <div class="row mt-2">
                        <input type="file" name="val_lampiran" id="file" onchange="previewELK12()">
                    </div>
                </div>
            </div> -->
            <script>
            function previewELK12() {
                let frame = document.getElementById('frameELK12');

                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            $('.select2').select2()
            $(':input').click(function() {
                $(this).select();
            });
            </script>

            <div class="card-footer text-center">
                <button type="button" name="simpan" style="float: left;" class="btn btn-light"
                    onclick="history.back(-1)" id="btn-close"><i style="color:black" class="fa fa-arrow-left"></i>
                    Kembali</button>
                <button type="submit" id="btn-save" style="float: right;" name="btn_submit" class="btn btn-primary"><i
                        class="fas fa-save"></i>Simpan</button>
            </div>
        </div>
    </div>
</form>
<!-- End Kolom Lampiran  -->
<script type="text/javascript">
$(".allow-numeric").bind("keypress", function(e) {
    var key = event.keyCode || event.which;
    let val = $(this).val().split('.').length;
    if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key > 96 && key < 123) || (key > 218 && key <
            223) || (key > 190 && key < 193) || (key == 165) || (key == 32) || (key == 37) || (key == 39) || (
            key == 164) || (key == 130) || (key == 181) || (key == 144) || (key == 214) || (key == 224) || (
            key == 233) || (key == 173) || (key == 61) || (key == 188) || (key == 59) || key == 189 || key ==
        187 || key == 190 || key == 44) {
        event.preventDefault();
    } else {
        if (key === 46 && val > 1) {
            event.preventDefault();
        } else {
            return true;
        }
    }
});
$('.add-foreign').click(function() {
    // alert($(this).data('table'));
    let key = -1;
    let page = $(this).data('table');
    let jenis = `master`;
    let jenis_modal = $(this).attr('id');
    let act = "add";
    let title_modal = "Tambah Jenis " + $(this).data('table');

    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}/` + key + '/true',
        success: function(r) {
            // alert(title_modal);
            $('#m-crud-title').text(title_modal);
            $('#m-crud-key').text(key);
            $('#m-crud-act').text(act);
            $('#m-crud-page').text(page);
            $('#m-crud-jenis').text(jenis);
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
        }
    });

});
$('#frm-pendapatan').submit(function(e) {
    e.preventDefault();
    let loading_button = `
        <div style="width:50px;margin-left:30%">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span></div>`;
    e.preventDefault();
    $('#btn-save').prop('disabled', true);
    $('#btn-save').html(loading_button);
    form_data = new FormData($('#frm-pendapatan')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'tpendapatan');
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/insert`,
        data: form_data,
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(r) {
            console.log(r);
            if (r.status == 200) {
                tes_sweet('Data Berhasil di Tambahkan');
                location.href = `<?= base_url() ?>/load/view/tpendapatan/other`;
            }
        }

    });
});
</script>
<?php
} elseif (isset($act) && $act == 'edit' && !$modal) {
    ?>

<form id="frm-pendapatan-edit" action="#">
    <div class="card card-danger card-outline">
        <div class="card-body">
            <input type="hidden" name="val_kd_divisi" value="0">
            <input type="hidden" name="val_tanggal" value="<?= date('Y-m-d H:i:s') ?>">
            <input type="hidden" id="key-update" name="key_no_transaksi" value="<?= $edit_data->no_transaksi ?>">

            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Kode Referensi</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" id="val_kd_customer_reff" name="val_no_transaksi_reff"
                        placeholder="Kode Refferensi" value="<?= $edit_data->no_transaksi_reff ?>" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Jenis Pendapatan</label>
                <div class="col-sm-8 col-md-4">
                    <select name="val_kd_pendapatan" class="form-control select2">
                        <!-- <option selected="0">pilih..</option> -->
                        <?php foreach ($pendapatan as $key => $value) : ?>
                        <option value="<?= $value->kd_pendapatan ?>"
                            <?= ($edit_data->kd_pendapatan == $value->kd_pendapatan) ? 'selected' : '' ?>>
                            <?= $value->nama ?></option>
                        <?php endforeach; ?>
                        <option value="" class="add-foreign" data-table="pendapatan">+ Tambah</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Jenis Bayar</label>
                <div class="col-sm-8 col-md-4">
                    <select name="val_kd_jenis_bayar" class="form-control select2">
                        <!-- <option selected="0">pilih..</option> -->
                        <?php foreach ($jenis_bayar as $key => $value) : ?>
                        <option value="<?= $value->kd_jenis_bayar ?>"
                            <?= ($edit_data->kd_jenis == $value->kd_jenis_bayar) ? 'selected' : '' ?>>
                            <?= $value->nama ?></option>
                        <?php endforeach ?>
                        <option value="" class="add-foreign" data-table="jenis_bayar">+ Tambah</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">No. Rekening</label>
                <div class="col-sm-8 col-md-4">
                    <select name="val_kd_kas" class="form-control select2">
                        <!-- <option selected="0">pilih..</option> -->
                        <?php foreach ($kas as $key => $value) : ?>
                        <option value="<?= $value->kd_kas ?>"
                            <?= ($edit_data->kd_kas == $value->kd_kas) ? 'selected' : '' ?>> <?= $value->no_rekening ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Nominal</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" name="val_nominal" id="val_kd_customer_reff" value="<?= $edit_data->nominal ?>"
                        min="0" placeholder="Kode Refferensi" value="-" class="form-control allow-numeric">
                </div>
            </div>
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Keterangan</label>
                <div class="col-sm-8 col-md-4">
                    <textarea name="val_keterangan" class="form-control"
                        placeholder="Keterangan"><?= $edit_data->keterangan ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-2 col-form-label">Kode Referensi</label>
                <div class="col-sm-8 col-md-4">
                    <input class="form-control" type="text" name="val_no_transaksi_reff" placeholder="Kode Refferensi"
                        value="<?= $edit_data->no_transaksi_reff ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-md-2 col-md-2 col-form-label">Lampiran</label>
                <div class="col-sm">
                    <div class="row col-sm-8">
                        <img id="customeredit" src="" style=" width: 100px; height:100px;">
                    </div>
                    <div class="row mt-2 col-md-2">
                        <input type="file" name="val_lampiran" id="file" onchange="previewELK12()">
                    </div>
                </div>
            </div>
            <script>
            function previewELK12() {
                let frame = document.getElementById('frameELK12');

                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            </script>

            <div class="card-footer text-center">
                <!-- <button type="submit" name="btn-save" value="Simpan" class="btn btn-primary"><i
                        class="fas fa-save"></i>Simpan
                    Data</button>
 -->
                <button type="button" name="simpan" style="float: left;" class="btn btn-light"
                    onclick="history.back(-1)" id="btn-close"><i style="color:black" class="fa fa-arrow-left"></i>
                    Kembali</button>
                <button type="submit" id="btn-save" style="float: right;" name="btn_submit" class="btn btn-primary"><i
                        class="fas fa-save"></i>Simpan</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
$(".allow-numeric").bind("keypress", function(e) {
    var key = event.keyCode || event.which;
    let val = $(this).val().split('.').length;
    if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key > 96 && key < 123) || (key > 218 && key <
            223) || (key > 190 && key < 193) || (key == 165) || (key == 32) || (key == 37) || (key == 39) || (
            key == 164) || (key == 130) || (key == 181) || (key == 144) || (key == 214) || (key == 224) || (
            key == 233) || (key == 173) || (key == 61) || (key == 188) || (key == 59) || key == 189 || key ==
        187 || key == 190 || key == 44) {
        event.preventDefault();
    } else {
        if (key === 46 && val > 1) {
            event.preventDefault();
        } else {
            return true;
        }
    }
});
$('.add-foreign').click(function() {

    let key = -1;
    let page = $(this).data('table');
    let jenis = `master`;
    let jenis_modal = $(this).attr('id');
    let act = "add";
    let title_modal = "Tambah Jenis " + $(this).data('table');

    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}/` + key + '/true',
        success: function(r) {
            $('#m-crud-title').text(title_modal);
            $('#m-crud-key').text(key);
            $('#m-crud-act').text(act);
            $('#m-crud-page').text(page);
            $('#m-crud-jenis').text(jenis);
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
        }
    });
});
$('#frm-pendapatan-edit').submit(function(e) {
    e.preventDefault();
    form_data = new FormData($('#frm-pendapatan-edit')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'tpendapatan');
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
                tes_sweet('Ubah Data Berhasil');
                location.href = `<?= base_url() ?>/load/view/tpendapatan/other`;
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
<script>
function preview() {
    let frame = document.getElementById('frame');
    frame.src = URL.createObjectURL(event.target.files[0]);
}

function preview1() {
    let frame1 = document.getElementById('frame1');

    frame1.src = URL.createObjectURL(event.target.files[0]);
}

function previewImgModal() {
    let frame1 = document.getElementById('frame2');

    frame1.src = URL.createObjectURL(event.target.files[0]);
}
</script>