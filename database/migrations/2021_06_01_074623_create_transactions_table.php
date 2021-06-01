<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subscription_id')->unsigned()->index();
            $table->bigInteger('provider_id')->unsigned()->index();
            $table->integer('provider_user_id');
            $table->string('status');
            $table->double('payment_amount', 9, 2);
            $table->dateTime('payment_time');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('cascade');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
