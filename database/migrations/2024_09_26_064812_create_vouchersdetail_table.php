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
        Schema::create('vouchersDetail', function (Blueprint $table) {
            $table->bigIncrements('voucherDtid');

            $table->unsignedBigInteger('voucherId');
            // Add the foreign key constraint with restrict on delete
            $table->foreign('voucherId')->references('voucherId')->on('vouchers')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->unsignedSmallInteger('uId');
            // Add the foreign key constraint with restrict on delete
            $table->foreign('uId')->references('uId')->on('users')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->unsignedSmallInteger('acId');
            // Add the foreign key constraint with restrict on delete
            $table->foreign('acId')->references('acId')->on('accounts')->onDelete('restrict'); // Prevent deletion if foreign key exists            

            $table->text('remarksDetail');

            $table->double('debit')->default(0);
            $table->double('credit')->default(0);
            
            $table->double('debitSR')->default(0);
            $table->double('creditSR')->default(0);
                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchersDetail');
    }
};
