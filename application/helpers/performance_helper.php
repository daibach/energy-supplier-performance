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

if ( ! function_exists('identify_quarter_month')) {
  function identify_quarter_month($quarter,$month,$format='long') {

    switch($quarter) {
      case 1 : $month_number = 0+$month; break;
      case 2 : $month_number = 3+$month; break;
      case 3 : $month_number = 6+$month; break;
      case 4 : $month_number = 9+$month; break;
      default: return "Unknown";
    }

    $month_date = mktime(0, 0, 0, $month_number, 10);

    if($format=='long') {
      return date("F", $month_date);
    } else {
      return date("M", $month_date);
    }

  }
}

if ( ! function_exists('add_ordinal_suffix')) {
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
}

if ( ! function_exists('ranking_css_class')) {
  function ranking_css_class($ranking) {

    switch ($ranking) {
      case 1: return "success"; break;
      case 2: return "info"; break;
      case 3: return "info"; break;
      case 4: return "warning"; break;
      case 5: return "warning"; break;
      case 6: return "important"; break;
      default: return "other";
    }

  }
}

/* Location: ./application/helpers/performance_helper.php */