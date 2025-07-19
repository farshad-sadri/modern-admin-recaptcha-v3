<?php
/*
Plugin Name: Modern Admin ReCAPTCHA v3
Plugin URI: https://github.com/farshad-sadri/modern-admin-recaptcha-v3
Description: A modern YOURLS plugin that integrates Google reCAPTCHA v3 into the admin login screen, effectively blocking spam bots by analyzing user behavior and enforcing a minimum trust score.
Version: 1.0
Author: Farshad Sadri
Author URI: https://github.com/farshad-sadri
*/

if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Validate reCAPTCHA before processing login
yourls_add_action( 'pre_login_username_password', 'adminnorecaptcha_validate_recaptcha_v3' );
function adminnorecaptcha_validate_recaptcha_v3() {
    $secret = yourls_get_option('adminnorecaptcha_priv_key');
    $token = $_POST['recaptcha_token'] ?? '';

    if (!$secret || !$token) {
        yourls_login_screen('reCAPTCHA token or secret key missing');
        die();
    }

    $data = [
        'secret' => $secret,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $opts = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
        ]
    ];

    $context  = stream_context_create($opts);
    $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
    $result = json_decode($result, true);

    if (empty($result['success']) || $result['score'] < 0.5 || $result['action'] !== 'admin_login') {
        yourls_login_screen('reCAPTCHA verification failed or suspicious activity detected');
        die();
    }
}

// Add plugin settings page to admin
yourls_add_action( 'plugins_loaded', 'adminnorecaptcha_init' );
function adminnorecaptcha_init() {
    yourls_register_plugin_page( 'adminnorecaptcha', 'Modern ReCAPTCHA Settings', 'adminnorecaptcha_config_page' );
}

// Admin settings UI
function adminnorecaptcha_config_page() {
    if( isset( $_POST['adminnorecaptcha_public_key'] ) ) {
        yourls_verify_nonce( 'adminnorecaptcha_nonce' );
        adminnorecaptcha_save_admin();
    }

    $nonce = yourls_create_nonce( 'adminnorecaptcha_nonce' );
    $pubkey = yourls_get_option( 'adminnorecaptcha_pub_key', "" );
    $privkey = yourls_get_option( 'adminnorecaptcha_priv_key', "" );
    echo '<h2>Modern Admin ReCAPTCHA v3 Settings</h2>';
    echo '<form method="post">';
    echo '<input type="hidden" name="nonce" value="' . $nonce . '" />';
    echo '<p><label for="adminnorecaptcha_public_key">reCAPTCHA v3 Site Key: </label>';
    echo '<input type="text" id="adminnorecaptcha_public_key" name="adminnorecaptcha_public_key" value="' . $pubkey . '"></p>';  
    echo '<p><label for="adminnorecaptcha_private_key">reCAPTCHA v3 Secret Key: </label>';
    echo '<input type="text" id="adminnorecaptcha_private_key" name="adminnorecaptcha_private_key" value="' . $privkey . '"></p>';
    echo '<input type="submit" value="Save"/>';
    echo '</form>';
}

// Save keys to database
function adminnorecaptcha_save_admin() {
    $pubkey = $_POST['adminnorecaptcha_public_key'];
    $privkey = $_POST['adminnorecaptcha_private_key'];

    if ( yourls_get_option( 'adminnorecaptcha_pub_key' ) !== false ) {
        yourls_update_option( 'adminnorecaptcha_pub_key', $pubkey );
    } else {
        yourls_add_option( 'adminnorecaptcha_pub_key', $pubkey );
    }

    if ( yourls_get_option( 'adminnorecaptcha_priv_key' ) !== false ) {
        yourls_update_option( 'adminnorecaptcha_priv_key', $privkey );
    } else {
        yourls_add_option( 'adminnorecaptcha_priv_key', $privkey );
    }

    echo "Saved";
}

// Inject reCAPTCHA v3 JS on login page
yourls_add_action( 'html_head', 'adminnorecaptcha_add_v3_script' );
function adminnorecaptcha_add_v3_script() {
    $siteKey = yourls_get_option( 'adminnorecaptcha_pub_key' );
    if (!$siteKey) return;
    echo <<<EOD
<script src="https://www.google.com/recaptcha/api.js?render=$siteKey"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById("login")) {
        grecaptcha.ready(function() {
            grecaptcha.execute('$siteKey', {action: 'admin_login'}).then(function(token) {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'recaptcha_token';
                input.value = token;
                document.getElementById('login').appendChild(input);
            });
        });
    }
});
</script>
EOD;
}
?>
