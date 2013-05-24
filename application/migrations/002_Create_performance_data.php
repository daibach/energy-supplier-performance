<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_performance_data extends CI_Migration {

  public function up()
  {
    /* CREATE DATA */
    $this->_create_energy_suppliers_table();
    $this->_create_performance_periods_table();
    $this->_create_performance_data_table();
    $this->_load_initial_suppliers();

  }

  public function down()
  {
    $this->dbforge->drop_table('energy_suppliers');
    $this->dbforge->drop_table('performance_periods');
    $this->dbforge->drop_table('performance_data');
  }

  function _create_energy_suppliers_table() {
    
    $this->dbforge->add_field('id');
    $this->dbforge->add_field(array(
      'supplier_name' => array(
        'type'          => 'VARCHAR',
        'constraint'    => 255
      ),
      'supplier_short_name' => array(
        'type'          => 'VARCHAR',
        'constraint'    => 100
      ),
      'supplier_slug' => array(
        'type'          => 'VARCHAR',
        'constraint'    => 255
      ),
      'supplier_importance' => array(
        'type'          => 'INT',
        'constraint'    => 11,
        'default'       => 1
      )
    ));
    $this->dbforge->add_field('created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
    $this->dbforge->create_table('energy_suppliers');
  }

  function _create_performance_periods_table() {
    
    $this->dbforge->add_field('id');
    $this->dbforge->add_field(array(
      'period_year' => array(
        'type'          => 'INT',
        'constraint'    => 11
      ),
      'period_quarter' => array(
        'type'          => 'INT',
        'constraint'    => 11
      ),
      'published' => array(
        'type'          => 'ENUM("yes","no")',
        'default'       => 'no'
      ),
      'published_date' => array(
        'type'          => 'TIMESTAMP',
        'default'       => '0000-00-00 00:00:00'
      )
    ));
    $this->dbforge->add_field('created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
    $this->dbforge->create_table('performance_periods');
  }

  function _create_performance_data_table() {
    
    $this->dbforge->add_field('id');
    $this->dbforge->add_field(array(
      'supplier' => array(
        'type'          => 'INT',
        'constraint'    => 11
      ),
      'period' => array(
        'type'          => 'INT',
        'constraint'    => 11
      ),
      'month1' => array(
        'type'          => 'DECIMAL',
        'constraint'    => '10,2'
      ),
      'month2' => array(
        'type'          => 'DECIMAL',
        'constraint'    => '10,2'
      ),
      'month3' => array(
        'type'          => 'DECIMAL',
        'constraint'    => '10,2'
      )
    ));
    $this->dbforge->add_field('created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
    $this->dbforge->create_table('performance_data');
  }

  function _load_initial_suppliers() {

    $data = array(
      array(
        'supplier_name' => 'British Gas',
        'supplier_short_name' => 'British Gas',
        'supplier_slug' => 'british-gas',
        'supplier_importance' => 1
      ),
      array(
        'supplier_name' => 'E.ON',
        'supplier_short_name' => 'E.ON',
        'supplier_slug' => 'eon',
        'supplier_importance' => 1
      ),
      array(
        'supplier_name' => 'EDF Energy',
        'supplier_short_name' => 'EDF',
        'supplier_slug' => 'edf-energy',
        'supplier_importance' => 1
      ),
      array(
        'supplier_name' => 'npower',
        'supplier_short_name' => 'npower',
        'supplier_slug' => 'npower',
        'supplier_importance' => 1
      ),
      array(
        'supplier_name' => 'Scottish and Southern Energy',
        'supplier_short_name' => 'SSE',
        'supplier_slug' => 'scottish-and-southern',
        'supplier_importance' => 1
      ),
      array(
        'supplier_name' => 'ScottishPower',
        'supplier_short_name' => 'ScottishPower',
        'supplier_slug' => 'scottish-power',
        'supplier_importance' => 1
      ),
      array(
        'supplier_name' => 'Industry Average (Big 6)',
        'supplier_short_name' => 'Big 6 average',
        'supplier_slug' => 'big-six-average',
        'supplier_importance' => 0
      )
    );

    $this->db->insert_batch('energy_suppliers',$data);

  }

}