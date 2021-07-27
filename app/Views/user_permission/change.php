<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<p>Ubah</p>
<table class="table table-bordered">

    <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>NAMA TABLE</th>
            <th>VIEW <input type="checkbox" id="cb-view" class="head-view"></th>
            <th>ADD <input type="checkbox" id="cb-add"></th>
            <th>EDIT <input type="checkbox" id="cb-edit"></th>
            <th>KODE GROUP</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($result as $User => $value) : ?>
        <tr class="text-center">
            <form action="/User_permission/update/<?= $value['id']; ?>" ; id=" frm-user" method="POST">
                <?= csrf_field(); ?>
                <td class="text-center"><?= $value['id']; ?></td>
                <td class="text-left"><?= $value['table_name']; ?></td>
                <td>
                    <input id="<?= $value['id'] ?>-view" class="test1"
                        name="update[<?= $value['table_name'] ?>][v_view]" type="text" style="width: 30px;"
                        value="<?= $value['v_view']  ?>">
                    <input class="selected-view slct-view chk-box" data-key="<?= $value['id'] ?>-view"
                        value="<?= $value['v_view']; ?>" <?= $value['v_view'] == 1 ? 'checked' : ''?> id="view"
                        type="checkbox">
                    <!-- <button class="btn btn-xs <?= $value['v_view'] == 1 ? 'btn-success' : 'btn-danger' ?>">
                        <i class="fa <?= $value['v_view'] == 1 ? 'fa-check-circle' : 'fa-ban' ?>"></i>
                    </button> -->
                </td>
                <td> <input type="text" name="update[<?= $value['table_name'] ?>][v_add]" id="<?= $value['id'] ?>-add"
                        class="test2" style="width: 30px;" value=" <?= $value['v_add'];  ?>">
                    <input value="<?= $value['v_add']; ?>" data-key="<?= $value['id'] ?>-add"
                        class="selected-add slct-add chk-box" <?= $value['v_add'] == 1 ? 'checked' : '' ?>
                        type="checkbox" id="add">
                </td>
                <td> <input type="text" name="update[<?= $value['table_name'] ?>][v_edit]" id="<?= $value['id'] ?>-edit"
                        class="test3" style="width:30px;" value="<?= $value['v_edit'];  ?>">
                    <input value="<?= $value['v_edit']; ?>" data-key="<?= $value['id'] ?>-edit"
                        class="selected-edit slct-edit chk-box" <?= $value['v_edit'] == 1 ? 'checked' : '' ?> id="edit"
                        type="checkbox">
                </td>
                <td> <?= $value['kd_group']; ?>
                </td>
                <?php endforeach; ?>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
// update[<?=$value['table_name'] ?>][v_view]
// $('.chk-box').click(function() {
//     if ($(this).prop('checked') == true) {
//         $(this).val() == 1;
//     } else {
//         $(this).val() == 0;
//     }
// });



//nilai
$('.chk-box').click(function() {
    // alert('test');
    var data = $(this).data('key');
    if ($(this).prop('checked') == true) {
        $('#' + data).val(1);
    } else {
        $('#' + data).val(0);
    }
})

// $('.head-view').click(function() {
//     var data = $(this).data('key');
//     if ($(this).prop('checked') == true) {
//         $('#' + data).val(1);
//     } else {
//         $('#' + data).val(0);
//     }
// });

$('#cb-view').click(function() {
    if ($('#cb-view').prop('checked') == true) {
        $('.selected-view').prop('checked', true);
        $('.selected-view').addClass('.slct-view');
        $('.test1').val(1);
    } else {
        $('.selected-view').prop('checked', false);
        $('.selected-view').removeClass('.slct-view');
        $('.test1').val(0);

    }
});
$('#cb-add').click(function() {
    if ($('#cb-add').prop('checked') == true) {
        $('.selected-add').prop('checked', true);
        $('.selected-add').addClass('.slct-add');
        $('.test2').val(1);
    } else {
        $('.selected-add').prop('checked', false);
        $('.selected-add').removeClass('.slct-add');
        $('.test2').val(0);
    }
});
$('#cb-edit').click(function() {
    if ($('#cb-edit').prop('checked') == true) {
        $('.selected-edit').prop('checked', true);
        $('.selected-edit').addClass('.slct-edit');
        $('.test3').val(1);
    } else {
        $('.selected-edit').prop('checked', false);
        $('.selected-edit').removeClass('.slct-edit');
        $('.test3').val(0);
    }
});
</script>
<input type="submit" value="Simpan" class="btn btn-primary btn-sm">
</form>

<?= $this->endSection(); ?>