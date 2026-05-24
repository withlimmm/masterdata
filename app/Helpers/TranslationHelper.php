<?php

if (!function_exists('__t')) {
    /**
     * Translate dynamic text based on current locale.
     * Supports JSON/array bilingual payloads and legacy delimiters like "Indonesian || English".
     *
     * @param string|null $text
     * @return string
     */
    function __t($text)
    {
        if (empty($text)) {
            return '';
        }

        $locale = app()->getLocale();

        if (is_array($text) || is_object($text)) {
            $data = (array) $text;
            return trim((string) ($data[$locale] ?? $data['id'] ?? $data['en'] ?? reset($data) ?? ''));
        }

        if (is_string($text)) {
            $decoded = json_decode($text, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return trim((string) ($decoded[$locale] ?? $decoded['id'] ?? $decoded['en'] ?? reset($decoded) ?? ''));
            }
        }

        $delimiters = ['||', '[EN]'];
        foreach ($delimiters as $delim) {
            if (strpos($text, $delim) !== false) {
                $parts = explode($delim, $text);
                if ($locale === 'en') {
                    return trim($parts[1] ?? $parts[0]);
                } else {
                    return trim($parts[0]);
                }
            }
        }

        return $text;
    }
}
