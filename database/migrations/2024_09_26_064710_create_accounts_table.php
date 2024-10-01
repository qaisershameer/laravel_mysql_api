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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('acId');
            $table->string('acTitle');
            $table->string('email')->nullable(); // Make email nullable;
            $table->string('mobile')->nullable(); // Make email nullable;

            $table->double('openingBal')->default(0);
            $table->double('CurrentBal')->default(0);

            $table->unsignedBigInteger('uId');
            // Add the foreign key constraint User Id
            // $table->foreign('uId')->references('uId')->on('users')->onDelete('cascade');

            // Add the foreign key constraint with restrict on delete
            $table->foreign('uId')->references('id')->on('users')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->unsignedBigInteger('currencyId');
            // Add the foreign key constraint Currency Id
            $table->foreign('currencyId')->references('currencyId')->on('currency')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->unsignedBigInteger('accTypeId');
            // Add the foreign key constraint Account Type Id
            $table->foreign('accTypeId')->references('accTypeId')->on('accType')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->unsignedBigInteger('parentId');
            // Add the foreign key constraint Parent Account Id
            $table->foreign('parentId')->references('parentId')->on('accParent')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->unsignedBigInteger('areaId')->nullable(); // Make areaId nullable;
            // Add the foreign key constraint Area Id
            $table->foreign('areaId')->references('areaId')->on('area')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
