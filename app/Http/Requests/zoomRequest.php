<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class zoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => ($this->input('_method') != 'PUT') ? "required|exists:orders,id" : "",
            'topic' => 'required|string|unique:zoom_meetings,topic,' . (($this->input('_method') === 'PUT') ?  $this->meeting->id : ''),
            'start' => 'required|date',
            'agenda' => 'string|nullable',
            'duration' => (($this->input('_method') === 'PUT') && (is_numeric($this->input('duration')))) ? 'required|numeric' : 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'topic.required' => __('zoom.topic'),
            'start.required' => __('zoom.start'),
            'duration.required' => __('zoom.duration'),
        ];
    }
}
