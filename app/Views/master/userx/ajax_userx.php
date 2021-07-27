<?php


if (isset($act) && $act == "view") {

    ?>
    <div class="card">
        <div class="card-body">
            <a class="btn btn-primary" href="<?= site_url('load/add/userx/master') ?>"><i class="fas fa-plus-circle"></i>
            Tambah User</a>
        </div>
    </div>

    <div class="card card-outline card-danger">
        <div class="card-body">
            <table id="data-tampil" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No </th>
                        <th>Nama </th>
                        <th>Deskripsi</th>
                        <th>Akses Level</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userx as $key => $value): ?>
                        <tr>
                            <td><?=($key+1)?></td>
                            <td><?=$value->pegawai?></td>
                            <td><?=$value->deskripsi?></td>
                            <td><?=$value->group_user?></td>
                            <td><?=$value->nama?></td>
                            <td class="text-center"> 
                                <button type="button" class="btn btn-primary btn-xs edit-master" id="edit-modal" data-key="<?= $value->passwd?>">
                                    <i class="fa fa-unlock-alt" > Ubah</i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-default btn-xs edit-master" id="edit-modal" data-key="<?= $value->kd_user?>">
                                    <i class="fa fa-check-double" style="color:#009A50;"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-default btn-xs edit-master" id="edit-modal" data-key="<?= $value->kd_user?>"> -->
                                    <!-- <i class="fa fa-edit " style="color:#FCBC5D"></i> -->
                                    <!-- </button> -->
                                    <a class="btn btn btn-default btn-xs" href="<?= site_url('load/edit/userx/master/').$value->kd_user ?>"><i class="fa fa-edit " style="color:#FCBC5D"></i></a>

                                    <button class="btn btn-default btn-xs delete" data-key="<?= $value->kd_user ?>"> <i class="fa fa-trash" style="color: red;"></i></button>
                                    <button
                                    class="btn btn-xs <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>"><i
                                    class="fa fa-image"></i></button>
                                </td>

                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#data-tampil').DataTable();
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
                    title_modal = "Tambah Data User";
                } else if (jenis_modal == "edit-modal") {
                    act = "edit";
                    title_modal = "Ubah Data User ";
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
                            data: `frm_table=userx&token=123`,
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
        $data_pegawai=array();
        foreach ($pegawai_non_user as $key_pegawai => $value_pegawai) {
            $data_pegawai["pegawai_".$value_pegawai->kd_pegawai]=$value_pegawai;
        }
        $selected_pegawai=json_encode($data_pegawai);

        ?>
        <form id="frm-userx" action="#">
            <div class="row">
                <div class="col">
                    <div class="card card-danger card-tabs">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Pegawai</label>
                                        <div class="col-sm-9">
                                            <select name="val_kd_pegawai" class="form-control" id="selected-pegawai" required>
                                                <?php 
                                                if (!empty($pegawai_non_user)) {
                                                    ?>
                                                    <option value="">Pilih Pegawai</option>
                                                    <?php
                                                    foreach ($pegawai_non_user as $key => $value) {
                                                        ?>
                                                        <option value="<?=$value->kd_pegawai ?>"><?=$value->nama ?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="">Not Available</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!-- <input name="no_transaksi_reff" class="form-control" id=""> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input  class="form-control" id="pegawai-nama" readonly placeholder="Pilih Pegawai">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">No.Hp</label>
                                        <div class="col-sm-9">
                                            <input  class="form-control" id="pegawai-hp" readonly placeholder="Pilih Pegawai">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Divisi</label>
                                        <div class="col-sm-9">
                                            <input  class="form-control" id="pegawai-divisi" readonly placeholder="Pilih Pegawai">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Username</label>
                                        <div class="col-sm-9">
                                            <input name="val_nama" class="form-control" id="" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="val_passwd" class="form-control" id="i-password" placeholder="password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="i-confirm-password" placeholder="confirm password">
                                            <span class="text-danger" id="confirm-pwd"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">User Group</label>
                                        <div class="col-sm-9">
                                            <select name="val_kd_group" class="form-control" id="selected-pegawai">
                                                <?php 
                                                if (!empty($user_group)) {
                                                    ?>
                                                    <!-- <option value="">Hak Akses...</option> -->
                                                    <?php
                                                    foreach ($user_group as $key => $value) {
                                                        ?>
                                                        <option value="<?=$value->kd_group ?>" ><?=$value->nama ?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="">Not Available</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 p-5" style="text-align: center" class="">
                                    <div >
                                        <img class="rounded change-image" id="customeredit" src="<?=base_url('assets/dist/img/add_image.png') ?>" style=" width: 150px; height:150px; border: solid 1px; opacity: 0.7;cursor: pointer;">
                                    </div>
                                    <div class="pt-2">
                                        <button type="button" class="btn btn-outline-secondary change-image">Foto Profil</button>
                                    </div>
                                    <div style="display: none;">
                                        <input type="file" name="val_lampiran" id="img-lampiran" onchange="editcustomer()">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="card-footer text-center">

                <button type="submit" name="btn_submit" value="Simpan" id="send-ajax-array-js" class="btn btn-primary"><i class="fas fa-save"></i> Simpan </button>
            </div>
        </form>
        <script type="text/javascript">
            $('.select2').select2()

            function editcustomer() {
                let frame = document.getElementById('customeredit');
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            $('.change-image').click(function(){
             $('#img-lampiran').trigger('click');
         });
            $('#selected-pegawai').change(function(){
                let id_pegawai=$(this).val();
                let selected_pegawai=<?=(!empty($selected_pegawai))?$selected_pegawai:'' ?>['pegawai_'+id_pegawai];
                if (selected_pegawai!='') {
                    $('#pegawai-nama').val(selected_pegawai['nama']);
                    $('#pegawai-hp').val(selected_pegawai['hp']);
                    $('#pegawai-divisi').val(selected_pegawai['divisi']);
                }
            // console.log(selected_pegawai);
            // console.log(selected_pegawai['kd_pegawai']);
        });


            $('#frm-userx').submit(function(e) {
                e.preventDefault();

                if ($('#i-password').val() != $('#i-confirm-password').val()) {
                    $('#confirm-pwd').text('Password tidak sesuai');
                }else{
                    form_data = new FormData($('#frm-userx')[0]);
                    form_data.append('token', '123');
                    form_data.append('frm_table', 'userx');
                    form_data.append('frm_table_update', 'm_pegawai');
                    form_data.append('frm_type', 'add');

                    $.ajax({
                        type: 'post',
                        url: `<?= base_url() ?>/api/add_user`,
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
                                location.href = `<?= base_url() ?>/load/view/userx/master`;
                        // location.reload();
                    }
                }
            });
                }

            });
        </script>
        <?php
    } elseif (isset($act) && $act == 'edit' && !$modal) {
        // print_r($edit_data);


        ?>
        <form id="frm-userx" action="#">
            <div class="row">
                <div class="col">
                    <div class="card card-danger card-tabs">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <input type="hidden" name="key_kd_user" value="<?=$edit_data->kd_user ?>">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Username</label>
                                        <div class="col-sm-9">
                                            <input name="val_nama" class="form-control" id="" placeholder="Username" value="<?=$edit_data->nama ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="val_passwd" class="form-control" id="i-password" placeholder="password" value="<?=$edit_data->passwd ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="i-confirm-password" placeholder="confirm password" value="<?=$edit_data->passwd ?>">
                                            <span class="text-danger" id="confirm-pwd"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">User Group</label>
                                        <div class="col-sm-9">
                                            <select name="val_kd_group" class="form-control" id="selected-pegawai">
                                                <?php 
                                                if (!empty($user_group)) {
                                                    ?>
                                                    <!-- <option value="">Hak Akses</option> -->
                                                    <?php
                                                    foreach ($user_group as $key => $value) {
                                                        ?>
                                                        <option value="<?=$value->kd_group ?>" <?=($value->kd_group==$edit_data->kd_group)?'selected':'' ?>><?=$value->nama ?></option>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="">Not Available</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 p-5" style="text-align: center" class="">
                                    <div >
                                        <img class="rounded change-image" id="customeredit" src="<?=base_url('assets/dist/img/add_image.png') ?>" style=" width: 150px; height:150px; border: solid 1px; opacity: 0.7;cursor: pointer;">
                                    </div>
                                    <div class="pt-2">
                                        <button type="button" class="btn btn-outline-secondary change-image">Foto Profil</button>
                                    </div>
                                    <div style="display: none;">
                                        <input type="file" name="val_lampiran" id="img-lampiran" onchange="editcustomer()">
                                    </div>
                                    <!-- <div class="row mt-2 col-md-6">
                                    </div> -->
                                <!-- <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <input name="no_transaksi_reff" class="form-control" id="">
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="card-footer text-center">

            <button type="submit" name="btn_submit" value="Simpan" id="send-ajax-array-js" class="btn btn-primary"><i class="fas fa-save"></i> Simpan </button>
        </div>
    </form>
    <script type="text/javascript">
        $('.select2').select2()

        function editcustomer() {
            let frame = document.getElementById('customeredit');
            frame.src = URL.createObjectURL(event.target.files[0]);
        }
        $('.change-image').click(function(){
         $('#img-lampiran').trigger('click');
     });
        $('#selected-pegawai').change(function(){
            let id_pegawai=$(this).val();
            let selected_pegawai=<?=(!empty($selected_pegawai))?$selected_pegawai:'' ?>['pegawai_'+id_pegawai];
            if (selected_pegawai!='') {
                $('#pegawai-nama').val(selected_pegawai['nama']);
                $('#pegawai-hp').val(selected_pegawai['hp']);
                $('#pegawai-divisi').val(selected_pegawai['divisi']);
            }
            // console.log(selected_pegawai);
            // console.log(selected_pegawai['kd_pegawai']);
        });
        

        $('#frm-userx').submit(function(e) {
            e.preventDefault();
            
            if ($('#i-password').val() != $('#i-confirm-password').val()) {
                $('#confirm-pwd').text('Password tidak sesuai');
            }else{
                form_data = new FormData($('#frm-userx')[0]);
                form_data.append('token', '123');
                form_data.append('frm_table', 'userx');
                form_data.append('frm_table_update', 'm_pegawai');
                form_data.append('frm_type', 'add');

                $.ajax({
                    type: 'post',
                    url: `<?= base_url() ?>/api/add_user`,
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
                            location.href = `<?= base_url() ?>/load/view/userx/master`;
                        // location.reload();
                    }
                }
            });
            }
            
        });
    </script>
    <?php
} else {
    echo view('errors/html/error_404');
}

?>
