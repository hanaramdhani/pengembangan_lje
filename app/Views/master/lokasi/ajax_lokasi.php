<?php


if (isset($act) && $act == "view") {
    ?>
<link rel="stylesheet" href="<?= base_url('/sample_assets/style.css') ?>">

<div class="card">
    <div class="card-body">
        <a class="btn btn-primary call-modal" id="add-modal" data-key="-1"><i class="fas fa-plus-circle"></i> Tambah
            Lokasi</a>
    </div>
</div>
<div class="card card-danger card-outline">
    <div class="card-body">
        <table id="table-lokasi" class="table table-striped table-bordered">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>NO</th>
                    <th>KABUPATEN</th>
                    <th>NAMA</th>
                    <th>DESKRIPSI</th>


                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lokasi as $key => $value) : ?>
                <tr>
                    <td class="text-center"><?= $key + 1; ?></td>
                    <td><?= $value->kabupaten ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->deskripsi ?></td>
                    <td class="text-center">
                        <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                            data-key='<?= $value->kd_lokasi ?>'><i
                                class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                aria-hidden="true"></i>
                            <!-- <?= $value->status == 1 ? 'Aktif' : 'Nonaktif' ?> -->
                        </button>
                        <button class="btn btn-xs btn-warning call-modal" id="edit-modal"
                            data-key="<?= $value->kd_lokasi ?>"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-xs btn-danger delete" data-key="<?= $value->kd_lokasi ?>"><i
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
$(document).ready(function() {
    $('#table-lokasi').DataTable();
});
$('.show-image').click(function() {
    // $('#imagepreview').attr('src', '');
    // $('#imagepreview').removeClass('after-load');
    // $('#imagepreview').addClass('before-load');

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
        title_modal = "Tambah Lokasi Kirim";
    } else if (jenis_modal == "edit-modal") {
        act = "edit";
        title_modal = "Ubah Lokasi Kirim";
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
                data: `frm_table=lokasi&token=123`,
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
        <input name="kd_lokasi_reff" class="form-control" value="-" id="kd_lokasi_reff">
    </div>
</div>
<div class="form-group row">
    <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
    <div class="col-sm-10">
        <input name="val_kd_kabupaten" class="form-control" id="namaKabupaten" placeholder="Isikan Nama Kabupaten"
            required>
        <div id="kabupaten-list" style="z-index:999" class="position-relative"></div>
        <input type="hidden" id="kabupaten-list1" name="val_kd_kabupaten">

    </div>

    <style>
    .autocomplete_li:hover {
        background-color: #7FFFD4;
    }
    </style>

</div>


<!-- <div class="form-group-row">
        <div class="col-sm-10">
            <div id="kabupaten-list" class="position-relative"></div>
        </div>
    </div> -->




<div class="form-group row">
    <label for="val_nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input name="val_nama" class="form-control" id="nama" placeholder="Isikan Nama Lokasi">
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
        <p><input type='radio' name="val_status" value='1' checked /> Aktif</p>
    </div>
    <div class="col-sm-2" id="radio-aktif1">
        <p><input type='radio' name="val_status" value='0' /> Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-2">
        <label for="val_lampiran">Lampiran</label>
    </div>
    <div class="col-sm-8">
        <div class="row">
            <img id="frameELK1" src="" style=" width: 100px; height:100px;" />
        </div>
        <div class="row mt-2">
            <input type="file" name="val_lampiran" id="file" onchange="previewELK1()">
        </div>
    </div>
</div>

<script>
$(':input').click(function() {
    $(this).select();
});

function previewELK1() {
    let frame = document.getElementById('frameELK1');

    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<script type="text/javascript">
$('#namaKabupaten').keyup(function() {

    var query = $(this).val();
    // alert(query);
    if (query != '') {
        $.ajax({
            method: "POST",
            url: `<?= base_url() ?>/api/kabupaten_ac`,
            data: {
                token: 123,
                kabupaten_name: query
            },
            success: function(r) {
                console.log(r);
                $('#kabupaten-list').html(r);
                $('#kabupaten-list').fadeIn();
                complete_id(query);
                // $('#kabupaten-ac').addClass('z-index', '99');

            }
        });
    } else {
        $('#kabupaten-list').fadeOut();
    }
});
$(document).on('click', '.kabupaten-list', function() {
    $('#namaKabupaten').val($(this).text());
    $('#kabupaten-list1').val($(this).data('key'));
    $('#kabupaten-list').fadeOut();
});

function complete_id(search) {
    $('.autocomplete_li').each(function() {
        if ($(this).text().toUpperCase() == search.toUpperCase()) {
            $('#kabupaten-list1').val($(this).data('key'));
            $('#namaKabupaten').val($(this).text());
            $('#kabupaten-list').fadeOut();


        } else {
            // $('#kd-' + type).val('');
        }
    });
}
</script>
<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_kd_lokasi" value="<?= $edit_data->kd_lokasi ?>">
<div class=" form-group row">
    <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
    <div class="col-sm-10">
        <select id="val_kd_kabupaten" name="val_kd_kabupaten" class="form-control">
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
    <label for="val_nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="val_nama" id="nama" value="<?= $edit_data->nama ?>"><br>
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
    <div class="col-sm-8">
        <div class="row">
            <img id="frameELK" src="" style=" width: 100px; height:100px;" />
        </div>
        <div class="row mt-2">
            <input type="file" name="val_lampiran" id="file" onchange="previewELK()">
            <!-- <input type="file" name="val_lampiran" id="val_lampiran"> -->
        </div>
    </div>
</div>
<script>
function previewELK() {
    let frame = document.getElementById('frameELK');

    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
} else {
    echo view('errors/html/error_404');
}

?>