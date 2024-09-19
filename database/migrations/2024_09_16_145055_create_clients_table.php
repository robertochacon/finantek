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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreign('person_id')->references('id')->on('persons');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->json('personal_references')->nullable();
            $table->json('family_references')->nullable();
            $table->json('business_references')->nullable();
            $table->decimal('income_salary', 10, 2)->nullable();
            $table->decimal('income_other', 10, 2)->nullable();
            $table->decimal('expenses_home', 10, 2)->nullable();
            $table->decimal('expenses_credit_quotas', 10, 2)->nullable();
            $table->decimal('expenses_other', 10, 2)->nullable();
            $table->text('warranty')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
