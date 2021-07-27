<?php 
$no=$last_start;
foreach ($customer as $cs => $value) : ?>
	<input type="hidden" value="<?php echo $value->kd_customer ?>" id="customer-id-<?php echo $no ?>">
	<input type="hidden" value="<?php echo $value->nama ?>" id="customer-name-<?php echo $no ?>">
	<input type="hidden" value="<?php echo $value->alamat ?>" id="customer-alamat-<?php echo $no ?>">
	<input type="hidden" value="<?php echo $value->hp ?>" id="customer-hp-<?php echo $no ?>">
	<input type="hidden" value="<?php echo $value->kabupaten ?>" id="customer-kabupaten-<?php echo $no ?>">

	<button type="button" data-id="<?php echo $no ?>" class="btn btn-sm panggil" id="pilih-customer" data-dismiss="modal"
		data-key="<?= $value->kd_customer ?>"
		style="border: solid darkgray 1px; height: 80px; width: 100%; margin-top: 10px;">

		<div class="row">
			<div class="col-md-2 mt-4">
				<!-- <?=$no ?> -->
				<i class="fas fa-image text-center"></i>
			</div>
			<div class="col-md-3">
				<li style="padding: 1px; font-size: 16px; text-align: left; list-style: none;">
					<strong><?php echo $value->nama ?></strong>
				</li>
				<li style="padding: 1px; text-align: left; list-style: none;"><?php echo $value->hp ?></li>
				<li style="padding: 1px; text-align: left; list-style: none;"><?php echo $value->kabupaten ?></li>
			</div>
		</div>
	</button>
	<?php 
	$no++;
endforeach; 
?>
<button style="width: 100%;color: navy" id="btn-load-more_<?=$no ?>" class="btn btn-light mt-2 mb-4" onclick="load_more_customer(`<?=($no) ?>`)">Load More</button>
<script type="text/javascript">

	function load_more_customer(start){
		let key = $(this).data('key');
		let page = `<?= $page ?>`;
		let jenis = `pengiriman`;
		let jenis_modal = $(this).attr('id');
		let act = "add";
		let title_modal = "";
    	// $('#start-customer').val(0);
    	$('#btn-load-more_'+start).html(loading);
    	$.ajax({
    		type: 'POST',
    		url: `<?= base_url() ?>/api/ajax_load_customer/`+start,
    		data:{token:`<?=$_SESSION['token']?>`,file_name:`pengiriman/pengiriman/ajax_pengiriman`,page:page,jenis:jenis,act:act},
    		success: function(r) {
    			$('#btn-load-more_'+start).remove();
	            // $('#m-crud-title-panggil').text(title_modal);
	            // $('#m-customer').text(jenis_modal);
	            $('#m-container-panggil').append(r);
	            // $('#modal-panggil').modal('show');
	            // $('#start-customer').val(10);
	        }
	    });
    }
    $('.panggil').on('click', function() {
    	let key = $(this).data('key');
    	let page = `<?= $page ?>`;
    	let jenis = `<?= $jenis ?>`;
    	// let jenis_modal = $(this).attr('id');
    	let jenis_modal = $(this).attr('id');
    	let title_modal = "";
    	let id = $(this).data('id');
    	let tujuan = $('#m-customer').text();
    	if (tujuan == "pengirim") {
        	// $('#val_kd_customer').val($("#customer-id-" + id).val());
        	$('#kd-selected-pengirim').val($("#customer-id-" + id).val());
        	$('#val_nama_pengirim').val($("#customer-name-" + id).val());
        	$('#val_alamat_pengirim').val($("#customer-alamat-" + id).val());
        	$('#val_kabupaten_pengirim').val($("#customer-kabupaten-" + id)
        		.val());
        	$('#val_hp_pengirim').val($("#customer-hp-" + id).val());
        	$('#pengirim-text').text($("#customer-name-" + id).val());
        } else {
        	// $('#val_kd_customer').val($("#customer-id-" + id).val());
        	$('#kd-selected-penerima').val($("#customer-id-" + id).val());
        	$('#val_nama_penerima').val($("#customer-name-" + id).val());
        	$('#val_alamat_penerima').val($("#customer-alamat-" + id).val());
        	$('#val_kabupaten_penerima').val($("#customer-kabupaten-" + id)
        		.val());
        	$('#val_hp_penerima').val($("#customer-hp-" + id).val());
        	$('#penerima-text').text($("#customer-name-" + id).val());
        }
        cek_selected_customer();
    });
</script>
