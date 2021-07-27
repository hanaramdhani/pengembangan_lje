<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>
<div id="ajax-container">


</div>
<script type="text/javascript">
    var loading = `
    <div class="d-flex justify-content-center mt-2"  >
    <div class="spinner-border text-primary" role="status">
    <span class="sr-only">Loading...</span>
    </div>
    </div>`;
    $(function() {
        first_load();
    })

    function first_load() {
        // alert('a');
        
        $('#ajax-container').html(loading);
        let act = `<?= $act ?>`;
        let key = `<?= $key ?>`;
        // alert(act);

        $.ajax({
            type: 'post',
            url: `<?= base_url() ?>/ajax_load/${act}/invoice/pengiriman/` + key,
            data: '',
            success: function(r) {
                $('#ajax-container').html(r);

            }
        });
    }

    function tes_sweet(msg) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: msg
        })
    }
</script>

<?= $this->endSection(); ?>