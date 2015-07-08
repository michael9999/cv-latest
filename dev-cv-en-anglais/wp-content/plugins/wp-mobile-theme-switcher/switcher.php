<?php

	/*
	* Plugin Name: WP Mobile Theme Switcher
	* Description: Select and configure different themes for mobile devices and desktop computers
	* Author: Wiziapp Solutions Ltd.
	* Version: v1.0.1
	* Author URI: http://www.wiziapp.com/
	*/

	class WordpressMobileThemeSwitcherHook
	{
		var $template;
		var $stylesheet;

		function install()
		{
			add_option('wordpress-mobile-theme-switcher', array());
		}

		function uninstall()
		{
			delete_option('wordpress-mobile-theme-switcher');
		}

		function plugins_loaded()
		{
			if (is_admin())
			{
				add_action('admin_init', array(&$this, 'admin_init'));
				add_action('admin_menu', array(&$this, 'admin_menu'));

				if ($GLOBALS['pagenow'] !== 'customize.php' && ($GLOBALS['pagenow'] !== 'admin-ajax.php' || $_REQUEST['action'] !== 'customize_save'))
				{
					return;
				}

				// Trick customize to think this is the current theme, so it doesn't try to switch
				$theme = isset($_REQUEST['theme'])?$_REQUEST['theme']:null;
				if ($theme && ($parent = $this->_theme_get_parent($theme)))
				{
					$this->stylesheet = $theme;
					$this->template = $parent;
					add_filter('template', array(&$this, 'template'), 99);
					add_filter('stylesheet', array(&$this, 'stylesheet'), 99);
				}

				return;
			}

			$options = ((array) get_option('wordpress-mobile-theme-switcher'))+array('mobile' => '', 'tablet' => '');
			$theme = '';
			switch ($this->_get_device_type())
			{
				case 'mobile':
					$theme = strval($options['mobile']);
					break;
				case 'tablet':
					$theme = strval($options['tablet']);
					break;
			}
			if (empty($theme) || !($parent = $this->_theme_get_parent($theme)))
			{
				return;
			}
			$this->stylesheet = $theme;
			$this->template = $parent;
			add_filter('template', array(&$this, 'template'), 99);
			add_filter('stylesheet', array(&$this, 'stylesheet'), 99);
		}

		function admin_init()
		{
			if (!current_user_can('switch_themes') || !isset($_POST['action']) || $_POST['action'] !== 'wordpress-mobile-theme-switcher' || !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wordpress-mobile-theme-switcher'))
			{
				return;
			}

			foreach (array('mobile', 'tablet') as $type)
			{
				if (isset($_POST['configure_'.$type]) && isset($_POST['theme_'.$type]))
				{
					wp_redirect($this->_configure_url($_POST['theme_'.$type]));
					exit;
				}
			}

			if (isset($_POST['submit']) && isset($_POST['theme_mobile']) && isset($_POST['theme_tablet']))
			{
				update_option('wordpress-mobile-theme-switcher', array('mobile' => $_POST['theme_mobile'], 'tablet' => $_POST['theme_tablet']));
				wp_redirect($this->_admin_url());
				exit;
			}
		}

		function admin_menu()
		{
			add_menu_page('WP Mobile Theme Switcher', 'Mobile Theme Switcher', 'switch_themes', 'wordpress-mobile-theme-switcher', array(&$this, 'admin_menu_page'));
		}

		function admin_menu_page()
		{
			$themes = $this->_get_themes();

			$options = ((array) get_option('wordpress-mobile-theme-switcher'))+array('mobile' => '', 'tablet' => '');
?>
<form action="<?php echo esc_html($this->_admin_url()); ?>" method="post">
	<div class="wrap">
		<h2>WP Mobile Theme Switcher</h2>

		<input type="hidden" name="action" value="wordpress-mobile-theme-switcher" />
		<input type="hidden" name="nonce" value="<?php echo esc_html(wp_create_nonce('wordpress-mobile-theme-switcher')); ?>" />
		<h3>Smartphone theme</h3>
		<select name="theme_mobile">
<?php
			foreach ($themes as $name => $title)
			{
				$selected = ($name === $options['mobile'])?' selected="selected"':'';
?>
			<option value="<?php echo esc_html($name); ?>"<?php echo $selected; ?>><?php echo esc_html($title); ?></option>
<?php
			}
?>
		</select>
		<?php submit_button('Configure', 'small', 'configure_mobile', false); ?>

		<h3>Tablet theme</h3>
		<select name="theme_tablet">
<?php
			foreach ($themes as $name => $title)
			{
				$selected = ($name === $options['tablet'])?' selected="selected"':'';
?>
			<option value="<?php echo esc_html($name); ?>"<?php echo $selected; ?>><?php echo esc_html($title); ?></option>
<?php
			}
?>
		</select>
		<?php submit_button('Configure', 'small', 'configure_tablet', false); ?>

		<?php submit_button(); ?>

		<!--/* OpenX Javascript Tag v2.8.10 */-->
		<!--<script type='text/javascript'><!--//<![CDATA[
			var m3_u = (location.protocol=='https:'?'https://50.56.70.210/openx/www/delivery/ajs.php':'http://50.56.70.210/openx/www/delivery/ajs.php');
			var m3_r = Math.floor(Math.random()*99999999999);
			if (!document.MAX_used) document.MAX_used = ',';
			document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			document.write ("?zoneid=256");
			document.write ('&amp;cb=' + m3_r);
			if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
			document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
			document.write ("&amp;loc=" + escape(window.location));
			if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
			if (document.context) document.write ("&context=" + escape(document.context));
			if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
			document.write ("'><\/scr"+"ipt>");
		//]]></script>-->
	</div>
</form>
<?php
		}

		function template()
		{
			return $this->template;
		}

		function stylesheet()
		{
			return $this->stylesheet;
		}

		function _get_device_type()
		{
			if (!isset($_SERVER['HTTP_USER_AGENT']))
			{
				return 'unknown';
			}

			$is_iPhone	= stripos($_SERVER['HTTP_USER_AGENT'], 'iPhone')  !== FALSE && stripos($_SERVER['HTTP_USER_AGENT'], 'Mac OS X')	   !== FALSE;
			$is_iPod	= stripos($_SERVER['HTTP_USER_AGENT'], 'iPod')    !== FALSE && stripos($_SERVER['HTTP_USER_AGENT'], 'Mac OS X')	   !== FALSE;
			$is_android	= stripos($_SERVER['HTTP_USER_AGENT'], 'Android') !== FALSE && stripos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit') !== FALSE;
			$is_windows	= stripos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== FALSE && stripos($_SERVER['HTTP_USER_AGENT'], 'IEMobile')	   !== FALSE && stripos($_SERVER['HTTP_USER_AGENT'], 'Phone') !== FALSE;
			$is_iPad	= stripos($_SERVER['HTTP_USER_AGENT'], 'iPad')    !== FALSE || stripos($_SERVER['HTTP_USER_AGENT'], 'webOS') 	   !== FALSE;

			if ($is_iPad)
			{
				return 'tablet';
			}
			else if ($is_iPhone || $is_iPod || $is_android || $is_windows)
			{
				return 'mobile';
			}
			return 'desktop';
		}

		function _theme_get_parent($theme)
		{
			$theme_root = get_theme_root($theme);
			$theme_dir = "$theme_root/$theme";
			if (!file_exists($theme_dir.'/style.css'))
			{
				return false;
			}

			if (function_exists('wp_get_theme'))
			{
				$theme_data = wp_get_theme($theme);
				if (!$theme_data->exists())
				{
					return false;
				}
				$parent = $theme_data->get_template();
			}
			else
			{
				$theme_data = get_theme_data($theme);
				if (!$theme_data)
				{
					return;
				}
				$parent = isset($theme_data['Template'])?$theme_data['Template']:false;
			}
			if (!$parent)
			{
				$parent = $theme;
			}

			if ($parent === $theme)
			{
				$parent_dir = $theme_dir;
			}
			else
			{
				$parent_root = get_theme_root($parent);
				$parent_dir = "$parent_root/$parent";
				if (!file_exists($parent_dir.'/style.css'))
				{
					return false;
				}
			}

			if (!file_exists($parent_dir.'/index.php'))
			{
				return false;
			}

			return $parent;
		}

		function _get_themes()
		{
			$ret = array('' => 'Same as desktop');
			if (function_exists('wp_get_themes'))
			{
				$themes = wp_get_themes();
				foreach ($themes as $theme => $data)
				{
					$ret[$theme] = $data['Title'];
				}
			}
			else
			{
				$themes = get_themes();
				foreach ($themes as $theme => $data)
				{
					$ret[$data['Stylesheet']] = $data['Title'];
				}
			}
			return $ret;
		}

		function _configure_url($theme)
		{
			return $this->_admin_url('customize.php?return='.urlencode($this->_admin_url()).($theme?'&theme='.urlencode($theme):''));
		}

		function _admin_url($path = 'admin.php?page=wordpress-mobile-theme-switcher')
		{
			if (function_exists('admin_url'))
			{
				return admin_url($path);
			}
			return trailingslashit(get_bloginfo('wpurl')).'wp-admin/'.$path;
		}
	}

	add_action('plugins_loaded', array(new WordpressMobileThemeSwitcherHook(), 'plugins_loaded'));
	register_activation_hook(plugin_basename(__FILE__), array('WordpressMobileThemeSwitcherHook', 'install'));
	register_deactivation_hook(plugin_basename(__FILE__), array('WordpressMobileThemeSwitcherHook', 'uninstall'));
