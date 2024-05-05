<?php

namespace App\Http\Controllers;

use App\Models\Incedent;
use App\Models\IncidentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    public function createIncident(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|'
        ]);
        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = 'incidentImg'.time().$ext;
        $image->storePubliclyAs('/storage/incident_images', $image);
        $user = Auth::user();
        $slug = $request->name. \Str::random(3).time().$user->id;

        $incident = new Incedent();
        $incident->name = $request->name;
        $incident->image = $imageName;
        $incident->slug = $slug;
        $incident->user_id = $user->id;
        $incident->save();

        return response()->json([
            'success' => true,
            'incident' => $incident,
        ]);
    }

    public function viewIncidents()
    {
        $user = Auth::user();
        $userIncidents = $user->incidents()->take(100)->get();
        return response()->json([
            'success' => true,
            'user_incidents' => $userIncidents,
        ]);
    }

    public function selectIncidents()
    {
        $incidents = Incedent::latest()->take(100)->get();
        return response()->json([
            'success' => true,
            'incidents' => $incidents,
        ]);
    }

    public function viewYourIncidents()
    {
       $user = Auth::user();
       $homeCareIncidents = $user->incidentDetails()->take(100)->get();

       return response()->json([
        'success' => true,
        'incidents' => $homeCareIncidents,
    ]);

    }

    public function singleIncident($slug)
    {
        $incidentDetail = IncidentDetail::where('slug', $slug)->first();
        return response()->json([
            'success' => true,
            'incidents' =>  $incidentDetail,
        ]);
    }
}
