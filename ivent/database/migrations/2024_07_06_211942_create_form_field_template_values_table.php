<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldTemplateValuesTable extends Migration
{
    public function up()
    {
        Schema::create('form_field_template_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_field_template_id')->constrained()->onDelete('cascade');
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_field_template_values');
    }
}
