<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormFieldTemplate;

class FormFieldTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormFieldTemplate::create([
            'name' => 'Full Name',
            'field_type' => 'text',
            'default_value' => null,
            'required' => true,
            'event_id' => 1,
        ]);

        FormFieldTemplate::create([
            'name' => 'Email',
            'field_type' => 'email',
            'default_value' => null,
            'required' => true,
            'event_id' => 1,
        ]);

        FormFieldTemplate::create([
            'name' => 'Speciality',
            'field_type' => 'select',
            'default_value' => json_encode(['Developer', 'Designer', 'Manager']),
            'required' => false,
            'event_id' => 1,
        ]);

        FormFieldTemplate::create([
            'name' => 'City',
            'field_type' => 'text',
            'default_value' => null,
            'required' => true,
            'event_id' => 1,
        ]);

        FormFieldTemplate::create([
            'name' => 'Country',
            'field_type' => 'text',
            'default_value' => null,
            'required' => true,
            'event_id' => 1,
        ]);
    }
}
