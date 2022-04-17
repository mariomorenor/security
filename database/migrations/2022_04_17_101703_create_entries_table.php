<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->timestamp("date_in");
            $table->timestamp("date_out")->nullable();
            $table->foreignId("client_id")->constrained("clients");
            $table->foreignId("camera_id")->constrained("cameras");
            $table->foreignId("responsible_id")->constrained("responsibles");
            $table->foreignId("visitor_id")->constrained("visitors");
            $table->foreignId("reason_id")->constrained("reasons");
            $table->text("observation")->nullable();
            $table->string("image_path")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
