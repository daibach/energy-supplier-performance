<?php

/**
 * Performance periods Model
 *
 * @package Energy Supplier Performance
 * @subpackage Models
 * @category Performance periods Model
 * @author Dafydd Vaughan (@dafyddbach)
 * @link http://www.cedyrn.com
 */
class Performance_periods_model extends CI_Model {

  /**
   * Constructor
   *
   * @access public
   */
  function __construct() {
      parent::__construct();
  }

  function all() {
    $this->db->order_by('period_year,period_quarter');
    $query = $this->db->get('performance_periods');
    if($query->num_rows() > 0) {
      return $query->result();
    } else {
      return false;
    }
  }

  function create($year,$quarter) {
    $data = array(
      'period_year' => $year,
      'period_quarter' => $quarter,
      'published' => 'no'
    );
    $this->db->insert('performance_periods',$data);

    $period_id = $this->db->insert_id();

    $supplier_query = $this->db->get('energy_suppliers');
    $suppliers = $supplier_query->result();
    $performance_data = array();
    foreach($suppliers as $supplier) {
      $data = array(
        'supplier'  => $supplier->id,
        'period'    => $period_id,
        'month1'    => 0,
        'month2'    => 0,
        'month3'    => 0
      );
      array_push($performance_data,$data);
    }
    if(!empty($performance_data)) {
      $this->db->insert_batch('performance_data',$performance_data);
    }
    return TRUE;
  }

  function publish($id) {
    $data = array(
      'published' => 'yes',
      'published_date' => date('Y-m-d H:i:s')
    );
    $this->db->where('id',$id);
    return $this->db->update('performance_periods',$data);
  }

  function delete($id) {
    $this->db->where('period',$id);
    $this->db->delete('performance_data');

    $this->db->where('id',$id);
    return $this->db->delete('performance_periods');
  }

  function latest($include_unpublished=FALSE) {
    if (! $include_unpublished) {
      $this->db->where('published','yes');
    }
    $this->db->order_by('period_year desc, period_quarter desc');
    return $this->_get_single_row();
  }

  function find_by_id($id) {
    $this->db->where('id',$id);
    return $this->_get_single_row();
  }

  function find_by_date($year,$quarter) {
    $this->db->where('period_year',$year);
    $this->db->where('period_quarter',$quarter);
    return $this->_get_single_row();
  }

  function _get_single_row() {
    $query = $this->db->get('performance_periods',1);
    if($query->num_rows() > 0) {
      return $query->row();
    } else {
      return FALSE;
    }

  }



}

/* Location: ./application/models/performance_periods_model.php */