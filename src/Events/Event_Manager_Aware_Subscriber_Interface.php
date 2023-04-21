<?php
namespace WP_Rocket_e2e\Events;

interface Event_Manager_Aware_Subscriber_Interface extends Subscriber_Interface {
	/**
	 * Set the WordPress event manager for the subscriber.
	 *
	 * @since 3.1
	 * @author Remy Perona
	 *
	 * @param Event_Manager $event_manager Event_Manager instance.
	 */
	public function set_event_manager( Event_Manager $event_manager );
}
