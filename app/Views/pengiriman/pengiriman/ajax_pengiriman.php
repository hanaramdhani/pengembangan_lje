<?php
date_default_timezone_set('Asia/Jakarta');
if (isset($act) && $act == "view") {
    echo view('pengiriman/pengiriman/ajax_pengiriman_view');
} elseif (isset($act) && $act == "add" && !$modal) {
    echo view('pengiriman/pengiriman/ajax_pengiriman_add');
} elseif (isset($act) && $act == 'add' && $modal) {
    echo view('pengiriman/pengiriman/ajax_pengiriman_load_customer');  
} else {
    echo view('errors/html/error_404');
}
?>