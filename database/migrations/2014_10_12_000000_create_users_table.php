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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->text('description')->nullable() ;
            $table->integer('days')->default(0);
            $table->string('photo')->nullable();
            $table->string('whats_number')->nullable();
            $table->boolean('verifyAccount')->default(false);
            $table->string('email')->unique()->nullable();
            $table->string('location')->nullable();
            $table->boolean('block')->default(false);
            $table->enum('type',['admin','client','office']);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('verifyOffice')->default(false);
            $table->string('qr_code')->nullable();
            $table->string('fcm_token')->nullable() ;
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
