<?php

class Account extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->_allowed_access(); 
  }
  
  function index() {
    redirect('manage/account/dashboard','location');
  }

  function dashboard() {

    $pagedata = array(
      'page_title' => 'Account Dashboard'
    );

    $this->load->view('manage/header',$pagedata);
    $this->load->view('manage/account/dashboard');
    $this->load->view('manage/footer');
  }

  function change_password() {

    $this->load->library('form_validation'); 

    //is this a form post?
    if ($this->input->post('action')) {

      //yes, set validation rules
      $this->form_validation->set_error_delimiters('<li>', '</li>');
      $this->form_validation->set_rules('currentPassword','current password','trim|required|xss_clean');
      $this->form_validation->set_rules('newPassword','new password','trim|required|min_length[8]|matches[newPasswordAgain]|xss_clean');
      $this->form_validation->set_rules('newPasswordAgain','retyped password','trim|required|xss_clean');

      //validate the items in the form
      if ($this->form_validation->run() === TRUE) {
        //the form is valid
        //now we should look to make sure the user is allowed to change their password
        $current_userid = $this->session->userdata('admin_userid');

        if($this->Accounts_model->is_password_correct($current_userid, $this->input->post('currentPassword'))) {
          //old password was valid so we should now generate new password things

          $user_details = $this->Accounts_model->find_by_id($current_userid);

          //generate new salt and password
          $newsalt = generate_salt(10,$user_details->email);
          $newpass = encrypt_password($this->input->post('newPassword'), $newsalt);

          $success = $this->Accounts_model->update_password($current_userid,$newsalt,$newpass);

          if($success) {
            $this->session->set_flashdata('success','Your password has been updated');
            redirect('manage/account/change-password','location');
          } else {
            $this->session->set_flashdata('error','There was a problem. Please try again.');
            redirect('manage/account/change-password','location');
          }

        } else {
          //old password wasn't valid, we shouldn't allow the change
          $this->session->set_flashdata('error','Your old password was invalid. Please try again.');
          redirect('manage/account/change-password','location');
        }
      } else {
        //no, form did not validate
        $this->_show_change_password_form();
        
      }

    } else {
      //no - this is a first load
      $this->_show_change_password_form();
    }

  }

  function _show_change_password_form() {

    $pagedata = array(
      'page_title' => 'Change your password',
      'page_section' => 'password'
    );

    $this->load->view('manage/header',$pagedata);
    $this->load->view('manage/account/change_password');
    $this->load->view('manage/footer');
  }

}

/* Location: ./application/controllers/manage/account.php */