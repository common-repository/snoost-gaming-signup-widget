<?php 

/**
	 * Plugin Name: Snoost: Gaming Signup Widget
	 * Description: Display a simple signup widget, and start getting free gaming time for your cloud gaming account for each referral. Use a custom title and description to appeal to your audience.
	 * Version: 0.1.3
	 * Author: Snoost
	 * Author URI: https://www.snoost.com/
	 * License: GPL2
 */

$widgetName = 'snoost_signup_widget';

function snoost_signup_widget_load() { register_widget('snoost_signup_widget'); }
add_action('widgets_init', 'snoost_signup_widget_load');

class snoost_signup_widget extends WP_Widget {

  function __construct() {
    parent::__construct(
      'snoost_signup_widget', __('Snoost Referral', 'snoost_signup_widget_title'), 
      ['description' => __('Earn free week\'s for each referral to Snoost cloud gaming.', 'snoost_signup_widget_title')]
    );
  }
  private function loadVariables($instance) {
    if(isset($instance['title'])) { $instance['title'] = $instance['title']; }
    else { $instance['title'] = __('Play any game on any PC', 'snoost_signup_widget_title'); }

    if(isset($instance['referralcode'])) { $instance['referralcode'] = $instance['referralcode']; }
    else { $instance['referralcode'] = __('xxxxxx', 'snoost_signup_widget_referralcode'); }

    if(isset($instance['description'])) { $instance['description'] = $instance['description']; }
    else { $instance['description'] = __('Get an entire week for free with the above referral code, and enjoy high graphics games with Snoost Cloud Gaming.', 'snoost_signup_widget_description'); }

    return $instance;
  }

  public function widget($args, $instance) {
    $instance = $this->loadVariables($instance);
    apply_filters('widget_title', $instance['title']);

    echo $args['before_widget'];
    echo $args['before_title'].$instance['title'].$args['after_title'];
    echo '<p><strong><a href="https://www.snoost.com/signup/?r='.$instance['referralcode'].'" target="_blank">Referral code: '.$instance['referralcode'].'</a></strong></p>';
    echo '<p>'.$instance['description'].'</p>';
    echo '<p><a href="https://www.snoost.com/signup/?r='.$instance['referralcode'].'" target="_blank">Join for free</a></p>';

    echo $args['after_widget'];
  }

  public function form($instance) {
    $instance = $this->loadVariables($instance);

    echo '
<p>Simply enter your referral code below, and get an entire week for free every time someone signs up to Snoost Cloud Gaming with your referral code. Your referrals also get a week for free. The first referral rewards you with a whole month. Get your referral code by <a href="https://app.snoost.com/" target="_blank">signing in to your Snoost account</a>, or <a href="https://www.snoost.com/signup/" target="_blank">sign up here</a> (free) if you do not yet have an account.</p>
<p>
  <label for="'.$this->get_field_id('title').'">Title:</label>
  <input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($instance['title']).'" />
</p>
<p>
  <label for="'.$this->get_field_id('referralcode').'">Referral code:</label>
  <input class="widefat" id="'.$this->get_field_id('referralcode').'" name="'.$this->get_field_name('referralcode').'" type="text" value="'.esc_attr($instance['referralcode']).'" />
</p>
<p>
  <textarea class="widefat" rows="6" cols="20" id="'.$this->get_field_id('description').'" name="'.$this->get_field_name('description').'">'.$instance['description'].'</textarea>
</p>';
  }

  public function update($new_instance, $old_instance) {
    $instance = [];
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['referralcode'] = (!empty($new_instance['referralcode'])) ? strip_tags($new_instance['referralcode']) : '';
    $instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';

    return $instance;
  }

}

?>