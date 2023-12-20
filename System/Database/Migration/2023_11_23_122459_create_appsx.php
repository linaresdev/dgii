<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('terms', function (Blueprint $table) {

            $table->bigIncrements("id");

            $table->string("type")->default("users-groups");
            $table->unsignedBigInteger("parent")->default(0);

            $table->string("slug", 30);
            $table->string("name", 50)->nullable();

            $table->string("description", 200)->nullable();

            $table->char("activated", 1)->default(1);

            $table->char("aling", 2)->default(0);

            $table->unsignedBigInteger("counter")->default(0);

            $table->timestamps();
        });

        Schema::create('termsmeta', function ($table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger("term_id");
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string("type", 30)->nullable();

            $table->unsignedBigInteger("parent")->default(0);

            $table->string("key", 200);
            $table->text("value");

            $table->unsignedBigInteger("counter")->default(0);

            $table->boolean("activated")->default(0);
         });

        Schema::create('termstaxonomies', function (Blueprint $table) 
        {
            $table->bigIncrements("id");

            $table->bigInteger('term_id')->unsigned();
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->bigInteger('tax_id')->unsigned();

            $table->text("meta")->nullable();

            $table->unsignedBigInteger("counter")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('termstaxonomies');
        Schema::dropIfExists('termsmeta');
        Schema::dropIfExists('terms');
    }
};
