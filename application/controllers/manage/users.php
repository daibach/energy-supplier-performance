<?php

class Users extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->_allowed_access(); 
    $this->load->library('form_validation');
  }
  
  function index() {
    $pagedata = array(
      'page_title'=>'User accounts',
      'page_section'=>'users'
    );

    $data = array(
      'users' => $this->Accounts_model->all()
    );

    $this->load->view('manage/header',$pagedata);
    $this->load->view('manage/users/list',$data);
    $this->load->view('manage/footer');
  }

  function suspend($user_id) {
    if($this->Accounts_model->find_by_id($user_id)) {
      $this->Accounts_model->deactivate($user_id,'inactive');
      $this->session->set_flashdata('success','The account has been deactivated');
      redirect(site_url('manage/users'),'location');
    } else {
      show_404(current_url());
    }
  }

  function activate($user_id) {
    if($this->Accounts_model->find_by_id($user_id)) {
      $this->Accounts_model->activate($user_id,'inactive');
      $this->session->set_flashdata('success','The account has been activated');
      redirect(site_url('manage/users'),'location');
    } else {
      show_404(current_url());
    }
  }

  function create() {

    $this->form_validation->set_error_delimiters('<li>', '</li>');
    $this->form_validation->set_rules('email','email','trim|required|valid_email|xss_clean');

    // validate form
    if ($this->form_validation->run() === TRUE) {
      //valid post
      $email = $this->input->post('email');

      //does this user
      if($this->Accounts_model->find_by_email($email)) {
        //user exists, can't create again
        $this->session->set_flashdata('warning','This user already exists.');
        redirect('manage/users','location');
      } else {
        //no user exists, create new user
        $password = generate_password(10);

        $user_id = $this->Accounts_model->create($email,$password);

        if($user_id > 0) {
          //generate confirmation email
          $message = "";
          $message .= "Someone has set up a user account for the ".SITE_NAME." system.\n\n";
          $message .= "Your username and password are below. You should change this password when you first log in.\n\n";
          $message .= "Username: $email\n";
          $message .= "Password: $password\n";
          $message .= "Login URL: ".site_url('manage/login')."\n\n";
          $message .= "If your email program does not let you click on this link, just copy and paste it into your web browser and hit return.\n\n";

          $subject = "Your user account details";

          $this->_send_email_notice($email,$subject,$message);

          $this->session->set_flashdata('success',"Acount &#39;$email&#39; has been created.");
          redirect('manage/users','location');

        } else {
          $this->session->set_flashdata('error','Something went wrong when creating user.');
          redirect('manage/users','location');
        }

      }
    } else {
      $this->index();
    }
  }

  function reset_password($user_id) {
    $user = $this->Accounts_model->find_by_id($user_id);
    if($user) {

      $salt = generate_salt(10,$user->email);
      $password = generate_password(10);
      $encrypted_password = encrypt_password($password,$salt);

      if($this->Accounts_model->update_password($user->id,$salt,$encrypted_password)) {

        //password has been reset, generate confirmation email
        $message = "";
        $message .= "Someone has requested a new password for the ".SITE_NAME." system. Your new password is below.\n\n";
        $message .= "Password: $password\n";
        $message .= "Login URL: ".site_url('manage/login')."\n\n";
        $message .= "If your email program does not let you click on this link, just copy and paste it into your web browser and hit return.\n\n";

        $subject = "Your new password";

        $this->_send_email_notice($user->email,$subject,$message);

        $this->session->set_flashdata('success',"A new password has been sent to the user.");
        redirect('manage/users','location');


      } else {
        $this->session->set_flashdata('error','Something went wrong when resetting the password.');
        redirect('manage/users','location');
      }
    } else {
      show_404(current_url());
    }
  }

  function delete($user_id) {
    if($this->Accounts_model->find_by_id($user_id)) {
      $this->Accounts_model->delete($user_id);
      $this->session->set_flashdata('success','The account has been deleted');
      redirect(site_url('manage/users'),'location');
    } else {
      show_404(current_url());
    }
  }

  function _send_email_notice($email,$subject,$message) {

    $this->load->library('Email');
    $this->email->from(SITE_EMAIL_FROM,SITE_EMAIL_FROM_NAME);
    $this->email->to($email);
    $this->email->subject("[".SITE_SHORT_NAME."] $subject");
    $this->email->message($message);
    $this->email->send();

  }

}

/* Location: ./application/controllers/manage/users.php */