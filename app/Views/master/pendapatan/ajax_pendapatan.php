<?php

if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary btn-sm call-modal" id="add-modal" data-key="-1"><i class="fa fa-plus"></i> Tambah
            <?= $page ?></button>
    </div>
</div>

<div class="card card-danger card-outline">
    <div class="card-body">
        <table id="table-pendapatan" class="table table-striped table-bordered">
            <thead class="bg-danger">
                <tr>
                    <th>#</th>
                    <th>NAMA</th>
                    <th>KETERANGAN</th>
                    <th>KODE REFF.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendapatan as $key => $value) : ?>
                <tr>
                    <td><?= ($key + 1) ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->keterangan ?></td>
                    <td><?= $value->kd_pendapatan_reff ?></td>
                    <td>
                        <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                            data-key='<?= $value->kd_pendapatan ?>'><i
                                class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-warning btn-xs call-modal" data-key="<?= $value->kd_pendapatan ?>"
                            id="edit-modal"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-xs delete" data-key="<?= $value->kd_pendapatan ?>"><i
                                class="fa fa-trash"></i></button>
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
                data: `frm_table=pendapatan&token=123`,
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
<script>
function preview_pendapatan_add() {
    let frame = document.getElementById('frm-img-pendapatan-add');
    frame.src = URL.createObjectURL(event.target.files[0]);
}

function preview_pendapatan_edit() {
    let frame = document.getElementById('frm-img-pendapatan-edit');
    console.log(frame);
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
<?php
} elseif (isset($act) && $act == 'add' && $modal) {
    ?>
<div class="form-group">
    <label>Nama</label>
    <input class="form-control" type="text" name="val_nama" placeholder="Nama">
</div>
<div class="form-group">
    <label>Keterangan</label>
    <textarea name="val_keterangan" class="form-control" placeholder="Keterangan">-</textarea>

</div>
<div class="form-group">
    <label>Status</label>
    <p>
        <input type='radio' name="val_status" value='1' checked /> Aktif
        <input type='radio' name="val_status" value='0' /> Nonaktif
    </p>
</div>
<div class="form-group">
    <label>Kode Refferensi</label>
    <input class="form-control" type="text" name="val_kd_pendapatan_reff" placeholder="Kode Refferensi" value="-">
</div>
<!-- Kolom Lampiran  -->
<div class="form-group">
    <div class="col-sm-10">
        <div class="row">
            <img id="frm-img-pendapatan-add" src="" style=" width: 100px; height:100px;" />
        </div>
        <div class="row mt-2">
            <input type="file" name="val_lampiran" id="file" onchange="preview_pendapatan_add()">
        </div>
    </div>
</div>
<!-- End Kolom Lampiran  -->

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_kd_pendapatan" value="<?= $edit_data->kd_pendapatan ?>">
<div class="form-group">
    <label>Nama</label>
    <input class="form-control" type="text" name="val_nama" placeholder="Nama" value="<?= $edit_data->nama ?>">
</div>
<div class="form-group">
    <label>Keterangan</label>
    <textarea name="val_keterangan" class="form-control"
        placeholder="Keterangan"><?= $edit_data->keterangan ?></textarea>
</div>
<div class="form-group">
    <label>Status</label>
    <p>
        <input type='radio' name="val_status" value='1' <?= ($edit_data->status == 1) ? 'checked' : '' ?> /> Aktif
        <input type='radio' name="val_status" value='0' <?= ($edit_data->status == 0) ? 'checked' : '' ?> /> Nonaktif
    </p>
</div>
<div class="form-group">
    <label>Kode Refferensi</label>
    <input class="form-control" type="text" name="val_kd_pendapatan_reff" placeholder="Kode Refferensi" value="-">
</div>
<!-- Kolom Lampiran  -->
<div class="form-group">
    <div class="col-sm-10">
        <div class="row">
            <img id="frm-img-pendapatan-edit" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2">
            <input type="file" name="val_lampiran" id="file" onchange="preview_pendapatan_edit()">
        </div>
    </div>
</div>
<script>

</script>
<?php
} else {
    echo view('errors/html/error_404');
}

?>