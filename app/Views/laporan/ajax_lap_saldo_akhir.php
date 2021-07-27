<?php 
if (isset($act) && $act=='view') {
	// print_r($laporan);
	?>
	
	<table id="tbl-laporan" class="display table table-bordered table-sm" style="width:100%">
		<thead class="bg-danger">
			<tr style="text-align: center;">
				<th>#</th>
				<th>No. Rekening</th>
				<th>Saldo Akhir</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($laporan as $key_laporan => $value_laporan): ?>
				<tr>
					<td style="text-align: center"><?=($key_laporan+1) ?></td>
					<td style="text-align: center"><?=$value_laporan->no_rekening?></td>
					<td style="text-align: right;"><?="Rp ".number_format($value_laporan->saldo_akhir,0,',','.') ?></td>
					
				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot style="display: none;">
			<tr>
				<th colspan="3" style="text-align: right;padding-right: 10px">Total:</th>
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

		// function footer_data_table(api,col,jenis){
		// 	let str;
		// 	if (jenis=='currency') {
		// 		str=/[\Rp.]/g;
		// 	}else if(jenis=='nota'){
		// 		str=/[\Nota]/g;
		// 	}else if(jenis=='item'){
		// 		str=/[\Item]/g;
		// 	}else{
		// 		str=/[\'']/g;
		// 	}
		// 	// Remove the formatting to get integer data for summation
		// 	var intVal = function ( i ) {
		// 		return typeof i === 'string' ?
		// 		i.replace(str, '')*1 :
		// 		typeof i === 'number' ?
		// 		i : 0;
		// 	};
 	// 		// Total over all pages
 	// 		total = api
 	// 		.column( col )
 	// 		.data()
 	// 		.reduce( function (a, b) {
 	// 			return intVal(a) + intVal(b);
 	// 		}, 0 );

  //           // Total over this page
  //           pageTotal = api
  //           .column( col, { page: 'current'} )
  //           .data()
  //           .reduce( function (a, b) {
  //           	return intVal(a) + intVal(b);
  //           }, 0 );

  //           if (jenis=='currency') {
  //           	html_total='Rp '+currencyFormat(pageTotal) +' <br>(Total Rp '+ currencyFormat(total) +')';
  //           }else if(jenis=='nota'){
  //           	html_total=pageTotal +' <br>(Total '+ total +' Nota)';
  //           }else if(jenis=='item'){
  //           	html_total=pageTotal +' <br>(Total '+ total +' Item)';
  //           }else{
  //           	html_total=pageTotal +' <br>(Total '+ total +')';
  //           }
  //       	//update total
  //       	$( api.column( col ).footer() ).html(html_total);            
  //       }
       
        
    </script>
    <?php
}elseif (isset($act) && $act=="show_detail") {
	?>
	<div class="row">
		<div class="col-md-6">
			<h4>Invoce:</h4>
			<hr>
			<table class="table table-sm">
				<tr>
					<th>Invoice No.</th>
				</tr>
				<?php foreach ($invoice as $key => $value): ?>
					<tr>
						<td><?=$value->no_invoice ?></td>
					</tr>
				<?php endforeach ?>
			</table>		
		</div>
		<div class="col-md-6">
			<h4>Pembayaran (Cicilan):</h4>
			<hr>
			<table class="table table-sm">
				<tr>
					<th>#</th>
					<th>tanggal</th>
					<th>Nominal</th>
				</tr>
			</table>
		</div>
	</div>
	
	<?php
	// print_r($pembayaran);
}else{
	echo view('errors/html/error_404');
}


?>