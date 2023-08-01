<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

	public function index(){

		if (!$this->hasLogin()) {
			redirect('admin/site/login');
		}

		$this->fragment['js'] = [ 
			base_url('assets/js/pages/admin/registration.js') 
		];

		$this->fragment['pagename'] = 'admin/pages/registration.php';

		$participant = $this->sitemodel->view('view_participants', '*');
		$this->fragment['participant'] = ( $participant ? sizeof($participant) : 0 );

		/*$attendance = $this->sitemodel->custom_query(" SELECT attendance_id FROM tr_attendance GROUP BY registration_id");
		$this->fragment['attendance'] = ( $attendance ? sizeof($attendance) : 0 );*/

		/* $attendance = $this->sitemodel->view('view_registration', '*', ['is_verify'=>1]);
		$this->fragment['attendance'] = ( $attendance ? sizeof($attendance) : 0 );

		$not_attend = $this->sitemodel->view('view_registration', '*', ['is_verify'=>0]);
		$this->fragment['not_attend'] = ( $not_attend ? sizeof($not_attend) : 0 ); */

		/* $total_registrant = $this->sitemodel->custom_query("SELECT participant_unit_bisnis, COUNT(*) AS TOTAL FROM view_registration GROUP BY participant_unit_bisnis");
		$this->fragment['total_registrant'] = $total_registrant;

		$total_registrant_attend = $this->sitemodel->custom_query("SELECT participant_unit_bisnis, COUNT(*) AS TOTAL FROM view_registration WHERE is_verify = 1  GROUP BY participant_unit_bisnis");
		$this->fragment['total_registrant_attend'] = $total_registrant_attend; */

		// echo json_encode($total_registrant);die;
		$this->load->view('admin/layout/main-site', $this->fragment);
	}

	public function login(){
		if( $this->hasLogin() ) redirect();
		$this->load->view('admin/login_page');
	}

	public function signin()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name','Username','required');
		$this->form_validation->set_rules('user_pass','Password','required');

		if ($this->form_validation->run() == false) {
			$this->response['msg'] = validation_errors();
			echo json_encode($this->response);
			exit;
		}

		$user_name = $this->input->post('user_name');
		$user_pass = md5($this->input->post('user_pass'));

		$check = $this->sitemodel->view('tab_user', '*', ['user_name'=>$user_name]);
		if (!$check) {$this->response['msg'] = "No user found.";echo json_encode($this->response);exit;}

		if ( $user_pass != $check[0]->user_pass ) {
			$this->response['msg'] = "Invalid username or password.";
			echo json_encode($this->response);
			exit;					
		}

		$data_sess = [
			'log_user'	=> $check[0]->user_id,
		];

		$this->session->set_userdata(SESS, (object)$data_sess);
		$this->response['type'] = 'done';
		$this->response['msg'] = "Successfully login.";
		echo json_encode($this->response);
	}

	public function signout()
	{
		$this->session->sess_destroy();
		redirect ( base_url() );
	}
}
