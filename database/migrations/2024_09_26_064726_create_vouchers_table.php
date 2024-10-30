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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('voucherId');
            $table->date('voucherDate');
            $table->string('voucherPrefix');
            $table->text('remarks')->nullable(); // Make email nullable;

            $table->unsignedBigInteger('drAcId')->nullable();
            // Add the foreign key constraint with restrict on delete
            $table->foreign('drAcId')->references('acId')->on('accounts')->onDelete('restrict'); // Prevent deletion if foreign key exists            
            
            $table->unsignedBigInteger('crAcId')->nullable();
            // Add the foreign key constraint with restrict on delete
            $table->foreign('crAcId')->references('acId')->on('accounts')->onDelete('restrict'); // Prevent deletion if foreign key exists            

            $table->double('debit')->default(0);
            $table->double('credit')->default(0);
            
            $table->double('debitSR')->default(0);
            $table->double('creditSR')->default(0);
            
            $table->unsignedBigInteger('uId');
            // Add the foreign key constraint with restrict on delete
            $table->foreign('uId')->references('id')->on('users')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
