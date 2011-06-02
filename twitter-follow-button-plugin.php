<?php
/*
Plugin Name: Twitter Follow Button
Plugin URI: http://cmsvoteup.com/wordpress-plugins/twitter-follow-button-plugin/
Description: With this plugin, you can embed Twitter Follow Button to let your visitor follow you instantly by just clicking on the button. Add the Follow Button to your website to increase engagement and create a lasting connection with your audience.
Version: 1.0
Author: Leon Wood
Author URI: CMSVoteUp.com
License:  http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
*/

define("twitter_follow_button","1.0",false);

function twitter_follow_button_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { 
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}

function activate_twitter_follow_button() {
	global $twitter_follow_button_options;
	$twitter_follow_button_options = array('position_button'=>'after',
							   'own_css'=>'float: right;', 
							   'screen_name'=>'cmsvoteup', 'data_button'=>'blue', 'data_show_count'=>'true', 'lang'=>'en', 'data_text_color'=>'#800080', 'data_link_color'=>'#800080', 'creditOn'=>'true');
	add_option('twitter_follow_button_options',$twitter_follow_button_options);
}	

global $twitter_follow_button_options;	

$twitter_follow_button_options = get_option('twitter_follow_button_options');		
	  
register_activation_hook( __FILE__, 'activate_twitter_follow_button' );

function add_twitter_follow_button_automatic($content){ 
	global $twitter_follow_button_options, $post;
 
	$p_title = get_the_title($post->ID);
	$voteUrl = get_permalink( $post->ID ).'&title='.str_replace(' ','+',$p_title).'&referenceUrl='.get_bloginfo( 'url' );
	$own_css = $twitter_follow_button_options['own_css'];

	$screen_name = $twitter_follow_button_options['screen_name'];
	$data_show_count = $twitter_follow_button_options['data_show_count'];
	$data_button = $twitter_follow_button_options['data_button'];
	$data_text_color = $twitter_follow_button_options['data_text_color']; //800080
	$data_link_color = $twitter_follow_button_options['data_link_color']; //800080
	$lang = $twitter_follow_button_options['lang'];
	//$creditOn = $twitter_follow_button_options['creditOn'];

	$htmlCode ="<div style='$cssStyle'>";
	$htmlCode .= "<a href=\"http://twitter.com/$screen_name\" class=\"twitter-follow-button\" data-show-count=\"$data_show_count\" data-button=\"$data_button\" data-text-color=\"$data_text_color\" data-link-color=\"$data_link_color\" data-lang=\"$lang\">Follow @$screen_name</a>\n";
	$htmlCode .= "<script src=\"http://platform.twitter.com/widgets.js\" type=\"text/javascript\"></script>";
	if ($creditOn == "true") {
		$htmlCode .= "<a href=\"http://cmsvoteup.com/category/wordpress-plugins/\" title=\"Get Twitter Follow Button Wordpress Plugin\" target=\"_blank\"><img src=\"http://www.cmsvoteup.com/images/power_by_2x2.gif\" border=\"0\"/></a>"; 
	}
	$htmlCode .="</div>";
	
		
	$twitter_follow_button = $htmlCode;
	if($twitter_follow_button_options['position_button'] == 'before' ){
		$content = $twitter_follow_button . $content;
	}
	else if($twitter_follow_button_options['position_button'] == 'after' ){
		$content = $content . $twitter_follow_button;
	} else  if($twitter_follow_button_options['position_button'] == 'before_and_after' ){
		$content = $twitter_follow_button. $content. $twitter_follow_button;
	}
	return $content;
}

if ($twitter_follow_button_options['position_button'] != 'manual'){
	add_filter('the_content','add_twitter_follow_button_automatic'); 
}

function add_twitter_follow_button(){
	global $twitter_follow_button_options, $post;
	$p_title = get_the_title($post->ID);
	$voteUrl = get_permalink( $post->ID ).'&title='.str_replace(' ','+',$p_title).'&referenceUrl='.get_bloginfo( 'url' );
	$own_css = $twitter_follow_button_options['own_css'];

	$screen_name = $twitter_follow_button_options['screen_name'];
	$data_show_count = $twitter_follow_button_options['data_show_count'];
	$data_button = $twitter_follow_button_options['data_button'];
	$data_text_color = $twitter_follow_button_options['data_text_color']; //800080
	$data_link_color = $twitter_follow_button_options['data_link_color']; //800080
	$lang = $twitter_follow_button_options['lang'];
	//$creditOn = $twitter_follow_button_options['creditOn'];

	$htmlCode ="<div style='$cssStyle'>";
	$htmlCode .= "<a href=\"http://twitter.com/$screen_name\" class=\"twitter-follow-button\" data-show-count=\"$data_show_count\" data-button=\"$data_button\" data-text-color=\"$data_text_color\" data-link-color=\"$data_link_color\" data-lang=\"$lang\">Follow @$screen_name</a>\n";
	$htmlCode .= "<script src=\"http://platform.twitter.com/widgets.js\" type=\"text/javascript\"></script>";
	if ($creditOn == "true") {
		$htmlCode .= "<a href=\"http://cmsvoteup.com/category/wordpress-plugins/\" title=\"Get Twitter Follow Button Wordpress Plugin\" target=\"_blank\"><img src=\"http://www.cmsvoteup.com/images/power_by_2x2.gif\" border=\"0\"/></a>"; 
	}
	$htmlCode .="</div>";
			
	$twitter_follow_button = $htmlCode;

	echo $twitter_follow_button;
}

// function for adding settings page to wp-admin
function twitter_follow_button_settings() {
	add_options_page('Twitter Follow Button', 'Twitter Follow Button', 9, basename(__FILE__), 'twitter_follow_button_options_form');
}

