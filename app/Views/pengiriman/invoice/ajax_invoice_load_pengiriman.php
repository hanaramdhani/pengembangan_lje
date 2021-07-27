<?php 
if (isset($act) && $act=='load_pengiriman') {
	?>
	<table id="table-invoice" class="table table-bordered table-sm">
		<thead class="bg-danger">
			<tr class="text-center">
				<th><input type="checkbox" id="head-cb"></th>
				<th>No Transaksi</th>
				<th>Jumlah Item</th>
				<th>From to</th>
				<th>Tujuan</th>
				<th>Sub Total</th>
			</tr>
		</thead>
		<tbody class="text-center">
			<?php foreach ($data_pengiriman as $key => $value) : ?>
				<tr class="data-dt-<?= $key ?> selected-dt details" data-pengiriman="<?= $value->no_transaksi ?>" data-keterangan="-" data-subtotal="<?=$value->subtotal ?>">
					<td><input type="checkbox" class="cb-child" value="click_key_<?= $key ?>" data-click="<?= $key ?>"></td>
					<td><?= $value->no_transaksi ?></td>
					<td><?= $value->jumlah_item ?></td>
					<td><?= $value->from_to ?></td>
					<td><?= $value->tujuan ?></td>
					<td style="text-align: right;"><?= "Rp ".number_format($value->subtotal,0,',','.') ?></td>

				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5" style="text-align: right;padding-right: 10px">Total:</th>
				<th id="total-invoice" style="text-align: right;"></th>
			</tr>
		</tfoot>
	</table>
	<script type="text/javascript">
		$(document).ready(function() {
			first_load();
		});
		
		function first_load() {
			$('#table-invoice').DataTable({
				"paging":   false,
				"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;
					footer_data_table(api,5,'currency');
				}
			});
			$('.select2').select2();
			$("#head-cb").prop('checked', true)
            // if ($("#head-cb").prop('checked') == true) {
            // console.log("AKTIF")
            $(".cb-child").prop('checked', true)
            // } else {
            // console.log("GA AKTIF")
            // $(".cb-child").prop('checked', true)
            // }

            get_detail_invoice();
        }
        $("#head-cb").on('click', function() {
        	if ($("#head-cb").prop('checked') == true) {
        		console.log("AKTIF")
        		$(".cb-child").prop('checked', true);
        		$('.details').addClass('selected-dt');
        	} else {
        		$(".cb-child").prop('checked', false)
        		$('.details').removeClass('selected-dt')
        	}
        	get_detail_invoice();
        })
        $("#table-invoice").on('click', '.cb-child', function() {
        	console.log("KLIK KA")
        	let key = $(this).data('click');
        	if ($(this).prop('checked') != true) {
        		$("#head-cb").prop('checked', false)
        		$('.data-dt-' + key).removeClass('selected-dt');
        	} else {
        		$('.data-dt-' + key).addClass('selected-dt');
        		let num_dt = $('.cb-child').length;
        		let selected_dt = $('.selected-dt').length;
        		if (num_dt === selected_dt) {
        			$("#head-cb").prop('checked', true);
        		}
        	}
        	get_detail_invoice();

        })

        function get_detail_invoice() {
        	detail_invoice = [];
        	var object = {};
        	$('.selected-dt').each(function() {
        		object = {};
        		object['val_no_pengiriman'] = $(this).data('pengiriman');
        		object['val_status'] = 1;
        		object['val_keterangan'] = $(this).data('keterangan');
        		detail_invoice.push(object);
        	});
        	hitung_total();
        	console.log(detail_invoice);
        }
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
            	html_total='Rp '+currencyFormat(pageTotal);
            	// +' <br>(Total Rp '+ currencyFormat(total) +')'
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
        function hitung_total(){
        	let total=0;
        	$('.selected-dt').each(function(){
        		total+=$(this).data('subtotal');
        	});
        	$('#total-invoice').text('Rp '+currencyFormat(total));
        }

    </script>
    <?php
}

?>