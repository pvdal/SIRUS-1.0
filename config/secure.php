<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Dynamic Tokens Tolerance
    |--------------------------------------------------------------------------
    |
    | Define quantos tokens dinâmicos por aba serão mantidos na sessão.
    | Usado no middleware SecureAjaxRequest para limitar a lista de tokens.
    |
    */
    'dynamic_tokens_tolerance' => env('DYNAMIC_TOKENS_TOLERANCE', 5),

    /*
    |--------------------------------------------------------------------------
    | Request Prefix
    |--------------------------------------------------------------------------
    |
    | Define um valor fixo usado em todas as requisições ajax.
    | Camada básica de segurança, para evitar que um usuário acabe digitando
    | uma rota ajax na URL e tendo como retorno a tela preta com a mensagem:
    | 'Apenas requisições Ajax São Permitidas'.
    |
    */
    'request_prefix' => env('REQUEST_PREFIX', '2e95b528-95e8-4c8e-a41a'),

    /*
    |--------------------------------------------------------------------------
    | Termos de uso e políticas de privacidade
    |--------------------------------------------------------------------------
    |
    | Define se será exigido o aceite de termos por parte do usuário ou não.
    |
    */
    'terms_accept' => false,
];
