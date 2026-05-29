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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();;

            $table->string('invoice_code')->unique();
            $table->string('invoice_file');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->foreignId('validated_by')
                ->nullable()
                ->constrained('users');
            $table->dateTime('validated_at')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
