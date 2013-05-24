<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('format_quarter_name')) {
  function format_quarter_name($quarter,$format='long') {

    if($quarter < 1 || $quarter > 4) {
      return "Unknown";
    } else {

      $short_names = array(
        1 => 'Jan - Mar',
        2 => 'Apr - Jun',
        3 => 'Jul - Sep',
        4 => 'Oct - Dec'
      );

      $long_names = array(
        1 => 'January - March',
        2 => 'April - June',
        3 => 'July - September',
        4 => 'October - December'
      );

      if($format=='long') {
        return "Quarter $quarter ($long_names[$quarter])";
      } elseif($format=='short') {
        return "Quarter $quarter ($short_names[$quarter])";
      } else {
        return "Unknown";
      }
    }

  }
}

function add_ordinal_suffix($number) {
  if(is_numeric($number)) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if (($number %100) >= 11 && ($number%100) <= 13) {
     return $number. 'th';
    } else {
     return $number. $ends[$number % 10];
    }
  } else {
    return $number;
  }
}


/* Location: ./application/helpers/performance_helper.php */