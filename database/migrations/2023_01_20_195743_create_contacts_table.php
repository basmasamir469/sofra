<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->enum('status', array('enquiry', 'suggestion', 'complaint'));
			$table->string('name', 191);
			$table->string('email', 191);
			$table->string('phone', 191);
			$table->text('message');
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}