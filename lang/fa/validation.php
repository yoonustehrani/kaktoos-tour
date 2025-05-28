<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'فیلد :attribute field must be accepted.',
    'accepted_if' => 'فیلد :attribute field must be accepted when :other is :value.',
    'active_url' => 'فیلد :attribute field must be a valid URL.',
    'after' => 'فیلد :attribute field must be a date after :date.',
    'after_or_equal' => 'فیلد :attribute field must be a date after or equal to :date.',
    'alpha' => 'فیلد :attribute field must only contain letters.',
    'alpha_dash' => 'فیلد :attribute field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => 'فیلد :attribute field must only contain letters and numbers.',
    'array' => 'فیلد :attribute field must be an array.',
    'ascii' => 'فیلد :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'فیلد :attribute field must be a date before :date.',
    'before_or_equal' => 'فیلد :attribute field must be a date before or equal to :date.',
    'between' => [
        'array' => 'فیلد :attribute field must have between :min and :max items.',
        'file' => 'فیلد :attribute field must be between :min and :max kilobytes.',
        'numeric' => 'فیلد :attribute field must be between :min and :max.',
        'string' => 'فیلد :attribute field must be between :min and :max characters.',
    ],
    'boolean' => 'فیلد :attribute field must be true or false.',
    'can' => 'فیلد :attribute field contains an unauthorized value.',
    'confirmed' => 'فیلد :attribute field confirmation does not match.',
    'contains' => 'فیلد :attribute field is missing a required value.',
    'current_password' => 'The password is incorrect.',
    'date' => 'فیلد :attribute field must be a valid date.',
    'date_equals' => 'فیلد :attribute field must be a date equal to :date.',
    'date_format' => 'فیلد :attribute field must match the format :format.',
    'decimal' => 'فیلد :attribute field must have :decimal decimal places.',
    'declined' => 'فیلد :attribute field must be declined.',
    'declined_if' => 'فیلد :attribute field must be declined when :other is :value.',
    'different' => 'فیلد :attribute field and :other must be different.',
    'digits' => 'فیلد :attribute field must be :digits digits.',
    'digits_between' => 'فیلد :attribute field must be between :min and :max digits.',
    'dimensions' => 'فیلد :attribute field has invalid image dimensions.',
    'distinct' => 'فیلد :attribute field has a duplicate value.',
    'doesnt_end_with' => 'فیلد :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'فیلد :attribute field must not start with one of the following: :values.',
    'email' => 'فیلد :attribute field must be a valid email address.',
    'ends_with' => 'فیلد :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'extensions' => 'فیلد :attribute field must have one of the following extensions: :values.',
    'file' => 'فیلد :attribute field must be a file.',
    'filled' => 'فیلد :attribute field must have a value.',
    'gt' => [
        'array' => 'فیلد :attribute field must have more than :value items.',
        'file' => 'فیلد :attribute field must be greater than :value kilobytes.',
        'numeric' => 'فیلد :attribute field must be greater than :value.',
        'string' => 'فیلد :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'فیلد :attribute field must have :value items or more.',
        'file' => 'فیلد :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'فیلد :attribute field must be greater than or equal to :value.',
        'string' => 'فیلد :attribute field must be greater than or equal to :value characters.',
    ],
    'hex_color' => 'فیلد :attribute field must be a valid hexadecimal color.',
    'image' => 'فیلد :attribute field must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'فیلد :attribute field must exist in :other.',
    'integer' => 'فیلد :attribute field must be an integer.',
    'ip' => 'فیلد :attribute field must be a valid IP address.',
    'ipv4' => 'فیلد :attribute field must be a valid IPv4 address.',
    'ipv6' => 'فیلد :attribute field must be a valid IPv6 address.',
    'json' => 'فیلد :attribute field must be a valid JSON string.',
    'list' => 'فیلد :attribute field must be a list.',
    'lowercase' => 'فیلد :attribute field must be lowercase.',
    'lt' => [
        'array' => 'فیلد :attribute field must have less than :value items.',
        'file' => 'فیلد :attribute field must be less than :value kilobytes.',
        'numeric' => 'فیلد :attribute field must be less than :value.',
        'string' => 'فیلد :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'فیلد :attribute field must not have more than :value items.',
        'file' => 'فیلد :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'فیلد :attribute field must be less than or equal to :value.',
        'string' => 'فیلد :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'فیلد :attribute field must be a valid MAC address.',
    'max' => [
        'array' => 'فیلد :attribute field must not have more than :max items.',
        'file' => 'فیلد :attribute field must not be greater than :max kilobytes.',
        'numeric' => 'فیلد :attribute field must not be greater than :max.',
        'string' => 'فیلد :attribute field must not be greater than :max characters.',
    ],
    'max_digits' => 'فیلد :attribute field must not have more than :max digits.',
    'mimes' => 'فیلد :attribute field must be a file of type: :values.',
    'mimetypes' => 'فیلد :attribute field must be a file of type: :values.',
    'min' => [
        'array' => 'فیلد :attribute field must have at least :min items.',
        'file' => 'فیلد :attribute field must be at least :min kilobytes.',
        'numeric' => 'فیلد :attribute field must be at least :min.',
        'string' => 'فیلد :attribute field must be at least :min characters.',
    ],
    'min_digits' => 'فیلد :attribute field must have at least :min digits.',
    'missing' => 'فیلد :attribute field must be missing.',
    'missing_if' => 'فیلد :attribute field must be missing when :other is :value.',
    'missing_unless' => 'فیلد :attribute field must be missing unless :other is :value.',
    'missing_with' => 'فیلد :attribute field must be missing when :values is present.',
    'missing_with_all' => 'فیلد :attribute field must be missing when :values are present.',
    'multiple_of' => 'فیلد :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'فیلد :attribute field format is invalid.',
    'numeric' => 'فیلد :attribute field must be a number.',
    'password' => [
        'letters' => 'فیلد :attribute field must contain at least one letter.',
        'mixed' => 'فیلد :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'فیلد :attribute field must contain at least one number.',
        'symbols' => 'فیلد :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'فیلد :attribute field must be present.',
    'present_if' => 'فیلد :attribute field must be present when :other is :value.',
    'present_unless' => 'فیلد :attribute field must be present unless :other is :value.',
    'present_with' => 'فیلد :attribute field must be present when :values is present.',
    'present_with_all' => 'فیلد :attribute field must be present when :values are present.',
    'prohibited' => 'فیلد :attribute field is prohibited.',
    'prohibited_if' => 'فیلد :attribute field is prohibited when :other is :value.',
    'prohibited_if_accepted' => 'فیلد :attribute field is prohibited when :other is accepted.',
    'prohibited_if_declined' => 'فیلد :attribute field is prohibited when :other is declined.',
    'prohibited_unless' => 'فیلد :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'فیلد :attribute field prohibits :other from being present.',
    'regex' => 'فیلد :attribute field format is invalid.',
    'required' => 'فیلد :attribute اجباری است.',
    'required_array_keys' => 'فیلد :attribute field must contain entries for: :values.',
    'required_if' => 'فیلد :attribute field is required when :other is :value.',
    'required_if_accepted' => 'فیلد :attribute field is required when :other is accepted.',
    'required_if_declined' => 'فیلد :attribute field is required when :other is declined.',
    'required_unless' => 'فیلد :attribute field is required unless :other is in :values.',
    'required_with' => 'فیلد :attribute field is required when :values is present.',
    'required_with_all' => 'فیلد :attribute field is required when :values are present.',
    'required_without' => 'فیلد :attribute field is required when :values is not present.',
    'required_without_all' => 'فیلد :attribute field is required when none of :values are present.',
    'same' => 'فیلد :attribute field must match :other.',
    'size' => [
        'array' => 'فیلد :attribute field must contain :size items.',
        'file' => 'فیلد :attribute field must be :size kilobytes.',
        'numeric' => 'فیلد :attribute field must be :size.',
        'string' => 'فیلد :attribute field must be :size characters.',
    ],
    'starts_with' => 'فیلد :attribute field must start with one of the following: :values.',
    'string' => 'فیلد :attribute field must be a string.',
    'timezone' => 'فیلد :attribute field must be a valid timezone.',
    'unique' => 'فیلد :attribute has already been taken.',
    'uploaded' => 'فیلد :attribute failed to upload.',
    'uppercase' => 'فیلد :attribute field must be uppercase.',
    'url' => 'فیلد :attribute field must be a valid URL.',
    'ulid' => 'فیلد :attribute field must be a valid ULID.',
    'uuid' => 'فیلد :attribute field must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'title' => 'عنوان',
        'airline_code' => 'ایرلاین'
    ],

];
