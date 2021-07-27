<script type="text/javascript">
$(document).ready(function() {
    // resultberat();
    // resultvolume();
    // resultsubtotal();
    // volume();
});

function resultberat() {
    var berat = document.getElementById('val_jumlah_berat').value;
    var hrgberat = document.getElementById('val_harga_berat').value;
    var minimum = document.getElementById('min').value;
    var ber_min = parseInt(hrgberat) * parseInt(minimum);
    var rberat = parseInt(hrgberat) * parseInt(berat);
    var rminim = parseInt(minimum) * parseInt(berat);
    if (berat <= minimum) {
        if (!isNaN(ber_min)) {
            document.getElementById('harga_berat').value = ber_min;
            subtotal();
            total();
        }
    } else {
        if (!isNaN(rberat)) {
            document.getElementById('harga_berat').value = rberat;
            subtotal();
            total();
        }
    }

}

function volume() {
    var panjang = document.getElementById('val_panjang').value;
    var lebar = document.getElementById('val_lebar').value;
    var tinggi = document.getElementById('val_tinggi').value;
    var rs = parseInt(panjang) * parseInt(lebar) * parseInt(tinggi);
    // var hasil = parseInt(volume) *
    if (!isNaN(rs)) {
        document.getElementById('hrg_volume').value = rs;
        resultvolume();
        subtotal();
        total();
    }


    // if (!isNaN(result)) {
    //     document.getElementById('hrg_volume').value = result;
    //     resultvolume();
    // }
}

function resultvolume() {
    var hargavolume = document.getElementById('hrg_volume').value; //8
    var volume = document.getElementById('val_harga_volume').value; //15000
    var min_volum = document.getElementById('min_volum').value; // 3
    var hasil = parseInt(volume) * parseInt(hargavolume);
    var result = parseInt(volume) * parseInt(min_volum);


    if (hargavolume <= min_volum) {
        if (!isNaN(result)) {
            document.getElementById('harga_volume').value = result;
            resultsubtotal();
            subtotal();
            total();
        }
    } else {
        if (!isNaN(hasil)) {
            document.getElementById('harga_volume').value = hasil;
            resultsubtotal();
            subtotal();
            total();
        }

    }
}

function resultsubtotal() {
    var hargakoli = document.getElementById('harga_koli').value;
    var jumlahitem = document.getElementById('jumlah-item').value;
    var hargaberat = document.getElementById('harga_berat').value;
    var hargavolume = document.getElementById('harga_volume').value;
    var koli_item = parseInt(hargakoli) * parseInt(jumlahitem);
    var result = parseInt(hargaberat) + parseInt(hargavolume) + parseInt(koli_item);
    if (!isNaN(result)) {
        document.getElementById('val_subtotal').value = result;
        total();
    }

}

function total() {
    var subtotal = document.getElementById('val_subtotal').value;
    var diskon = document.getElementById('diskon').value;
    var totaldiskon = document.getElementById('val_diskon_t').value;
    // diskon persen detail
    var dskn = parseInt(subtotal) * (parseInt(diskon) / parseInt(100));
    var result = parseInt(subtotal) - parseInt(dskn);
    //diskon persen master
    var hasildiskon = parseInt(result) * (parseInt(totaldiskon) / parseInt(100));
    var resultfix = parseInt(result) - parseInt(hasildiskon);
    //diskon rupiah detail
    var diskonrupiah = parseInt(subtotal) - parseInt(diskon);
    //diskon rupiah detail && persen master
    var cb = parseInt(diskonrupiah) * (parseInt(totaldiskon) / parseInt(100));
    var cbhasil = parseInt(diskonrupiah) - parseInt(cb);
    //diskon rupiah master && rupiah detail
    var mrupiah_drupiah = parseInt(diskonrupiah) - parseInt(totaldiskon);
    //diskon rupiah master && persen detail
    var mrupiah_dpersen = parseInt(result) - parseInt(totaldiskon);
    if ($('#val_diskon_t').attr('maxlength') <= 3) {
        if ($('#diskon').attr('maxlength') <= 3) {
            if (!isNaN(resultfix)) {
                document.getElementById('val_total').value = resultfix;
            }
        } else {
            if (!isNaN(cbhasil)) {
                document.getElementById('val_total').value = cbhasil;
            }
        };
    } else {
        if ($('#diskon').attr('maxlength') <= 3) {
            if (!isNaN(mrupiah_dpersen)) {
                document.getElementById('val_total').value = mrupiah_dpersen;
            }
        } else {
            if (!isNaN(mrupiah_drupiah)) {
                document.getElementById('val_total').value = mrupiah_drupiah;
            }
        };
    }
};

function Check(object) {
    if (object.value.length > object.maxLength) {
        object.value = object.value.slice(0, object.maxLength)
    }
}
</script>