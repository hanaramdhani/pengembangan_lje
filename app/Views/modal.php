<!-- modal crud -->
<div class="modal" tabindex="-1" role="dialog" id="modal-crud">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="frm-modal-crud">
                <div class="modal-header">
                    <div style="display: none;">
                        <span id="m-crud-key"></span>
                        <span id="m-crud-act"></span>
                        <span id="m-crud-page"></span>
                        <span id="m-crud-jenis"></span>
                    </div>
                    <h5 class="modal-title" id="m-crud-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="m-container-crud">
                    <!-- <p>Modal body text goes here.</p> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-btn" class="btn btn-primary"><i class="fas fa-save mr-2"></i>
                    Simpan</button>
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#add-modal').change(function() {
    let val = $(this).val(); // mengambil nilai dari id /class yang di pilih
    if (val == "") { //jika value nya kosong
        location.href = "isi link nya"; //panggil link dsini
        // $('#id_modal').modal('show') //panggil modal pakai fungsi ini
    }
});
</script>
<!-- modal crud -->
<script type="text/javascript">
    $('#frm-modal-crud').submit(function(e) {
        let loading_button = `
        <div style="width:50px">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="sr-only">Loading...</span></div>`;
        e.preventDefault();
        $('#modal-btn').prop('disabled',true);
        $('#modal-btn').html(loading_button);
        form_data = new FormData($('#frm-modal-crud')[0]);
        form_data.append('token', '123');
        form_data.append('frm_table', $('#m-crud-page').text());
        let act = $('#m-crud-act').text();
        let page = $('#m-crud-page').text();
    // alert(page);
    let jenis = $('#m-crud-jenis').text();
    let key_update = $('#m-crud-key').text();
    let url_ajax = "";

    if (act == "add") {
        url_ajax = `<?= base_url() ?>/api/insert`;
    } else if (act == "ambil") {
        url_ajax = `<?= base_url() ?>/api/insert`;
    } else {
        url_ajax = `<?= base_url() ?>/api/update/${key_update}/execute`;
    }
    $.ajax({
        type: 'POST',
        url: url_ajax,
        data: form_data,
        dataType: 'json',
        cache: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        success: function(r) {
            if (r.status == 200) {
                $('#modal-crud').modal('hide');
                $('#modal-btn').html(`<i class="fas fa-save mr-2"></i>Simpan`);
                $('#modal-btn').prop('disabled',false);
                tes_sweet(r.message);
                first_load();
            }
        }
    });
});
</script>


<!-- 
    modal panggil -->
    <div class="modal" tabindex="-1" role="dialog" id="modal-panggil">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="frm-modal-panggil">
                    <div class="modal-header">
                        <div>
                            <span id="m-customer"></span>
                        </div>
                        <h5 class="modal-title" id="m-crud-title-panggil"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- <div class="row"> -->
                    <!-- <div class="col-md-10">
                            <input type="text" id="cari" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button id="butonn" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                        </div> -->
                        <input type="hidden" id="start-customer">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="cari">
                            <div class="input-group-append">
                                <span id="butonn" class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <!-- </div> -->
                        <div id="m-container-panggil" class="overflow-auto" style="height: 400px">

                        </div>
                        <!-- <p>Modal body text goes here.</p> -->

                        <script type="text/javascript">
                            $('#cari').keypress(function(e) {
                                var key = e.which;
                                if (key == 13) {
                                    $('#butonn').click();
                                    return false;
                                }
                            })
                        </script>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- <script type="text/javascript">
$('#add-modal').change(function() {
    let val = $(this).val(); // mengambil nilai dari id /class yang di pilih
    if (val == "") { //jika value nya kosong
        location.href = "isi link nya"; //panggil link dsini
        // $('#id_modal').modal('show') //panggil modal pakai fungsi ini
    }
});
</script> -->
<!-- modal crud -->
<script type="text/javascript">
    $('#frm-modal-panggil').submit(function(e) {
        e.preventDefault();
        form_data = new FormData($('#frm-modal-panggil')[0]);
        form_data.append('token', '123');
        form_data.append('frm_table', $('#m-crud-page').text());
        let act = $('#m-crud-act').text();
        let page = $('#m-crud-page').text();
        let jenis = $('#m-crud-jenis').text();
        let url_ajax = "";
    });
    $('#pilih-customer').click(function() {
        let val = $(this).val();
        alert(val);

    });
</script>


