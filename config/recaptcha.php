<?php

/**
 * reCAPTCHA v3 configuration for Laravel
 */
return [

    /**
     * The site key
     * Get site key @ www.google.com/recaptcha/admin
     */
    'api_site_key' => env('RECAPTCHA_SITE_KEY'),

    /**
     * The secret key
     * Get secret key @ www.google.com/recaptcha/admin
     */
    'api_secret_key' => env('RECAPTCHA_SECRET_KEY'),

    /**
     * ReCAPTCHA version
     * Always v3 for this configuration
     */
    'version' => 'v3',

    /**
     * The minimum score threshold for reCAPTCHA v3
     * Range: 0.0 to 1.0 (1.0 is very likely a good interaction, 0.0 is very likely a bot)
     */
    'minimum_score' => env('RECAPTCHA_MIN_SCORE', 0.5),

    /**
     * The curl timeout in seconds to validate a recaptcha token
     */
    'curl_timeout' => 10,

    /**
     * IP addresses for which validation will be skipped
     * IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     */
    'skip_ip' => env('RECAPTCHA_SKIP_IP', []),

    /**
     * Set API domain. You can use "www.recaptcha.net" in case "www.google.com" is not accessible.
     * @see https://developers.google.com/recaptcha/docs/faq#can-i-use-recaptcha-globally
     */
    'api_domain' => 'www.google.com',
];