<?php
return [
    /**
     * Max Memory (php.ini override) for Intervention Image Resizing
     * @docs https://www.php.net/manual/en/ini.core.php#ini.memory-limit
     */
    'memory' => '256M',

    /**
     * Max Intervention Image Output Quality
     * before Image Optimizer is run.
     * @docs http://image.intervention.io/api/save
     */
    'max_quality' => 75,

    /**
     * Intervention Image Max Dimensions
     * @docs http://image.intervention.io/api/resize
     */
    'max_width' => 1024,
    'max_height' => 768,

    /**
     * Maximum characters before trimmed.
     * @docs https://stackoverflow.com/questions/6870824/what-is-the-maximum-length-of-a-filename-in-s3
     */
    'max_filename' => 250,

    /**
     * Allow site wide configuration of default toolbar
     */
    'default_ck_toolbar' => [
        'heading', '|',
        'alignment', '|',
        'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
        'link', '|',
        'bulletedList', 'numberedList', 'todoList',
        '-', // break point
        'fontfamily', 'fontsize', 'fontColor', '|',
        'codeBlock', '|',
        'insertTable', '|',
        'outdent', 'indent', '|',
        'mediaBrowser', 'blockQuote', '|',
        'undo', 'redo', '|', 'sourceEditing'
    ],

    /**
     * Allow site wide configuration of default code blocks
     */
    'default_ck_code_block' => [
        ['language' => 'plaintext', 'label' => 'Plain Text'],
        ['language' => 'c', 'label' => 'C'],
        ['language' => 'cs', 'label' => 'C#'],
        ['language' => 'cpp', 'label' => 'C++'],
        ['language' => 'css', 'label' => 'CSS'],
        ['language' => 'diff', 'label' => 'Diff'],
        ['language' => 'html', 'label' => 'HTML'],
        ['language' => 'java', 'label' => 'Java'],
        ['language' => 'javascript', 'label' => 'JavaScript'],
        ['language' => 'php', 'label' => 'PHP'],
        ['language' => 'python', 'label' => 'Python'],
        ['language' => 'ruby', 'label' => 'Ruby'],
        ['language' => 'typescript', 'label' => 'TypeScript'],
        ['language' => 'xml', 'label' => 'XML'],
    ],
];
