<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller
{
	public function switch_lang($lang = 'bn')
	{
		$lang = ($lang === 'en') ? 'en' : 'bn';
		$this->session->set_userdata('app_lang', $lang);

		$ref = $this->input->server('HTTP_REFERER');
		if ($ref)
		{
			redirect($ref);
		}
		redirect('dashboard');
	}
}
