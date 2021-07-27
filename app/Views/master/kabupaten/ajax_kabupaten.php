<?php

if (isset($act) && $act == "view") {
?>
<h1 style="margin-top: 20px" align="center">Page AJAX view</h1>
<hr>

<table class="table table-condensed">
    <tr>
        <th>Kode Kabupaten</th>
        <th>Kode Provinsi</th>
        <th>Kode Kabupaten Referensi</th>
        <th>Nomor</th>
        <th>Nama</th>
    </tr>
    <?php foreach ($kabupaten as $kab => $value) : ?>
    <tr>
        <td><?= $value->kd_kabupaten ?></td>
        <td><?= $value->kd_provinsi ?></td>
        <td><?= $value->kd_kabupaten_reff ?></td>
        <td><?= $value->nomor ?></td>
        <td><?= $value->nama ?></td>

    </tr>
    <?php endforeach ?>
</table>

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
                data: `frm_table=user_group&token=123`,
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
<h1 style="margin-top: 20px" align="center">Page AJAX add</h1>
<hr>
<form id="frm-user-group" action="#">
    <label>Nama</label>
    <input type="text" name="val_nama" placeholder="nama">
    <label>Deskripsi</label>
    <input type="text" name="val_deskripsi" placeholder="deskripsi">
    <label>Status</label>
    <!-- <input type="text" name="val_status" placeholder="status"> -->
    <div class="input-group">
        <select class="custom-select" id="inputGroupSelect04">
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-plus"></i></button>
        </div>
    </div>

    <input type="file" name="val_lampiran" id="file">
    <input type="submit" name="btn_submit" value="Simpan" class="btn btn-success">
</form>
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
$('#frm-user-group').submit(function(e) {
    e.preventDefault();
    form_data = new FormData($('#frm-user-group')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'user_group');
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
                alert('success');
                location.href = `<?= base_url() ?>/load/view/user_group/master`;
            }
        }

    });
})
</script>
<?php
} elseif (isset($act) && $act == "edit" && !$modal) {
?>
<h1 style="margin-top: 20px" align="center">Page AJAX edit</h1>
<hr>
<form id="frm-user-group-edit" action="#">
    <input type="hidden" id="key-update" name="key_kd_group" value="<?= $edit_data->kd_group ?>">
    <label>Nama</label>
    <input type="text" name="val_nama" placeholder="nama" value="<?= $edit_data->nama ?>">
    <label>Deskripsi</label>
    <input type="text" name="val_deskripsi" placeholder="deskripsi" value="<?= $edit_data->deskripsi ?>">
    <label>Status</label>
    <!-- <input type="text" name="val_status" placeholder="status" value="<?= $edit_data->status ?>"> -->
    <select name="val_status">
        <option value="1" <?= ($edit_data->status == '1') ? 'selected' : '' ?>>Aktif</option>
        <option value="0" <?= ($edit_data->status == '0') ? 'selected' : '' ?>>Non-Aktif</option>
    </select>
    <input type="file" name="val_lampiran" id="file">
    <input type="submit" name="btn_submit" value="Simpan" class="btn btn-success">
</form>
<script type="text/javascript">
$('#frm-user-group-edit').submit(function(e) {
    e.preventDefault();
    form_data = new FormData($('#frm-user-group-edit')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'user_group');
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
                location.href = `<?= base_url() ?>/load/view/user_group/master`;
            }
        }

    });
})
</script>
<?php
} elseif (isset($act) && $act == 'add' && $modal) {
?>
<label>Nama</label>
<input type="text" name="val_nama" placeholder="nama"> <br>
<label>Deskripsi</label>
<input type="text" name="val_deskripsi" placeholder="deskripsi"><br>
<label>Status</label>
<!-- <input type="text" name="val_status" placeholder="status"> -->
<select name="val_status">
    <option value="1">Aktif</option>
    <option value="0">Non-Aktif</option>
</select>
<input type="file" name="val_lampiran" id="file">
<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
?>
<input type="hidden" id="key-update" name="key_kd_group" value="<?= $edit_data->kd_group ?>">
<label>Nama</label>
<input type="text" name="val_nama" placeholder="nama" value="<?= $edit_data->nama ?>"><br>
<label>Deskripsi</label>
<input type="text" name="val_deskripsi" placeholder="deskripsi" value="<?= $edit_data->deskripsi ?>"><br>
<label>Status</label>
<!-- <input type="text" name="val_status" placeholder="status" value="<?= $edit_data->status ?>"> -->
<select name="val_status">
    <option value="1" <?= ($edit_data->status == '1') ? 'selected' : '' ?>>Aktif</option>
    <option value="0" <?= ($edit_data->status == '0') ? 'selected' : '' ?>>Non-Aktif</option>
</select>
<input type="file" name="val_lampiran" id="file">
<?php
} else {
    echo view('errors/html/error_404');
}

?>