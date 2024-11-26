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
        Schema::create('board_template_extra_rule', function (Blueprint $table) {
            $table->id();

            $table->foreignId('board_template_id');
            $table->foreignId('extra_rule_id');

            $table->text('value');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_template_extra_rule');
    }
};
