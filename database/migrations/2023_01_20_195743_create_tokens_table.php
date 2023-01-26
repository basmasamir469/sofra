<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTokensTable extends Migration {

	public function up()
	{
		Schema::create('tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('tokennable_id');
			$table->string('tokennable_type', 191);
			$table->string('token');
			$table->string('api_token');
			$table->string('type');
		});
	}

	public function down()
	{
		Schema::drop('tokens');
	}
}