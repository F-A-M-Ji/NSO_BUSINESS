<?php

return [
    'enabled' => env('AUDIT_LOG_ENABLED', true),
    'skip_paths' => array_filter(
        explode(',', (string) env('AUDIT_LOG_SKIP_PATHS', ''))
    ),
    'include_query' => env('AUDIT_LOG_INCLUDE_QUERY', false),
    'include_body' => env('AUDIT_LOG_INCLUDE_BODY', false),
    'include_files' => env('AUDIT_LOG_INCLUDE_FILES', false),
    'include_route_params' => env('AUDIT_LOG_INCLUDE_ROUTE_PARAMS', true),
    'mask_ip' => env('AUDIT_LOG_MASK_IP', true),
    'sensitive_keys' => array_filter(
        explode(',', (string) env('AUDIT_LOG_SENSITIVE_KEYS', 'password,password_confirmation,current_password,_token,token,authorization,cookie,my_secret_key'))
    ),
    'max_value_length' => (int) env('AUDIT_LOG_MAX_VALUE', 1000),
    'max_payload_length' => (int) env('AUDIT_LOG_MAX_PAYLOAD', 10000),
];
