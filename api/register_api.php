<?php
require_once EL_PATH."/includes/db.php";

function event_api_init() {
  global $myplugin_api_mytype;

  $myplugin_api_mytype = new Event_API();
  add_filter( 'json_endpoints', array( $myplugin_api_mytype, 'register_routes' ) );
}

add_action( 'wp_json_server_before_serve', 'event_api_init' );

class Event_API {

  public function register_routes( $routes ) {
    $routes['/events/(?P<month>\d+)/(?P<year>\d+)'] = array(
      array( array( $this, 'get_events'), WP_JSON_Server::READABLE ),
    );
    return $routes;
  }

  public function get_events($month, $year)
  {
    $month += 1;

    $db = El_Db::get_instance();
    return Array('events'=>$db->get_events_by_month_year($month, $year));
  }
}