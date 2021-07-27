<?php

use PhpParser\Node\Stmt\Echo_;

// print_r($pegawai);
// print_r($userx);
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <a class="btn  btn-primary" href="<?= site_url('load/add/pegawai/master') ?>" data-toggle="tooltip"
            data-placement="bottom" title="Tambah Data Pegawai"><i class="fas fa-plus-circle"></i>
            Tambah Pegawai</a>
    </div>
</div>
<div class="card card-danger card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped " id="table-data">
                <thead class="bg-danger">
                    <tr class="text-center">
                        <th>NO</th>
                        <th scope="col">NAMA</th>
                        <th scope="col">DESKRIPSI</th>
                        <th scope="col">NO. HP</th>
                        <th scope="col">KATEGORI</th>
                        <th scope="col">DIVISI</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pegawai as $key => $value) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $value->nama ?></td>
                        <td><?= $value->deskripsi ?></td>
                        <td class="text-right"><?= $value->hp ?></td>
                        <td><?= $value->kategori_pegawai ?></td>
                        <td><?= $value->divisi ?></td>
                        <td>
                            <button
                                class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                                data-key='<?= $value->kd_pegawai ?>'><i
                                    class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                    aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-xs btn-warning call-modal" id="edit-modal" data-toggle="tooltip"
                                data-placement="bottom" title="Edit Data" data-key="<?= $value->kd_pegawai ?>"><i
                                    class="fa fa-edit"></i></button>
                            <button data-toggle="tooltip" data-placement="bottom" title="Hapus Data"
                                class="btn btn-xs btn-danger delete" data-key="<?= $value->kd_pegawai ?>"><i
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
            </>
        </div>
    </div>
</div>
<script>
$('#table-data').DataTable();
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
                data: `frm_table=pegawai&token=123`,
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
    ?>
<form id="frm-pegawai" action="#">
    <div class="card card-danger card-outline">
        <div class="card-body">
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-2 col-form-label">Kode Referensi</label>
                <div class="col-sm-10 col-md-4">
                    <input type="text" id="val_kd_pegawai_reff" value="-" name="val_kd_pegawai_reff"
                        class="form-control" placeholder="Referensi">
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-2 col-form-label">Nama</label>
                <div class="col-sm-10 col-md-4">
                    <input type="text" id="val_nama" placeholder="Masukkan nama" name="val_nama" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="desc" class="col-sm-2 col-md-2 col-form-label">Deskripsi</label>
                <div class="col-sm-10 col-md-4">
                    <textarea id="val_deskripsi" name="val_deskripsi" style="height:80px"
                        class="form-control">-</textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-2 col-form-label">Nomor HP</label>
                <div class="col-sm-10 col-md-4">
                    <input type="text" id="val_hp" placeholder="Masukkan Nomor Hp" name="val_hp" class="form-control"
                        value="-">
                </div>
            </div>
            <div class="form-group row">
                <label for="val_status" class="col-sm-2 col-md-2 col-form-label">Status</label>
                <div class="col-sm-2" id="radio-aktif">
                    <p><input type='radio' name="val_status" value='1' checked /> Aktif</p>
                </div>
                <div class="col-sm-2" id="radio-aktif1">
                    <p><input type='radio' name="val_status" value='0' /> Nonaktif</p>
                </div>
            </div>
            <div class="form-group row">
                <label for="val_status" class="col-sm-2 col-md-2 col-form-label">Lampiran</label>
                <div class="col-sm-10 col-md-2">
                    <img id="pgwadd" src="" style=" width: 100px; height:100px;">
                    <div class="row mt-2">
                        <div class="col">
                            <input type="file" name="val_lampiran" id="val_lampiran" onchange="addpgw()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-2 col-form-label">Kategori</label>
                <div class="col-sm-10 col-md-4">
                    <select name="val_kd_kategori" id="add-modal-val-kd-kategori" class="form-control select2">
                        <?php foreach ($pegawai_kategori as $pg => $value) : ?>
                        <option value="<?php echo $value->kd_kategori; ?>">
                            <?php echo $value->nama ?>
                        </option>
                        <?php endforeach; ?>
                        <option value="" class="">+ Tambah Kategori</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-2 col-form-label">Divisi</label>
                <div class="col-sm-10 col-md-4">
                    <select id="add-modal-val-kd-divisi" name="val_kd_divisi" class="form-control select2">
                        <?php foreach ($divisi as $key_divisi => $value_divisi) : ?>
                        <?php if ($value_divisi->kd_divisi!=-1): ?>
                        <option value="<?php echo $value_divisi->kd_divisi; ?>"><?php echo $value_divisi->nama ?>
                        </option>
                        <?php endif ?>
                        <?php endforeach; ?>
                        <option value="" class="">+ Tambah Divisi</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <button type="button" name="simpan" style="float: left;" class="btn btn-light" onclick="history.back(-1)"
                id="btn-close"><i style="color:black" class="fa fa-arrow-left"></i>
                Kembali</button>
            <button type="submit" id="btn-save" style="float: right;" name="btn_submit" class="btn btn-primary"><i
                    class="fas fa-save"></i>
                Simpan</button>

        </div>
    </div>
