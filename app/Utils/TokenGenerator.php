<?php

namespace App\Utils;

use Random\RandomException;

class TokenGenerator
{
    /**
     * @throws RandomException
     */
    public static function uuidV4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f | 0x40));
        $data[8] =chr((ord($data[8])) & 0x3f | 0x80);

        return vsprintf('%02x%02x%02x%02x-%02x%02x-%02x%02x-%02x%02x-%02x%02x%02x%02x%02x%02x', str_split(bin2hex($data), 2));
    }

    /**
     * Gera o id da guia atual e o primeiro token dinâmico, inicializando a array
     *
     * @throws RandomException
     */
    public static function initializeTab(): void
    {
        /*
         * Aqui é gerado um ‘ID’ para cada guia aberta no navegador.
         * Em seguida é gerado o primeiro ‘token’ dinâmico da guia atual onde a index foi executada,
         * que é um tipo de ‘token’ anti-replay com margem de tolerância.
         * */

        $tabId = self::uuidV4();
        session(['tabId' => $tabId]);

        $dynamicToken = bin2hex(random_bytes(16));

        $allTokens = session('dynamic_tokens', []);
        $allTokens[$tabId] = [$dynamicToken];
        session(['dynamic_tokens' => $allTokens]);
    }
}
