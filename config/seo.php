<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Settings
    |--------------------------------------------------------------------------
    */
    'default_image' => '/assets/images/og-image.svg',

    'keywords' => 'online tools, free tools, pdf tools, seo tools, developer tools, nexora tools',

    // Optional Twitter handle, e.g. '@nexoratools'
    'twitter' => null,

    /*
    |--------------------------------------------------------------------------
    | Programmatic SEO seeds
    |--------------------------------------------------------------------------
    | These drive /services, /industry and /solutions landing pages.
    */
    'services' => [
        'pdf-workflows' => [
            'name' => 'PDF Workflows',
            'summary' => 'Convert, compress, split, and secure PDFs in your browser.',
            'benefits' => ['No uploads saved', 'One-click actions', 'Works on any device'],
            'cta_tool' => 'compress-pdf',
            'faqs' => [
                ['q' => 'Is the PDF processing secure?', 'a' => 'All actions run in-browser; files are not persisted on our servers.'],
                ['q' => 'What file size limits apply?', 'a' => 'Most tools support files up to 50MB; compression can lower this further.'],
            ],
        ],
        'document-security' => [
            'name' => 'Document Security',
            'summary' => 'Lock, unlock, and sanitize PDFs for safe sharing.',
            'benefits' => ['Password add/remove', 'Reduces risk of leaks', 'Audit-friendly'],
            'cta_tool' => 'lock-unlock-pdf',
            'faqs' => [
                ['q' => 'Can I remove a forgotten password?', 'a' => 'If you own the file and know the password, you can unlock and re-save.'],
                ['q' => 'Do you keep unlocked copies?', 'a' => 'No. Files stay local to your browser session.'],
            ],
        ],
    ],

    'industries' => [
        'legal' => [
            'name' => 'Legal & Compliance',
            'summary' => 'Bundle exhibits, paginate filings, and compress evidence securely.',
            'benefits' => ['Bates-like pagination', 'Evidence-size compression', 'Redaction-ready exports'],
            'cta_tool' => 'pdf-merger',
        ],
        'education' => [
            'name' => 'Education',
            'summary' => 'Prepare assignments, merge notes, and export scans to searchable PDFs.',
            'benefits' => ['OCR for scans', 'Small email-friendly files', 'Browser-based for Chromebooks'],
            'cta_tool' => 'pdf-to-word',
        ],
    ],

    'solutions' => [
        'remote-teams' => [
            'name' => 'Remote Team Enablement',
            'summary' => 'Standardize document sharing flows for distributed teams.',
            'benefits' => ['No installs needed', 'Share-ready outputs', 'Templateable actions'],
            'cta_tool' => 'pdf-merger',
        ],
        'immigration' => [
            'name' => 'Immigration & Visa Packs',
            'summary' => 'Compress, merge, and order visa documentation for online portals.',
            'benefits' => ['Keeps under size limits', 'Clean ordering', 'Secure handling'],
            'cta_tool' => 'compress-pdf',
        ],
    ],
];
