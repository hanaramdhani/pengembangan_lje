<?php
if (isset($act) && $act == "view") {
    // echo "<pre>";
    // print_r($kirim_detail);
    // echo "</pre>";
    $data_append = array();
    foreach ($kirim_detail as $key_row => $value_row) {
        // foreach ($value_row as $key_col => $value_col) {
        $data_append["detail_" . $value_row->kd_kirim][] = $value_row;

        // $data_append["detail_".$value_row->kd_kirim][$key_col] = $value_col;
        // }
    }
    $test = json_encode($data_append);
    // echo "<pre>";
    // print_r($data_append);
    // echo "</pre>";
    ?>

    <!-- <section class="content-header">
        <h1> Tabel Kirim Detail </h1>
    </section> -->
    <a class="btn btn-primary" href="<?= site_url('load/add/kirim/master') ?>"> Tambah Data</a>
    <br>
    <hr>
    <table id="data-tampil" class="table table-striped table-bordered" style="width:100%">
        <thead class="bg-danger">
            <tr>
                <th>NO</th>
                <th>KOTA ASAL</th>
                <th>KOTA TUJUAN</th>
                <th>KETERANGAN</th>
                <th>STATUS</th>
                <th>LAMPIRAN</th>
                <th class="text-center">AKSI</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($kirim as $key => $value) : ?>
                <tr>

                    <td><?= $value->kd_kirim ?></td>
                    <td><?= $value->asal ?></td>
                    <td><?= $value->tujuan ?></td>
                    <td><?= $value->keterangan ?></td>
                    <td><?= $value->status ?></td>
                    <td><?= $value->lampiran ?></td>
                    <td class="text-center" width="160px">
                        <button type="button" class="btn btn-default btn-xs data-tampil" id="data-tampil" data-key="<?= $value->kd_kirim ?>">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-xs edit-master" data-key="<?= $value->kd_kirim ?>">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <br>
    <script>
        $(document).ready(function() {
            $('#data-tampil').DataTable();
        });
    </script>

    <!-- Tampil Detail -->
    <script type="text/javascript">
        function format(data) {
            // alert(data);
            let kirim_detail = <?= (!empty($test)) ? $test : '' ?>['detail_' + data];
            // var result = Object.keys(kirim_detail).map((key) => [Number(key), kirim_detail[key]]);
            // const data_detail =JSON.stringify(kirim_detail);
            // console.log(kirim_detail);
            // console.log(data_detail);
            // console.log(data_detail['detail_'+data]);

            let content = ``;
            if (kirim_detail != "") {
                for (var i = 0; i < kirim_detail.length; i++) {
                    content += `
                    <tr style="background-color:azure">
                    <td>` + (i + 1) + `</td>
                    <td>` + kirim_detail[i]['kd_kirim_detail'] + `</td>
                    <td>` + kirim_detail[i]['jenis_kirim'] + `</td>
                    <td>` + kirim_detail[i]['layanan'] + `</td>
                    <td style="text-align: right;">Rp ` + currencyFormat(parseFloat(kirim_detail[i]['harga_berat'])) + `</td>
                    <td>` + kirim_detail[i]['min_berat'] + `</td>
                    <td style="text-align: right;">Rp ` + currencyFormat(parseFloat(kirim_detail[i]['harga_volume'])) + `</td>
                    <td>` + kirim_detail[i]['min_volume'] + `</td>
                    <td>` + kirim_detail[i]['prediksi_hari'] + `</td>
                    <td>` + kirim_detail[i]['status'] + `</td>
                    <td><button class="btn btn-xs btn-warning" onclick="edit_ongkir_detail(`+kirim_detail[i]['kd_kirim_detail']+`)"><i class="fa fa-edit"></i></button></td>
                    </tr>
                    `;

                }
            }
            let html_content = `<div class="slider container-fluid" name>
            <table class="table table-responsive table-condensed" style="opacity:0.9">
            <tr>
            <th>#</th>
            <th>Kode Kirim</th>
            <th>Jenis Kirim</th>
            <th>Jenis Layanan</th>
            <th>Harga Berat</th>
            <th>Minimal Berat</th>
            <th>Harga Volume</th>
            <th>Minimal Volume</th>
            <th>Prediksi Hari</th>
            <th>Status</th>
            <th>Aksi</th>
            </tr>
            ` + content + `
            </table>
            </div>`;
            // console.log(html_content);
            return html_content;

        }
        
        $("#data-tampil").on('click', '.data-tampil', function() {
            var table = $('#data-tampil').DataTable();
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                $('div.slider', row.child()).slideUp(function() {
                    row.child.hide();
                    tr.removeClass('shown');
                });
            } else {
                row.child(format($(this).data('key'))).show();
                tr.addClass('shown');

                $('div.slider', row.child()).slideDown();
            }

        });

        $("#data-tampil").on('click', '.edit-master', function() {            
            let key_update=$(this).data('key');
            $.ajax({
                type:'POST',
                url:`<?=base_url() ?>/ajax_load/edit/kirim/master/` + key_update + `/true`,
                success:function(r){
                    $('#m-crud-title').text('Edit Ongkir');
                    $('#m-crud-key').text(key_update);
                    $('#m-crud-act').text('edit');
                    $('#m-crud-page').text('kirim');
                    $('#m-crud-jenis').text('master');
                    $('#m-container-crud').html(r);
                    $('#modal-crud').modal('show');
                }
            });

        });

        function currencyFormat(num) {
            return (num
                .toFixed(0)
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                );
        }
        function edit_ongkir_detail(key_update){
            // alert(key_update);
            $.ajax({
                type:'POST',
                url:`<?=base_url() ?>/ajax_load/edit/kirim_detail/master/` + key_update + `/true`,
                success:function(r){
                    $('#m-crud-title').text('Edit Ongkir');
                    $('#m-crud-key').text(key_update);
                    $('#m-crud-act').text('edit');
                    $('#m-crud-page').text('kirim_detail');
                    $('#m-crud-jenis').text('master');
                    $('#m-container-crud').html(r);
                    $('#modal-crud').modal('show');
                }
            });
        }
    </script>



    <!-- End Detail -->


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
    $layanan_js = array();
    foreach ($layanan as $key_row => $value_row) {
        $layanan_js["detail_" . $value_row->kd_layanan] = $value_row->nama;
    }
    $arr_layanan= json_encode($layanan_js);
    // print_r($jenis_kirim);
    $jenis_kirim_js = array();
    foreach ($jenis_kirim as $key_row => $value_row) {
        $jenis_kirim_js["detail_" . $value_row->kd_jenis] = $value_row->nama;
    }
    $arr_jenis_kirim= json_encode($jenis_kirim_js);
    // print_r($arr_jenis_kirim);
    ?>
    <h1> Biaya Kirim </h1>
    <form id="frm-kirim" action="#">
        <div class="row">
            <!-- Tabel Kirim -->
            <div class="col-lg-6 mt-2">
                <div class="card card-info">
                    <div class="card-body">
                        <!-- Kolom kd_kirim_reff  -->
                        <div class="form-group row">
                            <label for="val_kd_kirim_reff" class="col-sm-4 col-form-label">Kode Referensi</label>
                            <div class="col-sm-8">
                                <input name="val_kd_kirim_reff" class="form-control data" id="kode-referensi" value="-">
                            </div>
                        </div>
                        <!-- End Kolom kd_kirim_reff  -->

                        <!-- Kolom Kota asal hasil dari kd_kota_asal  -->
                        <div class="form-group row">

                            <label for="val_kota_asal" class="col-sm-4 col-form-label">Kota Asal</label>
                            <div class="col-sm-8">
                                <select class="form-control select2 data" style="width: 100%;" name="val_kd_kota_asal">
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
                                <select class="form-control select2 data" style="width: 100%;" name="val_kd_kota_tujuan">
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
                                <textarea class="form-control data" rows="5" name="val_keterangan"></textarea>
                            </div>
                        </div>
                        <!-- End Kolom keterangan  -->

                        <!-- Kolom status  -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="val_status">Status</label>
                            </div>
                            <div class="col-sm-2" id="radio-aktif">
                                <p><input type='radio' class="data" name="val_status" value="1" checked/> Aktif</p>
                            </div>
                            <div class="col-sm-3" id="radio-aktif1">
                                <p><input type='radio' class="data" name="val_status" value="0" /> Non-Akif</p>
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
                                    <input class="data" type="file" name="val_lampiran" onchange="preview()">
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
                                <select class="form-control select2 data-dt" name="val_kd_layanan" param="val_kd_layanan" id="add-modal-select-layanan">
                                    <option selected="0" value="none">Pilih Layanan</option>
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
                                <select class="form-control select2 data-dt" param="val_kd_jenis" id="add-modal-select" name="val_kd_jenis">
                                    <option selected="0" value="none">Pilih Jenis Paket</option>
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
                                <input type="number" min="0" value="0" class="form-control data-dt" id="val_harga_berat" param="val_harga_berat">
                            </div>
                        </div>
                        <!--  End Kolom Harga/kg  -->

                        <!--  Kolom Minimal Berat  -->
                        <div class="form-group row">
                            <label for="val_min_berat" class="col-sm-4 col-form-label">Minimal Berat</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" value="0" class="form-control data-dt" id="val_min_berat" param="val_min_berat">
                            </div>
                        </div>
                        <!--  End Kolom Minimal Berat  -->


                        <!--  Kolom Harga/m3 -->
                        <div class="form-group row">
                            <label for="val_harga" class="col-sm-4 col-form-label">Harga/m3</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" value="0" class="form-control data-dt" id="val_harga_volume" param="val_harga_volume">
                            </div>
                        </div>
                        <!-- End  Kolom Harga/m3 -->

                        <!--  Kolom Minimal Volume -->
                        <div class="form-group row">
                            <label for="val_min_volume" class="col-sm-4 col-form-label">Minimal Volume</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" value="0" class="form-control data-dt" id="val_min_volume" param="val_min_volume">

                            </div>
                        </div>
                        <!--  End Kolom Minimal Volume -->


                        <!--  Kolom  PrediksiHari -->
                        <div class="form-group row">
                            <label for="val_prediksi_hari" class="col-sm-4 col-form-label">Prediksi Hari</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" value="0" class="form-control data-dt" id="val_prediksi_hari" param="val_prediksi_hari">

                            </div>
                        </div>
                        <!--  End Kolom Prediksi Hari -->


                        <!--  Kolom Status -->
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="val_status">Status</label>
                            </div>
                            <div class="col-sm-2" id="radio-aktif">
                                <p><input class="data-dt radio-dt-status" type='radio' name="val_status_dt" id="status-dt-aktif" param="val_status" value="1" checked/> Aktif</p>
                            </div>
                            <div class="col-sm-3" id="radio-aktif1">
                                <p><input class="radio-dt-status" type='radio' name="val_status_dt" id="status-dt-non-aktif" value="0" /> Non-Akif</p>
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
                                    <button type="button" class="form-control center-block btn-primary" name="tambah" data-row="-1" data-aksi="tambah" id="add-detail">
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
                                <thead class="bg-danger">
                                    <tr>
                                        <td>#</td>
                                        <td>Layanan</td>
                                        <td>Jenis Paket</td>
                                        <td>Harga/kg</td>
                                        <td>Minimal Berat</td>
                                        <td>Harga/m3</td>
                                        <td>Minimal Volume</td>
                                        <td>Prediksi Hari</td>
                                        <td>Status</td>
                                        <td>AKSI</td>
                                    </tr>
                                </thead>
                                <tbody id="table-container">
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>

                <div class="btn-simpan col-3">
                    <div class="container">
                        <button type="submit" id="send-ajax-array-js" name="simpan" class="form-control center-block btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
            <!-- EndForm Element Detail -->
        </div>
    </form>

    <script type="text/javascript">
        var dt_final = [];

        $('.radio-dt-status').click(function() {
            let status_kirim_dt_id=$(this).attr('id');
            if (status_kirim_dt_id=='status-dt-aktif') {
                $('#status-dt-non-aktif').removeAttr('param');
                $('#status-dt-non-aktif').removeClass('data-dt');
                $('#status-dt-aktif').addClass('data-dt');
            }else if (status_kirim_dt_id=='status-dt-non-aktif') {
                $('#status-dt-aktif').removeAttr('param');
                $('#status-dt-aktif').removeClass('data-dt');
                $('#status-dt-non-aktif').addClass('data-dt');

            }
            $(this).attr('param','val_status');
            // alert(status_kirim_dt);

        });
        $("#add-detail").click(function() {
            let row = $(this).attr('data-row');
            let aksi = $(this).attr('data-aksi');
            if (aksi == "tambah") {
                addRow();
            } else if (aksi == "ubah") {
                updateRow(row);
            }
            reload_tbl_tmp_dt();
            $(this).attr('data-row', '-1');
            $(this).attr('data-aksi', 'tambah');
        });

        function reload_tbl_tmp_dt() {
            let data_dtl = ``;
            let layanan_js=<?= (!empty($arr_layanan)) ? $arr_layanan : '' ?>;
            let jenis_kirim_js=<?= (!empty($arr_jenis_kirim)) ? $arr_jenis_kirim : '' ?>;
            for (var i = 0; i < dt_final.length; i++) {

                data_dtl += `<tr>`;
                data_dtl += `<td>` + (i + 1) + `</td>`;
                data_dtl += `<td>` + layanan_js['detail_'+dt_final[i]['val_kd_layanan']] + `</td>`;
                data_dtl += `<td>` + jenis_kirim_js['detail_'+dt_final[i]['val_kd_jenis']] + `</td>`;
                data_dtl += `<td>` + dt_final[i]['val_harga_berat'] + `</td>`;
                data_dtl += `<td>` + dt_final[i]['val_min_berat'] + `</td>`;
                data_dtl += `<td>` + dt_final[i]['val_harga_volume'] + `</td>`;
                data_dtl += `<td>` + dt_final[i]['val_min_volume'] + `</td>`;
                data_dtl += `<td>` + dt_final[i]['val_prediksi_hari'] + `</td>`;
                data_dtl += `<td>` + dt_final[i]['val_status'] + `</td>`;
                data_dtl += `<td> <button type="button" class="btn btn-sm btn-warning" onclick="getRow(` + i + `)">UBAH</button> <button type="button" class="btn btn-sm btn-danger" onclick="deleteNRefresh(` + i + `)">HAPUS</button></td>`;
                data_dtl += `</tr>`;
            }
            let table_template = data_dtl;
            $('#table-container').html(table_template);
        }

        function addRow() {
            var object = {};
            let validation=true;
            $(".data-dt").each(function() {
                let name = $(this).attr("param");
                if ($(this).val()=="" || $(this).val()=="none") {
                    validation=false;
                }else{
                    object[name] = $(this).val();
                }
            });
            if (validation) {
                dt_final.push(object);
            }
        }


        function updateRow(row) {
            var object = {};
            let validation=true;
            $(".data-dt").each(function() {
                let name = $(this).attr("param");
                if ($(this).val()=="" || $(this).val()=="none") {
                    validation=false;
                }else{
                    object[name] = $(this).val();
                }
            });
            dt_final[row] = object;
            $("#add-detail").attr('data-row', '-1');
            $("#add-detail").attr('data-aksi', 'tambah');

        }

        function deleteRow(row) {
            dt_final.splice(row, 1);
        }

        function deleteNRefresh(row) {
            deleteRow(row);
            reload_tbl_tmp_dt();
        }

        function getRow(row) {
            $('#add-modal-select-layanan').val(dt_final[row]['val_kd_layanan']);
            $('#add-modal-select').val(dt_final[row]['val_kd_jenis']);
            $('#val_harga_berat').val(dt_final[row]['val_harga_berat']);
            $('#val_min_berat').val(dt_final[row]['val_min_berat']);
            $('#val_harga_volume').val(dt_final[row]['val_harga_volume']);
            $('#val_min_volume').val(dt_final[row]['val_min_volume']);
            $('#val_prediksi_hari').val(dt_final[row]['val_prediksi_hari']);
            // alert(dt_final[row]['val_status']);
            if (dt_final[row]['val_status']==0) {
                // alert('dd');
                $('#status-dt-non-aktif').prop('checked', true);;
            }else{
                // alert('kshdfkaj');
                $('#status-dt-aktif').prop('checked', true);;
            }
            // $('#data-dt').val(dt_final[row]['val_status']);

            $('#add-detail').attr('data-row', row);
            $('#add-detail').attr('data-aksi', 'ubah');
        }
        $('#frm-kirim').submit(function(e) {
            e.preventDefault();
            form_data = new FormData($('#frm-kirim')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'kirim');
            for (var i = 0; i < dt_final.length; i++) {
                for (var property in dt_final[i]) {
                    form_data.append(`detail[${i}][${property}]`, dt_final[i][property]);
                }
            }
            $.ajax({
                type: 'post',
                url: `<?= base_url() ?>/api/multi_insert`,
                data: form_data,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                success: function(r) {
                    console.log(r);
                    if (r.status == 200) {
                        tes_sweet('simpan data berhasil');
                        location.href = `<?= base_url() ?>/load/view/kirim/master`;
                    }
                    // print_r($kirim);
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
                $('#modal-crud').modal('hide');
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
    </script>
    <?php
} elseif (isset($act) && $act == "edit" && $modal){
    // print_r($edit_data);
    ?>
    <div class="card card-info">
        <div class="card-body">
            <!-- Kolom kd_kirim_reff  -->
            <input type="hidden" name="key_kd_kirim" value="<?=$edit_data->kd_kirim ?>">
            <div class="form-group row">
                <label for="val_kd_kirim_reff" class="col-sm-4 col-form-label">Kode Referensi</label>
                <div class="col-sm-8">
                    <input name="val_kd_kirim_reff" class="form-control data" id="kode-referensi" value="<?=$edit_data->kd_kirim_reff ?>">
                </div>
            </div>
            <!-- End Kolom kd_kirim_reff  -->

            <!-- Kolom Kota asal hasil dari kd_kota_asal  -->
            <div class="form-group row">

                <label for="val_kota_asal" class="col-sm-4 col-form-label">Kota Asal</label>
                <div class="col-sm-8">
                    <select class="form-control select2 data" style="width: 100%;" name="val_kd_kota_asal">
                        <option selected="0">Pilih Kota</option>
                        <?php foreach ($lokasi as $lk) : ?>
                            <option value="<?php echo $lk->kd_lokasi; ?>" <?=($lk->kd_lokasi==$edit_data->kd_kota_asal)?'selected':'' ?>> <?php echo $lk->nama ?> </option>
                        <?php endforeach; ?>
                    </select>

                </div>
            </div>
            <!-- End Kolom kd_kota_asal  -->

            <!-- Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->
            <div class="form-group row">
                <label for="val_kota_tujuan" class="col-sm-4 col-form-label">Kota Tujuan</label>
                <div class="col-sm-8">
                    <select class="form-control select2 data" style="width: 100%;" name="val_kd_kota_tujuan">
                        <option selected="0">Pilih Kota</option>
                        <?php foreach ($lokasi as $lk) : ?>
                            <option value="<?php echo $lk->kd_lokasi; ?>" <?=($lk->kd_lokasi==$edit_data->kd_kota_tujuan)?'selected':'' ?>> <?php echo $lk->nama ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <!-- End Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->

            <!-- Kolom keterangan  -->
            <div class="form-group row">
                <label for="val_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                    <textarea class="form-control data" rows="5" name="val_keterangan"><?=$edit_data->keterangan ?></textarea>
                </div>
            </div>
            <!-- End Kolom keterangan  -->

            <!-- Kolom status  -->
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="val_status">Status</label>
                </div>
                <div class="col-sm-2" id="radio-aktif">
                    <p><input type='radio' class="data" name="val_status" value="1" <?=($edit_data->status==1)?'checked':'' ?>/> Aktif</p>
                </div>
                <div class="col-sm-3" id="radio-aktif1">
                    <p><input type='radio' class="data" name="val_status" value="0" <?=($edit_data->status==0)?'checked':'' ?>/> Non-Akif</p>
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
                        <input class="data" type="file" name="val_lampiran" onchange="preview()">
                    </div>
                </div>
            </div>
            <!-- End Kolom Lampiran  -->
        </div>
    </div>
    <?php
}else {
    echo view('errors/html/error_404');
}

?>
<script type="text/javascript">
    $("input").focus(function(){
        $(this).select();
    });
</script>