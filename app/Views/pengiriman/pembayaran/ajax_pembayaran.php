<?php


if (isset($act) && $act == "view") {

    ?>
<link rel="stylesheet" href="<?= base_url('/sample_assets/style.css') ?>">
<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= site_url('load/add/pembayaran/pengiriman') ?>" data-toggle="tooltip"
            data-placement="bottom" title="Tambah Data"><i class="fas fa-plus-circle"></i>
            Tambah Data</a>
    </div>
</div>
<div class="card card-outline card-danger">
    <div class="card-body">
        <table id="table-bayar" class="table table-striped table-bordered">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>ID PENGIRIMAN</th>
                    <th>JENIS BAYAR</th>
                    <th>KAS</th>
                    <th>NOMINAL</th>
                    <th>KETERANGAN</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pembayaran as $key => $value) : ?>
                <tr class="text-center">
                    <td><?= $value->no_pengiriman ?></td>
                    <td><?= $value->jenis_bayar ?></td>
                    <td><?= $value->kas ?></td>
                    <td><?= $value->nominal ?></td>
                    <td><?= $value->keterangan ?></td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-xs call-modal" id="edit-modal"
                            data-key="<?= $value->nomor ?>">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-xs delete" data-key="<?= $value->nomor ?>"> <i
                                class="fa fa-trash"></i></button>
                        <button
                            class="btn btn-xs show-image <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>"
                            data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar"
                            data-src="<?= base_url("/img/$page/" . $value->lampiran) ?>">
                            <i class=" fa fa-image"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#table-bayar').DataTable();
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
                data: `frm_table=pembayaran&token=123`,
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
    foreach ($pengiriman_belum_lunas as $key_belum_lunas => $value_belum_lunas) {
        $js_data['detail_'.$value_belum_lunas->no_transaksi]=$value_belum_lunas;
    }
    $js_data_append=json_encode($js_data);
    ?>
<form id="frm-bayar" action="#">
    <div class="row">
        <div class="col">
            <div class="card card-danger card-tabs">

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kode Referensi</label>
                                <div class="col-sm-9">
                                    <input name="val_nomor_reff" class="form-control" value="-" id="val_nomor_reff">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jenis Bayar</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2 data" style="width: 100%;"
                                        name="val_kd_jenis_bayar">
                                        <?php foreach ($jenis_bayar as $jb) : ?>
                                        <option value="<?php echo $jb->kd_jenis_bayar ?>"> <?php echo $jb->nama ?>
                                        </option>
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
                                <div class="col-sm-6">
                                    <select id="select-customer" class="form-control select2 data" style="width: 100%;"
                                        name="">
                                        <?php foreach ($customer_pengiriman as $pbl) : ?>
                                        <option value="<?php echo $pbl->kd_customer ?>">
                                            <?php echo $pbl->customer." ( ".$pbl->jumlah_nota." nota )" ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" id="get-pengiriman-customer"
                                        class="btn btn-primary btn-sm mt-1">Cek Pengiriman</button>
                                </div>
                                <input type="hidden" name="val_no_pengiriman" id="val-no-pengiriman">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Kas</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2 data" style="width: 100%;" name="val_kd_kas">
                                        <?php foreach ($kas as $kas1) : ?>
                                        <option value="<?php echo $kas1->kd_kas ?>"> <?php echo $kas1->no_rekening ?>
                                        </option>
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
                                    <input type="text" min="0" value="0" name="val_nominal"
                                        class="form-control allow-numeric" id="val_nominal">

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
                                    <textarea class="form-control" rows="3" name="val_keterangan">-</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6" id="detail-pengiriman">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="btn-batal">
            <button type="button" name="simpan" style="width: 150px;" class="btn btn-outline-dark"
                onclick="history.back(-1)" id="btn-close"><i style="color:red" class="fa fa-times"></i> Batal</button>
            <button type="submit" id="btn-save" style="float: right; width: 150px;" name="btn_submit" value="Simpan"
                class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </div>
</form>



