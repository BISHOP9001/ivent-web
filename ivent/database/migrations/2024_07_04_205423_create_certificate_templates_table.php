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
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settings_id');
            $table->string('background_image_url');
            $table->text('layout_details');  // This could store JSON or other structured data defining the layout
            $table->timestamps();

            $table->foreign('settings_id')->references('id')->on('event_settings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_templates');
    }
};
