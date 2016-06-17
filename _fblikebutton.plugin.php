<?php
/**
 * This file implements the Text Resizer plugin for {@link http://b2evolution.net/}.
 *
 * @copyright (c)2010 by Emin Özlem - {@link http://eodepo.com/}.
 *
 * @license GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *
 * @package plugins
 *
 * @author Emin Özlem
 *
 * @version $Id:  $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * fblikebutton Plugin *
 * 'Allows you to add a quick facebook like button to your posts [iframe-not fbml]';
 *
 */
class fblikebutton_plugin extends Plugin
{
	var $author = 'Emin Özlem';
	var $code = 'fblikebutton';
	var $apply_rendering = 'stealth';
	var $group = 'eodepo';
	var $help_url = 'http://www.eodepo.com';
	var $name = 'FB Like Button';
	var $long_desc = 'Allows you to add a quick facebook like button to your posts [iframe-not fbml]';
	var $short_desc = 'Add FB Like button.';
	var $number_of_installs = 1;
	var $priority = 60;
	var $version = '1.0';
	var $extra_info = 'test?';

	function PluginInit( & $params )
	{
		$this->name = $this->T_('FB Like Button');
		$this->short_desc = $this->T_('Add FB Like button.');
		$this->long_desc = $this->T_('Allows you to add a quick facebook like button to your posts [iframe-not fbml]');
	}

	function GetDefaultSettings( & $params )
	{
		$DefSet = array(

			'fblb_layout' => array(
				'label' => T_('Layout Style'),
				'note' => 'determines the size and amount of social context next to the button.default is standart.',
				'defaultvalue' => 'standard',
				'options' => array( 'standard' => $this->T_('standard'), 'button_count' => $this->T_('button_count'), 'box_count' => $this->T_('box_count'), ),
				'type' => 'select',
			),
			'fblb_width' => array(
				'label' => 'Width',
				'defaultvalue' => '450',
				'note' => 'the width of the plugin in pixels valid range: 1-999, default is : 450',
				'valid_range' => array( 'min'=>1, 'max'=>9999 ),
			),
			'fblb_height' => array(
				'label' => 'Height',
				'defaultvalue' => '35',
				'note' => 'the height of the plugin in pixels.Recommended values; standart: 35, button_count: 23, box_count:90  valid range: 1-99, default is : 35',
				'valid_range' => array( 'min'=>1, 'max'=>99 ),
			),

			'fblb_showfaces' => array(
				'label' => T_('Show Faces?'),
				'note' => T_('Show profile pictures below the button.Enabled by default'),
				'defaultvalue' => 'true',
				'options' => array( 'true' => $this->T_('Yes'), 'false' => $this->T_('No'), ),
				'type' => 'select',
			),
			'fblb_verb' => array(
				'label' => T_('Verb to display'),
				'note' => 'The verb to display in the button. Currently only "like" and "recommend" are supported.Default is like.',
				'defaultvalue' => 'like',
				'options' => array( 'like' => $this->T_('like'), 'recommend' => $this->T_('recommend'), ),
				'type' => 'select',
			),
			'fblb_color_scheme' => array(
				'label' => T_('Color Scheme'),
				'note' => 'The Color Scheme of the plugin.',
				'defaultvalue' => 'like',
				'options' => array( 'light' => $this->T_('light'), 'dark' => $this->T_('dark'), ),
				'type' => 'select',
			),
			'fblb_font' => array(
				'label' => T_('Font'),
				'note' => 'the font of the plugin.Default is arial.',
				'defaultvalue' => 'arial',
				'options' => array( 'arial' => $this->T_('Arial'), 'lucida+grande' => $this->T_('Lucida Grande'), 'segoe+ui' => $this->T_('Segoe UI'), 'tahoma' => $this->T_('Tahoma'), 'trebuchet+ms' => $this->T_('Trebuchet Ms'), 'verdana' => $this->T_('Verdana'), ),
				'type' => 'select',
			),
			'fblb_ba' => array(
				'label' => T_('Before / After content ?'),
				'note' => 'Would you like to display the like button before / after the content ?',
				'defaultvalue' => 'before',
				'options' => array( 'before' => $this->T_('before'), 'after' => $this->T_('after'), ),
				'type' => 'select',
			),
			'fblb_ac' => array(
				'label' => T_('Css Class'),
				'note' => 'Css class to customize the button -position possibly-',
				'defaultvalue' => 'fbiframediv',
			),

		);

		return $DefSet;

	}

