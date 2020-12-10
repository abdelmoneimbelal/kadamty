<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	public function up()
	{
		Schema::create('cities', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->unsignedBigInteger('governrate_id');
            $table->foreign('governrate_id')->references('id')->on('governorates')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::drop('cities');
	}
}