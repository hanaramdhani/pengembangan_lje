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
                                                name="val_no_transaksi_reff" value="" readonly>
                                                <!-- <div class="input-group-append"> -->
                                               <!--  <button class="btn btn-success" type="button" id="cariKodeReff">
                                                    <i class="fas fa-search"></i>
                                                </button> -->
                                                <!-- </div> -->
                                            </div>
                                            <!-- <input type="text" class="form-control data" id="val-no-transaksi-reff" name="val_no_transaksi_reff" placeholder="No. Refferensi" value="" required> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Divisi Asal</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val-divisi-asal" readonly name="val_divisi_asal" placeholder="Divisi Asal" value="" required>
                                            <input type="hidden" class="form-control data" id="val-kd-asal" readonly name="val_kd_asal"  value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Divisi Tujuan</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val-divisi-tujuan" readonly name="val_divisi_tujuan" placeholder="No. Refferensi" value="" required>
                                            <input type="hidden" class="form-control data" id="val-kd-tujuan" readonly name="val_kd_tujuan" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="subject" class="col-sm-4 col-form-label">Tanggal Berangkat</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control data" id="val-tanggal-berangkat" readonly
                                            placeholder="Tanggal Berangkat" name="val_tanggal_berangkat" required>
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
                                                placeholder="Kendaraan" name="val_kendaraan" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="subject" class="col-sm-3 col-form-label">Kontak</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control data" id="val-kontak"
                                                placeholder="Kontak" readonly name="val_kontak" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Keterangan</label>
                                            <div class="col-sm-7">
                                                <textarea name="val_keterangan" id="" rows="2" class="form-control"
                                                placeholder="Keterangan" readonly></textarea>
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


            <div class="card card-danger card-outline" style="min-height: 200px;">
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered" id="detail-manifest" style="max-height: 100px; overflow-y: scroll;">
                        <thead>
                            <tr>
                                <th style="width: 170px;">
                                    <input type="checkbox" name="check-all" id="check-all" class="mr-3">
                                    <label for="check-all" class="control-label m-0">Pilih semua</label>
                                </th>
                                <th>No. Pengiriman</th>
                                <th>Referensi</th>
                                <th>Deskripsi</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="btn-batal">
                        <button type="button" name="simpan" class="btn btn-outline-dark" onclick="history.back(-1)" id="btn-close"><i style="color:red" class="fa fa-times"></i> Batal</button>
                        <button type="submit" id="btn-save" style="float: right;" name="btn_submit" value="Simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>

        <!-- <div class="text-center">
            <button type="submit" name="btn_submit" class="btn btn-lg btn-primary px-5">Simpan</button>
        </div> -->
        <br>
    </form>



    <script type="text/javascript">
        $('#select-test').change(function() {
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
            let loading_button = `
            <div style="width:50px;margin-left:30%">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span></div>`;
            $('#btn-save').prop('disabled',true);
            $('#btn-save').html(loading_button);
            const dataPengiriman = []
            $('.chPengiriman:checked').each(function() {
                dataPengiriman.push($(this).val())
            });

            console.log(dataPengiriman);
            if (dataPengiriman.length>0) {
                $.ajax({
                    url: '/api/manifest_in/insert',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        no_transaksi: $('input[name=val_no_transaksi]').val(),
                        no_pengiriman: dataPengiriman,
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

        // ambil data manifest berdasarkan kode reff
        let manifestDetail = [];

        function getKodeReff() {
            const spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            $('#cariKodeReff').html(spinner);

            $.ajax({
                url: '/api/get_manifest_in',
                type: 'post',
                dataType: 'json',
                data: {
                    reff_manifest: `${$('input[name=val_no_transaksi]').val()}`,
                    token: '<?= $_SESSION['token']; ?>'
                },
                success: function(res) {
                    console.log(res);
                    if (res.status == '200') {
                        const master = res.master[0];
                        manifestDetail = res.detail;
                // console.log(master);
                // isi inputan menggunakan prop master
                for (const prop in master) {
                    if (Object.hasOwnProperty.call(master, prop)) {
                        $(`input[name=val_${prop}`).val(master[prop])
                    }
                }

                // isi table detail dengan prop detail
                let html = '';
                manifestDetail.forEach(index => {
                    html += '<tr>'
                    html +=
                    `<td><input type="checkbox" name='chPengiriman' value=${index.no_pengiriman} class="chPengiriman"></td>`
                    html += `<td>${index.no_pengiriman}</td>`
                    html += `<td>${index.refferensi}</td>`
                    html += `<td>${index.deskripsi}</td>`
                    html += `<td>${index.subtotal}</td>`
                    html += '</tr>'
                });

                $('table#detail-manifest tbody').html(html);
            } else {
                // alert('something went wrong!')
                alert('Wrong Parameter!');
                location.href = `<?= base_url() ?>/load/view/manifest_out/pengiriman`;
            }
            $('#cariKodeReff').html(`<i class="fas fa-search"></i>`)
        }
    })
        }

        $('#cariKodeReff').on('click', getKodeReff)
        $('form').keypress(function(e) {
            if (e.keyCode == '13') {
                e.preventDefault()
            }
        })
        $('input[name=val_no_transaksi]').keypress(function(e) {
            if (e.keyCode == '13') {
                getKodeReff()
            }
        })

        $('#check-all').click(function() {
            let isChecked = $(this).prop('checked')
            $('table#detail-manifest tr:has(td)').find('input[type=checkbox]').prop('checked', isChecked)
            if (isChecked) {
                $(this).siblings('label').html('Hapus Pilihan')
            } else {
                $(this).siblings('label').html('Pilih Semua')
            }
        })

        $('table#detail-manifest').on('click', '.chPengiriman', function(e) {
            $('#check-all').prop('checked', ($('.chPengiriman').length) === ($('.chPengiriman:checked').length))
        })
// end of cari data manifest
</script>
<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>




    <?php
} else {
    echo view('errors/html/error_404');
}

?>