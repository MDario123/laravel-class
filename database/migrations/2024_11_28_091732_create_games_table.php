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
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_id')
                ->constrained('board_templates');

            $table->foreignId('player1_id')
                ->constrained('users');

            $table->foreignId('player2_id')
                ->constrained('users');

            $table->string('player1_move')->nullable()->default(null);
            $table->string('player2_move')->nullable()->default(null);

            $table->integer('turn')->default(0);
            $table->jsonb('player1_state');
            $table->jsonb('player2_state');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
