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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->json('geo_location')->nullable() ;
            $table->text('description');
            $table->string('location');
            $table->boolean('block')->default(false);
            $table->enum('type',['engineering_companies','real_estate_companies','real_estate_maintenance_companies']);
            $table->json('contact_information')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('companies');
    }
};
