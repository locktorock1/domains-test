<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('domains', function (Blueprint $table) {

            $table->timestamp('last_checked_at')
                ->nullable()
                ->after('check_interval');

            $table->timestamp('next_check_at')
                ->nullable()
                ->after('last_checked_at');
        });
    }

    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn([
                'last_checked_at',
                'next_check_at',
            ]);
        });
    }
};
