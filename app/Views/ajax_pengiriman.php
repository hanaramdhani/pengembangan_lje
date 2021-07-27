<?php
// print_r($customer);
if (isset($act) && $act == "view") {
?>
<div class="row">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="row">
                <div class="card-body">
                    <form id="frm-pertama" action="#"></form>
                    <select name="val_kd_customer" id="val_kd_customer" class="form-control">
                        <option selected="0">pilih dari customer</option>
                        <?php foreach ($customer as $cs => $value) : ?>
                        <option value="<?php echo $value->kd_customer; ?>"> <?php echo $value->nama ?> </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-4 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_nama" id="val_nama" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subject" class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea id="val_alamat" name="val_alamat" id="val_alamat" style="height:80px"
                                class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-4 col-form-label">Area</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_area" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-4 col-form-label">No. Tlpn</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_hp" id="val_hp" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>

    <div class="col-md-6">
        <div class="card card-info">
            <div class="row">
                <div class="card-body">


                    <form id="frm-kedua" action="#"></form>
                    <select name="val_kd_customer" id="val_kd_customer" class="form-control">
                        <option selected="0">pilih dari customer</option>
                        <?php foreach ($customer as $cs => $value) : ?>
                        <option value="<?php echo $value->kd_customer; ?>"> <?php echo $value->nama ?> </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-4 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_nama" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subject" class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea id="val_alamat" name="val_alamat" style="height:80px"
                                class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-4 col-form-label">Area</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_nama" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-4 col-form-label">No. Tlpn</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_nama" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-info">
    <div class="card-body">
        <textarea name="" id="" style="width: 100%; height: 200px;"></textarea>
    </div>
</div>
<!-- 
        <div class="card" style="width: 50%; float: left;">
            <form id="frm-kedua" action="#">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="fname" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_nama" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea name="val_alamat" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Area</label>
                        <div class="col-sm-8">
                            <input type="text" id="val_nama" name="val_nama" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subject" class="col-sm-2 col-form-label">No. Tlpn</label>
                        <div class="col-sm-8">
                            <textarea id="val_alamat" name="val_alamat" style="height:80px"
                                class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div> -->



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