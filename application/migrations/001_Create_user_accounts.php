<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_user_accounts extends CI_Migration {

  public function up()
  {
    /* CREATE DATA */
    $this->_create_user_accounts_table();
    $this->_create_initial_user();

  }

  public function down()
  {
    $this->dbforge->drop_table('accounts');
  }

  function _create_user_accounts_table() {
    
    $this->dbforge->add_field('id');
    $this->dbforge->add_field(array(
      'email' => array(
        'type'          => 'VARCHAR',
        'constraint'    => 200
      ),
      'password' => array(
        'type'          => 'VARCHAR',
        'constraint'    => 255
      ),
      'salt' => array(
        'type'          => 'VARCHAR',
        'constraint'    => 20
      ),
      'status' => array(
        'type'          => 'ENUM("active","inactive")',
        'default'       => 'active'
      ),
    ));
    $this->dbforge->add_field('created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
    $this->dbforge->create_table('accounts');
  }

  function _create_initial_user() {
    $data = array(
      'email' => 'initialuser@localhost.uk',
      'password' => 'e3df4d6326b88ea9c17d20aeae32a671743acbfb',
      'salt' => 'a3325378cc',
      'status' => 'active'
    );
    $this->db->insert('accounts',$data);
  }

}