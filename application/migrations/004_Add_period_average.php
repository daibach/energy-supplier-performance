<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_period_average extends CI_Migration {

  public function up()
  {
    /* CREATE DATA */
    $this->_add_period_average_field();

  }

  public function down()
  {
    $this->_remove_period_average_field();
  }

  function _add_period_average_field() {

    $fields = array(
      'period_average' => array(
        'type'          => 'DECIMAL',
        'constraint'    => '10,2',
        'default'       => '0'
      )
    );
    $this->dbforge->add_column('performance_data', $fields);
  }

  function _remove_period_average_field() {
    $this->dbforge->drop_column('performance_data', 'period_average');
  }

}