<!-- modal crud coba -->
<div class="modal" tabindex="-1" role="dialog" id="modal-tambah">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <div style="display: none;">
                    <span id="m-id"></span>
                    

                </div>
                <h5 class="modal-title" id="m-crud-title-tambah">Tambah Data Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="m-container-crud-tambah">
                <div class="form-group row">
                    <label for="val_no_transaksi" class="col-sm-4 col-form-label">ID Pengiriman</label>
                    <div class="input-group input-group-sm col-sm-8 col-form-label">
                        <input type="text" class="form-control" id="ID" value="" placeholder="Isi ID Pengiriman"
                        aria-label="ID Pengiriman" aria-describedby="cariIDPengiriman" name="val_no_transaksi"
                        onkeydown="testFungsi()">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-success btn-flat" id="cariIDPengiriman">
                                <i class="fas fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="val_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="ket" rows="5" value="" name="val_keterangan">-</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-btn-1" class="btn btn-success" disabled>
                    <i class="fas fa-save mr-2"></i>
                    Tambah Data
                </button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#add-modal-coba').change(function() {
        let val = $(this).val(); 

        if (val == "") { 

            location.href = "isi link nya"; 
        }
    });
</script>
<script type="text/javascript">
    $('#frm-modal-tambah').submit(function(e) {
        e.preventDefault();
        form_data = new FormData($('#frm-modal-tambah')[0]);
        form_data.append('token', '123');
        form_data.append('frm_table', $('#m-crud-page').text());
        let act = $('#m-crud-act').text();
        let page = $('#m-crud-page').text();
        let jenis = $('#m-crud-jenis').text();

        let url_ajax = "";


        $.ajax({
            type: 'POST',
            url: url_ajax,
            data: form_data,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            success: function(r) {
                if (r.status == 200) {
                    $('#modal-crud-tambah').modal('hide');
                    tes_sweet(r.message);
                    first_load();
                }
            }
        });
    });
    $('#modal-btn-1').click(function() {
        console.log(ambilID);
        console.log($('#ID').val());
        console.log(ambilID.includes($('#ID').val()));

        $('#modal-tambah').modal('hide');

        if (ambilID.includes($('#ID').val())) {
            alert("ID Pengiriman yang Dicari Sudah Ada");
            $('#modal-tambah').modal('show');
            cb();
        } else {
            $('#isitagihan').append(tambahdata);
            tes_sweet('Tambah Data Paket Berhasil');
            normal();
            first_load();
            tambahdata = [];
        }
    });

    $('.close').click(function() {
        exit();
    });

    function normal() {
        document.getElementById("ID").value = "";
        document.getElementById("ket").value = "-";
        $('#cariIDPengiriman').html(`<i class="fas fa-search"></i>`);
        document.getElementById("modal-btn-1").disabled = true;

    }

    function exit() {
        document.getElementById("ID").value = "";
        document.getElementById("ket").value = "-";
        $('#cariIDPengiriman').html(`<i class="fas fa-search"></i>`);
        document.getElementById("modal-btn-1").disabled = true;

    }

    function testFungsi() {
        $('#cariIDPengiriman').html(`<i class="fas fa-search"></i>`);
        document.getElementById("modal-btn-1").disabled = true;
        tambahdata = [];
    }
</script>
<script type="text/javascript">
    $('#frm-modal-tambah').submit(function(e) {
        e.preventDefault();
        form_data = new FormData($('#frm-modal-tambah')[0]);
        form_data.append('token', '123');
        form_data.append('frm_table', $('#m-crud-page').text());
        let act = $('#m-crud-act').text();
        let page = $('#m-crud-page').text();
        let jenis = $('#m-crud-jenis').text();

        let url_ajax = "";


        $.ajax({
            type: 'POST',
            url: url_ajax,
            data: form_data,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            success: function(r) {
                if (r.status == 200) {
                    $('#modal-crud-tambah').modal('hide');
                    tes_sweet(r.message);
                    first_load();
                }
            }
        });
    });
</script>

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"                aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ku" style="height: 500px;">
            <div style="text-align: center;">
                <img class="before-load" src="<?= "/assets/dist/img/loading.gif" ?>" id="imagepreview">
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .modal-ku {
        padding: 1rem;
    }

    .before-load {
        position: absolute;
        top: 220px;
        left: 380px;
        width: 70px;
        height: 70px;
    }

    .after-load {
        width: 760px;
        height: 468px;
    }
</style>

<div class="modal" tabindex="-1" role="dialog" id="modal-detail-piutang">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <div style="display: none;">
                    <span id=""></span>
                </div>
                <h5 class="modal-title" id="">Detail Piutang (no_pengiriman:<strong style="color:blue" id="pengiriman-id"></strong>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="m-container-detail-piutang">
                
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-btn-1" class="btn btn-success" disabled>
                    <!-- <i class="fas fa-save mr-2"></i> -->
                    Tutup
                </button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal-load-pengiriman">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <div style="display: none;">
                    <span id=""></span>
                </div>
                <h5 class="modal-title" id="">Pengiriman (Customer: <strong id="cust-name"></strong>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <input type="text" id="subtotal-kirim" >
            <input type="text" id="terbayar-kirim" >
            <input type="text" id="sisa-cicilan-kirim" > -->
            <div class="modal-body" id="m-container-load-pengiriman">
                
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-btn-set-pengiriman" class="btn btn-success">
                    <!-- <i class="fas fa-save mr-2"></i> -->
                    OK
                </button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>