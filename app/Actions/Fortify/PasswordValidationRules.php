<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Password::min(8) // tamanho mínimo
                    ->letters() // precisa de pelo menos uma letra
                    ->mixedCase() // maiúscula + minúscula
                    ->numbers() // pelo menos um número
                    ->symbols() // pelo menos um símbolo
                    ->uncompromised(), // não pode estar em vazamentos conhecidos (usa haveibeenpwned API)
            'confirmed'];
    }
}
