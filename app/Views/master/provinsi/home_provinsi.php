<?=$this->extend('layouts/template');?>
<?=$this->section('content');?>
<div id="ajax-container"></div>
<script type="text/javascript">
	$(function(){
		first_load();
	});
	function first_load(){
		let loading=`
		<div class="d-flex justify-content-center mt-2"  >
		<div class="spinner-border text-primary" role="status">
		<span class="sr-only">Loading...</span>
		</div>
		</div>`;
		$('#ajax-container').html(loading);

		// let act=`<?=$act ?>`;
		$.ajax({
			type:'post',
			url:`<?=base_url() ?>/ajax_load/view/provinsi/master`,
			data:'',
			success:function(r){
				setTimeout(function(){ 
					$('#ajax-container').html(r);
					// alert("Hello"); 
				}, 2000);
			}
		});
	}

</script>
<?=$this->endSection();?>