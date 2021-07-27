<?php
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary call-modal" id="add-modal" data-key="-1"><i class="fas fa-plus-circle"></i>
            Tambah <?= $page ?></button>
    </div>
</div>
<div class="card card-danger card-outline">
    <div class="card-body">
        <table class="table table-hover table-bordered table-striped" id="table-data">
            <thead class="bg-danger">
                <tr>
                    <th class="text-center">NO</th>
                    <th class="text-center">NO. REKENING</th>
                    <th class="text-center">SALDO AWAL</th>
                    <!-- <th>STATUS</th> -->
                    <!-- <th>LAMPIRAN</th> -->
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kas as $key => $value) : ?>
                <tr>
                    <td class="text-center"><?= ($key + 1) ?></td>
                    <td class="text-right"><?= $value->no_rekening ?></td>
                    <td class="text-right"><?= $value->saldo_awal ?></td>
                    <td class="text-center">
                        <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                            data-key='<?= $value->kd_kas ?>'><i
                                class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-warning btn-xs call-modal" data-key="<?= $value->kd_kas ?>"
                            id="edit-modal"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-xs delete" data-key="<?= $value->kd_kas ?>"><i
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
                data: `frm_table=kas&token=123`,
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
<!-- Form KAS -->
<div class="row">
    <!-- Tabel kas -->
    <div class="col-lg-12 mt-2">
        <div class="card card-info">
            <div class="card-body  ">
                <!-- Kolom kd_kas_reff  -->
                <div class="form-group row">
                    <label for="val_kd_kas_reff" class="col-sm-3 col-form-label">Kode Referensi</label>
                    <div class="col-sm-8" placeholder="Refferensi">
                        <input name="val_kd_kas_reff" class="form-control" id="kode-referensi" value="-">
                    </div>
                </div>
                <!-- End Kolom kd_kas_reff  -->

                <!-- Kolom nomor_rekening  -->
                <div class="form-group row">

                    <label for="val_nomor_rekening" class="col-sm-3 ">Nomor Rekening</label>
                    <div class="col-sm-8">
                        <input name="val_no_rekening" class="form-control" id="val_nomor_rekening"
                            placeholder="No. Rekening">
                    </div>
                </div>
                <!-- End olom nomor_rekening  -->

                <!-- Kolom saldo awal -->
                <div class="form-group row">
                    <label for="val_saldo_awal" class="col-sm-3 col-form-label">Saldo Awal</label>
                    <div class="col-sm-8">
                        <input type="number" min="0" value="0" name="val_saldo_awal" class="form-control"
                            id="val_saldo_awal" placeholder="Saldo Awal">
                    </div>
                </div>
                <!-- End Kolom saldo awal  -->

                <!-- Kolom status  -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="val_status">Status</label>
                    </div>
                    <div class="col-sm-2" id="radio-aktif">
                        <p><input type='radio' name="val_status" value='1' checked /> Aktif</p>
                    </div>
                    <div class="col-sm-2" id="radio-aktif1">
                        <p><input type='radio' name="val_status" value='0' /> Non-Akif</p>
                    </div>
                </div>
                <!-- End Kolom status  -->



                <!-- Kolom Lampiran  -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="val_status">Lampiran</label>
                    </div>
                    <div class="col-sm-6">
                        <img id="frame" src="" style=" width: 100px; height:100px;" />
                        <div class="row mt-2">
                            <div class="col">
                                <input type="file" name="val_lampiran" onchange="preview()">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Kolom Lampiran  -->
            </div>
        </div>
    </div>
    <!-- End Tabel kas -->
</div>
<script>
$(':input').click(function() {
    $(this).select();
});
</script>
<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<!-- Form KAS -->
<div class="row">
    <!-- Tabel kas -->
    <div class="col-lg-12 mt-2">
        <div class="card card-info">
            <div class="card-body  ">
                <input type="hidden" id="key-update" name="key_kd_kas" value="<?= $edit_data->kd_kas ?>">
                <!-- Kolom kd_kas_reff  -->
                <div class="form-group row">
                    <label for="val_kd_kas_reff" class="col-sm-3 col-form-label">Kode Referensi</label>
                    <div class="col-sm-8">
                        <input name="kd_kas_reff" class="form-control" id="kode-referensi"
                            value="<?= $edit_data->kd_kas_reff ?>" placeholder="Referensi">
                    </div>
                </div>
                <!-- End Kolom kd_kas_reff  -->

                <!-- Kolom nomor_rekening  -->
                <div class="form-group row">

                    <label for="val_nomor_rekening" class="col-sm-3 ">Nomor Rekening</label>
                    <div class="col-sm-8">
                        <input name="val_no_rekening" class="form-control" id="val_no_rekening"
                            value="<?= $edit_data->no_rekening ?>" placeholder="No. Rekening">
                    </div>
                </div>
                <!-- End olom nomor_rekening  -->

                <!-- Kolom saldo awal -->
                <div class="form-group row">
                    <label for="val_saldo_awal" class="col-sm-3 col-form-label">Saldo Awal</label>
                    <div class="col-sm-8">
                        <input type="number" min="0" value="0" name="val_saldo_awal" class="form-control"
                            id="val_saldo_awal" value="<?= $edit_data->saldo_awal ?>" placeholder="Saldo Awal">
                    </div>
                </div>
                <!-- End Kolom saldo awal  -->

                <!-- Kolom status  -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="val_status">Status</label>
                    </div>
                    <div class="col-sm-2" id="radio-aktif">
                        <p><input type='radio' name="val_status" value='1'
                                <?= ($edit_data->status == 1) ? 'checked' : '' ?> /> Aktif</p>
                    </div>
                    <div class="col-sm-2" id="radio-aktif1">
                        <p><input type='radio' name="val_status" value='0'
                                <?= ($edit_data->status == 0) ? 'checked' : '' ?> /> Non-Akif</p>
                    </div>
                </div>
                <!-- End Kolom status  -->



                <!-- Kolom Lampiran  -->
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="val_lampiran">Lampiran</label>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <img id="frame" src="" style=" width: 100px; height:100px;" />
                        </div>
                        <div class="row mt-2">
                            <input type="file" name="val_lampiran" onchange="preview()">
                        </div>
                    </div>
                </div>
                <!-- End Kolom Lampiran  -->
            </div>
        </div>
    </div>
    <!-- End Tabel kas -->
</div>
<!-- End Form KAS -->
<?php


} else {
    echo view('errors/html/error_404');
}

?>
<script>
function preview() {
    let frame = document.getElementById('frame');
    frame.src = URL.createObjectURL(event.target.files[0]);
}

function preview1() {
    let frame1 = document.getElementById('frame1');

    frame1.src = URL.createObjectURL(event.target.files[0]);
}

function previewImgModal() {
    let frame1 = document.getElementById('frame2');

    frame1.src = URL.createObjectURL(event.target.files[0]);
}
</script>