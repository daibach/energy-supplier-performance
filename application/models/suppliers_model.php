<?php

/**
 * Suppliers Model
 *
 * @package Energy Supplier Performance
 * @subpackage Models
 * @category Suppliers Model
 * @author Dafydd Vaughan (@dafyddbach)
 * @link http://www.cedyrn.com
 */
class Suppliers_model extends CI_Model {

  /**
   * Constructor
   *
   * @access public
   */
  function __construct() {
      parent::__construct();
  }

  function all() {
    $this->db->order_by('supplier_importance desc, supplier_name');
    $query = $this->db->get('energy_suppliers');
    if($query->num_rows() > 0) {
      return $query->result();
    } else {
      return FALSE;
    }
  }

  function find($id) {
    $this->find_by_id($id);
  }

  function find_by_id($id) {
    $this->db->where('id',$id);
    return $this->_get_single_row();
  }

  function find_by_slug($slug) {
    $this->db->where('supplier_slug',$slug);
    return $this->_get_single_row();
  }

  function _get_single_row() {
    $query = $this->db->get('energy_suppliers',1);
    if($query->num_rows() > 0) {
      return $query->row();
    } else {
      return FALSE;
    }

  }



}

/* Location: ./application/models/suppliers_model.php */