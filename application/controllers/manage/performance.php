<?php

class Performance extends ESP_Controller {

  function __construct() {
    parent::__construct();
    $this->_allowed_access(); 
    $this->load->library('form_validation');
    $this->load->model('Performance_periods_model','periods');
    $this->load->model('Performance_data_model','period_data');
  }
  
  function index() {
    $pagedata = array(
      'page_title'=>'Supplier performance',
      'page_section'=>'performance'
    );

    $data = array(
      'periods' => $this->periods->all()
    );


    $this->load->view('manage/header',$pagedata);
    $this->load->view('manage/performance/overview',$data);
    $this->load->view('manage/footer');
  }

  function create_period() {

    $this->form_validation->set_error_delimiters('<li>', '</li>');
    $this->form_validation->set_rules('periodyear','year','trim|required|integer|greater_than[2009]|xss_clean');
    $this->form_validation->set_rules('periodquarter','quarter','trim|required|integer|greater_than[0]|less_than[5]|xss_clean');

    // validate form
    if ($this->form_validation->run() === TRUE) {
      //valid post
      $year = $this->input->post('periodyear');
      $quarter = $this->input->post('periodquarter');

      if( $this->periods->find_by_date($year,$quarter) ) {
        $this->session->set_flashdata('warning','This period already exists.');
        redirect('manage/performance','location');
      } else {
        if ($this->periods->create($year,$quarter)) {
          $this->session->set_flashdata('success',"The period $year/Q$quarter has been created.");
          redirect('manage/performance','location');
        } else {
          $this->session->set_flashdata('error','Something went wrong when creating period.');
          redirect('manage/performance','location');
        }
      }

    } else {
      $this->index();
    }
  }

  function view($id) {
    $period = $this->periods->find_by_id($id);
    if($period) {
      $pagedata = array(
        'page_title'=>"Supplier performance (Period $period->period_year Q$period->period_quarter)",
        'page_section'=>'performance'
      );

      $data = array(
        'period' => $period,
        'performance_data' => $this->period_data->all_for_period($period->id)
      );

      $this->load->view('manage/header',$pagedata);
      $this->load->view('manage/performance/view_period',$data);
      $this->load->view('manage/footer');
    } else {
      show_404(current_url());
    }
  }

  function publish($id) {
    $period = $this->periods->find_by_id($id);
    if($period) {
      if($period->published=='no') {
        if($this->periods->publish($id)) {
          $this->session->set_flashdata('success',"Period $period->period_year/Q$period->period_quarter data has been published.");
          redirect('manage/performance','location');
        } else {
          $this->session->set_flashdata('error',"Something went wrong when publishing $period->period_year/Q$period->period_quarter data.");
          redirect('manage/performance','location');
        }
      } else {
        $this->session->set_flashdata('warning',"Period $period->period_year/Q$period->period_quarter has already been published.");
        redirect('manage/performance','location');
      }
    } else {
      show_404(current_url());
    }
  }

  function delete($id) {
    $period = $this->periods->find_by_id($id);
    if($period) {
      if($period->published=='no') {
        if($this->periods->delete($id)) {
          $this->session->set_flashdata('success',"Period $period->period_year/Q$period->period_quarter has been deleted.");
          redirect('manage/performance','location');
        } else {
          $this->session->set_flashdata('error',"Something went wrong when deleting $period->period_year/Q$period->period_quarter data.");
          redirect('manage/performance','location');
        }
      } else {
        $this->session->set_flashdata('warning',"You can't delete period $period->period_year/Q$period->period_quarter as it has already been published.");
        redirect('manage/performance','location');
      }
    } else {
      show_404(current_url());
    }
  }

  function edit($id) {
    $period = $this->periods->find_by_id($id);
    if($period) {
      if($period->published=='no') {

        $performance_data = $this->period_data->all_for_period($period->id,true);

        //was this a form post?
        if ($this->input->post('action')) {
          //yes, define validation rules
          $this->form_validation->set_error_delimiters('<li>', '</li>');
          foreach($performance_data as $supplier) {
            $this->form_validation->set_rules("supplier".$supplier->supplier_id."A",$supplier->supplier_short_name.' (month 1)','trim|required|numeric|xss_clean');
            $this->form_validation->set_rules("supplier".$supplier->supplier_id."B",$supplier->supplier_short_name.' (month 2)','trim|required|numeric|xss_clean');
            $this->form_validation->set_rules("supplier".$supplier->supplier_id."C",$supplier->supplier_short_name.' (month 3)','trim|required|numeric|xss_clean');
          }

          //validate the items in the form
          if ($this->form_validation->run() === TRUE) {

            $month1_cumulative = 0;
            $month2_cumulative = 0;
            $month3_cumulative = 0;

            foreach($performance_data as $supplier) {
              $month1 = $this->input->post('supplier'.$supplier->supplier_id."A");
              $month2 = $this->input->post('supplier'.$supplier->supplier_id."B");
              $month3 = $this->input->post('supplier'.$supplier->supplier_id."C");
              $this->period_data->update_supplier($period->id,$supplier->supplier_id,$month1,$month2,$month3);
              $month1_cumulative += $month1;
              $month2_cumulative += $month2;
              $month3_cumulative += $month3;
            }

            $num_of_suppliers = count($performance_data);
            if($num_of_suppliers > 0) {
              $month1_average = $month1_cumulative/$num_of_suppliers;
              $month2_average = $month2_cumulative/$num_of_suppliers;
              $month3_average = $month3_cumulative/$num_of_suppliers;
              $this->period_data->update_average($period->id,$month1_average,$month2_average,$month3_average);
            } 

            $this->session->set_flashdata('success',"Period $period->period_year/Q$period->period_quarter data has been updated.");
            redirect('manage/performance/edit/'.$period->id,'location');
          } else {
            //validation failed
            $this->_show_edit_form($period,$performance_data);
          }

        } else {
          //no, show edit form
          $this->_show_edit_form($period,$performance_data);
        }

      } else {
        $this->session->set_flashdata('warning',"You can't edit period $period->period_year/Q$period->period_quarter as it has already been published.");
        redirect('manage/performance','location');
      }
    } else {
      show_404(current_url());
    }
  }

  function _show_edit_form($period,$performance_data) {
    $pagedata = array(
      'page_title'=>"Supplier performance (Edit Period $period->period_year Q$period->period_quarter)",
      'page_section'=>'performance'
    );

    $data = array(
      'period' => $period,
      'performance_data' => $performance_data
    );

    $this->load->view('manage/header',$pagedata);
    $this->load->view('manage/performance/edit_period',$data);
    $this->load->view('manage/footer');
  }

}
/* Location: ./application/controllers/manage/performace.php */