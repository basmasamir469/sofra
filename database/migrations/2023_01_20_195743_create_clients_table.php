<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name', 191);
			$table->string('phone', 191);
			$table->string('email', 191);
			$table->string('password', 191);
			$table->integer('district_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}