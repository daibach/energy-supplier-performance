<?php

/**
 * Performance data Model
 *
 * @package Energy Supplier Performance
 * @subpackage Models
 * @category Performance data Model
 * @author Dafydd Vaughan (@dafyddbach)
 * @link http://www.cedyrn.com
 */
class Performance_data_model extends CI_Model {

  /**
   * Constructor
   *
   * @access public
   */
  function __construct() {
      parent::__construct();
  }

  function all_for_period($period_id,$exclude_average=false,$order_by='name') {
    $this->db->select('performance_data.id as row_id, performance_data.month1, performance_data.month2,
      performance_data.month3, performance_data.period_average, energy_suppliers.id as supplier_id,
      energy_suppliers.supplier_name, energy_suppliers.supplier_short_name,
      energy_suppliers.supplier_slug, energy_suppliers.supplier_annotation,
      performance_data.ranking_average, performance_data.month1_ranking, performance_data.month2_ranking,
      performance_data.month3_ranking');
    $this->db->where('period',$period_id);
    if($exclude_average) {
      $this->db->where('supplier_slug !=','average');
    }
    $this->db->join('energy_suppliers','energy_suppliers.id=performance_data.supplier');
    switch($order_by) {
      case 'ranking' : $this->db->order_by('supplier_importance desc, ranking_average asc, supplier_name'); break;
      case 'month1' : $this->db->order_by('month1 asc, supplier_name'); break;
      case 'month2' : $this->db->order_by('month2 asc, supplier_name'); break;
      case 'month3' : $this->db->order_by('month3 asc, supplier_name'); break;
      default: $this->db->order_by('supplier_importance desc, supplier_name');
    }
    $query = $this->db->get('performance_data');
    if($query->num_rows() > 0) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  function all_for_supplier($supplier_id,$include_unpublished=FALSE,$order_reversed=FALSE) {
    $this->db->select('performance_data.id as row_id, performance_data.month1, performance_data.month2,
      performance_data.month3, performance_data.period_average, performance_data.ranking_average,
      performance_data.month1_ranking, performance_data.month2_ranking, performance_data.month3_ranking,
      performance_periods.id as period_id, performance_periods.period_year,
      performance_periods.period_quarter');
    $this->db->where('supplier',$supplier_id);
    if(! $include_unpublished) {
      $this->db->where('published','yes');
    }
    $this->db->join('performance_periods','performance_periods.id=performance_data.period');
    if($order_reversed) {
      $this->db->order_by('period_quarter asc');
    } else {
      $this->db->order_by('period_quarter desc');
    }

    $query = $this->db->get('performance_data');
    if($query->num_rows() > 0) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  function average_for_period($period_id) {
    $this->db->select('performance_data.*');
    $this->db->where('period',$period_id);
    $this->db->where('supplier_slug','average');
    $this->db->join('energy_suppliers','energy_suppliers.id=performance_data.supplier');
    $query = $this->db->get('performance_data',1);
    if($query->num_rows() > 0) {
      return $query->row();
    } else {
      return FALSE;
    }
  }

  function update_supplier($period,$supplier,$month1,$month2,$month3,$ranking_average=null) {
    $data = array(
      'month1' => $month1,
      'month2' => $month2,
      'month3' => $month3,
      'period_average' => (($month1+$month2+$month3)/3),
      'ranking_average' => $ranking_average
    );
    $this->db->where('period',$period);
    $this->db->where('supplier',$supplier);
    return $this->db->update('performance_data',$data);
  }

  function update_average($period,$month1,$month2,$month3) {
    $average_row = $this->_find_supplier_from_slug('average');
    if($average_row) {
      return $this->update_supplier($period,$average_row->id,$month1,$month2,$month3);
    } else {
      return FALSE;
    }
  }

  function generate_rankings_for_month($period,$month) {
    $month_data = $this->all_for_period($period,true,$month);

    $last_complaints = -1;
    $ranking_count = 0;

    foreach($month_data as $key => $supplier) {
      $comparison = 0;
      switch($month) {
        case 'month1' : $comparison = $supplier->month1; break;
        case 'month2' : $comparison = $supplier->month2; break;
        case 'month3' : $comparison = $supplier->month3; break;
        default: $comparison = 0;
      }
      if($comparison != $last_complaints) {
        $last_complaints = $comparison;
        $ranking_count++;
      }
      $data = array($month."_ranking" => $ranking_count);
      $this->db->where('period',$period);
      $this->db->where('supplier',$supplier->supplier_id);
      $this->db->update('performance_data',$data);
    }
  }

  function generate_rankings_for_period($period) {

    $this->generate_rankings_for_month($period,'month1');
    $this->generate_rankings_for_month($period,'month2');
    $this->generate_rankings_for_month($period,'month3');

    $period_data = $this->all_for_period($period,true,'name');

    foreach($period_data as $key => $supplier) {
      if(is_null($supplier->month1_ranking) || is_null($supplier->month2_ranking) || is_null($supplier->month3_ranking)) {
        //no-op
      } else {
        $data = array(
          'ranking_average' => round(($supplier->month1_ranking+$supplier->month2_ranking+$supplier->month3_ranking)/3)
        );
        $this->db->where('period',$period);
        $this->db->where('supplier',$supplier->supplier_id);
        $this->db->update('performance_data',$data);
      }
    }
    return TRUE;
  }

  function _find_supplier_from_slug($slug) {
    $this->db->where('supplier_slug',$slug);
    $query = $this->db->get('energy_suppliers',1);
    if($query->num_rows > 0) {
      return $query->row(); 
    } else {
      return FALSE;
    }
  }



}

/* Location: ./application/models/performance_data_model.php */