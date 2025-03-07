<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TimeSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimeSheetRequest;
use App\Http\Resources\TimeSheetResource;

 /**
 * @group Time sheets
 *
 * This set of endpoints lets user to interact with time sheets
 */
class TimeSheetController extends Controller
{
    /**
     * time sheets list
     *
     * This endpoint allow user to fetch all time sheets
     *
     * @authenticated
     */
    public function index()
    {
        $timeSheets = TimeSheet::latest()->paginate(parent::ELEMENTS_PER_PAGE)->withQueryString();

        return TimeSheetResource::collection($timeSheets)->additional([
            'meta' => [
                'success' => true,
                'code' => 200,
                'message' => 'TimeSheets fetched successfully',
                'direct' => null,
            ]
        ]);
    }
 /**
     * show time sheet
     *
     * This endpoint allow user to get a single time sheet
     *
     * @authenticated
     */
    public function show(TimeSheet $timeSheet)
    {
        return $this->sendSuccessResponse(new TimeSheetResource($timeSheet));
    }
  /**
     * store time sheet
     *
     * This endpoint allow user to store time sheet with attributes
     *
     * @authenticated
     */
    public function store(StoreTimeSheetRequest $request)
    {
        $data = $request->validated();
        $timeSheet = TimeSheet::create($data);

        return $this->sendSuccessResponse(data: new TimeSheetResource($timeSheet), message: 'Time sheet created successfully');
    }
  /**
     * update time sheet
     *
     * This endpoint allow user to update time sheet with attributes
     *
     * @authenticated
     */
    public function update(StoreTimeSheetRequest $request, TimeSheet $timeSheet)
    {
        $data = $request->validated();
        $timeSheet->update($data);

        return $this->sendSuccessResponse(data: new TimeSheetResource($timeSheet), message: 'Time sheet updated successfully');
    }

/**
     * delete time sheet
     *
     * This endpoint allow user to delete time sheet with attributes
     *
     * @authenticated
     */
    public function destroy(TimeSheet $timeSheet)
    {
        $timeSheet->delete();

        return $this->sendSuccessResponse(message: 'Time sheet deleted successfully');
    }

}
