<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealsTable extends Migration {

	public function up()
	{
		Schema::create('meals', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name', 191);
			$table->decimal('price');
			$table->decimal('price_after_offer')->nullable();
			$table->text('description');
			$table->string('preparation_time', 191);
			$table->string('image', 191);
		});
	}

	public function down()
	{
		Schema::drop('meals');
	}
}