<script type="text/javascript">
$('#val-kd-biaya').change(function() {
    let value = $(this).val();
    if (value == "") {
        let key = $(this).data('key');
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah Kategori Customer";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/${act}/biaya/${jenis}` + key + '/true',
            success: function(r) {
                // alert(title_modal);
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('biaya');
                $('#m-crud-jenis').text(jenis);
                $('#m-container-crud').html(r);
                $(
                    '#modal-crud').modal('show');
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
<div class="form-group">
    <label>Nama</label>
    <input class="form-control" type="text" name="val_nama" placeholder="Nama">
</div>
<div class="form-group">
    <label>Keterangan</label>
    <textarea name="val_keterangan" class="form-control" placeholder="Keterangan">-</textarea>

</div>
<div class="form-group">
    <label>Status</label>
    <select name="val_status" class="form-control">
        <option value="1">Aktif</option>
        <option value="0">Non-Aktif</option>
    </select>
</div>
<div class="form-group">
    <label>Kode Refferensi</label>
    <input class="form-control" type="text" name="val_kd_biaya_reff" placeholder="Kode Refferensi" value="-">
</div>
<!-- Kolom Lampiran  -->
<div class="form-group row">
    <div class="col-sm-2">
        <label for="val_status">Lampiran</label>
    </div>
    <div class="col-sm-10">
        <div class="row">
            <img id="frame" src="" style=" width: 100px; height:100px;" />
        </div>
        <div class="row mt-2">
            <input type="file" name="val_lampiran" id="file" onchange="preview()">
        </div>
    </div>
</div>

<script>
function preview() {
    let frame = document.getElementById('frame');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
<?php
}
?>