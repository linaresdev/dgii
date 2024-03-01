<?php

Route::get("/", "HomeController@index");

Route::prefix("{rnc}")->group(function()
{
    Route::get("/", "EntityController@index");

    Route::get("/arecf", "EntityController@arecf");
    Route::get("/acecf", "EntityController@acecf");
    

    Route::prefix("ecf")->group(function()
    {

        Route::get("{ecfID}/send/acecf", "EntityController@getSendACECF");
        Route::post("{ecfID}/send/acecf", "EntityController@postSendACECF");

        Route::get("{ecfID}/send/acecf/schema", function(){
            if( !\Schema::hasTable("ACECF") )
            {
               \Schema::create('ACECF', function ($table)
                {
                    $table->bigIncrements("id");

                    $table->unsignedInteger("hacienda_id");
                    $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');
                    
                    $table->string("RNCEmisor", 20);
                    $table->string("RNCComprador", 20);
                    $table->string("eNCF",20);
                    $table->boolean("Estado")->default(0);
                    $table->string("DetalleMotivoRechazo", 250)->nullable();
                    $table->string("FechaHoraAprobacionComercial",20);                    

                    $table->text("ecf");
                    $table->text("acecf");

                    $table->timestamps();
                });
            }
        });
    });
    
});