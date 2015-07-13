<?php
function custom_login() {?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jqm.css" />
<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/login.js"></script>
<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/jq/jqm-latest.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/login.css" /> 
<?php }
add_action('login_head', 'custom_login');
?>