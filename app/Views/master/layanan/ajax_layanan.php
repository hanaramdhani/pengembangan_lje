<?php


if (isset($act) && $act == "view") {
?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary call-modal" id="add-modal" data-key="-1"><i class="fas fa-plus-circle"></i>
            Tambah Layanan</button>
    </div>
</div>

<div class="card card-outline card-danger">
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped" id="table-data">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>NO</th>
                    <th>NAMA</th>
                    <th>KETERANGAN</th>

                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($layanan as $key => $value) : ?>
                <tr>
                    <td class="text-center"><?= $key + 1; ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->keterangan ?></td>

                    <td class="text-center">
                        <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                            data-key='<?= $value->kd_layanan ?>'><i
                                class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                aria-hidden="true"></i>
                            <!-- <?= $value->status == 1 ? 'Aktif' : 'Nonaktif' ?> -->
                        </button>
                        <button class="btn btn-xs btn-warning call-modal" id="edit-modal"
                            data-key="<?= $value->kd_layanan ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-xs btn-danger delete" data-key="<?= $value->kd_layanan ?>"><i
                                class="fas fa-trash"></i></button>
                    </td>

                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>


    <script>
    $(document).ready(function() {
        $('#table-data').DataTable();
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
        swal_delete('layanan', key_delete);
    });

    function swal_delete(table, key) {
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
                    url: `<?= base_url() ?>/api/delete/` + key,
                    data: `frm_table=${table}&token=<?= $_SESSION['token'] ?>`,
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
    }
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
    });
    </script>
    <?php

} elseif (isset($act) && $act == 'add' && $modal) {
    ?>
    <div class="form-group row">
        <label for="val_kd_layanan_reff" class="col-sm-2 col-form-label">Kode Referensi</label>
        <div class="col-sm-10">
            <input name="val_kd_kirim_reff" class="form-control data" id="kode-referensi" value="-">
        </div>
    </div>
    <div class="form-group row">
        <label for="val_nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input name="val_nama" class="form-control" id="nama" placeholder="Masukan jenis layanan pengiriman">
        </div>
    </div>
    <div class="form-group row">
        <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="10" name="val_keterangan">-</textarea>
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


    <script type="text/javascript">
    $(':input').click(function() {
        $(this).select();
    });
    </script>
    <?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
    <input type="hidden" id="key-update" name="key_kd_layanan" value="<?= $edit_data->kd_layanan ?>">
    <div class="form-group row">
        <label for="val_nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input name="val_nama" class="form-control" id="nama" value="<?= $edit_data->nama ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <textarea id="val_keterangan" rows="10" name="val_keterangan"
                class="form-control"><?= $edit_data->keterangan ?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2">
            <label for="val_status">Status</label>
        </div>
        <div class="col-sm-2" id="radio-aktif">
            <p><input type='radio' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'checked' : '' ?> />
                Aktif</p>
        </div>
        <div class="col-sm-2" id="radio-aktif1">
            <p><input type='radio' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'checked' : '' ?> />
                Non-Akif</p>
        </div>
    </div>

    </form>

    <?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
    <input type="hidden" id="key-update" name="key_kd_layanan" value="<?= $edit_data->kd_layanan ?>">
    <div class="form-group row">
        <label for="val_nama" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="val_nama" class="form-control" id="val_nama" value="<?= $edit_data->nama ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <input type="text" name="val_keterangan" class="form-control" id="val_keterangan"
                value="<?= $edit_data->keterangan ?>">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2">
            <label for="val_status">Status</label>
        </div>
        <div class="col-sm-2" id="radio-aktif">
            <p><input type='radio' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'selected' : '' ?> />
                Aktif
            </p>
        </div>
        <div class="col-sm-2" id="radio-aktif1">
            <p><input type='radio' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'selected' : '' ?> />
                Non-Akif</p>
        </div>
    </div>


    <?php
} else {
    echo view('errors/html/error_404');
}

    ?>