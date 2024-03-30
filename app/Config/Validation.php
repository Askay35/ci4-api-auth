<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------


    public array $register = [
        'email' => [
            'rules'  => 'required|max_length[256]|valid_email|is_unique[users.email]',
            'errors' => [
                'valid_email' => 'Невалидная электронная почта',
                'is_unique' => 'Электронная почта уже зарегистрирована',
            ],
        ],
        'password'=>[
            'rules'  => 'required|max_length[256]|min_length[8]',
            'errors' => [
                'min_length' => 'Пароль должен быть >8 символов'
            ]
        ],
        'password_confirm'=>[
            'rules'  => 'required|max_length[256]|min_length[8]|matches[password]',
            'errors' => [
                'matches' => 'Пароли не совпадают'
            ]
        ]
    ];

    public array $verify_email = [
        'code' => [
            'rules' => 'required|min_length[6]|max_length[6]|numeric'
        ]
    ];

    public array $login = [
        'email' => [
            'rules'  => 'required|max_length[256]|valid_email',
            'errors' => [
                'valid_email' => 'Не валидная электронная почта',
            ],
        ],
        'password'=>[
            'rules'  => 'required|max_length[256]|min_length[8]',
            'errors' => [
                'min_length' => 'Пароль должен быть >8 символов'
            ]
        ]
    ];

}
