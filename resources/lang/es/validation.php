<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted' => ':attribute debe ser aceptado.',
    'active_url' => ':attribute no es una URL válida.',
    'after' => ':attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => ':attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => ':attribute sólo debe contener letras.',
    'alpha_dash' => ':attribute sólo debe contener letras, números y guiones.',
    'alpha_num' => ':attribute sólo debe contener letras y números.',
    'array' => ':attribute debe ser un conjunto.',
    'before' => ':attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => ':attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => ':attribute tiene que estar entre :min - :max.',
        'file' => ':attribute debe pesar entre :min - :max kilobytes.',
        'string' => ':attribute tiene que tener entre :min - :max caracteres.',
        'array' => ':attribute tiene que tener entre :min - :max ítems.',
    ],
    'boolean' => 'El campo :attribute debe tener un valor verdadero o falso.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => ':attribute no es una fecha válida.',
    'date_format' => ':attribute no corresponde al formato :format.',
    'different' => ':attribute y :other deben ser diferentes.',
    'digits' => ':attribute debe tener :digits dígitos.',
    'digits_between' => ':attribute debe tener entre :min y :max dígitos.',
    'dimensions' => 'Las dimensiones de la imagen :attribute no son válidas.',
    'distinct' => 'El campo :attribute contiene un valor duplicado.',
    'email' => ':attribute no es un correo válido',
    'exists' => ':attribute es inválido.',
    'file' => 'El campo :attribute debe ser un archivo.',
    'filled' => 'El campo :attribute es obligatorio.',
    'image' => ':attribute debe ser una imagen.',
    'in' => ':attribute es inválido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => ':attribute debe ser un número entero.',
    'ip' => ':attribute debe ser una dirección IP válida.',
    'ipv4' => ':attribute debe ser un dirección IPv4 válida',
    'ipv6' => ':attribute debe ser un dirección IPv6 válida.',
    'json' => 'El campo :attribute debe tener una cadena JSON válida.',
    'max' => [
        'numeric' => ':attribute no debe ser mayor a :max.',
        'file' => ':attribute no debe ser mayor que :max kilobytes.',
        'string' => ':attribute no debe ser mayor que :max caracteres.',
        'array' => ':attribute no debe tener más de :max elementos.',
    ],
    'mimes' => ':attribute debe ser un archivo con formato: :values.',
    'mimetypes' => ':attribute debe ser un archivo con formato: :values.',
    'min' => [
        'numeric' => 'El tamaño de :attribute debe ser de al menos :min.',
        'file' => 'El tamaño de :attribute debe ser de al menos :min kilobytes.',
        'string' => ':attribute debe contener al menos :min caracteres.',
        'array' => ':attribute debe tener al menos :min elementos.',
    ],
    'not_in' => ':attribute es inválido.',
    'numeric' => ':attribute debe ser numérico.',
    'present' => 'El campo :attribute debe estar presente.',
    'regex' => 'El formato de :attribute es inválido.',
    'required' => 'El campo :attribute es obligatorio.',
    'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',
    'required_unless' => 'El campo :attribute es obligatorio a menos que :other esté en :values.',
    'required_with' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_with_all' => 'El campo :attribute es obligatorio cuando :values está presente.',
    'required_without' => 'El campo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es obligatorio cuando ninguno de :values estén presentes.',
    'same' => ':attribute y :other deben coincidir.',
    'size' => [
        'numeric' => 'El tamaño de :attribute debe ser :size.',
        'file' => 'El tamaño de :attribute debe ser :size kilobytes.',
        'string' => 'El campo :attribute debe contener :size caracteres.',
        'array' => ':attribute debe contener :size elementos.',
    ],
    'string' => 'El campo :attribute debe ser una cadena de caracteres.',
    'timezone' => 'El :attribute debe ser una zona válida.',
    'unique' => ':attribute ya ha sido registrado.',
    'uploaded' => 'Subir :attribute ha fallado.',
    'url' => 'El formato :attribute es inválido.',


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
        'password' => [
            'min' => 'La :attribute debe contener más de :min caracteres',
        ],
        'email' => [
            'unique' => 'El :attribute ya ha sido registrado.',
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

    'attributes' => [
        'name' => 'nombre',
        'username' => 'usuario',
        'email' => 'correo electrónico',
        'first_name' => 'nombre',
        'last_name' => 'apellido',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de la contraseña',
        'city' => 'ciudad',
        'country' => 'país',
        'address' => 'dirección',
        'phone' => 'teléfono',
        'mobile' => 'móvil',
        'age' => 'edad',
        'sex' => 'sexo',
        'gender' => 'género',
        'year' => 'año',
        'month' => 'mes',
        'day' => 'día',
        'hour' => 'hora',
        'minute' => 'minuto',
        'second' => 'segundo',
        'title' => 'título',
        'content' => 'contenido',
        'body' => 'contenido',
        'description' => 'descripción',
        'excerpt' => 'extracto',
        'date' => 'fecha',
        'time' => 'hora',
        'subject' => 'asunto',
        'message' => 'mensaje',
        'soap_type_id' => 'SOAP tipo',
        'soap_username' => 'SOAP Usuario',
        'soap_password' => 'SOAP Contraseña',
        'company_number' => 'número de empresa',
        'company_name' => 'nombre de empresa',
        'unit_price' => 'Precio unitario' ,
        'bank_id' => 'banco',
        'number' => 'número',
        'currency_type_id' => 'moneda',
        'trade_name' => 'nombre comercial',
        'identity_document_type_id' => 'tipo de documento de identidad',
        'department_id' => 'departamento',
        'province_id' => 'provincia',
        'district_id' => 'distrito',
        'customer_email' => 'correo del cliente',
        'customer_id' => 'cliente',
        'voided_description' => 'descripción del motivo de anulación',
        'code' => 'código',
        'unit_type_id' => 'unidad',
        'document_type_id' => 'tipo de documento',
        'supplier_id' => 'proveedor',
        'date_of_issue' => 'fecha de emisión',
        'charge_discount_type_id' => 'tipo de cargo',
        'pricing' => 'precio',
        'limit_users' => 'límite de usuarios',
        'limit_documents' => 'límite de documentos',
        'plan_documents' => 'documentos activos',
        'plan_id' => 'plan',

        'note.note_credit_type_id' => 'tipo de nota de crédito',
        'note.note_debit_type_id' => 'tipo de nota de débito',
        'note.note_description' => 'descripción',
        'exchange_rate_sale' => 'tipo de cambio',
        'type' => 'perfil',
        'item_id' => 'producto',
        'warehouse_id' => 'almacén',
        'inventory_transaction_id' => 'motivo traslado',
        'quantity' => 'cantidad',
        'category_id' => 'categoría',
        'brand_id' => 'marca',
        
        'room_type' => 'tipo de habitación',
        'ocupation' => 'ocupación',
        'sex' => 'sexo',
        'age' => 'edad',
        'civil_status' => 'estado civil',
        'nacionality' => 'nacionalidad',
        'origin' => 'procedencia',
        'room_number' => 'N° de habitación',
        'date_entry' => 'fecha ingreso',
        'time_entry' => 'hora ingreso',
        'date_exit' => 'fecha salida',
        'time_exit' => 'hora salida',
        'person_type_id' => 'tipo de cliente',
        'customers' => 'cliente',
        'sale_unit_price' => 'precio unitario de venta',
        'transport_mode_type_id' => 'modo de translado',
        'delivery.address' => 'dirección',
        'origin.address' => 'dirección',
        'transfer_reason_type_id' => 'motivo de translado',
        'token_server' => 'token servidor',
        'url_server' => 'url servidor',
        'is_client' => 'modo offline',
        'series_id' => 'series',
        'observations' => 'observaciones',
        'operation_type_id' => 'tipo operación',
        'percentage ' => 'porcentaje',
        'start_number ' => 's',
        'commission_amount' => 'monto de comisión',


        'number_identity_document' => 'número documento',
        'passenger_fullname' => 'nombre y apellidos',
        'passenger_manifest' => 'manifiesto pasajeros',
        'seat_number' => 'número asiento',
        'start_date' => 'fecha inicio',
        'start_time' => 'hora inicio',
        'origin_address' => 'dirección origen',
        'origin_district_id' => 'ubigeo',
        'destinatation_district_id' => 'ubigeo',
        'destinatation_address' => 'dirección destino',
        'date_start' => 'fecha inicial',
        'date_end' => 'fecha final',
        'payment_method_type_id' => 'm. pago',
        'expense_method_type_id' => 'm. gasto',
        'payment_destination_id' => 'destino',
        'telephone' => 'teléfono',
        'customer' => 'cliente',

        'cellphone' => 'celular',
        'state' => 'estado',
        'reason' => 'motivo',
        'serial_number' => 'n° serie',
        'prepayment' => 'pago adelantado',
        'activities' => 'actividades',
        'user_id' => 'vendedor',
        'internal_id' => 'código interno',
    ],
];
