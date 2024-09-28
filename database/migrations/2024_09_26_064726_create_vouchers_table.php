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
            $table->text('remarksMaster');

            $table->double('sumDebit')->default(0);
            $table->double('sumCredit')->default(0);
            
            $table->double('sumDebitSR')->default(0);
            $table->double('sumCreditSR')->default(0);
            
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
