<?php

namespace App\Http\Controllers;

use App\Models\Incedent;
use Illuminate\Http\Request;

class IncidentDetailController extends Controller
{
    public function clientUploadIncident(Request $request, $slug)
    {
        $data = $request->validate([
            'date' => 'required',
            'incident_type' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ]);

        $user = Auth::user();
        $incidentCategory = Incedent::were('slug', $slug)->first();
        $home_care_id = $incidentCategory->user_id;
        $slug = \Str::random(5).time().$user->id;
        $data['slug'] = $slug;
        $data['user_id'] =$user->id;
        $data['home_care_id'] =$home_care_id;
        $incidentDetail = $incidentCategory->incidentDetail()->create($data);

        return response()->json([
            'success' => true,
            'incidentDetails' => $incidentDetail,
        ]);
    }
}
