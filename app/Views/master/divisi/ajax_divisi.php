<?php
// print_r($divisi);
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-sm btn-primary call-modal" style="padding-top: 10px; padding-bottom: 10px;"
            id="add-modal" data-toggle="tooltip" data-placement="bottom" title="Tambah Data Divisi" data-key="-1">
            <i class="fa fa-plus-circle"></i> Tambah Divisi
        </button>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-pegawai" class="table table-striped table-bordered">
                <thead class="bg-danger">
                    <tr class="text-center">
                        <th scope="col">LOKASI</th>
                        <th scope="col">NAMA</th>
                        <th scope="col">DESKRIPSI</th>
                        <!-- <th scope="col">Status</th> -->
                        <!-- <th scope="col">Lampiran</th> -->
                        <th scope="col">REFERENSI</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($divisi as $div => $value) : ?>
                    <?php 
                            if ($value->kd_divisi!='-1') {
                                ?>
                    <tr>
                        <td class="text-left"><?= $value->kd_divisi_reff ?></td>
                        <td class="text-left"><?= $value->lokasi ?></td>
                        <td class="text-left"><?= $value->nama ?></td>
                        <td class="text-left"><?= $value->deskripsi ?></td>

                        <td class="text-center">

                            <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?>"
                                data-toggle="tooltip" data-placement="bottom" title="Lihat"
                                data-key='<?= $value->kd_divisi ?>'><i
                                    class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                    aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-xs btn-warning call-modal" data-toggle="tooltip"
                                data-placement="bottom" title="Edit Data" data-key="<?= $value->kd_divisi ?>"
                                id="edit-modal">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-xs btn-danger delete" data-toggle="tooltip" data-placement="bottom"
                                title="Hapus Data" data-key="<?= $value->kd_divisi ?>">
                                <i class=" fa fa-trash"></i>
                            </button>
                            <button
                                class="btn btn-xs <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>">
                                <i class="fa fa-image"></i>
                            </button>



                        </td>
                    </tr>
                    <?php
                            }

                            ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#table-pegawai').DataTable();
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
            $('#m-crud-page').text('divisi');
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
                data: `frm_table=divisi&token=123`,
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
    <label class="col-sm-3 col-form-label">Devisi Referensi</label>
    <div class="col-sm-8">
        <input type="text" id="val_kd_divisi_reff" name="val_kd_divisi_reff" value="-" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Lokasi</label>
    <div class="col-sm-8">
        <select name="val_kd_lokasi" class="form-control select2">
            <?php foreach ($lokasi as $loc => $value) : ?>
            <option value="<?php echo $value->kd_lokasi; ?>"><?php echo $value->nama ?> </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col-sm-8">
        <input type="text" id="val_nama" placeholder="Masukkan Nama" name="val_nama" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Deskripsi</label>
    <div class="col-sm-8">
        <textarea id="val_deskripsi" name="val_deskripsi" class="form-control">-</textarea>
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-2 col-md-3 col-md-3 col-form-label">Status</label>
    <div class="col-sm-2" id="radio-aktif">
        <p><input type='radio' name="val_status" value='1' checked> Aktif</p>
    </div>
    <div class="col-sm-2" id="radio-aktif1">
        <p><input type='radio' name="val_status" value='0' /> Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-3 col-form-label">Lampiran</label>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="devisiadd" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="adddevisi()">
        </div>
    </div>
</div>
<script>
$(':input').click(function() {
    $(this).select();
});
$('.select2').select2();

function adddevisi() {
    let frame = document.getElementById('devisiadd');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_kd_divisi" value="<?= $edit_data->kd_divisi ?>">

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Devisi Referensi</label>
    <div class="col-sm-8">
        <input type="text" id="val_kd_divisi_reff" name="val_kd_divisi_reff" class="form-control"
            value="<?= $edit_data->kd_divisi_reff ?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Lokasi</label>
    <div class="col-sm-8">
        <select name="val_kd_lokasi" id="val_kd_lokasi" class="form-control select2">
            <?php foreach ($lokasi as $loc => $value) : ?>
            <option value="<?= $value->kd_lokasi ?>"
                <?= ($edit_data->kd_lokasi == $value->kd_lokasi) ? 'selected' : '' ?>>
                <?php echo $value->nama ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col-sm-8">
        <input type="text" id="val_nama" name="val_nama" class="form-control" value="<?= $edit_data->nama ?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Deskripsi</label>
    <div class="col-sm-8">
        <textarea id="val_deskripsi" name="val_deskripsi"
            class="form-control"><?php echo $edit_data->deskripsi ?></textarea>
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
    <label for="val_status" class="col-sm-3 col-form-label">Lampiran</label>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="devisiedit" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="editdevisi()">
        </div>
    </div>
</div>
<script>
$('.select2').select2()

function editdevisi() {
    let frame = document.getElementById('devisiedit');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
} else {
    echo view('errors/html/error_404');
}

?>