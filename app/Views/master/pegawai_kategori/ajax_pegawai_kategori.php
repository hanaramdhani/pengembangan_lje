<script type="text/javascript">
$('#val-kd-kategori').change(function() {
    let value = $(this).val();
    if (value == "") {
        let key = $(this).data('key');
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah Kategori Pegawai";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/${act}/pegawai_kategori/${jenis}` + key + '/true',
            success: function(r) {
                // alert(title_modal);
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('pegawai_kategori');
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
if (isset($act) && $act == 'add' && $modal) {
?>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Kategori Referensi</label>
    <div class="col-sm-8">
        <input type="text" name="val_kd_kategori_reff" value="-" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Nama</label>
    <div class="col-sm-8">
        <input type="text" name="val_nama" placeholder="Masukkan Nama" class="form-control">
    </div>
</div>
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Deskripsi</label>
    <div class="col-sm-8">
        <textarea type="text" name="val_deskripsi" class="form-control">-</textarea>
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
    <div class="col-sm-3 col-form-label">
        <label for="val_status">Lampiran</label>
    </div>
    <div class="col-sm">
        <div class="row col-md-6">
            <img id="kat_pgw" src="" style=" width: 100px; height:100px;" />
        </div>
        <div class="row mt-2 col-md-6">
            <input type="file" name="val_lampiran" id="val_lampiran" onchange="pgw_kat()">
        </div>
    </div>
</div>

<script>
function pgw_kat() {
    let frame = document.getElementById('kat_pgw');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
}
?>