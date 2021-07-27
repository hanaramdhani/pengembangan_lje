<?php 
if (isset($act) && $act=='view') {
	// print_r($laporan);
	?>
	
	<table id="tbl-laporan" class="display table table-bordered  table-sm" style="width:100%">
		<thead class="bg-danger">
			<tr style="text-align: center">
				<th>#</th>
				<th>Tanggal</th>
				<th>Transaksi</th>
				<th>No. Transaksi</th>
				<th>Objek</th>
				<th>No. Rekening</th>
				<th>Debet</th>
				<th>Kredit</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($laporan as $key_laporan => $value_laporan): ?>
				<tr>
					<td style="text-align: center;"><?=($key_laporan+1) ?></td>
					<td style="text-align: center;"><?=$value_laporan->tanggal?></td>
					<td><?=$value_laporan->transaksi ?></td>
					<td style="text-align: center"><?=$value_laporan->no_transaksi_reff ?></td>
					<td><?=$value_laporan->objek ?></td>
					<td style="text-align: center;"><?=$value_laporan->no_rekening ?></td>
					<td style="text-align: right;"><?="Rp ".number_format($value_laporan->debet,0,',','.')?></td>
					<td style="text-align: right;"><?="Rp ".number_format($value_laporan->kredit,0,',','.') ?></td>
					
				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot style="display: none;">
			<tr>
				<th colspan="8" style="text-align: right;padding-right: 10px">Total:</th>
			</tr>
		</tfoot>
	</table>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tbl-laporan').DataTable( {
				// "footerCallback": function ( row, data, start, end, display ) {
				// 	var api = this.api(), data;
				// 	footer_data_table(api,6,'currency');
				// }
			} );
		} );
        
    </script>
    <?php
}elseif (isset($act) && $act=="show_detail") {
	?>
	
	<?php
	// print_r($pembayaran);
}else{
	echo view('errors/html/error_404');
}


?>