<script type="text/javascript">
$('.select2').select2();
$(".allow-numeric").bind("keypress", function(e) {
    var key = event.keyCode || event.which;
    let val = $(this).val().split('.').length;
    // alert(key)
    if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key >= 95 && key < 123) || (key > 218 && key <
            223) || (key > 190 && key < 193) || (key == 130) || (key == 181) || (key == 144) || (key == 214) ||
        (key == 224) || (key == 233) || (key == 173) || (key == 61) || (key == 188) || (key == 59) || key ==
        189 || key == 187 || key == 190 || (key >= 91 && key <= 94) || key == 47 || key == 59 || (key >= 123 &&
            key <= 126) || key == 64 || (key >= 32 && key <= 44) || key == 58 || key == 63) {
        event.preventDefault();
    } else {
        if (key === 46 && val > 1) {
            event.preventDefault();
        } else {
            return true;
        }
    }
});
$('#get-pengiriman-customer').click(function() {
    let key = $('#select-customer').val();
    // alert(key);
    if (key != '') {
        $.ajax({
            type: 'POST',
            url: `<?=base_url() ?>/api/get_pengiriman_kredit`,
            data: {
                token: `<?=$_SESSION['token'] ?>`,
                kd_customer: key
            },
            success: function(r) {
                $('#m-container-load-pengiriman').html(r);
                $('#modal-load-pengiriman').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modal-load-pengiriman').modal('show');
            }
        });
    }
});
$('#modal-btn-set-pengiriman').click(function() {
    let no_tr_val = ``;
    let dt_pengiriman_html = ``
    $('.selected-pengiriman').each(function() {
        dt_pengiriman_html += `<ul>
                <li >Total: <strong>Rp ` + currencyFormat(parseFloat($(this).data('subtotal'))) + `</strong></li>
                <li >Total Cicilan: <strong>Rp ` + currencyFormat(parseFloat($(this).data('terbayar'))) + `</strong></li>
                <li >Sisa Cicilan: <strong>Rp ` + currencyFormat(parseFloat($(this).data('sisa'))) + `</strong></li>
                </ul>`;
        no_tr_val = $(this).data('no_transaksi');
    });
    if (dt_pengiriman_html != '' && no_tr_val != '') {
        $('#detail-pengiriman').html(dt_pengiriman_html);
        $('#val-no-pengiriman').val(no_tr_val);
        $('#modal-load-pengiriman').modal('hide');
    } else {
        alert('Maaf, anda belum memilih pengiriman apapun');
    }

    // console.log(kirim_belum_lunas);
    // alert(no_transaksi_selected);
});
$('#no-pengiriman').change(function() {
    let data_belum_lunas = <?=(!empty($js_data_append))?$js_data_append:array() ?>['detail_' + $(this).val()];
    // ['detail_'+$(this).val()]
    // console.log(data_belum_lunas);
    let ul_respon = `<ul>
            <li >Total: <strong>Rp ` + currencyFormat(parseFloat(data_belum_lunas.subtotal)) + `</strong></li>
            <li >Total Cicilan: <strong>Rp ` + currencyFormat(parseFloat(data_belum_lunas.total_cicilan)) + `</strong></li>
            <li >Sisa Cicilan: <strong>Rp ` + currencyFormat(parseFloat(data_belum_lunas.sisa_cicilan)) + `</strong></li>
            </ul>`;
    $('#detail-pengiriman').html(ul_respon);
    // let key= $(this).val();
    // $.ajax({
    //     type:'POST',
    //     url:`<?=base_url() ?>/api/bayar_tagihan_dt`,
    //     data:{no_transaksi:key,token:<?=$_SESSION['token'] ?>},
    //     dataType:'json',
    //     success:function(r){
    //         
    //         $('#detail-pengiriman').html(ul);
    //     }
    // });
});
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
$('#frm-bayar').submit(function(e) {
    e.preventDefault();
    let loading_button = `
            <div style="width:50px;margin-left:30%">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span></div>`;
    $('#btn-save').prop('disabled', true);
    $('#btn-save').html(loading_button);
    if ($('#val-no-pengiriman').val() != '') {
        if ($('#val_nominal').val() == 0) {
            alert('Nominal Pembayaran belum diisi')
            $('#btn-save').prop('disabled', false);
            $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
        } else {
            form_data = new FormData($('#frm-bayar')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'pembayaran');
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
                        tes_sweet('simpan data berhasil');
                        swal2_confirm(`<?= base_url() ?>/load/view/pembayaran/pengiriman`);
                    } else {
                        $('#btn-save').prop('disabled', false);
                        $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
                    }
                }
            });
        }
    } else {
        alert('Maaf Anda belum memilih Pengiriman yang akan dibayarkan')
        $('#btn-save').prop('disabled', false);
        $('#btn-save').html(`<i class="fas fa-save"></i> Simpan`);
    }

})
</script>
<?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
<input type="hidden" id="key-update" name="key_nomor" value="<?= $edit_data->nomor ?>">
<div class=" form-group row">
    <label for="val_no_pengiriman" class="col-sm-2 col-form-label">ID Pengiriman</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="val_no_pengiriman" id="val_no_pengiriman"
            value="<?= $edit_data->no_pengiriman ?>"><br>
    </div>
