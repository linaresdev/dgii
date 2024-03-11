<?php

Route::get("/", "HomeController@index");

Route::prefix("{rnc}")->group(function()
{
    Route::get("/", "EntityController@index");

    Route::get("/config/set/{key}/{value}", "EntityController@setConfig");

    //Route::get("/arecf", "EntityController@arecf");
    Route::get("/acecf", "EntityController@acecf");
    

    Route::prefix("ecf")->group(function()
    {        
        Route::prefix("{ecfID}")->group(function()
        {

            ## ARECF
            Route::get("arecf", "EntityController@arecf");
            Route::get("arecf/download", "EntityController@downloadArecf");

            ## ACECF
            Route::get("acecf", "EntityController@acecf");
            Route::get("acecf/download", "EntityController@downloadAcecf");

            Route::get("acecf/send/mail", "EntityController@getSendMailAcecf");
            Route::post("acecf/send/mail", "EntityController@postSendMailAcecf");

            ## SEND ACECF
            Route::get("acecf/send", "EntityController@getSendACECF");
            Route::post("acecf/send/", "EntityController@postSendACECF");
        });

        // Route::get("{ecfID}/send/acecf", "EntityController@getSendACECF");
        // Route::post("{ecfID}/send/acecf", "EntityController@postSendACECF");

    //     Route::get("{ecfID}/send/acecf/schema", function()
    //     {
    //         if( !\Schema::hasTable("ECF") )
    //         {
    //            \Schema::create('ECF', function ($table)
    //             {
    //                 $table->bigIncrements("id");

    //                 $table->unsignedInteger("hacienda_id");
    //                 $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');
                                        
    //                 $table->string("eNCF",20);
    //                 $table->string("RNCComprador", 20);
    //                 $table->string("FechaEmision", 20);
                    
    //                 $table->text("descripcion")->nullable();

    //                 $table->text("ecf");

    //                 $table->char("acecf", 1)->nullable();
    //                 $table->char("arecf", 1)->nullable();

    //                 $table->timestamps();
    //             });
    //         }
    //         if( !\Schema::hasTable("ACECF") )
    //         {
    //            \Schema::create('ACECF', function ($table)
    //             {
    //                 $table->bigIncrements("id");

    //                 $table->unsignedInteger("hacienda_id");
    //                 $table->foreign('hacienda_id')->references('id')->on('HACIENDAS')->onDelete('CASCADE')->onUpdate('CASCADE');
                    
    //                 $table->string("RNCEmisor", 20);
    //                 $table->string("RNCComprador", 20);
    //                 $table->string("eNCF",20);
    //                 $table->boolean("Estado")->default(0);
    //                 $table->string("DetalleMotivoRechazo", 250)->nullable();
    //                 $table->string("FechaHoraAprobacionComercial",20);                    

    //                 $table->text("ecf");
    //                 $table->text("acecf");

    //                 $table->timestamps();
    //             });
    //         }
    //     });
    });
    
});