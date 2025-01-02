<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Alert Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain alert messages for various scenarios
    | during CRUD operations. You are free to modify these language lines
    | according to your application's requirements.
    |
    */

    'backend' => [
        'roles' => [
            'created' => 'The role was successfully created.',
            'deleted' => 'The role was successfully deleted.',
            'updated' => 'The role was successfully updated.',
        ],

        'users' => [
            'cant_resend_confirmation' => 'The application is currently set to manually approve users.',
            'confirmation_email' => 'A new confirmation e-mail has been sent to the address on file.',
            'confirmed' => 'The user was successfully confirmed.',
            'created' => 'The user was successfully created.',
            'deleted' => 'The user was successfully deleted.',
            'deleted_permanently' => 'The user was deleted permanently.',
            'restored' => 'The user was successfully restored.',
            'session_cleared' => "The user's session was successfully cleared.",
            'social_deleted' => 'Social Account Successfully Removed',
            'unconfirmed' => 'The user was successfully un-confirmed',
            'updated' => 'The user was successfully updated.',
            'updated_password' => "The user's password was successfully updated.",
            'updated_password_not' => "The user's password was not updated.",
        ],
    ],

    'blog' => [
        'created' => 'Blog is created sucessfully',
        'updated' => 'Blog is updated sucessgully',
        'deleted' => 'Blog is deleted sucessfully',
        'createFailed' => 'Blog is not created',
        'updateFailed' => 'Blog is not updated',
        'deleteFailed' => 'Blog is not deleted',

    ],

    'forum' => [
        'created' => 'Forum is created sucessfully',
        'updated' => 'Forum is updated sucessgully',
        'deleted' => 'Forum is deleted sucessfully',
        'createFailed' => 'Forum is not created',
        'updateFailed' => 'Forum is not updated',
        'deleteFailed' => 'Forum is not deleted',

    ],

    'frontend' => [
        'contact' => [
            'sent' => 'Your information was successfully sent. We will respond back to the e-mail provided as soon as we can.',
        ],
    ],
];
