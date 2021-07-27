<?php 
if (isset($act) && $act='view') {
	?>
	
	<table id="example" class="display table table-bordered table-sm" style="width:100%">
		<thead class="bg-danger">
			<tr style="text-align: center;">
				<th>#</th>
				<th>Pengirim - Penerima</th>
				<th>Tujuan</th>
				<th>Jenis - Layanan</th>
				<th>Tanggal</th>
				<th>Berat</th>
				<th>Koli </th>
				<th>Ongkos </th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach ($laporan as $key_laporan => $value_laporan): 
				$ongkir=0;
				$satuan='';
				$ongkir_satuan='';
				if ($value_laporan->harga_koli>0) {
					$ongkir=$value_laporan->harga_koli;
					$satuan='@';
				}
				if ($value_laporan->harga_berat>0) {
					$ongkir=$value_laporan->harga_berat;
					$satuan='kg';
				}
				if ($value_laporan->harga_volume>0) {
					$ongkir=$value_laporan->harga_volume;
					$satuan='m3';
				}
				if ($satuan=='@') {
					$ongkir_satuan=$satuan." ".number_format($ongkir,0,',','.');
				}else{
					$separator=($ongkir>0)?" /":'';
					$ongkir_satuan=number_format($ongkir,0,',','.').$separator.$satuan;
				}
				?>
				<tr>
					<td><?=($key_laporan+1) ?></td>
					<td><?=$value_laporan->nama_pengirim." - ".$value_laporan->nama_penerima ?></td>
					<td><?=$value_laporan->alamat_penerima ?></td>
					<td><?=$value_laporan->jenis_kirim." - ".$value_laporan->layanan?></td>
					<td style="text-align: center"><?=$value_laporan->tanggal?></td>
					<td style="text-align: right;"><?=number_format($value_laporan->jumlah_berat,0,',','.') ?></td>
					<td style="text-align: right;"><?=number_format($value_laporan->jumlah_item,0,',','.') ?></td>
					<td style="text-align: right;"><?=$ongkir_satuan?></td>
					<td style="text-align: right;">
						<?="Rp ".number_format($value_laporan->total_bersih,0,',','.')?>
					</td>
				</tr>
				<?php 
			endforeach 
			?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="8" style="text-align: right;padding-right: 10px">Total:</th>
				<th></th>
			</tr>
		</tfoot>
	</table>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable( {
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
					footer_data_table(api,8,'currency');
				}
			} );
		} );

		function footer_data_table(api,col,jenis){
			let str;
			if (jenis=='currency') {
				str=/[\Rp.]/g;
			}else if(jenis=='nota'){
				str=/[\Nota]/g;
			}else if(jenis=='item'){
				str=/[\Item]/g;
			}else{
				str=/[\'']/g;
			}
			// Remove the formatting to get integer data for summation
			var intVal = function ( i ) {
				return typeof i === 'string' ?
				i.replace(str, '')*1 :
				typeof i === 'number' ?
				i : 0;
			};
 			// Total over all pages
 			total = api
 			.column( col )
 			.data()
 			.reduce( function (a, b) {
 				return intVal(a) + intVal(b);
 			}, 0 );

            // Total over this page
            pageTotal = api
            .column( col, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
            	return intVal(a) + intVal(b);
            }, 0 );

            if (jenis=='currency') {
            	html_total='Rp '+currencyFormat(pageTotal) +' <br>(Total Rp '+ currencyFormat(total) +')';
            }else if(jenis=='nota'){
            	html_total=pageTotal +' <br>(Total '+ total +' Nota)';
            }else if(jenis=='item'){
            	html_total=pageTotal +' <br>(Total '+ total +' Item)';
            }else{
            	html_total=pageTotal +' <br>(Total '+ total +')';
            }
        	//update total
        	$( api.column( col ).footer() ).html(html_total);            
        }
    </script>
    <?php
}else{
	echo view('errors/html/error_404');
}


?>