#### About this repository.
This plugin seperates the complicated user meta sent by auth0 upon login to seperate keys, making it easier to retrieve each individual key. In short, this plugin allows you to easily retrieve user_meta fields.

#### Example
Here's an example on retrieving the last name of a logged in user.

<?php
$user_id = get_current_user_id();
$key = 'last_name';
$single = true;
$last_name = get_user_meta( $user_id, $key, $single );
echo $last_name;
?>
