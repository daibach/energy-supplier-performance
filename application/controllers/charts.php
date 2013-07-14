<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Charts extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');
    $this->load->model('Suppliers_model','suppliers');
  }

  public function index() {
    show_404(current_url());
  }

  public function current() {
    $this->_do_cache();
    $latest_period = $this->periods->latest();
    $this->_generate_period_chart($latest_period);
  }

  public function historical() {
    $this->_do_cache();
    $suppliers = $this->suppliers->all();
    if($suppliers) {
      $supplier_data = array();
      foreach($suppliers as $supplier) {
        $data = $this->period_data->all_for_supplier($supplier->id,false,true);
        array_push($supplier_data,array('supplier_details'=>$supplier,'supplier_data'=>$data));
      }

      $data = array(
        'supplier_data' => $supplier_data,
        'suppliers' => $suppliers,
        'periods' => $this->periods->all_published()
      );
      
      $this->output->set_content_type('application/javascript');
      $this->load->view('charts/historical_chart',$data);

    } else {
      show_404(current_url());
    }
  }

  public function view_period($year,$quarter) {
    $this->_do_cache();
    $period = $this->periods->find_by_date($year,$quarter);
    $this->_generate_period_chart($period);
  }

  public function view_supplier($slug) {
    $this->_do_cache();
    $supplier = $this->suppliers->find_by_slug($slug);
    if($supplier) {

      $period_data = $this->period_data->all_for_supplier($supplier->id,false,true);
      $average_supplier = $this->suppliers->find_by_slug('average');

      if($period_data) {

        $line_colour = '#006c78';
        switch(ranking_css_class($period_data[sizeof($period_data)-1]->ranking)) {
          case 'success': $line_colour = '#468847'; break;
          case 'info': $line_colour = '#3a87ad'; break;
          case 'warning': $line_colour = '#f89406'; break;
          case 'important': $line_colour = '#b94a48'; break;
        }

        $data = array(
          'supplier' => $supplier,
          'period_data' => $period_data,
          'line_colour' => $line_colour,
          'average_data' => null,
          'is_average_supplier' => FALSE
        );

        if($average_supplier->supplier_slug==$supplier->supplier_slug) {
          $data['is_average_supplier'] = TRUE;
        } else {
          $data['average_data'] = $this->period_data->all_for_supplier($average_supplier->id,false,true);
          $data['is_average_supplier'] = FALSE;
        }

        $this->output->set_content_type('application/javascript');
        $this->load->view('charts/supplier_chart',$data);

      } else {
        show_404(current_url());
      }

    } else {
      show_404(current_url());
    }
  }

  function _generate_period_chart($period) {
    if($period) {

      $period_data = $this->period_data->all_for_period($period->id, true, 'average');

      $data = array(
        'period' => $period,
        'period_data' => $period_data,
        'period_average' => $this->period_data->average_for_period($period->id)
      );

      $this->output->set_content_type('application/javascript');
      $this->load->view('charts/period_chart',$data);

    } else {
      show_404(current_url());
    }
  }

}

/* Location: ./application/controllers/charts.php */