<?php
function wpbook_settings_page() {

    global $wpbook_settings;

	ob_start(); ?>
	<div class="wrap">
		<h1>WP-Book , Plugin Options : </h1>
		<form method="post" action="options.php">
            <?php settings_fields('wpbook_settings_group'); ?>
            
            <h2>Currency Options</h2>

            <p>
                <?php $currency_choices = array('INR','USD','EUR'); ?>
                <select id="wpbook_settings[currency]" name="wpbook_settings[currency]">
                    <?php foreach($currency_choices as $currecy_choice){ ?>
                        <?php 
                        if($wpbook_settings['currency'] == $currecy_choice) {
                            $selected = 'selected="selected"'; 
                        } 
                        else{
                             $selected=''; 
                        } 
                    ?>
                        <option value="<?php echo $currecy_choice; ?>"<?php echo $selected; ?>> <?php echo $currecy_choice;?></option>
                    <?php } ?>
                </select>
                <label class="description" for="wpbook_settings[number_of_books]"><?php _e('Select Currency','wp-book'); ?></label>
            </p>

            <h2>Number of Books Displayed Per Page</h2>
            
            <p>
                <input id="wpbook_settings[number_of_books]" name="wpbook_settings[number_of_books]" type="number" value="<?php echo $wpbook_settings['number_of_books']; ?>" />
                <label class="description" for="wpbook_settings[number_of_books]"><?php _e('Please Enter Number of Books Per Page','wp-book'); ?></label>
            </p>

            <p>
                <input type="submit" class="button-primary" value="Save Options" />
            </p>

        </form>
	</div>
	<?php
	echo ob_get_clean();
}
function wpbook_add_admin_settings() {
	add_menu_page(
        __('Book Admin Settings Page', 'wp-book'),
        __('Book Admin Settings', 'wp-book'),
        'manage_options',
        'wpbook-settings',
        'wpbook_settings_page',
        '',
        35
    );
}
add_action('admin_menu', 'wpbook_add_admin_settings');

function wpbook_register_admin_settings(){
    register_setting('wpbook_settings_group', 'wpbook_settings');
}
add_action('admin_init', 'wpbook_register_admin_settings');