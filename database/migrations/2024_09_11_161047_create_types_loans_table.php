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
        Schema::create('types_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->integer('max_term_months')->nullable();
            $table->decimal('min_amount', 10, 2)->nullable();
            $table->decimal('max_amount', 10, 2)->nullable();
            $table->decimal('legal_fees', 10, 2)->nullable();
            $table->decimal('late_fee_percentage', 5, 2)->nullable();
            $table->integer('grace_days')->nullable();
            $table->json('requirements')->nullable();
            $table->boolean('status')->default(true);
            $table->decimal('insurance', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types_loans');
    }
};
