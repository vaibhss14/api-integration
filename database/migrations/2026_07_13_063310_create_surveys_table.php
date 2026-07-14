<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {

            $table->id();

            $table->bigInteger('survey_id')->unique();
            $table->string('survey_name');

            $table->integer('industry_id');
            $table->integer('country_id');
            $table->integer('study_type_id');

            $table->decimal('cpi', 8, 2)->nullable();
            $table->integer('loi')->nullable();
            $table->integer('ir')->nullable();

            $table->boolean('collect_pii')->default(false);

            $table->boolean('is_mobile')->default(false);
            $table->boolean('is_tablet')->default(false);
            $table->boolean('is_desktop')->default(false);

            $table->boolean('is_survey_group_exist')->default(false);

            $table->integer('client_id')->nullable();
            $table->integer('account_id')->nullable();

            $table->text('live_link')->nullable();
            $table->text('test_link')->nullable();

            $table->timestamp('update_timestamp')->nullable();
            $table->timestamp('qual_update_timestamp')->nullable();
            $table->timestamp('quota_update_timestamp')->nullable();
            $table->timestamp('group_update_timestamp')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
