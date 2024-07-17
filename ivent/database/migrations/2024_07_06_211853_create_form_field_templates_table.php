<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('form_field_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('field_type');
            $table->string('default_value')->nullable();
            $table->boolean('required')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_field_templates');
    }
}
