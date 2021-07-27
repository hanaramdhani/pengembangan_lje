<?php 
if (isset($act) && $act=="load_detail_manifest_out") {
	// echo "<pre>";
	// print_r($manifest_dt);
	// echo "</pre>";
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="card-body">
				<table id="table-manifest-out" class="table table-sm table-bordered">
					<thead class="bg-danger text-center ">
						<tr>
							<th><input type="checkbox" id="head-cb"></th>
							<th>SA</th>
							<th>KOLI</th>
							<th>JENIS BARANG</th>
							<th>PENGIRIM</th>
							<th>PENERIMA</th>
							<th>BERAT</th>
							<th>ONGKOS</th>
							<th>TOTAL</th>
						</tr>
					</thead>
					<tbody class="bg-azure">
						<?php 
						$total=0;
						$ttl_berat=0;
						foreach ($manifest_dt as $data => $value) : 
						// print_r($value);
							$ongkir=0;
							$satuan='';
							$ongkir_satuan='';
							if ($value->harga_koli>0) {
								$ongkir=$value->harga_koli;
								$satuan='@';
							}
							if ($value->harga_berat>0) {
								$ongkir=$value->harga_berat;
								$satuan='kg';
							}
							if ($value->harga_volume>0) {
								$ongkir=$value->harga_volume;
								$satuan='m3';
							}
							if ($satuan=='@') {
								$ongkir_satuan=$satuan." Rp ".number_format($ongkir,0,',','.');
							}else{
								$ongkir_satuan="Rp ".number_format($ongkir,0,',','.')." /".$satuan;
							}
							?>
							<tr class="text-center data-dt-<?= $data ?> selected-dt details" data-pengiriman="<?= $value->no_transaksi ?>" data-berat="<?=$value->berat ?>" data-subtotal="<?=$value->subtotal?>">
								<td><input type="checkbox" class="child-cb" value="click_key_<?= $data ?>" data-click="<?= $data ?>"></td>
								<td><?= $value->no_sa ?></td>
								<td><?= $value->koli ?></td>
								<td><?= $value->item ?></td>
								<td><?= $value->pengirim ?></td>
								<td><?= $value->penerima ?></td>
								<td><?= $value->berat." kg" ?></td>
								<td style="text-align: right;"><?= $ongkir_satuan ?></td>
								<td style="text-align: right;"><?= "Rp ".number_format($value->subtotal,0,',','.') ?></td>

							</tr>
							<?php 
							$ttl_berat+=$value->berat;
							$total+=$value->subtotal;
						endforeach; 
						?>
					</tbody>
				</table>
				<div class="p-1" style="text-align: right;margin-right: 20px;">
					<strong class="pr-3">Total:</strong>
					<strong class="pr-3"><span id="ttl-berat-checked"><?=$ttl_berat." kg" ?></span></strong>
					<strong id="total-pengiriman-checked"><?="Rp ".number_format($total,0,',','.') ?></strong>
				</div>
			</div>
			<div class="card-footer">
				<div class="btn-batal">
					<button type="button" name="simpan" style="width: 150px;"
					class="btn btn-outline-dark" onclick="history.back(-1)" id="btn-close"><i style="color:red" class="fa fa-times"></i> Batal</button>
					<button type="submit" id="btn-save" style="float: right; width: 150px;" name="btn_submit" value="Simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			first_load_table()
			get_menifest_out_detail()
		});

		function first_load_table() {
			$('#table-manifest-out').DataTable({
				"scrollY":        "700px",
				"scrollCollapse": true,
				"paging":         false
			});
			$('#head-cb').prop('checked', true)
			$('.child-cb').prop('checked', true)
			get_menifest_out_detail();
		}
		$('#head-cb').click(function() {
			if ($('#head-cb').prop('checked') == true) {
				console.log('aktif')
                // $('#head-cb').prop('checked', true)
                $('.child-cb').prop('checked', true)
                $('.details').addClass('selected-dt')
            } else {
                // $('#head-cb').prop('checked', false)
                $('.child-cb').prop('checked', false)
                $('.details').removeClass('selected-dt')

            }

            get_menifest_out_detail();
        });
		$('#table-manifest-out').on('click', '.child-cb', function() {
			console.log('klik');
			let key = $(this).data('click');
			if ($(this).prop('checked') != true) {
				$('#head-cb').prop('checked', false)
				$('.data-dt-' + key).removeClass('selected-dt');
			} else {
				$('.data-dt-' + key).addClass('selected-dt');
				let child = $('.child-cb').length;
				let selected_dt = $('.selected-dt').length;
				// alert(child+" => "+selected_dt);
				if (child === selected_dt) {
					$('#head-cb').prop('checked', true);
				}
			}
			get_menifest_out_detail();
		})

		function get_menifest_out_detail() {
			detail_manifest_out = [];
			let ttl_berat=0;
			let total=0;
			$('.selected-dt').each(function() {
				detail_manifest_out.push($(this).data('pengiriman'));
				ttl_berat+=parseFloat($(this).data('berat'));
				total+=parseFloat($(this).data('subtotal'));
			});
			$('#ttl-berat-checked').text(ttl_berat+' kg');
			$('#total-pengiriman-checked').text('Rp '+currencyFormat(total));
			console.log(detail_manifest_out);
		}
	</script>
	<?php
}elseif (isset($act) && $act="load_detail_manifest_out_general") {
	?>
	<div class="slider container-fluid">
		<table id="table-manifest-out" class="table table-sm table-bordered">
			<thead style="background-color: azure">
				<tr style="text-align: center">
					<th>SA</th>
					<th>KOLI</th>
					<th>JENIS BARANG</th>
					<th>PENGIRIM</th>
					<th>PENERIMA</th>
					<th>BERAT</th>
					<th>ONGKOS</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody class="bg-azure">
				<?php 
				$total=0;
				$ttl_berat=0;
				foreach ($manifest_dt as $data => $value) : 
						// print_r($value);
					$ongkir=0;
					$satuan='';
					$ongkir_satuan='';
					if ($value->harga_koli>0) {
						$ongkir=$value->harga_koli;
						$satuan='@';
					}
					if ($value->harga_berat>0) {
						$ongkir=$value->harga_berat;
						$satuan='kg';
					}
					if ($value->harga_volume>0) {
						$ongkir=$value->harga_volume;
						$satuan='m3';
					}
					if ($satuan=='@') {
						$ongkir_satuan=$satuan." Rp ".number_format($ongkir,0,',','.');
					}else{
						$ongkir_satuan="Rp ".number_format($ongkir,0,',','.')." /".$satuan;
					}
					?>
					<tr class="text-center data-dt-<?= $data ?> selected-dt details" data-pengiriman="<?= $value->no_transaksi ?>" data-berat="<?=$value->berat ?>" data-subtotal="<?=$value->subtotal?>">
						<td><?= $value->no_sa ?></td>
						<td><?= $value->koli ?></td>
						<td><?= $value->item ?></td>
						<td><?= $value->pengirim ?></td>
						<td><?= $value->penerima ?></td>
						<td><?= $value->berat." kg" ?></td>
						<td style="text-align: right;"><?= $ongkir_satuan ?></td>
						<td style="text-align: right;"><?= "Rp ".number_format($value->subtotal,0,',','.') ?></td>

					</tr>
					<?php 
					$ttl_berat+=$value->berat;
					$total+=$value->subtotal;
				endforeach; 
				?>
			</tbody>
		</table>
	</div>
	<?php
}else{
	echo view('errors/html/error_404');
}

?>