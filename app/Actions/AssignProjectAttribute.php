<?php

namespace App\Actions;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;

class AssignProjectAttribute
{
    public function execute(Project $project, array $data)
    {
        if (isset($data['attributes'])) {
            collect($data['attributes'])->each(function ($attrData) use ($project) {
                $attribute = Attribute::find($attrData['id']);
                AttributeValue::updateOrCreate(
                    ['attribute_id' => $attribute->id, 'entity_id' => $project->id],
                    ['value' => $attrData['value']]
                );
            });
        }
    }
}
