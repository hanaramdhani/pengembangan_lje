<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>

<h1>Hello world</h1>

<table class="table  table-bordered">
    <thead>
        <tr class="text-center">
            <th>Kode Group</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($user_group as $user => $value): ?>
        <tr>
            <td class="text-center"><?= $value['kd_group']; ?></td>
            <td><?= $value['nama']; ?></td>
            <td><?= $value['deskripsi']; ?></td>
            <td><?= $value['status']; ?></td>
            <td><a href="<?= site_url('/pengaturan/userPermission/edit?kd_group=' . $value['kd_group']) ?>"
                    data-key="<?= $value['kd_group'] ?>" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection(); ?>