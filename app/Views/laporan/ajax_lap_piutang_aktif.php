<?php 
if (isset($act) && $act=='view') {
	// print_r($laporan);
	?>
	
	<table id="tbl-laporan" class="display table table-bordered table-sm" style="width:100%">
		<thead class="bg-danger">
			<tr style="text-align: center;">
				<th></th>
				<th>SA</th>
				<th>Customer</th>
				<th>Tanggal</th>
				<th>Total Kredit</th>
				<th>Total Cicilan</th>
				<th>Sisa Cicilan</th>
				
			</tr>
		</thead>
		<tbody>
			<?php foreach ($laporan as $key_laporan => $value_laporan): ?>
				<tr>
					<td>
						<button style="float: left;" type="button" class="btn btn-primary btn-xs tampil-dt mr-2" id="data-tampil" data-key="<?= $value_laporan->no_transaksi ?>">
							<i class="fa fa-eye"></i>
						</button>
						<!-- <?=($key_laporan+1) ?> -->
					</td>
					<td style="text-align: center;"><?=$value_laporan->no_transaksi_reff?></td>
					<td><?=$value_laporan->customer ?></td>
					<td style="text-align: center;"><?=$value_laporan->tanggal ?></td>
					<td style="text-align: right;"><?='Rp '.number_format($value_laporan->t_bersih,0,',','.')?></td>
					<td style="text-align: right;"><?='Rp '.number_format($value_laporan->cicilan,0,',','.')?></td>
					<td style="text-align: right;"><?='Rp '.number_format($value_laporan->sisa_cicilan,0,',','.')?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="6" style="text-align: right;padding-right: 10px">Total:</th>
				<th style="text-align: right;"></th>
			</tr>
		</tfoot>
	</table>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tbl-laporan').DataTable( {
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
					footer_data_table(api,6,'currency');
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
        // $('.tampil-dt').click(function(){
        	// let key= $(this).data('key');
        	// $.ajax({
        	// 	type:'POST',
        	// 	url:`<?=base_url()?>`,
        	// 	data:{key:key},
        	// 	success:function(r){

        	// 	}
        	// });
        // });
        $("#tbl-laporan").on('click', '.tampil-dt', function() {
        	var table = $('#tbl-laporan').DataTable();
        	var tr = $(this).closest('tr');
        	var row = table.row(tr);
        	let key = $(this).data('key');
        	if (row.child.isShown()) {
        		$('div.slider', row.child()).slideUp(function() {
        			row.child.hide();
        			tr.removeClass('shown');
        		});
        	} else {
        		let loading=`
        		<div class="d-flex justify-content-center" style="opacity:0.5">
        		<div class="spinner-border text-primary" role="status">
        		<span class="sr-only">Loading...</span>
        		</div>
        		</div>`;
        		tr.addClass('shown');
        		row.child(loading).show();
        		$.ajax({
        			type:'POST',
        			url:`<?=base_url()?>/api/get_cicilan/`+key,
        			data:{token:`<?= $_SESSION['token']?>`},
        			dataType:'json',
        			success:function(r){
        				// console.log(r);
        				row.child(format(r,key));
        				tr.addClass('shown');
        				$('div.slider', row.child()).slideDown();
        			}
        		});
        		
        	}
        	
        	
        });
        function format(data,key) {
        	// alert(key);
        	// console.log(data);
        	let kirim_detail = data;
        	console.log(kirim_detail);
        	let content = ``;
        	if (kirim_detail != "") {
        		for (var i = 0; i < kirim_detail.length; i++) {
        			content += `
        			<tr style="background-color:azure">
        			<td>` + (i + 1) + `</td>
        			<td>` + kirim_detail[i].kas + `</td>
        			<td>` + kirim_detail[i].jenis_bayar + `</td>
        			<td>` + kirim_detail[i].keterangan + `</td>
        			<td style="text-align: right;">Rp ` + currencyFormat(parseFloat(kirim_detail[i].nominal)) + `</td>
        			
        			</tr>
        			`;

        		}
        	}
        	let html_content = `<div class="slider container-fluid" style="background-color:azure" name>
        	<table class="table table-bordered table-sm" style="width:100%">
        	<tr>
        	<th>#</th>
        	<th>No. Rekening</th>
        	<th>Jenis Bayar</th>
        	<th>Keterangan</th>
        	<th>Nominal Pembayaran</th>
        	</tr>
        	`+content+`
        	<tr>
        	<td colspan="5">
        	
        	</td>
        	</tr>
        	</table>
        	</div>`;
        	return html_content;
        	// <button type="button"  style="text-align: center" class="btn btn-light btn-xs" onclick="view_detail_piutang(${key})"><u style="color:navy">More Details</u> </button>

        }
        function view_detail_piutang(key){
        	
        	$.ajax({
        		type:'POST',
        		url:`<?=base_url() ?>/api/detail_piutang/`+key,
        		data:{token:`<?=$_SESSION['token'] ?>`},
        		success:function(r){
        			$('#pengiriman-id').text(key);
        			$('#m-container-detail-piutang').html(r);
        			$('#modal-detail-piutang').modal('show');
        		}
        	});
        }
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
	print_r($pembayaran);
}else{
	echo view('errors/html/error_404');
}


?>