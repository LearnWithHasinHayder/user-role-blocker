<?php
/*
Plugin Name: User Role Blocker
Plugin URI:
Description: Block User By Role
Version: 1.0.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: urb
 */
add_action( 'init', function () {
    add_role( 'urb_user_blocked', __( 'Blocked', 'urb' ), array('blocked' => true) );
    add_rewrite_rule('blocked/?$','index.php?blocked=1','top');
} );

add_action('init',function(){
    //$user = wp_get_current_user();
    //if($user->has_cap('blocked'));

    if(is_admin() && current_user_can('blocked')){
        wp_redirect(get_home_url().'/blocked');
        die();
    }elseif(current_user_can('blocked')){
        //show_admin_bar(false);
    }

});

add_filter('query_vars',function($query_vars){
    $query_vars[]='blocked';
    return $query_vars;
});

add_action('template_redirect',function(){
    $is_blocked = intval(get_query_var('blocked'));
    if($is_blocked){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Blocked</title>
        </head>
        <body>
            <h2><?php _e('You are blocked','urb')  ;?></h2>
        </body>
        </html>
        <?php
        die();
    }
}); 