<?php


if (isset($act) && $act == "view") {

?>
    <link rel="stylesheet" href="<?= base_url('/sample_assets/style.css') ?>">
    <br>

    <form>
        <div class="row">
            <div class="col">
                <div class="card card-danger card-tabs">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kode Referensi</label>
                                    <div class="col-sm-9">
                                        <input name="val_nomor_reff" class="form-control" id="val_nomor_reff">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Jenis Bayar</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 data" style="width: 100%;" name="val_kd_jenis_bayar">
                                            <option selected="0">Pilih Jenis Bayar</option>
                                            <?php foreach ($jenis_bayar as $jb) : ?>
                                                <option value="<?php echo $jb->kd_jenis_bayar ?>"> <?php echo $jb->nama ?> </option>
                                            <?php endforeach; ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">ID Pengiriman</label>
                                    <div class="col-sm-9">
                                        <input name="val_no_pengiriman" class="form-control" id="val_no_pengiriman">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Kas</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 data" style="width: 100%;" name="val_kd_kas">
                                            <option selected="0">Pilih Kas</option>
                                            <?php foreach ($kas as $kas1) : ?>
                                                <option value="<?php echo $kas1->kd_kas ?>"> <?php echo $kas1->no_rekening ?> </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nominal</label>
                                    <div class="col-sm-9">
                                        <input name="val_nominal" class="form-control" id="val_nominal">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Lampiran</label>
                                    <div class="col-sm-8">
                                        <input class="data" type="file" name="val_lampiran">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="6" name="val_keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    </div>

    <div class="col-12">
        <button type="submit" id="send-ajax-array-js" name="simpan" style="display: block; margin: auto; width: max-content;" class="form-control btn-primary">Simpan</button>
    </div>

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
                title_modal = "Tambah Jenis Paket";
            } else if (jenis_modal == "edit-modal") {
                act = "edit";
                title_modal = "Ubah Jenis Paket ";
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
                        data: `frm_table=penagihan&token=123`,
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



<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
?>


<?php
} else {
    echo view('errors/html/error_404');
}

?>