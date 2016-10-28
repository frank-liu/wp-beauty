<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Glow
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header class="dt-site-header" role="banner">
        <div class="dt-main-menu-wrap transition35 <?php if( is_front_page() && get_theme_mod( 'home_featured_posts' ) != '' ) : ?>dt-home-menu dt-main-menu-scroll<?php endif; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <div class="dt-logo">

                            <?php
                            if ( function_exists( 'get_custom_logo' ) && has_custom_logo() ) :
                                the_custom_logo();
                            else :
                            ?>

                            <h1 class="transition35 site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

                                <?php
                                $description = get_bloginfo( 'description', 'display' );
                                if ( $description || is_customize_preview() ) : ?>
                                    <span class="site-description"><?php echo $description; ?></span>
                                <?php endif; ?>
                            </h1>

                            <?php endif; ?>

                            <div class="dt-menu-md">
                                <i class="fa fa-bars"></i>
                            </div>
                        </div><!-- .dt-logo -->
                    </div><!-- .col-lg-3 .col-md-3 -->

                    <?php if ( has_nav_menu( 'primary' ) ) : ?>

                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <nav class="dt-main-menu">
                            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
                        </nav><!-- .dt-main-menu -->
                    </div><!-- .col-lg-9 .col-md-9 -->

                    <?php endif; ?>

                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .dt-main-menu-wrap -->

        <?php if ( get_theme_mod( 'home_featured_posts' ) == '' || ! is_front_page() ) : ?>

            <div class="dt-header-sep"></div>

        <?php endif; ?>

        <?php if( ! is_front_page() && ! is_home() ) : ?>

            <div class="dt-breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">

                            <?php glow_breadcrumb(); ?>

                        </div><!-- .col-lg-12 .col-md-12 -->
                    </div><!-- .row-->
                </div><!-- .container-->
            </div><!-- .dt-breadcrumbs-->

        <?php endif; ?>

	</header>
