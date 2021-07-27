<?php
if (isset($act) && $act == 'edit' && $modal) {
    // print_r($edit_data);

?>
<input type="hidden" id="key-update" name="key_nomor" value="<?= $edit_data->nomor ?>">

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nomor Pengiriman</label>
    <div class="col-sm-7">
        <input type="text" class="form-control" name="val_no_pengiriman" value="<?= $edit_data->no_pengiriman ?>">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Deskripsi</label>
    <div class="col-sm-7">
        <textarea type="text" class="form-control" name="val_deskripsi"><?= $edit_data->deskripsi ?></textarea>
    </div>
</div>



<?php
} else {
    echo view('errors/html/error_404');
}
?>