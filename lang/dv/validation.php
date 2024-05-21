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

    'accepted' => ':attribute ޤަބޫލުކުރަން ޖެހޭނެ.',
    'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
    'active_url'           => ':attribute އަކީ ރަނގަޅު ޔޫ.އާރް.އެލްއެއް ނޫން.',
    'after'                => ':attribute ވާންޖެހޭނީ :date އަށްވުރެ ފަހުގެ ތާރީޙަކަށް.',
    'after_or_equal'       => ':attribute ވާންޖެހޭނީ :date އާއި އެއްވަރު ނުވަތަ އެއަށްވުރެ ފަހުގެ ތާރީޙަކަށް',
    'alpha'                => ':attribute ގައި ހިމެނޭނީ އަކުރު އެކަނި.',
    'alpha_dash'           => ':attribute ގައި ހިމެނޭނީ ހަމައެކަނި އަކުޜާއި، ނަންބަރާއި، ޑޭޝް.',
    'alpha_num'            => ':attribute ގައި ހިމެނޭނީ ހަމައެކަނި އަކުރާއި ނަންބަރު.',
    'array'                => ':attribute ވާންޖެހޭނީ އެރޭއަކަށް.',
    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before'               => ':attribute ވާންޖެހޭނީ :date އަށްވުރެ ކުރީގެ ތާރީޙަކަށް.',
    'before_or_equal'      => ':attribute ވާންޖެހޭނީ :date އާއި އެއްވަރު ނުވަތަ އެއަށްވުރެ ކުރީގެ ތާރީޙަކަށް',
    'between' => [
        'numeric' => ':attribute ވާންޖެހޭނީ :min އާއި :max އާ ދެމެދުގެ ނަންބަރަކަށް.',
        'file'    => ':attribute ވާންޖެހޭނީ :min އާއި :max އާ ދެމެދުގެ ކޭބީގެ ފައިލަކަށް.',
        'string'  => ':attribute ވާންޖެހޭނީ :min އާއި :max އާ ދެމެދުގެ ދިގުމިނުގެ އިބާރާތަކަށް.',
        'array'   => ':attribute ވާންޖެހޭނީ :min އާއި :max އާ ދެމެދުގެ ދިގުމިނުގެ އެރޭއަކަށް.',
    ],
    'boolean'              => ':attribute ވާންޖެހޭނީ އާއެކޭ ނުވަތަ ނޫނެކޭ.',
    'can' => 'The :attribute field contains an unauthorized value.',
    'confirmed'            => ':attribute ކޮމްފަރމޭޝަން ދިމަލެއްނުވޭ.',
    'current_password' => 'ޕާސްވޯރޑް ރަނގަޅެއް ނޫން.',
    'date'                 => ':attribute އަކީ ރަނގަޅު ތާރީޙެއްނޫން.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'date_format'          => ':attribute :format ފޯރމެޓާ ދިމަލެއްނުވޭ.',
    'decimal' => 'The :attribute field must have :decimal decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => 'The :attribute field and :other must be different.',
    'digits'               => ':attribute ވާންޖެހޭނީ :digits ގެ ނަންބަރުތަކަކަށް.',
    'digits_between'       => ':attribute ވާންޖެހޭނީ :min އާއި :max އާ ދެމެދުގެ ނަންބަރުތަކަކަށް.',
    'dimensions'           => ':attribute ގައި ހުރީ ރަނގަޅު ސައިޒެއް ނޫން.',
    'distinct'             => ':attribute ގައި ޑުޕްލިކޭޓް އަދަދު އެބަހުރި.',
    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    'email'                => ':attribute ވާންޖެހޭނީ ރަނގަޅު އީމެއިލް އެޑްރެހަކަށް.',
    'ends_with' => 'The :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists'               => 'ހިޔާރުކުރި :attribute ރަނގަޅެއްނޫން.',
    'extensions' => 'The :attribute field must have one of the following extensions: :values.',
    'file'                 => ':attribute ވާންޖެހޭނީ ފައިލަކަށް.',
    'filled'               => ':attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'gt' => [
        'array' => 'The :attribute field must have more than :value items.',
        'file' => 'The :attribute field must be greater than :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than :value.',
        'string' => 'The :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than or equal to :value.',
        'string' => 'The :attribute field must be greater than or equal to :value characters.',
    ],
    'hex_color' => 'The :attribute field must be a valid hexadecimal color.',
    'image' => 'The :attribute field must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must exist in :other.',
    'integer' => 'The :attribute field must be an integer.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'list' => 'The :attribute field must be a list.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'The :attribute field must be less than :value.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'numeric' => ':attribute :max އަށްވުރެ ބޮޑުވެގެން ނުވާނެ.',
        'file'    => ':attribute :max ކޭބީ އަށްވުރެ ބޮޑުވެގެން ނުވާނެ.',
        'string'  => ':attribute :max އަކުރަށްވުރެ ދިގުވެގެން ނުވާނެ.',
        'array'   => ':attribute :max އައިޓަމަށްވުރެ ދިގުވެގެން ނުވާނެ.',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => 'The :attribute field must be a file of type: :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute :min އަށްވުރެ ކުޑަވެގެން ނުވާނެ.',
        'file'    => ':attribute :min ކޭބީ އަށްވުރެ ކުޑަވެގެން ނުވާނެ',
        'string'  => ':attribute :min އަކުރަށްވުރެ ކުރުވެގެން ނުވާނެ',
        'array'   => ':attribute :min އައިޓަމަށްވުރެ މަދުވެގެން ނުވާނެ',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in'               => 'ހިޔާރުކުރި :attribute ރަނގަޅެއްނޫން.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => 'The :attribute field must be a number.',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'present_if' => 'The :attribute field must be present when :other is :value.',
    'present_unless' => 'The :attribute field must be present unless :other is :value.',
    'present_with' => 'The :attribute field must be present when :values is present.',
    'present_with_all' => 'The :attribute field must be present when :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute field format is invalid.',
    'required'             => ':attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if'          => ':other އަކީ :value ނަމަ :attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_if_declined' => 'The :attribute field is required when :other is declined.',
    'required_unless'      => ':values ގައި :other ނެތްނަމަ :attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'required_with'        => ':values ހިމެނޭނަމަ :attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'required_with_all'    => ':values ހިމެނޭނަމަ :attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'required_without'     => ':values ނުހިމެނޭނަމަ :attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'required_without_all' => ':values ގެ އެއްވެސް އެއްޗެއް ނުހިމެނޭނަމަ :attribute ފުރިހަމަކުރަން ޖެހޭ.',
    'same' => 'The :attribute field must match :other.',
    'size' => [
        'numeric' => ':attribute ވާންޖެހޭނީ :size އަށް.',
        'file'    => ':attribute ވާންޖެހޭނީ :size ކޭބީ.',
        'string'  => ':attribute ވާންޖެހޭނީ :size އަކުރު.',
        'array'   => ':attribute ގައި ހިމެނެން ޖެހޭނީ :size އައިޓަމް.',
    ],
    'starts_with' => 'The :attribute field must start with one of the following: :values.',
    'string'               => ':attribute ވާންޖެހޭނީ ޢިބާރާތަކަށް.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique'               => ':attribute ލިބޭކަށް ނެތް.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url'                  => ':attribute ފޯރމެޓް ރަނގަޅެއް ނޫން.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

    /*
     |--------------------------------------------------------------------------
     | Custom Validation Rules
     |--------------------------------------------------------------------------
     */
    'slug'                 => ':attribute ގައި ހަމައެކަނި ހިމެނޭނީ ކުދި އަކުރާއި، ނަންބަރާއި، :special_char.',
    'ids_exist'			   => ':attribute ގެ ކޮންމެވެސް އަދަދެއް ރަނގަޅެއްނޫން.',
    'passcheck'			   => ':attribute ރަނގަޅެއްނޫން.',
    'array_exists'		   => ':attribute ގެ އެއްކެއް ނުވަތަ އެއަށްވުރެ ގިނަ އަދަދުތައް ސައްޙައެއް ނޫން',
    'latitude'			   => ':attribute ވާންޖެހޭނީ ސައްޙަ ލެޓިޓިއުޑަކަށް',
    'longitude'			   => ':attribute ވާންޖެހޭނީ ސައްޙަ ލޮންޖިޓިއުޑަކަށް.',
    'color'				   => ':attribute ވާންޖޭހީ ސައްޙަ އެކްސް ކުލައަކަށް.',
    'mobile'               => ':attribute ވާންޖެހޭނީ ރާއްޖޭގެ މޯބައިލް ނަންބަރަކަށް.',
    'national_id' 		   => ':attribute ވާންޖެހޭނީ ރަނގަޅު ދ.ރ.ކ ނަންބަރަކަށް.',
    'allowed_attributes'   => ':attribute ރަނގަޅެއް ނޫން.',
    'recaptcha'            => 'ތީ ރޮބޮޓެއް ނޫންކަން ސާބިތުކޮށްދީ',

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
        'name' => 'ނަން',
        'password' => 'ޕާސްވޯރޑް',
        'email' => 'އީމެއިލް',
        'agreement' => 'އެއްބަސްވުން',
        'dob' => 'އުފަން ތާރީޙް',
        'current_password' => 'މިހާރު ގެންގުޅޭ ޕާސްވޯރޑް',
        'password_confirmation' => 'ޕާސްވޯރޑް ޔަޤީންކުރުން',
    ],

];
