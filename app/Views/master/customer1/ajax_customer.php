<?php
// print_r($kabupaten);
if (isset($act) && $act == "view") {
?>

<<<<<<< HEAD
<div class="card-body">
    <div class="card-header">
        <a class="btn btn-sm btn-primary" style="padding-top: 10px; padding-bottom: 10px;"
            href="<?= site_url('load/add/customer/master') ?>">
            <i class="fa fa-pluscircle"></i> Tambah</a>
    </div>
    <table class="table table-condensed" id="table-customer">
        <tr>
            <th>Customer Referensi</th>
            <th>Kategori</th>
            <th>Kabupaten</th>
            <th>Nomor</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No. HP</th>
            <th>Limit Kredit</th>
            <th>Status</th>
            <th>Lampiran</th>
            <th>Aksi</th>

        </tr>
        <?php foreach ($customer as $cs => $value) : ?>
        <tr>
            <td><?= $value->kd_customer_reff ?></td>
            <td><?= $value->kategori ?></td>
            <td><?= $value->kabupaten ?></td>
            <td><?= $value->nomor ?></td>
            <td><?= $value->nama ?></td>
            <td><?= $value->alamat ?></td>
            <td><?= $value->hp ?></td>
            <td><?= $value->limit_kredit ?></td>
            <td><?= $value->status ?></td>
            <td><?= $value->lampiran ?></td>
            <td>
                <button class="btn btn-sm btn-secondary  call-modal" id="edit-modal"
                    data-key="<?= $value->kd_customer ?>">
                    <i class="fa fa-pencil-alt"></i></button>
                <button class="btn btn-sm btn-danger delete" data-key="<?= $value->kd_customer ?>""><i class=" fa
                    fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#table-customer').DataTable();
});
</script>
=======
    <div class="card-body">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" style="padding-top: 10px; padding-bottom: 10px;" href="<?= site_url('load/add/customer/master') ?>">
                <i class="fa fa-pluscircle"></i> Tambah</a>
        </div>
        <table class="table table-condensed" id="table-customer">
            <tr>
                <th>Customer Referensi</th>
                <th>Kategori</th>
                <th>Kabupaten</th>
                <th>Nomor</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Limit Kredit</th>
                <th>Status</th>
                <th>Lampiran</th>
                <th>Aksi</th>

            </tr>
            <?php foreach ($customer as $cs => $value) : ?>
                <tr>
                    <td><?= $value->kd_customer_reff ?></td>
                    <td><?= $value->kategori ?></td>
                    <td><?= $value->kabupaten ?></td>
                    <td><?= $value->nomor ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->alamat ?></td>
                    <td><?= $value->hp ?></td>
                    <td><?= $value->limit_kredit ?></td>
                    <td><?= $value->status ?></td>
                    <td><?= $value->lampiran ?></td>
                    <td>
                        <button class="btn btn-sm btn-secondary  call-modal" id="edit-modal" data-key="<?= $value->kd_customer ?>">
                            <i class="fa fa-pencil-alt"></i></button>
                        <button class="btn btn-sm btn-danger delete" data-key="<?= $value->kd_customer ?>""><i class=" fa fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#table-customer').DataTable();
        });
    </script>
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98



