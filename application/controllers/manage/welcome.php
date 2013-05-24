<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends ESP_Controller {

  public function index() {
    show_404(current_url());
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/manage/welcome.php */