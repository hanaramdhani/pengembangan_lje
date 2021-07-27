<?php

if (isset($act) && $act == "view") {
	date_default_timezone_set('Asia/Jakarta');


	$data_append = array();
	foreach ($penagihan_detail as $key_row => $value_row) {
		$data_append["detail_" . $value_row->no_tagihan][] = $value_row;
	}
	$test = json_encode($data_append);




?>
	<link rel="stylesheet" href="<?= base_url('/sample_assets/style.css') ?>">

	<div class="card">
		<div class="card-body">
			<a class="btn btn-primary" href="<?= site_url('load/add/penagihan/pengiriman') ?>"><i class="fas fa-plus-circle"></i>
				Tambah Data</a>
		</div>
	</div>

	<div class="card card-outline card-danger">
		<div class="card-body">
			<table id="data-tampil" class="table table-striped table-bordered">
				<thead class="bg-danger">
					<tr class="text-center">
						<th>NO TRANSAKSI</th>
						<th>PEGAWAI</th>
						<th>DIVISI</th>
						<th>KETERANGAN</th>

						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($penagihan as $key => $value) : ?>
						<tr>
							<td class="text-center">
								<button style="float: left;" type="button" class="btn btn-primary btn-xs data-tampil" id="data-tampil" data-key="<?= $value->no_transaksi ?>">
									<i class="fa fa-eye"></i>
								</button>

								<?= $value->no_transaksi ?>
							</td>
							<td><?= $value->Name_exp_14 ?></td>
							<td><?= $value->divisi ?></td>
							<td><?= $value->keterangan ?></td>


							<td class="text-center">
								<button class="btn btn-xs <?= $value->status == 1 ? 'btn-success' : 'btn-danger' ?> edit-status" data-key='<?= $value->no_transaksi ?>'><i class="fa <?= $value->status == 1 ? 'fa-check-circle' : 'fa-ban' ?>" aria-hidden="true"></i>
									<!-- <?= $value->status == 1 ? 'Aktif' : 'Nonaktif' ?> -->
								</button>
								<button type="button" class="btn btn-warning btn-xs edit-master" data-key="<?= $value->no_transaksi  ?>">
									<i class="fa fa-edit"></i>
								</button>

								<button class="btn btn-danger btn-xs delete" data-key="<?= $value->no_transaksi ?>"> <i class="fa fa-trash"></i></button>
								<button class="btn btn-xs <?= $value->lampiran != '' ? 'btn-info' : 'btn-secondary disabled' ?>"><i class="fa fa-image"></i></button>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#data-tampil').DataTable();
		});
	</script>
	<script type="text/javascript">
		function format(data) {

			let penagihan_detail = <?= (!empty($test)) ? $test : '' ?>['detail_' + data];
			let content = ``;
			if (penagihan_detail != "") {
				for (var i = 0; i < penagihan_detail.length; i++) {
					content += `
                    <tr style="background-color:azure">
                    <td>` + (i + 1) + `</td>
                    <td>` + penagihan_detail[i]['nomor'] + `</td>
                    <td>` + penagihan_detail[i]['no_tagihan'] + `</td>
                    <td>` + penagihan_detail[i]['no_pengiriman'] + `</td>
                    <td>` + penagihan_detail[i]['keterangan'] + `</td>
                    <td>` + penagihan_detail[i]['status'] + `</td>
					<td>
					<button class="btn btn-xs btn-warning" onclick="edit_tagih_detail(` + penagihan_detail[i]['nomor'] + `)"><i class="fa fa-edit"></i></button>
					<button class="btn btn-xs btn-danger" onclick="delete_tagih_detail(` + penagihan_detail[i]['nomor'] + `)"><i class="fa fa-trash"></i></button>
					</td>
                    </tr>
                    `;
				}
			}
			let html_content = `<div class="slider container-fluid" name>
            <table class="table table-responsive table-condensed" style="opacity:0.9">
            <tr>
                        <th>#</th>
                        <th>Nomor</th>
                        <th>No Tagihan</th>
                        <th>No Pengiriman</th>
                        <th>Keterangan</th>
                        <th>Status</th>
						<th></th>
                       
            </tr>
            ` + content + `
			<tr>
            <td colspan="11">
            <button type="button"  style="text-align: center" class="btn btn-success btn-xs" onclick="add_detail_tagih(` +
				data + `)"><i class="fas fa-plus-circle"></i> </button>
            </td>
            </tr>
            </table>
            </div>`;
			// console.log(html_content);
			return html_content;

		}

		function add_detail_tagih(key_master) {

			$.ajax({
				type: 'POST',
				url: `<?= base_url() ?>/ajax_load/add/penagihan_detail/pengiriman/-1/true`,
				data: {
					master_key: key_master
				},
				success: function(r) {
					$('#m-crud-title').text('Tambah Data Tagihan Detail');
					$('#m-crud-key').text('-1');
					$('#m-crud-act').text('add');
					$('#m-crud-page').text('penagihan_detail');
					$('#m-crud-jenis').text('penagihan');
					$('#m-container-crud').html(r);
					$('#modal-crud').modal('show');
				}
			});
		}

		$("#data-tampil").on('click', '.data-tampil', function() {
			var table = $('#data-tampil').DataTable();
			var tr = $(this).closest('tr');
			var row = table.row(tr);

			if (row.child.isShown()) {
				// This row is already open - close it
				$('div.slider', row.child()).slideUp(function() {
					row.child.hide();
					tr.removeClass('shown');
				});
			} else {
				row.child(format($(this).data('key'))).show();
				tr.addClass('shown');
				$('div.slider', row.child()).slideDown();
			}
		});
		$("#data-tampil").on('click', '.edit-master', function() {
			let key_update = $(this).data('key');
			$.ajax({
				type: 'POST',
				url: `<?= base_url() ?>/ajax_load/edit/penagihan/pengiriman/` + key_update + `/true`,
				success: function(r) {
					$('#m-crud-title').text('Edit Data Penagihan');
					$('#m-crud-key').text(key_update);
					$('#m-crud-act').text('edit');
					$('#m-crud-page').text('penagihan');
					$('#m-crud-jenis').text('master');
					$('#m-container-crud').html(r);
					$('#modal-crud').modal('show');
				}
			});
			if (row.child.isShown()) {
				// This row is already open - close it
				$('div.slider', row.child()).slideUp(function() {
					row.child.hide();
					tr.removeClass('shown');
				});
			} else {
				row.child(format($(this).data('key'))).show();
				tr.addClass('shown');
			}
		});
		$()

		function edit_tagih_detail(key_update) {
			// alert(key_update);
			$.ajax({
				type: 'POST',
				url: `<?= base_url() ?>/ajax_load/edit/penagihan_detail/pengiriman/` + key_update + `/true`,
				success: function(r) {
					$('#m-crud-title').text('Edit Detail Penagihan');
					$('#m-crud-key').text(key_update);
					$('#m-crud-act').text('edit');
					$('#m-crud-page').text('penagihan_detail');
					$('#m-crud-jenis').text('master');
					$('#m-container-crud').html(r);
					$('#modal-crud').modal('show');
				}
			});

		}

		function delete_tagih_detail(key_delete) {
			swal_delete('penagihan_detail', key_delete);
		}
	</script>




	<script type="text/javascript">
		$('.call-modal').click(function() {
			let key = $(this).data('key');
			let page = `<?= $page ?>`;
			let jenis = `<?= $jenis ?>`;
			let jenis_modal = $(this).attr('id');
			let act = '';
			let title_modal = '';
			if (jenis_modal == "add-modal") {
				act = "add";
				title_modal = "Tambah Jenis Paket";
			} else if (jenis_modal == "edit-modal") {
				act = "edit";
				title_modal = "Ubah Jenis Paket ";
			}
			$.ajax({
				type: 'POST',
				url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}` + key + '/true',
				success: function(r) {
					$('#m-crud-title').text(title_modal);
					$('#m-crud-key').text(key);
					$('#m-crud-act').text(act);
					$('#m-crud-page').text(page);
					$('#m-crud-jenis').text(jenis);
					$('#m-container-crud').html(r);
					$('#modal-crud').modal('show');
				}
			});
		});
		$('.delete').on('click', function() {
			let key_delete = $(this).data('key');
			Swal.fire({
				title: '?',
				text: "Apakah anda Yakin?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Tidak'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						url: `<?= base_url() ?>/api/delete/` + key_delete,
						data: `frm_table=penagihan&token=123`,
						dataType: 'json',
						success: function(r) {
							// alert(r.status);

							if (r.status == 200) {
								tes_sweet('hapus data berhasil');
								first_load();
								// first_load();
							}
						}
					});
				}
			})
		});

		function swal_delete(table, key) {
			Swal.fire({
				title: '?',
				text: "Apakah anda Yakin?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Tidak'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						url: `<?= base_url() ?>/api/delete/` + key,
						data: `frm_table=${table}&token=<?= $_SESSION['token'] ?>`,
						dataType: 'json',
						success: function(r) {
							// alert(r.status);
							if (r.status == 200) {
								tes_sweet('hapus data berhasil');
								first_load();
								// first_load();
							}
						}
					});
				}
			})
		}
	</script>
<?php

} elseif (isset($act) && $act == "add" && !$modal) {
	// print_r($_SESSION);

?>

	<form id="myform">
		<div class="row">
			<div class="col-12">
				<div class="card card-danger card-tabs">
					<div class="card-body">
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Kode Referensi</label>
									<p id="cetak"></p>
									<div class="col-sm-9">
										<input name="val_kd_kirim_reff" class="form-control" id="val_kd_kirim_reff" value="-">
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Divisi</label>
									<div class="col-sm-8">
										<select class="form-control select2 data" style="width: 100%;" name="val_kd_divisi">
											<option selected="0">Pilih Divisi</option>
											<?php foreach ($divisi as $ds) : ?>
												<option value="<?php echo $ds->kd_divisi; ?>"> <?php echo $ds->nama ?> </option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>

						</div>
						<input type="hidden" name="val_tanggal" value="<?= date('Y-m-d H:i:s') ?>">
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Pegawai</label>
									<div class="col-sm-9">
										<select class="form-control select2 data" style="width: 100%;" name="val_kd_pegawai">
											<option selected="0">Pilih Pegawai</option>
											<?php foreach ($pegawai as $key_pegawai => $value_pegawai) : ?>
												<option value="<?= $value_pegawai->kd_pegawai ?>"><?= $value_pegawai->nama ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Lampiran</label>
									<div class="col-sm-8">
										<input class="data" type="file" name="val_lampiran">
									</div>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Keterangan</label>
									<div class="col-sm-9">
										<textarea class="form-control" rows="3" name="val_keterangan">-</textarea>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6">


								<div class="form-group row" hidden>
									<div class="col-2">
										<label for="val_status">Status</label>
									</div>
									<div class="col-2" id="radio-aktif">
										<p><input type='radio' name="val_status" value="1" checked /> Aktif</p>
									</div>
									<div class="col-3" id="radio-aktif1">
										<p><input type='radio' name="val_status" value="0" />Non-Aktif</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="title col-10">
						<h3 style="text-align: left;">Detail Paket</h3>
					</div>
					<div class="col-2">
						<button type="button" id="add-modal-coba" style="margin-left: auto;" class="form-control btn btn-success cari-pengiriman">Tambah</button>
					</div>
				</div>

				<div class="row">

					<div class="card card-outline card-danger col-12">
						<div class="card-body">
							<table id="table-penagihan" class="table table-striped table-bordered">
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
								<tbody class="text-center" id="isitagihan">
									<?php foreach ($data_pengiriman as $key => $value) : ?>
										<tr class="data-dt-<?= $key ?> selected-dt" data-pengiriman="<?= $value->no_transaksi ?>" data-keterangan="-">
											<td><input type="checkbox" class="cb-child" value="click_key_<?= $key ?>" data-click="<?= $key ?>"></td>
											<td id="cekNo" class="cobaA" onclick="cb()"><?= $value->no_transaksi ?></td>
											<td><?= $value->jumlah_item ?></td>
											<td><?= $value->from_to ?></td>
											<td><?= $value->tujuan ?></td>
											<td><?= $value->subtotal ?></td>

										</tr>
									<?php endforeach ?>

								</tbody>
							</table>

							<div class="card-footer text-center">

								<button type="submit" name="btn_submit" value="Simpan" id="send-ajax-array-js" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data </button>
							</div>

						</div>
					</div>

				</div>

			</div>
		</div>
	</form>

	<script type="text/javascript">
		$('.cari-pengiriman').click(function() {
			$('#modal-tambah').modal('show');
			cb();



		});
		var detail_tagihan = [];
		$('.call-modal').click(function() {
			let key = $(this).data('key');
			let page = `<?= $page ?>`;
			let jenis = `<?= $jenis ?>`;
			let jenis_modal = $(this).attr('id');
			let act = '';
			let title_modal = '';
			if (jenis_modal == "add-modal") {
				act = "add";
				title_modal = "Tambah Jenis Paket";
			} else if (jenis_modal == "edit-modal") {
				act = "edit";
				title_modal = "Ubah Jenis Paket ";
			}
			$.ajax({
				type: 'POST',
				url: `<?= base_url() ?>/ajax_load/${act}/${page}/${jenis}` + key + '/true',
				success: function(r) {
					$('#m-crud-title').text(title_modal);
					$('#m-crud-key').text(key);
					$('#m-crud-act').text(act);
					$('#m-crud-page').text(page);
					$('#m-crud-jenis').text(jenis);
					$('#m-container-crud').html(r);
					$('#modal-crud').modal('show');
				}
			});
		});
		$('.delete').on('click', function() {
			let key_delete = $(this).data('key');
			Swal.fire({
				title: '?',
				text: "Apakah anda Yakin?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya',
				cancelButtonText: 'Tidak'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: 'POST',
						url: `<?= base_url() ?>/api/delete/` + key_delete,
						data: `frm_table=penagihan&token=123`,
						dataType: 'json',
						success: function(r) {
							// alert(r.status);

							if (r.status == 200) {
								tes_sweet('hapus data berhasil');
								first_load();
								// first_load();
							}
						}
					});
				}
			})
		});
		$(document).ready(function() {
			first_load();
		});

		function first_load() {
			$('#table-penagihan').DataTable();
			$("#head-cb").prop('checked', true)
			// if ($("#head-cb").prop('checked') == true) {
			// console.log("AKTIF")
			$(".cb-child").prop('checked', true)
			// } else {
			// console.log("GA AKTIF")
			// $(".cb-child").prop('checked', true)
			// }

			get_detail_tagihan();
		}

		$("#head-cb").on('click', function() {
			if ($("#head-cb").prop('checked') == true) {
				console.log("AKTIF")
				$(".cb-child").prop('checked', true)
			} else {
				$(".cb-child").prop('checked', false)
			}
		})
		$("#table-penagihan").on('click', '.cb-child', function() {
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
			get_detail_tagihan();

		})

		function get_detail_tagihan() {
			detail_tagihan = [];
			var object = {};
			$('.selected-dt').each(function() {
				object = {};
				object['val_no_pengiriman'] = $(this).data('pengiriman');
				object['val_status'] = 1;
				object['val_keterangan'] = $(this).data('keterangan');
				detail_tagihan.push(object);
			});
			console.log(detail_tagihan);
		}


		$('#myform').submit(function(e) {
			e.preventDefault();
			form_data = new FormData($('#myform')[0]);
			form_data.append('token', '123');
			form_data.append('frm_table', 'penagihan');
			for (var i = 0; i < detail_tagihan.length; i++) {
				for (var property in detail_tagihan[i]) {
					form_data.append(`detail[${i}][${property}]`, detail_tagihan[i][property]);
				}
			}
			$.ajax({
				type: 'post',
				url: `<?= base_url() ?>/api/multi_insert`,
				data: form_data,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				enctype: 'multipart/form-data',
				success: function(r) {
					console.log(r);
					if (r.status == 200) {
						tes_sweet('simpan data berhasil');
						// location.href = `<?= base_url() ?>/load/view/kirim/master`;
						location.reload();
					}
				}
			});
		});
		let tambahdata = '';
		var ambilID = [];
		$('#cariIDPengiriman').click(function(e) {
			// alert('berhasil');
			const loading = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;

			$('#cariIDPengiriman').html(loading);

			let recordrow = $('.cb-child').length;
			// alert(recordrow);
			$.ajax({
				type: 'post',
				url: `<?= base_url() ?>/api/cek_pengiriman/${$('input[name=val_no_transaksi]').val()}`,
				data: {
					token: '<?= $_SESSION['token']; ?>'
				},
				dataType: 'json',
				success: function(r) {
					console.log(r);
					if (r.status == 200) {
						$('#cariIDPengiriman').html(`<i class="fas fa-check"></i>`)
						document.getElementById("modal-btn-1").disabled = false;

						// alert('data ditemukan');
						tambahdata += '<tr class="data-dt-' + (recordrow + 1) + ' selected-dt" data-pengiriman=' + r.no_transaksi + ' data-keterangan="-">'
						tambahdata += `<td><input type="checkbox" class="cb-child" value="click_key_${recordrow+1}" data-click="${recordrow+1}"></td>`
						tambahdata += `<td class="cobaA">` + r.no_transaksi + `</td>`
						tambahdata += `<td>` + r.jumlah_item + `</td>`
						tambahdata += `<td>` + r.from_to + `</td>`
						tambahdata += `<td>` + r.tujuan + `</td>`
						tambahdata += `<td>` + r.subtotal + `</td>`
						tambahdata += '</tr>'
						//    alert(tambahdata);

					} else {

						alert('ID Pengiriman Tidak Ditemukan!')
						document.getElementById("modal-btn-1").disabled = true;
						$('#cariIDPengiriman').html(`<i class="fas fa-search"></i>`)
						document.getElementById("ID").value = "";
					}
				}
			});
		});

		function cb() {
			ambilID = []
			$('.cobaA').each(function() {
				ambilID.push($(this).text())
			})
			console.log(ambilID);
		}
	</script>
<?php

} elseif (isset($act) && $act == 'edit' && $modal) {
?>

	<input type="hidden" class="form-control data" id="key_no_transaksi" name="key_no_transaksi" value="<?= $edit_data->no_transaksi ?>" required>
	<!-- Kolom Kota asal hasil dari kd_kota_asal  -->
	<div class="form-group row">

		<label for="val_kd_pegawai" class="col-sm-2 col-form-label">Pegawai</label>
		<div class="col-sm-10">
			<select class="form-control select2 data" style="width: 100%;" name="val_kd_pegawai">
				<option selected="0">Pilih Pegawai</option>
				<?php foreach ($pegawai as $pg) : ?>
					<option value="<?php echo $pg->kd_pegawai; ?>" <?= ($pg->kd_pegawai == $edit_data->kd_pegawai) ? 'selected' : '' ?>> <?php echo $pg->nama ?> </option>
				<?php endforeach; ?>
			</select>

		</div>
	</div>
	<!-- End Kolom kd_kota_asal  -->

	<!-- Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->
	<div class="form-group row">
		<label for="val_kd_divisi" class="col-sm-2 col-form-label">Divisi</label>
		<div class="col-sm-10">
			<select class="form-control select2 data" style="width: 100%;" name="val_kd_divisi">
				<option selected="0">Pilih Divisi</option>
				<?php foreach ($divisi as $ds) : ?>
					<option value="<?php echo $ds->kd_divisi; ?>" <?= ($ds->kd_divisi == $edit_data->kd_divisi) ? 'selected' : '' ?>> <?php echo $ds->nama ?> </option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<!-- End Kolom Kota Tujuan hasil dari kd_kota_tujuan  -->
	<!-- Kolom keterangan  -->
	<div class="form-group row">
		<label for="val_keterangan" class="col-sm-2 col-form-label">Keterangan</label>
		<div class="col-sm-10">
			<textarea class="form-control data" rows="5" name="val_keterangan"><?= $edit_data->keterangan ?></textarea>
		</div>
	</div>
	<!-- End Kolom keterangan  -->
	<!-- Kolom status  -->
	<div class="form-group row">
		<div class="col-sm-2">
			<label for="val_status">Status</label>
		</div>
		<div class="col-sm-2" id="radio-aktif">
			<p><input type='radio' class="data" name="val_status" value="1" <?= ($edit_data->status == 1) ? 'checked' : '' ?> /> Aktif</p>
		</div>
		<div class="col-sm-3" id="radio-aktif1">
			<p><input type='radio' class="data" name="val_status" value="0" <?= ($edit_data->status == 0) ? 'checked' : '' ?> /> Non-Akif</p>
		</div>
	</div>
	<!-- End Kolom status  -->

	<!-- Kolom Lampiran  -->
	<div class="form-group row">
		<div class="col-sm-2">
			<label for="val_lampiran">Lampiran</label>
		</div>
		<div class="col-sm-10">
			<div class="row">
				<img id="gmbrTagih" src="" style=" width: 100px; height:100px;" />
			</div>
			<div class="row mt-2">
				<input class="data" type="file" name="val_lampiran" onchange="previewgmbrTagih()">
			</div>
		</div>
	</div>
	<!-- End Kolom Lampiran  -->

	<script>
		function previewgmbrTagih() {
			let frame = document.getElementById('gmbrTagih');
			frame.src = URL.createObjectURL(event.target.files[0]);
		}
	</script>

<?php
} else {
	echo view('errors/html/error_404');
}

?>