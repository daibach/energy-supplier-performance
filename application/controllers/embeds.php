<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Embeds extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');
  }

  public function index() {
    show_404(current_url());
  }

  public function consumer_futures_latest_data() {
    $latest_period = $this->periods->latest();

    if($latest_period) {

      $latest_period_data = $this->period_data->all_for_period($latest_period->id, false, 'ranking');

      $data = array(
        'period' => $latest_period,
        'period_data' => $latest_period_data
      );

      $this->load->view('consumerfutures/latest_data',$data);

    } else {
      $this->_data_unavailable();
    }
  }

}

/* End of file embeds.php */
/* Location: ./application/controllers/embeds.php */