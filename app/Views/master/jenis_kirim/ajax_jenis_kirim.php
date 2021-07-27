<?php


if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary call-modal" id="add-modal" data-key="-1"><i class="fas fa-plus-circle"></i>
            Tambah Jenis Kirim</button>
    </div>
</div>
<div class="card card-outline card-danger">

    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="dataJenis">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>No</th>
                    <th>NAMA</th>
                    <th>DESKRIPSI</th>

                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jenis_kirim as $key => $value) : ?>
                <tr>
                    <td class="text-center"><?= $key + 1; ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->deskripsi ?></td>

                    <td class="text-center">
                        <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                            data-key='<?= $value->kd_jenis ?>'><i
                                class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                aria-hidden="true"></i>
                            <!-- <?= $value->status == 1 ? 'Aktif' : 'Nonaktif' ?> -->
                        </button>
                        <button class="btn btn-xs btn-warning call-modal" id="edit-modal"
                            data-key="<?= $value->kd_jenis ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-xs btn-danger delete" data-key="<?= $value->kd_jenis ?>"><i
                                class="fas fa-trash"></i></button>
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
$(function() {
    $('#dataJenis').DataTable({
        // "buttons": [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]
    });

});
$('.show-image').click(function() {
    let url = $(this).data('src');
    $('#imagepreview').attr('src', url);
    $('#imagepreview').addClass('after-load');
    $('#imagepreview').removeClass('before-load');
    $('#imagemodal').modal('show');
});
$('.call-modal').click(function() {
    let key = $(this).data('key');
    let page = `<?= $page ?>`;
    let jenis = `<?= $jenis ?>`;
    let jenis_modal = $(this).attr('id');
    let act = '';
    let title_modal = '';
    if (jenis_modal == "add-modal") {
        act = "add";
        title_modal = "Tambah Jenis Paket";
    } else if (jenis_modal == "edit-modal") {
        act = "edit";
        title_modal = "Ubah Jenis Paket ";
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
                data: `frm_table=jenis_kirim&token=123`,
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
} elseif (isset($act) && $act == 'add' && $modal) {
    ?>

<div class="form-group row">
    <label for="val_kd_lokasi_reff" class="col-sm-2 col-form-label">Kode Referensi</label>
    <div class="col-sm-10">
        <input name="kd_lokasi_reff" class="form-control" id="kd_lokasi_reff" value="-">
    </div>
</div>
<div class="form-group row">
    <label for="val_nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input name="val_nama" class="form-control" id="nama" placeholder="Masukan nama jenis paket pengiriman">
    </div>
</div>
<div class="form-group row">
    <label for="val_deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
    <div class="col-sm-10">
        <textarea class="form-control" rows="10" name="val_deskripsi">-</textarea>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-2">
        <label for="val_status">Status</label>
    </div>
    <div class="col-sm-2" id="radio-aktif">
        <p><input type='radio' class="data" name="val_status" value="1" checked /> Aktif</p>
    </div>
    <div class="col-sm-2" id="radio-aktif1">
        <p><input type='radio' class="data" name="val_status" value="0" /> Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-2">
        <label for="val_lampiran">Lampiran</label>
    </div>
    <div class="col-sm-8">
        <div class="row">
            <img id="frame-test12" src="" style=" width: 100px; height:100px;" />
        </div>
        <div class="row mt-2">
            <input type="file" name="val_lampiran" id="file" onchange="test12()">
            <!-- <input type="file" name="val_lampiran" id="val_lampiran"> -->
        </div>
    </div>
</div>

<script>
function test12() {
    let frame = document.getElementById('frame-test12');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
$(':input').click(function() {
    $(this).select();
});
</script>
<!-- <div class="col-sm-8">
        <input name="val_deskripsi" class="form-control" id="val_deskripsi">
    </div> -->

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_kd_jenis" value="<?= $edit_data->kd_jenis ?>">
<div class="form-group row">
    <label for="val_nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="nama" name="val_nama" value="<?= $edit_data->nama ?>"><br>
    </div>
</div>
<div class="form-group row">
    <label for="val_deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
    <div class="col-sm-10">
        <textarea id="val_deskripsi" rows="10" name="val_deskripsi"
            class="form-control"><?= $edit_data->deskripsi ?></textarea>

    </div>
</div>
<div class="form-group row">
    <div class="col-sm-2">
        <label for="val_status">Status</label>
    </div>
    <div class="col-sm-2" id="radio-aktif">
        <p><input type='radio' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'checked' : '' ?> /> Aktif
        </p>
    </div>
    <div class="col-sm-2" id="radio-aktif1">
        <p><input type='radio' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'checked' : '' ?> />
            Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-2">
        <label for="val_lampiran">Lampiran</label>
    </div>
    <div class="col-sm-10">
        <div class="row">
            <img id="frame-test123" src="" style=" width: 100px; height:100px;" />
        </div>
        <div class="row mt-2">
            <input type="file" name="val_lampiran" id="file" onchange="test123()">
            <!-- <input type="file" name="val_lampiran" id="val_lampiran"> -->
        </div>
    </div>
</div>

<script>
function test123() {
    let frame = document.getElementById('frame-test123');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
} else {
    echo view('errors/html/error_404');
}

?>