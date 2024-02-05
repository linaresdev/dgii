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
            $table->string("env")->default("testecf");
            $table->string("name",150);
            $table->string("rnc",20);

            $table->text("p12")->nullable();
            $table->text("password"); 
                      
            $table->text("meta")->nullable();

            $table->char("activated")->default(1);
            
            $table->integer("emision_comprobante")->default(0);
            $table->integer("emision_aprobacion")->default(0);
            $table->integer("recepcion_aprobacion")->default(0);
            $table->integer("recepcion_acuserecibo")->default(0);

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
