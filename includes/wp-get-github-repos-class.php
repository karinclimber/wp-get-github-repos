<?php

class WP_GET_GITHUB_REPOS extends WP_Widget {

	// Constructor to Create Widget
	function __construct() {
		parent::__construct(
			'my_github_repos',
			__('My Github Repos', 'wpggr_domain'),
			array('description' => __('A widget to display your Guthub repos in a widget', 'wpggr_domain'))
		);
	}


	// Create Widget Front End Display
	public function widget($args, $instance) {

		$title = apply_filters('widget_title', $instance['title']);
		$username = esc_attr($instance['username']);
		$count = esc_attr($instance['count']);

		echo $args['before_widget'];

		if(!empty($title)){
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo $this->showRepos($username, $count);

		echo $args['after_widget'];

	}

	// Create Widget Backend Form
	public function form( $instance ) {

		if(isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Latest Github Repos', 'wpggr_domain');
		}

		if(isset($instance['username'])) {
			$username = $instance['username'];
		} else {
			$username = __('adamjohnlea', 'wpggr_domain');
		}

		if(isset($instance['count'])) {
			$count = $instance['count'];
		} else {
			$count = 5;
		} ?>

		<p>
			<label
				for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Title', 'wpggr_domain');  ?>
			</label>
			<input type="text"
			       class="widefat"
			       id="<?php echo $this->get_field_id('title'); ?>"
			       name="<?php echo $this->get_field_name('title'); ?>"
			       value="<?php echo esc_html($title)?>">
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id('username'); ?>">
				<?php _e('Username', 'wpggr_domain');  ?>
			</label>
			<input type="text"
			       class="widefat"
			       id="<?php echo $this->get_field_id('username'); ?>"
			       name="<?php echo $this->get_field_name('username'); ?>"
			       value="<?php echo esc_html($username)?>">
		</p>

		<p>
			<label
				for="<?php echo $this->get_field_id('count'); ?>">
				<?php _e('Count', 'wpggr_domain');  ?>
			</label>
			<input type="text"
			       class="widefat"
			       id="<?php echo $this->get_field_id('count'); ?>"
			       name="<?php echo $this->get_field_name('count'); ?>"
			       value="<?php echo esc_html($count)?>">
		</p>

	<?php }

	// Create Widget Value Update Method
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['username'] = (!empty($new_instance['username'])) ? strip_tags($new_instance['username']) : '';
		$instance['count'] = (!empty($new_instance['count'])) ? strip_tags($new_instance['count']) : '';

		return $instance;
	}

	public function showRepos($username, $count) {
		$url ='https://api.github.com/users/' . $username . '/repos?sort=updated&per_page=' .$count;
		//$options = array('http' => array('user_agent' => $_SERVER['HTTP_USER_AGENT']));
		//$context = stream_context_create($options);
		$response = wp_remote_get($url);

		if( is_wp_error( $response ) ) {
			return false; // Bail early
		}

		$body = wp_remote_retrieve_body($response);
		$repos = json_decode($body);

		if(empty($repos->message)) {

			// Build Output
			$output = '<ul class="repos">';

			foreach ( $repos as $repo ) {
				$output .= '<li class="repo-li">';

				$output .= '<div class="repo-title">' . $repo->name . '</div>';
				$output .= '<div class="repo-desc">' . $repo->description . '</div>';
				$output .= '<a target="_blank" href="' . $repo->html_url . '">View On Github</a>';

				$output .= '</li>';
			}

			$output .= '</ul>';

			return $output;
		} else {
			return "I'm sorry there was a problem. Please try again later.";
		}

	}
}