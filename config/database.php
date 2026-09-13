<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | This app only ever talks to the shared Supabase Postgres instance, so
    | pgsql is the default rather than Laravel's usual sqlite.
    |
    */

    'default' => env('DB_CONNECTION', 'pgsql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => env('DB_SSLMODE', 'require'),
            // Laravel 13: talk correctly to Supabase's PgBouncer transaction
            // pooler (emulated prepares, correct boolean binding, etc.).
            // Leave false if DB_PORT points at Supabase's direct connection
            // (5432) instead of the pooler (6543).
            'pooled' => (bool) env('DB_POOLED', false),
        ],

        // Direct (non-pooled) alias, used for the one-off admin_users
        // migration — see the `::direct` suffix convention Laravel 13 adds
        // for schema/DDL work that shouldn't run through a transaction
        // pooler. Only needed if DB_POOLED=true above.
        'pgsql::direct' => [
            'driver' => 'pgsql',
            'host' => env('DB_DIRECT_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('DB_DIRECT_PORT', '5432'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => env('DB_SSLMODE', 'require'),
        ],

        // Dashboard authentication tables live in the dedicated Supabase
        // Admin schema; traveler data remains in public.
        'pgsql_admin' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => '"Admin"',
            'sslmode' => env('DB_SSLMODE', 'require'),
            // Admin authentication uses the regular application connection.
            // Keep pooling opt-in here so Laravel does not reject the
            // connection when no explicit direct endpoint is configured.
            'pooled' => false,
        ],

        'pgsql_admin::direct' => [
            'driver' => 'pgsql',
            'host' => env('DB_DIRECT_HOST', env('DB_HOST', '127.0.0.1')),
            'port' => env('DB_DIRECT_PORT', '5432'),
            'database' => env('DB_DATABASE', 'postgres'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => '"Admin"',
            'sslmode' => env('DB_SSLMODE', 'require'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    */

    'migrations' => [
        'table' => 'admin_migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Not used by this app (cache/session/queue are file/sync-based — see
    | .env.example), kept only because some framework internals expect the
    | key to exist.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => Str::slug(env('APP_NAME', 'laravel'), '_').'_database_',
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

    ],

];
