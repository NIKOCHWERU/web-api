<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('slug');
            $table->string('status')->default('draft')->after('image');
            $table->json('tags')->nullable()->after('status');
            $table->string('meta_title')->nullable()->after('supporting_images');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('focus_keyword')->nullable()->after('meta_description');
            $table->string('canonical_url')->nullable()->after('focus_keyword');
            $table->integer('seo_score')->default(0)->after('canonical_url');
            $table->string('readability_score')->default('Poor')->after('seo_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'summary',
                'status',
                'tags',
                'meta_title',
                'meta_description',
                'focus_keyword',
                'canonical_url',
                'seo_score',
                'readability_score',
            ]);
        });
    }
};
