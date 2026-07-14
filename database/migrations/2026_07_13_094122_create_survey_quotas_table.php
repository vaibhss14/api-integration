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
        Schema::create('survey_quotas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('survey_id');
            $table->bigInteger('quota_id');
            $table->string('quota_name');
            $table->integer('total_remaining')->nullable();
            $table->bigInteger('qualification_id')->nullable();
            $table->string('answer_id')->nullable();
            $table->timestamp('update_timestamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_quotas');
    }
};
