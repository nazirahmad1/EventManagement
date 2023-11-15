<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attenndee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{

    use CanLoadRelationships;

    private   $relations =['user'];


 public function __construct()
    {
            $this->middleware('auth:sanctum')->except(['index','show','update']);
            $this->middleware('throttle:api')
            ->only(['store','destroy']);
            $this->authorizeResource(Attenndee::class,'attendee');
    }

        public function index(Event $event)
    {
            $attendees = $this->loadRelationships($event->attendees()->latest());

            return AttendeeResource::collection([
                $attendees->paginate()
            ]);
    }


    public function store(Request $request,Event $event)
    {
        $attendee = $this->loadRelationships($event->attendees()->create([
            'user_id'=>$request->user()->id
        ]));

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event,Attenndee $attendee)
    {
            return new AttendeeResource($this->loadRelationships($event));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event,Attenndee $attendee)
    {
            $attendee->delete();
            return response(status:204);
    }
}
