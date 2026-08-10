<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_issues', function (Blueprint $table) {
            if (!Schema::hasColumn('book_issues', 'fine_status')) {
                $table->enum('fine_status', ['unpaid', 'paid', 'waived'])->default('unpaid')->after('fine');
            }
            if (!Schema::hasColumn('book_issues', 'waiver_reason')) {
                $table->text('waiver_reason')->nullable()->after('fine_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('book_issues', function (Blueprint $table) {
            $table->dropColumn(['fine_status', 'waiver_reason']);
        });
    }
};