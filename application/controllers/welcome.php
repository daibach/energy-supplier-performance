<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends ESP_Controller {

  public function index()
  {
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');

    $latest_period = $this->periods->latest();

    if($latest_period) {

      $latest_period_data = $this->period_data->all_for_period($latest_period->id, false, true);

      $data = array(
        'period' => $latest_period,
        'period_data' => $latest_period_data,
        'period_average' => $this->period_data->average_for_period($latest_period->id)
      );

      $this->load->view('template/header');
      $this->load->view('welcome',$data);
      $this->load->view('template/footer');

    } else {
      echo('There is no data to display');
    }
  
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */