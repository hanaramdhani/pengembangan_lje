<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<p>Hello World</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>NAMA TABLE</th>
            <th>VIEW</th>
            <th>ADD</th>
            <th>EDIT</th>
            <th>KODE GROUP</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($user_permission as $User => $value) : ?>
        <tr>
            <td><?= $value['table_name']; ?></td>
            <td><?= $value['v_view'];  ?></td>
            <td><?= $value['v_add'];  ?></td>
            <td><?= $value['v_edit'];  ?></td>
            <td><?= $value['kd_group'];  ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>