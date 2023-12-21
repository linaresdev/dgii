<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('EMISIONCOMPROBANTE', function (Blueprint $table)
        {
            $table->bigIncrements("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('haciendas')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string("rnc");
            $table->string("tipoEncf");
            $table->text("urlRecepcion");
            $table->text("urlAutenticacion")->nullable();

            $table->char("state")->default(0);

            $table->timestamps();
        });
        Schema::create('EMISIONAPROVACIONCOMERCIAL', function (Blueprint $table)
        {
            $table->bigIncrements("id");
            
            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('haciendas')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string("rnc");
            $table->string("encf");
            $table->string("estadoAprobacion");
            $table->text("urlAprobacionComercial");
            $table->string("urlAutenticacion");

            $table->char("state")->default(0);

            $table->timestamps();
        });
        Schema::create('RECEPCIONAPROBACIONCOMERCIAL', function (Blueprint $table)
        {
            $table->bigIncrements("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('haciendas')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string("Version", 10);
            $table->string("RNCEmisor", 20);
            $table->string("eNCF",20);
            $table->string("FechaEmision",20);
            $table->string("RNCComprador",20);
            $table->char("Estado",1);
            $table->text("DetalleMotivoRechazo");
            $table->string("FechaHoraAprobacionComercial",20);

            $table->text("xml");

            $table->char("state", 1)->default(0);

            $table->timestamps();
        });
        Schema::create('RECEPCIONACUSERECIBO', function (Blueprint $table)
        {
            $table->bigIncrements("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('haciendas')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string("rnc", 20);
            $table->string("tipoEncf", 20);
            $table->text("urlRecepcion");
            $table->text("urlAutenticacion")->nullable();

            $table->text("xml");

            $table->char("state")->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('EMISIONCOMPROBANTE');
        Schema::dropIfExists('EMISIONAPROVACIONCOMERCIAL');
        Schema::dropIfExists('RECEPCIONAPROBACIONCOMERCIAL');
        Schema::dropIfExists('RECEPCIONACUSERECIBO');
    }
};
