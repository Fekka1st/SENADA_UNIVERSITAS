<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mews\Captcha\Facades\Captcha;

class HybridCaptchaService
{
    private $siteKey;
    private $secretKey;
    private $minScore;

    public function __construct()
    {
        $this->siteKey = config('recaptcha.api_site_key');
        $this->secretKey = config('recaptcha.api_secret_key');
        $this->minScore = config('recaptcha.minimum_score', 0.5); // Minimum score untuk reCAPTCHA v3
    }

    /**
     * Get the site key for frontend
     */
    public function getSiteKey(): string
    {
        return $this->siteKey;
    }

    /**
     * Verify hybrid CAPTCHA (reCAPTCHA v3 with alphanumeric fallback)
     */
    public function verify(string $recaptchaToken = null, string $alphanumericCaptcha = null, string $ip = null): array
    {
        // Jika ada token reCAPTCHA, coba verifikasi dulu
        if (!empty($recaptchaToken)) {
            $recaptchaResult = $this->verifyRecaptchaV3($recaptchaToken, $ip);
            
            if ($recaptchaResult['success']) {
                // reCAPTCHA v3 berhasil
                Session::forget('show_numeric_captcha');
                return [
                    'success' => true,
                    'type' => 'recaptcha_v3',
                    'score' => $recaptchaResult['score'] ?? null,
                    'message' => 'reCAPTCHA verification successful'
                ];
            } else {
                // reCAPTCHA v3 gagal, fallback ke alphanumeric CAPTCHA
                Session::put('show_numeric_captcha', true);
                
                if (!empty($alphanumericCaptcha)) {
                    return $this->verifyAlphanumericCaptcha($alphanumericCaptcha);
                } else {
                    return [
                        'success' => false,
                        'type' => 'fallback_required',
                        'message' => 'reCAPTCHA failed, alphanumeric CAPTCHA required'
                    ];
                }
            }
        }

        // Jika tidak ada token reCAPTCHA tapi ada alphanumeric CAPTCHA
        if (!empty($alphanumericCaptcha)) {
            return $this->verifyAlphanumericCaptcha($alphanumericCaptcha);
        }

        // Tidak ada CAPTCHA yang diberikan
        return [
            'success' => false,
            'type' => 'missing',
            'message' => 'No CAPTCHA provided'
        ];
    }

    /**
     * Verify reCAPTCHA v3 token
     */
    private function verifyRecaptchaV3(string $token, string $ip = null): array
    {
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->secretKey,
                'response' => $token,
                'remoteip' => $ip
            ]);

            $result = $response->json();

            if ($response->successful() && $result['success'] === true) {
                $score = $result['score'] ?? 0;
                
                // Check if score meets minimum threshold
                if ($score >= $this->minScore) {
                    return [
                        'success' => true,
                        'score' => $score,
                        'action' => $result['action'] ?? null
                    ];
                } else {
                    Log::info('reCAPTCHA v3 score too low', [
                        'score' => $score,
                        'minimum_required' => $this->minScore
                    ]);
                    
                    return [
                        'success' => false,
                        'score' => $score,
                        'reason' => 'score_too_low'
                    ];
                }
            } else {
                Log::warning('reCAPTCHA v3 verification failed', [
                    'error_codes' => $result['error-codes'] ?? []
                ]);
                
                return [
                    'success' => false,
                    'error_codes' => $result['error-codes'] ?? []
                ];
            }
        } catch (RequestException $e) {
            Log::error('reCAPTCHA v3 API request failed', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'reason' => 'api_error'
            ];
        }
    }

    /**
     * Verify alphanumeric CAPTCHA using mews/captcha
     */
    private function verifyAlphanumericCaptcha(string $input): array
    {
        try {
            if (Captcha::check($input)) {
                Session::forget('show_numeric_captcha');
                return [
                    'success' => true,
                    'type' => 'alphanumeric_captcha',
                    'message' => 'Alphanumeric CAPTCHA verification successful'
                ];
            } else {
                return [
                    'success' => false,
                    'type' => 'alphanumeric_captcha',
                    'message' => 'Alphanumeric CAPTCHA verification failed'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Alphanumeric CAPTCHA verification error', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'type' => 'alphanumeric_captcha',
                'message' => 'Alphanumeric CAPTCHA verification error'
            ];
        }
    }

    /**
     * Check if alphanumeric CAPTCHA should be shown
     */
    public function shouldShowAlphanumericCaptcha(): bool
    {
        return Session::get('show_numeric_captcha', false);
    }

    /**
     * Generate alphanumeric CAPTCHA HTML
     */
    public function getAlphanumericCaptchaHtml(): string
    {
        return Captcha::img('flat');
    }

    /**
     * Get alphanumeric CAPTCHA source URL
     */
    public function getAlphanumericCaptchaSrc(): string
    {
        return Captcha::src('flat');
    }

    /**
     * Reset CAPTCHA state
     */
    public function reset(): void
    {
        Session::forget('show_numeric_captcha');
    }
}