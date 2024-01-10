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
        Schema::table("users", function(Blueprint $table)
        {
            $table->string('type', 20)->default("user")->after("id");
            $table->string('fullname')->nullable()->after("name");
            $table->string("firstname", 30)->nullable()->after("fullname");    
            $table->string("lastname", 30)->nullable()->after("firstname");
            $table->string("rnc", 30)->nullable()->after("lastname");
            $table->string('user')->nullable()->after("rnc");
            $table->string('cellphone')->nullable()->after("user");
            $table->string("avatar", 200)->default("__avapath/avatar.png")->after("password");
            $table->string('gender', 30)->nullable()->after("password");
            $table->char("activated", 1)->default(0)->after("avatar");
        });

        Schema::create('usersmeta', function (Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
 
            $table->string("type", 30)->default("info");
 
            $table->string('key', 255);
            $table->text('value')->nullable();
 
            $table->boolean('activated')->default(1);
            
            $table->timestamps();
        });
        
        Schema::create('userstask', function (Blueprint $table)
        {            
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id')->default(0);            
            
            $table->string("type", 30)->default("retry-pass");
            $table->string("host", 45)->nullable();

            $table->string("guard", 30)->default("web");
            $table->string("header", 150)->nullable();
            $table->string("token", 80)->nullable();

            $table->text("path", 45)->nullable();

            $table->text("agent")->nullable();

            $table->text("meta")->nullable();
            $table->char("activated", 1)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersmeta');
        Schema::dropIfExists('userstask');

        Schema::table("users", function(Blueprint $table){
            $table->dropColumn([
                "type",
                "fullname",
                "firstname",
                "lastname",
                "rnc",
                "user",
                "cellphone",
                "avatar",
                "activated"
            ]);
        });        
    }
};
