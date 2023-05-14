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
    public function up()
    {
        Schema::create('page_setting_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_setting_id');
            $table->string('locale')->index();
            $table->string('page_name');
            $table->string('page_slug');
            $table->longText('page_description');
            $table->unique(['page_setting_id', 'locale']);
            $table->foreign('page_setting_id')->references('id')->on('page_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_setting_translations');
    }
};
