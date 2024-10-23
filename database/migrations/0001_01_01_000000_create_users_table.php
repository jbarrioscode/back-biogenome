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
            $table->string('firstName', 60);
            $table->string('middleName', 60)->nullable();
            $table->string('lastName', 60);
            $table->string('surName', 60)->nullable();
            $table->string('username', 20)->unique();
            $table->string('document', 25)->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->boolean('userStatus')->default(1);
            $table->date('passwordExpirationDate')->nullable();

            /** Foreign Key Fields */
            $table->unsignedBigInteger('doc_type_id');
            $table->unsignedBigInteger('user_id');

            /** Foreign Key References */
            $table->foreign('doc_type_id')->references('id')->on('doc_types');
            $table->foreign('user_id')->references('id')->on('users');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
