<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * This is the ONLY table this project adds to the shared Supabase
     * database. It is intentionally unrelated to public.users (Supabase
     * Auth / the mobile app's travelers) — dashboard staff and travelers
     * are different audiences with different login systems.
     *
     * Run this against the direct connection (see README) rather than the
     * pooler, since DDL doesn't play well with transaction pooling.
     */
    public function up(): void
    {
        $schema = Schema::connection('pgsql_admin::direct');

        if (! $schema->hasTable('admin_users')) {
            $schema->create('admin_users', function (Blueprint $table) {
                $table->uuid('id')->primary()->default(new \Illuminate\Database\Query\Expression('gen_random_uuid()'));
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('role', ['owner', 'moderator', 'analyst'])->default('moderator');
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('pgsql_admin::direct')->dropIfExists('admin_users');
    }
};
