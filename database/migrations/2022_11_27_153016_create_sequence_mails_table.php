<?php

use Domain\Shared\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSequenceMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequence_mails', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 100);
            $table->enum('status', ["draft", "sent"]);
            $table->longText('content');
            $table->json('filters');
            $table->unsignedBigInteger('sequence_id');
            $table->unsignedBigInteger('schedule_id');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequence_mails');
    }
}
