<?php

class Simple_Social_Icons_Widget extends WP_Widget {

  /**
   * Default widget values.
   *
   * @var array
   */
  protected $defaults;

  /**
   * Default widget values.
   *
   * @var array
   */
  protected $sizes;

  /**
   * Default widget profile glyphs.
   *
   * @var array
   */
  protected $glyphs;

  /**
   * Default widget profile values.
   *
   * @var array
   */
  protected $profiles;

  /**
   * Constructor method.
   *
   * Set some global values and create widget.
   */
  function __construct() {

    /**
     * Default widget option values.
     */
    $this->defaults = apply_filters( 'simple_social_default_styles', array(
      'title'                  => '',
      'new_window'             => 0,
      'size'                   => 36,
      'border_radius'          => 3,
      'icon_color'             => '#ffffff',
      'icon_color_hover'       => '#ffffff',
      'background_color'       => '#999999',
      'background_color_hover' => '#666666',
      'alignment'              => 'alignleft',
      'email'                  => '',
      'facebook'               => '',
      'flickr'                 => '',
      'gplus'                  => '',
      'instagram'              => '',
      'linkedin'               => '',
      'pinterest'              => '',
      'rss'                    => '',
      'stumbleupon'            => '',
      'tumblr'                 => '',
      'twitter'                => '',
      'vimeo'                  => '',
      'youtube'                => '',
    ) );

    /**
     * Social profile glyphs.
     */
    $this->glyphs = apply_filters( 'simple_social_default_glyphs', array(
      'email'     => '&#xe80b;',
      'facebook'    => '&#xe802;',
      'flickr'    => '&#xe80a;',
      'gplus'     => '&#xe801;',
      'instagram'   => '&#xe809;',
      'linkedin'    => '&#xe806;',
      'pinterest'   => '&#xe803;',
      'rss'     => '&#xe805;',
      'stumbleupon' => '&#xe808;',
      'tumblr'    => '&#xe807;',
      'twitter'   => '&#xe80d;',
      'vimeo'     => '&#xe80e;',
      'youtube'   => '&#xe804;',
    ) );

    /**
     * Social profile choices.
     */
    $this->profiles = apply_filters( 'simple_social_default_profiles', array(
      'email' => array(
        'label'   => __( 'Email URI', 'ssiw' ),
        'pattern' => '<li class="social-email"><a href="%s" %s>' . $this->glyphs['email'] . '</a></li>',
      ),
      'facebook' => array(
        'label'   => __( 'Facebook URI', 'ssiw' ),
        'pattern' => '<li class="social-facebook"><a href="%s" %s>' . $this->glyphs['facebook'] . '</a></li>',
      ),
      'flickr' => array(
        'label'   => __( 'Flickr URI', 'ssiw' ),
        'pattern' => '<li class="social-flickr"><a href="%s" %s>' . $this->glyphs['flickr'] . '</a></li>',
      ),
      'gplus' => array(
        'label'   => __( 'Google+ URI', 'ssiw' ),
        'pattern' => '<li class="social-gplus"><a href="%s" %s>' . $this->glyphs['gplus'] . '</a></li>',
      ),
      'instagram' => array(
        'label'   => __( 'Instagram URI', 'ssiw' ),
        'pattern' => '<li class="social-instagram"><a href="%s" %s>' . $this->glyphs['instagram'] . '</a></li>',
      ),
      'linkedin' => array(
        'label'   => __( 'Linkedin URI', 'ssiw' ),
        'pattern' => '<li class="social-linkedin"><a href="%s" %s>' . $this->glyphs['linkedin'] . '</a></li>',
      ),
      'pinterest' => array(
        'label'   => __( 'Pinterest URI', 'ssiw' ),
        'pattern' => '<li class="social-pinterest"><a href="%s" %s>' . $this->glyphs['pinterest'] . '</a></li>',
      ),
      'rss' => array(
        'label'   => __( 'RSS URI', 'ssiw' ),
        'pattern' => '<li class="social-rss"><a href="%s" %s>' . $this->glyphs['rss'] . '</a></li>',
      ),
      'stumbleupon' => array(
        'label'   => __( 'StumbleUpon URI', 'ssiw' ),
        'pattern' => '<li class="social-stumbleupon"><a href="%s" %s>' . $this->glyphs['stumbleupon'] . '</a></li>',
      ),
      'tumblr' => array(
        'label'   => __( 'Tumblr URI', 'ssiw' ),
        'pattern' => '<li class="social-tumblr"><a href="%s" %s>' . $this->glyphs['tumblr'] . '</a></li>',
      ),
      'twitter' => array(
        'label'   => __( 'Twitter URI', 'ssiw' ),
        'pattern' => '<li class="social-twitter"><a href="%s" %s>' . $this->glyphs['twitter'] . '</a></li>',
      ),
      'vimeo' => array(
        'label'   => __( 'Vimeo URI', 'ssiw' ),
        'pattern' => '<li class="social-vimeo"><a href="%s" %s>' . $this->glyphs['vimeo'] . '</a></li>',
      ),
      'youtube' => array(
        'label'   => __( 'YouTube URI', 'ssiw' ),
        'pattern' => '<li class="social-youtube"><a href="%s" %s>' . $this->glyphs['youtube'] . '</a></li>',
      ),
    ) );

    $widget_ops = array(
      'classname'   => 'simple-social-icons',
      'description' => __( 'Displays select social icons.', 'ssiw' ),
    );

    $control_ops = array(
      'id_base' => 'simple-social-icons',
    );

    $this->WP_Widget( 'simple-social-icons', __( 'Genesis - Social Icons', 'ssiw' ), $widget_ops, $control_ops );

    /** Enqueue icon font */
    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );

