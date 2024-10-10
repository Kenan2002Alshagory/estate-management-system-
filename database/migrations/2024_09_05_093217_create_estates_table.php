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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['sale','rent','sold','rented']);
            $table->enum('property_category',['commercial','residential','agricultural','industrial']);
            $table->enum('indicators',['negotiable','residential','agricultural','industrial']);
            $table->string('name');
            $table->string('location');
            $table->text('description');
            $table->string('code')->nullable();
            $table->double('space');
            $table->double('number_of_bedrooms')->nullable();
            $table->double('number_of_bathrooms')->nullable();
            $table->double('number_of_floors')->nullable();
            $table->double('number_of_parking_spaces')->nullable();
            $table->date('year_of_construction')->nullable();
            $table->json('geo_location')->nullable() ;
            $table->json('services')->nullable();
            $table->string('3d_photo')->nullable();
            $table->string('blueprint')->nullable();
            $table->string('video_url')->nullable();
            $table->double('price')->nullable();
            $table->string('rental_duration')->nullable();
            $table->json('filters')->nullable();
            $table->json('photos');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
