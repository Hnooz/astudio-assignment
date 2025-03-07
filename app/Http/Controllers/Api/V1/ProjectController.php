<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\AssignProjectAttribute;
use App\Models\Project;
use App\Models\Attribute;
use Illuminate\Support\Arr;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\StoreProjectRequest;
use Illuminate\Http\Request;

 /**
 * @group Projects
 *
 * This set of endpoints lets user to interact with Projects
 */
class ProjectController extends Controller
{
      /**
     * projects list
     *
     * This endpoint allow user to fetch all projects
     *
     * @authenticated
     */
    public function index(Request $request)
    {
        $allowedOperators = ['=', '>', '<', '>=', '<=', 'LIKE'];

        $projects = Project::with(['attributeValues.attribute', 'timeSheets', 'users'])
            ->when($request->filled('filters'), function ($query) use ($request, $allowedOperators) {
                foreach ($request->filters as $name => $value) {
                    $query->whereHas('attributeValues', function ($q) use ($name, $value, $allowedOperators) {
                        $q->whereHas('attribute', fn ($attrQuery) => $attrQuery->where('name', $name));
                        $operator = '=';
                        if (preg_match('/^(>=|<=|>|<|LIKE) (.+)$/i', $value, $matches)) {
                            $operator = strtoupper($matches[1]);
                            $value = $matches[2];
                        }
                        if (!in_array($operator, $allowedOperators)) {
                            return; // Skip invalid operators
                        }

                        if ($operator === 'LIKE') {
                            // Split value into words and match any of them (OR condition)
                            $q->where(function ($likeQuery) use ($value) {
                                foreach (explode(' ', $value) as $word) {
                                    $likeQuery->orWhere('value', 'LIKE', "%{$word}%");
                                }
                            });
                        } else {
                            $q->where('value', $operator, $value);
                        }
                    });
                }
            })
            ->latest()
            ->paginate(parent::ELEMENTS_PER_PAGE)
            ->withQueryString();



        return ProjectResource::collection($projects)->additional([
            'meta' => [
                'success' => true,
                'code' => 200,
                'message' => 'Projects fetched successfully',
                'direct' => null,
            ]
        ]);
    }
 /**
     * show project
     *
     * This endpoint allow user to get a single project
     *
     * @authenticated
     */
    public function show(Project $project)
    {
        return $this->sendSuccessResponse(new ProjectResource($project));
    }

    /**
     * store project
     *
     * This endpoint allow user to store project with attributes
     *
     * @authenticated
     */
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
/**
     * update project
     *
     * This endpoint allow user to update project with attributes
     *
     * @authenticated
     */
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
/**
     * delete project
     *
     * This endpoint allow user to delete project with attributes
     *
     * @authenticated
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return $this->sendSuccessResponse(message: 'Project deleted successfully');
    }
}
