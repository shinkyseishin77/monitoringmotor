<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp_lib {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('whatsapp', TRUE);
    }

    /**
     * Send text message via WhatsApp Gateway
     *
     * @param string $wa_number The destination number (e.g., 628...)
     * @param string $message The message content
     * @return bool True if successful, False otherwise
     */
    public function send_text($wa_number, $message) {
        $base_url = rtrim($this->CI->config->item('wa_base_url', 'whatsapp'), '/');
        $session_id = $this->CI->config->item('wa_session_id', 'whatsapp');
        $auth_token = $this->CI->config->item('wa_auth_token', 'whatsapp');

        $url = "{$base_url}/api/sessions/{$session_id}/send-text";

        $payload = json_encode([
            'wa_number' => $wa_number,
            'message'   => $message
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $auth_token
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10 seconds timeout
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        
        curl_close($ch);

        if ($curl_error) {
            log_message('error', 'WhatsApp Gateway cURL Error: ' . $curl_error);
            return false;
        }

        if ($http_code >= 200 && $http_code < 300) {
            return true;
        } else {
            log_message('error', "WhatsApp Gateway API Error (HTTP {$http_code}): " . $response);
            return false;
        }
    }

    /**
     * Format and send aduan notification to admin
     *
     * @param array $data_aduan Data array containing nama_pelapor, no_hp, isi_aduan
     * @return bool True if successful, False otherwise
     */
    public function send_aduan_notification($data_aduan) {
        $admin_number = $this->CI->config->item('wa_admin_number', 'whatsapp');
        
        if (empty($admin_number)) {
            log_message('error', 'WhatsApp Gateway: wa_admin_number is not set in config.');
            return false;
        }

        // Set timezone ke Jakarta khusus untuk pesan ini
        $tz = new DateTimeZone('Asia/Jakarta');
        $dt = new DateTime('now', $tz);
        $waktu = $dt->format('d-m-Y H:i');
        $nama = isset($data_aduan['nama_pelapor']) ? $data_aduan['nama_pelapor'] : '-';
        $isi = isset($data_aduan['isi_aduan']) ? $data_aduan['isi_aduan'] : '-';

        $message = "📢 *ADUAN BARU MASUK*\n";
        $message .= "━━━━━━━━━━━━━━━━━━\n\n";
        $message .= "👤 *Pelapor:* {$nama}\n\n";
        $message .= "📝 *Isi Aduan:*\n";
        $message .= "{$isi}\n\n";
        $message .= "🕐 *Waktu:* {$waktu}\n";
        $message .= "━━━━━━━━━━━━━━━━━━\n";
        $message .= "_Pesan ini dikirim otomatis oleh Sistem Monitoring. Mohon untuk tidak membalas pesan ini._\n";
        $message .= "_Jika ingin memproses aduan, silakan login ke website: https://motor.technomedic.id_";

        return $this->send_text($admin_number, $message);
    }
}
