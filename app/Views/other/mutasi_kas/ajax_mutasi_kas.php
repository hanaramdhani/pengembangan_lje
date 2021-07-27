<?php
// print_r($kas);
date_default_timezone_set('Asia/Jakarta');
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <button class="btn btn-primary call-modal" id="add-modal" data-key="-1">
            <i class="fas fa-plus-circle"></i>
            Tambah Mutasi KAS
        </button>
    </div>
</div>
<div class="card card-danger card-outline">
    <div class="card-body">
        <table id="data-tampil" class="table table-bordered">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th scope="col">TANGGAL TRANSAKSI</th>
                    <th scope="col">KAS SUMBER</th>
                    <th scope="col">KAS TUJUAN</th>
                    <th scope="col">NOMINAL</th>
                    <th scope="col">BUKTI SUMBER</th>
                    <th scope="col">BUKTI TUJUAN</th>
                    <th scope="col">KETERANGAN</th>
                    <!-- <th scope="col">USER</th> -->
                    <!-- <th scope="col">TANGGAL</th> -->
                    <th scope="col"></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($mutasi_kas as $mk => $value): ?>
                <tr>
                    <td><?=$value->tanggal?></td>
                    <td><?=$value->sumber?></td>
                    <td><?=$value->tujuan?></td>
                    <td class="text-right"><?php echo number_format($value->nominal, 0, ',', '.')?></td>
                    <td><?=$value->no_bukti_sumber?></td>
                    <td><?=$value->no_bukti_tujuan?></td>
                    <td><?=$value->keterangan?></td>
                    <!-- <td><?=$value->kd_user?></td> -->
                    <!-- <td><?=$value->tanggal_server?></td> -->
                    <td>
                        <button class="btn btn-xs btn-warning call-modal" id="edit-modal"
                            data-key="<?=$value->no_transaksi?>">
                            <i class=" fa fa-edit"></i>
                        </button>
                        <button class="btn btn-xs btn-danger delete" data-key="<?=$value->no_transaksi?>">
                            <i class=" fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $('#data-tampil').DataTable();
});
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
            $('#m-crud-page').text('mutasi_kas');
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
                data: `frm_table=mutasi_kas&token=123`,
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
<input type="hidden" name="val_tanggal" value="<?=date('Y-m-d H:i:s')?>">
<input type="hidden" name="val_tanggal_server" value="<?=date('Y-m-d H:i:s')?>">
<input type="hidden" name="val_no_transaksi">
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kas Sumber</label>
    <div class="col-sm-8">
        <select name="val_kd_kas_sumber" class="form-control select2">
            <?php foreach ($kas as $ka => $value): ?>
            <option value="<?php echo $value->kd_kas; ?>"> <?php echo $value->no_rekening ?> </option>
            <?php endforeach;?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kas Tujuan</label>
    <div class="col-sm-8">
        <select name="val_kd_kas_tujuan" class="form-control select2">
            <?php foreach ($kas as $k => $value): ?>
            <option value="<?php echo $value->kd_kas; ?>"> <?php echo $value->no_rekening ?> </option>
            <?php endforeach;?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nominal <span class="col-sm-7"> Rp. </span> </label>
    <div class="col-sm-8">
        <input type="number" min="0" name="val_nominal" class="form-control allow-numeric" value="0">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Bukti Sumber</label>
    <div class="col-sm-8">
        <input type="text" name="val_no_bukti_sumber" class="form-control" placeholder="Bukti Sumber" value="-">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Bukti Tujuan</label>
    <div class="col-sm-8">
        <input type="text" name="val_no_bukti_tujuan" class="form-control" placeholder="Bukti Tujuan" value="-">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Keterangan</label>
    <div class="col-sm-8">
        <textarea placeholder="Keterangan" class="form-control" rows="2" name="val_keterangan">-</textarea>
    </div>
