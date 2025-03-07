<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttributeValueResource;


 /**
 * @group Attribute Values
 *
 * This set of endpoints lets user to interact with attribute values
 */
class AttributeValueController extends Controller
{
     /**
        * attribute values list
        *
        * This endpoint allow user to fetch all attribute values
        *
        * @authenticated
    */
    public function index()
    {
        $attribute_values = AttributeValue::latest()->paginate(parent::ELEMENTS_PER_PAGE)->withQueryString();

        return AttributeValueResource::collection($attribute_values)->additional([
            'meta' => [
                'success' => true,
                'code' => 200,
                'message' => 'Attribute values fetched successfully',
                'direct' => null,
            ]
        ]);
    }

     /**
     * show attribute value
     *
     * This endpoint allow user to get a single attribute value
     *
     * @authenticated
     */
    public function show(AttributeValue $attribute_value)
    {
        return $this->sendSuccessResponse(data: new AttributeValueResource($attribute_value));
    }

     /**
     * store attribute value
     *
     * This endpoint allow user to store attribute value 
     *
     * @authenticated
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'value' => ['required'],
            'attribute_id' => ['required', 'integer', 'exists:attributes,id'],
            'entity_id' => ['required', 'integer'],
        ]);

        $attribute_value = AttributeValue::create($data);

        return $this->sendSuccessResponse(data: new AttributeValueResource($attribute_value), message: 'Attribute value created successfully');
    }

       /**
     * update attribute value
     *
     * This endpoint allow user to update attribute value 
     *
     * @authenticated
     */

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $data = $request->validate([
            'value' => ['required'],
            'attribute_id' => ['required', 'integer', 'exists:attributes,id'],
            'entity_id' => ['required', 'integer'],
        ]);

        $attributeValue->update($data);

        return $this->sendSuccessResponse(data: new AttributeValueResource($attributeValue), message: 'Attribute value updated successfully');
    }

    /**
     * delete attribute value
     *
     * This endpoint allow user to delete attribute value
     *
     * @authenticated
     */
    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return $this->sendSuccessResponse(message: 'Attribute value deleted successfully');
    }
}
