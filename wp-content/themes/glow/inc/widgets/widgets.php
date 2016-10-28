<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function glow_widgets_init() {

    // Register Right Sidebar
    register_sidebar( array(
        'name'          => __( 'Right Sidebar', 'glow' ),
        'id'            => 'dt-right-sidebar',
        'description'   => __( 'Add widgets to Show widgets at right panel of page', 'glow' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '<span></span></h2>',
    ) );

    // Services
    register_sidebar( array(
        'name'          => __( 'Home Page', 'glow' ),
        'id'            => 'dt_home_page',
        'description'   => __( 'Add widgets to Show at Home Page', 'glow' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 1
    register_sidebar( array(
        'name'          => __( 'Footer Position 1', 'glow' ),
        'id'            => 'dt-footer1',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 1', 'glow' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title"><span></span>',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 2
    register_sidebar( array(
        'name'          => __( 'Footer Position 2', 'glow' ),
        'id'            => 'dt-footer2',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 2', 'glow' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title"><span></span>',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 3
    register_sidebar( array(
        'name'          => __( 'Footer Position 3', 'glow' ),
        'id'            => 'dt-footer3',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 3', 'glow' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title"><span></span>',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 4
    register_sidebar( array(
        'name'          => __( 'Footer Position 4', 'glow' ),
        'id'            => 'dt-footer4',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 4', 'glow' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title"><span></span>',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'glow_widgets_init' );

/**
 * Enqueue Admin Scripts
 */
function glow_media_script( $hook ) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

    wp_enqueue_style('glow-widget-style', get_template_directory_uri() . '/inc/widgets/widgets.css');

    wp_enqueue_media();
    wp_enqueue_script( 'glow-media-upload', get_template_directory_uri() . '/inc/widgets/widgets.js', array( 'jquery' ), '', true );

}
add_action( 'admin_enqueue_scripts', 'glow_media_script' );

/**
 * Social Icons widget.
 */
class glow_social_icons extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'glow_social_icons',
            __( 'Daisy: Social Icons', 'glow' ),
            array(
                'description'   => __( 'Social Icons', 'glow' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title      = isset( $instance['title'] ) ? $instance['title'] : '';
        $facebook   = isset( $instance['facebook'] ) ? $instance['facebook'] : '';
        $twitter    = isset( $instance['twitter'] ) ? $instance['twitter'] : '';
        $g_plus     = isset( $instance['g-plus' ] ) ? $instance['g-plus'] : '';
        $instagram  = isset( $instance['instagram'] ) ? $instance['instagram'] : '';
        $github     = isset( $instance['github'] ) ? $instance['github'] : '';
        $flickr     = isset( $instance['flickr'] ) ? $instance['flickr'] : '';
        $pinterest  = isset( $instance['pinterest'] ) ? $instance['pinterest'] : '';
        $wordpress  = isset( $instance['wordpress'] ) ? $instance['wordpress'] : '';
        $youtube    = isset( $instance['youtube'] ) ? $instance['youtube'] : '';
        $vimeo      = isset( $instance['vimeo'] ) ? $instance['vimeo'] : '';
        $linkedin   = isset( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $behance    = isset( $instance['behance'] ) ? $instance['behance'] : '';
        $dribbble   = isset( $instance['dribbble'] ) ? $instance['dribbble'] : '';

        ?>

        <aside class="widget dt-social-icons">
            <?php if( ! empty( $title ) ) { ?><h2 class="widget-title"><?php echo esc_attr( $title ); ?><span></span></h2><?php } ?>

            <ul>
                <?php if( ! empty( $facebook ) ) { ?>
                    <li><a href="<?php echo esc_url( $facebook ); ?>" target="_blank"><i class="fa fa-facebook transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $twitter ) ) { ?>
                    <li><a href="<?php echo esc_url( $twitter ); ?>" target="_blank"><i class="fa fa-twitter transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $g_plus ) ) { ?>
                    <li><a href="<?php echo esc_url( $g_plus ); ?>" target="_blank"><i class="fa fa-google-plus transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $instagram ) ) { ?>
                    <li><a href="<?php echo esc_url( $instagram ); ?>" target="_blank"><i class="fa fa-instagram transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $github ) ) { ?>
                    <li><a href="<?php echo esc_url( $github ); ?>" target="_blank"><i class="fa fa-github transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $flickr ) ) { ?>
                    <li><a href="<?php echo esc_url( $flickr ); ?>" target="_blank"><i class="fa fa-flickr transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $pinterest ) ) { ?>
                    <li><a href="<?php echo esc_url( $pinterest ); ?>" target="_blank"><i class="fa fa-pinterest transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $wordpress ) ) { ?>
                    <li><a href="<?php echo esc_url( $wordpress ); ?>" target="_blank"><i class="fa fa-wordpress transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $youtube ) ) { ?>
                    <li><a href="<?php echo esc_url( $youtube ); ?>" target="_blank"><i class="fa fa-youtube transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $vimeo ) ) { ?>
                    <li><a href="<?php echo esc_url( $vimeo ); ?>" target="_blank"><i class="fa fa-vimeo transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $linkedin ) ) { ?>
                    <li><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank"><i class="fa fa-linkedin transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $behance ) ) { ?>
                    <li><a href="<?php echo esc_url( $behance ); ?>" target="_blank"><i class="fa fa-behance transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $dribbble ) ) { ?>
                    <li><a href="<?php echo esc_url( $dribbble ); ?>" target="_blank"><i class="fa fa-dribbble transition35"></i></a> </li>
                <?php } ?>

                <div class="clearfix"></div>
            </ul>
        </aside>

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'             => '',
                'facebook'          => '',
                'twitter'           => '',
                'g-plus'            => '',
                'instagram'         => '',
                'github'            => '',
                'flickr'            => '',
                'pinterest'         => '',
                'wordpress'         => '',
                'youtube'           => '',
                'vimeo'             => '',
                'linkedin'          => '',
                'behance'           => '',
                'dribbble'          => ''
            )
        );

        ?>

        <div class="dt-social-icons">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Title', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo esc_attr( $instance['facebook'] ); ?>" placeholder="<?php _e( 'https://www.facebook.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo esc_attr( $instance['twitter'] ); ?>" placeholder="<?php _e( 'https://twitter.com/', 'glow' ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'g-plus' ); ?>"><?php _e( 'G plus', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'g-plus' ); ?>" name="<?php echo $this->get_field_name( 'g-plus' ); ?>" value="<?php echo esc_attr( $instance['g-plus'] ); ?>" placeholder="<?php _e( 'https://plus.google.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Instagram', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo esc_attr( $instance['instagram'] ); ?>" placeholder="<?php _e( 'https://instagram.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e( 'Github', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo esc_attr( $instance['github'] ); ?>" placeholder="<?php _e( 'https://github.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e( 'Flickr', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" value="<?php echo esc_attr( $instance['flickr'] ); ?>" placeholder="<?php _e( 'https://www.flickr.com/"', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Pinterest', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo esc_attr( $instance['pinterest'] ); ?>" placeholder="<?php _e( 'https://www.pinterest.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'wordpress' ); ?>"><?php _e( 'WordPress', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'wordpress' ); ?>" name="<?php echo $this->get_field_name( 'wordpress' ); ?>" value="<?php echo esc_attr( $instance['wordpress'] ); ?>" placeholder="<?php _e( 'https://wordpress.org/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'YouTube', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo esc_attr( $instance['youtube'] ); ?>" placeholder="<?php _e( 'https://www.youtube.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e( 'Vimeo', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo esc_attr( $instance['vimeo'] ); ?>" placeholder="<?php _e( 'https://vimeo.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'Linkedin', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo esc_attr( $instance['linkedin'] ); ?>" placeholder="<?php _e( 'https://linkedin.com', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'behance' ); ?>"><?php _e( 'Behance', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'behance' ); ?>" name="<?php echo $this->get_field_name( 'behance' ); ?>" value="<?php echo esc_attr( $instance['behance'] ); ?>" placeholder="<?php _e( 'https://www.behance.net/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e( 'Dribbble', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo esc_attr( $instance['dribbble'] ); ?>" placeholder="<?php _e( 'https://dribbble.com/', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-social-icons -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
        $instance['title']     = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['facebook']  = strip_tags( stripslashes( $new_instance['facebook'] ) );
        $instance['twitter']   = strip_tags( stripslashes( $new_instance['twitter'] ) );
        $instance['g-plus']    = strip_tags( stripslashes( $new_instance['g-plus'] ) );
        $instance['instagram'] = strip_tags( stripslashes( $new_instance['instagram'] ) );
        $instance['github']    = strip_tags( stripslashes( $new_instance['github'] ) );
        $instance['flickr']    = strip_tags( stripslashes( $new_instance['flickr'] ) );
        $instance['pinterest'] = strip_tags( stripslashes( $new_instance['pinterest'] ) );
        $instance['wordpress'] = strip_tags( stripslashes( $new_instance['wordpress'] ) );
        $instance['youtube']   = strip_tags( stripslashes( $new_instance['youtube'] ) );
        $instance['vimeo']     = strip_tags( stripslashes( $new_instance['vimeo'] ) );
        $instance['linkedin']  = strip_tags( stripslashes( $new_instance['linkedin'] ) );
        $instance['behance']   = strip_tags( stripslashes( $new_instance['behance'] ) );
        $instance['dribbble']  = strip_tags( stripslashes( $new_instance['dribbble'] ) );
        return $instance;

    }

}

/**
 * About
 */
class glow_about extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'glow_about',
            __( 'Daisy: About Me', 'glow'),
            array(
                'description'   => __( 'Show a single page', 'glow' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $dt_about_page = isset( $instance['dt_about_page'] ) ? $instance['dt_about_page'] : '';
        $dt_about_page_id = $dt_about_page['0']['page'];

        ?>

        <aside class="widget dt-about-holder">
            <article>
                <h2 class="widget-title"><?php echo esc_html( get_the_title( $dt_about_page_id ) ); ?><span></span></h2>

                <?php  if ( has_post_thumbnail( $dt_about_page_id ) ) : ?>

                    <figure>

                        <?php
                        $image = '';
                        $title_attribute = get_the_title( $dt_about_page_id );
                        $image .= '<a href="'. esc_url( get_permalink( $dt_about_page_id ) ) . '" title="' . the_title( '', '', false ) .'">';
                        $image .= get_the_post_thumbnail( $dt_about_page_id, 'glow-about-img', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class' => 'transition35' ) ).'</a>';
                        echo $image;
                        ?>

                    </figure>

                <?php endif; ?>

                <p>
                    <?php
                    echo wp_trim_words( get_the_content( $dt_about_page_id ), 40, '...' );
                    ?>
                    <a href="<?php echo esc_url( get_permalink( $dt_about_page_id ) ); ?>" title="<?php _e( 'Read Details', 'glow' ); ?>"><?php _e( ' ...', 'glow' ); ?></a>
                </p>

            </article>
        </aside>

        <?php
    }

    public function form( $instance ) {

        $dt_about_page = isset( $instance['dt_about_page'] ) ? $instance['dt_about_page'] : '';
        if ( ! empty( $dt_about_page ) ) {
            foreach ( $dt_about_page as $dt_about_page_key => $dt_about_page_value ) { ?>

                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( 'dt_about_page' ).$dt_about_page_key; ?>"><?php _e( 'Select a Page', 'glow' ); ?></label>

                    <?php

                    $arg = array(
                        'name' => $this->get_field_name( "dt_about_page" ).'['.esc_attr( $dt_about_page_key ).'][page]',
                        'id'   => $this->get_field_id( "dt_about_page" ).$dt_about_page_key,
                        'selected' => $dt_about_page_value['page'],
                    );

                    wp_dropdown_pages( $arg );

                    ?>

                </div><!-- .dt-admin-input-wrap -->

            <?php }

        } else {
            for ( $dt_service_counter = 0; $dt_service_counter < 1; $dt_service_counter++ ) { ?>

                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( 'dt_about_page' ).$dt_service_counter; ?>"><?php _e( 'Select a Page', 'glow' ); ?></label>

                    <?php

                    $arg = array(
                        'name' => $this->get_field_name( "dt_about_page" ).'['.esc_attr( $dt_service_counter ).'][page]',
                        'id'   => $this->get_field_id( "dt_about_page" ).$dt_service_counter,
                    );

                    wp_dropdown_pages($arg);

                    ?>

                </div><!-- .dt-admin-input-wrap -->

                <?php
            }
        }
    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['dt_about_page'] = array();

        if ( isset( $new_instance['dt_about_page'] ) ) {
            foreach ( $new_instance['dt_about_page'] as $stream_source ) {
                $instance['dt_about_page'][] = $stream_source;
            }
        }
        return $instance;
    }

}

/**
 * Services
 */
class glow_services extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'glow_services',
            __( 'Daisy: Services', 'glow' ),
            array(
                'description'   => __( 'Show Service pages with shot description and featured image', 'glow' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title              = isset( $instance['title'] ) ? $instance['title'] : '';
        $dt_description     = isset( $instance['description'] ) ? esc_textarea( $instance['description'] ) : '';
        $dt_service_page    = isset( $instance['dt_service_page'] ) ? $instance['dt_service_page'] : '';
        ?>

        <div class="widget dt-services">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <header class="dt-entry-header">
                            <?php if( ! empty( $title ) ) : ?><h2 class="widget-title"><?php echo $title; ?><span><i class="fa fa-pagelines"></i> </span></h2><?php endif; ?>
                            <?php if( ! empty( $dt_description ) ) : ?><p><?php echo $dt_description; ?></p><?php endif; ?>
                        </header><!-- .dt-services-meta -->


                        <div class="dt-services-wrap">

                            <?php foreach ( $dt_service_page as $dt_service_page_key => $dt_service_page_value ) :
                                $dt_service_page_id = esc_attr( $dt_service_page_value['page'] ); ?>

                                <div class="dt-services-holder">
                                    <figure>
                                        <a href="<?php echo esc_url( get_the_permalink( $dt_service_page_id ) ); ?>">

                                            <?php
                                            $dt_service_page_thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $dt_service_page_id ), 'glow-service-img' );
                                            $dt_service_page_thumbnail_url = $dt_service_page_thumbnail_src[0];
                                            ?>

                                            <img src="<?php echo esc_url( $dt_service_page_thumbnail_url ); ?>" alt="<?php echo esc_attr( get_the_title( $dt_service_page_id ) ); ?>">
                                        </a>

                                        <a href="<?php echo esc_url( get_the_permalink( $dt_service_page_id ) ); ?>"><span class="transition35"><i class="fa fa-mail-forward"></i></span></a>
                                    </figure>

                                    <header class="dt-services-header transition5">
                                        <h3><a href="<?php echo esc_url( get_the_permalink( $dt_service_page_id ) ); ?>"><?php echo esc_attr( get_the_title( $dt_service_page_id ) ); ?></a></h3>

                                        <?php

                                            $dt_service_post = get_post( $dt_service_page_id );
                                            $dt_service_page_content = apply_filters( 'the_content', $dt_service_post->post_content );
                                            $postOutput = preg_replace( '/<img[^>]+./','', $dt_service_page_content );

                                            $dt_service_page_trimmed_content = wp_trim_words( $postOutput, 16, '...' );

                                        ?>

                                        <p><?php echo esc_attr( $dt_service_page_trimmed_content ); ?></p>
                                    </header><!-- .dt-services-header -->
                                </div><!-- .dt-services-holder -->

                            <?php endforeach; ?>

                            <div class="clearfix"></div>
                        </div><!-- .dt-services-wrap -->
                    </div><!-- .col-lg-12 .col-md-12 -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div>

        <?php
    }

    public function form( $instance ) {

        $dt_title           = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $dt_description     = isset( $instance['description'] ) ? esc_textarea( $instance['description'] ) : '';
        ?>

        <div class="dt-admin-input-wrap">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'glow' ); ?></label>
            <input type="url" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $dt_title; ?>" placeholder="<?php _e( 'Title', 'glow' ); ?>" >
        </div><!-- .dt-admin-input-wrap -->

        <div class="dt-admin-input-wrap">
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description', 'glow' ); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" placeholder="<?php _e( 'Some Description...', 'glow' ); ?>" ><?php echo esc_attr( $dt_description ); ?></textarea>
        </div><!-- .dt-admin-input-wrap -->

        <?php
        $dt_service_page = isset( $instance['dt_service_page'] ) ? $instance['dt_service_page'] : '';
        if ( ! empty( $dt_service_page ) ) {
            foreach ( $dt_service_page as $dt_service_page_key => $dt_service_page_value ) { ?>

                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( 'dt_service_page' ).$dt_service_page_key; ?>"><?php _e( 'Select Page', 'glow' ); ?></label>

                    <?php
                    $arg = array(
                        'name' => $this->get_field_name( "dt_service_page" ).'['.esc_attr( $dt_service_page_key ).'][page]',
                        'id'   => $this->get_field_id( "dt_service_page" ).$dt_service_page_key,
                        'selected' => $dt_service_page_value['page'],
                    );
                    ?>
                    <?php wp_dropdown_pages( $arg ); ?>

                </div><!-- .dt-admin-input-wrap -->

            <?php }

        } else {
            for ( $dt_service_counter = 0; $dt_service_counter < 6; $dt_service_counter++ ) { ?>

                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( 'dt_service_page' ).$dt_service_counter; ?>"><?php _e( 'Select Page', 'glow' ); ?></label>

                    <?php
                    $arg = array(
                        'name' => $this->get_field_name( "dt_service_page" ).'['.esc_attr( $dt_service_counter ).'][page]',
                        'id'   => $this->get_field_id( "dt_service_page" ).$dt_service_counter,
                    );
                    ?>
                    <?php wp_dropdown_pages( $arg ); ?>

                </div><!-- .dt-admin-input-wrap -->

            <?php }
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']              = ( ! empty( $new_instance['title'] ) ) ? wp_kses( $new_instance['title'] ) : '';
        $instance['description']        = ( ! empty( $new_instance['description'] ) ) ? wp_kses( $new_instance['description'] ) : '';
        $instance['dt_service_page']    = array();

        if ( isset( $new_instance['dt_service_page'] ) ) {
            foreach ( $new_instance['dt_service_page'] as $stream_source ) {
                $instance['dt_service_page'][] = $stream_source;
            }
        }
        return $instance;
    }

}

/**
 * Call to Action
 */
class glow_call_to_action extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'glow_call_to_action',
            __( 'Daisy: Call to Action', 'glow' ),
            array(
                'description'   => __( 'Show call to action button with link', 'glow' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $description    = isset( $instance['description'] ) ? $instance['description'] : '';
        $button         = isset( $instance['button'] ) ? $instance['button'] : '';
        $button_url     = isset( $instance['button-url'] ) ? $instance['button-url'] : 'Button';

        ?>

        <div class="widget dt-call-to-action-wrap">
            <div class="dt-call-to-action-meta">
                <?php if( ! empty ( $title ) ) : ?><h2 class="widget-title"><?php echo esc_attr( $title ); ?></h2> <?php endif; ?>
                <?php if( ! empty ( $description ) ) : ?><p><?php echo esc_attr( $description ); ?></p><?php endif; ?>
            </div><!-- .dt-call-to-action-meta -->

            <div class="dt-call-to-action-btn">
                <a href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_attr( $button ); ?></a>
            </div><!-- .dt-call-to-action-btn -->

            <div class="clearfix"></div>
        </div><!-- .dt-call-to-action-wrap -->

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'description'        => '',
                'button'             => '',
                'button-url'         => ''
            )
        );

        ?>

        <div class="dt-admin-input-wrap">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'glow' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Title', 'glow' ); ?>" >
        </div><!-- .dt-admin-input-wrap -->

        <div class="dt-admin-input-wrap">
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description', 'glow' ); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" placeholder="<?php _e( 'Some Description ...', 'glow' ); ?>" ><?php echo esc_attr( $instance['description'] ); ?></textarea>
        </div><!-- .dt-admin-input-wrap -->

        <div class="dt-admin-input-wrap">
            <label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e( 'Button Text', 'glow' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" value="<?php echo esc_attr( $instance['button'] ); ?>" placeholder="<?php _e( 'Button Text', 'glow' ); ?>" >
        </div><!-- .dt-admin-input-wrap -->

        <div class="dt-admin-input-wrap">
            <label for="<?php echo $this->get_field_id( 'button-url' ); ?>"><?php _e( 'Button URL', 'glow' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'button-url' ); ?>" name="<?php echo $this->get_field_name( 'button-url' ); ?>" value="<?php echo esc_attr( $instance['button-url'] ); ?>" placeholder="<?php _e( 'Button URL', 'glow' ); ?>" >
        </div><!-- .dt-admin-input-wrap -->

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                   = $old_instance;
        $instance['title']        = esc_attr( $new_instance['title'] );
        $instance['description']  = esc_textarea( $new_instance['description'] );
        $instance['button']       = esc_attr( $new_instance['button'] );
        $instance['button-url']   = esc_url( $new_instance['button-url'] );
        return $instance;

    }

}

/**
 * Testimonial.
 */
class glow_testimonial extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'glow_testimonial',
            __( 'Daisy: Testimonial', 'glow' ),
            array(
                'description'   => __( 'Show client Testimonials', 'glow' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title              = isset( $instance['title'] ) ? $instance['title'] : '';
        $dt_testimonial_page    = isset( $instance['dt_testimonial_page'] ) ? $instance['dt_testimonial_page'] : '';
        ?>

        <div class="widget dt-testimonial">
            <div class="dt-testimonial-wrap">
                <header class="dt-entry-header">
                    <?php if( ! empty( $title ) ) : ?><h2 class="widget-title"><?php echo $title; ?><span><i class="fa fa-pagelines"></i> </span></h2><?php endif; ?>
                </header>

                <div class="dt-testimonial-slider">
                    <div class="swiper-wrapper">

                        <?php foreach ( $dt_testimonial_page as $dt_testimonial_page_key => $dt_testimonial_page_value ) :
                            $dt_testimonial_page_id = esc_attr( $dt_testimonial_page_value['page'] ); ?>

                            <div class="swiper-slide">
                                <div class="dt-testimonial-holder">
                                    <?php

                                    $dt_service_post = get_post( $dt_testimonial_page_id );
                                    $dt_service_page_content = apply_filters( 'the_content', $dt_service_post->post_content );
                                    $postOutput = preg_replace( '/<img[^>]+./','', $dt_service_page_content );

                                    $dt_testimonial_page_trimmed_content = wp_trim_words( $postOutput, 250, '...' );

                                    ?>

                                    <div class="dt-testimonial-desc">
                                        <p><?php echo esc_attr( $dt_testimonial_page_trimmed_content ); ?></p>
                                    </div>

                                    <div class="dt-testimonial-meta">
                                        <figure>
                                            <a href="<?php echo esc_url( get_the_permalink( $dt_testimonial_page_id ) ); ?>">

                                                <?php
                                                $dt_testimonial_page_thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $dt_testimonial_page_id ), 'glow-service-img' );
                                                $dt_testimonial_page_thumbnail_url = $dt_testimonial_page_thumbnail_src[0];
                                                ?>

                                                <img src="<?php echo esc_url( $dt_testimonial_page_thumbnail_url ); ?>" alt="<?php echo esc_attr( get_the_title( $dt_testimonial_page_id ) ); ?>">
                                            </a>
                                        </figure>

                                        <h5><?php echo esc_attr( get_the_title( $dt_testimonial_page_id ) ); ?></h5>
                                    </div><!-- .dt-testimonial-meta -->
                                </div><!-- .dt-testimonial-holder -->
                            </div><!-- .swiper-slide -->

                        <?php endforeach; ?>

                    </div><!-- .swiper-wrapper -->

                    <!-- Add Arrows -->
                    <div class="swiper-button-next transition5"><i class="fa fa-angle-right"></i></div>
                    <div class="swiper-button-prev transition5"><i class="fa fa-angle-left"></i></div>
                </div><!-- .dt-testimonial-slider -->
            </div>
        </div>

        <?php
    }

    public function form( $instance ) {

        $dt_title           = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        ?>

        <div class="dt-admin-input-wrap">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'glow' ); ?></label>
            <input type="url" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $dt_title; ?>" placeholder="<?php _e( 'Title', 'glow' ); ?>" >
        </div><!-- .dt-admin-input-wrap -->

        <?php
        $dt_testimonial_page = isset( $instance['dt_testimonial_page'] ) ? $instance['dt_testimonial_page'] : '';
        if ( ! empty( $dt_testimonial_page ) ) {
            foreach ( $dt_testimonial_page as $dt_testimonial_page_key => $dt_testimonial_page_value ) { ?>

                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( 'dt_testimonial_page' ).$dt_testimonial_page_key; ?>"><?php _e( 'Select Page', 'glow' ); ?></label>

                    <?php
                    $arg = array(
                        'name' => $this->get_field_name( "dt_testimonial_page" ).'['.esc_attr( $dt_testimonial_page_key ).'][page]',
                        'id'   => $this->get_field_id( "dt_testimonial_page" ).$dt_testimonial_page_key,
                        'selected' => $dt_testimonial_page_value['page'],
                    );
                    ?>
                    <?php wp_dropdown_pages( $arg ); ?>

                </div><!-- .dt-admin-input-wrap -->

            <?php }

        } else {
            for ( $dt_service_counter = 0; $dt_service_counter < 3; $dt_service_counter++ ) { ?>

                <div class="dt-admin-input-wrap">
                    <label for="<?php echo $this->get_field_id( 'dt_testimonial_page' ).$dt_service_counter; ?>"><?php _e( 'Select Page', 'glow' ); ?></label>

                    <?php
                    $arg = array(
                        'name' => $this->get_field_name( "dt_testimonial_page" ).'['.esc_attr( $dt_service_counter ).'][page]',
                        'id'   => $this->get_field_id( "dt_testimonial_page" ).$dt_service_counter,
                    );
                    ?>
                    <?php wp_dropdown_pages( $arg ); ?>

                </div><!-- .dt-admin-input-wrap -->

            <?php }
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']              = ( ! empty( $new_instance['title'] ) ) ? wp_kses( $new_instance['title'] ) : '';
        $instance['dt_testimonial_page']    = array();

        if ( isset( $new_instance['dt_testimonial_page'] ) ) {
            foreach ( $new_instance['dt_testimonial_page'] as $stream_source ) {
                $instance['dt_testimonial_page'][] = $stream_source;
            }
        }
        return $instance;
    }

}

/**
 * News Recent Posts
 */
class glow_recent_posts extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'glow_recent_posts',
            __( 'Daisy: Front Recent Posts', 'glow' ),
            array(
                'description'   => __( 'Posts display widget for recently published post', 'glow' )
            )
        );
    }

    public function widget( $args, $instance ) {

        global $post;
        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $category       = isset( $instance['category'] ) ? $instance['category'] : '';
        $no_of_posts    = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : '';

        $news_layout1 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category,
            'posts_per_page'    => $no_of_posts
        ) );

        ?>

        <div class="widget dt-news-layout-wrap">
            <?php
            if ( $news_layout1->have_posts() ) : ?>

                <header class="dt-entry-header">
                    <?php if( ! empty( $title ) ) : ?><h2 class="widget-title"><?php echo esc_html( $title ); ?><span><i class="fa fa-pagelines"></i> </span></h2><?php endif; ?>
                </header>

                <div class="container">
                    <div class="row">

                        <?php while ( $news_layout1->have_posts() ) : $news_layout1->the_post(); ?>

                            <div class="col-lg-4 col-md-4">
                                <div class="dt-recent-post-holder">
                                    <figure class="transition35">

                                        <?php

                                        if ( has_post_thumbnail() ) :
                                            $image = '';
                                            $title_attribute = get_the_title( $post->ID );
                                            $image .= '<a href="'. esc_url( get_permalink() ) . '" title="' . esc_attr( the_title( '', '', false ) ) .'">';
                                            $image .= get_the_post_thumbnail( $post->ID, 'glow-service-img', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                                            echo $image;

                                        else : ?>

                                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/blank.png" alt="<?php _e( 'no image found', 'glow' ); ?>"/>

                                        <?php endif; ?>

                                    </figure><!-- .dt-recent-post-img -->

                                    <div class="dt-recent-post-content">
                                        <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

                                        <p><?php

                                            $excerpt = get_the_excerpt();
                                            $limit   = "140";
                                            $pad     = "...";

                                            if( strlen( $excerpt ) <= $limit ) {
                                                echo esc_attr( $excerpt );
                                            } else {
                                                $excerpt = substr( $excerpt, 0, $limit ) . $pad;
                                                echo esc_attr( $excerpt );
                                            }

                                            ?></p>
                                    </div><!-- .dt-recent-post-content -->
                                </div><!-- .dt-recent-post-holder -->
                            </div>

                        <?php endwhile; ?>

                    </div>
                </div>

            <?php else : ?>
                <p><?php _e( 'Sorry, no posts found in selected category.', 'glow' ); ?></p>
            <?php endif; ?>

            <div class="clearfix"></div>
        </div><!-- .dt-news-layout-wrap -->

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'category'           => '',
                'no_of_posts'        => '4'
            )
        );

        ?>

        <div class="dt-admin-recent-posts">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'glow' ); ?></strong></label>

                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Category', 'glow' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
                    <?php foreach( get_terms( 'category','parent=0&hide_empty=0' ) as $term ) { ?>
                        <option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><strong><?php _e( 'No. of Posts', 'glow' ); ?></strong></label>

                <input type="number" id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo esc_attr( $instance['no_of_posts'] ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-news-list-1 -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                   = $old_instance;
        $instance['title']          = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['category']       = strip_tags( stripslashes( $new_instance['category'] ) );
        $instance['no_of_posts']    = strip_tags( stripslashes( $new_instance['no_of_posts']  ) );
        return $instance;

    }

}

