<?php
if (isset($act) && $act == 'add' && $modal) {
?>

    <!--  Kolom No Tagihan  -->
    <div class="form-group row" hidden>
        <label for="val_no_tagihan" class="col-sm-2 col-form-label">No Tagihan</label>

        <div class="col-sm-10">
            <input class="form-control data-dt" id="val_no_tagihan" name="val_no_tagihan" value="">
        </div>

    </div>
    <!--  End Kolom No Tagihan  -->

    <!--  Kolom No Pengiriman  -->
    <div class="form-group row">
        <label for="val_no_pengiriman" class="col-sm-2 col-form-label">No Pengiriman</label>
        <div class="col-sm-10">

            <input class="form-control data-dt" id="val_no_pengiriman" name="val_no_pengiriman" value="">

        </div>
    </div>
    <!--  End Kolom No Pengiriman  -->

    <!--  Kolom Keterangan  -->
    <div class="form-group row">
        <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <textarea id="val_keterangan" rows="5" name="val_keterangan" class="form-control"></textarea>
        </div>
    </div>
    <!--  End Kolom Keterangan -->


    <!--  Kolom Status -->
    <div class="form-group row" hidden>
        <div class="col-sm-2">
            <label for="val_status">Status</label>
        </div>
        <div class="col-sm-2" id="radio-aktif">
            <p><input type='radio' name="val_status" value="1" checked /> Aktif</p>
        </div>
        <div class="col-sm-2" id="radio-aktif1">
            <p><input type='radio' name="val_status" value="0" /> Non-Akif</p>
        </div>
    </div>
    <!-- End Kolom Status -->
<?php

} else if (isset($act) && $act == 'edit' && $modal) {
?>
    <input type="hidden" id="key-update" name="key_nomor" value="<?= $edit_data->nomor ?>">

    <!--  Kolom No Tagihan  -->
    <div class="form-group row" hidden>
        <label for="val_no_tagihan" class="col-sm-2 col-form-label">No Tagihan</label>

        <div class="col-sm-10">
            <input class="form-control data-dt" id="val_no_tagihan" name="val_no_tagihan" value="<?= $edit_data->no_tagihan ?>">
        </div>

    </div>
    <!--  End Kolom No Tagihan  -->

    <!--  Kolom No Pengiriman  -->
    <div class="form-group row">
        <label for="val_no_pengiriman" class="col-sm-2 col-form-label">No Pengiriman</label>
        <div class="col-sm-10">

            <input class="form-control data-dt" id="val_no_pengiriman" name="val_no_pengiriman" value="<?= $edit_data->no_pengiriman ?>">

        </div>
    </div>
    <!--  End Kolom No Pengiriman  -->

    <!--  Kolom Keterangan  -->
    <div class="form-group row">
        <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <textarea id="val_keterangan" rows="5" name="val_keterangan" class="form-control"><?= $edit_data->keterangan ?></textarea>
        </div>
    </div>
    <!--  End Kolom Keterangan -->


    <!--  Kolom Status -->
    <div class="form-group row" hidden>
        <div class="col-sm-2">
            <label for="val_status">Status</label>
        </div>
        <div class="col-sm-2" id="radio-aktif">
            <p><input type='radio' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'checked' : '' ?> /> Aktif</p>
        </div>
        <div class="col-sm-2" id="radio-aktif1">
            <p><input type='radio' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'checked' : '' ?> /> Non-Akif</p>
        </div>
    </div>
    <!-- End Kolom Status -->
<?php
} else {
    echo view('errors/html/error_404');
}

?>