</div>
<input type="hidden" name="val_kd_user" class="form-control" value="<?=$_SESSION['kd_user']?>">
<script type="text/javascript">
$(".allow-numeric").bind("keypress", function(e) {
    var key = event.keyCode || event.which;
    let val = $(this).val().split('.').length;
    if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key > 96 && key < 123) || (key > 218 && key <
            223) || (key > 190 && key < 193) || (key == 165) || (key == 32) || (key == 37) || (key == 39) || (
            key == 164) || (key == 130) || (key == 181) || (key == 144) || (key == 214) || (key == 224) || (
            key == 233) || (key == 173) || (key == 61) || (key == 188) || (key == 59) || key == 189 || key ==
        187 || key == 190 || key == 44) {
        event.preventDefault();
    } else {
        if (key === 46 && val > 1) {
            event.preventDefault();
        } else {
            return true;
        }
    }
});
$('.select2').select2();
$(':input').click(function() {
    $(this).select();
});
</script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_no_transaksi" value="<?=$edit_data->no_transaksi?>">
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Tanggal Transaksi</label>
    <div class="col-sm-8">
        <input name="val_tanggal" value="<?=$edit_data->tanggal?>" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Rekening Sumber</label>
    <div class="col-sm-8">
        <select name="val_kd_kas_sumber" class="form-control">
            <?php foreach ($kas as $k => $value): ?>
            <option value="<?=$value->kd_kas?>" <?=($edit_data->kd_kas_sumber == $value->kd_kas) ? 'selected' : ''?>>
                <?php echo $value->no_rekening ?>
            </option>
            <?php endforeach;?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Rekening Tujuan</label>
    <div class="col-sm-8">
        <select name="val_kd_kas_tujuan" class="form-control">
            <?php foreach ($kas as $k => $value): ?>
            <option value="<?=$value->kd_kas?>" <?=($edit_data->kd_kas_tujuan == $value->kd_kas) ? 'selected' : ''?>>
                <?php echo $value->no_rekening ?>
            </option>
            <?php endforeach;?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nominal <span class="col-sm-7"> Rp. </span> </label>
    <div class="col-sm-8">
        <input type="number" min="0" name="val_nominal" class="form-control allow-numeric"
            value="<?=$edit_data->nominal?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Bukti Sumber</label>
    <div class="col-sm-8">
        <input type="text" name="val_no_bukti_sumber" class="form-control" value="<?=$edit_data->no_bukti_sumber?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Bukti Tujuan</label>
    <div class="col-sm-8">
        <input type="text" name="val_no_bukti_tujuan" class="form-control" value="<?=$edit_data->no_bukti_tujuan?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Keterangan</label>
    <div class="col-sm-8">
        <textarea placeholder="Keterangan" class="form-control" rows="2"
            name="val_keterangan"><?=$edit_data->keterangan?></textarea>
    </div>
</div>
<input type="hidden" name="val_kd_user" class="form-control" value="<?=$_SESSION['kd_user']?>">
<script type="text/javascript">
$(".allow-numeric").bind("keypress", function(e) {
    var key = event.keyCode || event.which;
    let val = $(this).val().split('.').length;
    if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key >= 95 && key < 123) || (key > 218 && key <
            223) || (key > 190 && key < 193) || (key == 130) || (key == 181) || (key == 144) || (key == 214) ||
        (key == 224) || (key == 233) || (key == 173) || (key == 61) || (key == 188) || (key == 59) || key ==
        189 || key == 187 || key == 190 || (key >= 91 && key <= 94) || key == 47 || key == 59 || (key >= 123 &&
            key <= 126) || key == 64 || (key >= 32 && key <= 44) || key == 58 || key == 63) {
        event.preventDefault();
    } else {
        if (key === 46 && val > 1) {
            event.preventDefault();
        } else {
            return true;
        }
    }
});
</script>
<?php
} else {
    echo view('errors/html/error_404');
}

?>