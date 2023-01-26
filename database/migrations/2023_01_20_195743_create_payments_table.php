<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('resturant_id')->unsigned();
			$table->string('payment_name', 191);
			$table->decimal('payment_cost');
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}