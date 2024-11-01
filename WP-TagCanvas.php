<?php
/*
 Plugin Name: WP-TagCanvas
Plugin URI: http://harryxu.net
Description: Get a 3D Tag cloud by TagCanvas(http://www.goat1000.com/tagcanvas.php).TagCanvas is a Javascript class which will draw and animate a HTML5 canvas based tag cloud. It support three shape:sphere, hcylinder for a cylinder that starts off horizontal and vcylinder for a cylinder that starts off vertical. Based on TagCanvas version 1.12.
Version: 1.3.1
Author: Harry Xu
Author URI: http://harryxu.net
Update Server: http://harryxu.net
License: LGPL v3

WP-TagCanvas is a plugin using Javascript class which will draw and animate a HTML5 canvas based tag cloud. It support three shape
*/

add_action('wp_head', 'wpTagCanvasHead');
function wpTagCanvasPage(){
	echo '<form method="post">';
	echo "<div class=\"wrap\"><h2>Tag Cloud by HTML5 Canvas Options</h2>";
	echo '<p>说明：本来哥都不想写设置页的，但是要显得专业一点么亲~未来准备在这个页面把TagCanvas</p>';
	echo '<p>欢迎访问作者<a href="http://harryxu.net" target="_blank">Harry Xu的博客</a>提意见~!</p>';
	echo "</div>";
	echo '</form>';
}
function wpTagCanvasInstall(){
	$tag_option = get_option('tag_Canvas_options');
	$tag_option['title'] ='Tag Cloud';
	$tag_option['width'] ='260';
	$tag_option['height'] ='260';
	$tag_option['textColour'] ='ff0000';
	$tag_option['outlineColour'] ='ff00ff';
	$tag_option['reverse'] ='true';
	$tag_option['maxspeed'] ='0.04';
	$tag_option['shape'] ='sphere';
	$tag_option['weight_mode'] ='size';
	$tag_option['weight_size'] ='1.0';
	$tag_option['weight_colour'] ='00ff00';
	add_option('tag_Canvas_options',$tag_option);
}
function wpTagCanvasUninstall(){
	delete_option('tag_Canvas_options');
}


function wpTagCanvasHead(){
	$nowoption = get_option('tag_Canvas_options');
	$tcolor = attribute_escape($nowoption['textColour']);
	$olcolor = attribute_escape($nowoption['outlineColour']);
	$reverse = attribute_escape($nowoption['reverse']);
	$speed = attribute_escape($nowoption['maxspeed']);
	$shape = attribute_escape($nowoption['shape']);
	$weight_mode = attribute_escape($nowoption['weight_mode']);
	$weight_size = attribute_escape($nowoption['weight_size']);
	$weight_colour = attribute_escape($nowoption['weight_colour']);
	$wcolor_1=sprintf("%06x",((base_convert($tcolor,16,10)-base_convert($weight_colour,16,10))/3)+base_convert($weight_colour,16,10));
	$wcolor_2=sprintf("%06x",((base_convert($tcolor,16,10)-base_convert($weight_colour,16,10))*2/3)+base_convert($weight_colour,16,10));
	?>
<script
	src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-tagcanvas/tagcanvas.js"
	type="text/javascript"></script>


	<?php echo '<script type="text/javascript">'; ?>
	<?php echo 'var tcolor=\'#'.$tcolor.'\';'; ?>
	<?php echo 'var olcolor=\'#'.$olcolor.'\';'; ?>
	<?php echo 'var reverse='.$reverse.';'; ?>
	<?php echo 'var speed='.$speed.';'; ?>
	<?php echo 'var shape=\''.$shape.'\';'; ?>
	<?php echo 'var weight_mode=\''.$weight_mode.'\';'; ?>
	<?php echo 'var weight_size='.$weight_size.';'; ?>
	<?php echo 'var wcolor=\'#'.$weight_colour.'\';'; ?>
	<?php echo 'var weight_colour={0:\'#'.$weight_colour.'\', 0.33:\'#'.$wcolor_2.'\',0.66:\'#'.$wcolor_1.'\', 1:\'#'.$tcolor.'\'}'; ?>

function addLoadEvent(your_function) { if (window.attachEvent)
{window.attachEvent('onload', your_function);} else if
(window.addEventListener) {window.addEventListener('load',
your_function, false);} else {document.addEventListener('load',
your_function, false);} } function tagcloud_load() { try {
TagCanvas.maxSpeed = speed; TagCanvas.textColour = tcolor;
TagCanvas.outlineColour = olcolor; TagCanvas.reverse=true;
TagCanvas.shape=shape;
if((weight_mode=="size")||(weight_mode=="colour")||(weight_mode=="both")){
TagCanvas.weight=true; TagCanvas.weightMode=weight_mode;
TagCanvas.weightSize=weight_size;
TagCanvas.weightGradient=weight_colour; }
TagCanvas.Start('tag_canvas','tag_html5'); } catch(err) { } }


addLoadEvent(tagcloud_load);

</script>


<?php
}

