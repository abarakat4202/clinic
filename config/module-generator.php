<?php

return [
    'allowed_types' => [
        'action' => 'Actions',
        'api' => 'Routes',
        'class' => 'Support',
        'command' => 'Commands',
        'controller' => 'Controllers',
        'enum' => 'Enums',
        'event' => 'Events',
        'export' => 'Exports',
        'facade' => 'Support\Facades',
        'factory' => 'Factories',
        'import' => 'Imports',
        'job' => 'Jobs',
        'responder' => 'Responders',
        'listener'  => 'Listeners',
        'mail' => 'Mails',
        'model' => 'Models',
        'notification' => 'Notifications',
        'observer' => 'Observers',
        'repository' => 'Repositories',
        'request' => 'Requests',
        'resource' => 'Resources',
        'seeder' => 'Seeders',
        'service' => 'Services',
        'trait' => 'Traits',
    ],

    'related_types' => [
        // 'controller,request,service',
        'facade,class',
    ],

    'dont_rename' => [
        'model',
        'api',
        'web',
        'trait',
        'facade',
        'class',
        'enum',
    ],
];
