<?php



// print_r($customer);
// print_r($kabupaten);
if (isset($act) && $act == "view") {
    ?>
<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= site_url('load/add/customer/master') ?>" data-toggle="tooltip"
            data-placement="bottom" title="Tambah Data Customer"><i class="fas fa-plus-circle"></i>
            Tambah Customer</a>
    </div>
</div>
<div class="card card-outline card-danger">
    <div class="card-body">
        <table class="table table-hover table-bordered" id="table-data" style="width: 100%;">
            <thead class="bg-danger">
                <tr class="text-center">
                    <th>NO</th>
                    <!-- <th>No. Reff</th> -->
                    <th>KATEGORI</th>
                    <!-- <th>Kabupaten</th> -->
                    <!-- <th>Nomor</th> -->
                    <th>NAMA</th>
                    <th>ALAMAT</th>
                    <th>NO. HP</th>
                    <th>LIMIT KREDIT</th>
                    <!-- <th>Status</th> -->
                    <!-- <th>Lampiran</th> -->
                    <th></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($customer as $key => $value) : ?>
                <tr class="text-center">
                    <td><?= $key + 1; ?></td>
                    <td class="text-left"><?= $value->kategori ?></td>
                    <td class="text-left"><?= $value->nama ?></td>
                    <td class="text-left"><?= $value->alamat . ', ' . $value->kabupaten ?></td>
                    <td class="text-right"><?= $value->hp ?></td>
                    <td class="text-right"><?php echo number_format($value->limit_kredit, 0, ',', '.') ?></td>

                    <td>
                        <?php if ($value->kd_customer!=-1): ?>
                        <button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status"
                            data-key='<?= $value->kd_customer ?>'><i
                                class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>"
                                aria-hidden="true"></i>
                            <!-- <?= $value->status == 1 ? 'Aktif' : 'Nonaktif' ?> -->
                        </button>
                        <button class="btn btn-xs btn-warning call-modal" id="edit-modal" data-toggle="tooltip"
                            data-placement="bottom" title="Edit Data" data-key="<?= $value->kd_customer ?>">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-xs btn-danger delete" data-toggle="tooltip" data-placement="bottom"
                            title="Hapus Data" data-key="<?= $value->kd_customer ?>"><i class=" fas fa-trash"></i>
                        </button>
                        <button
                            class="btn btn-xs show-image <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>"
                            data-toggle="tooltip" data-placement="bottom" title="Lihat Gambar"
                            data-src="<?= base_url("/img/$page/" . $value->lampiran) ?>">
                            <i class=" fa fa-image"></i>
                        </button>
                        <?php endif ?>

                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$('#table-data').DataTable({
    'scrollX': true
})
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
$('#table-data').on('click', '.call-modal', function() {
    // alert($(this).data('key'));
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
    // alert(`<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}/` + key + '/true');
    $.ajax({
        type: 'POST',
        url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}/` + key + '/true',
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
$('#table-data').on('click', '.delete', function() {
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
                data: `frm_table=customer&token=123`,
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
<form id="frm-customer" action="#">
    <div class="card card-danger card-outline">
        <div class="card-body">
            <div class="form-group row">
                <label for="fname" class="col-sm-2 col-md-3 col-form-label">Kode Referensi</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" id="val_kd_customer_reff" name="val_kd_customer_reff" value="-"
                        class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-3 col-form-label">Nama</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" id="val_nama" placeholder="Masukkan nama" name="val_nama" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="subject" class="col-sm-2 col-md-3 col-form-label">Alamat</label>
                <div class="col-sm-8 col-md-4">
                    <textarea id="val_alamat" name="val_alamat" placeholder="Masukkan alamat" style="height:80px"
                        class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="kabupaten" class="col-sm-2 col-md-3 col-form-label">Kabupaten</label>
                <div class="col-sm-8 col-md-4">
                    <input name="val_kd_kabupaten" class="form-control" id="namaKabupaten"
                        placeholder="Isikan Nama Kabupaten" required>
                    <div id="kabupaten-list" style="z-index:999" class="position-relative"></div>
                    <input type="hidden" id="kabupaten-list1" name="val_kd_kabupaten">
                </div>

                <style>
                .autocomplete_li:hover {
                    background-color: #7FFFD4;
                }
                </style>

            </div>

            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-3 col-form-label">Nomor HP</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" id="val_hp" placeholder="Masukkan nomor HP" name="val_hp" class="form-control"
                        value="-">
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-3 col-form-label">Limit Kredit</label>
                <div class="col-sm-8 col-md-4">
                    <input type="text" id="val_limit_kredit" placeholder="Masukkan limit kredit" name="val_limit_kredit"
                        class="form-control" value="0">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3 col-form-label">
                    <label for="val_status">Status</label>
                </div>
                <div class="col-sm-2" id="radio-aktif">
                    <p><input type='radio' class="data" name="val_status" value="1" checked /> Aktif</p>
                </div>
                <div class="col-sm-2" id="radio-aktif1">
                    <p><input type='radio' class="data" name="val_status" value="0" /> Non-Akif</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Lampiran</label>
                <div class="col-sm">
                    <div class="row col-md-6">
                        <img id="customeradd" src="" style=" width: 100px; height:100px;">
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <input type="file" name="val_lampiran" id="val_lampiran" onchange="addcustomer()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="lname" class="col-sm-2 col-md-3 col-form-label">Kategori</label>
                <div class="col-sm-8 col-md-4">
                    <select name="val_kd_kategori" id="add-modal-val-kd-kategori" class="form-control select2">
                        <!-- <option selected="0">pilih..</option> -->
                        <?php foreach ($customer_kategori as $cs => $value) : ?>
                        <option value="<?php echo $value->kd_kategori; ?>"> <?php echo $value->nama ?> </option>
                        <?php endforeach; ?>
                        <option value="" class="">+ Tambah Kategori</option>
                    </select>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="button" name="simpan" style="float: left;" class="btn btn-light"
                    onclick="history.back(-1)" id="btn-close"><i style="color:black" class="fa fa-arrow-left"></i>
                    Kembali</button>
                <button type="submit" id="btn-save" style="float: right;" name="btn_submit" class="btn btn-primary"><i
                        class="fas fa-save"></i>Simpan</button>
            </div>
        </div>
    </div>

</form>
<script type="text/javascript">
$(':input').click(function() {
    $(this).select();
});
$('#namaKabupaten').keyup(function() {

    var query = $(this).val();
    // alert(query);
    if (query != '') {
        $.ajax({
            method: "POST",
            url: `<?= base_url() ?>/api/kabupaten_ac`,
            data: {
                token: 123,
                kabupaten_name: query
            },
            success: function(r) {
                console.log(r);
                $('#kabupaten-list').html(r);
                $('#kabupaten-list').fadeIn();
                complete_id(query);
                // $('#kabupaten-ac').addClass('z-index', '99');

            }
        });
    } else {
        $('#kabupaten-list').fadeOut();
    }
});
$(document).on('click', '.kabupaten-list', function() {
    $('#namaKabupaten').val($(this).text());
    $('#kabupaten-list1').val($(this).data('key'));
    $('#kabupaten-list').fadeOut();
});

function complete_id(search) {
    $('.autocomplete_li').each(function() {
        if ($(this).text().toUpperCase() == search.toUpperCase()) {
            $('#kabupaten-list1').val($(this).data('key'));
            $('#namaKabupaten').val($(this).text());
            $('#kabupaten-list').fadeOut();


        } else {
            // $('#kd-' + type).val('');
        }
    });
}
</script>
<script>
$('.select2').select2()

function addcustomer() {
    let frame = document.getElementById('customeradd');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>

<script type="text/javascript">
$('#add-modal-val-kd-kategori').change(function() {
    let val = $(this).val();
    if (val == "") {
        let key = $(this).data('key');
        let page = 'jenis';
        let jenis = `<?= $jenis ?>`;
        let jenis_modal = $(this).attr('id');
        let act = "add";
        let title_modal = "Tambah Kategori Customer";

        $.ajax({
            type: 'POST',
            url: `<?= base_url() ?>/ajax_load/${act}/customer_kategori/${jenis}` + key + '/true',
            success: function(r) {
                // alert(title_modal);
                $('#m-crud-title').text(title_modal);
                $('#m-crud-key').text(key);
                $('#m-crud-act').text(act);
                $('#m-crud-page').text('customer_kategori');
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
$('#frm-customer').submit(function(e) {
    e.preventDefault();
    let loading_button = `
        <div style="width:50px;margin-left:30%">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span></div>`;
    e.preventDefault();
    $('#btn-save').prop('disabled', true);
    $('#btn-save').html(loading_button);

    form_data = new FormData($('#frm-customer')[0]);
    form_data.append('token', '123');
    form_data.append('frm_table', 'customer');
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
                tes_sweet('tambah data customer berhasil');
                location.href = `<?= base_url() ?>/load/view/customer/master`;
            }
        }

    });
})
</script>

<?php
} elseif (isset($act) && $act == 'edit' && $modal) {

    ?>
<input type="hidden" id="key-update" name="key_kd_customer" value="<?= $edit_data->kd_customer ?>">
<hr>
<div class="container">

    <div class="form-group row">
        <label for="fname" class="col-sm-2 col-md-3 col-md-3 col-form-label">Kode Referensi</label>
        <div class="col-sm-10 col-md-8">
            <input type="text" id="val_kd_customer_reff" name="val_kd_customer_reff" class="form-control"
                value="<?= $edit_data->kd_customer_reff ?>">
        </div>
    </div>

    <!-- </div> -->
    <div class="form-group row">
        <label for="lname" class="col-sm-2 col-md-3 col-md-3 col-form-label">Nomor</label>
        <div class="col-sm-10 col-md-8">
            <input type="text" id="val_nomor" name="val_nomor" class="form-control" value="<?= $edit_data->nomor ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="lname" class="col-sm-2 col-md-3 col-md-3 col-form-label">Nama</label>
        <div class="col-sm-10 col-md-8">
            <input type="text" id="val_nama" name="val_nama" class="form-control" value="<?= $edit_data->nama ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="subject" class="col-sm-2 col-md-3 col-md-3 col-form-label">Alamat</label>
        <div class="col-sm-10 col-md-8">
            <textarea id="val_alamat" name="val_alamat" style="height:80px"
                class="form-control"><?= $edit_data->alamat ?></textarea>
        </div>
    </div>
    <div class=" form-group row">
        <label for="kabupaten" class="col-sm-2 col-md-3 col-md-3 col-form-label">Kabupaten</label>
        <div class="col-sm-10 col-md-8">
            <select name="val_kd_kabupaten" id="val_kd_kabupaten" class="form-control select2">
                <?php foreach ($kabupaten as $kab => $value) : ?>
                <option value="<?= $value->kd_kabupaten ?>"
                    <?= ($edit_data->kd_kabupaten == $value->kd_kabupaten) ? 'selected' : '' ?>>
                    <?php echo $value->nama ?>
                </option>
                <?php endforeach; ?>
            </select>

        </div>
    </div>


    <div class="form-group row">
        <label for="lname" class="col-sm-2 col-md-3 col-md-3 col-form-label">Nomor HP</label>
        <div class="col-sm-10 col-md-8">
            <input type="text" id="val_hp" name="val_hp" class="form-control" value="<?= $edit_data->hp ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="lname" class="col-sm-2 col-md-3 col-md-3 col-form-label">Limit Kredit</label>
        <div class="col-sm-10 col-md-8">
            <input type="text" id="val_limit_kredit" name="val_limit_kredit" class="form-control"
                value="<?= $edit_data->limit_kredit ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="val_status" class="col-sm-3 col-form-label">Status</label>
        <div class="col-sm-3" id="radio-aktif">
            <p><input type='radio' name="val_status" value="1" <?= ($edit_data->status == '1') ? 'checked' : '' ?>>
                Aktif
            </p>

        </div>
        <div class="col-sm-3" id="radio-aktif1">
            <p><input type='radio' name="val_status" value="0" <?= ($edit_data->status == '0') ? 'checked' : '' ?>>
                Non-Akif</p>
        </div>
    </div>
    <div class="form-group row">
        <label for="val_status" class="col-sm-2 col-md-3 col-md-3 col-form-label">Lampiran</label>
        <div class="col-sm">
            <div class="row col-md-6">
                <img id="customeredit" src="" style=" width: 100px; height:100px;">
            </div>
            <div class="row mt-2 col-md-6">
                <input type="file" name="val_lampiran" id="val_lampiran" onchange="editcustomer()">
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="kategori" class="col-sm-2 col-md-3 col-md-3 col-form-label">Kategori</label>
        <div class="col-sm-10 col-md-8">
            <select name="val_kd_kategori" id="val_kd_kategori" class="form-control select2">
                <?php foreach ($customer_kategori as $cs => $value) : ?>
                <option value="<?= $value->kd_kategori ?>"
                    <?= ($edit_data->kd_kategori == $value->kd_kategori) ? 'selected' : '' ?>>
                    <?php echo $value->nama ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

</div>
<script>
$('.select2').select2()

function editcustomer() {
    let frame = document.getElementById('customeredit');
    frame.src = URL.createObjectURL(event.target.files[0]);
}
</script>
<?php
} else {
    echo view('errors/html/error_404');
}

?>