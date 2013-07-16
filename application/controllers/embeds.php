<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Embeds extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');
    $this->load->model('Suppliers_model','suppliers');
  }

  public function index() {
    show_404(current_url());
  }

  public function consumer_futures_latest_data() {
    $this->_do_cache();
    $latest_period = $this->periods->latest();

    if($latest_period) {

      $latest_period_data = $this->period_data->all_for_period($latest_period->id, false, 'month3_ranking');

      $pagedata = array(
        'page_title' => 'Latest Data',
        'page_scripts' => array(site_url('charts/current.js'))
      );

      $data = array(
        'period' => $latest_period,
        'period_data' => $latest_period_data
      );

      $this->load->view('consumerfutures/header',$pagedata);
      $this->load->view('consumerfutures/latest_data',$data);
      $this->load->view('consumerfutures/footer');

    } else {
      $this->_data_unavailable();
    }
  }

  public function consumer_futures_historical_data() {
    $this->_do_cache();
    $this->load->library('ESP_DataFormatter');

    $pagedata = array(
        'page_title' => 'Historical Data',
        'page_scripts' => array(site_url('charts/historical.js'))
      );

    $data = array(
      'suppliers' => $this->suppliers->all(),
      'historical_period_data' => $this->esp_dataformatter->generate_historical_data()
    );

    $this->load->view('consumerfutures/header',$pagedata);
    $this->load->view('consumerfutures/historical_data',$data);
    $this->load->view('consumerfutures/footer');

  }

}

/* End of file embeds.php */
/* Location: ./application/controllers/embeds.php */