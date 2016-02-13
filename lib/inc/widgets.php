<?php
/**
 * Connected Class
 */
class NewtonWidget extends WP_Widget {
    /** constructor */
    function NewtonWidget() {
		$widget_ops = array('classname' => 'msd-connected', 'description' => __('Show social icons'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('newton', __('Newton Job Board'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
        extract($instance);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		echo $before_widget;
		if ( !empty( $title ) ) { print $before_title.$title.$after_title; } 
        if ( !empty( $text )){ print '<div class="intro-text">'.$text.'</div>'; }
        print(do_shortcode('[newton-job-board]'));
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		
        $instance['form_id'] = $new_instance['form_id'];
        
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = esc_textarea($instance['text']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>	
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
        
<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("NewtonWidget");'));/**