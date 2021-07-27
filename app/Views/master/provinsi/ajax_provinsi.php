<?php 
// echo $act;
// echo $page;
// echo $jenis;
// print_r($provinsi);
if (isset($act) && $act=="view") {
	?>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>NAMA</th>
				<th>REFF</th>
				<th>LAMPIRAN</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($provinsi as $key => $value): ?>
				<tr>
					<td><?=$value->nama ?></td>
					<td><?=$value->kd_provinsi_reff ?></td>
					<td><?=$value->lampiran ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php
}elseif (isset($act) && $act=="add" && $modal) {
	?>
	<h1 style="margin-top: 20px" align="center">Page AJAX add</h1>
	<hr>
	<?php
}elseif (isset($act) && $act=="edit" && $modal) {
	?>
	<h1 style="margin-top: 20px" align="center">Page AJAX edit</h1>
	<hr>
	<?php
}else{
	echo view('errors/html/error_404');
}

?>
