<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'company_name' => $this->company_name,
            'salary_min' => $this->salary_min,
            'salary_max' => $this->salary_max,
            'is_remote' => $this->is_remote,
            'job_type' => $this->job_type,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'languages' => $this->languages->pluck('name'),
            'locations' => $this->locations->pluck('city'),
            'categories' => $this->categories->pluck('name'),
            'attributes' => $this->attributeValues->map(function ($attributeValue) {
                return [
                    'name' => $attributeValue->attribute->name,
                    'value' => $attributeValue->value,
                ];
            }),
        ];
    }
}
