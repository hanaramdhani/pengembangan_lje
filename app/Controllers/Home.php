<?php

namespace App\Controllers;

use Config\View;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}

	public function tes()
	{
		$data['gambar'] = '63-francesco-bagnaia_dsc2264.gallery_full_top_fullscreen.jpg';
		return \view('tes', $data);
	}
}
