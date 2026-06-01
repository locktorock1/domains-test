<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->enum('check_method', ['GET', 'HEAD'])
                ->default('HEAD')
                ->after('title');

            $table->unsignedInteger('timeout')
                ->default(5)
                ->after('check_method');

            $table->unsignedInteger('check_interval')
                ->default(5)
                ->after('timeout');
        });
    }

    public function down(): void
    {
        Schema::table('domains', function (Blueprint $table) {
            $table->dropColumn([
                'check_method',
                'timeout',
                'check_interval',
            ]);
        });
    }
};
