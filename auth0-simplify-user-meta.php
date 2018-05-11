<?php
/*
Plugin Name: Auth0 Simplify User Meta
Plugin URI: https://accounts.asuite.org
Description: This plugin seperates the complicated user meta sent by auth0 upon login to seperate keys, making it easier to retrieve each individual key. In short, this plugin allows you to easily retrieve user_meta fields.
Version: 1.0
Author: ASuite Accounts
Author URI: https://accounts.asuite.org
*/
function your_function( $user_login, $user ) {
global $wpdb;
$prefix = $wpdb->prefix;
$currentuserid = $user->ID;
$myString = get_user_meta($currentuserid, $prefix . 'auth0_obj', true);
$auth0array = explode(',', $myString);
$cleanarray1 = str_replace('"user_metadata":{','',$auth0array);
$cleanarray2 = str_replace('"app_metadata":{','',$cleanarray1);
$cleanedusermeta = str_replace('{','',$cleanarray2);
$cleanedusermetastep2 = str_replace('}','',$cleanedusermeta);
$cleanedusermetastep3 = str_replace(']','',$cleanedusermetastep2);
$cleanedusermetastep4 = str_replace('[','',$cleanedusermetastep3);
$cleanedusermetastep5 = str_replace('(','',$cleanedusermetastep4);
$cleanedusermetastep6 = str_replace(')','',$cleanedusermetastep5);
print_r($cleanedusermetastep6);
$usermetaarray = $cleanedusermetastep6;
foreach ($usermetaarray as $value) {
$seperatekeyandvalue = explode(':', $value);
$key = $seperatekeyandvalue[0];
$value = $seperatekeyandvalue[1];
$cleanedkey = str_replace('"', "", $key);
$cleanedvalue = str_replace('"', "", $value);
update_user_meta($currentuserid, $cleanedkey, $cleanedvalue);
if ($cleanedkey == 'given_name') {
wp_update_user( array( 'ID' => $currentuserid, 'first_name' => $cleanedvalue ) );
}elseif ($cleanedkey == 'family_name') {
wp_update_user( array( 'ID' => $currentuserid, 'last_name' => $cleanedvalue ) );
}
}
}
add_action('wp_login', 'your_function', 10, 2);
function do_anything() {
$current_user = wp_get_current_user();
$userid = $current_user->ID;
    
$auth0fname = get_user_meta($userid, 'given_name', true ); 
$auth0lname = get_user_meta($userid, 'family_name', true ); 
if (!empty($auth0fname)) {
wp_update_user( array( 'ID' => $userid, 'first_name' => $auth0fname, 'last_name' => $auth0lname, 'display_name' => $auth0fname . ' ' . $auth0lname ) );
}
}
add_action('wp_login', 'do_anything', 10, 2);
