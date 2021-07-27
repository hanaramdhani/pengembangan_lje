<?php 
$data_append = array();
foreach ($pengiriman_detail as $key_row => $value_row) {
    $data_append["detail_" . $value_row->no_transaksi][] = $value_row;
}
$test = json_encode($data_append);
?>
<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= site_url('load/add/pengiriman/pengiriman') ?>">
            <i class="fas fa-plus-circle"></i> Pengiriman Baru</a>
    </div>
</div>
</div>

<div class="card card-outline card-danger">
    <div class="card-body">
        <table id="data-tampil" class="table table-bordered" style="width:100%">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>No.</th>
                    <th>Reff.</th>
                    <th>Divisi</th>
                    <th>Customer</th>
                    <th>From - to </th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pengiriman as $key => $value) : ?>

                <tr>
                    <td>
                        <button type="button" class="btn btn-info btn-xs data-tampil text-left"
                            data-key="<?= $value->no_transaksi ?>" data-layanan="<?= $value->kd_layanan ?>"
                            data-kota_asal="<?= $value->kd_lokasi_asal ?>"
                            data-kota_tujuan="<?= $value->kd_lokasi_tujuan ?>">
                            <i class="fa fa-eye"></i>
                        </button>
                        <?= $value->no_transaksi ?>
                    </td>
                    <td><?= $value->no_transaksi_reff ?></td>
                    <td><?= $value->divisi ?></td>
                    <td><?= $value->customer ?></td>
                    <td><?= $value->nama_pengirim ?> - <?= $value->nama_penerima ?> (<?= $value->layanan ?>)</td>
                    <td><?= $value->tanggal ?></td>
                    <td style="text-align: right;">Rp <?= number_format($value->total,0,',','.') ?></td>
                    <!-- <td></td>
                        <td><?= $value->tujuan ?></td>
                        <td></td> -->
                    <!-- <td><?= $value->diskon ?></td>
                        <td><?= $value->nama_pengirim ?></td>
                        <td><?= $value->nama_penerima ?></td>
                        <td><?= $value->alamat_pengirim ?></td>
                        <td><?= $value->alamat_penerima ?></td>
                        <td><?= $value->no_hp_pengirim ?></td>
                        <td><?= $value->no_hp_penerima ?></td>
                        <td><?= $value->nomor ?></td>
                        <td><?= $value->tanggal ?></td>
                        <td><?= $value->status ?></td>
                        <td><?= $value->lama_kredit ?></td>
                        <td><?= $value->diskon ?></td>
                        <td><?= $value->keterangan ?></td>
                        <td><?= $value->lampiran ?></td>
                        <td><?= $value->kd_user ?></td> -->
                    <td class="text-center" width="160px">
                        <a href="<?= site_url('load/edit/pengiriman/pengiriman/') . $value->no_transaksi ?>"
                            class="btn btn-warning btn-xs" data-key="<?= $value->no_transaksi ?>">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete" data-key="<?= $value->no_transaksi ?>">
                            <i class="fa fa-trash"></i>
                        </button>

                        <button
                            class="btn btn-xs show-image <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>"
                            data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar"
                            data-src="<?= base_url("/img/$page/" . $value->lampiran) ?>">
                            <i class=" fa fa-image"></i>
                        </button>
                        <!-- <a href="<?= base_url('printController/generatePDF/pengiriman?no_transaksi=' . $value->no_transaksi . '&title=Struk Pengiriman'); ?>" target="_blank" class="btn btn-xs btn-default"><i class="fas fa-print"></i></a> -->
                        <a href="<?= base_url('printController/generatemPDF/pengiriman?no_transaksi=' . $value->no_transaksi . '&title=Struk Pengiriman'); ?>"
                            target="_blank" class="btn btn-xs btn-default"><i class="fas fa-print"></i></a>
                        <!-- edit modal
                            <button type="button" class="btn btn-warning btn-xs edit-master" data-key="<?= $value->no_transaksi ?>">
                                <i class="fa fa-edit"></i>
                            </button> -->
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#data-tampil').DataTable();
});
$('.show-image').click(function() {
    let url = $(this).data('src');
    $('#imagepreview').attr('src', url);
    $('#imagepreview').addClass('after-load');
    $('#imagepreview').removeClass('before-load');
    $('#imagemodal').modal('show');
});

function format(data, layanan, kota_asal, kota_tujuan) {
    let pengiriman_detail = <?= (!empty($test)) ? $test : '' ?>['detail_' + data];
    console.log(pengiriman_detail);
    let dimensi = ``;
    let content = ``;
    if (pengiriman_detail != "") {
        for (var i = 0; i < pengiriman_detail.length; i++) {

            dimensi = (pengiriman_detail[i]['panjang'] * pengiriman_detail[i]['lebar'] * pengiriman_detail[i][
                    'tinggi'
                ] != 0) ? pengiriman_detail[i]['panjang'] + ` * ` + pengiriman_detail[i]['lebar'] + ` * ` +
                pengiriman_detail[i]['tinggi'] : `0`;
            // alert(dimensi);
            content += `
                <tr style="background-color:azure">
                <td>` + (i + 1) + `</td>
                <td>` + pengiriman_detail[i]['keterangan1'] + `</td>
                <td>` + pengiriman_detail[i]['jenis_kirim'] + `</td>
                <td>` + dimensi + `</td>
                <td>` + pengiriman_detail[i]['jumlah_berat'] + `</td>
                <td>` + pengiriman_detail[i]['diskon'] + `</td>
                <td>` + pengiriman_detail[i]['harga_berat'] + `</td>
                <td>` + pengiriman_detail[i]['harga_volume'] + `</td>
                <td>` + pengiriman_detail[i]['harga_koli'] + `</td>
                <td>` + pengiriman_detail[i]['jumlah_item'] + `</td>
                <td> <button class="btn btn-xs btn-warning" onclick="edit_pengiriman_detail(` +
                pengiriman_detail[i]['nomor'] + `,'` + layanan + `','` + `${kota_asal}','${kota_tujuan}` + `','` +
                pengiriman_detail[i]['kd_jenis'] + `')"><i class="fa fa-edit"></i></button> </td>
                </tr>
                `;
        }
    }
    let html_content = `<div class="slider container-fluid" name>
        <table class="table table-responsive table-condensed" style="opacity:0.9">
        <tr>
        <th>#</th>
        <td>Item</td>
        <td>Jenis Kirim</td>
        <td>Dimensi</td>
        
        <td>Berat</td>
        <td>Diskon</td>
        <td>Harga Berat</td>
        <td>Harga Volume</td>
        <td>Harga Koli</td>
        <td>Jumlah harga_koli</td>
        </tr>
        ` + content + `
        </table>
        </div>`;
    return html_content;

}

