<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Tag Manager Container ID
    |--------------------------------------------------------------------------
    | Format: GTM-XXXXXXX
    | Jika menggunakan GTM, set ini dan kosongkan ga4_id.
    | GTM akan mengelola GA4 dan tag lainnya dari satu tempat.
    | Cara mendapatkan: https://tagmanager.google.com
    */
    'gtm_id' => env('GTM_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Analytics 4 Measurement ID
    |--------------------------------------------------------------------------
    | Format: G-XXXXXXXXXX
    | Gunakan ini jika TIDAK menggunakan GTM.
    | Cara mendapatkan: https://analytics.google.com → Admin → Data Streams
    */
    'ga4_id' => env('GA4_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Google Search Console Verification
    |--------------------------------------------------------------------------
    | Kode verifikasi dari Google Search Console.
    | Cara mendapatkan:
    |   1. Buka https://search.google.com/search-console
    |   2. Add Property → pilih URL prefix → masukkan domain
    |   3. Pilih metode "HTML tag"
    |   4. Salin hanya nilai content="..." (bukan seluruh tag)
    |   5. Masukkan ke .env: GOOGLE_SITE_VERIFICATION=xxxxxxxx
    */
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION', ''),

    /*
    |--------------------------------------------------------------------------
    | Bing Webmaster Tools Verification
    |--------------------------------------------------------------------------
    | Cara mendapatkan: https://www.bing.com/webmasters
    */
    'bing_site_verification' => env('BING_SITE_VERIFICATION', ''),

    /*
    |--------------------------------------------------------------------------
    | Default OG Image
    |--------------------------------------------------------------------------
    | Gambar default yang digunakan saat share di sosial media.
    | Ukuran ideal: 1200x630px, format PNG/JPG.
    */
    'default_og_image' => env('DEFAULT_OG_IMAGE', '/images/og-rakira.png'),

    /*
    |--------------------------------------------------------------------------
    | Site Name
    |--------------------------------------------------------------------------
    */
    'site_name' => env('APP_NAME', 'Rakira Digital Nusantara'),

];
