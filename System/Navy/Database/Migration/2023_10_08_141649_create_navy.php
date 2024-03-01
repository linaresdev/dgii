<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('navies', function (Blueprint $table) {            
            $table->id();

            $table->bigInteger("parent")->default(0);

            $table->string("icon", 200);
            $table->string("label", 150);
            $table->text("url");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('navies');
    }
};
