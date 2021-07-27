<script type="text/javascript">
$('#val-kd-kategori').change(function() {
    let value = $(this).val();
    if (value == "") {
        let key = $(this).data('key');
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah Kategori Customer";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/${act}/customer_kategori/${jenis}` + key + '/true',
            success: function(r) {
                // alert(title_modal);
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('customer_kategori');
                $('#m-crud-jenis').text(jenis);
                $('#m-container-crud').html(r);
                $('#modal-crud').modal('show');
            }
        });
        // $('#modal-crud').modal('show')
    } else {
        $('#modal-crud').modal('hide')
    }
});
</script>


<?php
if (isset($act) && $act == 'add' && $modal) {
    ?>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kategori Referensi</label>
    <div class="col-sm-8">
        <input type="text" name="val_kd_kategori_reff" value="-" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col-sm-8">
        <input type="text" name="val_nama" class="form-control" placeholder="Maukkan Nama">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Deskripsi</label>
    <div class="col-sm-8">
        <input type="text" name="val_deskripsi" value="-" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Status</label>
    <div class="col-sm-2" id="radio-aktif">
        <p><input type='radio' name="val_status" value='1' checked /> Aktif</p>
    </div>
    <div class="col-sm-2" id="radio-aktif1">
        <p><input type='radio' name="val_status" value='0' /> Non-Akif</p>
    </div>
</div>
</div>
<div class="form-group row">
    <div class="col-sm-3 col-form-label">
        <label for="val_status">Lampiran</label>
    </div>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="k_cs" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="cs_k()">
        </div>
    </div>
</div>
<script>
function cs_k() {
    let frame = document.getElementById('k_cs');

    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
}elseif (isset($act) && $act=='view') {
    ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary call-modal" id="add-modal" data-key="-1"><i class="fas fa-plus-circle"></i>
            Tambah Customer Kategori</button>
    </div>
</div>
<div class="card card-danger card-outline">
    <div class="card-body">
        <table class="table table-hover table-bordered table-striped" id="table-data">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>DESKRIPSI</th>
                    <th>REFF</th>
                    <!-- <th>STATUS</th> -->
                    <!-- <th>LAMPIRAN</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customer_kategori as $key => $value) : ?>
                <tr>
                    <td class="text-center"><?= ($key + 1) ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->deskripsi ?></td>
                    <td><?= $value->kd_kategori_reff ?></td>
                    <td class="text-center">
                        <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                            data-key='<?= $value->kd_kategori ?>'><i
                                class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-warning btn-xs call-modal" data-key="<?= $value->kd_kategori ?>"
                            id="edit-modal"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-xs delete" data-key="<?= $value->kd_kategori ?>"><i
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

<script type="text/javascript">
$('#table-data').DataTable();
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
        title_modal = "Tambah Customer Kategori";
    } else if (jenis_modal == "edit-modal") {
        act = "edit";
        title_modal = "Ubah Customer Kategori";
    }
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}` + key + '/true',
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
                data: `frm_table=customer_kategori&token=123`,
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
}elseif (isset($act) && $act=='edit' && $modal) {
    ?>
<input type="hidden" name="key_kd_kategori" class="form-control" value="<?=$edit_data->kd_kategori ?>">
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kategori Referensi</label>
    <div class="col-sm-8">
        <input type="text" name="val_kd_kategori_reff" value="<?=$edit_data->kd_kategori_reff ?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col-sm-8">
        <input type="text" name="val_nama" value="<?=$edit_data->nama ?>" class="form-control"
            placeholder="Maukkan Nama">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Deskripsi</label>
    <div class="col-sm-8">
        <input type="text" name="val_deskripsi" value="<?=$edit_data->deskripsi ?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-3 col-form-label">Status</label>
    <div class="col-sm-3" id="radio-aktif">
        <p><input type='radio' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'checked' : '' ?>> Aktif
        </p>

    </div>
    <div class="col-sm-3" id="radio-aktif1">
        <p><input type='radio' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'checked' : '' ?>>
            Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-3 col-form-label">
        <label for="val_status">Lampiran</label>
    </div>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="k_cs" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="cs_k()">
        </div>
    </div>
</div>
<script>
function cs_k() {
    let frame = document.getElementById('k_cs');

    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
<?php
}
?>