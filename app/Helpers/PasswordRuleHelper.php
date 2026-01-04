<?php

namespace App\Helpers;

class PasswordRuleHelper
{
    /**
     * Aturan standar password aplikasi
     */
    public static function rules(): array
    {
        return [
            'required',
            'string',
            'min:12',

            // minimal 1 huruf kecil
            'regex:/[a-z]/',

            // minimal 1 huruf besar
            'regex:/[A-Z]/',

            // minimal 1 angka
            'regex:/[0-9]/',

            // minimal 1 simbol
            'regex:/[@$!%*#?&^()_\-+=]/',
        ];
    }

    /**
     * Message error khusus password
     */
    public static function messages(): array
    {
        return [
            'password.min'   => __('Password must be at least 12 characters.'),
            'password.regex' => __('Password must contain uppercase, lowercase, number, and symbol.'),
        ];
    }
}