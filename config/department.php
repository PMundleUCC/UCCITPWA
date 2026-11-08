<?php

return [
    // University details shared across pages.
    'university' => env('DEPARTMENT_UNIVERSITY', 'University of the Commonwealth Caribbean'),
    'name' => 'Department of Information Technology',
    'address' => '17 Worthington Avenue, Kingston 5, Jamaica',
    'phone' => '(876) 906-3000',
    'dial' => '+18769063000',
    'website' => 'https://ucc.edu.jm',
    'hod_email' => env('DEPARTMENT_HOD_EMAIL', 'ithod@ucc.edu.jm'),
    'application_url' => env('DEPARTMENT_APPLICATION_URL', 'https://www.ucc.edu.jm/apply/undergraduate'),
    // Firebase course database connection.
    'firebase_url' => env('FIREBASE_DATABASE_URL'),
    // Links displayed in the footer.
    'social' => [
        'Facebook' => env('DEPARTMENT_FACEBOOK_URL') ?: 'https://www.facebook.com/uccjamaica',
        'Twitter / X' => env('DEPARTMENT_TWITTER_URL') ?: 'https://x.com/uccjamaica',
        'Instagram' => env('DEPARTMENT_INSTAGRAM_URL') ?: 'https://www.instagram.com/uccjamaica',
        'YouTube' => 'https://www.youtube.com/uccjamaica',
        'LinkedIn' => 'https://www.linkedin.com/company/uccjamaica',
        'TikTok' => 'https://www.tiktok.com/@uccjamaica',
        'Threads' => 'https://www.threads.net/@uccjamaica',
    ],
    // Directory entries; photo filenames belong in public/images.
    'staff' => [
        [
            'name' => 'Mr. Otis Osbourne',
            'role' => 'Head of Department',
            'area' => 'Information Technology',
            'email' => 'ithod@ucc.edu.jm',
            'phone' => '(876) 906-3000 (UCC main office)',
            'dial' => '+18769063000',
            'photo' => null,
            'office' => '17 Worthington Avenue, Kingston 5',
        ],
        [
            'name' => 'Dr. Peter Ndajah',
            'role' => 'Dean',
            'area' => 'School of Mathematics, Science & Technology',
            'email' => 'deanmathscitech@ucc.edu.jm',
            'phone' => '(876) 906-3000',
            'dial' => '+18769063000',
            'photo' => null,
            'office' => '17 Worthington Avenue, Kingston 5',
        ],
        [
            'name' => 'Ms. Sherida Levy',
            'role' => 'Programme Officer',
            'area' => 'Information Technology',
            'email' => 'itprogrammeofficer2@ucc.edu.jm',
            'phone' => '(876) 906-3000 ext. 4020',
            'dial' => '+18769063000;ext=4020',
            'photo' => null,
            'office' => '17 Worthington Avenue, Kingston 5',
        ],
        [
            'name' => 'Mr. Craig Wilmot',
            'role' => 'Programme Officer',
            'area' => 'Information Technology',
            'email' => 'itprogofficer4@ucc.edu.jm',
            'phone' => '(876) 906-3000 ext. 3937',
            'dial' => '+18769063000;ext=3937',
            'photo' => null,
            'office' => '17 Worthington Avenue, Kingston 5',
        ],
    ],
];
