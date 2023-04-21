<?php

return [
    /**
     * Styles to import.
     */
    'styles' => [
        'bootstrap_style' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css',
        'prismjs' => CONFIG[ 'ASSETS_URL' ] . 'vendor/prismjs/prism.css',
        'custom_style' => CONFIG[ 'ASSETS_URL' ] . 'css/style.css',
    ],
    /**
     * Scripts to import.
     */
    'scripts' => [
        'bootstrap_script' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js',
        'prismjs' => CONFIG[ 'ASSETS_URL' ] . 'vendor/prismjs/prism.js',
    ],
];