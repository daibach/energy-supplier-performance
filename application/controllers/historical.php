<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Historical extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');
    $this->load->model('Suppliers_model','suppliers');
  }

  public function index()
  {

    $this->load->library('ESP_DataFormatter');

    $pagedata = array(
      'page_section' => 'historical',
      'page_title' => "Historical supplier performanace data",
      'page_scripts' => array(
        site_url('charts/historical.js')
      )
    );

    $data = array(
      'suppliers' => $this->suppliers->all(),
      'historical_period_data' => $this->esp_dataformatter->generate_historical_data()
    );

    $this->load->view('template/header',$pagedata);
    $this->load->view('historical_list',$data);
    $this->load->view('template/footer');
  }

  public function view_quarter($year,$quarter) {
    $period = $this->periods->find_by_date($year,$quarter);
    if($period) {

      $period_data = $this->period_data->all_for_period($period->id,false,'average');

      $pagedata = array(
        'page_section' => 'historical',
        'page_title' => "$period->period_year quarter $period->period_quarter performanace data",
        'page_scripts' => array(
          site_url(array('charts','historical',$period->period_year.'-q'.$period->period_quarter.'.js'))
        )
      );

      $data = array(
        'period' => $period,
        'period_data' => $period_data
      );

      $this->load->view('template/header',$pagedata);
      $this->load->view('view_period',$data);
      $this->load->view('template/footer');

    } else {
      show_404(current_url());
    }
  }

}

/* Location: ./application/controllers/historical.php */