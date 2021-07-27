<?php


if (isset($act) && $act == "view") {
    date_default_timezone_set('Asia/Jakarta');
    // print_r($invoice);
    // $data_append = array();
    // foreach ($invoice_detail as $key_row => $value_row) {
    //     $data_append["detail_" . $value_row->no_invoice][] = $value_row;
    // }
    // $test = json_encode($data_append);
    ?>
    <div class="card">
        <div class="card-body">
            <a class="btn btn-primary" href="<?= site_url('load/add/invoice/pengiriman') ?>"><i class="fas fa-plus-circle"></i>
            Tambah Data</a>
        </div>
    </div>

    <div class="card card-outline card-danger">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark px-3 active" id="manifest-tab" data-toggle="pill" href="#invoice-tab-content" role="tab" aria-controls="invoice-tab-content" aria-selected="true">
                        <i class="fas fa-tasks mr-2"></i> Invoice Pending
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" id="history-invoice-tab" data-toggle="pill"
                    href="#history-invoice-tab-content" role="tab" aria-controls="history-invoice-tab-content"
                    aria-selected="false"><i class="fas fa-history mr-2"></i> History Invoice</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="">
                <div class="tab-pane fade active show" id="invoice-tab-content" role="tabpanel" aria-labelledby="manifest-tab">
                    <div id="ajax-invoice-pending-container">

                    </div>
                </div>
                <div class="tab-pane fade" id="history-invoice-tab-content" role="tabpanel" aria-labelledby="history-invoice-tab">
                    <table id="data-tampil" class="table table-striped table-bordered">
                        <thead class="bg-danger">
                            <tr>

                                <th>Customer</th>
                                <th>Divisi</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <!-- <th>Lampiran</th> -->
                                <th></th>
                            </tr>

                        </thead>
                        <tbody>

                            <?php foreach ($invoice as $key => $value) : ?>
                                <tr>
                                    <td><?= $value->customer ?></td>
                                    <td><?= $value->divisi ?></td>
                                    <td><?= $value->tanggal ?></td>
                                    <td><?= $value->keterangan ?></td>



                                    <td class="text-center">
                                        <button type="button" class="btn btn-primary btn-xs data-tampil " id="data-tampil" data-key="<?= $value->no_transaksi ?>">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-xs edit-master" id="edit-modal" data-key="<?= $value->no_transaksi ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs delete" data-key="<?= $value->no_transaksi ?>"> <i class="fa fa-trash"></i></button>
                                        <button class="btn btn-xs show-image <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>" data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar" data-src="<?= base_url("/img/$page/" . $value->lampiran) ?>">
                                            <i class=" fa fa-image"></i>
                                        </button>
                                        <a href="<?= base_url('printController/generatemPDF/invoice?no_transaksi=' . $value->no_transaksi . '&title=Struk Invoice'); ?>" target="_blank" class="btn btn-xs btn-default"><i class="fas fa-print"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#data-tampil').DataTable();
            load_invoice_pending();
        });
        $('.show-image').click(function() {
            // $('#imagepreview').attr('src', '');
            // $('#imagepreview').removeClass('after-load');
            // $('#imagepreview').addClass('before-load');

            let url = $(this).data('src');
            $('#imagepreview').attr('src', url);
            $('#imagepreview').addClass('after-load');
            $('#imagepreview').removeClass('before-load');
            $('#imagemodal').modal('show');
        });
        function format(data) {
            let invoice_detail = <?= (!empty($test)) ? $test : '' ?>['detail_' + data];
            let content = ``;
            if (invoice_detail != "") {
                for (var i = 0; i < invoice_detail.length; i++) {
                    content += `
                    <tr style="background-color:azure">
                    <td>` + (i + 1) + `</td>
                    <td>` + invoice_detail[i]['no_invoice'] + `</td>
                    <td>` + invoice_detail[i]['no_pengiriman'] + `</td>
                    <td>` + invoice_detail[i]['keterangan'] + `</td>
                    <td>` + invoice_detail[i]['status'] + `</td>
                    <td><button class="btn btn-xs btn-warning" onclick="edit_invoice_detail(` + invoice_detail[i]['nomor'] + `)"><i class="fa fa-edit"></i></button></td>
                    </tr>`;
                }
            }

            // yang ini juga wkwkw
            let html_content = `<div class="slider container-fluid" name>
            <table class="table table-responsive table-condensed" style="opacity:0.9">
            <tr>
            <th>#</th>
            <td>Nomor Invoice</td>
            <td>Nomor Pengiriman</td>
            <td>Keterangan</td>
            <td>Status</td>
            <td>Aksi<td>
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
                tr.addClass('shown');
                row.child(loading).show();
                $.ajax({
                    type:'POST',
                    url:`<?=base_url() ?>/api/get_invoice_dt`,
                    data: {
                        key_invoice: $(this).data('key'),
                        token: '<?= $_SESSION['token']; ?>'
                    },
                    success: function(r) {
                        row.child(r).show();
                        tr.addClass('shown');
                        $('div.slider', row.child()).slideDown();
                    }

                });
            }
        });

        $("#data-tampil").on('click', '.edit-master', function() {
            let key_update = $(this).data('key');
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/ajax_load/edit/invoice/pengiriman/` + key_update + `/true`,
                success: function(r) {
                    $('#m-crud-title').text('Edit Data Invoice');
                    $('#m-crud-key').text(key_update);
                    $('#m-crud-act').text('edit');
                    $('#m-crud-page').text('invoice');
                    $('#m-crud-jenis').text('master');
                    $('#m-container-crud').html(r);
                    $('#modal-crud').modal('show');
                }
            });
            // if (row.child.isShown()) {
            //     $('div.slider', row.child()).slideUp(function() {
            //         row.child.hide();
            //         tr.removeClass('shown');
            //     });
            // } else {
            //     row.child(format($(this).data('key'))).show();
            //     tr.addClass('shown');
            // }
        });

        function edit_invoice_detail(key_update) {
            // alert(key_update);
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/ajax_load/edit/invoice_detail/pengiriman/` + key_update + `/true`,
                success: function(r) {
                    $('#m-crud-title').text('Edit Detail invoice');
                    $('#m-crud-key').text(key_update);
                    $('#m-crud-act').text('edit');
                    $('#m-crud-page').text('invoice_detail');
                    $('#m-crud-jenis').text('master');
                    $('#m-container-crud').html(r);
                    $('#modal-crud').modal('show');
                }
            });
        }

    </script>

    <script type="text/javascript">
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
                        data: `frm_table=invoice&token=<?=$_SESSION['token'] ?>`,
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
    // print_r($data_pengiriman);
    ?>

    <br>
    <form id="frm-invoice" action="#">
        <div class="row">
            <div class="col">
                <div class="card card-danger card-tabs">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kode Referensi</label>
                                    <div class="col-sm-9">
                                        <input name="no_transaksi_reff" class="form-control" id="" value="-">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Customer</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 data" id="invoice-customer" style="width: 100%;" name="val_kd_customer">
                                            <option selected="0" value="">Pilih Customer</option>
                                            <?php foreach ($customer as $key_customer => $value_customer) : ?>
                                                <option value="<?= $value_customer->kd_customer ?>"><?= $value_customer->nama ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Divisi</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2 data" style="width: 100%;" name="val_kd_divisi">
                                            <?php foreach ($divisi as $key_divisi => $value_divisi) : ?>
                                                <?php if ($value_divisi->kd_divisi != -1): ?>
                                                    <option value="<?= $value_divisi->kd_divisi ?>" <?=($value_divisi->kd_divisi==$_SESSION['kd_divisi'])?'selected':'' ?>><?= $value_divisi->nama ?></option>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Keterangan</label>
                                    <div class="col-sm-9">
                                        <textarea rows="2" name="val_keterangan" class="form-control">-</textarea>
                                    </div>
                                </div>
                                <div class="form-group row pt-2">
                                    <label class="col-sm-3 col-form-label">Lampiran</label>
                                    <div class="col-sm-4 pt-2">
                                        <input class="data" type="file" name="val_lampiran">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" id="val_tanggal" class="form-control" id="val_tanggal" value="<?= date('Y-m-d H:i:s') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="title col-10">
                        <h3 style="text-align: left;">Detail Paket</h3>
                    </div>
                    <!-- <div class="tambah-detail col-2">
                        <button type="submit" id="tambah-detail" style="margin-left: auto;" name="tambah-detail" class="form-control btn btn-success">Tambah</button>
                    </div> -->
                </div>

                <div class="row">

                    <div class="card card-outline card-danger col-12">
                        <div class="card-body">
                            <div id="ajax-load-invoice-container">

                            </div>

                            <div class="card-footer">
                                <div class="btn-batal">
                                    <button type="button" name="simpan" style=""
                                    class="btn btn-outline-dark" onclick="history.back(-1)" id="btn-close"><i style="" class="fa fa-arrow-left"></i> Kembali</button>
                                    <button style="display: none;float: right;" disabled type="submit" name="btn_submit" value="Simpan" id="btn-save" class="btn btn-primary"><i class="fas fa-save"></i> Simpan </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </form>

    <script type="text/javascript">
        let detail_invoice = [];
        $('#invoice-customer').change(function(){
            $('#ajax-load-invoice-container').html(loading);
            let val_key=$(this).val();
            if (val_key!='') {
                $.ajax({
                    type:'POST',
                    url:`<?=base_url() ?>/api/load_invoice_customer`,
                    data:{token:`<?=$_SESSION['token'] ?>`,kd_customer:val_key},
                    success:function(r){
                        $('#ajax-load-invoice-container').html(r)
                        $('#btn-save').prop('disabled',false);
                        $('#btn-save').css('display','inline-block');

                    }
                });
            }
        });
        $('#frm-invoice').submit(function(e) {
            e.preventDefault();
            let loading_button = `
            <div style="width:50px;margin-left:30%">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span></div>`;
            $('#btn-save').prop('disabled',true);
            $('#btn-save').html(loading_button);
            if (detail_invoice.length>0) {
                form_data = new FormData($('#frm-invoice')[0]);
                form_data.append('token', `<?=$_SESSION['token'] ?>`);
                form_data.append('frm_table', 'invoice');
                for (var i = 0; i < detail_invoice.length; i++) {
                    for (var property in detail_invoice[i]) {
                        form_data.append(`detail[${i}][${property}]`, detail_invoice[i][property]);
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
                            // location.href = `<?= base_url() ?>/load/view/kirim/master`;
                            swal2_confirm(`<?= base_url() ?>/load/view/invoice/pengiriman`);
                            // location.href = `<?= base_url() ?>/load/view/invoice/pengiriman`;
                            // location.reload();
                        }else{
                            alert('Maaf, Data belum lengkap');
                            $('#btn-save').prop('disabled',false);
                            $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
                        }
                    }
                });
            }else{
                alert('Tidak Ada pengiriman dipilih');
                $('#btn-save').prop('disabled',false);
                $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
            }
            
        });
        
    </script>
    <script type="text/javascript">
        let invoicedetail = [];

        function getIdPengiriman() {
            const spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
            $('#cariIdPengiriman').html(spinner);

            $.ajax({
                url: '/api/get_invoice_detail',
                type: 'post',
                dataType: 'json',
                data: {
                    reff_manifest: `${$('input[name=val_no_transaksi]').val()}`,
                    token: '<?= $_SESSION['token']; ?>'
                },
                success: function(res) {
                    console.log(res);
                    if (res.status == '200') {
                        const utama = res.utama[0];
                        invoicedetail = res.detail;
						// isi inputan menggunakan prop master
						for (const prop in master) {
							if (Object.hasOwnProperty.call(master, prop)) {
								$(`input[name=val_${prop}`).val(master[prop])
							}
						}
						// isi table detail dengan prop detail
						let html = '';
						invoicedetail.forEach(index => {
							html += '<tr>'
							html += `<td><input type="checkbox" name='chPengiriman' value=${index.no_pengiriman} class="chPengiriman"></td>`
							html += `<td>${index.no_pengiriman}</td>`
							html += `<td>${index.refferensi}</td>`
							html += `<td>${index.deskripsi}</td>`
							html += `<td>${index.subtotal}</td>`
							html += '</tr>'
						});
						$('table#detail-invoice tbody').html(html);
					} else {
						alert('something went wrong!')
					}
					$('#cariIdPengiriman').html(`<i class="fas fa-search"></i>`)
				}
			})
        }

        $('form').keypress(function(e) {
            if (e.keyCode == '13') {
                e.preventDefault()
            }
        })
        $('input[name=val_no_transaksi]').keypress(function(e) {
            if (e.keyCode == '13') {
                getIdPengiriman()
            }
        })
    </script>
    <?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
    <input type="hidden" class="form-control data" id="key_no_transaksi" name="key_no_transaksi" value="<?= $edit_data->no_transaksi ?>" required>
    <!-- Kolom Kota asal hasil dari kd_kota_asal  -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Kode Referensi</label>
        <div class="col-sm-10">
            <input name="val_no_transaksi_reff" class="form-control" id="" value="<?= $edit_data->no_transaksi_reff?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="val_kd_customer" class="col-sm-2 col-form-label">Customer</label>
        <div class="col-sm-10">
            <select class="form-control select2 data" style="width: 100%;" name="val_kd_customer">
                <option selected="0">Pilih Customer</option>
                <?php foreach ($customer as $cs) : ?>
                    <option value="<?php echo $cs->kd_customer; ?>" <?= ($cs->kd_customer == $edit_data->kd_customer) ? 'selected' : '' ?>> <?php echo $cs->nama ?> </option>
                <?php endforeach; ?>
            </select>

        </div>
    </div>
    <!-- End Kolom kd_kota_asal  -->

    <!-- Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->
    <div class="form-group row">
        <label for="val_kd_divisi" class="col-sm-2 col-form-label">Divisi</label>
        <div class="col-sm-10">
            <select class="form-control select2 data" style="width: 100%;" name="val_kd_divisi">
                <?php foreach ($divisi as $ds) : ?>
                    <?php if ($ds->kd_divisi!=-1): ?>
                        <option value="<?php echo $ds->kd_divisi; ?>" <?= ($ds->kd_divisi == $edit_data->kd_divisi) ? 'selected' : '' ?>> <?php echo $ds->nama ?> </option>
                    <?php endif ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <!-- End Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->
    <!-- Kolom keterangan  -->
    <div class="form-group row">
        <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <textarea class="form-control data" rows="5" name="val_keterangan" ><?= $edit_data->keterangan ?></textarea>
        </div>
    </div>
    <!-- End Kolom keterangan  -->
    <!-- Kolom status  -->
    <div class="form-group row">
        <div class="col-sm-2">
            <label for="val_status">Status</label>
        </div>
        <div class="col-sm-2" id="radio-aktif">
            <p>
                <input type='radio' class="data" name="val_status" value="1" <?= ($edit_data->status == 1) ? 'checked' : '' ?> /> Aktif
            </p>
        </div>
        <div class="col-sm-3" id="radio-aktif1">
            <p><input type='radio' class="data" name="val_status" value="0" <?= ($edit_data->status == 0) ? 'checked' : '' ?> /> Non-Akif</p>
        </div>
    </div>
    <!-- End Kolom status  -->

    <!-- Kolom Lampiran  -->
    <div class="form-group row">
        <div class="col-sm-2">
            <label for="val_lampiran">Lampiran</label>
        </div>
        <div class="col-sm-10">
            <div class="row">
                <img id="gmbrTagih" src="" style=" width: 100px; height:100px;" />
            </div>
            <div class="row mt-2">
                <input class="data" type="file" name="val_lampiran" onchange="previewgmbrTagih()">
            </div>
        </div>
    </div>
    <!-- End Kolom Lampiran  -->
    <script>
        function previewgmbrTagih() {
            let frame = document.getElementById('gmbrTagih');
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <?php
} elseif (isset($act) && $act == 'show_invoice_pending') {
    // echo "<pre>";
    // print_r($jenis_bayar);
    // echo "</pre>";

    ?>
    <table id="data-tampil-pending" class="table table-striped table-bordered table-sm">
        <thead class="bg-danger">
            <tr style="text-align: center">

                <th>No. Invoice</th>
                <th>Total Invoice</th>
                <th>Total Cicilan</th>
                <th>Sisa Cicilan</th>
                <th>Keterangan</th>
                <!-- <th>Lampiran</th> -->
                <th></th>
            </tr>

        </thead>
        <tbody>

            <?php foreach ($master as $key => $value) : ?>
                <tr>
                    <td><?= $value->no_invoice ?></td>
                    <td style="text-align: right;"><?= "Rp ".number_format($value->ttl_invoice,0,',','.') ?></td>
                    <td style="text-align: right;"><?= "Rp ".number_format($value->total_bayar,0,',','.') ?></td>
                    <td style="text-align: right;"><?= "Rp ".number_format(($value->ttl_invoice-$value->total_bayar),0,',','.') ?></td>
                    <td><?= "Customer: ".$value->customer ?></td>



                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-xs cl-invoice-pending-tampil" id="invoice-pending-tampil" data-key="<?= $value->no_invoice ?>">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn btn-xs btn-success bayar-invoice pl-2 pr-2" data-no_invoice="<?= $value->no_invoice ?>" data-sisa_cicilan="<?= $value->ttl_invoice-$value->total_bayar ?>"><i class="fa fa-dollar-sign"></i></button>
                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>
    </table>
    <script type="text/javascript">
        $(function(){
            $('#data-tampil-pending').DataTable();
        });
        function format_invoice_pending(data) {
            let invoice_pending_detail = <?=(!empty($detail))?json_encode($detail):'' ?>['detail_'+data];
            console.log(invoice_pending_detail);
            let content = ``;
            if (invoice_pending_detail != "") {
                for (var i = 0; i < invoice_pending_detail.length; i++) {
                    let tanggal=invoice_pending_detail[i]['tanggal_bayar_dt'].split(';');
                    let angsuran=invoice_pending_detail[i]['angsuran_dt'].split(';');
                    let data_angsuran=[];
                    for (var j = 0; j < tanggal.length; j++) {
                        if (angsuran[j]!=0) {
                            data_angsuran.push((j+1)+`. Rp `+currencyFormat(parseFloat(angsuran[j]))+` ( `+tanggal[j]+` ) <br>`)
                        }else{
                            data_angsuran.push('-');
                        }
                    }
                    content += `
                    <tr style="background-color:azure">
                    <td>` + (i + 1) + `</td>
                    <td>` + invoice_pending_detail[i].no_invoice_dt + `</td>
                    <td>` + invoice_pending_detail[i].reff_pengiriman_dt + `</td>
                    <td>` + `Rp `+currencyFormat(parseFloat(invoice_pending_detail[i].subtotal_dt)) + `</td>
                    <td>` + `Rp `+currencyFormat(parseFloat(invoice_pending_detail[i].total_bayar_dt)) + `</td>
                    
                    
                    </tr>`;
                }
                // <td>
                //     <button class="btn btn-xs btn-warning" onclick="edit_invoice_pending_detail(` + invoice_pending_detail[i]['no_invoice_dt'] + `)"><i class="fa fa-edit"></i>
                //     </button>
                //     </td>
            }

            // yang ini juga wkwkw
            let html_content = `<div class="slider container-fluid" name>
            <table class="table table-responsive table-condensed table-sm" style="opacity:0.9">
            <tr>
            <th>#</th>
            <td>Nomor Pengiriman</td>
            <td>SA</td>
            <td>Subtotal</td>
            <td>Total Cicilan</td>
            
            </tr>
            ` + content + `
            </table>
            </div>`;
            // console.log(html_content);
            return html_content;
        }

        $("#data-tampil-pending").on('click','.cl-invoice-pending-tampil', function() {
            var table = $('#data-tampil-pending').DataTable();
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                $('div.slider', row.child()).slideUp(function() {
                    row.child.hide();
                    tr.removeClass('shown');
                });
            } else {
                row.child(format_invoice_pending($(this).data('key'))).show();
                tr.addClass('shown');
                $('div.slider', row.child()).slideDown();
            }
        });
        $("#data-tampil-pending").on('click','.bayar-invoice', function() {
            let no_invoice_selected=$(this).data('no_invoice');
            let sisa_cicilan_selected=$(this).data('sisa_cicilan');
            $('#no-invoice').val(no_invoice_selected);
            $('#sisa-cicilan').val(sisa_cicilan_selected);
            $('#val-nominal').val(sisa_cicilan_selected);
            $('#modal-pembayaran-invoice').modal('show');
        });

        $(':input').click(function() {
            $(this).select();
        });
        $('#frm-modal-pembayaran-invoice').submit(function(e){
            e.preventDefault();
            // let form_data= new FormData($('#frm-modal-pembayaran-invoice')[0]);
            form_data_invoice = new FormData($('#frm-modal-pembayaran-invoice')[0]);
            form_data_invoice.append('token', `<?=$_SESSION['token'] ?>`);
            // form_data.append('token', `<?=$_SESSION['token'] ?>`);
            $.ajax({
                type:'post',
                url:`<?=base_url() ?>/api/save_pembayaran_invoice`,
                data:form_data_invoice,
                processData: false,
                contentType: false,
                dataType:'json',
                success:function(r){
                    if (r.status==200) {
                        tes_sweet(r.message);
                        $('#modal-pembayaran-invoice').modal('hide');
                        load_invoice_pending();
                    }
                }
            })
        })
        // function show_detail(key){
        //     let data_test=<?=(!empty($detail))?json_encode($detail):'' ?>['detail_'+key];
        //     if (data_test!="") {
        //         for (var i = 0; i < data_test.length; i++) {
        //             console.log(data_test[i].no_invoice_dt);
        //         }
        //         // console.log(data_test);
        //     }
        // }
        
    </script>
    <div class="modal" tabindex="-1" role="dialog" id="modal-pembayaran-invoice">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="frm-modal-pembayaran-invoice">
                    <div class="modal-header">
                        <h5 class="modal-title" id="m-crud-title">Pembayaran Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="">
                        <div class=" form-group row">
                            <label for="val_nomor_reff" class="col-sm-2 col-form-label">No. Refferensi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="val_nomor_reff" id="" value="-">
                            </div>
                        </div>
                        <div class=" form-group row">
                            <label for="val_no_invoice" class="col-sm-2 col-form-label">No. Invoice</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="val_no_invoice" id="no-invoice" value="" readonly>
                            </div>
                        </div>
                        <div class=" form-group row">
                            <label for="val_kd_jenis_bayar" class="col-sm-2 col-form-label">Jenis Bayar</label>
                            <div class="col-sm-10">
                                <select id="val_kd_jenis_bayar" name="val_kd_jenis_bayar" class="form-control">
                                    <?php foreach ($jenis_bayar as $jeb => $value) : ?>
                                        <option value="<?= $value->kd_jenis_bayar ?>" <?= ( $value->kd_jenis_bayar) ? 'selected' : '' ?>>
                                            <?php echo $value->nama ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class=" form-group row">
                            <label for="val_kd_kas" class="col-sm-2 col-form-label">Kas</label>
                            <div class="col-sm-10">
                                <select id="val_kd_kas" name="val_kd_kas" class="form-control">
                                    <?php foreach ($kas as $kas2 => $value) : ?>
                                        <option value="<?= $value->kd_kas ?>" <?= ( $value->kd_kas) ? 'selected' : '' ?>>
                                            <?php echo $value->no_rekening ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="val_nominal" class="col-sm-2 col-form-label">Sisa Cicilan</label>
                            <div class="col-sm-10">
                                <input type="number" min="0"  class="form-control" name="" id="sisa-cicilan" value="" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="val_nominal" class="col-sm-2 col-form-label">Nominal</label>
                            <div class="col-sm-10">
                                <input type="number" min="0"  class="form-control" name="val_nominal" id="val-nominal" value="0">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea id="val_keterangan" rows="2" name="val_keterangan" class="form-control">-</textarea>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="val_lampiran">Lampiran</label>
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <img id="gmbrbayar" src="" style=" width: 100px; height:100px;" />
                                </div>
                                <div class="row mt-2">
                                    <input type="file" name="val_lampiran" id="file" onchange="previewgmbrbayar()">
                                    <!-- <input type="file" name="val_lampiran" id="val_lampiran"> -->
                                </div>
                            </div>
                        </div>

                        <script>
                            function previewgmbrbayar() {
                                let frame = document.getElementById('gmbrbayar');
                                frame.src = URL.createObjectURL(event.target.files[0]);
                            }
                        </script>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="modal-btn" class="btn btn-primary"><i class="fas fa-save mr-2"></i>
                        Simpan</button>
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    
}else {
    echo view('errors/html/error_404');
}

?>
<script type="text/javascript">
   function load_invoice_pending(){
    $('#ajax-invoice-pending-container').html(loading);
    $.ajax({
        type:'POST',
        url:`<?=base_url() ?>/api/get_invoice_pending`,
        data:{token:'<?=$_SESSION['token'] ?>'},
        success:function(r){
            $('#ajax-invoice-pending-container').html(r);
        }
    });
}
</script>
