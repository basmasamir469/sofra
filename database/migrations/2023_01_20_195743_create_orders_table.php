<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('address', 191);
			$table->text('notes')->nullable();
			$table->integer('payment_method');
			$table->decimal('delivery_cost')->nullable();
			$table->decimal('total_cost');
			$table->decimal('meals_cost');
			$table->decimal('app_comission');
			$table->decimal('net');
			$table->integer('status');
			$table->integer('client_id')->unsigned();
			$table->integer('resturant_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}