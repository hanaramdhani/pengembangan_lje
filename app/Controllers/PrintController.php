<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \Mpdf\Mpdf;
class PrintController extends BaseController
{

	public function __construct()
	{
		$this->dompdf = new \Dompdf\Dompdf();
		$this->dompdf->getOptions()->set([
			'chroot' => \ROOTPATH
		]);
	}

	public function index()
	{
	}

	function generatePDF($route)
	{
		$table = $this->am->report_routing($route);
		$data = $this->am->get_data_where_general($table, ['no_transaksi' => $this->request->getVar('no_transaksi')])->getResultArray();
		$this->dompdf->loadHtml(view('print/' . $route . '_print', ["data" => $data,]));
		$this->dompdf->setBasePath(realpath(\ROOTPATH . 'public/'));
		$this->dompdf->setPaper('A4', $route == 'manifest' ? 'landscape' : 'portrait');
		$this->dompdf->render();
		$this->dompdf->stream($this->request->getVar('title'), ['Attachment' => 0]);
		return redirect()->to(base_url(''));
	}
	function generatemPDF($route){
		$mpdf = new Mpdf(['debug'=>FALSE,'mode' => 'utf-8', 'orientation' => 'L']);
		$table = $this->am->report_routing($route);
		$data = $this->am->get_data_where_general($table, ['no_transaksi' => $this->request->getVar('no_transaksi')])->getResultArray();
        $mpdf->WriteHTML(view('print/' . $route . '_print', ["data" => $data,]));
        $mpdf->Output('Laporan_data_pegawai.pdf','I');
        exit;
	}
}
