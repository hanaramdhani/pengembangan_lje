<?= $this->extend('layouts/template'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="/assets/tes.css">
<?php
$tesArr = [
  'bandi' => [
    'nama' => 'Ahmad SYahbandi',
    'alamat' => 'lingsar'
  ],
  'frans' => [
    'nama' => 'Fransdika',
    'alamat' => 'mataram'
  ],
  'satria' => [
    'nama' => 'Satriadi kawih jaran',
    'alamat' => 'Praya'
  ]
];

$encoded = json_encode($tesArr);
?>

<div class="row">
  <div class="col">
    <div class="card card-danger card-tabs">
      <div class="card-header p-0 pl-1 pt-1">
        <ul class="nav nav-tabs" id="tab-pengiriman" role="tablist">
          <li class="nav-item">
            <a class="nav-link active px-5 font-weight-bold" id="tab-pengiriman-dasar" data-toggle="pill" href="#tab-pengiriman-dasar-form" role="tab" aria-controls="tab-pengiriman-dasar-form" aria-selected="true">Dasar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-pengiriman-paket" data-toggle="pill" href="#tab-pengiriman-paket-form" role="tab" aria-controls="tab-pengiriman-paket-form" aria-selected="false">Paket</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="tab-pengirimanContent">
          <div class="tab-pane fade active show" id="tab-pengiriman-dasar-form" role="tabpanel" aria-labelledby="tab-pengiriman-dasar">
            <form class="form-horizontal w-50">
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="inputEmail3" placeholder="Email" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Password</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
              </div>

              <!-- <div class="form-group row">
                <label for="tesselect" class="col-sm-4 col-form-label">Tes select2</label>
                <div class="col-sm-8">
                  <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
              </div> -->

              <!-- <div class="form-group row">
                <label for="" class="col-sm-4">Tes input group</label>
                <div class="col sm-8">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control isRupiah" placeholder="Masukkan Diskon" id="diskon" value="">
                    <div class="input-group-append">
                      <div class="switch-field">
                        <input type="radio" id="radio-rp" name="radio-diskon" value="Rp" checked />
                        <label for="radio-rp" class="mb-0">Rp</label>
                        <input type="radio" id="radio-percent" name="radio-diskon" value="%" />
                        <label for="radio-percent" class="mb-0">%</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
            </form>

            <div class="row w-50">
              <div class="offset-sm-4 col-sm-8">
                <button class="btn btn-info" id="btnSubmit">Tambah</button>
              </div>
            </div>

          </div>
          <div class="tab-pane fade" id="tab-pengiriman-paket-form" role="tabpanel" aria-labelledby="tab-pengiriman-paket">
            Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>

<div class="d-flex mb-3">
  <h3 class="m-0">Detail Paket</h3>
  <div class="ml-auto">
    <button id="printcok" class="btn btn-sm btn-success">Print</button>
    <a class="btn btn-sm btn-primary" href="/printController/generatePDF/pengiriman/?no_transaksi=1&title=Struk Pengiriman" target="_blank">Download PDF</a>
  </div>
</div>
<div class="card card-danger">
  <div class="card-body">
    <div id="printable">
      <table class="table table-bordered mb-0" id="table-detail">
        <thead class="bg-danger">
          <tr>
            <th style="width: 10px">#</th>
            <th>Email</th>
            <th>Password</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>




<script>
  // $('.table').DataTable();
  $('.select2').select2()

  const data = [];

  const rows = () => {
    let html = '';
    for (let i = 0; i < data.length; i++) {
      html += `<tr>`;
      html += `<td>${i+1}</td>`
      for (let j = 0; j < data[i].length; j++) {
        html += `<td>${data[i][j]}</td>`;
      }
      html += `</tr>`;
    }

    return html;
  }

  $('#btnSubmit').on('click', function(e) {
    const inner = []
    $('form.form-horizontal :input').each(function(e) {
      if ($(this).val() !== '') {
        inner[e] = $(this).val()
        $(this).val('')
      } else {
        $(this).addClass('is-invalid')
      }
    })

    if (inner.length > 0) {
      data.push(inner)
    }
    console.log(data);
    $('#table-detail tbody').html(rows);
  });

  $('input#diskon').click(function() {
    $(this).val('')
  })

  $('input[name=radio-diskon]').click(function() {
    let vall = $(this).val()
    const diskonField = $('#diskon')
    let total = 100000

    if (vall === '%' && diskonField.hasClass('isRupiah')) {

      if (diskonField.val() !== '' && !isNaN(diskonField.val())) {
        diskonField.val(diskonField.val() / total * 100)
        diskonField.removeClass('isRupiah')
        diskonField.addClass('isPercent')
      }



    } else if (vall === 'Rp' && diskonField.hasClass('isPercent')) {
      if (diskonField.val() !== '' && !isNaN(diskonField.val())) {
        diskonField.val(total * (diskonField.val() / 100))
        diskonField.addClass('isRupiah')
        diskonField.removeClass('isPercent')
      }
    }


  })

  // $('#printcok').click(function(e) {
  //   console.log('tt');
  //   let table = $('#printable');
  //   let css = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">'
  //   let printArea = window.open('')
  //   printArea.document.write('<html lang="en">')
  //   printArea.document.write('<head>')
  //   printArea.document.write('<title>Tes</title>')
  //   // printArea.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />')
  //   printArea.document.write('<link rel="stylesheet" href="/assets/tes.css" media="print"/>')
  //   printArea.document.write('</head>')
  //   printArea.document.write('<body>')
  //   printArea.document.write('<h3 class="text-danger">Tes</h3>')
  //   printArea.document.write('</body>')
  //   printArea.document.write('</html>')
  //   // if (printArea.document.readyState === 'complete') {
  //   printArea.print()
  //   printArea.close()
  //   // }
  //   // printArea.close()
  // })
</script>

<?= $this->endSection(); ?>