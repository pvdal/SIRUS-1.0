<?php

namespace App\Utils;

class StringResolve
{
    public static function normalizeFolderName(string $value): string
    {
        /// Tabela básica de acentos → substituição
        $unwanted_array = [
            'á'=>'a','à'=>'a','ã'=>'a','â'=>'a','ä'=>'a',
            'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
            'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
            'ó'=>'o','ò'=>'o','ô'=>'o','õ'=>'o','ö'=>'o',
            'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
            'ç'=>'c','Ç'=>'C',
            'Á'=>'A','À'=>'A','Ã'=>'A','Â'=>'A','Ä'=>'A',
            'É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E',
            'Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I',
            'Ó'=>'O','Ò'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O',
            'Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U'
        ];

        // Utiliza a array pra remover os acentos
        $value = strtr($value, $unwanted_array);

        // Transforma tudo em minúsculo
        $value = strtolower($value);

        // Substitui qualquer caractere que não seja letra, número ou _ por _
        $value = preg_replace('/[^a-zA-Z0-9_]/', '_', $value);

        // Remove múltiplos _ consecutivos
        $value = preg_replace('/_+/', '_', $value);

        // Remove _ no início ou fim
        return trim($value, '_');
    }
}
