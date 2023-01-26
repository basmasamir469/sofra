<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('notificationable_id');
			$table->string('notificationable_type', 191);
			$table->integer('order_id')->unsigned();
			$table->string('title');
			$table->text('content');
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}