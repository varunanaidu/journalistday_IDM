<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grandprize extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->select 		= '*';
		$this->from   		= 'view_report_doorprize';
		$this->order_by   	= ['doorprize_id'=>'DESC'];
		$this->order 		= ['gift_name', 'participant_name', 'participant_email', 'participant_wa', 'addon'];
		$this->search 		= ['gift_name', 'participant_name', 'participant_email', 'participant_wa', 'addon'];

	}

	public function index(){

		if (!$this->hasLogin()) {
			redirect('admin/site/login');
		}

		$this->fragment['js'] = [ 
			base_url('assets/js/pages/admin/grandprize.js') 
		];

		$this->fragment['pagename'] = 'admin/pages/grandprize.php';
		$this->load->view('admin/layout/main-site', $this->fragment);
	}

	public function view()
	{
		$data = array();
		$res = $this->sitemodel->get_datatable($this->select, $this->from, $this->order_by, $this->search, $this->order);
		$q = $this->db->last_query();
		$a = 1;

		foreach ($res as $row) {
			$col = array();
			$col[] = $row->participant_name;
			$col[] = $row->participant_div;
			$col[] = $row->participant_wa;
			$col[] = ($row->addon ? date('d/m/Y H:i:s', strtotime($row->addon)) : '-' );
			$data[] = $col;
			$a++;
		}
		$output = array(
			"draw" 				=> $_POST['draw'],
			"recordsTotal" 		=> $this->sitemodel->get_datatable_count_all($this->from),
			"recordsFiltered" 	=> $this->sitemodel->get_datatable_count_filtered($this->select, $this->from, $this->order_by, $this->search, $this->order),
			"data" 				=> $data,
			"q"					=> $q

		);
		echo json_encode($output);
		exit;
	}
}