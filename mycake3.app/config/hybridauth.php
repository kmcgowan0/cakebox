<?php

use Cake\Core\Configure;

return [
    'HybridAuth' => [
        'providers' => [
            'Google' => [
                'enabled' => true,
                'keys' => [
                    'id' => '623418431467-boee7g4q792mf6ita1qadl5slsb49fi6.apps.googleusercontent.com',
                    'secret' => 'AGftwBoxSctfwEr88clBto4E'
                ]
            ],
            'Facebook' => [
                'enabled' => true,
                'keys' => [
                    'id' => '1931790230468418',
                    'secret' => '40aa1c242f4ee345e56aae8675215334'
                ],
                'scope' => 'email, user_about_me, user_birthday, user_hometown'
            ],
            'Twitter' => [
                'enabled' => true,
                'keys' => [
                    'key' => 'OV1kzn80yTvadTBRAXJMxfz65',
                    'secret' => 'A4yY7ITZu0XTs63TPs3EhzJ2W6hqMOLQIL1z2KzDxTlEI6XL9U'
                ],
                'includeEmail' => true // Only if your app is whitelisted by Twitter Support
            ]
        ],
        'debug_mode' => Configure::read('debug'),
        'debug_file' => LOGS . 'hybridauth.log',
    ]
];