<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Antigen extends MY_Controller {

	public function index(){

		$this->load->view('antigen/index');
	}

	public function find(){
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		$check = $this->sitemodel->view('view_participants', '*', ['participant_id'=>$key]);
		if (!$check) {$this->response['msg'] = "Data tidak ditemukan.";echo json_encode($this->response);exit;}
		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['msg'] = $check;
		echo json_encode($this->response);
		exit;
	}

	public function save_antigen()
	{
		// echo json_encode($this->input->post());die;
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}

		$registration_id 	= $this->input->post('registration_id');
		$participant_id 	= $this->input->post('participant_id');
		$participant_name 	= $this->input->post('participant_name');

		$check_nik = $this->sitemodel->view('view_participants', '*', ['participant_id'=>$participant_id]);
		if ( !$check_nik ) {$this->response['msg'] = "Data tidak ditemukan.";echo json_encode($this->response);exit;}
		

		$check_attendance = $this->sitemodel->view('view_registration', '*', ['participant_id'=>$participant_id]);
		if ( $check_attendance ) {$this->response['msg'] = "Anda telah melakukan pengambilan jersey pada pukul ".date('d/m/Y H:i:s', strtotime($check_attendance[0]->ambil_datetime));echo json_encode($this->response);exit;}

		$data = [
			'participant_id' => $participant_id,
			'is_ambil' => 1,
			'ambil_datetime' => date('Y-m-d H:i:s'),
			'addon' => date('Y-m-d H:i:s'),
			'modion' => date('Y-m-d H:i:s'),
		];

		$insert = $this->sitemodel->insert('tr_registration', $data);

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['participant_name'] = $check_nik[0]->participant_name;
		$this->response['participant_id'] = $check_nik[0]->participant_id;
		$this->response['ukuran_jersey'] = $check_nik[0]->ukuran_jersey;
		$this->response['category'] = $check_nik[0]->category;
		echo json_encode($this->response);
		exit;
	}
}
