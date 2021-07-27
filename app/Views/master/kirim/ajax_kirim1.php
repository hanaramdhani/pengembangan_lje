<link rel="stylesheet" href="<?= base_url('/sample_assets/style.css') ?>">
<?php
if (isset($act) && $act == "view") {
?>

    <section class="content-header">
        <h1> Tabel Kirim Detail </h1>
    </section>
    <a class="btn btn-primary" href="<?= site_url('load/add/kirim/master') ?>"> Tambah Data</a>
    <br>
    <hr>
    <table class="table table table-bordered">
        <tr class="table-info">
            <th>NO</th>
            <th>KETERANGAN</th>
            <th>STATUS</th>
            <th>LAMPIRAN</th>

        </tr>
        <?php foreach ($kirim as $key => $value) : ?>
            <tr>
                <td><?= $value->kd_kirim ?></td>
                <td><?= $value->keterangan ?></td>
                <td><?= $value->status ?></td>
                <td><?= $value->lampiran ?></td>

            </tr>
        <?php endforeach ?>
    </table>

    <br>


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
                title_modal = "Tambah " + page;
            } else if (jenis_modal == "edit-modal") {
                act = "edit";
                title_modal = "Ubah " + page;
            }
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}` + key + '/true',
                success: function(r) {
                    // alert(title_modal);
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
                        data: `frm_table=user_group&token=123`,
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
?>
    <h1> Biaya Kirim </h1 <!-- Form Biaya Kirim -->
    <form class="frm-kirim">
        <div class="row">
            <!-- Tabel Kirim -->
            <div class="col-lg-6 mt-2">
                <div class="card card-info">
                    <div class="card-body">
                        <!-- Kolom kd_kirim_reff  -->
                        <div class="form-group row">
                            <label for="val_kd_kirim_reff" class="col-sm-4 col-form-label">Kode Referensi</label>
                            <div class="col-sm-8">
                                <input name="kd_kirim_reff" class="form-control" id="kode-referensi">
                            </div>
                        </div>
                        <!-- End Kolom kd_kirim_reff  -->

                        <!-- Kolom Kota asal hasil dari kd_kota_asal  -->
                        <div class="form-group row">

                            <label for="val_kota_asal" class="col-sm-4 col-form-label">Kota Asal</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="val_kota_asal">
                                    <option selected="0">Pilih Kota</option>
                                    <?php foreach ($lokasi as $lk) : ?>
                                        <option value="<?php echo $lk->kd_lokasi; ?>"> <?php echo $lk->nama ?> </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                        <!-- End Kolom kd_kota_asal  -->

                        <!-- Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->
                        <div class="form-group row">
                            <label for="val_kota_tujuan" class="col-sm-4 col-form-label">Kota Tujuan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="val_kota_tujuan">
                                    <option selected="0">Pilih Kota</option>
                                    <?php foreach ($lokasi as $lk) : ?>
                                        <option value="<?php echo $lk->kd_lokasi; ?>"> <?php echo $lk->nama ?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->

                        <!-- Kolom keterangan  -->
                        <div class="form-group row">
                            <label for="val_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" rows="5" name="val_keterangan"></textarea>
                            </div>
                        </div>
                        <!-- End Kolom keterangan  -->

                        <!-- Kolom status  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="val_status">Status</label>
                            </div>
                            <div class="col-sm-2" id="radio-aktif">
                                <p><input type='radio' name="val_status" value='aktif' /> Aktif</p>
                            </div>
                            <div class="col-sm-2" id="radio-aktif1">
                                <p><input type='radio' name="val_status" value='non_aktif' /> Non-Akif</p>
                            </div>
                        </div>
                        <!-- End Kolom status  -->

                        <!-- Kolom Lampiran  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="val_lampiran">Lampiran</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <img id="frame" src="" style=" width: 100px; height:100px;" />
                                </div>
                                <div class="row mt-2">
                                    <input type="file" name="val_lampiran" onchange="preview()">
                                </div>
                            </div>
                        </div>
                        <!-- End Kolom Lampiran  -->
                    </div>
                </div>
            </div>
            <!-- End Tabel Kirim -->

            <!-- Form isi Tabel jenis kirim dan layanan -->
            <div class="col-lg-6 mt-2 mr-8">
                <div class="card card-info">
                    <div class="card-body">
                        <!--  Kolom Layanan  -->
                        <div class="form-group row">
                            <label for="val_layanan" class="col-sm-4 col-form-label">Layanan</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 data-dt" param="val_kd_layanan" id="add-modal-select-layanan" class="form-control">
                                    <!-- <select name="val_kd_layanan" class="form-control select2" id="add-modal-select-layanan" style="width: 100%;"> -->
                                    <option selected="0">Pilih Layanan</option>
                                    <!-- <option>Alaska</option> -->
                                    <?php foreach ($layanan as $ly) : ?>
                                        <option value="<?php echo $ly->kd_layanan; ?>"> <?php echo $ly->nama ?> </option>
                                    <?php endforeach; ?>
                                    <option class="" value="">+Tambah Layanan</option>
                                </select>
                            </div>
                        </div>
                        <!--  End Kolom Layanan  -->

                        <!--  Kolom Jenis Paket  -->
                        <div class="form-group row">
                            <label for="val_jenis_paket" class="col-sm-4 col-form-label">Jenis Paket</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 data-dt" param="val_kd_jenis" id="add-modal-select" class="form-control">
                                    <option selected="0">Pilih Jenis Paket</option>
                                    <?php foreach ($jenis_kirim as $jk) : ?>
                                        <option value="<?php echo $jk->kd_jenis; ?>"> <?php echo $jk->nama ?> </option>
                                    <?php endforeach; ?>
                                    <option class="" value="">+Tambah Jenis Paket</option>
                                </select>
                            </div>
                        </div>
                        <!--  End Kolom Jenis Paket  -->

                        <!--  Kolom Harga/kg  -->
                        <div class="form-group row">
                            <label for="val_harga" class="col-sm-4 col-form-label">Harga/kg</label>
                            <div class="col-sm-8">
                                <input class="form-control data-dt" param="val_harga_berat" IN></input>
                            </div>
                        </div>
                        <!--  End Kolom Harga/kg  -->

                        <!--  Kolom Minimal Berat  -->
                        <div class="form-group row">
                            <label for="val_minimal_berat" class="col-sm-4 col-form-label">Minimal Berat</label>
                            <div class="col-sm-8">
                                <input class="form-control data-dt" id="val_minimal_berat" param="val_minimal_berat"></input>
                            </div>
                        </div>
                        <!--  End Kolom Minimal Berat  -->

                        <!--  Kolom Harga/m3 -->
                        <div class="form-group row">
                            <label for="val_harga" class="col-sm-4 col-form-label">Harga/m3</label>
                            <div class="col-sm-8">
                                <input class="form-control data-dt" param="val_harga_volume"></input>
                            </div>
                        </div>
                        <!-- End  Kolom Harga/m3 -->

                        <!--  Kolom Minimal Volume -->
                        <div class="form-group row">
                            <label for="val_volume" class="col-sm-4 col-form-label">Minimal Volume</label>
                            <div class="col-sm-8">
                                <input class="form-control data-dt" param="val_volume"></input>
                            </div>
                        </div>
                        <!--  End Kolom Minimal Volume -->

                        <!--  Kolom Status -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="val_status">Status</label>
                            </div>
                            <div class="col-sm-2" id="radio-aktif">
                                <p><input class="data-dt" type='radio' name="status" param="val_status" value='1' /> Aktif</p>
                            </div>
                            <div class="col-sm-2" id="radio-aktif1">
                                <p><input class="data-dt" type='radio' name="status" param="val_status" value='0' /> Non-Akif</p>
                            </div>
                        </div>
                        <!-- End Kolom Status -->

                        <!--  Button Tambah Detail -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="tambah-data"></label>
                            </div>
                            <div class="col-sm-7">
                                <div class="btn_tambah">
                                    <button type="button" class="form-control center-block btn-primary" name="tambah" id="add-detail">
                                        <p>Tambah Detail</p>
                                    </button>

                                </div>
                            </div>
                        </div>
                        <!--  End Button Tambah Detail -->
                    </div>
                </div>

            </div>
        </div>


        <!-- Form Element Detail -->
        <div class="row">
            <div class="col-lg-12 mt-2 mr-8">
                <div class="card card-info">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="val_keterangan" class="col-sm-4 col-form-label">Detail</label>

                            <table class="table table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                        <td>Layanan</td>
                                        <td>Jenis Paket</td>
                                        <td>Harga/kg</td>
                                        <td>Minimal Berat</td>
                                        <td>Harga/m3</td>
                                        <td>Minimal Volume</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>
                                <tbody id="data">
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

                <div class="btn-simpan col-3">
                    <div class="container">
                        <button type="submit" name="simpan" class="form-control center-block btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
            <!-- EndForm Element Detail -->
        </div>
    </form>

    <script type="text/javascript">
        var dt_final = [];
        $("#add-detail").click(function(e) {
            e.preventDefault();
            var dt_now = [];
            var object = {};
            $(".data-dt").each(function() {
                let name = $(this).attr("param");
                object[name] = $(this).val();
            });
            // dt_now.push(object);
            dt_final.push(object);
            console.log(dt_final);
        });

        $('#frm-kirim').submit(function(e) {
            e.preventDefault();
            // var mt=[]
            // var object = {};

            form_data = new FormData($('#frm-kirim')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'kirim');
            for (var i = 0; i < dt_final.length; i++) {
                for (var property in dt_final[i]) {
                    // form_data.append(key, dt_final[i][key]);
                    // form_data.append(property,dt_final[i][property]);
                    form_data.append(`detail[${i}][${property}]`, dt_final[i][property]);
                    // console.log(`${property}`,`${dt_final[i][property]}`);
                }
                // console.log(dt_final[i]);
            }
            // $(".data").each(function () {
            //   let name = $(this).attr("name");
            //   object[name] = $(this).val();
            // });
            // mt.push(object);
            // console.log(dt_final);
            // console.log(mt);
            // data:{master:mt,detail:dt_final,frm_table:'penagihan',token:123},
            // url:`multi_insert_with_file.php`,
            $.ajax({
                type: 'post',
                url: `http://localhost:8080/api/multi_insert`,
                data: form_data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                success: function(r) {
                    console.log(r);
                }
            });
        });
    </script>

    <!-- End Form Biaya Kirim -->

    <!-- Menampilkan modal untuk tambah jenis paket -->
    <script type="text/javascript">
        $('#add-modal-select').change(function() {
            let val = $(this).val();
            if (val == "") {
                let key = $(this).data('key');
                let page = 'jenis';
                let jenis = `<?= $jenis ?>`;
                let jenis_modal = $(this).attr('id');
                let act = "add";
                let title_modal = "Tambah Jenis Kirim";
                $.ajax({
                    type: 'POST',
                    url: `<?= base_url() ?>/ajax_load/${act}/jenis_kirim/${jenis}` + key + '/true',
                    success: function(r) {
                        // alert(title_modal);
                        $('#m-crud-title').text(title_modal);
                        $('#m-crud-key').text(key);
                        $('#m-crud-act').text(act);
                        $('#m-crud-page').text('jenis_kirim');
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
    <!-- End menampilkan modal untuk tambah jenis paket -->

    <!-- Menampilkan modal untuk tambah jenis layanan -->
    <script type="text/javascript">
        $('#add-modal-select-layanan').change(function() {
            let val = $(this).val();
            if (val == "") {
                let key = $(this).data('key');
                let page = 'jenis';
                let jenis = `<?= $jenis ?>`;
                let jenis_modal = $(this).attr('id');
                let act = "add";
                let title_modal = "Tambah Jenis Layanan";

                $.ajax({
                    type: 'POST',
                    url: `<?= base_url() ?>/ajax_load/${act}/layanan/${jenis}` + key + '/true',
                    success: function(r) {
                        // alert(title_modal);
                        $('#m-crud-title').text(title_modal);
                        $('#m-crud-key').text(key);
                        $('#m-crud-act').text(act);
                        $('#m-crud-page').text('layanan');
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
    <!-- End menampilkan modal untuk tambah jenis layanan -->

    <!-- Script pilih file input -->
    <script>
        function preview() {
            let frame = document.getElementById('frame');

            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
    <!-- endScript pilih file input -->






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
        $('#frm-kirim').submit(function(e) {
            e.preventDefault();
            form_data = new FormData($('#frm-kirim')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'kirim');
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
                        location.href = `<?= base_url() ?>/load/view/kirim/master`;
                    }
                }

            });
        })
    </script>
<?php
} else {
    echo view('errors/html/error_404');
}

?>