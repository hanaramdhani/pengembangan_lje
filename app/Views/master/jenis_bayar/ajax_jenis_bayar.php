<?php
// print_r($divisi);
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary call-modal" id="add-modal" data-toggle="tooltip" data-placement="bottom"
            title="Tambah Data Jenis Bayar" data-key="-1">
            <i class="fas fa-plus-circle"></i>
            Tambah
        </button>
    </div>
</div>
<div class="card card-danger card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-condensed" id="tampil-data">
                <thead>
                    <tr>
                        <th>Jenis Bayar Referensi</th>
                        <th>Nama</th>
                        <!-- <th>Status</th> -->
                        <!-- <th>Lampiran</th> -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jenis_bayar as $jb => $value): ?>
                    <tr>
                        <td><?=$value->kd_jenis_bayar_reff?></td>
                        <td><?=$value->nama?></td>
                        <!-- <td class="text-center">
                                    <button class="w-50 btn btn-xs <?=$value->status == 1 ? 'btn-success' : 'btn-danger'?>"
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="Lihat Gambar"><?=$value->status == 1 ? 'Aktif' : 'Nonaktif'?>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button data-key="<?=$value->lampiran?>" class="btn btn-xs btn-info w-50">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td> -->
                        <td>
                            <button
                                class="btn btn-xs <?=$value->status == 1 ? 'btn-success' : 'btn-danger'?> edit-status"><i
                                    class="fa <?=$value->status == 1 ? 'fa-check-circle' : 'fa-ban'?>"
                                    aria-hidden="true"></i>
                                <!-- <?=$value->status == 1 ? 'Aktif' : 'Nonaktif'?> -->
                            </button>
                            <button class="btn btn-xs btn-warning call-modal" data-key="<?=$value->kd_jenis_bayar?>"
                                data-toggle="tooltip" data-placement="bottom" title="Edit Data" id="edit-modal">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-xs btn-danger delete" data-toggle="tooltip" data-placement="bottom"
                                title="Hapus Data" data-key="<?=$value->kd_jenis_bayar?>">
                                <i class=" fa fa-trash"></i>
                            </button>
                            <button
                                class="btn btn-xs <?=$value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled'?>"><i
                                    class="fa fa-image"></i></button>
                        </td>
                    </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>
</div>





<script type="text/javascript">
$('#tampil-data').DataTable();
$('.call-modal').click(function() {
    let key = $(this).data('key');
    let page = `<?=$page?>`;
    let jenis = `<?=$jenis?>`;
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
        url: `<?=base_url()?>/ajax_load/${act}/${page}/${jenis}` + key + '/true',
        success: function(r) {
            $('#m-crud-title').text(title_modal);
            $('#m-crud-key').text(key);
            $('#m-crud-act').text(act);
            $('#m-crud-page').text('jenis_bayar');
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
                url: `<?=base_url()?>/api/delete/` + key_delete,
                data: `frm_table=jenis_bayar&token=123`,
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
    <label class="col-sm-3 col-form-label">Kode Referensi</label>
    <div class="col-sm-8">
        <input type="text" id="val_kd_jenis_bayar_reff" value="-" name="val_kd_jenis_bayar_reff" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col-sm-8">
        <input type="text" id="val_nama" placeholder="Masukkan nama" name="val_nama" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-3 col-form-label">Status</label>
    <div class="col-sm-3" id="radio-aktif">
        <p><input type='radio' name="val_status" value="1" checked> Aktif</p>
    </div>
    <div class="col-sm-3" id="radio-aktif1">
        <p><input type='radio' name="val_status" value="0">Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-3 col-form-label">Lampiran</label>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="jbadd" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="addjb()">
        </div>
    </div>
</div>
<script>
function addjb() {
    let frame = document.getElementById('jbadd');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_kd_jenis_bayar" value="<?=$edit_data->kd_jenis_bayar?>">

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Jenis Bayar Referensi</label>
    <div class="col-sm-8">
        <input type="text" id="val_kd_jenis_bayar_reff" name="val_kd_jenis_bayar_reff" class="form-control"
            value="<?=$edit_data->kd_jenis_bayar_reff?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col-sm-8">
        <input type="text" id="val_nama" name="val_nama" class="form-control" value="<?=$edit_data->nama?>">
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-3 col-form-label">Status</label>
    <div class="col-sm-3" id="radio-aktif">
        <p><input type='radio' name="val_status" value="1" <?=($edit_data->status == '1') ? 'checked' : ''?>> Aktif
        </p>

    </div>
    <div class="col-sm-3" id="radio-aktif1">
        <p><input type='radio' name="val_status" value="0" <?=($edit_data->status == '0') ? 'checked' : ''?>>
            Non-Akif</p>
    </div>
</div>
<div class="form-group row">
    <label for="val_status" class="col-sm-3 col-form-label">Lampiran</label>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="jbedit" src="" style=" width: 100px; height:100px;">
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="editjb()">
        </div>
    </div>
</div>
<script>
function editjb() {
    let frame = document.getElementById('jbedit');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>


<?php
} else {
    echo view('errors/html/error_404');
}

?>