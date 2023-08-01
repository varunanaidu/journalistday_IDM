<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends MY_Controller {

	public function index(){

		 $this->load->view('registration/index');
		
		// if ( date('Y-m-d H:i:s') < '2021-11-26 00:00:00' ) {
		// 	$this->load->view('registration/index');
		// }else{
		// 	$this->load->view('registration/index2');
		// }
	}

	public function registered($id)
	{
		$data['participant'] = $this->sitemodel->view('tab_participants', '*', ['participant_id'=>$id]);
		// echo json_encode($data);die;
		$this->load->view('registration/registered', $data);
	}

	public function save()
	{
		// echo json_encode($this->input->post());die;
		/*** Check POST or GET ***/
		if ( !$_POST ){$this->response['msg'] = "Invalid parameters.";echo json_encode($this->response);exit;}

		$participant_name = $this->input->post('participant_name');
		$participant_div = $this->input->post('participant_div');
		$participant_wa = $this->input->post('participant_wa');
		$identityPhoto = $_FILES['participant_pic'];

		$data_participant = [
			'participant_name' 		=> $participant_name,
			'participant_div'		=> $participant_div,
			'participant_wa'		=> $participant_wa,
			'addon'					=> date('Y-m-d H:i:s')
		];

        if ( $identityPhoto['name'] != '' ) {
        	$temp_name = $identityPhoto['name'];
        	$target_dir = 'assets/files/' . md5(date('Y-m-d').'identityPhoto') . '/';

			$ext = explode('.', $temp_name);
			$end = strtolower(end($ext));

			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}

			$attachment_name = $target_dir."identityPhoto.".$end;

			move_uploaded_file($identityPhoto['tmp_name'], $attachment_name);
			$data_participant['participant_pic'] = $attachment_name;
        }

		$check_name = $this->sitemodel->view('tab_participants', '*', ['participant_name'=>$participant_name]);
		if ($check_name) {$this->response['msg'] = "Anda telah melakukan pendaftaran !";echo json_encode($this->response);exit;}

		$participant_id = $this->sitemodel->insert('tab_participants', $data_participant);

		/*** Result Area ***/
		$this->response['type'] = 'done';
		$this->response['id'] = $participant_id;
		echo json_encode($this->response);
		exit;
	}
}
