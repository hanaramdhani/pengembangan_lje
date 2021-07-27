<?php
if (isset($act) && $act == 'edit' && $modal) {
    // print_r($edit_data);

?>
<input type="hidden" id="key-update" name="key_nomor" value="<?= $edit_data->nomor ?>">


<div class="form-group row">
    <label class="col-sm-3 col-form-label">Jenis Kirim</label>
    <div class="col-sm-7">

        <input type="text" class="form-control" name="" value="<?= $edit_data->jenis_kirim ?>" readonly>
        <input type="hidden" name="val_kd_jenis" value="<?= $edit_data->kd_jenis ?>">
    </div>

</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Berat</label>


    <div class="col-sm-3">
        <input type="number" id="val_jumlah_berat" param="val_jumlah_berat" name="val_jumlah_berat"
            class="data-dt form-control" value="<?= $edit_data->jumlah_berat ?>" placeholder="Masukkan berat"
            onkeyup="resultberat()">
    </div>
    <div class="col-sm-6">
        <label class="col-form-label pr-2">Harga:</label>
        <label class="col-form-label"><strong id="harga-berat"><?= $kirim_selected->harga_berat ?></strong> (min. <span
                id="min-berat"><?= $kirim_selected->min_berat ?></span> kg)</label>
    </div>

    <input type="hidden" class="data-dt" value="<?= $kirim_selected->harga_berat ?>" id="harga_berat"
        param="harga_berat" onkeyup="resultberat()">
    <input type="hidden" class="data-dt" value="<?= $kirim_selected->min_berat ?>" id="min" param="min"
        onkeyup="resultberat()">
    <div class="col-md-6">
        <label id="label_harga_berat" class="form-label"></label>
    </div>
    <div>
        <input type="hidden" class="data-dt" readonly value="<?= $edit_data->harga_berat ?>" name="val_harga_berat"
            param="val_harga_berat" id="val_harga_berat">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Dimensi</label>
    <div class="row col-sm-7">
        <div class="col-sm-4">
            <input type="number" class="form-control data-dt" id="val_panjang" param="val_panjang" name="val_panjang"
                placeholder="Panjang" value="<?= $edit_data->panjang ?>" onkeyup="volume()">
        </div>
        <div class="col-sm-4">
            <input type="number" class="form-control data-dt" id="val_lebar" param="val_lebar" name="val_lebar"
                placeholder="Lebar" value="<?= $edit_data->lebar ?>" onkeyup="volume()">
        </div>
        <div class="col-sm-4">
            <input type="number" class="form-control data-dt" id="val_tinggi" param="val_tinggi" name="val_tinggi"
                placeholder="Tinggi" onkeyup="volume()" value="<?= $edit_data->tinggi ?>">
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Volume</label>
    <div class="col-sm-3">
        <input type="number" class="form-control" id="hrg_volume" name="hrg_volume" param="hrg_volume"
            onkeyup="resultvolume()" readonly>
    </div>
    <div class="col-sm-6">
        <label class="col-form-label pr-2">Harga:</label>
        <label class="col-form-label"><strong id="harga-berat"><?= $kirim_selected->harga_volume ?></strong> ( min.
            <span class="min-volume"><?= $kirim_selected->min_volume ?></span> &#13221; )</label>

    </div>
    <input type="hidden" id="harga_volume" value="<?= $kirim_selected->harga_volume ?>" onkeyup="resultvolume()">
    <input type="hidden" id="min_volum" value="<?= $kirim_selected->min_volume ?>" onkeyup="resultvolume()">
    <label id="label_harga_volume" class="form-label"></label>
    <input type="hidden" id="val_harga_volume" value="<?= $edit_data->harga_volume ?>" class="data-dt"
        name="val_harga_volume" param="val_harga_volume" onkeyup="resultsubtotal()">
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Subtotal</label>
    <div class="col-sm-7">
        <input type="text" class="form-control data-dt" id="val_subtotal" name="val_subtotal" onkeyup="total()"
            param="val_subtotal" readonly value="">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-3 col-form-label">Diskon</label>
    <div class="col-sm-7 row">
        <div class="col-sm-6">
            <input type="number" value="<?= $edit_data->diskon ?>" min="0" max="99" class="form-control data-dt"
                id="val_diskon" onkeyup="total()" param="val_diskon" name="val_diskon" placeholder="diskon(%)" value="">
        </div>
        <div class="col-sm-6">
            <label class="form-label">%</label>
        </div>
    </div>
</div>


<div class="form-group row">
    <label class="col-sm-3 col-form-label">Total</label>
    <div class="col-sm-7">
        <input type="text" class="form-control data-dt" id="val_total" name="val_total" param="val_total" value=""
            readonly>
    </div>
</div>

<input type="hidden" id="kd-layanan">
<input type="hidden" id="kd-kota-asal">
<input type="hidden" id="kd-kota-tujuan">

<script type="text/javascript">
$(function() {
    resultberat();
    resultsubtotal();
    volume();
    resultvolume();
    total();
});

function volume() {
    var panjang = document.getElementById('val_panjang').value;
    var lebar = document.getElementById('val_lebar').value;
    var tinggi = document.getElementById('val_tinggi').value;
    var result = parseInt(panjang) * parseInt(lebar) * parseInt(tinggi);
    if (!isNaN(result)) {
        document.getElementById('hrg_volume').value = result;
        resultvolume();
    };
}

function resultberat() {
    var berat = document.getElementById('val_jumlah_berat').value;
    var hrgberat = document.getElementById('harga_berat').value;
    var minimum = document.getElementById('min').value;
    var ber_min = parseInt(hrgberat) * parseInt(minimum);
    var rberat = parseInt(hrgberat) * parseInt(berat);
    var rminim = parseInt(minimum) * parseInt(berat);
    if (berat <= minimum) {
        if (!isNaN(ber_min)) {
            document.getElementById('val_harga_berat').value = ber_min;
        }
    } else {
        if (!isNaN(rberat)) {
            document.getElementById('val_harga_berat').value = rberat;
        }
    }
    resultsubtotal();
}

function resultvolume() {
    var volume = document.getElementById('hrg_volume').value;
    var hargavolume = document.getElementById('harga_volume').value;
    var min_volum = document.getElementById('min_volum').value;
    var result = parseInt(hargavolume) * parseInt(min_volum);
    var hasil = parseInt(volume) * parseInt(hargavolume);

    if (volume <= min_volum) {
        if (!isNaN(result)) {
            document.getElementById('val_harga_volume').value = result;
        }
    } else {
        if (!isNaN(hasil)) {
            document.getElementById('val_harga_volume').value = hasil;
        }
        resultsubtotal();
    }
}

function resultsubtotal() {
    var hargaberat = document.getElementById('val_harga_berat').value;
    var hargavolume = document.getElementById('val_harga_volume').value;
    var result = parseInt(hargaberat) + parseInt(hargavolume);
    if (!isNaN(result)) {
        document.getElementById('val_subtotal').value = result;
    }
}

function total() {
    var subtotal = document.getElementById('val_subtotal').value;
    var diskon = document.getElementById('val_diskon').value;
    var dskn = parseInt(subtotal) * (parseInt(diskon) / parseInt(100));
    var result = parseInt(subtotal) - parseInt(dskn);
    if (!isNaN(result)) {
        document.getElementById('val_total').value = result;
    }
}

$('#kd-jenis-edit').click(function() {
    document.getElementById('val_kd_jenis').value =
        document.getElementById('kd-jenis-edit').value;
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/get_ongkir`,
        data: {
            layanan: 12,
            lokasi_asal: 12,
            lokasi_tujuan: 13,
            jenis_kirim: 12,
            token: 123
        },
        dataType: 'JSON',
        success: function(r) {
            console.log(r);
            $('#label_harga_berat').html("Rp. " + r
                .harga_berat + " x " + r.min_berat);
            $('#label_harga_volume').html("Rp. " + r
                .harga_volume + " x " + r.min_volume);
            $('#harga_berat').val(r.harga_berat);
            $('#harga_volume').val(r.harga_volume);
            $('#min').val(r.min_berat);
            $('#min_volum').val(r.min_volume);
        }
    });

});
</script>


<?php
} else {
    echo view('errors/html/error_404');
}
?>