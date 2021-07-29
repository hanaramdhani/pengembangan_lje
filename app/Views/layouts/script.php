<script type="text/javascript">
function currencyFormat(num) {
    return (num
        .toFixed(0)
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
    );
}

function resultberat() {
    var berat = document.getElementById('val_jumlah_berat').value;
    var hrgberat = document.getElementById('val_harga_berat').value;
    var minimum = document.getElementById('min').value;
    var ber_min = parseFloat(hrgberat) * parseFloat(minimum);
    var rberat = parseFloat(hrgberat) * Math.abs(parseFloat(berat));
    var rminim = parseFloat(minimum) * Math.abs(parseFloat(berat));

    if (berat != 0) {
        if (parseFloat(berat) <= parseFloat(minimum)) {
            if (!isNaN(ber_min)) {
                document.getElementById('harga_berat').value = ber_min;
            }
        } else {
            if (!isNaN(rberat)) {
                document.getElementById('harga_berat').value = rberat;
            }
        }
    } else {
        document.getElementById('harga_berat').value = 0;
    }
    // volume();
    // resultvolume();
    // resultsubtotal();
    // total();

}

function volume() {
    var panjang = document.getElementById('val_panjang').value;
    var lebar = document.getElementById('val_lebar').value;
    var tinggi = document.getElementById('val_tinggi').value;
    var rs = parseFloat(panjang) * parseFloat(lebar) * parseFloat(tinggi);
    if (!isNaN(rs)) {
        document.getElementById('hrg_volume').value = rs.toFixed(3);
        // resultvolume();
    }
}

function resultvolume() {
    var hargavolume = document.getElementById('hrg_volume').value; //8
    var volume = document.getElementById('val_harga_volume').value; //15000
    var min_volum = document.getElementById('min_volum').value; // 3
    var hasil = parseFloat(volume) * Math.abs(parseFloat(hargavolume));
    var result = parseFloat(volume) * parseFloat(min_volum);


    if (Math.abs(parseFloat(hargavolume)) <= parseFloat(min_volum)) {
        if (!isNaN(result)) {
            if (hargavolume != 0) {

                document.getElementById('harga_volume').value = result;
            } else {
                document.getElementById('harga_volume').value = 0;
            }
            // resultsubtotal();
        }
    } else {
        if (!isNaN(hasil)) {
            document.getElementById('harga_volume').value = hasil;
            // resultsubtotal();
        }
    }

}

function resultsubtotal() {
    var hargakoli = document.getElementById('harga_koli').value.split('.').join('');
    var jumlahitem = document.getElementById('jumlah-item').value;
    var hargaberat = document.getElementById('harga_berat').value;
    var hargavolume = document.getElementById('harga_volume').value;
    var koli_item = parseFloat(hargakoli) * parseFloat(jumlahitem);
    var result = parseFloat(hargaberat) + parseFloat(hargavolume) + parseFloat(koli_item);

    if (!isNaN(result)) {
        document.getElementById('val_subtotal').value = currencyFormat(result);
        // total();
    }
}



