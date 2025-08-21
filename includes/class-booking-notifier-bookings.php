<?php

class Booking_Notifier_Bookings {


  public function get_future_bookings()  {
    global $wpdb;
    $booking_dates_table = $wpdb->prefix . 'bookingdates' ;
    $booking_table = $wpdb->prefix . 'booking' ;
    $results = $wpdb->get_results("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM $booking_dates_table bd  inner join $booking_table b on bd.booking_id = b.booking_id where bd.booking_date > CURRENT_DATE order by bd.booking_date, b.booking_type;", ARRAY_A);
    return $results;
  }

  public function get_current_bookings() {
    global $wpdb;
    $booking_dates_table = $wpdb->prefix . 'bookingdates' ;
    $booking_table = $wpdb->prefix . 'booking' ;
    $results = $wpdb->get_results("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM $booking_dates_table bd  inner join $booking_table b on bd.booking_id = b.booking_id where bd.booking_date = CURRENT_DATE order by bd.booking_date, b.booking_type;", ARRAY_A);
    return $results;
  }

  public function get_booking_dates( $booking_id ) {
    global $wpdb;
    $booking_dates_table = $wpdb->prefix . 'bookingdates' ;
    $booking_table = $wpdb->prefix . 'booking' ;
    $results = $wpdb->get_results("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM $booking_dates_table bd  inner join $booking_table b on bd.booking_id = b.booking_id where bd.booking_date >= CURRENT_DATE AND bd.booking_id = "  . $booking_id  . "  order by bd.booking_date", ARRAY_A);
    return $results;
  }

  public function get_most_recent_booking( $resource_id ) {
    global $wpdb;
    $booking_dates_table = $wpdb->prefix . 'bookingdates' ;
    $booking_table = $wpdb->prefix . 'booking' ;
    $result = $wpdb->get_row("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM $booking_dates_table bd  inner join $booking_table b on bd.booking_id = b.booking_id where bd.booking_date < CURRENT_DATE and b.booking_type = "  . $resource_id  . " order by bd.booking_date DESC LIMIT 1", ARRAY_A);
    return $result;
  }

  public function get_booking_resource_name( $resource_id ) {
    global $wpdb;
    $booking_types_table = $wpdb->prefix . 'bookingtypes' ;
    $result = $wpdb->get_var("SELECT title FROM $booking_types_table where booking_type_id = " . $resource_id );
    return $result;
  }


}