	function BeforeEnable()
	{
		return true ;
	}

	function RenderItemAsHtml( & $params )
	{	global $baseurl;
		$fblb_layout = $this->Settings->get( 'fblb_layout' );
		$fblb_width = $this->Settings->get( 'fblb_width' );
		$fblb_showfaces = $this->Settings->get( 'fblb_showfaces' );
		$fblb_verb = $this->Settings->get( 'fblb_verb' );
		$fblb_color_scheme = $this->Settings->get( 'fblb_color_scheme' );
		$fblb_font = $this->Settings->get( 'fblb_font' );
		$fblb_height = $this->Settings->get( 'fblb_height' );
		$fblb_ba = $this->Settings->get( 'fblb_ba' );
		$fblb_ac = $this->Settings->get( 'fblb_ac' );
		$PID = $params['Item']->ID;
		$fblbutton = '<div class="'.$fblb_ac.'"><iframe src="http://www.facebook.com/plugins/like.php?app_id=194259500619894&amp;href='.$baseurl.'index.php?p='.$PID.'&amp;send=false';
		if($fblb_layout != 'standard')
		{
			$fblbutton .= '&amp;layout='.$fblb_layout;

		}
		$fblbutton .= '&amp;width='.$fblb_width.'&amp;show_faces='.$fblb_showfaces.'&amp;action='.$fblb_verb.'&amp;colorscheme='.$fblb_color_scheme.'&amp;font='.$fblb_font.'&amp;height='.$fblb_height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$fblb_width.'px; height:'.$fblb_height.'px;" allowTransparency="true"></iframe></div>';
		$contentt = & $params['data'];

		if($fblb_ba == 'before') { $contentt = $fblbutton.$contentt;	}
		if($fblb_ba == 'after') { $contentt = $contentt.$fblbutton;	}


	}

	function get_widget_param_definitions( $params )
	{
		$r = array(
			'fb_like_what' => array(
				'label' => 'Like What ?',
				'id' => $this->classname.'_fb_like_what',
				'onchange' => 'document.getElementById("'.$this->classname.'_fb_url_to_like").disabled = ( this.value == "currpage" );',
				'defaultvalue' => 'currpage',
				'type' => 'select',
				'options' => array( 'currpage' => 'Current Page', 'custom' => 'Custom URL' ),
				'note' => 'Like whichever the page the visitor is on, or use an enforced url to like.',
			),
			'fb_url_to_like' => array(
				'label' => 'URL to like',
				'id' => $this->classname.'_fb_url_to_like',
				//'size' => '105',
				//		'disabled' => true, // this can be useful if you detect that something cannot be changed. You probably want to add a 'note' then, too.
				'note' => 'Change the Like What to custom to activate.',
			),

			'fblbw_layout' => array(
				'label' => T_('Layout Style'),
				'note' => 'determines the size and amount of social context next to the button.default is standart.',
				'defaultvalue' => 'standard',
				'options' => array( 'standard' => $this->T_('standard'), 'button_count' => $this->T_('button_count'), 'box_count' => $this->T_('box_count'), ),
				'type' => 'select',
			),
			'fblbw_width' => array(
				'label' => 'Width',
				'defaultvalue' => '450',
				'note' => 'the width of the plugin in pixels valid range: 1-999, default is : 450',
				'valid_range' => array( 'min'=>1, 'max'=>9999 ),
			),
			'fblbw_height' => array(
				'label' => 'Height',
				'defaultvalue' => '35',
				'note' => 'the height of the plugin in pixels.Recommended values; standart: 35, button_count: 23, box_count:90  valid range: 1-99, default is : 35',
				'valid_range' => array( 'min'=>1, 'max'=>99 ),
			),

			'fblbw_showfaces' => array(
				'label' => T_('Show Faces?'),
				'note' => T_('Show profile pictures below the button.Enabled by default'),
				'defaultvalue' => 'true',
				'options' => array( 'true' => $this->T_('Yes'), 'false' => $this->T_('No'), ),
				'type' => 'select',
			),
			'fblbw_verb' => array(
				'label' => T_('Verb to display'),
				'note' => 'The verb to display in the button. Currently only "like" and "recommend" are supported.Default is like.',
				'defaultvalue' => 'like',
				'options' => array( 'like' => $this->T_('like'), 'recommend' => $this->T_('recommend'), ),
				'type' => 'select',
			),
			'fblbw_color_scheme' => array(
				'label' => T_('Color Scheme'),
				'note' => 'The Color Scheme of the plugin.',
				'defaultvalue' => 'like',
				'options' => array( 'light' => $this->T_('light'), 'dark' => $this->T_('dark'), ),
				'type' => 'select',
			),
			'fblbw_font' => array(
				'label' => T_('Font'),
				'note' => 'the font of the plugin.Default is arial.',
				'defaultvalue' => 'arial',
				'options' => array( 'arial' => $this->T_('Arial'), 'lucida+grande' => $this->T_('Lucida Grande'), 'segoe+ui' => $this->T_('Segoe UI'), 'tahoma' => $this->T_('Tahoma'), 'trebuchet+ms' => $this->T_('Trebuchet Ms'), 'verdana' => $this->T_('Verdana'), ),
				'type' => 'select',
			),
			'fblbw_ba' => array(
				'label' => T_('Before / After content ?'),
				'note' => 'Would you like to display the like button before / after the content ?',
				'defaultvalue' => 'before',
				'options' => array( 'before' => $this->T_('before'), 'after' => $this->T_('after'), ),
				'type' => 'select',
			),
			'fblbw_ac' => array(
				'label' => T_('Css Class'),
				'note' => 'Css class to customize the button -position possibly-',
				'defaultvalue' => 'fbwiframediv',
			),

		);

		if( $this->Settings->get('fb_like_what') == 'custom' )
		{
			$r['fb_url_to_like']['disabled'] = false;
		}
		return $r;
	}