function total() {
    resultberat()
    volume();
    resultvolume();
    resultsubtotal();
    var diskon_persen = (document.getElementById('discount-val').value != '') ? document.getElementById('discount-val')
        .value : 0;
    var subtotal = document.getElementById('val_subtotal').value.split('.').join('');
    var diskon = document.getElementById('diskon').value;
    var totaldiskon = document.getElementById('val_diskon_t').value;


    //diskon 0, for db
    var discount = parseFloat(diskon) / parseFloat(100);

    // diskon persen detail
    var dskn = parseFloat(subtotal) * (parseFloat(diskon) / parseFloat(100));
    var result = parseFloat(subtotal) - parseFloat(dskn);
    //diskon persen master
    var hasildiskon = parseFloat(result) * (parseFloat(totaldiskon) / parseFloat(100));
    var resultfix = parseFloat(result) - parseFloat(hasildiskon);
    //diskon rupiah detail
    var diskonrupiah = parseFloat(subtotal) - parseFloat(diskon);
    //diskon rupiah detail && persen master
    var cb = parseFloat(diskonrupiah) * (parseFloat(totaldiskon) / parseFloat(100));
    var cbhasil = parseFloat(diskonrupiah) - parseFloat(cb);
    //diskon rupiah master && rupiah detail
    var mrupiah_drupiah = parseFloat(diskonrupiah) - parseFloat(totaldiskon);
    //diskon rupiah master && persen detail
    var mrupiah_dpersen = parseFloat(result) - parseFloat(totaldiskon);
    // var hasilkali = parseFloat(diskonkoma) * parseFloat(100);


    if ($('#val_diskon_t').attr('maxlength') <= 3) {
        if ($('#diskon').attr('maxlength') <= 3) {
            if (!isNaN(resultfix)) {
                document.getElementById('val_total').value = currencyFormat(resultfix);
                if (!isNaN(discount)) {
                    document.getElementById('discount-val').value = discount;
                    get_diskon();
                }
            }
        } else {
            if (parseFloat(diskon) > parseFloat(subtotal)) {
                // $('#diskon').val(subtotal);
                alert('diskon melebihi sub total')
            } else {
                if (!isNaN(cbhasil)) {
                    document.getElementById('val_total').value = currencyFormat(cbhasil);
                    document.getElementById('discount-val').value = diskon;
                }
            }
        }
        // document.getElementById('discount-val').value = diskon_persen;
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

function get_diskon() {
    var ct = document.getElementById('discount-val').value;
    var hs = parseFloat(ct) * parseFloat(100);

    if (ct < 1) {
        if (!isNaN(hs)) {
            document.getElementById('diskon').value = hs;
        }
    } else {
        document.getElementById('diskon').value = ct;
    }
}





function total1() {
    // function resultberat() {
    // alert($('#min').val());
    var berat = document.getElementById('val_jumlah_berat').value;
    var hrgberat = document.getElementById('val_harga_berat').value;
    var minimum = document.getElementById('min').value;
    var ber_min = parseFloat(hrgberat) * parseFloat(minimum);
    var rberat = parseFloat(hrgberat) * Math.abs(parseFloat(berat));
    var rminim = parseFloat(minimum) * Math.abs(parseFloat(berat));
    // alert(minimum);

    if (berat != 0) {
        if (parseFloat(berat) <= parseFloat(minimum)) {
            if (!isNaN(ber_min)) {
                document.getElementById('harga_berat').value = ber_min;
            }
        } else {
            if (!isNaN(rberat)) {
                document.getElementById('harga_berat').value = rberat;
            }
        }
    } else {
        document.getElementById('harga_berat').value = 0;
    }
    // alert($('#harga_berat').val()); 
    // volume();
    // resultvolume();
    // resultsubtotal();
    // total();

    // }

    // function volume() {
    var panjang = document.getElementById('val_panjang').value;
    var lebar = document.getElementById('val_lebar').value;
    var tinggi = document.getElementById('val_tinggi').value;
    var rs = parseFloat(panjang) * parseFloat(lebar) * parseFloat(tinggi);
    if (!isNaN(rs)) {
        document.getElementById('hrg_volume').value = rs.toFixed(3);
        // resultvolume();
    }
    // }

    // function resultvolume() {
    var hargavolume = document.getElementById('hrg_volume').value; //8
    var volume = document.getElementById('val_harga_volume').value; //15000
    var min_volum = document.getElementById('min_volum').value; // 3
    var hasil = parseFloat(volume) * Math.abs(parseFloat(hargavolume));
    var result = parseFloat(volume) * parseFloat(min_volum);
    // alert(hasil);

    if (Math.abs(parseFloat(hargavolume)) <= parseFloat(min_volum)) {
        if (!isNaN(result)) {
            if (hargavolume != 0) {

                document.getElementById('harga_volume').value = result;
            } else {
                document.getElementById('harga_volume').value = 0;
            }
            // resultsubtotal();
        }
    } else {
        if (!isNaN(hasil)) {
            document.getElementById('harga_volume').value = hasil;
            // resultsubtotal();
        }
    }


    // }

    // function resultsubtotal() {
    var hargakoli = document.getElementById('harga_koli').value.split('.').join('');
    var jumlahitem = document.getElementById('jumlah-item').value;
    var hargaberat = document.getElementById('harga_berat').value;
    var hargavolume = document.getElementById('harga_volume').value;
    var koli_item = parseFloat(hargakoli) * parseFloat(jumlahitem);
    var result = parseFloat(hargaberat) + parseFloat(hargavolume) + parseFloat(koli_item);

    if (!isNaN(result)) {
        document.getElementById('val_subtotal').value = currencyFormat(result);
        // total();
    }
    // }


    // function total() {
    var diskon_persen = (document.getElementById('discount-val').value != '') ? document.getElementById(
            'discount-val')
        .value : 0;
    var subtotal = document.getElementById('val_subtotal').value.split('.').join('');
    var diskon = (document.getElementById('diskon').value != '') ? (document.getElementById('diskon').value).split('.')
        .join('') : 0;
    var totaldiskon = document.getElementById('val_diskon_t').value;

    // alert(diskon);
    //diskon 0, for db
    var discount = parseFloat(diskon) / parseFloat(100);

    // diskon persen detail
    var dskn = parseFloat(subtotal) * (parseFloat(diskon) / parseFloat(100));
    var result = parseFloat(subtotal) - parseFloat(dskn);
    //diskon persen master
    var hasildiskon = parseFloat(result) * (parseFloat(totaldiskon) / parseFloat(100));
    var resultfix = parseFloat(result) - parseFloat(hasildiskon);
    //diskon rupiah detail
    var diskonrupiah = parseFloat(subtotal) - parseFloat(diskon);
    //diskon rupiah detail && persen master
    var cb = parseFloat(diskonrupiah) * (parseFloat(totaldiskon) / parseFloat(100));
    var cbhasil = parseFloat(diskonrupiah) - parseFloat(cb);
    //diskon rupiah master && rupiah detail
    var mrupiah_drupiah = parseFloat(diskonrupiah) - parseFloat(totaldiskon);
    //diskon rupiah master && persen detail
    var mrupiah_dpersen = parseFloat(result) - parseFloat(totaldiskon);
    // alert(mrupiah_dpersen);
    // alert(mrupiah_drupiah);
    // var hasilkali = parseFloat(diskonkoma) * parseFloat(100);

    if ($('#val_diskon_t').attr('maxlength') <= 3) {
        if ($('#diskon').attr('maxlength') <= 3) {
            if (!isNaN(resultfix)) {
                document.getElementById('val_total').value = currencyFormat(resultfix);
                if (!isNaN(discount)) {
                    document.getElementById('discount-val').value = discount;
                    get_diskon();
                }
            }
        } else {
            if (parseFloat(diskon) > parseFloat(subtotal)) {
                // $('#diskon').val(subtotal);
                alert('diskon melebihi sub total')
            } else {
                if (!isNaN(cbhasil)) {
                    document.getElementById('val_total').value = currencyFormat(cbhasil);
                    document.getElementById('discount-val').value = diskon;
                }
            }
        }
        document.getElementById('discount-val').value = diskon_persen;
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

    // };

    // function Check(object) {
    // if (object.value.length > object.maxLength) {
    //     object.value = object.value.slice(0, object.maxLength)
    // }
    // }

    var ct = document.getElementById('discount-val').value;
    var hs = parseFloat(ct) * parseFloat(100);

    if (ct < 1) {
        if (!isNaN(hs)) {
            document.getElementById('diskon').value = hs;
        }
    } else {
        document.getElementById('diskon').value = ct;
    }
}

function swal2_confirm(link) {
    Swal.fire({
        title: '?',
        text: "Kembali Ke Halaman Utama?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = link;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // location.reload(true);
            first_load();
        }
    })
}
</script>