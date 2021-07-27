<?php
if (isset($type) && $type == 'cari_customer') {
    // print_r($customer);
?>

    <?php foreach ($customer as $cs => $value) : ?>
        <input type="hidden" value="<?php echo $value->kd_customer ?>" id="customer-id-<?php echo $cs ?>">
        <input type="hidden" value="<?php echo $value->nama ?>" id="customer-name-<?php echo $cs ?>">
        <input type="hidden" value="<?php echo $value->alamat ?>" id="customer-alamat-<?php echo $cs ?>">
        <input type="hidden" value="<?php echo $value->hp ?>" id="customer-hp-<?php echo $cs ?>">
        <input type="hidden" value="<?php echo $value->kabupaten ?>" id="customer-kabupaten-<?php echo $cs ?>">
        <button type="button" data-id="<?php echo $cs ?>" class="btn btn-sm panggil cari" id="pilih-customer" data-dismiss="modal" data-key="<?= $value->kd_customer ?>" style="border: solid darkgray 1px; height: 80px; width: 100%; margin-top: 10px;">
            <div class="row">
                <div class="col-md-2 mt-4">
                    <i class="fas fa-image text-center"></i>
                </div>
                <div class="col-md-3">
                    <li style="padding: 1px; font-size: 16px; text-align: left; list-style: none;">
                        <strong><?php echo $value->nama ?></strong>
                    </li>
                    <li style="padding: 1px; text-align: left; list-style: none;"><?php echo $value->hp ?></li>
                    <li style="padding: 1px; text-align: left; list-style: none;"><?php echo $value->kabupaten ?></li>
                </div>
            </div>
        </button>


    <?php endforeach; ?>


    <script>
        $('.panggil').on('click', function() {

            let key = $(this).data('key');
            let jenis_modal = $(this).attr('id');
            let title_modal = "";
            let id = $(this).data('id');
            let tujuan = $('#m-customer').text();
            // alert(tujuan);
            if (tujuan == "pengirim") {
                // alert($("#customer-id-" + id).val())
                $('#val_kd_customer').val($("#customer-id-" + id).val());
                $('#val_nama_pengirim').val($("#customer-name-" + id).val());
                $('#val_alamat_pengirim').val($("#customer-alamat-" + id).val());
                $('#val_kabupaten_pengirim').val($("#customer-kabupaten-" + id).val());
                $('#val_hp_pengirim').val($("#customer-hp-" + id).val());
                $('#pengirim-text').text($("#customer-name-" + id).val());
            } else {
                $('#val_kd_customer').val($("#customer-id-" + id).val());
                $('#val_nama_penerima').val($("#customer-name-" + id).val());
                $('#val_alamat_penerima').val($("#customer-alamat-" + id).val());
                $('#val_kabupaten_penerima').val($("#customer-kabupaten-" + id).val());
                $('#val_hp_penerima').val($("#customer-hp-" + id).val());
                $('#penerima-text').text($("#customer-name-" + id).val());
            }
        });
    </script>

<?php
}
?>

<script>

</script>