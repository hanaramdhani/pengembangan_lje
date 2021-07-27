<?php 
if (isset($act) && $act=='view') {
	?>
	<div style="border: dotted 0.5px; padding: 1rem;width:70%;">
		<table id="" class="" style="width:100%;border: none;">
			<thead>
				<tr style="border-bottom: dotted 1px;padding-bottom: 1rem">
					<th>Keterangan</th>
					<th style="text-align: center" colspan="2">Nominal (Rp)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($laporan as $key_laporan => $value_laporan): 
					if ($value_laporan->type==0) {
						$value_laporan->Nominal="( ".number_format($value_laporan->Nominal,0,',','.')." )";
					}else{
						$value_laporan->Nominal=number_format($value_laporan->Nominal,0,',','.');
					}
					?>
					<tr>
						<?php 
						if ($value_laporan->type==0) {
							?>
							<td style="padding-left: 50px !important"><?=$value_laporan->Keterangan?></td>
							<?php
						}else{
							?>
							<td><?=$value_laporan->Keterangan?></td>
							<?php
						}
						?>

						<?php 
						if ($key_laporan>1) {
							?>
							<td style="text-align: right;"></td>
							<td style="text-align: right;"><?=$value_laporan->Nominal ?></td>
							<?php
						}else{
							?>
							<td style="text-align: right;"><?=$value_laporan->Nominal ?></td>
							<td style="text-align: right;"></td>
							<?php
						}

						?>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot style="display: none;">
				<tr>
					<th colspan="3" style="text-align: right;padding-right: 10px">Total:</th>
				</tr>
			</tfoot>
		</table>
	</div>
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