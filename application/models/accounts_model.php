<?php

/**
 * Accounts Model
 *
 * @package Energy Supplier Performance
 * @subpackage Models
 * @category Accounts Model
 * @author Dafydd Vaughan (@dafyddbach)
 * @link http://www.cedyrn.com
 */
class Accounts_model extends CI_Model {

  /**
   * Constructor
   *
   * @access public
   */
  function __construct() {
      parent::__construct();
  }


  /**
   * Verifies the user is valid
   * 
   * @access public
   * @param string $u the username of the user
   * @param string $p the password of the user
   * @return boolean true if valid user
   */
  function verify_user($u,$p) {
    //find the user with this username
    $this->db->select('id,email,password,salt,status');
    $this->db->where('email',xss_clean($u));
      
    $query = $this->db->get('accounts',1);

    //if there is a user
    if ($query->num_rows() > 0) {
      $user = $query->row();
    
      //check if the user is active
      if ($user->status == 'active') {
        $encryppass = encrypt_password($p,$user->salt);

        //check the password is correct
        if ($user->password ==  $encryppass) {
          //password is correct,set session information
          $this->session->set_userdata('admin_userid', $user->id);
          $this->session->set_userdata('admin_username', $user->email);
          
          return TRUE;
        } else {
          //password is false
          $this->session->set_flashdata('error','Sorry, your username or password is incorrect! Please try again.');
          return FALSE;
        }
      } else {
        //user is inactive
        $this->session->set_flashdata('error','Sorry, your user account has not been activated. Please check your email.');
        return FALSE;
      }

    } else {
      //user cannot be found
      $this->session->set_flashdata('error','Sorry, your username or password is incorrect! Please try again.');
      return FALSE;
    }

  }

  function validate_access($id) {
    $this->db->select('status');
    $this->db->where('id',$id);

    $query = $this->db->get('accounts',1);

    if ($query->num_rows() > 0) {
      $user = $query->row();
      if($user->status == 'active') {
        return TRUE;
      } else {
        return FALSE;
      }
    } else {
      return FALSE;
    }

  }

  function is_password_correct($id,$pass) {
    //find the user with this id
    $this->db->select('id,email,password,salt,status');
    $this->db->where('id',$id);
      
    $query = $this->db->get('accounts',1);

    //if there is a user
    if ($query->num_rows() > 0) {
      $user = $query->row();
    
      //check the password is correct
      $encryppass = encrypt_password($pass,$user->salt);

      if ($user->password ==  $encryppass) {
        return TRUE;
      } else {
        return FALSE;
      }

    } else {
      return FALSE;
    }
  }

  function find($id) {
    return $this->find_by_id($id);
  }

  function find_by_email($email) {
    return $this->_find_by_attribute('email',$email);
  }

  function find_by_id($id) {
    return $this->_find_by_attribute('id',$id);
  }

  function _find_by_attribute($attribute,$value) {
    $this->db->where($attribute,$value);
    $query = $this->db->get('accounts',1);
    if($query->num_rows() > 0){
      return $query->row();
    } else {
      return false;
    }
  }

  function all() {
    $this->db->select('id,email,status');
    $this->db->order_by('email');
    $query = $this->db->get('accounts');
    if($query->num_rows() > 0) {
      return $query->result();
    } else {
      return false;
    }

  }

  function create($email,$password='') {
    if($password=='') { $password = generate_password(10); }
    $salt = generate_salt(10,$email);

    $data = array(
      'email' => $email,
      'password' => encrypt_password($password,$salt),
      'salt' => $salt,
      'status' => 'active'
    );
    $this->db->insert('accounts',$data);
    return $this->db->insert_id();
  }

  function update_password($id,$salt,$pass) {
    $data = array(
      'salt'=>$salt,
      'password'=>$pass
    );
    $this->db->where('id',$id);
    return $this->db->update('accounts',$data);
  }

  function delete($id) {
    $this->db->where('id',$id);
    return $this->db->delete('accounts');
  }

  function deactivate($id) {
    return $this->_update_status($id,'inactive');
  }

  function activate($id) {
    return $this->_update_status($id,'active');
  }

  function _update_status($id,$status) {
    $data = array(
      'status' => $status
    );
    $this->db->where('id',$id);
    return $this->db->update('accounts',$data);
  }

}

/* Location: ./application/models/accounts_model.php */