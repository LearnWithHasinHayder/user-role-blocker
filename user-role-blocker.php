<?php
/*
Plugin Name: User Role Blocker
Plugin URI: https://github.com/LearnWithHasinHayder/user-role-blocker
Description: A simple and nice plugin to block existing users from logging into the admin panel by assigning them to the 'Blocked' user role, as simple as that.
Version: 1.0.0
Author: Captain Haddock
Author URI: https://profiles.wordpress.org/captainhaddock/
License: GPLv2 or later
Text Domain: user-role-blocker
 */
add_action( 'init', function () {
    add_role( 'urb_user_blocked', __( 'Blocked', 'user-role-blocker' ), array( 'blocked' => true ) );
    add_rewrite_rule( 'blocked/?$', 'index.php?blocked=1', 'top' );
} );

add_action( 'init', function () {
    if ( is_admin() && current_user_can( 'blocked' ) ) {
        wp_redirect( get_home_url() . '/blocked' );
        die();
    }
} );

add_filter( 'query_vars', function ( $query_vars ) {
    $query_vars[] = 'blocked';
    return $query_vars;
} );

add_action( 'template_redirect', function () {
    $is_blocked = intval( get_query_var( 'blocked' ) );
    if ( $is_blocked ) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php _e( 'Blocked User', 'user-role-blocker' );?></title>
        </head>
        <body>
            <h2 style="text-align: center"><?php _e( 'You are blocked', 'user-role-blocker' );?></h2>
        </body>
        </html>
        <?php
die();
    }
} );