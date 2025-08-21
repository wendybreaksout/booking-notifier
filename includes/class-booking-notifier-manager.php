<?php

class Booking_Notifier_Manager {

  public function send_booking_digest() {

    $content = $this->get_digest_content();
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $emails = $this->get_subscriber_emails();
    $subject = "[Justice Props] Daily Digest";

    foreach ( $emails as $email ) {
      wp_mail( $email,$subject, $content, $headers);
    }

  }

  private function get_subscriber_emails() {
    $args = array( 
      'role' => 'subscriber',
      'fields' => 'all'
    );

    $user_query = new WP_User_Query( $args );
    $email_list = array();

    if ( ! empty( $user_query->get_results() ) ) {
	    foreach ( $user_query->get_results() as $user ) {
		     $email_list[] = $user->user_email;
	  }   
    } else {
	    return false;
    }

    return $email_list;

  }

  private function get_digest_content() {

    $bookings_obj = new Booking_Notifier_Bookings();
    $date_today = date("M d, Y");
    // TODO locallize
    $message_content = '<h2>Reserved Today, ' . $date_today . '</h2>';

    // get current (today's) bookings. 
    $current_bookings = $bookings_obj->get_current_bookings();
    foreach ( $current_bookings as $booking ) {
      $resource_id = $booking['booking_type'];
      $resource_name = $bookings_obj->get_booking_resource_name( $resource_id);
      $form_content = $this->extract_form_info($booking['form']);
      $message_content .= '<hr>';
      $message_content .= '<h3>' . $resource_name . '</h3>';
      $message_content .= $form_content;

      $recent_booking = $bookings_obj->get_most_recent_booking( $resource_id);
      if ( $recent_booking ) {
        $message_content .= '<h4>Last booking</h4>';
        $booking_datetime = strtotime( $recent_booking['booking_date']);
        $booking_date_str = date("M d, Y", $booking_datetime);
        $message_content .= $booking_date_str;
        $message_content .=  $this->extract_form_info($recent_booking['form']);
      }

    }

    $future_bookings = $bookings_obj->get_future_bookings();

    $message_content .= '<hr><h2>Future Reservations</h2>';

    foreach ( $future_bookings as $booking ) {
      $booking_datetime = strtotime( $booking['booking_date']);
      $booking_date_str = date("M d, Y", $booking_datetime);
      $message_content .= '<hr><h3>' . $booking_date_str . '</h3>';
      $resource_id = $booking['booking_type'];
      $resource_name = $bookings_obj->get_booking_resource_name( $resource_id);
      $form_content = $this->extract_form_info($booking['form']);
      $message_content .= '<h3>' . $resource_name . '</h3>';
      $message_content .= $form_content;
    }

    return $message_content;

  }

  public function cron_exec() {
    /*
    if ( ! wp_next_scheduled('tnotw_booking_notifier_cron' ) ) {
      wp_schedule_event( time(), 'daily', 'tnotw_booking_notifier_cron'  );
    }
    */

    $this->send_booking_digest();

    /*
    $timestamp = wp_next_scheduled( 'tnotw_booking_notifier_cron'  );
    wp_unschedule_event( $timestamp, 'tnotw_booking_notifier_cron'   );
    */
  }

  private function extract_form_info( $form_content ) {

    $fields = explode( "~", $form_content );
    $field = explode("^", $fields[0]);
    $first_name = $field[2];

    $field = explode("^", $fields[2]);
    $last_name = $field[2];

    $field = explode("^", $fields[4]);
    $email = $field[2];

    $field = explode("^", $fields[6]);
    $phone = $field[2];

    $field = explode("^", $fields[8]);
    $details = $field[2];

    // TODO localize
    $content = '<p>Name: ' . $first_name . ' ' . $last_name . '</br>Email: ' . $email .  '</br>Phone: ' . $phone .'<br>Details: ' . $details . '</p>';
    return $content ;

  }
}