<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//application/libraries/MY_Controller.php

class ESP_Controller extends CI_Controller {

  function __construct() {
    parent::__construct();
    session_start();
    if (SITE_MAINTENANCE) {
      include('maintenance.php');
      exit;
    }

  }

  function _do_cache() {
    if(SITE_CACHE) {
      $this->output->cache(SITE_CACHE_TIME);
    }
  }

  function _is_logged_in() {
    if( $this->session->userdata('admin_userid') ) {
      if ($this->session->userdata('admin_userid') < 1) {
        return FALSE;
      } else {
        if( $this->Accounts_model->validate_access($this->session->userdata('admin_userid'))) {
          return TRUE;
        }
      }
    } else {
      return FALSE;
    }
  }

  function _allowed_access() {
    if($this->_is_logged_in()) {
      return TRUE;
    } else {
      $this->session->set_flashdata('warning',"You must be signed in!");
      redirect('manage/login','location');
    }
  }

  function _data_unavailable() {
    echo('data is currently unavailable');
  }

}
