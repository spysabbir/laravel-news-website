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
        Schema::create('default_setting_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('default_setting_id');
            $table->string('locale')->index();
            $table->string('app_name')->nullable();
            $table->string('support_phone')->nullable();
            $table->string('support_email')->nullable();
            $table->text('address')->nullable();
            $table->unique(['default_setting_id', 'locale']);
            $table->foreign('default_setting_id')->references('id')->on('default_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_setting_translations');
    }
};
