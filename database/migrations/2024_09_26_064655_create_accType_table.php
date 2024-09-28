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
        Schema::create('accType', function (Blueprint $table) {
            $table->id('accTypeId');
            $table->string('accTypeTitle');
            $table->unsignedBigInteger('uId');

            // Add the foreign key constraint
            // $table->foreign('uId')->references('uId')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('accType');
    }
};
