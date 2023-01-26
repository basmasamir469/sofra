<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResturantsTable extends Migration {

	public function up()
	{
		Schema::create('resturants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name', 191);
			$table->string('email', 191);
			$table->string('phone', 50);
			$table->integer('district_id')->unsigned();
			$table->string('password', 191);
			$table->decimal('delivery_cost');
			$table->decimal('minimum_order');
			$table->string('image', 191);
			$table->string('contact_phone', 191);
			$table->integer('status');
		});
	}

	public function down()
	{
		Schema::drop('resturants');
	}
}