/**
 * Opening Hours widget.
 */
class glow_opening_hour extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'glow_opening_hour',
            __( 'Daisy: Opening Hours', 'glow' ),
            array(
                'description'   => __( 'Opening Hours', 'glow' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title      = isset( $instance['title'] ) ? $instance['title'] : '';
        $sun        = isset( $instance['sun'] ) ? $instance['sun'] : '';
        $mon        = isset( $instance['mon'] ) ? $instance['mon'] : '';
        $tue        = isset( $instance['tue'] ) ? $instance['tue'] : '';
        $wed        = isset( $instance['wed'] ) ? $instance['wed'] : '';
        $thus       = isset( $instance['thus'] ) ? $instance['thus'] : '';
        $fri        = isset( $instance['fri'] ) ? $instance['fri'] : '';
        $sat        = isset( $instance['sat'] ) ? $instance['sat'] : '';

        ?>

        <div class="widget dt-opening-hours">

            <?php if( ! empty( $title ) ) : ?><h2 class="widget-title"><label><?php echo $title; ?></label></h2><?php endif; ?>

            <ul>
                <?php if( ! empty( $sun ) ) { ?>
                    <li><label><?php _e( 'Sunday', 'glow' ); ?> </label><span><?php echo esc_attr( $sun ); ?></span></li>
                <?php } ?>

                <?php if( ! empty( $mon ) ) { ?>
                    <li><label><?php _e( 'Monday', 'glow' ); ?> </label><span><?php echo esc_attr( $mon ); ?></span></li>
                <?php } ?>

                <?php if( ! empty( $tue ) ) { ?>
                    <li><label><?php _e( 'Tuesday', 'glow' ); ?> </label><span><?php echo esc_attr( $tue ); ?></span></li>
                <?php } ?>

                <?php if( ! empty( $wed ) ) { ?>
                    <li><label><?php _e( 'Wednesday', 'glow' ); ?> </label><span><?php echo esc_attr( $wed ); ?></span></li>
                <?php } ?>

                <?php if( ! empty( $thus ) ) { ?>
                    <li><label><?php _e( 'Thursday', 'glow' ); ?> </label><span><?php echo esc_attr( $thus ); ?></span></li>
                <?php } ?>

                <?php if( ! empty( $fri ) ) { ?>
                    <li><label><?php _e( 'Friday', 'glow' ); ?> </label><span><?php echo esc_attr( $fri ); ?></span></li>
                <?php } ?>

                <?php if( ! empty( $sat ) ) { ?>
                    <li><label><?php _e( 'Saturday', 'glow' ); ?> </label><span><?php echo esc_attr( $sat ); ?></span></li>
                <?php } ?>

                <div class="clearfix"></div>
            </ul>
        </div>

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'             => '',
                'sun'               => '',
                'mon'               => '',
                'tue'               => '',
                'wed'                => '',
                'thus'              => '',
                'fri'               => '',
                'sat'               => '',
            )
        );

        ?>

        <div class="dt-opening-hours">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Title', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'sun' ); ?>"><?php _e( 'Sunday', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'sun' ); ?>" name="<?php echo $this->get_field_name( 'sun' ); ?>" value="<?php echo esc_attr( $instance['sun'] ); ?>" placeholder="<?php _e( '10:00AM - 6:00PM', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'mon' ); ?>"><?php _e( 'Monday', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'mon' ); ?>" name="<?php echo $this->get_field_name( 'mon' ); ?>" value="<?php echo esc_attr( $instance['mon'] ); ?>" placeholder="<?php _e( '10:00AM - 6:00PM', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'tue' ); ?>"><?php _e( 'Tuesday', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'tue' ); ?>" name="<?php echo $this->get_field_name( 'tue' ); ?>" value="<?php echo esc_attr( $instance['tue'] ); ?>" placeholder="<?php _e( '10:00AM - 6:00PM', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'wed' ); ?>"><?php _e( 'Wednesday', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'wed' ); ?>" name="<?php echo $this->get_field_name( 'wed' ); ?>" value="<?php echo esc_attr( $instance['wed'] ); ?>" placeholder="<?php _e( '10:00AM - 6:00PM', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'thus' ); ?>"><?php _e( 'Thursday', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'thus' ); ?>" name="<?php echo $this->get_field_name( 'thus' ); ?>" value="<?php echo esc_attr( $instance['thus'] ); ?>" placeholder="<?php _e( '10:00AM - 6:00PM', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'fri' ); ?>"><?php _e( 'Friday', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'fri' ); ?>" name="<?php echo $this->get_field_name( 'fri' ); ?>" value="<?php echo esc_attr( $instance['fri'] ); ?>" placeholder="<?php _e( '10:00AM - 6:00PM', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'sat' ); ?>"><?php _e( 'Saturday', 'glow' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'sat' ); ?>" name="<?php echo $this->get_field_name( 'sat' ); ?>" value="<?php echo esc_attr( $instance['sat'] ); ?>" placeholder="<?php _e( '10:00AM - 6:00PM', 'glow' ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-social-icons -->

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance             = $old_instance;
        $instance['title']    = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['sun']      = strip_tags( stripslashes( $new_instance['sun'] ) );
        $instance['mon']      = strip_tags( stripslashes( $new_instance['mon'] ) );
        $instance['tue']      = strip_tags( stripslashes( $new_instance['tue'] ) );
        $instance['wed']      = strip_tags( stripslashes( $new_instance['wed'] ) );
        $instance['thus']     = strip_tags( stripslashes( $new_instance['thus'] ) );
        $instance['fri']      = strip_tags( stripslashes( $new_instance['fri'] ) );
        $instance['sat']      = strip_tags( stripslashes( $new_instance['sat'] ) );
        return $instance;

    }

}

// Register widgets
function glow_register_widgets() {

    register_widget( 'glow_social_icons' );
    register_widget( 'glow_about' );
    register_widget( 'glow_services' );
    register_widget( 'glow_call_to_action' );
    register_widget( 'glow_testimonial' );
    register_widget( 'glow_recent_posts' );
    register_widget( 'glow_opening_hour' );

}
add_action( 'widgets_init', 'glow_register_widgets' );
