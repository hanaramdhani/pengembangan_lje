<?= $this->extend('layouts/template'); ?>
<?= $this->section('content'); ?>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12" id="col-master">
                <div class="card" id="card-for-master">
                    <div class="card-header"><h3 class="card-title">Periode: <span id="periode-report"> <?=date('d-m-Y')." - ".date('d-m-Y') ?> ( Hari Ini ) </span></h3></div>
                    <div class="card-body">
                        <?php if ($filter_tanggal=="show"): ?>
                            <form action="" method="post" id="form-filter">
                                <div class="row">
                                    <div class="col-12 col-lg-4">
                                        <input type="hidden" id="text-date" value="Hari Ini">
                                        <label>Filter Tanggal:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            
                                            <input type="text" class="form-control" id="daterange-btn" readonly="" value="<?=date('Y-m-d').' - '.date('Y-m-d') ?>">
                                            <span class="input-group-append">
                                                <button class="btn btn-info btn-flat" id="btn-filter-tanggal" type="submit">Submit</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="start" value="<?=date('Y-m-d') ?>">
                                <input type="hidden" name="end" id="" value="<?=date('Y-m-d') ?>">
                            </form>    
                        <?php endif ?>
                        
                    </div>
                    <div class="card-body" id="ajax-container">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function() {
        let date_awal=`<?=date('Y-m-d');?>`;
        let date_akhir=`<?=date('Y-m-d');?>`;
        first_load(date_awal,date_akhir);
    })


    function first_load(awal,akhir) {
        let page = `<?= $page ?>`;
        let filter_tanggal=`<?=$filter_tanggal ?>`;
        let text_date=$('#text-date').val();
        let loading=`
        <div class="d-flex justify-content-center" >
        <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
        </div>
        </div>`;
        $('#ajax-container').html(loading);
        $.ajax({
            type:'POST',
            url:`<?=base_url() ?>/ajax_load_laporan`,
            data:{page:page,date_filter:awal+' - '+akhir,filter_divisi:'',filter_tanggal:filter_tanggal},
            success:function(r){
                $('#btn-filter-tanggal').prop('disabled',false);
                $('#btn-filter-tanggal').html(`Submit`);
                if (text_date=='') {
                    $('#periode-report').text(' '+formatDate(awal)+' - '+formatDate(akhir));
                }else{
                    $('#periode-report').text(' '+formatDate(awal)+' - '+formatDate(akhir)+' ( '+text_date+' )');

                }
                $('#ajax-container').html(r);
                // console.log(formatDate(awal));
            }
        });
    }


    $('#daterange-btn').daterangepicker(
    {
        ranges   : {
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Minggu Ini': [moment().subtract(6, 'days'), moment()],
            'Minggu Lalu': [moment().subtract(12, 'days'), moment().subtract(6, 'days')],
            '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale:{
            format: 'YYYY-MM-DD'
        },  
        // autoApply: true,

    },function (start, end) {
        $('input[name="start"]').val(start.format('YYYY-MM-DD'));
        $('input[name="end"]').val(end.format('YYYY-MM-DD'));
        // $('section[data-range-key = '+myEm+']').addClass('active');
        // $('.ranges').children('ul').children('.active').each(function () {

            // alert($(this).attr('data-range-key'));

        // });
    });
    $(".ranges").on("click", "li", function (event) {
        let range_text=$(this).attr('data-range-key');
        if (range_text!='Custom Range') {
            $('#text-date').val(range_text);
        }else{
            $('#text-date').val('');
        }
        // alert($(this).attr('data-range-key'));
    });
    $('#form-filter').submit(function(e){
        e.preventDefault();
        $('#btn-filter-tanggal').prop('disabled',true);
        $('#btn-filter-tanggal').html(`
            <div style="width:50px">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span></div>`);
        let awal=$('input[name="start"]').val();
        let akhir=$('input[name="end"]').val();
        first_load(awal,akhir);
    });
    function formatDate(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [day, month, year].join('-');
    }


</script>



<?= $this->endSection(); ?>