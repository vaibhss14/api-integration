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
        Schema::create('survey_qualifications', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('survey_id');
            $table->bigInteger('qualification_id');

            $table->string('answer_id');

            $table->timestamp('update_timestamp')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_qualifications');
    }
};
