<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('is_published');
        });

        // Add read_at to contacts if not exists
        if (!Schema::hasColumn('contacts', 'read_at')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->timestamp('read_at')->nullable()->after('message');
            });
        }
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};
