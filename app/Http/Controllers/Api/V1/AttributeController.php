<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeResource;
use App\Models\Attribute;
use Illuminate\Http\Request;

/**
 * @group Attributes
 *
 * This set of endpoints lets user to interact with attributes
 */
class AttributeController extends Controller
{
    /**
     * attribute list
     *
     * This endpoint allow user to fetch all attribute
     *
     * @authenticated
     */
    public function index()
    {
        $attributes = Attribute::latest()->paginate(parent::ELEMENTS_PER_PAGE)->withQueryString();

        return AttributeResource::collection($attributes)->additional([
            'meta' => [
                'success' => true,
                'code' => 200,
                'message' => 'Attributes fetched successfully',
                'direct' => null,
            ],
        ]);
    }

    /**
     * show attribute
     *
     * This endpoint allow user to get a single attribute
     *
     * @authenticated
     */
    public function show(Attribute $attribute)
    {
        return $this->sendSuccessResponse(data: new AttributeResource($attribute));
    }

    /**
     * store attribute
     *
     * This endpoint allow user to store attribute
     *
     * @authenticated
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $attribute = Attribute::create($data);

        return $this->sendSuccessResponse(data: new AttributeResource($attribute), message: 'Attribute created successfully');
    }

    /**
     * update attribute
     *
     * This endpoint allow user to update attribute
     *
     * @authenticated
     */
    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
        ]);

        $attribute->update($data);

        return $this->sendSuccessResponse(data: new AttributeResource($attribute), message: 'Attribute updated successfully');
    }

    /**
     * delete attribute
     *
     * This endpoint allow user to delete attribute with attributes
     *
     * @authenticated
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return $this->sendSuccessResponse(message: 'Attribute deleted successfully');
    }
}
