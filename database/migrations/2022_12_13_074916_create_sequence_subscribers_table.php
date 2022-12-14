<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequence_subscribers', function (Blueprint $table) {
            $table->foreignId('sequence_id');
            $table->foreignId('subscriber_id');
            $table->dateTime('subscribed_at')->useCurrent();
            $table->enum('status', ["in_process", "completed"])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequence_subscribers');
    }
};
