<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop table if it exists to ensure clean schema rebuild
        Schema::dropIfExists('book_issues');

        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->date('issue_date');
            $table->date('return_date');
            $table->date('actual_return_date')->nullable();
            $table->decimal('fine', 8, 2)->default(0.00);
            $table->enum('status', ['issued', 'returned', 'overdue'])->default('issued');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_issues');
    }
};