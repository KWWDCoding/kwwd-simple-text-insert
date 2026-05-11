<?php
/**
 * Plugin Name: Simple Text Insert by KWWD
 * Plugin URI:  https://kwwdcoding.github.io/kwwd-simple-text-insert/index.html
 * Description: Insert predefined text snippets and shortcodes into the WordPress editor.
 * Version:     1.2.0
 * Author:      KWWD
 * License:     GPL3
 * Licence URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Update URI: https://raw.githubusercontent.com/KWWDCoding/kwwd-simple-text-insert/main/assets/';
 * Text Domain: kww-simple-text-insert
 */

defined( 'ABSPATH' ) || exit;
define( 'QTI_VERSION', '1.2.0' );

/**************************************************************
 * UPDATE CHECKER (GITHUB Method)
 *************************************************************/
// Use the RAW content URL from GitHub
$githubAssets = 'https://raw.githubusercontent.com/KWWDCoding/kwwd-simple-text-insert/main/assets/';

require_once plugin_dir_path(__FILE__) . 'includes/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/KWWDCoding/kwwd-simple-text-insert/',
    __FILE__,
    'kwwd-simple-text-insert'
);
// Since you're using GitHub's "Releases" feature to host the ZIPs:
$myUpdateChecker->getVcsApi()->enableReleaseAssets();

/** PLUGIN ICONS ***/
$myUpdateChecker->addResultFilter(function($info) use ($githubAssets) {
    if ($info) {
        $info->icons = array(
            '1x'      => $githubAssets . 'icon-128x128.png',
            '2x'      => $githubAssets . 'icon-256x256.png', // Optional
            'default' => $githubAssets . 'icon-128x128.png',
        );
    }
    return $info;
});
/***************** END PLUGIN UPDATE **************************/



define( 'QTI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QTI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once QTI_PLUGIN_DIR . 'includes/class-admin.php';
require_once QTI_PLUGIN_DIR . 'includes/class-tinymce.php';
require_once QTI_PLUGIN_DIR . 'includes/class-gutenberg.php';

new QTI_Admin();
new QTI_TinyMCE();
new QTI_Gutenberg();
