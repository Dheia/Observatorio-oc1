<?php

namespace Tresfera\Taketsystem\Classes\Libs;

class Pusher
{
    /**
     * API URL.
     */
    const GOOGLE_GCM_URL = 'https://android.googleapis.com/gcm/send';

    /**
     * API Key.
     *
     * @var string
     */
    const API_KEY = '';

    /**
     * @param string|array $regIds
     * @param string       $action
     * @param string       $content
     *
     * @throws \Exception
     *
     * @return object
     */
    public static function notify($regIds, $action, $content = null)
    {
        // Data
        $fields = [
            'registration_ids' => is_string($regIds) ? [$regIds] : $regIds,
            'data'             => [
                'message' => [
                    'action' => $action,
                    'content' => $content,
                ],
            ],
        ];

        $data = json_encode($fields, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

        // cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::GOOGLE_GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key='.self::API_KEY,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if ($result === false) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);

        return json_decode($result);
    }
}
