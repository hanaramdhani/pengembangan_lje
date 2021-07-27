<?php


if (isset($act) && $act == "view") {
    date_default_timezone_set('Asia/Jakarta');
    echo "<pre>";
    print_r($data_pengiriman);
    echo "</pre>";
?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <br>
    <script type="text/javascript">
        $(function() {
            first_load();
        })

        function first_load() {
            // alert('a');

            if ($("#head-cb").prop('checked') == true) {
                // console.log("AKTIF")
                $(".cb-child").prop('checked', true)
            } else {
                // console.log("GA AKTIF")
                $(".cb-child").prop('checked', true)
            }
    </script>
    <form id="myform" method="post">

        <div class="row">
            <div class="col">
                <div class="card card-danger card-tabs">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kode Referensi</label>
                                    <div class="col-sm-9">
                                        <input name="val_kd_kirim_reff" class="form-control" id="val_kd_kirim_reff">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nomor</label>
                                    <div class="col-sm-8">
                                        <input name="val_nomor" class="form-control" id="val_nomor">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="val_tanggal" value="<?= date('Y-m-d H:i:s') ?>">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Pegawai</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 data" style="width: 100%;" name="val_kd_pegawai">
                                            <option selected="0">Pilih Pegawai</option>
                                            <?php foreach ($pegawai as $pk) : ?>
                                                <option value="<?php echo $pk->kd_pegawai; ?>"> <?php echo $pk->nama ?>
                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Divisi</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2 data" style="width: 100%;" name="val_kd_divisi">
                                            <option selected="0">Pilih Divisi</option>
                                            <?php foreach ($divisi as $ds) : ?>
                                                <option value="<?php echo $ds->kd_divisi; ?>"> <?php echo $ds->nama ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Customer</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 data" style="width: 100%;" name="val_kd_custmer">
                                            <option selected="0">Pilih Customer</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="datepicker" name="val_tanggal">
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
                            <div class="col-12 col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Lampiran</label>
                                    <div class="col-sm-4">
                                        <input class="data" type="file" name="val_lampiran">
                                    </div>
                                </div>
                                <div class="col-10 col-sm-6">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label for="val_status">Status</label>
                                        </div>
                                        <div class="col-4" id="radio-aktif">
                                            <p><input type='radio' name="val_status" value="1" /> Aktif</p>
                                        </div>
                                        <div class="col-4" id="radio-aktif1">
                                            <p><input type='radio' name="val_status" value="0" /> Non-Akif</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="title col-10">
                        <h3 style="text-align: left;">Detail Paket</h3>
                    </div>
                    <div class="tambah-detail col-2">
                        <button type="submit" id="tambah-detail" style="margin-left: auto;" name="tambah-detail" class="form-control btn btn-success">Tambah</button>
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 mt-2 mr-8">

                            <div class="form-group row">


                                <table id="table-penagihan" class="table table-striped table-bordered">
                                    <thead class="bg-danger">
                                        <tr style="text-align: center;">
                                            <th width="5px"><input type="checkbox" id="head-cb"></th>
                                            <th>No Transaksi</th>
                                            <th>Jumlah Item</th>
                                            <th>Berat</th>
                                            <th>From to</th>
                                            <th>Tujuan</th>
                                            <th>Harga Berat</th>
                                            <th>Volume</th>
                                            <th>Harga Volume</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data_pengiriman as $key => $value) : ?>
                                            <tr>
                                                <td><input type="checkbox" class="cb-child"></td>
                                                <td><?= $value->no_transaksi ?></td>
                                                <td><?= $value->jumlah_item ?></td>
                                                <td><?= $value->berat ?></td>
                                                <td><?= $value->from_to ?></td>
                                                <td><?= $value->tujuan ?></td>
                                                <td><?= $value->harga_berat ?></td>
                                                <td><?= $value->volume ?></td>
                                                <td><?= $value->harga_volume ?></td>
                                                <td><?= $value->subtotal ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>

                                <div class="col-12">
                                    <button type="submit" name="btn_submit" value="Simpan" style="display: block; margin: auto; width: max-content;" class="form-control btn-primary">Simpan</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


    </form>
    <script>
        $(document).ready(function() {
            $('#table-penagihan').DataTable();
        });
    </script>

    <script>
        $("#head-cb").on('click', function() {
            if ($("#head-cb").prop('checked') == true) {
                console.log("AKTIF")

                $(".cb-child").prop('checked', true)
            } else {
                // console.log("GA AKTIF")
                $(".cb-child").prop('checked', false)
            }
        })
        $("#table-penagihan").on('click', '.cb-child', function() {
            console.log("KLIK KA")
            // console.log($(this))

            if ($(this).prop('checked') != true) {
                $("#head-cb").prop('checked', false)
            }
        })
    </script>







    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
    </div>
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