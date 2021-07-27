<?php
if (isset($act) && $act == "view") {

    ?>
    <link rel="stylesheet" href="<?= base_url('/sample_assets/style.css') ?>">
    <br>
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
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
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
} elseif (isset($act) && $act == 'edit' && !$modal) {
    // print_r($edit_data);
    
    // print_r($_SESSION);
    // echo "<pre>";
    // print_r($manifest_in);
    // echo "</pre>";
    $reff= service('uri')->getSegment(5) != null ? service('uri')->getSegment(5):'';
    if (!empty($reff)) {
        echo "<script>
        $(function(){
            getKodeReff();
            })
            </script>";
        }
        ?>

        <form id="frm-manifest" action="">
            <div class="card card-danger card-outline">
                <div class="card-body">
                    <div class="card-body">
                        <div class="tab-content" id="tab-pengirimanContent">

                            <!-- form data pengiriman -->
                            <input type="hidden" id="val_tanggal" name="val_tanggal" class="data"
                            value="<?= date('Y-m-d H:i:s') ?>">
                            <input type="hidden" name="val_no_transaksi" value=<?=$reff ?>>
                            <!-- dsr -->
                            <div class="tab-pane fade active show" id="tab-pengiriman-dsr-form" role="tabpanel"
                            aria-labelledby="tab-pengiriman-dsr">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class=" form-group row">
                                        <label class="col-sm-4 col-form-label">Kode Referensi</label>
                                        <div class="col-sm-7">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Isi Kode Referensi"
                                                aria-label="Kode Referensi" aria-describedby="cariKodeReff"
                                                name="val_no_transaksi_reff" value="<?=$edit_data->no_transaksi_reff ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Divisi Asal</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val-divisi-asal" readonly name="val_divisi_asal" placeholder="Divisi Asal" value="<?=$edit_data->divisi_asal ?>" required>
                                            <input type="hidden" class="form-control data" id="val-kd-asal" readonly name="val_kd_asal"  value="<?=$edit_data->kd_asal ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Divisi Tujuan</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val-divisi-tujuan" readonly name="val_divisi_tujuan" placeholder="No. Refferensi" value="<?=$edit_data->divisi_tujuan ?>" required>
                                            <input type="hidden" class="form-control data" id="val-kd-tujuan" readonly name="val_kd_tujuan" value="<?=$edit_data->kd_tujuan ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Tanggal Berangkat</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val-tanggal-berangkat" readonly
                                            placeholder="Tanggal Berangkat" name="val_tanggal_berangkat" value="<?=$edit_data->tanggal_berangkat?>" required>
                                        </div>
                                    </div>
                                <!-- <div class="form-group row">
                                            <label for="subject" class="col-sm-4 col-form-label">Tanggal Sampai</label>
                                            <div class="col-sm-7">
                                                <input type="date" class="form-control data" id="val_no_transaksi_reff"
                                                name="val_no_transaksi_reff" required>
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="val_status" class="col-sm-3 col-form-label">Kendaraan</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control data" id="val-kendaraan" readonly
                                                placeholder="Kendaraan" name="val_kendaraan" value="<?=$edit_data->kendaraan ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="subject" class="col-sm-3 col-form-label">Kontak</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control data" id="val-kontak"
                                                placeholder="Kontak" value="<?=$edit_data->kontak ?>" readonly name="val_kontak" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Keterangan</label>
                                            <div class="col-sm-7">
                                                <textarea name="val_keterangan" id="" rows="2" class="form-control"
                                                placeholder="Keterangan" readonly><?=$edit_data->keterangan ?></textarea>
                                            </div>
                                        </div>
                                <!-- <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Lampiran</label>
                                            <div class="col-sm-7">
                                                <input type="file" class="form-control data" name="val_lampiran" required>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex mt-4 mb-2">
                <h3>Detail Pengiriman</h3>
                <div class="link ml-auto">
                    <a href="" class="btn btn-success">Tambah Pengiriman</a>
                </div>
            </div>


            <div class="card card-danger card-outline" style="min-height: 200px;" id="ajax-dt-manifest-out-container">
                <!-- <div class="card-body" >
                    
                </div>
                <div class="card-footer">
                    <div class="btn-batal">
                        <button type="button" name="simpan" class="btn btn-outline-dark" onclick="history.back(-1)" id="btn-close"><i style="color:red" class="fa fa-times"></i> Batal</button>
                        <button type="submit" id="btn-save" style="float: right;" name="btn_submit" value="Simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div> -->
            </div>

        <!-- <div class="text-center">
            <button type="submit" name="btn_submit" class="btn btn-lg btn-primary px-5">Simpan</button>
        </div> -->
        <br>
    </form>



    <script type="text/javascript">
        var detail_manifest_out=[];
        $('#frm-manifest').submit(function(e) {
            e.preventDefault();
            let loading_button = `
            <div style="width:50px;margin-left:30%">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span></div>`;
            $('#btn-save').prop('disabled',true);
            $('#btn-save').html(loading_button);
            if (detail_manifest_out.length>0) {
                // console.log(detail_manifest_out);
                $.ajax({
                    url: '/api/manifest_in/insert',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        no_transaksi: $('input[name=val_no_transaksi]').val(),
                        no_pengiriman: detail_manifest_out,
                        token: `<?= $_SESSION['token'] ?>`
                    },
                    success: function(r) {
                        if (r.status == 200) {
                            tes_sweet(r.message);
                            swal2_confirm(`<?= base_url() ?>/load/view/manifest_out/pengiriman`);
                        }else{
                            $('#btn-save').prop('disabled',false);
                            $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
                        }
                    }
                });
            }else{
                alert('Tidak Ada Pengiriman yang dipilih')
                $('#btn-save').prop('disabled',false);
                $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
            }
        })

        function getKodeReff() {
            // const spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            // $('#cariKodeReff').html(spinner);
            $('#ajax-dt-manifest-out-container').html(loading);
            $.ajax({
                url: '/api/get_manifest_out_to_in',
                type: 'post',
                // dataType: 'json',
                data: {
                    reff_manifest: `${$('input[name=val_no_transaksi]').val()}`,
                    token: '<?= $_SESSION['token']; ?>'
                },
                success: function(r) {
                    // console.log(r);
                    $('#ajax-dt-manifest-out-container').html(r);
                }
            })
        }
</script>
<?php
} else {
    echo view('errors/html/error_404');
}

?>