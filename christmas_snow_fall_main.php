<?php
/*
Plugin Name: Christmas Snow Fall
Plugin URI: http://webeeoo.com/wp_plugin/christmas-snow-fall-plugin-test/
Description: This is an awesome free Christmas snow falling wordpress plugin . You can add falling snow flakes to your website and customize these snow flakes using various configuration options in your WordPress Dashboard Setting christmas snow fall option. 
Author: Md. Shiddikur Rahman
Author URI: http://phpdev.us/siddik
Version: 1.0
*/
/* Adding Latest jQuery from Wordpress */
function christmas_snow_main_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'christmas_snow_main_jquery');
/*Some Set-up*/
define('CHRISTMAS_SNOW_FALL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );



/* Including all files */
function christmas_snow_fall_file() {		

wp_enqueue_script('christmas-snow-min-js', CHRISTMAS_SNOW_FALL.'js/snow-fall.js', array('jquery'), 1.0, false);

}
add_action( 'wp_enqueue_scripts', 'christmas_snow_fall_file' );

function snow_fall_fnc(){
	?>

<?php global $snowfall_options; $snow_fall_settings = get_option( 'snowfall_options', $snowfall_options ); ?>	
	
<style>
body{
background-color:<?php echo $snow_fall_settings['bg_color_snow']; ?>
}
.snow-canvas {
display: block;
width: 100%;
height: 100%;
top: 0;
left: 0;
position: fixed;
pointer-events: none;
}
</style>
    <canvas class="snow-canvas" speed="1" interaction="false" size="2" count="80" opacity="0.00001" start-color="rgba(253,252,251,1)" end-color="rgba(251,252,253,0.3)" wind-power="0" image="false" width="1366" height="667"></canvas>
    <canvas class="snow-canvas" speed="3" interaction="true" size="6" count="30" start-color="rgba(253,252,251,1)" end-color="rgba(251,252,253,0.3)" opacity="0.00001" wind-power="2" image="false" width="1366" height="667"></canvas>
	
	<canvas class="snow-canvas" speed="3" interaction="true" size="12" count="20" wind-power="-5" image="<?php echo plugins_url( 'img/snow.png', __FILE__ ); ?>" width="1366" height="667"></canvas>	

	<canvas class="snow-canvas" speed="3" interaction="true" size="12" count="20" wind-power="-5" image="<?php echo plugins_url( 'img/snowflake.png', __FILE__ ); ?>" width="1366" height="667"></canvas>	
	
	<canvas class="snow-canvas" speed="3" interaction="true" size="12" count="20" wind-power="-5" image="<?php echo plugins_url( 'img/snowflake_1.png', __FILE__ ); ?>" width="1366" height="667"></canvas>	
	
	<canvas class="snow-canvas" speed="3" interaction="true" size="12" count="20" wind-power="-5" image="<?php echo plugins_url( 'img/snowflake_2.png', __FILE__ ); ?>" width="1366" height="667"></canvas>	
	
	<canvas class="snow-canvas" speed="3" interaction="true" size="12" count="20" wind-power="-5" image="<?php echo plugins_url( 'img/snowflake_3.png', __FILE__ ); ?>" width="1366" height="667"></canvas>

<script type="text/javascript">
jQuery(document).ready(function(){
       jQuery(".snow-canvas").snow();
});
</script>	
	 
	<?php
}





add_shortcode('snow_fall', 'snow_fall_fnc');


function christmas_snow_fall_options()
{
	add_options_page('Christmas Snow Fall Options', 'Christmas Snow Fall Options', 'manage_options', 'snow-fall-settings', 'snow_fall_options');
}
add_action('admin_menu', 'christmas_snow_fall_options');

add_action( 'admin_enqueue_scripts', 'snow_fall_color_picker' );
function snow_fall_color_picker( $hook ) {
 
    if( is_admin() ) {
     
        // Add the color picker css file      
        wp_enqueue_style( 'wp-color-picker' );
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-color_picker', plugins_url( 'inc/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }
}
// Default values

$snowfall_options = array(
	'bg_color_snow' => 'fff',

);



if ( is_admin() ) : // Load only if we are viewing an admin page

function snow_fall_settings() {
	// Register settings and call sanitation function
	register_setting( 'snow_fall_seting_options', 'snowfall_options', 'snow_validate_options' );
}

add_action( 'admin_init', 'snow_fall_settings' );




// Function to generate options page
function snow_fall_options() {
	global $snowfall_options;
	
	if ( !isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>


	<div class="wrap">
	

	<h2>Christmas Snow Falling Option</h2>
	
	<form method="post" action="options.php">
	
	<?php $settings = get_option( 'snowfall_options', $snowfall_options ); ?>
	
	<?php settings_fields( 'snow_fall_seting_options' ); ?>

	
	<table class="form-table">
		<tr>
			<td align="center"><input type="submit" class="button-secondary" name="snowfall_options[back_as_default]" value="Back as default" /></td>
			<td colspan="2"><input type="submit" class="button-primary" value="Save Settings" /></td>
		</tr>
			
		<tr valign="top">
			<th scope="row"><label for="bg_color_snow">Change your Backgroud Color</label></th>
			<td>:</td>
			<td>
				<input  id='bg_color_snow' type="text" name="snowfall_options[bg_color_snow]" value="<?php echo stripslashes($settings['bg_color_snow']); ?>" class="color-field" />
				<p class="description">Change your Background. You can also add html HEX color code. Default color is #fff</p>
			</td>
		</tr>
	
			


		<tr>
			<td align="center"><input type="submit" class="button-secondary" name="snowfall_options[back_as_default]" value="Back as default" /></td>
			<td colspan="2"><input type="submit" class="button-primary" value="Save Settings" /></td>
		</tr>
	</table>
	
	</form>
	
	</div>
	
	<?php
}




// Inputs validation, if fails validations replace by default values.
function snow_validate_options( $input ) {
	global $snowfall_options, $scroll_auto_hide_mode;
	
	$settings = get_option( 'snowfall_options', $snowfall_options );
	
	// We strip all tags from the text field, to avoid Vulnerabilities like XSS
	
	$input['bg_color_snow'] = isset( $input['back_as_default'] ) ? 'fff' : wp_filter_post_kses( $input['bg_color_snow'] );



	
	
	return $input;
}

endif;		// Endif is_admin()







?>