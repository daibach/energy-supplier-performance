<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_period_ranking extends CI_Migration {

  public function up()
  {
    /* CREATE DATA */
    $this->_add_period_ranking_field();

  }

  public function down()
  {
    $this->_remove_period_ranking_field();
  }

  function _add_period_ranking_field() {

    $fields = array(
      'ranking' => array(
        'type'          => 'INT',
        'constraint'    => '11',
        'null'          => TRUE
      )
    );
    $this->dbforge->add_column('performance_data', $fields);
  }

  function _remove_period_ranking_field() {
    $this->dbforge->drop_column('performance_data', 'ranking');
  }

}