function edit_pengiriman_detail(key_update, kd_layanan, kd_kota_asal, kd_kota_tujuan, kd_jenis) {
    // console.log(kd_layanan);
    // $.ajax({
    //     type: 'POST',
    //     url: `<?= base_url() ?>/ajax_load/edit/pengiriman_detail/pengiriman/` + key_update + `/true`,
    //     success: function(r) {
    //         alert('ss')
    //         $('#m-crud-title').text('Edit Detail Pengiriman');
    //         $('#m-crud-key').text(key_update);
    //         $('#m-crud-act').text('edit');
    //         $('#m-crud-page').text('pengiriman_detail');
    //         $('#m-crud-jenis').text('master');
    //         $('#m-container-crud').html(r);
    //         $('#modal-crud').modal('show');
    //         $('#hrg_volume').change(function() {
    //             volume();

    //         });

    //     }

    // })

    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/get_min/${kd_kota_asal}/${kd_kota_tujuan}/${kd_jenis}/${kd_layanan}/${key_update}`,
        data: {
            token: 123,
        },
        // dataType: 'JSON',
        success: function(r) {
            $('#m-crud-title').text('Edit Detail Pengiriman');
            $('#m-crud-key').text(key_update);
            $('#m-crud-act').text('edit');
            $('#m-crud-page').text('pengiriman_detail');
            $('#m-crud-jenis').text('master');
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
            $('#hrg_volume').change(function() {
                volume();
            });
        }
    });
};


$("#data-tampil").on('click', '.data-tampil', function() {
    var table = $('#data-tampil').DataTable();
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var layanan = $(this).data('layanan');
    var kota_asal = $(this).data('kota_asal');
    var kota_tujuan = $(this).data('kota_tujuan');

    if (row.child.isShown()) {
        $('div.slider', row.child()).slideUp(function() {
            row.child.hide();
            tr.removeClass('shown');
        });
    } else {
        row.child(format($(this).data('key'), layanan, kota_asal, kota_tujuan)).show();
        tr.addClass('shown');
        $('div.slider', row.child()).slideDown();
    }
});
$("#data-tampil").on('click', '.edit-master', function() {
    let key_update = $(this).data('key');
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/edit/pengiriman/pengiriman/` + key_update + `/true`,
        success: function(r) {
            $('#m-crud-title').text('Edit Pengiriman');
            $('#m-crud-key').text(key_update);
            $('#m-crud-act').text('edit');
            $('#m-crud-page').text('pengiriman');
            $('#m-crud-jenis').text('master');
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
        }
    });
    if (row.child.isShown()) {
        $('div.slider', row.child()).slideUp(function() {
            row.child.hide();
            tr.removeClass('shown');
        });
    } else {
        row.child(format($(this).data('key'))).show();
        tr.addClass('shown');
    }
});

function edit_pengiriman_detail(key_update, kd_layanan, kd_kota_asal, kd_kota_tujuan, kd_jenis) {
    // console.log(kd_layanan);
    // $.ajax({
    //     type: 'POST',
    //     url: `<?= base_url() ?>/ajax_load/edit/pengiriman_detail/pengiriman/` + key_update + `/true`,
    //     success: function(r) {
    //         alert('ss')
    //         $('#m-crud-title').text('Edit Detail Pengiriman');
    //         $('#m-crud-key').text(key_update);
    //         $('#m-crud-act').text('edit');
    //         $('#m-crud-page').text('pengiriman_detail');
    //         $('#m-crud-jenis').text('master');
    //         $('#m-container-crud').html(r);
    //         $('#modal-crud').modal('show');
    //         $('#hrg_volume').change(function() {
    //             volume();
    //         });
    //     }
    // })
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/api/get_min/${kd_kota_asal}/${kd_kota_tujuan}/${kd_jenis}/${kd_layanan}/${key_update}`,
        data: {
            token: 123,
        },
        success: function(r) {
            $('#m-crud-title').text('Edit Detail Pengiriman');
            $('#m-crud-key').text(key_update);
            $('#m-crud-act').text('edit');
            $('#m-crud-page').text('pengiriman_detail');
            $('#m-crud-jenis').text('master');
            $('#m-container-crud').html(r);
            $('#modal-crud').modal('show');
            $('#hrg_volume').change(function() {
                volume();
            });

        }
    });
};

$('#data-tampil').on('click', '.delete', function() {
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
                data: `frm_table=pengiriman&token=123`,
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