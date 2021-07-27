<?php 
if (isset($act) && $act == 'edit' && $modal) {
	?>
	<input type="hidden" id="key-update" name="key_kd_kirim_detail" value="<?=$edit_data->kd_kirim_detail?>">
	
	<div class="form-group row">
		<label for="val_layanan" class="col-sm-4 col-form-label">Layanan</label>
		<div class="col-sm-8">
			<select class="form-control select2 data-dt" name="val_kd_layanan" id="add-modal-select-layanan">
				<option selected="0">Pilih Layanan</option>
				<?php foreach ($layanan as $ly) : ?>
					<option value="<?php echo $ly->kd_layanan; ?>" <?=($edit_data->kd_layanan==$ly->kd_layanan)?'selected':'';?>> <?php echo $ly->nama ?> </option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<!--  End Kolom Layanan  -->

	<!--  Kolom Jenis Paket  -->
	<div class="form-group row">
		<label for="val_jenis_paket" class="col-sm-4 col-form-label">Jenis Paket</label>
		<div class="col-sm-8">
			<select class="form-control select2 data-dt" name="val_kd_jenis" id="add-modal-select">
				<option selected="0">Pilih Jenis Paket</option>
				<?php foreach ($jenis_kirim as $jk) : ?>
					<option value="<?php echo $jk->kd_jenis; ?>" <?=($edit_data->kd_jenis==$jk->kd_jenis)?'selected':'';?>> <?php echo $jk->nama ?> </option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<!--  End Kolom Jenis Paket  -->
	<!--  Kolom Harga/kg  -->
	<div class="form-group row">
		<label for="val_harga" class="col-sm-4 col-form-label">Harga/kg</label>
		<div class="col-sm-8">
			<input type="number" min="0" class="form-control data-dt" id="val_harga_berat" name="val_harga_berat" value="<?=$edit_data->harga_berat ?>">
		</div>
	</div>
	<!--  End Kolom Harga/kg  -->

	<!--  Kolom Minimal Berat  -->
	<div class="form-group row">
		<label for="val_min_berat" class="col-sm-4 col-form-label">Minimal Berat</label>
		<div class="col-sm-8">
			<input type="number" min="0" class="form-control data-dt" id="val_min_berat" name="val_min_berat" value="<?=$edit_data->min_berat ?>">
		</div>
	</div>
	<!--  End Kolom Minimal Berat  -->


	<!--  Kolom Harga/m3 -->
	<div class="form-group row">
		<label for="val_harga" class="col-sm-4 col-form-label">Harga/m3</label>
		<div class="col-sm-8">
			<input type="number" min="0" class="form-control data-dt" id="val_harga_volume" name="val_harga_volume" value="<?=$edit_data->harga_volume ?>">
		</div>
	</div>
	<!-- End  Kolom Harga/m3 -->

	<!--  Kolom Minimal Volume -->
	<div class="form-group row">
		<label for="val_min_volume" class="col-sm-4 col-form-label">Minimal Volume</label>
		<div class="col-sm-8">
			<input type="number" min="0" class="form-control data-dt" id="val_min_volume" name="val_min_volume" value="<?=$edit_data->min_volume ?>">

		</div>
	</div>
	<!--  End Kolom Minimal Volume -->


	<!--  Kolom  PrediksiHari -->
	<div class="form-group row">
		<label for="val_prediksi_hari" class="col-sm-4 col-form-label">Prediksi Hari</label>
		<div class="col-sm-8">
			<input type="number" min="0" class="form-control data-dt" id="val_prediksi_hari" name="val_prediksi_hari" value="<?=$edit_data->prediksi_hari ?>">
		</div>
	</div>
	<!--  End Kolom Prediksi Hari -->


	<!--  Kolom Status -->
	<div class="form-group row">
		<div class="col-sm-4">
			<label for="val_status">Status</label>
		</div>
		<div class="col-sm-2" id="radio-aktif">
			<p><input class="data-dt radio-dt-status" type='radio' id="status-dt-aktif" name="val_status" value="1" <?=($edit_data->status==1)?'checked':'' ?>/> Aktif</p>
		</div>
		<div class="col-sm-3" id="radio-aktif1">
			<p><input class="radio-dt-status" type='radio' name="val_status" id="status-dt-non-aktif" value="0" <?=($edit_data->status==0)?'checked':'' ?>/> Non-Akif</p>
		</div>
	</div>
	<!-- End Kolom Status -->
	<?php
} else {
	echo view('errors/html/error_404');
}

?>