<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_monthly_rankings extends CI_Migration {

  public function up()
  {
    /* CREATE DATA */
    $this->_add_period_ranking_fields();
    $this->_rename_ranking_field();

  }

  public function down()
  {
    $this->_remove_period_ranking_fields();
    $this->_restore_ranking_field();
  }

  function _add_period_ranking_fields() {

    $fields = array(
      'month1_ranking' => array(
        'type'          => 'INT',
        'constraint'    => '11',
        'null'          => TRUE
      ),
      'month2_ranking' => array(
        'type'          => 'INT',
        'constraint'    => '11',
        'null'          => TRUE
      ),
      'month3_ranking' => array(
        'type'          => 'INT',
        'constraint'    => '11',
        'null'          => TRUE
      ),
    );
    $this->dbforge->add_column('performance_data', $fields);
  }

  function _rename_ranking_field() {

    $fields = array(
      'ranking' => array(
        'name'    => 'ranking_average',
        'type'    => 'INT',
        'null'    => TRUE
      ),
    );
    $this->dbforge->modify_column('performance_data', $fields);
  }

  function _remove_period_ranking_fields() {
    $this->dbforge->drop_column('performance_data', 'month1_ranking');
    $this->dbforge->drop_column('performance_data', 'month2_ranking');
    $this->dbforge->drop_column('performance_data', 'month3_ranking');
  }

  function _restore_ranking_field() {

    $fields = array(
      'ranking_average' => array(
        'name' => 'ranking',
        'type'    => 'INT',
        'null'    => TRUE
      ),
    );
    $this->dbforge->modify_column('performance_data', $fields);
  }

}