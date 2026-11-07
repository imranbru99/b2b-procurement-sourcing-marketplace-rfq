<?php

$demoPassword = 'password';

$demoLogins = [
    ['label' => 'Super administrator', 'email' => 'superadmin@demo.test', 'password' => $demoPassword, 'panel' => 'superadmin', 'path' => '/platform'],
    ['label' => 'Platform manager', 'email' => 'platform.manager@demo.test', 'password' => $demoPassword, 'panel' => 'platform-manager', 'path' => '/platform'],
    ['label' => 'Support', 'email' => 'support@demo.test', 'password' => $demoPassword, 'panel' => 'support', 'path' => '/platform'],
    ['label' => 'Finance', 'email' => 'finance@demo.test', 'password' => $demoPassword, 'panel' => 'finance', 'path' => '/platform'],
    ['label' => 'KYC', 'email' => 'kyc@demo.test', 'password' => $demoPassword, 'panel' => 'kyc', 'path' => '/platform'],
    ['label' => 'Buyer admin', 'email' => 'buyer.admin@demo.test', 'password' => $demoPassword, 'panel' => 'buyer-admin', 'path' => '/buyer'],
    ['label' => 'Procurement', 'email' => 'procurement@demo.test', 'password' => $demoPassword, 'panel' => 'procurement', 'path' => '/buyer'],
    ['label' => 'Requester', 'email' => 'requester@demo.test', 'password' => $demoPassword, 'panel' => 'requester', 'path' => '/buyer'],
    ['label' => 'Approver', 'email' => 'approver@demo.test', 'password' => $demoPassword, 'panel' => 'approver', 'path' => '/buyer'],
    ['label' => 'Accounts payable', 'email' => 'ap@demo.test', 'password' => $demoPassword, 'panel' => 'ap', 'path' => '/buyer'],
    ['label' => 'Receiver', 'email' => 'receiver@demo.test', 'password' => $demoPassword, 'panel' => 'receiver', 'path' => '/buyer'],
    ['label' => 'Auditor', 'email' => 'auditor@demo.test', 'password' => $demoPassword, 'panel' => 'auditor', 'path' => '/buyer'],
    ['label' => 'Supplier admin', 'email' => 'supplier.admin@demo.test', 'password' => $demoPassword, 'panel' => 'supplier-admin', 'path' => '/supplier'],
    ['label' => 'Supplier sales', 'email' => 'supplier.sales@demo.test', 'password' => $demoPassword, 'panel' => 'supplier-sales', 'path' => '/supplier'],
    ['label' => 'Catalog manager', 'email' => 'supplier.catalog@demo.test', 'password' => $demoPassword, 'panel' => 'supplier-catalog', 'path' => '/supplier'],
    ['label' => 'Supplier finance', 'email' => 'supplier.finance@demo.test', 'password' => $demoPassword, 'panel' => 'supplier-finance', 'path' => '/supplier'],
    ['label' => 'Logistics', 'email' => 'logistics@demo.test', 'password' => $demoPassword, 'panel' => 'logistics', 'path' => '/logistics'],
    ['label' => 'Inspector', 'email' => 'inspector@demo.test', 'password' => $demoPassword, 'panel' => 'inspector', 'path' => '/logistics'],
];

