<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class ValidResources implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $json_validator = Validator::make([$attribute => $value], [$attribute => 'json']);

        if ($json_validator->fails()) {
            $fail('The :attribute field must be valid JSON.');

            return;
        }

        $data = json_decode($value, associative: true);
        $data_validator = Validator::make($data, [
            '*.x' => ['required', 'numeric', 'integer', 'min:1'],
            '*.y' => ['required', 'numeric', 'integer', 'min:1'],
            '*.type' => ['required'],
        ]);

        if ($data_validator->fails()) {
            $fail('The :attribute field contains incorrect data.');

            return;
        }
    }
}
