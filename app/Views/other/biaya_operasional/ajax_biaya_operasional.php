<?php
date_default_timezone_set('Asia/Jakarta');
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= site_url('load/add/biaya_operasional/other') ?>"><i
                class="fas fa-plus-circle"></i>
            Tambah Biaya Operasional</a>
    </div>
</div>
<div class="card card-outline card-danger">
    <div class="card-header">
        <div class="card-body">
            <table class="table table-condensed" id="tampil-data">
                <thead class="bg-danger">
                    <tr class="text-center">
                        <th scope="col">REFERENSI</th>
                        <th scope="col">BIAYA</th>
                        <th scope="col">JENIS</th>
                        <th scope="col">KAS</th>
                        <th scope="col">DIVISI</th>
                        <!-- <th scope="col">Nomor</th> -->
                        <th scope="col">TANGGAL</th>
                        <th scope="col">KETERANGAN</th>
                        <th scope="col">NOMINAL</th>
                        <!-- <th scope="col">Lampiran</th> -->
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($biaya_operasional as $bo => $value) : ?>
                    <tr>
                        <td><?= $value->no_transaksi_reff ?></td>
                        <td><?= $value->biaya ?></td>
                        <td><?= $value->bayar ?></td>
                        <td><?= $value->kas ?></td>
                        <td><?= $value->divisi ?></td>
                        <!-- <td><?= $value->nomor ?></td> -->
                        <td><?= $value->tanggal ?></td>
                        <td><?= $value->keterangan ?></td>
                        <td class="text-right"><?= $value->nominal ?></td>
                        <td>
                            <button class="btn btn-xs btn-warning call-modal" data-toggle="tooltip"
                                data-placement="bottom" title="Edit Data" id="edit-modal"
                                data-key="<?= $value->no_transaksi ?>"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-xs btn-danger delete" data-toggle="tooltip" data-placement="bottom"
                                title="Hapus Data" data-key="<?= $value->no_transaksi ?>"><i
                                    class=" fa fa-trash"></i></button>
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
</div>
<script type="text/javascript">
$('#tampil-data').DataTable();
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
    let jenis = `<?= $jenis ?>`;
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
        url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}` + key + '/true',
        success: function(r) {
            $('#m-crud-title').text(title_modal);
            $('#m-crud-key').text(key);
            $('#m-crud-act').text(act);
            $('#m-crud-page').text('biaya_operasional');
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
                data: `frm_table=biaya_operasional&token=123`,
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
} elseif (isset($act) && $act == "add" && !$modal) {
    ?>

<form id="frm-biaya-operasional" action="#">
    <input type="hidden" name="val_tanggal" value="<?= date('Y-m-d H:i:s') ?>">
    <div class="card card-outline card-danger">
        <div class="card-info">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Referensi</label>
                    <div class="col-md-4">
                        <input type="text" name="val_no_transaksi_reff" value="-" class="form-control"
                            placeholder="Refferensi">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Biaya</label>
                    <div class="col-md-4">
                        <select name="val_kd_biaya" id="add-modal-val-kd-biaya" class="form-control select2">
                            <?php foreach ($biaya as $by => $value) : ?>
                            <option value="<?php echo $value->kd_biaya; ?>"><?php echo $value->nama ?> </option>
                            <?php endforeach; ?>
                            <option value="" class="">+Tambah Jenis Biaya</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Jenis Bayar</label>
                    <div class="col-md-4">
                        <select name="val_kd_jenis" class="form-control select2">
                            <?php foreach ($jenis_bayar as $jb => $value) : ?>
                            <option value="<?php echo $value->kd_jenis_bayar; ?>"><?php echo $value->nama ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Kas</label>
                    <div class="col-md-4">
                        <select name="val_kd_kas" class="form-control select2">
                            <?php foreach ($kas as $k => $value) : ?>
                            <option value="<?php echo $value->kd_kas; ?>"><?php echo $value->no_rekening ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Divisi</label>
                    <div class="col-md-4">
                        <select name="val_kd_divisi" class="form-control select2">
                            <?php foreach ($divisi as $div => $value) : ?>
                            <?php if ($value->kd_divisi!=-1): ?>
                            <option value="<?php echo $value->kd_divisi ?>"><?php echo $value->nama ?></option>
                            <?php endif ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Keterangan</label>
                    <div class="col-md-4">
                        <textarea name="val_keterangan" class="form-control">-</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nominal</label>
                    <div class="col-md-4">
                        <input type="text" min="0" value="0" name="val_nominal" placeholder="Masukkan nominal"
                            class="form-control allow-numeric">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="val_status" class="col-md-2 col-form-label">Lampiran</label>
                    <div class="col-sm-8">
                        <div class="row col-md-4">
                            <img id="boadd" src="" style=" width: 100px; height:100px;">
                        </div>
                        <div class="row col-md-4">
                            <input type="file" name="val_lampiran" id="val_lampiran" onchange="addbo()">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="val_kd_user">
            </div>
            <div class="card-footer text-center">
                <!-- <button type="submit" name="btn_submit" class="btn btn-primary"><i class="fas fa-save"></i>
                    Simpan</button> -->

                <button type="button" name="simpan" style="float: left;" class="btn btn-light"
                    onclick="history.back(-1)" id="btn-close"><i style="color:black" class="fa fa-arrow-left"></i>
                    Kembali</button>
                <button type="submit" id="btn-save" style="float: right;" name="btn_submit" class="btn btn-primary"><i
                        class="fas fa-save"></i>Simpan</button>

            </div>
        </div>
    </div>
</form>
<script>
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
$('.select2').select2()
e.preventDefault();
let loading_button = `
        <div style="width:50px;margin-left:30%">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span></div>`;
e.preventDefault();
$('#btn-save').prop('disabled', true);
$('#btn-save').html(loading_button);

function addbo() {
    let frame = document.getElementById('boadd');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
<script type="text/javascript">
$(':input').click(function() {
    $(this).select();
});
$('#select-test').change(function() {
    if ($(this).val() == '') {
        var newThing = prompt('Enter a name for the new thing:');
        var newValue = $('option', this).length;
        $('<option>')
            .text(newThing)
            .attr('value', newValue)
            .insertBefore($('option[value=]', this));
        $(this).val(newValue);
    }
});
$('#frm-biaya-operasional').submit(function(e) {
    e.preventDefault();
    form_data = new FormData($('#frm-biaya-operasional')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'biaya_operasional');
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
                tes_sweet('menyimpan data berhasi;')
                location.href = `<?= base_url() ?>/load/view/biaya_operasional/other`;
            }
        }

    });
})
</script>
<script type="text/javascript">
$('#add-modal-val-kd-biaya').change(function() {
    let val = $(this).val();
    if (val == "") {
        let key = $(this).data('key');
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah Jenis Biaya";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/${act}/biaya/master/${jenis}` + key + '/true',
            success: function(r) {
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('biaya');
                $('#m-crud-jenis').text(jenis);
                $('#m-container-crud').html(r);
                $('#modal-crud').modal('show');
            }
        });
    } else {
        $('#modal-crud').modal('hide')
    }
});
</script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_no_transaksi" value="<?= $edit_data->no_transaksi ?>">
<div class="form-group row">
    <label class="col-md-2 col-form-label">Tanggal</label>
    <div class="col-md-8">
        <input type="text" name="val_tanggal" class="form-control" value="<?= $edit_data->tanggal ?>" readonly>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Referensi</label>
    <div class="col-md-8">
        <input type="text" name="val_no_transaksi_reff" class="form-control"
            value="<?= $edit_data->no_transaksi_reff ?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Biaya</label>
    <div class="col-md-8">
        <select name="val_kd_biaya" class="form-control select2">
            <?php foreach ($biaya as $by => $value) : ?>
            <option value="<?= $value->kd_biaya ?>" <?= ($edit_data->kd_biaya == $value->kd_biaya) ? 'selected' : '' ?>>
                <?php echo $value->nama ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Jenis Bayar</label>
    <div class="col-md-8">
        <select name="val_kd_jenis" class="form-control select2">
            <?php foreach ($jenis_bayar as $k => $value) : ?>
            <option value="<?= $value->kd_jenis_bayar ?>"
                <?= ($edit_data->kd_jenis == $value->kd_jenis_bayar) ? 'selected' : '' ?>>
                <?php echo $value->nama ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label class="col-md-2 col-form-label">KAS</label>
    <div class="col-md-8">
        <select name="val_kd_kas" class="form-control select2">
            <?php foreach ($kas as $k => $value) : ?>
            <option value="<?= $value->kd_kas ?>" <?= ($edit_data->kd_kas == $value->kd_kas) ? 'selected' : '' ?>>
                <?php echo $value->no_rekening ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Divisi</label>
    <div class="col-md-8">
        <select name="val_kd_divisi" class="form-control select2">
            <?php foreach ($divisi as $k => $value) : ?>
            <option value="<?= $value->kd_divisi ?>"
                <?= ($edit_data->kd_divisi == $value->kd_divisi) ? 'selected' : '' ?>>
                <?php echo $value->nama ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Keterangan</label>
    <div class="col-md-8">
        <textarea type="text" name="val_keterangan" class="form-control"><?= $edit_data->keterangan ?></textarea>
    </div>
</div>
<div class="form-group row">
    <label class="col-md-2 col-form-label">Nominal</label>
    <div class="col-md-8">
        <input type="text" name="val_nominal" class="form-control allow-numeric" value="<?= $edit_data->nominal ?>">
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-md-2 col-form-label">Lampiran</label>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="boedit" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="editbo()">
        </div>
    </div>
</div>
<input type="hidden" name="val_kd_user" class="form-control" value="<?= $edit_data->kd_user ?>">
<script>
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
$('.select2').select2()

function editbo() {
    let frame = document.getElementById('boedit');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
<?php
} else {
    echo view('errors/html/error_404');
}
?>