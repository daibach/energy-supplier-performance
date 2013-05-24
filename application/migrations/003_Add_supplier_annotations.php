<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_supplier_annotations extends CI_Migration {

  public function up()
  {
    /* CREATE DATA */
    $this->_add_supplier_annotation_field();
    $this->_add_annotations_to_suppliers();

  }

  public function down()
  {
    $this->_remove_supplier_annotation_field();
  }

  function _add_supplier_annotation_field() {

    $fields = array(
      'supplier_annotation' => array(
        'type'          => 'VARCHAR',
        'constraint'    => 255
      )
    );
    $this->dbforge->add_column('energy_suppliers', $fields);
  }

  function _remove_supplier_annotation_field() {
    $this->dbforge->drop_column('energy_suppliers', 'supplier_annotation');
  }

  function _add_annotations_to_suppliers() {

    $data = array('supplier_annotation'=>'Includes Atlantic, Scottish Hydro Electric, Southern Electric, SWALEC');
    $this->db->where('supplier_slug','scottish-and-southern');
    $this->db->update('energy_suppliers',$data);

    $data = array('supplier_annotation'=>'Includes Scottish Gas');
    $this->db->where('supplier_slug','british-gas');
    $this->db->update('energy_suppliers',$data);

  }

}