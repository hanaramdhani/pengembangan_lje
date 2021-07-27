<?php

if (isset($act) && $act == "view") {
    ?>
    <h1 style="margin-top: 20px" align="center">Page AJAX view</h1>
    <hr>
    <button class="btn btn-primary" id="get_ongkir" >Get Ongkir(test)</button>
    <button class="btn btn-primary call-modal" id="add-modal" data-key="-1">Tambah via modal</button>

    <a class="btn btn-danger" href="<?= site_url('load/add/user_group/master') ?>"> Tambah via link</a>
    <hr>
    <div class="form-group ">
        <label>Nama Provinsi</label>  
        <input type="text" id="kota-asal" class="form-control" placeholder="Kota Asal" />
        <input type="text" id="kota-tujuan" class="form-control" placeholder="Kota Asal" />
        <!-- <input type="text" id="kota-tujuan" class="form-control" placeholder="Kota Tujuan" /> -->
        <div id="kota-asal-list" class="position-relative"></div>
        <input type="text" name="val_kd_kota_asal" id="kd-kota-asal">

        <div id="kota-tujuan-list" class="position-relative"></div>
        <input type="text" name="val_kd_kota_tujuan" id="kd-kota-tujuan">
    </div>
    <table class="table table-condensed">
        <tr>
            <th>NAMA</th>
            <th>DESKRIPSI</th>
            <th>STATUS</th>
            <th>LAMPIRAN</th>
            <th>AKSI</th>
        </tr>
        <?php foreach ($user_group as $key => $value) : ?>
            <tr>
                <td><?= $value->nama ?></td>
                <td><?= $value->deskripsi ?></td>
                <td><?= $value->status ?></td>
                <td><?= $value->lampiran ?></td>
                <td>
                    <a class="btn btn-danger" href="<?= site_url('load/edit/user_group/master/') . $value->kd_group ?>"> Edit
                        via
                    link</a>
                    <button class="btn btn-warning call-modal" data-key="<?= $value->kd_group ?>" id="edit-modal">EDIT
                    modal</button>
                    <button class="btn btn-danger delete" data-key="<?= $value->kd_group ?>">DELETE</button>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <style>
        .autocomplete_li:hover{
            background-color:#7FFFD4;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){  
            $('#kota-asal').keyup(function(){  
                var query = $(this).val();  
                if(query != '')  
                {  
                    $.ajax({  
                        url:`<?=base_url() ?>/api/lokasi`,
                        method:"POST",  
                        data:{token:'123',search_key:query,find_type:'kota_asal',find_condition:''},  
                        success:function(r){  
                            console.log(r);

                            $('#kota-asal-list').html(r);  
                            $('#kota-asal-list').fadeIn();
                            set_autocomplete_id(query,'kota-asal');
                        }  
                    });  
                }else{
                    $('#kota-asal-list').fadeOut(); 
                }
            });
            $('#kota-tujuan').keyup(function(){  
                var query = $(this).val();  
                if(query != '')  
                {  
                    $.ajax({  
                        url:`<?=base_url() ?>/api/lokasi`,
                        method:"POST",  
                        data:{token:'123',search_key:query,find_type:'kota_tujuan',find_condition:''},  
                        success:function(r){  
                            console.log(r);

                            $('#kota-tujuan-list').html(r);  
                            $('#kota-tujuan-list').fadeIn();
                            set_autocomplete_id(query,'kota-tujuan');
                        }  
                    });  
                }else{
                    $('#kota-tujuan-list').fadeOut(); 
                }
            });  
            $(document).on('click', '.li-kota-asal', function(){  
                $('#kota-asal').val($(this).text());  
                $('#kd-kota-asal').val($(this).data('key'));
                $('#kota-asal-list').fadeOut();  
            });
            $(document).on('click', '.li-kota-tujuan', function(){  
                $('#kota-tujuan').val($(this).text());  
                $('#kd-kota-tujuan').val($(this).data('key'));
                $('#kota-tujuan-list').fadeOut();  
            });  
            function set_autocomplete_id(search,type){

                $('.autocomplete_li').each(function(){
                    if ($(this).text().toUpperCase()==search.toUpperCase()) {
                        $('#kd-'+type).val($(this).data('key'));
                        $('#'+type).val($(this).text());  
                        $('#'+type+'-list').fadeOut();  
                    }else{
                        $('#kd-'+type).val('');
                    }
                });
            }
        }); 
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
        $('#get_ongkir').click(function(){
            $.ajax({
                type:'POST',
                url:`<?=base_url() ?>/api/get_ongkir`,
                data:{layanan:9,jenis_kirim:1,lokasi_asal:7,lokasi_tujuan:7,token:'123'},
                dataType:'json',
                success:function(r){
                    console.log(r);
                }
            });
        });
    </script>
    <?php
} elseif (isset($act) && $act == "add" && !$modal) {
    // print_r($_SESSION);
    ?>
    <h1 style="margin-top: 20px" align="center">Page AJAX add</h1>
    <hr>
    <form id="frm-user-group" action="#">
        <label>Nama</label>
        <input type="text" name="val_nama" placeholder="nama">
        <label>Deskripsi</label>
        <input type="text" name="val_deskripsi" placeholder="deskripsi">
        <label>Status</label>
        <!-- <input type="text" name="val_status" placeholder="status"> -->
        <div class="input-group">
            <select class="custom-select" id="inputGroupSelect04">
                <option selected>Choose...</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-plus"></i></button>
            </div>
        </div>

        <input type="file" name="val_lampiran" id="file">
        <input type="submit" name="btn_submit" value="Simpan" class="btn btn-success">
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
        $('#frm-user-group').submit(function(e) {
            e.preventDefault();
            form_data = new FormData($('#frm-user-group')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'user_group');
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
                        location.href = `<?= base_url() ?>/load/view/user_group/master`;
                    }
                }

            });
        })
    </script>
    <?php
} elseif (isset($act) && $act == "edit" && !$modal) {
    ?>
    <h1 style="margin-top: 20px" align="center">Page AJAX edit</h1>
    <hr>
    <form id="frm-user-group-edit" action="#">
        <input type="hidden" id="key-update" name="key_kd_group" value="<?= $edit_data->kd_group ?>">
        <label>Nama</label>
        <input type="text" name="val_nama" placeholder="nama" value="<?= $edit_data->nama ?>">
        <label>Deskripsi</label>
        <input type="text" name="val_deskripsi" placeholder="deskripsi" value="<?= $edit_data->deskripsi ?>">
        <label>Status</label>
        <!-- <input type="text" name="val_status" placeholder="status" value="<?= $edit_data->status ?>"> -->
        <select name="val_status">
            <option value="1" <?= ($edit_data->status == '1') ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= ($edit_data->status == '0') ? 'selected' : '' ?>>Non-Aktif</option>
        </select>
        <input type="file" name="val_lampiran" id="file">
        <input type="submit" name="btn_submit" value="Simpan" class="btn btn-success">
    </form>
    <script type="text/javascript">
        $('#frm-user-group-edit').submit(function(e) {
            e.preventDefault();
            form_data = new FormData($('#frm-user-group-edit')[0]);
            form_data.append('token', '123');
            form_data.append('frm_table', 'user_group');
            key = $('#key-update').val();
            $.ajax({
                type: 'POST',
                url: `<?= base_url() ?>/api/update/${key}/execute`,
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
                        location.href = `<?= base_url() ?>/load/view/user_group/master`;
                    }
                }

            });
        })
    </script>
    <?php
} elseif (isset($act) && $act == 'add' && $modal) {
    ?>
    <label>Nama</label>
    <input type="text" name="val_nama" placeholder="nama"> <br>
    <label>Deskripsi</label>
    <input type="text" name="val_deskripsi" placeholder="deskripsi"><br>
    <label>Status</label>
    <!-- <input type="text" name="val_status" placeholder="status"> -->
    <select name="val_status">
        <option value="1">Aktif</option>
        <option value="0">Non-Aktif</option>
    </select>
    <input type="file" name="val_lampiran" id="file">
    <?php
} elseif (isset($act) && $act == 'edit' && $modal) {
    ?>
    <input type="hidden" id="key-update" name="key_kd_group" value="<?= $edit_data->kd_group ?>">
    <label>Nama</label>
    <input type="text" name="val_nama" placeholder="nama" value="<?= $edit_data->nama ?>"><br>
    <label>Deskripsi</label>
    <input type="text" name="val_deskripsi" placeholder="deskripsi" value="<?= $edit_data->deskripsi ?>"><br>
    <label>Status</label>
    <!-- <input type="text" name="val_status" placeholder="status" value="<?= $edit_data->status ?>"> -->
    <select name="val_status">
        <option value="1" <?= ($edit_data->status == '1') ? 'selected' : '' ?>>Aktif</option>
        <option value="0" <?= ($edit_data->status == '0') ? 'selected' : '' ?>>Non-Aktif</option>
    </select>
    <input type="file" name="val_lampiran" id="file">
    <?php
} else {
    echo view('errors/html/error_404');
}

?>