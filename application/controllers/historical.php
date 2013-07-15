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
    $pagedata = array(
      'page_section' => 'historical',
      'page_title' => "Historical supplier performanace data",
      'page_scripts' => array(
        site_url('charts/historical.js')
      )
    );

    $data = array(
      'suppliers' => $this->suppliers->all(),
      'historical_period_data' => $this->_generate_historical_data()
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

  function _generate_historical_data() {
    $suppliers = $this->suppliers->all();
    $periods = $this->periods->all();

    if( ! empty($periods)) {
      $historical_periods = array();

      foreach($periods as $period) {
        $period_data = $this->period_data->all_for_period($period->id,false,'name');

        $month1 = $month2 = $month3 = array(
          'month' => 0,
          'month_name' => '',
          'year' => $period->period_year,
          'quarter' => $period->period_quarter,
          'data' => array()
        );
        $month1['month'] = identify_quarter_month($period->period_quarter,1,'n');
        $month1['month_name'] = identify_quarter_month($period->period_quarter,1,'short');
        $month2['month'] = identify_quarter_month($period->period_quarter,2,'n');
        $month2['month_name'] = identify_quarter_month($period->period_quarter,2,'short');
        $month3['month'] = identify_quarter_month($period->period_quarter,3,'n');
        $month3['month_name'] = identify_quarter_month($period->period_quarter,3,'short');

        foreach($period_data as $period_supplier_data) {
          $m1 = $m2 = $m3 = array(
            'supplier' => $period_supplier_data->supplier_name,
            'supplier_slug' => $period_supplier_data->supplier_slug,
            'value' => 0,
            'ranking' => $period_supplier_data->ranking
          );
          $m1['value'] = $period_supplier_data->month1;
          $m2['value'] = $period_supplier_data->month2;
          $m3['value'] = $period_supplier_data->month3;

          $month1['data'][$period_supplier_data->supplier_id] = $m1;
          $month2['data'][$period_supplier_data->supplier_id] = $m2;
          $month3['data'][$period_supplier_data->supplier_id] = $m3;

        }

        array_push($historical_periods,$month1);
        array_push($historical_periods,$month2);
        array_push($historical_periods,$month3);

      }
      return $historical_periods;

    } else {
      return false;
    }

  }
}

/* Location: ./application/controllers/historical.php */