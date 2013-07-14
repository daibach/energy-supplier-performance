<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');
    $this->load->model('Suppliers_model','suppliers');
  }

  public function index()
  {

    $suppliers = $this->suppliers->all();

    if($suppliers) {

      $pagedata = array(
        'page_section' => 'suppliers',
        'page_title' => "Energy suppliers"
      );

      $data = array(
        'suppliers' => $suppliers
      );

      $this->load->view('template/header',$pagedata);
      $this->load->view('supplier_list',$data);
      $this->load->view('template/footer');

    } else {
      $this->_data_unavailable();
    }
  }

  public function view($slug,$is_industry_average=false) {
    $supplier = $this->suppliers->find_by_slug($slug);
    if($supplier) {

      $period_data = $this->period_data->all_for_supplier($supplier->id);

      if($period_data) {

        $pagedata = array(
          'page_section' => 'suppliers',
          'page_title' => "$supplier->supplier_name performance data",
          'page_scripts' => array(
            site_url(array('charts','supplier',$supplier->supplier_slug.'.js'))
          )
        );

        $data = array(
          'supplier' => $supplier,
          'period_data' => $period_data,
          'ranking' => $period_data[0]->ranking,
          'is_industry_average' => $is_industry_average
        );

        $this->load->view('template/header',$pagedata);
        $this->load->view('view_supplier',$data);
        $this->load->view('template/footer');

      } else {
        $this->_data_unavailable();
      }

    } else {
      show_404(current_url());
    }
  }
}

/* Location: ./application/controllers/suppliers.php */