<?php
} elseif (isset($act) && $act == "add" && !$modal) {
    // print_r($_SESSION);
?>

<<<<<<< HEAD
<h1 style="margin-top: 20px" align="center">Tambah Customer</h1>
<hr>
<div class="container">
    <form id="frm-customer" action="#">
=======
    <h1 style="margin-top: 20px" align="center">Tambah Customer</h1>
    <hr>
    <div class="container">
        <form id="frm-customer" action="#">
            <div class="card card-info">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="fname" class="col-sm-2 col-form-label">Kode Referensi</label>
                        <div class="col-sm-8">
                            <input type="text" id="val_kd_customer_reff" name="val_kd_customer_reff" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-8">
                            <select name="val_kd_kategori" id="add-modal-val-kd-kategori" class="form-control">
                                <option selected="0">pilih..</option>
                                <?php foreach ($customer_kategori as $cs => $value) : ?>
                                    <option value="<?php echo $value->kd_kategori; ?>"> <?php echo $value->nama ?> </option>
                                <?php endforeach; ?>
                                <option value="" class="">+ Tambah Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                        <div class="col-sm-8">
                            <select id="val_kd_kabupaten" name="val_kd_kabupaten" class="form-control">
                                <option selected="0">pilih kategori</option>
                                <?php foreach ($kabupaten as $kab => $value) : ?>
                                    <option value="<?php echo $value->kd_kabupaten; ?>"> <?php echo $value->nama ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Nomor</label>
                        <div class="col-sm-8">
                            <input type="text" id="val_nomor" name="val_nomor" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" id="val_nama" name="val_nama" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subject" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea id="val_alamat" name="val_alamat" style="height:80px" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Nomor HP</label>
                        <div class="col-sm-8">
                            <input type="text" id="val_hp" name="val_hp" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Limit Kredit</label>
                        <div class="col-sm-8">
                            <input type="text" id="val_limit_kredit" name="val_limit_kredit" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="val_status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-2" id="radio-aktif">
                            <p><input type='checkbox' name="val_status" value='1' /> Aktif</p>
                        </div>
                        <div class="col-sm-2" id="radio-aktif1">
                            <p><input type='checkbox' name="val_status" value='0' /> Non-Akif</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="val_status" class="col-sm-2 col-form-label">Lampiran</label>
                        <div class="col-sm-8">
                            <div class="row">
                                <img id="customeradd" src="" style=" width: 100px; height:100px;">
                            </div>
                            <div class="row mt-2">
                                <input type="file" name="val_lampiran" id="val_lampiran" onchange="addcustomer()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" name="btn_submit" value="Simpan" class="btn btn-sm btn-success" style="padding-top: 10px; padding-bottom: 10px;"><i class="fa fa-pluscircle"></i>
        </form>
    </div>
    <script>
        function addcustomer() {
            let frame = document.getElementById('customeradd');
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
        $('#frm-customer').submit(function(e) {
            e.preventDefault();
            form_data = new FormData($('#frm-customer')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'customer');
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
                        tes_sweet('tambah data customer berhasil');
                        location.href = `<?= base_url() ?>/load/view/customer/master`;
                    }
                }

            });
        })
    </script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {

?>
    <input type="hidden" id="key-update" name="key_kd_customer" value="<?= $edit_data->kd_customer ?>">
    <hr>
    <div class="container">
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
        <div class="card card-info">
            <div class="card-body">
                <div class="form-group row">
                    <label for="fname" class="col-sm-2 col-form-label">Kode Referensi</label>
                    <div class="col-sm-8">
<<<<<<< HEAD
                        <input type="text" id="val_kd_customer_reff" name="val_kd_customer_reff" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-8">
                        <select name="val_kd_kategori" id="add-modal-val-kd-kategori" class="form-control">
                            <option selected="0">pilih..</option>
                            <?php foreach ($customer_kategori as $cs => $value) : ?>
                            <option value="<?php echo $value->kd_kategori; ?>"> <?php echo $value->nama ?> </option>
                            <?php endforeach; ?>
                            <option value="" class="">+ Tambah Kategori</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                    <div class="col-sm-8">
                        <select id="val_kd_kabupaten" name="val_kd_kabupaten" class="form-control">
                            <option selected="0">pilih kategori</option>
                            <?php foreach ($kabupaten as $kab => $value) : ?>
                            <option value="<?php echo $value->kd_kabupaten; ?>"> <?php echo $value->nama ?> </option>
=======
                        <input type="text" id="val_kd_customer_reff" name="val_kd_customer_reff" class="form-control" value="<?= $edit_data->kd_customer_reff ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-8">
                        <select name="val_kd_kategori" id="val_kd_kategori" class="form-control">
                            <?php foreach ($customer_kategori as $cs => $value) : ?>
                                <option value="<?= $value->kd_kategori ?>" <?= ($edit_data->kd_kategori == $value->kd_kategori) ? 'selected' : '' ?>>
                                    <?php echo $value->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class=" form-group row">
                    <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                    <div class="col-sm-8">
                        <select name="val_kd_kabupaten" id="val_kd_kabupaten" class="form-control">
                            <?php foreach ($kabupaten as $kab => $value) : ?>
                                <option value="<?= $value->kd_kabupaten ?>" <?= ($edit_data->kd_kabupaten == $value->kd_kabupaten) ? 'selected' : '' ?>>
                                    <?php echo $value->nama ?>
                                </option>
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
<<<<<<< HEAD
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Nomor</label>
                    <div class="col-sm-8">
                        <input type="text" id="val_nomor" name="val_nomor" class="form-control">
=======

                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Nomor</label>
                    <div class="col-sm-8">
                        <input type="text" id="val_nomor" name="val_nomor" class="form-control" value="<?= $edit_data->nomor ?>">
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-8">
<<<<<<< HEAD
                        <input type="text" id="val_nama" name="val_nama" class="form-control">
=======
                        <input type="text" id="val_nama" name="val_nama" class="form-control" value="<?= $edit_data->nama ?>">
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                    </div>
                </div>
                <div class="form-group row">
                    <label for="subject" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-8">
<<<<<<< HEAD
                        <textarea id="val_alamat" name="val_alamat" style="height:80px" class="form-control"></textarea>
=======
                        <textarea id="val_alamat" name="val_alamat" style="height:80px" class="form-control"><?= $edit_data->alamat ?></textarea>
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Nomor HP</label>
                    <div class="col-sm-8">
<<<<<<< HEAD
                        <input type="text" id="val_hp" name="val_hp" class="form-control">
=======
                        <input type="text" id="val_hp" name="val_hp" class="form-control" value="<?= $edit_data->hp ?>">
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label">Limit Kredit</label>
                    <div class="col-sm-8">
<<<<<<< HEAD
                        <input type="text" id="val_limit_kredit" name="val_limit_kredit" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="val_status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-2" id="radio-aktif">
                        <p><input type='checkbox' name="val_status" value='1' /> Aktif</p>
                    </div>
                    <div class="col-sm-2" id="radio-aktif1">
                        <p><input type='checkbox' name="val_status" value='0' /> Non-Akif</p>
=======
                        <input type="text" id="val_limit_kredit" name="val_limit_kredit" class="form-control" value="<?= $edit_data->limit_kredit ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="val_status" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-3" id="radio-aktif">
                        <p><input type='checkbox' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'checked' : '' ?>> Aktif
                        </p>

                    </div>
                    <div class="col-sm-3" id="radio-aktif1">
                        <p><input type='checkbox' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'checked' : '' ?>>
                            Non-Akif</p>
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                    </div>
                </div>
                <div class="form-group row">
                    <label for="val_status" class="col-sm-2 col-form-label">Lampiran</label>
                    <div class="col-sm-8">
                        <div class="row">
<<<<<<< HEAD
                            <img id="customeradd" src="" style=" width: 100px; height:100px;">
                        </div>
                        <div class="row mt-2">
                            <input type="file" name="val_lampiran" id="val_lampiran" onchange="addcustomer()">
=======
                            <img id="customeredit" src="" style=" width: 100px; height:100px;">
                        </div>
                        <div class="row mt-2">
                            <input type="file" name="val_lampiran" id="val_lampiran" onchange="editcustomer()">
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                        </div>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD
        <input type="submit" name="btn_submit" value="Simpan" class="btn btn-sm btn-success"
            style="padding-top: 10px; padding-bottom: 10px;"><i class="fa fa-pluscircle"></i>
    </form>
</div>
<script>
function addcustomer() {
    let frame = document.getElementById('customeradd');
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
=======
    </div>
    <script>
        function editcustomer() {
            let frame = document.getElementById('customeredit');
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
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
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                $('#m-crud-jenis').text(jenis);
                $('#m-container-crud').html(r);
                $('#modal-crud').modal('show');
            }
        });
