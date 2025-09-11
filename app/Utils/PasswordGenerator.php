<?php

namespace App\Utils;

use Illuminate\Support\Str;
use Random\RandomException;

class PasswordGenerator
{
    /**
     * Gera uam senha aleatória com letras maiúsculas e minúsculas, números e símbolos.
     * @param int $length Tamanho total desejado da senha
     * @return String
     * @throws RandomException
     */
    public static function random(int $length = 12): String
    {
        if($length < 8) {
            Throw New \InvalidArgumentException("A senha deve ter pelo menos 8 caracteres!");
        }

        // Conjuntos de caracteres
        $lowerLetters = 'abcdefghijklmnopqrstuvwxyz';
        $upperLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $symbols = '!@#$%&*';

        $password = null; // inicia a variável

        // Adiciona pelo menos um tipo de cada
        $password .= $lowerLetters[random_int(0, strlen($lowerLetters) - 1)];
        $password .= $upperLetters[random_int(0, strlen($upperLetters) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        $allChars = $lowerLetters . $upperLetters . $numbers . $symbols;
        for ($i = strlen($password); $i < $length; $i ++) {
            $password = $allChars[random_int(0, strlen($allChars) -1)];
        }

        // Embaralha a ordem final
        return str_shuffle($password);
    }
}
