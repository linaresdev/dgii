<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{    
    public function up(): void
    {
        Schema::create("HACIENDAS", function (Blueprint $table)
        {
            $table->increments("id");

            $table->string("name",150);
            $table->string("slug",30);
            $table->text("token");
            $table->string("password", 100);
            $table->text("certify");

            $table->integer("counter_emisioncomprobante")->default(0);
            $table->integer("counter_emisionaprobacioncomercial")->default(0);
            $table->integer("counter_recepcionaprobacioncomercial")->default(0);
            $table->integer("counter_recepcionacuserecibo")->default(0);

            $table->text("xml");

            $table->text("meta");
            $table->char("activated")->default(1);

            $table->timestamps();
        });

         Schema::create('HACIENDAS_META', function (Blueprint $table) {

            $table->increments("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->string("type")->default("info");

            $table->string("key");
            $table->text("value");
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('HACIENDAS_META');
        Schema::dropIfExists('HACIENDAS');
    }
};
