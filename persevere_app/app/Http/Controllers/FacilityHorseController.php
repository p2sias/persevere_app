<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Facility,Horse,FacilityHorse,ExceptionFacility,DayFacility};
use App\Http\Resources\{FacilityResource,HorseResource,FacilityHorseResource};
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FacilityHorseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Facility $facility, Horse $horse)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }
        
        $inputs = $request->all();

        // Check exceptions
        $selected_start_date = Carbon::parse($inputs['start_date']);
        $selected_end_date = Carbon::parse($inputs['end_date']);

        $exception_facility = ExceptionFacility::where('facility_id', '=', $facility->id)->get();

        foreach($exception_facility as $exc_facility){
            $start_date = Carbon::parse($exc_facility->start_date);
            $end_date = Carbon::parse($exc_facility->end_date);

            if(($start_date < $selected_start_date && $selected_start_date < $end_date) || ($start_date < $selected_end_date && $selected_end_date < $end_date)){
                return response()->json(["error" => "Impossible de réserver cette date, l'installation n'est pas disponible à cette date."]);
            }
        }

        // Check if max customers reserved the date
        $count_customers = 0;
        $max_customers = $facility->max_customers;
        
        $facility_horse = FacilityHorse::where([['facility_id', '=', $facility->id],['status','=','reserved'],['start_date','>',Carbon::now()]])->get();

        foreach($facility_horse as $fac_horse){
            $start_date = Carbon::parse($fac_horse->start_date);
            $end_date = Carbon::parse($fac_horse->end_date);

            if(($start_date < $selected_start_date && $selected_start_date < $end_date) || ($start_date < $selected_end_date && $selected_end_date < $end_date)){
                $count_customers++;
                if($count_customers >= $max_customers){
                    return response()->json(["error" => "La date demandée se superpose au maximum de rendez-vous possibles au même moment."]);
                }
            }
        }

        // Check date validity
        $selected_start_date = Carbon::parse($inputs['start_date'])->format('HH:MM:SS');
        $selected_end_date = Carbon::parse($inputs['end_date'])->format('HH:MM:SS');

        $day_facility = DayFacility::where('facility_id', '=', $facility->id)->get();

        foreach($day_facility as $day_fac){
            $start_date = Carbon::parse("2000-01-01 $day_fac->start_hour:$day_fac->start_minute:00")->format('HH:MM:SS');
            $end_date = Carbon::parse("2000-01-01 $day_fac->end_hour:$day_fac->end_minute:00")->format('HH:MM:SS');

            if($selected_start_date < $start_date){ // If selected date (start) < facility start date
                return response()->json(["error" => "La date de début du rendez-vous ne respecte pas la plage horaires de l'installation."]);
            }
            elseif($selected_end_date > $end_date){ // If selected date (end) > facility end date
                return response()->json(["error" => "La date de fin du rendez-vous ne respecte pas la plage horaires de l'installation."]);
            }
        }

        // Create new FacilityHorse instance
        $facilityHorse = new FacilityHorse();
        $facilityHorse->start_date = $inputs['start_date'];
        $facilityHorse->end_date = $inputs['end_date'];
        $facilityHorse->facility_id = $facility->id;
        $facilityHorse->horse_id = $horse->id;
        $facilityHorse->status = "reserved";
        $facilityHorse->save();

        return response()->json(["success" => new FacilityHorseResource($facilityHorse)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FacilityHorse $facilityHorse
     * @return \Illuminate\Http\Response
     */
    public function cancel(Request $request, FacilityHorse $facilityHorse)
    {
        $validator = Validator::make($request->all(), [
            'decline_reason' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update FacilityHorse
        $inputs = $request->all();

        $facilityHorse->status = "canceled";
        $facilityHorse->decline_reason = $inputs['decline_reason'];
        $facilityHorse->update();

        return response()->json(["success" => "Rendez-vous annulé avec succès !"]);
    }

    /**
     * Refuse the specified resource from storage.
     *
     * @param  \App\Models\FacilityHorse $facilityHorse
     * @return \Illuminate\Http\Response
     */
    public function decline(Request $request, FacilityHorse $facilityHorse)
    {
        $validator = Validator::make($request->all(), [
            'decline_reason' => 'required|string|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(["input_error" => $validator->errors()]);
        }

        // Update FacilityHorse
        $inputs = $request->all();

        $facilityHorse->status = "declined";
        $facilityHorse->decline_reason = $inputs['decline_reason'];
        $facilityHorse->update();

        return response()->json(["success" => "Rendez-vous décliné avec succès !"]);
    }
}