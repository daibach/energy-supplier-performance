<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ESP_DataFormatter {

  var $ci;

  function __construct() {
    $this->ci =& get_instance();
    $this->ci->load->model('Performance_periods_model','periods');
    $this->ci->load->model('Performance_data_model','period_data');
    $this->ci->load->model('Suppliers_model','suppliers');
  }

  function generate_historical_data() {
    $suppliers = $this->ci->suppliers->all();
    $periods = $this->ci->periods->all();

    if( ! empty($periods)) {
      $historical_periods = array();

      foreach($periods as $period) {
        $period_data = $this->ci->period_data->all_for_period($period->id,false,'name');

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

/* Location: ./application/libraries/esp_dataformatter.php */