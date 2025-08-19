<?php

class Booking_Notifier_Bookings {

  public function get_future_bookings()  {
    global $wpdb;
    $results = $wpdb->get_results("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM local.wp_bookingdates bd  inner join wp_booking b on bd.booking_id = b.booking_id where bd.booking_date > CURRENT_DATE order by bd.booking_date, b.booking_type;", ARRAY_A);
    return $results;
  }

  public function get_current_bookings() {
    global $wpdb;
    $results = $wpdb->get_results("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM local.wp_bookingdates bd  inner join wp_booking b on bd.booking_id = b.booking_id where bd.booking_date = CURRENT_DATE order by bd.booking_date, b.booking_type;", ARRAY_A);
    return $results;
  }

  public function get_booking_dates( $booking_id ) {
    global $wpdb;
    $results = $wpdb->get_results("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM local.wp_bookingdates bd  inner join wp_booking b on bd.booking_id = b.booking_id where bd.booking_date >= CURRENT_DATE AND bd.booking_id = "  . $booking_id  . "  order by bd.booking_date", ARRAY_A);
    return $results;
  }

  public function get_most_recent_booking( $resource_id ) {
    global $wpdb;
    $result = $wpdb->get_row("SELECT bd.booking_date, bd.booking_id, b.booking_type, b.form FROM local.wp_bookingdates bd  inner join wp_booking b on bd.booking_id = b.booking_id where bd.booking_date < CURRENT_DATE and b.booking_type = "  . $resource_id  . " order by bd.booking_date DESC LIMIT 1", ARRAY_A);
    return $result;
  }

  public function get_booking_resource_name( $resource_id ) {
    global $wpdb;
    $result = $wpdb->get_var("SELECT title FROM wp_bookingtypes where booking_type_id = " . $resource_id );
    return $result;
  }


}