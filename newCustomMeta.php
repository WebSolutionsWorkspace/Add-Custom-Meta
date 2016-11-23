<?php
/*
Plugin Name: New Custom Meta
Plugin URI: http://wordpress.org
Description: Добавляет дополнительные возможности метаполям, для отображения содержимогов зависимости от мобильного User Agent браузера (iOS / Android / WM7)
Author:
Version: 1.0.0
Author URI: http://example.com
*/
define('PLUGIN_DIR', plugin_dir_path(__FILE__));
require_once(PLUGIN_DIR . 'lib/Mobile_Detect.php');

// довавляем опцию  ключ - значение
add_option('mobile_option', 'mobile_meta');
add_option('desktop_option', 'desktop_meta');


    function scripts_()
    {
        wp_register_script('custom-script', plugins_url('/js/custom-script.js', __FILE__));
    }
    add_action('wp_enqueue_scripts', 'scripts_', 5);

    function mt_add_pages()
    {
        add_options_page('Test Options', 'New Custom Meta', 8, 'new_custom_meta', 'mt_options_page');
    }
    add_action('admin_menu', 'mt_add_pages');

    function Save()
    {
        //update_option('mobile_option', $_POST['mobile_id'], 'no');
        //update_option('desktop_option', $_POST['desktop_id'], 'no');

        if ( get_option('mobile_option') != ''    ) {
            update_option( 'mobile_option', $_POST['mobile_id'] );
        }

        if ( get_option('desktop_option') != ''    ) {
            update_option( 'desktop_option', $_POST['desktop_id'] );
        }


        var_dump($_POST);

    }

    function mt_options_page()
    {
        echo "<br/>";

        echo "<h2>Настройки: </h2>";
        echo '
        <form name = "settingCustomMeta" action="/wp-admin/options-general.php?page=new_custom_meta" method = "post">
          Meta name for mobile:<br>
          <input type="text" name="mobile_id" value="' . get_option('mobile_option') . '">
          <br>
          Meta name for desktop:<br>
          <input type="text" name="desktop_id" value="' . get_option('desktop_option') . '">
          <br><br>
          <input type="submit" value="Save">
        </form> ';
        Save();
        DetectDevise();
    }

    function DetectDevise()
    {
        $detect = new Mobile_Detect;
        $isMobile = $detect->isMobile();
        $isTablet = $detect->isTablet();

        $layoutType = ($isMobile ? ($isTablet ? 'Tablet' : 'Mobile') : 'Desktop');
        echo "<br/>";
        echo "Текущее устройство: " . $layoutType;
    }




#1. Пример регистрации шоткода [custom_meta wrap="iframe"]:

function meta_func( $atts ) {
	 return "wrap = {$atts['wrap']}";
}
add_shortcode('custom_meta', 'meta_func');



?>
