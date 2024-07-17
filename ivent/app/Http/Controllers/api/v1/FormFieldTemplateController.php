<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\FormFieldTemplate;
use App\Models\FormFieldTemplateValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class FormFieldTemplateController extends Controller
{
    // Get form fields for a specific event
    public function getFormFields($eventId)
    {
        $formFields = FormFieldTemplate::where('event_id', $eventId)->get();
        return response()->json($formFields);
    }

    // Fill the form with user input
    public function fillForm(Request $request)
    {
        $validated = $request->validate([
            'form_fields' => 'required|array',
            'form_fields.*.field_id' => 'required|exists:form_field_templates,id',
            'form_fields.*.value' => 'required|string|max:255',
        ]);
        foreach ($validated['form_fields'] as $formField) {
            FormFieldTemplateValue::create([
                'form_field_template_id' => $formField['field_id'],
                'value' => $formField['value'],
            ]);
        }

        return response()->json(['message' => 'Form filled successfully'], Response::HTTP_CREATED);
    }
}
