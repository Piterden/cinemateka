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

    'accepted'             => 'Значение :attribute обязательно.',
    'active_url'           => ':attribute не корректный URL.',
    'after'                => 'Значение :attribute должно быть датой после :date.',
    'alpha'                => ':attribute может содержать толко буквы.',
    'alpha_dash'           => ':attribute может содержать толко буквы, цифры, и тире.',
    'alpha_num'            => ':attribute может содержать толко буквы и цифры.',
    'array'                => 'Значение :attribute должно быть массивом.',
    'before'               => 'Значение :attribute должно быть датой до :date.',
    'between'              => [
        'numeric' => 'Значение :attribute должно быть между :min и :max.',
        'file'    => 'Размер :attribute должен быть от :min до :max килобайт.',
        'string'  => 'Строка :attribute должна быть длиной от :min до :max букв.',
        'array'   => 'Массив :attribute должен содержать от :min до :max элементов.',
    ],
    'boolean'              => ':attribute должно быть true или false.',
    'confirmed'            => ':attribute пароли не совпадают.',
    'date'                 => ':attribute не корректная дата.',
    'date_format'          => ':attribute не соответствует формату :format.',
    'different'            => ':attribute и :other должны быть разными.',
    'digits'               => 'Число :attribute должно быть длиной в :digits цифр.',
    'digits_between'       => 'Число :attribute должно от :min до :max цифр.',
    'dimensions'           => ':attribute не корректное изображение.',
    'distinct'             => ':attribute повторяющееся значение.',
    'email'                => 'Значение :attribute должно быть настоящим E-mail адресом.',
    'exists'               => 'Выбранное значения поля :attribute не верно.',
    'filled'               => 'Поле :attribute обязательно.',
    'image'                => 'Значение :attribute должно изображением.',
    'in'                   => 'Выбранное :attribute не верно.',
    'in_array'             => ':attribute поле не существует в :other.',
    'integer'              => 'Значение :attribute должно быть целым числом.',
    'ip'                   => 'Значение :attribute должно быть IP адресом.',
    'json'                 => 'Значение :attribute должно быть корректной строкой JSON.',
    'max'                  => [
        'numeric' => ':attribute не может быть больше :max.',
        'file'    => ':attribute не может быть больше :max килобайт.',
        'string'  => ':attribute не может быть больше :max букв.',
        'array'   => ':attribute не может иметь больше :max элементов.',
    ],
    'mimes'                => 'Значение :attribute должно a file of type: :values.',
    'min'                  => [
        'numeric' => 'Значение :attribute должно at least :min.',
        'file'    => 'Значение :attribute должно at least :min kilobytes.',
        'string'  => 'Значение :attribute должно at least :min characters.',
        'array'   => ':attribute must have at least :min items.',
    ],
    'not_in'               => 'Выбранное :attribute не верно.',
    'numeric'              => 'Значение :attribute должно быть числом.',
    'present'              => 'Число :attribute должно быть положительным.',
    'regex'                => ':attribute формат не верен.',
    'required'             => 'Поле :attribute обязательно.',
    'required_if'          => 'Поле :attribute обязательно когда :other = :value.',
    'required_unless'      => 'Поле :attribute обязательно пока :other одно из :values.',
    'required_with'        => 'Поле :attribute обязательно когда :values задано.',
    'required_with_all'    => 'Поле :attribute обязательно когда :values задано.',
    'required_without'     => 'Поле :attribute обязательно когда :values не задано.',
    'required_without_all' => 'Поле :attribute обязательно когда ни одного из :values не задано.',
    'same'                 => ':attribute и :other должны совпадать.',
    'size'                 => [
        'numeric' => 'Число :attribute должно быть :size цифр.',
        'file'    => 'Файл :attribute должен быть размером :size килобайт.',
        'string'  => 'Строка :attribute должна состоять из :size букв.',
        'array'   => 'Массив :attribute должен содержать :size элементов.',
    ],
    'string'               => 'Значение :attribute должно строкой.',
    'timezone'             => 'Значение :attribute должно корректной временной зоной.',
    'unique'               => ':attribute уже есть.',
    'url'                  => ':attribute неправильный формат URL.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
