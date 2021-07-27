<?php

use PhpParser\Node\Stmt\Echo_;

// print_r($userx);
if (isset($act) && $act == "view") {
?>
<a class="btn btn-sm btn-primary" style="padding-top: 10px; padding-bottom: 10px;"
    href="<?= site_url('load/add/pegawai/master') ?>">
    <i class="fa fa-pluscircle"></i> Tambah</a>
<br>
<hr>
<div class="card">
    <div class="card-body">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" style="padding-top: 10px; padding-bottom: 10px;"
                href="<?= site_url('load/add/pegawai/master') ?>">
                <i class="fa fa-pluscircle"></i> Tambah</a>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th scope="col">Kategori</th>
                        <th scope="col">Kode Pegawai Referensi</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">No. HP</th>
                        <th scope="col">Status</th>
                        <th scope="col">Lampiran</th>
                        <th scope="col">Kode User</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pegawai as $pg => $value) : ?>
                    <tr>
                        <td><?= $value->kategori_pegawai ?></td>
                        <td><?= $value->kd_pegawai_reff ?></td>
                        <td><?= $value->nama ?></td>
                        <td><?= $value->deskripsi ?></td>
                        <td><?= $value->hp ?></td>
                        <td><?= $value->status ?></td>
                        <td><?= $value->lampiran ?></td>
                        <td><?= $value->kd_user ?></td>
                        <td>
                            <button class="btn btn-sm btn-secondary  call-modal" id="edit-modal"
                                data-key="<?= $value->kd_pegawai ?>">
                                <i class="fa fa-pencil"></i></button>
                            <button class="btn btn-sm btn-danger delete"
                                data-key="<?= $value->kd_pegawai ?>""><i class=" fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
} elseif (isset($act) && $act == "add" && !$modal) {
    // print_r($_SESSION);
?>

<div class="container">
    <form id="frm-pegawai" action="#">
        <div class="card card-info">
            <div class="card-body">
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Kode Referensi</label>
                    <div class="col-sm-8 col-md-4">
                        <input type="text" id="val_kd_pegawai_reff" name="val_kd_pegawai_reff" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-8">
                        <input type="text" id="val_nama" name="val_nama" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="desc" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-8">
                        <textarea id="val_deskripsi" name="val_deskripsi" style="height:80px"
                            class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Nomor HP</label>
                    <div class="col-sm-8">
                        <input type="text" id="val_hp" name="val_hp" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="val_status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-2" id="radio-aktif">
                        <p><input type='checkbox' name="val_status" value='aktif' /> Aktif</p>
                    </div>
                    <div class="col-sm-2" id="radio-aktif1">
                        <p><input type='checkbox' name="val_status" value='non_aktif' /> Non-Akif</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="val_status" class="col-sm-2 col-form-label">Lampiran</label>
                    <div class="col-sm-8">
                        <div class="row">
                            <img id="pgwadd" src="" style=" width: 100px; height:100px;">
                        </div>
                        <div class="row mt-2">
                            <input type="file" name="val_lampiran" id="val_lampiran" onchange="addpgw()">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-8">
                        <select name="val_kd_kategori" id="add-modal-val-kd-kategori" class="form-control">
                            <option selected="0">pilih..</option>
                            <?php foreach ($pegawai_kategori as $pg => $value) : ?>
                            <option value="<?php echo $value->kd_kategori; ?>">
                                <?php echo $value->nama ?> </option>
                            <?php endforeach; ?>
                            <option value="" class="">+ Tambah Kategori</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">User</label>
                    <div class="col-sm-8">
                        <input type="text" id="val_kd_user" name="val_kd_user" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" name="btn_submit" value="Simpan" class="btn btn-sm btn-success"
            style="padding-top: 10px; padding-bottom: 10px;"><i class="fa fa-pluscircle"></i>
    </form>
</div>
<script>
function addpgw() {
    let frame = document.getElementById('pgwadd');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<script type="text/javascript">
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
                // alert(title_modal);
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('pegawai_kategori');
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
<!-- <script type="text/javascript">
$('#add-modal-val-kd-user').change(function() {
    let val = $(this).val();
    if (val == "") {
        let key = $(this).data('key');
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah User";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/${act}/userx/${jenis}` + key + '/true',
            success: function(r) {
                // alert(title_modal);
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('userx');
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
</script> -->
<script type="text/javascript">
$('#select-test').change(function() {
    // alert('h');
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
                // alert('success');
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
<div class="card card-info">
    <div class="card-body">
        <div class="form-group row">
            <label for="lname" class="col-sm-2 col-form-label">Kode Referensi</label>
            <div class="col-sm-8">
                <input type="text" id="val_kd_pegawai_reff" name="val_kd_pegawai_reff" class="form-control"
                    value="<?= $edit_data->kd_pegawai_reff ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="lname" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-8">
                <input type="text" id="val_nama" name="val_nama" class="form-control" value="<?= $edit_data->nama ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="desc" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-8">
                <textarea id="val_deskripsi" name="val_deskripsi" style="height:80px"
                    class="form-control"><?= $edit_data->deskripsi ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="lname" class="col-sm-2 col-form-label">Nomor HP</label>
            <div class="col-sm-8">
                <input type="text" id="val_hp" name="val_hp" class="form-control" value="<?= $edit_data->hp ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="val_status" class="col-sm-2 col-form-label">Status</label>
            <div class="col-sm-3" id="radio-aktif">
                <p><input type='checkbox' name="val_status" value="1"
                        <?= ($edit_data->status == '1') ? 'checked' : '' ?>> Aktif
                </p>

            </div>
            <div class="col-sm-3" id="radio-aktif1">
                <p><input type='checkbox' name="val_status" value="0"
                        <?= ($edit_data->status == '0') ? 'checked' : '' ?>>
                    Non-Akif</p>
            </div>
        </div>
        <div class="form-group row">
            <label for="val_status" class="col-sm-2 col-form-label">Lampiran</label>
            <div class="col-sm-8">
                <div class="row">
                    <img id="pgwedit" src="" style=" width: 100px; height:100px;">
                </div>
                <div class="row mt-2">
                    <input type="file" name="val_lampiran" id="val_lampiran" onchange="editpgw()">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-8">
                <select name="val_kd_kategori" id="val_kd_kategori" class="form-control">
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
            <label for="lname" class="col-sm-2 col-form-label">User</label>
            <div class="col-sm-8">
                <select name="val_kd_user" id="add-modal-val-kd-user" class="form-control">
                    <?php foreach ($userx as $user => $value) : ?>
                    <option value="<?= $value->kd_user ?>"
                        <?= ($edit_data->kd_user == $value->kd_user) ? 'selected' : '' ?>>
                        <?php echo $value->nama ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>
<script>
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