</div>
<div class=" form-group row">
    <label for="val_kd_jenis_bayar" class="col-sm-2 col-form-label">Jenis Bayar</label>
    <div class="col-sm-10">
        <select id="val_kd_jenis_bayar" name="val_kd_jenis_bayar" class="form-control">
            <?php foreach ($jenis_bayar as $jeb => $value) : ?>
            <option value="<?= $value->kd_jenis_bayar ?>"
                <?= ($edit_data->kd_jenis_bayar == $value->kd_jenis_bayar) ? 'selected' : '' ?>>
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
            <option value="<?= $value->kd_kas ?>" <?= ($edit_data->kd_kas == $value->kd_kas) ? 'selected' : '' ?>>
                <?php echo $value->no_rekening ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="val_nominal" class="col-sm-2 col-form-label">Nominal</label>
    <div class="col-sm-10">
        <input type="text" class="form-control allow-numeric" name="val_nominal" id="val_nominal"
            value="<?= $edit_data->nominal ?>"><br>
    </div>
</div>
<div class="form-group row">
    <label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
    <div class="col-sm-10">
        <textarea id="val_keterangan" rows="10" name="val_keterangan"
            class="form-control"><?= $edit_data->keterangan ?></textarea>
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
$(".allow-numeric").bind("keypress", function(e) {
    var key = event.keyCode || event.which;
    let val = $(this).val().split('.').length;
    if ((key > 64 && key < 91) || (key > 159 && key < 166) || (key >= 95 && key < 123) || (key > 218 && key <
            223) || (key > 190 && key < 193) || (key == 130) || (key == 181) || (key == 144) || (key == 214) ||
        (key == 224) || (key == 233) || (key == 173) || (key == 61) || (key == 188) || (key == 59) || key ==
        189 || key == 187 || key == 190 || (key >= 91 && key <= 94) || key == 47 || key == 59 || (key >= 123 &&
            key <= 126) || key == 64 || (key >= 32 && key <= 44) || key == 58 || key == 63) {
        event.preventDefault();
    } else {
        if (key === 46 && val > 1) {
            event.preventDefault();
        } else {
            return true;
        }
    }
});

function previewgmbrbayar() {
    let frame = document.getElementById('gmbrbayar');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<?php
} elseif (isset($act) && $act == 'show_pengiriman') {
    $data_js=array();
    foreach ($pengiriman_belum_lunas as $key_dt => $value_dt) {
        $data_js['detail_'.$value_dt->no_transaksi]=$value_dt;
    }
    $data_js_json=json_encode($data_js);

    ?>
<div class="row">
    <?php foreach ($pengiriman_belum_lunas as $key => $value): ?>
    <div class="col-md-6 col-sm-6" style="padding-top:10px;" id="card-item_">
        <div class="card card-list-pengiriman" id="card-list_<?=$key?>" style="border: ridge 1px; ">
            <div class="card-body p-2 card-clickable" data-key="<?=$key ?>"
                data-no_transaksi="<?=$value->no_transaksi ?>" data-subtotal="<?=$value->subtotal ?>"
                data-terbayar="<?=$value->total_cicilan ?>" data-sisa="<?=$value->sisa_cicilan ?>"
                style="cursor: pointer;">
                <div class="row ">
                    <div class="col-md-4 col-12">
                        <p style="font-size:14px;font-weight:bold;color:black">Transaksi No:
                            <strong class="" style="color: green"><?=$value->no_transaksi ?></strong>
                        </p>
                    </div>
                    <div class="col-md-8 col-12" style="text-align:right">
                        <p style="font-size:14px; font-weight:bold;color:black" class="badge badge-default">Belum Bayar:
                            <span style="color: red">Rp <?=number_format($value->sisa_cicilan,0,',','.') ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="row">
                    <div class="col-12 col-md-6" style="padding: 3px;font-size:14px; font-weight:bold;color:black">
                        <span>Total: </span>
                        <span style="color: grey">Rp <?=number_format($value->subtotal,0,',','.') ?> </span>
                    </div>
                    <div class="col-12 col-md-6" style="text-align: right;font-size:14px; font-weight:bold;color:black">
                        <span>Dibayar:</span>
                        <span style="color: grey"> Rp <?=number_format($value->total_cicilan,0,',','.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>
<script type="text/javascript">
$('.card-clickable').click(function() {
    let key = $(this).data('key');
    $('.card-list-pengiriman').css('background-color', '');
    $('.card-clickable').removeClass('selected-pengiriman');
    if ($(this).hasClass('selected-pengiriman')) {
        $(this).removeClass('selected-pengiriman')
    } else {
        $(this).removeClass('not-selected-pengiriman');
        $(this).addClass('selected-pengiriman');
        // $('.card-list-pengiriman').css('background-color','');
        $('#card-list_' + key).css('background-color', '#7bed9f');
        // $('#subtotal-kirim').val($(this).data('subtotal'));
        // $('#terbayar-kirim').val($(this).data('terbayar'));
        // $('#sisa-cicilan-kirim').val($(this).data('sisa'));

    }
})
</script>
<?php
}else {
    echo view('errors/html/error_404');
}

?>