<?php

class Login extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('form_validation');  
  }
  
  /**
   * Displays a a login form
   * 
   * @access public
   */
  function index() {

    //if already logged in, redirect to account dashboard
    if($this->_is_logged_in()) { redirect('manage/account/dashboard','location'); }

    //is this a post?
    if( $this->input->post('action') ) {
      
      //yes, validate form with these rules:
      $this->form_validation->set_error_delimiters('<li>', '</li>');
      $this->form_validation->set_rules('email','email','trim|required|valid_email|xss_clean');
      $this->form_validation->set_rules('password','password','trim|required|min_length[8]|xss_clean');

      if($this->form_validation->run() === FALSE) {
        //form validation has failed, show login form again
        $this->_show_login_form();
      } else {
        //validation success, now check credentials
        $u = $this->input->post('email');
        $p = $this->input->post('password');

        $this->Accounts_model->verify_user($u,$p);

        if($this->_is_logged_in()) {
          redirect('manage/account/dashboard','location');
        }

        //invalid credentials, show login form
        redirect('manage/login','location');

      }

    } else {
      //not a post, show login form
      $this->_show_login_form();
    }
  }

  function _show_login_form() {
    $this->load->view('manage/header');
    $this->load->view('manage/login');
    $this->load->view('manage/footer');
  }  
 
  /**
   * Logs a user out and resets session variables
   * 
   * @access public
   */
  function logout() {
    if($this->_is_logged_in()) {
      $this->session->unset_userdata('admin_userid');
      $this->session->unset_userdata('admin_username');
      $this->session->sess_destroy();
      $this->session->sess_create();
      $this->session->set_flashdata('success',"You've been logged out!");
    } else {
      $this->session->set_flashdata('warning',"You are not logged in!");
    }

    redirect('manage/login','location');
  }

}

/* Location: ./application/controllers/manage/login.php */