<<<<<<< HEAD
        // $('#modal-crud').modal('show')
    } else {
        $('#modal-crud').modal('hide')
    }
});
</script>

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
$('#frm-customer').submit(function(e) {
    e.preventDefault();
    form_data = new FormData($('#frm-customer')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'customer');
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
                tes_sweet('tambah data customer berhasil');
                location.href = `<?= base_url() ?>/load/view/customer/master`;
            }
        }

    });
})
</script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {

?>
<input type="hidden" id="key-update" name="key_kd_customer" value="<?= $edit_data->kd_customer ?>">
<hr>
<div class="container">
    <div class="card card-info">
        <div class="card-body">
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-form-label">Kode Referensi</label>
                <div class="col-sm-8">
                    <input type="text" id="val_kd_customer_reff" name="val_kd_customer_reff" class="form-control"
                        value="<?= $edit_data->kd_customer_reff ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                <div class="col-sm-8">
                    <select name="val_kd_kategori" id="val_kd_kategori" class="form-control">
                        <?php foreach ($customer_kategori as $cs => $value) : ?>
                        <option value="<?= $value->kd_kategori ?>"
                            <?= ($edit_data->kd_kategori == $value->kd_kategori) ? 'selected' : '' ?>>
                            <?php echo $value->nama ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class=" form-group row">
                <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                <div class="col-sm-8">
                    <select name="val_kd_kabupaten" id="val_kd_kabupaten" class="form-control">
                        <?php foreach ($kabupaten as $kab => $value) : ?>
                        <option value="<?= $value->kd_kabupaten ?>"
                            <?= ($edit_data->kd_kabupaten == $value->kd_kabupaten) ? 'selected' : '' ?>>
                            <?php echo $value->nama ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-form-label">Nomor</label>
                <div class="col-sm-8">
                    <input type="text" id="val_nomor" name="val_nomor" class="form-control"
                        value="<?= $edit_data->nomor ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-8">
                    <input type="text" id="val_nama" name="val_nama" class="form-control"
                        value="<?= $edit_data->nama ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="subject" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-8">
                    <textarea id="val_alamat" name="val_alamat" style="height:80px"
                        class="form-control"><?= $edit_data->alamat ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-form-label">Nomor HP</label>
                <div class="col-sm-8">
                    <input type="text" id="val_hp" name="val_hp" class="form-control" value="<?= $edit_data->hp ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-form-label">Limit Kredit</label>
                <div class="col-sm-8">
                    <input type="text" id="val_limit_kredit" name="val_limit_kredit" class="form-control"
                        value="<?= $edit_data->limit_kredit ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="val_status" class="col-sm-3 col-form-label">Status</label>
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
                        <img id="customeredit" src="" style=" width: 100px; height:100px;">
                    </div>
                    <div class="row mt-2">
                        <input type="file" name="val_lampiran" id="val_lampiran" onchange="editcustomer()">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function editcustomer() {
    let frame = document.getElementById('customeredit');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
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
                data: `frm_table=customer&token=123`,
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
=======
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
                    data: `frm_table=customer&token=123`,
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
>>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
</script>