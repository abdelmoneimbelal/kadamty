<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	public function up()
	{
		Schema::create('services', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('price');
			$table->string('image');
			$table->text('description')->nullable();
			$table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categoreis')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('services');
	}
}