return [

    'demo' => (bool) env('APP_DEMO', false),

    'rtl_locales' => [],

    'supported_locales' => ['en', 'bn'],

    'demo_logins' => $demoLogins,

    'blog_posts' => [
        [
            'slug' => 'rfq-best-practices-2026',
            'published_at' => '2026-01-15',
            'author' => 'Imran Ahmed',
            'title' => [
                'en' => 'RFQ best practices for B2B procurement teams',
                'bn' => 'বিটুবি ক্রয় দলের জন্য আরএফকিউ সেরা অনুশীলন',
            ],
            'excerpt' => [
                'en' => 'Structure clear requirements, publish transparent deadlines, and compare bids with weighted scorecards—not gut feel.',
                'bn' => 'স্পষ্ট প্রয়োজনীয়তা, স্বচ্ছ সময়সীমা, এবং ওজনযুক্ত স্কোরকার্ডে তুলনা করুন।',
            ],
            'body' => [
                'en' => '<p>Great RFQs start with a single buyer owner, a published timeline, and line items suppliers can price without guesswork. Use public visibility when you want marketplace reach; keep addenda versioned so every bidder sees the same facts.</p><p>When evaluation begins, separate commercial, technical, and compliance scores. That discipline shortens award cycles and reduces disputes later in purchase order and goods receipt flows.</p>',
                'bn' => '<p>ভালো আরএফকিউ শুরু হয় একজন দায়িত্বশীল ক্রেতা, প্রকাশিত সময়রেখা এবং স্পষ্ট লাইন আইটেম দিয়ে। বাজারে বিস্তৃত প্রসার চাইলে পাবলিক ভিজিবিলিটি ব্যবহার করুন।</p>',
            ],
        ],
        [
            'slug' => 'supplier-discovery-checklist',
            'published_at' => '2026-02-02',
            'author' => 'Imran Ahmed',
            'title' => [
                'en' => 'A practical supplier discovery checklist',
                'bn' => 'সরবরাহকারী আবিষ্কারের ব্যবহারিক চেকলিস্ট',
            ],
            'excerpt' => [
                'en' => 'Verify capacity, certifications, and prior buyer references before you invite vendors to bid.',
                'bn' => 'বিড আমন্ত্রণের আগে ক্ষমতা, সনদপত্র ও রেফারেন্স যাচাই করুন।',
            ],
            'body' => [
                'en' => '<p>Directory profiles should answer where a supplier operates, what categories they serve, and whether they are verified on the platform. Favor suppliers with complete storefronts and recent reviews.</p><p>Discovery is not a one-time search—save categories and let the marketplace notify you when new matches appear.</p>',
                'bn' => '<p>ডিরেক্টরি প্রোফাইলে অবস্থান, ক্যাটাগরি ও যাচাইকরণ থাকা উচিত। সম্পূর্ণ স্টোরফ্রন্ট ও সাম্প্রতিক রিভিউ সম্পন্ন সরবরাহকারীকে অগ্রাধিকার দিন।</p>',
            ],
        ],
        [
            'slug' => 'modular-procurement-platform',
            'published_at' => '2026-03-10',
            'author' => 'Imran Ahmed',
            'title' => [
                'en' => 'Why modular procurement beats monolithic ERP add-ons',
                'bn' => 'মডুলার ক্রয় কেন একক ইআরপি অ্যাড-অনের চেয়ে ভালো',
            ],
            'excerpt' => [
                'en' => 'Turn on sourcing, orders, and supplier modules as your organization matures—without replatforming.',
                'bn' => 'সংস্থা বড় হলে সোর্সিং, অর্ডার ও সরবরাহকারী মডিউল চালু করুন—রিপ্ল্যাটফর্ম ছাড়াই।',
            ],
            'body' => [
                'en' => '<p>Each module owns its data model and Filament surfaces for buyers, suppliers, and operators. Enable only what you need today; the registry keeps disabled modules out of navigation and routes.</p>',
                'bn' => '<p>প্রতিটি মডিউল নিজস্ব ডেটা মডেল ও প্যানেল নিয়ন্ত্রণ করে। আজ যা দরকার কেবল তাই চালু রাখুন।</p>',
            ],
        ],
    ],

    'sitemap_static' => [
        'home',
        'features',
        'modules',
        'for-buyers',
        'for-suppliers',
        'suppliers.index',
        'rfqs.index',
        'categories',
        'pricing',
        'how-it-works',
        'industries',
        'about',
        'contact',
        'blog.index',
        'faq',
        'help',
        'terms',
        'privacy',
        'login',
        'register',
        'demo.request',
    ],

];