	/* like widget */
	function SkinTag( & $params )
	{
		global $basedomain;
		$fblbw_layout = $params['fblbw_layout'];
		$fblbw_width = $params['fblbw_width'];
		$fblbw_showfaces = $params['fblbw_showfaces'];
		$fblbw_verb = $params['fblbw_verb'];
		$fblbw_color_scheme = $params['fblbw_color_scheme'];
		$fblbw_font = $params['fblbw_font'];
		$fblbw_height = $params['fblbw_height'];
		$fblbw_ba = $params['fblbw_ba'];
		$fblbw_ac = $params['fblbw_ac'];
		$fblbw_likeurl = $params['fb_url_to_like'];
		$fblbw_like_what = $params['fb_like_what'];
		global $ReqURI;
		echo $params['block_start']."\n";
		echo $params['block_title_start'];

		$fblbwutton = '<div class="'.$fblbw_ac.'"><iframe src="http://www.facebook.com/plugins/like.php?app_id=194259500619894&amp;href=';
		if($fblbw_like_what == 'custom' && ! empty($fblbw_likeurl) )
		{
			$fblbwutton .= $fblbw_likeurl;
		}
		else
		{
			$fblbwutton .= 'http://'.$basedomain.$ReqURI;
		}
		$fblbwutton .= '&amp;send=false';
		if($fblbw_layout != 'standard')
		{
			$fblbwutton .= '&amp;layout='.$fblbw_layout;

		}
		$fblbwutton .= '&amp;width='.$fblbw_width.'&amp;show_faces='.$fblbw_showfaces.'&amp;action='.$fblbw_verb.'&amp;colorscheme='.$fblbw_color_scheme.'&amp;font='.$fblbw_font.'&amp;height='.$fblbw_height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$fblbw_width.'px; height:'.$fblbw_height.'px;" allowTransparency="true"></iframe></div>';

		echo $fblbwutton;
		echo $params['block_end']."\n";

		return ( true ) ;

	}

	/**
	 * Do the same as for HTML.
	 *
	 * @see RenderItemAsHtml()
	 */
	function RenderItemAsXml( & $params )
	{
		$this->RenderItemAsHtml( $params );
	}

	/**
	 * @version 1.5: Added a widget as well, tiny bug fixes.
	 * @version 1.0: initial release
	 * @31.05.2011
	 * @author Emin Özlem
	 */
}

?>