<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Generate a new salt
 *
 * @access   public
 */
if ( ! function_exists('generate_salt')) {
  function generate_salt($max_length=10, $any_text="") {
    $base_salt = random_string('unique');
    if($any_text != "") { $base_salt = $any_text; }

    $salt = hash('md5',$base_salt.date('YmdHis'));

    if($max_length > 0) {
      $salt = substr($salt,0,$max_length);
    }

    return $salt;
  }
}

if ( ! function_exists('generate_password')) {
  function generate_password($max_legnth) {
    return random_string('alnum',10);
  }
}

if ( ! function_exists('encrypt_password')) {
  function encrypt_password($password,$salt) {
    return sha1($password.$salt);
  }
}


/* Location: ./application/helpers/password_helper.php */