    /** Load CSS in <head> */
    add_action( 'wp_head', array( $this, 'css' ) );

  }

  /**
   * Widget Form.
   *
   * Outputs the widget form that allows users to control the output of the widget.
   *
   */
  function form( $instance ) {

    /** Merge with defaults */
    $instance = wp_parse_args( (array) $instance, $this->defaults );
    ?>

    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

    <p><label><input id="<?php echo $this->get_field_id( 'new_window' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="1" <?php checked( 1, $instance['new_window'] ); ?>/> <?php esc_html_e( 'Open links in new window?', 'ssiw' ); ?></label></p>

    <hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

    <?php
    foreach ( (array) $this->profiles as $profile => $data ) {

      printf( '<p><label for="%s">%s:</label></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
      printf( '<p><input type="text" id="%s" name="%s" value="%s" class="widefat" />', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );
      printf( '</p>' );

    }

  }

  /**
   * Form validation and sanitization.
   *
   * Runs when you save the widget form. Allows you to validate or sanitize widget options before they are saved.
   *
   */
  function update( $newinstance, $oldinstance ) {

    foreach ( $newinstance as $key => $value ) {

      /** Border radius and Icon size must not be empty, must be a digit */
      if ( ( 'border_radius' == $key || 'size' == $key ) && ( '' == $value || ! ctype_digit( $value ) ) ) {
        $newinstance[$key] = 0;
      }

      /** Validate hex code colors */
      elseif ( strpos( $key, '_color' ) && 0 == preg_match( '/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/', $value ) ) {
        $newinstance[$key] = $oldinstance[$key];
      }

      /** Sanitize Profile URIs */
      elseif ( array_key_exists( $key, (array) $this->profiles ) ) {
        $newinstance[$key] = esc_url( $newinstance[$key] );
      }

    }

    return $newinstance;

  }

  /**
   * Widget Output.
   *
   * Outputs the actual widget on the front-end based on the widget options the user selected.
   *
   */
  function widget( $args, $instance ) {

    extract( $args );

    /** Merge with defaults */
    $instance = wp_parse_args( (array) $instance, $this->defaults );

    echo $before_widget;

      if ( ! empty( $instance['title'] ) )
        echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

      $output = '';

      $new_window = $instance['new_window'] ? 'target="_blank"' : '';

      $profiles = (array) $this->profiles;

      foreach ( $profiles as $profile => $data ) {

        if ( empty( $instance[ $profile ] ) )
          continue;

        if ( is_email( $instance[ $profile ] ) )
          $output .= sprintf( $data['pattern'], 'mailto:' . esc_attr( $instance[$profile] ), $new_window );
        else
          $output .= sprintf( $data['pattern'], esc_url( $instance[$profile] ), $new_window );

      }

      if ( $output )
        printf( '<ul class="%s">%s</ul>', $instance['alignment'], $output );

    echo $after_widget;

  }

  function enqueue_css() {

    $cssfile  = apply_filters( 'simple_social_default_css', plugin_dir_url( __FILE__ ) . 'css/style.css' );

    wp_enqueue_style( 'simple-social-icons-font', esc_url( $cssfile ), array(), '1.0.5', 'all' );
  }

  /**
   * Custom CSS.
   *
   * Outputs custom CSS to control the look of the icons.
   */
  function css() {

    /** Pull widget settings, merge with defaults */
    $all_instances = $this->get_settings();
    $instance = wp_parse_args( $all_instances[$this->number], $this->defaults );

    $font_size = round( (int) $instance['size'] / 2 );
    $icon_padding = round ( (int) $font_size / 2 );

  }

}

add_action( 'widgets_init', 'ssiw_load_widget' );
/**
 * Widget Registration.
 *
 * Register Simple Social Icons widget.
 *
 */
function ssiw_load_widget() {

  register_widget( 'Simple_Social_Icons_Widget' );

}
