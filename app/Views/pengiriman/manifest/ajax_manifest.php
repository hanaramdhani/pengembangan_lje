<?php if (isset($act) && $act == "view") { ?>
    <link rel="stylesheet" href="<?= base_url('/sample_assets/style.css') ?>">

    <div class="card card-danger card-outline">
        <div class="card-body">
        </div>
    </div>

    <a class="btn btn-danger" href="<?= site_url('load/add/manifest/pengiriman') ?>"> Tambah Data</a>
    <br>
    <hr>
    <table id="table-bayar" class="table table-striped table-bordered">
        <thead class="bg-danger">
            <tr>
                <th>No Transaksi</th>
                <th>Kota Asal</th>
                <th>Kota Tujuan</th>
                <th>Tanggal Berangkat</th>
                <th>Tanggal Sampai</th>
                <th>Nomor</th>
                <th>Kendaraan</th>
                <th>Kontak</th>
                <th>Keterangan</th>
                <th>Lampiran</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <?php foreach ($data_pengiriman_manifest_out as $data => $value) : ?>
                    <td><?= $value->no_transaksi ?></td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                    <td>#</td>
                <?php endforeach; ?>
                <td>

                    <button class="btn btn-primary call-modal" id="edit-modal" data-key="">
                        <i class="fa fa-pencil-alt"></i>
                    </button>
                    <button class="btn btn-danger delete" data-key=""> <i class="fa fa-trash"></i></button>
                </td>
            </tr>

        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('#table-bayar').DataTable();
        });
    </script>





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
                title_modal = "Tambah Data Manifest";
            } else if (jenis_modal == "edit-modal") {
                act = "edit";
                title_modal = "Ubah Data Manifest ";
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
                        data: `frm_table=manifest&token=123`,
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
} elseif (isset($act) && $act == "add" && !$modal) {
    // print_r($_SESSION);
    // echo "<pre>";
    // print_r($data_pengiriman_manifest_out);
    // echo "</pre>";
?>

    <br>
    <form id="frm-manifest" action="#">
        <div class="row">
            <div class="col">
                <div class="card card-danger card-tabs">

                    <div class="card-body">
                        <div class="card-body">
                            <div class="tab-content" id="tab-pengirimanContent">

                                <!-- form data pengiriman -->
                                <input type="hidden" id="val_tanggal" name="val_tanggal" class="data" value="<?= date('Y-m-d H:i:s') ?>">
                                <!-- dsr -->
                                <div class="tab-pane fade active show" id="tab-pengiriman-dsr-form" role="tabpanel" aria-labelledby="tab-pengiriman-dsr">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class=" form-group row">
                                                <label class="col-sm-4 col-form-label">Kode Referensi</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control data" id="val_no_transaksi_reff" name="val_no_transaksi_reff" value="-" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="subject" class="col-sm-4 col-form-label">Divisi Tujuan</label>
                                                <div class="col-sm-7">
                                                    <select name="val_kd_kas" id="val_kd_kas" class="form-control data">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="subject" class="col-sm-4 col-form-label">Divisi Asal</label>
                                                <div class="col-sm-7">
                                                    <select name="val_kd_divisi" id="val_kd_divisi" param="val_kd_divisi" class="form-control data">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="subject" class="col-sm-4 col-form-label">Tanggal
                                                    berangkat</label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control data" id="val_no_transaksi_reff" name="val_no_transaksi_reff" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="subject" class="col-sm-4 col-form-label">Tanggal Sampai</label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control data" id="val_no_transaksi_reff" name="val_no_transaksi_reff" required>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="val_status" class="col-sm-3 col-form-label">Kendaraan</label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control data" id="val_no_transaksi_reff" name="val_no_transaksi_reff" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="subject" class="col-sm-3 col-form-label">Kontak</label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control data" id="val_no_transaksi_reff" name="val_no_transaksi_reff" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Keterangan</label>
                                                <div class="col-sm-7">
                                                    <textarea name="" id="" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Lampiran</label>
                                                <div class="col-sm-7">
                                                    <input type="file" class="form-control data" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>




                    </div>
                </div>
                <div class="row">
                    <div class="title col-10">
                        <h3 style="text-align: left;">Detail Pengiriman</h3>
                    </div>
                </div>

                <div class="card card-danger card-tabs">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Id Pengiriman</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Tanggal Terima</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Lampiran</label>
                                    <input class="data" type="file" name="val_lampiran">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label></label>
                                    <button type="submit" name="btn_tambah" value="Tambah" class="form-control btn-success">Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table tampil">
                                    <thead class="bg-danger text-center ">
                                        <tr>
                                            <th>check</th>
                                            <th>No. Transaksi</th>
                                            <th>Customer</th>
                                            <th>Jenis Bayar</th>
                                            <th>Divisi</th>
                                            <th>Tanggal transaksi</th>
                                            <th>From - To</th>
                                            <th>Tujuan</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($data_pengiriman_manifest_out as $data => $value) : ?>
                                        <tbody class="bg-azure">
                                            <tr class="text-center">
                                                <td><input type="checkbox" checked></td>
                                                <td><?= $value->no_transaksi ?></td>
                                                <td><?= $value->customer ?></td>
                                                <td><?= $value->jenis_bayar ?></td>
                                                <td><?= $value->divisi ?></td>
                                                <td><?= $value->tanggal ?></td>
                                                <td><?= $value->from_to ?></td>
                                                <td><?= $value->tujuan ?></td>
                                            </tr>
                                        </tbody>
                                    <?php endforeach; ?>
                                </table>
                                <script type="text/javascript">
                                    $('.tampil').DataTable();
                                </script>

                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>
        </div>
        </div>
        <div class="col-12">
            <button type="submit" name="btn_submit" value="Simpan" style="display: block; margin: auto; width: 200px;" class="form-control btn-primary">Simpan</button>
        </div>
        <br>
    </form>



    <script type="text/javascript">
        $('#select-test').change(function() {
            // alert('h');
            if ($(this).val() == '') {
                var newThing = prompt('Enter a name for the new thing:');
                var newValue = $('option', this).length;
                $('<option>')
                    .text(newThing)
                    .attr('value', newValue)
                    .insertBefore($('option[value=]', this));
                $(this).val(newValue);
            }
        });
        $('#frm-manifest').submit(function(e) {
            e.preventDefault();
            form_data = new FormData($('#frm-manifest')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'manifest');
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/api/insert`,
                data: form_data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                success: function(r) {
                    console.log(r);
                    if (r.status == 200) {
                        alert('success');
                        location.href = `<?= base_url() ?>/load/view/manifest/pengiriman`;
                    }
                }

            });
        })
    </script>
<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
?>




<?php
} else {
    echo view('errors/html/error_404');
}

?>