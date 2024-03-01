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
            $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');

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
            $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string("rnc");
            $table->string("encf");
            $table->string("estadoAprobacion");
            $table->text("urlAprobacionComercial");
            $table->string("urlAutenticacion");

            $table->char("state")->default(0);

            $table->timestamps();
        });

        Schema::create('APROBACIONCOMERCIAL', function (Blueprint $table)
        {
            $table->bigIncrements("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string("RNCEmisor", 20);
            $table->string("eNCF",20);
            $table->string("FechaEmision",20);
            $table->string("RNCComprador",20);
            $table->string("filename",200);
            $table->text("path")->nullable();

            $table->text("meta")->nullable();

            $table->char("state", 1)->default(0);

            $table->timestamps();
        });
        
        Schema::create('RECEPCION', function (Blueprint $table)
        {
            $table->bigIncrements("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string("eNCF",20);
            $table->string("FechaEmision",20);
            
            $table->string("RNCEmisor", 20);
            $table->string("RNCComprador", 20);
            $table->string("RazonSocialComprador", 250);

            $table->string("TipoeCF", 20);
            $table->text("fileName");
            $table->text("path");

            $table->char("state")->default(0);

            $table->timestamps();
        });
        Schema::create('ARECF', function (Blueprint $table)
        {
            $table->bigIncrements("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->string("RNCEmisor", 20);
            $table->string("RNCComprador", 20);
            $table->string("eNCF",20);
            $table->boolean("Estado")->default(0);
            $table->string("FechaHoraAcuseRecibo",20);
            
            $table->char("CodigoMotivoNoRecibido", 1)->nullable();

            $table->text("pathECF");
            $table->text("pathARECF");

            $table->timestamps();
        });

        Schema::create('ACECF', function (Blueprint $table)
        {
            $table->bigIncrements("id");

            $table->unsignedInteger("hacienda_id");
            $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');
            
            $table->string("RNCEmisor", 20);
            $table->string("RNCComprador", 20);
            $table->string("eNCF",20);
            $table->boolean("Estado")->default(0);
            $table->string("FechaHoraAcuseRecibo",20);
            
            $table->char("CodigoMotivoNoRecibido", 1)->nullable();

            $table->text("pathECF");
            $table->text("pathACECF");

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
        Schema::dropIfExists('APROBACIONCOMERCIAL');
        Schema::dropIfExists('RECEPCION');
        Schema::dropIfExists('ARECF');
        Schema::dropIfExists('ACECF');
    }
};