/*			WIDGET			*/

function wpTagCanvasLoad(){
	//Check for required functions
	if (!function_exists('register_sidebar_widget'))
	return;

	function wpTagCanvasCtrl(){
		$tag_option = get_option('tag_Canvas_options');
		if ( $_POST["wpTagCanvas_widget_submit"] ) {
			$tag_option['title'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_title"]));
			$tag_option['width'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_width"]));
			$tag_option['height'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_height"]));
			$tag_option['textColour'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_tcolor"]));
			$tag_option['outlineColour'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_olcolor"]));
			$tag_option['maxspeed'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_speed"]));
			$tag_option['shape'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_shape"]));;
			$tag_option['weight_mode'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_weight_mode"]));
			$tag_option['weight_size'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_weight_size"]));
			$tag_option['weight_colour'] =strip_tags(stripslashes($_POST["wpTagCanvas_widget_weight_colour"]));
			update_option('tag_Canvas_options',$tag_option);
		}
		$title = attribute_escape($tag_option['title']);
		$width = attribute_escape($tag_option['width']);
		$height = attribute_escape($tag_option['height']);
		$tcolor = attribute_escape($tag_option['textColour']);
		$olcolor = attribute_escape($tag_option['outlineColour']);
		$speed = attribute_escape($tag_option['maxspeed']);
		$shape = attribute_escape($tag_option['shape']);
		$weight_mode = attribute_escape($tag_option['weight_mode']);
		$weight_size = attribute_escape($tag_option['weight_size']);
		$weight_colour = attribute_escape($tag_option['weight_colour']);

		?>
<p>
	<label for="wpTagCanvas_widget_title"><?php _e('Title:'); ?> <input
		class="widefat" id="wpTagCanvas_widget_title"
		name="wpTagCanvas_widget_title" type="text"
		value="<?php echo $title; ?>" /> </label>
</p>
<p>
	<label for="wpTagCanvas_widget_width"><?php _e('Width:'); ?> <input
		class="widefat" id="wpTagCanvas_widget_width"
		name="wpTagCanvas_widget_width" type="text"
		value="<?php echo $width; ?>" /> </label>
</p>
<p>
	<label for="wpTagCanvas_widget_height"><?php _e('Height:'); ?> <input
		class="widefat" id="wpTagCanvas_widget_height"
		name="wpTagCanvas_widget_height" type="text"
		value="<?php echo $height; ?>" /> </label>
</p>
<p>
	<label for="wpTagCanvas_widget_tcolor"><?php _e('Text Color:'); ?> <input
		class="widefat" id="wpTagCanvas_widget_tcolor"
		name="wpTagCanvas_widget_tcolor" type="text"
		value="<?php echo $tcolor; ?>" /> </label>
</p>
<p>
	<label for="wpTagCanvas_widget_olcolor"><?php _e('Outline Color:'); ?>
		<input class="widefat" id="wpTagCanvas_widget_olcolor"
		name="wpTagCanvas_widget_olcolor" type="text"
		value="<?php echo $olcolor; ?>" /> </label>
</p>
<p>
	<label for="wpTagCanvas_widget_speed"><?php _e('Max Speed:'); ?> <input
		class="widefat" id="wpTagCanvas_widget_speed"
		name="wpTagCanvas_widget_speed" type="text"
		value="<?php echo $speed; ?>" /> </label>
</p>
<p>

<?php _e('Shape:'); ?>
	<br /> <input class="radio" id="wpTagCanvas_widget_shape"
		name="wpTagCanvas_widget_shape" type="radio" value="sphere"



		<?php if( $shape == "sphere" ){ echo ' checked="checked"'; } ?>>
	sphere<br /> <input class="radio" id="wpTagCanvas_widget_shape"
		name="wpTagCanvas_widget_shape" type="radio" value="hcylinder"



		<?php if( $shape == "hcylinder" ){ echo ' checked="checked"'; } ?>>
	hcylinder<br /> <input class="radio" id="wpTagCanvas_widget_shape"
		name="wpTagCanvas_widget_shape" type="radio" value="vcylinder"



		<?php if( $shape == "vcylinder" ){ echo ' checked="checked"'; } ?>>
	vcylinder
</p>
<p>

<?php _e('Weight Mode:'); ?>
	<br /> <input class="radio" id="wpTagCanvas_widget_weight_mode"
		name="wpTagCanvas_widget_weight_mode" type="radio" value="off"



		<?php if( $weight_mode == "off" ){ echo ' checked="checked"'; } ?>>
	off<br /> <input class="radio" id="wpTagCanvas_widget_weight_mode"
		name="wpTagCanvas_widget_weight_mode" type="radio" value="size"



		<?php if( $weight_mode == "size" ){ echo ' checked="checked"'; } ?>>
	size<br /> <input class="radio" id="wpTagCanvas_widget_weight_mode"
		name="wpTagCanvas_widget_weight_mode" type="radio" value="colour"



		<?php if( $weight_mode == "colour" ){ echo ' checked="checked"'; } ?>>
	colour<br /> <input class="radio" id="wpTagCanvas_widget_weight_mode"
		name="wpTagCanvas_widget_weight_mode" type="radio" value="both"



		<?php if( $weight_mode == "both" ){ echo ' checked="checked"'; } ?>>
	both
</p>
<p>
	<label for="wpTagCanvas_widget_weight_size"><?php _e('Size Weight:'); ?>
		<input class="widefat" id="wpTagCanvas_widget_weight_size"
		name="wpTagCanvas_widget_weight_size" type="text"
		value="<?php echo $weight_size; ?>" /> </label>
</p>
<p>
	<label for="wpTagCanvas_widget_weight_colour"><?php _e('Color for popular tag:'); ?>
		<input class="widefat" id="wpTagCanvas_widget_weight_colour"
		name="wpTagCanvas_widget_weight_colour" type="text"
		value="<?php echo $weight_colour; ?>" /> </label>
</p>
<input
	type="hidden" id="wpTagCanvas_widget_submit"
	name="wpTagCanvas_widget_submit" value="1" />

	<?php
	}

	function wpTagCanvasWidget($args){
		extract($args);
		$options=get_option('tag_Canvas_options');
		$title = attribute_escape($options['title']);
		$width = attribute_escape($options['width']);
		$height = attribute_escape($options['height']);
		echo $before_widget;
		if( $title )
		echo $before_title . $title . $after_title;?>
<div id="tag_html5" width="<?php echo $width;?>"
	height="<?php echo $height;?>" hidden>


	<?php wp_tag_cloud(); ?>
</div>
<canvas width="<?php echo $width;?>" height="<?php echo $height;?>"
	id="tag_canvas">
					</canvas>


					<?php
					echo $after_widget;
	}

	register_sidebar_widget('Tag Cloud by HTML5 Canvas', 'wpTagCanvasWidget');
	register_widget_control( "Tag Cloud by HTML5 Canvas", "wpTagCanvasCtrl" );
}

// Delay plugin execution until sidebar is loaded
add_action('widgets_init', 'wpTagCanvasLoad');

// add the actions
register_activation_hook( __FILE__, 'wpTagCanvasInstall' );
register_deactivation_hook( __FILE__, 'wpTagCanvasUninstall' );
?>