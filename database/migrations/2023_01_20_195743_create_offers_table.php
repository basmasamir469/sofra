<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('offer_name',191);
			$table->string('image', 191);
			$table->text('description');
			$table->date('from');
			$table->date('to');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}