<?php
/*
Plugin Name: PhoneTrack Meu Site Manager
Description: Adiciona o script da <a href="https://phonetrack.app/account/integracao/script" target="_blank">integração do Meu Site</a> para substituir automaticamente os números de telefone das suas páginas pelos do PhoneTrack.
Version: 0.1.1
Author: PhoneTrack
Author URI: suporte@phonetrack.com.br
Text Domain: phonetrack-meu-site-manager
*/

function isValidMd5($md5 ='') {
  return preg_match('/^[a-f0-9]{32}$/', $md5);
}

function pht_activate_phtmanager() {
  add_option('pht_id', '');
}

function pht_deactive_phtmanager() {
  delete_option('pht_id');
}

function pht_admin_init_phtmanager() {
  register_setting('phtmanager', 'pht_id');
}

function pht_options_page_phtmanager() {
  include(WP_PLUGIN_DIR.'/phonetrack-meu-site-manager/options.php');
}

function pht_admin_menu_phtmanager() {
  add_options_page(
    'PhoneTrack Meu Site Manager',
    'PhoneTrack Meu Site Manager',
    'manage_options',
    'phtmanager',
    'pht_options_page_phtmanager'
  );
}

function pht_add_script_enqueue() {
  $pht_id = get_option('pht_id');
  if(empty($pht_id) === false && isValidMd5($pht_id)) {
    wp_enqueue_script(
      'script-phonetrack',
      'https://phonetrack-static.s3.sa-east-1.amazonaws.com/'.$pht_id.'.js'
    );
  }
}

function pht_add_data_attribute($tag, $handle) {
   if ('script-phonetrack' !== $handle )
       return $tag;
   return str_replace(' src', ' id="script-pht-phone" data-cookiedays="5" src', $tag);
}

function pht_load_plugin_textdomain() {
    load_plugin_textdomain( 'phonetrack-meu-site-manager', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'pht_load_plugin_textdomain' );

register_activation_hook(__FILE__, 'pht_activate_phtmanager');
register_deactivation_hook(__FILE__, 'pht_deactive_phtmanager');

if (is_admin()) {
  add_action('admin_init', 'pht_admin_init_phtmanager');
  add_action('admin_menu', 'pht_admin_menu_phtmanager');
}

add_filter('script_loader_tag', 'pht_add_data_attribute', 10, 2);
add_action('wp_enqueue_scripts', 'pht_add_script_enqueue');
