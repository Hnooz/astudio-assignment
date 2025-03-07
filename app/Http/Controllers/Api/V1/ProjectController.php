<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\AssignProjectAttribute;
use App\Models\Project;
use App\Models\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(parent::ELEMENTS_PER_PAGE)->withQueryString();

        return ProjectResource::collection($projects)->additional([
            'meta' => [
                'success' => true,
                'code' => 200,
                'message' => 'Projects fetched successfully',
                'direct' => null,
            ]
        ]);
    }

    public function show(Project $project)
    {
        return $this->sendSuccessResponse(new ProjectResource($project));
    }

    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        $project = Project::create(Arr::except($data, ['attributes']));
        if (isset($data['attributes'])){
            collect($data['attributes'])->each(function ($attrData) use ($project) {
                $attribute = Attribute::find($attrData['id']);
                AttributeValue::updateOrCreate(
                    ['attribute_id' => $attribute->id, 'entity_id' => $project->id],
                    ['value' => $attrData['value']]
                );

            });
        }
        return $this->sendSuccessResponse(data: new ProjectResource($project), message: 'Project created successfully');
    }

    public function update(StoreProjectRequest $request, Project $project, AssignProjectAttribute $assignProjectAttribute)
    {
        $data = $request->validated();
        $project->update(Arr::except($data, ['attributes']));

        if (isset($data['attributes'])){
            collect($data['attributes'])->each(function ($attrData) use ($project) {
                $attribute = Attribute::find($attrData['id']);
                AttributeValue::updateOrCreate(
                    ['attribute_id' => $attribute->id, 'entity_id' => $project->id],
                    ['value' => $attrData['value']]
                );

            });
        }

        return $this->sendSuccessResponse(data: new ProjectResource($project), message: 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return $this->sendSuccessResponse(message: 'Project deleted successfully');
    }
}
