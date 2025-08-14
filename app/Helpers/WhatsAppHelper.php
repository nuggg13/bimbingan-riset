<?php

namespace App\Helpers;

class WhatsAppHelper
{
    /**
     * Generate WhatsApp URL for sending message
     */
    public static function generateWhatsAppUrl($phoneNumber, $message = '')
    {
        // Clean phone number - remove spaces, dashes, and other characters
        $cleanNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        // Convert +62 to 62 if present
        if (strpos($cleanNumber, '+62') === 0) {
            $cleanNumber = '62' . substr($cleanNumber, 3);
        }
        
        // Ensure it starts with 62
        if (strpos($cleanNumber, '62') !== 0) {
            $cleanNumber = '62' . ltrim($cleanNumber, '0');
        }
        
        // URL encode the message
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$cleanNumber}?text={$encodedMessage}";
    }

    /**
     * Generate message for contacting mentor
     */
    public static function generateMentorContactMessage($pesertaName, $judulRiset)
    {
        return "Halo, saya {$pesertaName}, peserta bimbingan riset dengan judul \"{$judulRiset}\". Saya ingin berkonsultasi mengenai riset saya. Terima kasih.";
    }

    /**
     * Generate message for schedule discussion
     */
    public static function generateScheduleDiscussionMessage($pesertaName, $judulRiset, $currentSchedule = null)
    {
        $baseMessage = "Halo, saya {$pesertaName}, peserta bimbingan riset dengan judul \"{$judulRiset}\".";
        
        if ($currentSchedule) {
            return $baseMessage . " Saya ingin mendiskusikan jadwal bimbingan yang saat ini terjadwal pada {$currentSchedule}. Apakah bisa diatur ulang? Terima kasih.";
        } else {
            return $baseMessage . " Saya ingin mendiskusikan dan mengatur jadwal bimbingan riset. Kapan waktu yang tepat untuk bimbingan? Terima kasih.";
        }
    }

    /**
     * Format phone number for display
     */
    public static function formatPhoneNumber($phoneNumber)
    {
        // Clean phone number
        $cleanNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        // If it starts with +62, keep it as is
        if (strpos($cleanNumber, '+62') === 0) {
            return $cleanNumber;
        }
        
        // If it starts with 62, add +
        if (strpos($cleanNumber, '62') === 0) {
            return '+' . $cleanNumber;
        }
        
        // If it starts with 0, replace with +62
        if (strpos($cleanNumber, '0') === 0) {
            return '+62' . substr($cleanNumber, 1);
        }
        
        // Otherwise, assume it needs +62 prefix
        return '+62' . $cleanNumber;
    }
}