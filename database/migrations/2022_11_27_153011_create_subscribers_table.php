<?php

use Domain\Shared\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('email', 50)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->foreignId('form_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('subscribed_at')->useCurrent();
            $table->timestamps();

            $table->unique(['user_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