function twitter_follow_button_options_form(){ 
	global $twitter_follow_button_options;
?>

<div class="wrap">

<div id="poststuff" class="metabox-holder has-right-sidebar" style="float:right;width:30%;"> 
   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About this Plugin:</span></h3> 
			  <div class="inside">
                <ul>
					<li><a href="http://www.cmsvoteup.com" title="Vote Up your Wordpress Website" >CMS Vote Up!</a></li>
					<li><a href="http://cmsvoteup.com/all/category/wordpress-plugins/" title="Vote or Download Other plugins">Vote & Download Other Plugins</a></li>					
                </ul> 
              </div> 
			</div> 
     </div>
 </div>


<form method="post" action="options.php">

<?php settings_fields('twitter_follow_button_options_group'); ?>

<h2>Twitter Follow Button Options</h2> 

<table class="form-table" style="clear:none;width:70%;">

<tr valign="top">
<th scope="row">Where Twitter Follow Button will be displayed:</th>
<td><select name="twitter_follow_button_options[position_button]" id="position_button" >
<option value="before" <?php if ($twitter_follow_button_options['position_button'] == "before"){ echo "selected";}?> >Before Content</option>
<option value="after" <?php if ($twitter_follow_button_options['position_button'] == "after"){ echo "selected";}?> >After Content</option>
<option value="before_and_after" <?php if ($twitter_follow_button_options['position_button'] == "before_and_after"){ echo "selected";}?> >Before and After</option>
<option value="manual" <?php if ($twitter_follow_button_options['position_button'] == "manual"){ echo "selected";}?> >Manual Insertion</option>
</select><br/>
<b>Note:</b> &nbsp;You can also use this tag <code>add_twitter_follow_button();</code> for manually insert button to any of your post item.
</td>
</tr>

<tr valign="top">
<th scope="row">Custom CSS for &lt;div&gt; (i.e. float: right;):</th>
<td><input id="own_css" name="twitter_follow_button_options[own_css]" value="<?php echo $twitter_follow_button_options['own_css']; ?>"></td>
</td>
</tr>

<tr valign="top">
<th scope="row">What's your user name?</th>
<td><input size="32" id="screen_name" name="twitter_follow_button_options[screen_name]" value="<?php echo $twitter_follow_button_options['screen_name']; ?>"></td>
</td>
</tr>


<tr valign="top">
<th scope="row">What color background will be used?</th>
<td><select name="twitter_follow_button_options[data_button]" id="data_button" >
<option value="grey" <?php if ($twitter_follow_button_options['data_button'] == "grey"){ echo "selected";}?> >dark</option>
<option value="blue" <?php if ($twitter_follow_button_options['data_button'] == "blue"){ echo "selected";}?> >light</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Text color?</th>
<td><input size="10" id="screen_name" name="twitter_follow_button_options[data_text_color]" value="<?php echo $twitter_follow_button_options['data_text_color']; ?>"></td>
</td>
</tr>

<tr valign="top">
<th scope="row">Link color?</th>
<td><input size="10" id="screen_name" name="twitter_follow_button_options[data_link_color]" value="<?php echo $twitter_follow_button_options['data_link_color']; ?>"></td>
</td>
</tr>


<tr valign="top">
<th scope="row">Show follower count?</th>
<td><select name="twitter_follow_button_options[data_show_count]" id="data_show_count" >
<option value="true" <?php if ($twitter_follow_button_options['data_show_count'] == "true"){ echo "selected";}?> >true</option>
<option value="false" <?php if ($twitter_follow_button_options['data_show_count'] == "false"){ echo "selected";}?> >false</option>
</select>
</td>
</tr>


<tr valign="top">
<th scope="row">Language options</th>
<td>
<select name="twitter_follow_button_options[lang]" id="lang" >
	<option value="en" <?php if ($twitter_follow_button_options['lang'] == "en"){ echo "selected";}?> >English</option>
	<option value="fr" <?php if ($twitter_follow_button_options['lang'] == "fr"){ echo "selected";}?> >French</option>
	<option value="de" <?php if ($twitter_follow_button_options['lang'] == "de"){ echo "selected";}?> >German</option>
	<option value="it" <?php if ($twitter_follow_button_options['lang'] == "it"){ echo "selected";}?> >Italian</option>
	<option value="ja" <?php if ($twitter_follow_button_options['lang'] == "ja"){ echo "selected";}?> >Japanese</option>
	<option value="ko" <?php if ($twitter_follow_button_options['lang'] == "ko"){ echo "selected";}?> >Korean</option>
	<option value="ru" <?php if ($twitter_follow_button_options['lang'] == "ru"){ echo "selected";}?> >Russian</option>
	<option value="es" <?php if ($twitter_follow_button_options['lang'] == "es"){ echo "selected";}?> >Spanish</option>
	<option value="tr" <?php if ($twitter_follow_button_options['lang'] == "tr"){ echo "selected";}?> >Turkish</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Show Vote Up Link:</th>
<td><select name="twitter_follow_button_options[creditOn]" id="creditOn" >
<option value="true" <?php if ($twitter_follow_button_options['creditOn'] == "true"){ echo "selected";}?> >true</option>
<option value="false" <?php if ($twitter_follow_button_options['creditOn'] == "false"){ echo "selected";}?> >false</option>
</select>
</td>
</tr>


</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

</div>
<?php }

// Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'twitter_follow_button_settings');
  add_action( 'admin_init', 'register_twitter_follow_button_settings' ); 
} 
function register_twitter_follow_button_settings() { // whitelist options
  register_setting( 'twitter_follow_button_options_group', 'twitter_follow_button_options' );
}

?>