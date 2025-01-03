<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы названий кнопок
    |--------------------------------------------------------------------------
    |
    | Следующие языковые ресурсы используются в названиях
    | кнопок всего вашего приложения.
    | Вы можете свободно изменять эти языковые ресурсы в соответствии
    | с требованиями вашего приложения.
    |
    */

    'backend' => [
        'access' => [
            'users' => [
                'activate' => 'Активировать',
                'change_password' => 'Изменить пароль',
                'deactivate' => 'Деактивировать',
                'delete_permanently' => 'Удалить навсегда',
                'login_as' => 'Войти как :user',
                'resend_email' => 'Повторно отправить подтверждение на E-mail',
                'restore_user' => 'Восстановить учетную запись',
                'unconfirm' => 'Un-confirm',
                'unlink' => 'Unlink',
            ],
        ],
    ],
    'emails' => [
        'auth' => [
            'confirm_account' => 'Подтвердить учетную запись',
            'reset_password' => 'Сбросить пароль',
        ],
    ],
    'general' => [
        'cancel' => 'Отменa',
        'crud' => [
            'create' => 'Создать',
            'delete' => 'Удалить',
            'edit' => 'Редактировать',
            'update' => 'Применить',
            'view' => 'Просмотр',
        ],
        'save' => 'Сохранить',
        'view' => 'Просмотр',
    ],
];
