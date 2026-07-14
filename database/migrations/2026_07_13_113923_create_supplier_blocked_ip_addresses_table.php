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
        Schema::create('supplier_blocked_ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->integer('completed_surveys')->default(0);
            $table->integer('reconcile_rate')->default(0);
            $table->timestamp('updated_timestamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_blocked_ip_addresses');
    }
};
