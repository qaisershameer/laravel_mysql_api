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
        Schema::create('accParent', function (Blueprint $table) {
            $table->increments('parentId');
            $table->string('accParentTitle');

            $table->unsignedSmallInteger('accTypeId');
            // Add the foreign key constraint Account Type Id
            $table->foreign('accTypeId')->references('accTypeId')->on('accType')->onDelete('restrict'); // Prevent deletion if foreign key exists

            $table->unsignedSmallInteger('uId');
            // Add the foreign key constraint with restrict on delete
            $table->foreign('uId')->references('uId')->on('users')->onDelete('restrict'); // Prevent deletion if foreign key exists
                                    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accParent');
    }
};