</form>
<script>
$(':input').click(function() {
    $(this).select();
});

function addpgw() {
    let frame = document.getElementById('pgwadd');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<script type="text/javascript">
$('.select2').select2()

$('#add-modal-val-kd-kategori').change(function() {
    let val = $(this).val();
    if (val == "") {
        let key = $(this).data('key');
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah Kategori Pegawai";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/${act}/pegawai_kategori/${jenis}` + key +
                '/true',
            success: function(r) {
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('pegawai_kategori');
                $('#m-crud-jenis').text(jenis);
                $('#m-container-crud').html(r);
                $('#modal-crud').modal('show');
            }
        });
    }
});
$('#add-modal-val-kd-divisi').change(function() {
    let val = $(this).val();
    if (val == "") {
        let key = -1;
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah Divisi";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/add/divisi/master/` + key + '/true',
            success: function(r) {
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('divisi');
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

<script type="text/javascript">
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
$('#frm-pegawai').submit(function(e) {
    e.preventDefault();
    let loading_button = `
        <div style="width:50px;margin-left:30%">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span></div>`;
    e.preventDefault();
    $('#btn-save').prop('disabled', true);
    $('#btn-save').html(loading_button);
    form_data = new FormData($('#frm-pegawai')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'pegawai');
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
                tes_sweet('tambah data pegawai berhasil');
                location.href = `<?= base_url() ?>/load/view/pegawai/master`;
            }
        }

    });
})
</script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {

    ?>
<input type="hidden" id="key-update" name="key_kd_pegawai" value="<?= $edit_data->kd_pegawai ?>">
<hr>
<div class="form-group row">
    <label for="lname" class="col-md-3 col-form-label">Kode Referensi</label>
    <div class="col-sm-7 col-md-8">
        <input type="text" id="val_kd_pegawai_reff" name="val_kd_pegawai_reff" class="form-control"
            placeholder="Refferensi" value="<?= $edit_data->kd_pegawai_reff ?>">
    </div>
</div>
<div class="form-group row">
    <label for="lname" class="col-sm-2 col-md-3 col-form-label">Nama</label>
    <div class="col-sm-10 col-md-8">
        <input type="text" id="val_nama" placeholder="Nama" name="val_nama" class="form-control"
            value="<?= $edit_data->nama ?>">
    </div>
</div>
<div class="form-group row">
    <label for="desc" class="col-sm-2 col-md-3 col-form-label">Deskripsi</label>
    <div class="col-sm-10 col-md-8">
        <textarea id="val_deskripsi" name="val_deskripsi" style="height:80px" class="form-control"
            placeholder="No. HP"><?= $edit_data->deskripsi ?></textarea>
    </div>
</div>

<div class="form-group row">
    <label for="lname" class="col-sm-2 col-md-3 col-form-label">Nomor HP</label>
    <div class="col-sm-10 col-md-8">
        <input type="text" id="val_hp" name="val_hp" class="form-control" placeholder="No. Hp"
            value="<?= $edit_data->hp ?>">
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-2 col-md-3 col-form-label">Status</label>
    <div class="col-sm-3" id="radio-aktif">
        <p><input type='radio' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'checked' : '' ?>>
            Aktif
        </p>

    </div>
    <div class="col-sm-3" id="radio-aktif1">
        <p><input type='radio' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'checked' : '' ?>>
            Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-2 col-md-3 col-form-label">Lampiran</label>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="pgwedit" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="editpgw()">
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="kategori" class="col-sm-2 col-md-3 col-form-label">Kategori</label>
    <div class="col-sm-10 col-md-6">
        <select name="val_kd_kategori" id="val_kd_kategori" class="form-control select2">
            <?php foreach ($pegawai_kategori as $pg => $value) : ?>
            <option value="<?= $value->kd_kategori ?>"
                <?= ($edit_data->kd_kategori == $value->kd_kategori) ? 'selected' : '' ?>>
                <?php echo $value->nama ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="kategori" class="col-sm-2 col-md-3 col-form-label">Divisi</label>
    <div class="col-sm-10 col-md-6">
        <select name="val_kd_divisi" class="form-control select2">
            <?php foreach ($divisi as $key_divisi => $value_divisi) : ?>
            <?php if ($value_divisi->kd_divisi!=-1): ?>
            <option value="<?= $value_divisi->kd_divisi ?>"
                <?= ($edit_data->kd_divisi == $value_divisi->kd_divisi) ? 'selected' : '' ?>>
                <?php echo $value_divisi->nama ?>
            </option>
            <?php endif ?>

            <?php endforeach; ?>
        </select>
    </div>
</div>
<input type="hidden" name="val_kd_user" value="<?= $_SESSION['kd_user'] ?>">
<script>
$('.select2').select2()

function editpgw() {
    let frame = document.getElementById('pgwedit');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
<?php
} else {
    echo view('errors/html/error_404');
}
?>