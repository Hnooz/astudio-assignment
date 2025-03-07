<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TimeSheet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimeSheetRequest;
use App\Http\Resources\TimeSheetResource;

class TimeSheetController extends Controller
{
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

    public function show(TimeSheet $timeSheet)
    {
        return $this->sendSuccessResponse(new TimeSheetResource($timeSheet));
    }

    public function store(StoreTimeSheetRequest $request)
    {
        $data = $request->validated();
        $timeSheet = TimeSheet::create($data);

        return $this->sendSuccessResponse(data: new TimeSheetResource($timeSheet), message: 'Time sheet created successfully');
    }

    public function update(StoreTimeSheetRequest $request, TimeSheet $timeSheet)
    {
        $data = $request->validated();
        $timeSheet->update($data);

        return $this->sendSuccessResponse(data: new TimeSheetResource($timeSheet), message: 'Time sheet updated successfully');
    }

    public function destroy(TimeSheet $timeSheet)
    {
        $timeSheet->delete();

        return $this->sendSuccessResponse(message: 'Time sheet deleted successfully');
    }

}
