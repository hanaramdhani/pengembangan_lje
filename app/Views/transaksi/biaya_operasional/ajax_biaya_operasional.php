<?php
// print_r($biaya);
// print_r($kas);
// print_r($userx); not related
// print_r($divisi); not related
//jenis ?
// print_r($biaya_operasional);
// print_r($jenis_kirim);
// print_r($jenis_bayar);
date_default_timezone_set('Asia/Jakarta');
if (isset($act) && $act == "view") {
    ?>
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" style="padding-top: 10px; padding-bottom: 10px;" href="<?= site_url('load/add/biaya_operasional/transaksi') ?>">+Tambah</a>
        </div>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th scope="col">REFERENSI</th>
                    <th scope="col">BIAYA</th>
                    <th scope="col">JENIS</th>
                    <th scope="col">KAS</th>
                    <th scope="col">DIVISI</th>
                    <th scope="col">NOMOR</th>
                    <th scope="col">TANGGAL</th>
                    <th scope="col">KETERANGAN</th>
                    <th scope="col">NOMINAL</th>
                    <th scope="col">LAMPIRAN</th>
                    <th scope="col">USER</th>
                    <th scope="col">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($biaya_operasional as $bo => $value) : ?>
                    <tr>
                        <td><?= $value->no_transaksi_reff ?></td>
                        <td><?= $value->kd_biaya ?></td>
                        <td><?= $value->kd_jenis ?></td>
                        <td><?= $value->kd_kas ?></td>
                        <td><?= $value->kd_divisi ?></td>
                        <td><?= $value->nomor ?></td>
                        <td><?= $value->tanggal ?></td>
                        <td><?= $value->keterangan ?></td>
                        <td><?= $value->nominal ?></td>
                        <td><?= $value->lampiran ?></td>
                        <td><?= $value->kd_user ?></td>
                        <td>
                            <button class="btn btn-sm btn-secondary" data-key="<?= $value->kd_divisi ?>"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-sm btn-danger" data-key="<?= $value->kd_divisi ?>"><i class=" fa fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>
    </div>


    <?php
} elseif (isset($act) && $act == "add" && !$modal) {
    // print_r($_SESSION);
    ?>
    <<<<<<< HEAD
    <h1 style="margin-top: 20px" align="center">Tambah Biaya Operasional</h1>
    <hr>
    <form id="frm-biaya-operasional" action="#">
        <input type="hidden" name="val_tanggal" value="<?= date('Y-m-d H:i:s') ?>">
        <div class="card">
            <div class="card-info">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Referensi</label>
                        <div class="col-sm-8">
                            <input type="text" name="val_no_transaksi_reff" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Biaya</label>
                        <div class="col-sm-8">
                            <select name="val_kd_biaya" id="add-modal-val-kd-biaya" class="form-control">
                                <option selected="0">pilih jenis biaya</option>
                                <?php foreach ($biaya as $by => $value) : ?>
                                    <option value="<?php echo $value->kd_biaya; ?>">
                                        <?php echo $value->nama ?> </option>
                                    <?php endforeach; ?>
                                    <option value="" class="">+Tambah Jenis Biaya</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Jenis Bayar</label>
                            <div class="col-sm-8">
                                <select name="val_kd_jenis" class="form-control">
                                    <?php foreach ($jenis_bayar as $jb => $value) : ?>
                                        <option value="<?php echo $value->kd_jenis_bayar; ?>">
                                            <?php echo $value->nama ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kas</label>
                                <div class="col-sm-8">
                                    <select name="val_kd_kas" class="form-control">
                                        <?php foreach ($kas as $k => $value) : ?>
                                            <option value="<?php echo $value->kd_kas; ?>">
                                                <?php echo $value->no_rekening ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Divisi</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="val_kd_divisi" class="form-control">
                                        =======
                                        <h1 style="margin-top: 20px" align="center">Tambah Biaya Operasional</h1>
                                        <hr>
                                        <form id="frm-biaya-operasional" action="#">
                                            <div class="card">
                                                <div class="card-info">
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Referensi</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="val_no_transaksi_reff" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Biaya</label>
                                                            <div class="col-sm-8">
                                                                <select name="val_kd_biaya" id="add-modal-val-kd-biaya" class="form-control">
                                                                    <option selected="0">pilih..</option>
                                                                    <?php foreach ($biaya as $by => $value) : ?>
                                                                        <option value="<?php echo $value->kd_biaya; ?>">
                                                                            <?php echo $value->nama ?> </option>
                                                                        <?php endforeach; ?>
                                                                        <option value="" class="">+ Tambah Jenis Biaya</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Jenis Kirim</label>
                                                                <div class="col-sm-8">
                                                                    <select name="val_kd_jenis" class="form-control">
                                                                        <option value="3">JNE</option>
                                                                        <option value="4">J&T</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Kas</label>
                                                                <div class="col-sm-8">
                                                                    <select name="val_kd_kas" id="add-modal-val-kd-kas" class="form-control">
                                                                        <option selected="0">pilih nomor rekening</option>
                                                                        <?php foreach ($kas as $k => $value) : ?>
                                                                            <option value="<?php echo $value->kd_kas; ?>">
                                                                                <?php echo $value->kd_kas ?> </option>
                                                                            <?php endforeach; ?>
                                                                            <option value="" class="">+ Tambah Kas</option>
                                                                        </select>
                                                                    </div>
                                                                    >>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Divisi</label>
                                                                    <div class="col-sm-8">
                                                                        <select name="val_kd_divisi" class="form-control">
                                                                            <option value="1">Bank</option>
                                                                            <option value="0">ATM</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">Nomor</label>
                                                                    <div class="col-sm-8">
                                                                        <input type="text" name="val_nomor" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <<<<<<< HEAD
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Nominal</label>
                                                                <div class="col-sm-8">
                                                                    <input type="number" name="val_nominal" class="form-control">
                                                                    =======
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-3 col-form-label">Keterangan</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" name="val_keterangan" class="form-control">
                                                                        </div>
                                                                        >>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-sm-3 col-form-label">Nominal</label>
                                                                        <div class="col-sm-8">
                                                                            <input type="text" name="val_nominal" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="val_status" class="col-sm-3 col-form-label">Lampiran</label>
                                                                        <div class="col-sm-8">
                                                                            <div class="row">
                                                                                <img id="boadd" src="" style=" width: 100px; height:100px;">
                                                                            </div>
                                                                            <div class="row mt-2">
                                                                                <input type="file" name="val_lampiran" id="val_lampiran" onchange="addbo()">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <<<<<<< HEAD
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label">User</label>
                                                                    <div class="col-sm-8">
                                                                        <select name="val_kd_user" class="form-control">
                                                                            <option value="1">Admin</option>
                                                                            <option value="0">Pelanggan</option>
                                                                        </select>
                                                                        =======
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">User</label>
                                                                            <div class="col-sm-8">
                                                                                <select name="val_kd_kas" class="form-control">
                                                                                    <option value="1">Admin</option>
                                                                                    <option value="0">Pelanggan</option>
                                                                                </select>
                                                                            </div>
                                                                            >>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <<<<<<< HEAD
                                                        </div>
                                                        <input type="submit" name="btn_submit" value="Simpan" class="btn btn-sm btn-success"
                                                        style="padding-top: 10px; padding-bottom: 10px;"><i class="fa fa-pluscircle"></i>
                                                    </form>
                                                    <script>
                                                        function addbo() {
                                                            let frame = document.getElementById('boadd');
                                                            frame.src = URL.createObjectURL(event.target.files[0]);
                                                        }
// $('#kas-tes').change(function() {
//     alert($(this).val());
// })
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
                    location.href = `<?= base_url() ?>/load/view/biaya_operasional/transaksi`;
                }
                =======
                <input type="submit" name="btn_submit" value="Simpan" class="btn btn-sm btn-success" style="padding-top: 10px; padding-bottom: 10px;"><i class="fa fa-pluscircle"></i>
                </form>
                <script>
                function addbo() {
                    let frame = document.getElementById('boadd');
                    frame.src = URL.createObjectURL(event.target.files[0]);
                    >>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
                }
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
                                alert('success');
                                location.href = `<?= base_url() ?>/load/view/biaya_operasional/transaksi`;
                            }
                        }

                        <<<<<<< HEAD
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
                // alert(title_modal);
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('biaya');
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
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
    <input type="hidden" id="key-update" name="key_no_transaksi" value="<?= $edit_data->no_transaksi ?>">
    <div class="card">
        <div class="card-info">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <input type="text" name="val_tanggal" class="form-control" value="<?= $edit_data->tanggal ?>"
                        readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Referensi</label>
                    <div class="col-sm-8">
                        <input type="text" name="val_no_transaksi_reff" class="form-control"
                        value="<?= $edit_data->no_transaksi_reff ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Biaya</label>
                    <div class="col-sm-8">
                        <select name="val_kd_biaya" class="form-control">
                            <?php foreach ($biaya as $by => $value) : ?>
                                <option value="<?= $value->kd_biaya ?>"
                                    <?= ($edit_data->kd_biaya == $value->kd_biaya) ? 'selected' : '' ?>>
                                    <?php echo $value->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jenis Bayar</label>
                    <div class="col-sm-8">
                        <select name="val_kd_jenis" class="form-control">
                            <?php foreach ($jenis_bayar as $jb => $value) : ?>
                                <option value="<?= $value->kd_jenis_bayar ?>"
                                    <?= ($edit_data->kd_jenis == $value->kd_jenis_bayar) ? 'selected' : '' ?>>
                                    <?php echo $value->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">KAS</label>
                    <div class="col-sm-8">
                        <select name="val_kd_kas" class="form-control">
                            <?php foreach ($kas as $k => $value) : ?>
                                <option value="<?= $value->kd_kas ?>"
                                    <?= ($edit_data->kd_kas == $value->kd_kas) ? 'selected' : '' ?>>
                                    <?php echo $value->no_rekening ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Divisi</label>
                    <div class="col-sm-8">
                        <input type="text" name="val_kd_divisi" class="form-control" value="<?= $edit_data->kd_divisi ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nomor</label>
                    <div class="col-sm-8">
                        <input type="text" name="val_nomor" class="form-control" value="<?= $edit_data->nomor ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <input type="text" name="val_keterangan" class="form-control" value="<?= $edit_data->keterangan ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nominal</label>
                    <div class="col-sm-8">
                        <input type="number" name="val_nominal" class="form-control" value="<?= $edit_data->nominal ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="val_status" class="col-sm-3 col-form-label">Lampiran</label>
                    <div class="col-sm-8">
                        <div class="row">
                            <img id="boedit" src="" style=" width: 100px; height:100px;">
                        </div>
                        <div class="row mt-2">
                            <input type="file" name="val_lampiran" id="val_lampiran" onchange="editbo()">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">User</label>
                    <div class="col-sm-8">
                        <input type="text" name="val_kd_user" class="form-control" value="<?= $edit_data->kd_user ?>">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        function editbo() {
            let frame = document.getElementById('boedit');
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    =======
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
    >>>>>>> 6ad6aafd75f53267d4904fed1b16d003583d6c98
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