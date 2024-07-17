<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormFieldTemplateValue;

class FormFieldTemplateValueSeeder extends Seeder
{
    public function run()
    {
        FormFieldTemplateValue::create(['form_field_template_id' => 1, 'value' => 'Option 1']);
        FormFieldTemplateValue::create(['form_field_template_id' => 1, 'value' => 'Option 2']);
    }
}
