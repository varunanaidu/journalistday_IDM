<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengambilan extends MY_Controller {

	public function index(){

		$this->load->view('pengambilan/index');
	}

	public function find(){
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}
		/*** Params ***/
		/*** Required Area ***/
		$key = $this->input->post("key");
		// $arr_key = explode("-", $key);
		// $parent_key = $arr_key[0];
		/*** Optional Area ***/
		/*** Validate Area ***/
		if ( empty($key) ){$this->response['msg'] = "Invalid parameter.";echo json_encode($this->response);exit;}
		/*** Accessing DB Area ***/
		 $check = $this->sitemodel->view('view_participants', '*', ['participant_id'=>$key]);
		//$check = $this->sitemodel->view('view_participants', '*', [explode("-",'participant_id',-1)=>explode("-",$key,-1)]);
		//$check = $this->sitemodel->custom_query("SELECT * FROM view_participants WHERE participant_id LIKE '".$parent_key."-%' ");
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
		
		$arr_key = explode("-", $participant_id);
		$parent_key = $arr_key[0];

		$check_nik = $this->sitemodel->view('view_participants', '*', ['participant_id'=>$participant_id]);
		//$check_nik = $this->sitemodel->custom_query("SELECT * FROM view_participants WHERE participant_id LIKE '".$parent_key."-%' ");
		if ( !$check_nik ) {$this->response['msg'] = "Data tidak ditemukan.";echo json_encode($this->response);exit;}
		

		$check_attendance = $this->sitemodel->view('view_registration', '*', ['participant_id'=>$participant_id]);
		//$check_attendance = $this->sitemodel->custom_query("SELECT * FROM view_registration WHERE participant_id LIKE '".$parent_key."-%' ");
		if ( $check_attendance ) {$this->response['msg'] = $participant_name." telah melakukan pengambilan goodiebag pada pukul ".date('d/m/Y H:i:s', strtotime($check_attendance[0]->ambil_datetime));echo json_encode($this->response);exit;}
		
		$real_participant_id = $check_nik[0]->participant_id;

		$data = [
			'participant_id' => $real_participant_id,
			'is_ambil' => 1,
			'ambil_datetime' => date('Y-m-d H:i:s'),
			'ambil_by' => $participant_id,
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
