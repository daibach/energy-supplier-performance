<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');
    $this->load->model('Suppliers_model','suppliers');
  }

  public function index()
  {

    $latest_period = $this->periods->latest();

    if($latest_period) {

      $latest_period_data = $this->period_data->all_for_period($latest_period->id, false, 'month3');

      $pagedata = array(
        'page_section' => 'latest',
        'page_scripts' => array(site_url('charts/current.js'))
      );

      $data = array(
        'period' => $latest_period,
        'period_data' => $latest_period_data,
        'period_average' => $this->period_data->average_for_period($latest_period->id)
      );

      $this->load->view('template/header',$pagedata);
      $this->load->view('welcome',$data);
      $this->load->view('template/footer');

    } else {
      $this->_data_unavailable();
    }
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */