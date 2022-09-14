<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Email;
use App\Models\Coupon;
use App\Models\Status;
use App\Models\Subtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{

    // -> Function to filter by multiple parameters <- \\
    
    public function filter(Request $request) {

    // -> First we create queries with parameters and tables that we need for specific kinds of coupons  <- \\

        if($request->current_table == 'coupon.all')
        {
            $coupons = Coupon::query()
                    ->join('types', 'coupons.type_id', '=', 'types.id')
                    ->join('subtypes', 'coupons.subtype_id', '=', 'subtypes.id')
                    ->join('statuses', 'coupons.status_id', '=', 'statuses.id')
                    ->select('types.type_name', 'subtypes.subtype_name', 'statuses.status_name', 'coupons.*');
        }
        elseif($request->current_table == 'coupon.active')
        {
            $coupons = Coupon::query()
                    ->join('types', 'coupons.type_id', '=', 'types.id')
                    ->join('subtypes', 'coupons.subtype_id', '=', 'subtypes.id')
                    ->join('statuses', 'coupons.status_id', '=', 'statuses.id')
                    ->where('status_id', '=', 1)
                    ->where('type_id', '!=', 1 )
                    ->select('types.type_name', 'subtypes.subtype_name', 'statuses.status_name', 'coupons.*');
        }
        elseif($request->current_table == 'coupon.used')
        {
            $coupons = DB::table('useds')
                ->join('coupons', 'coupons.id', '=', 'useds.coupon_id')
                ->join('emails', 'emails.id', '=', 'useds.email_id')
                ->join('types', 'coupons.type_id', '=', 'types.id')
                ->join('subtypes', 'coupons.subtype_id', '=', 'subtypes.id')
                ->join('statuses', 'coupons.status_id', '=', 'statuses.id')
                ->select('types.type_name', 'subtypes.subtype_name', 'statuses.status_name', 'coupons.*', 'emails.*', 'useds.*');
            
        }
        elseif($request->current_table == 'coupon.non_used')
        {
            $coupons = Coupon::query()
                    ->join('types', 'coupons.type_id', '=', 'types.id')
                    ->join('subtypes', 'coupons.subtype_id', '=', 'subtypes.id')
                    ->join('statuses', 'coupons.status_id', '=', 'statuses.id')
                    ->where('status_id', '=', 1)
                    ->select('types.type_name', 'subtypes.subtype_name', 'statuses.status_name', 'coupons.*');
        }
        elseif($request->current_table == 'email.addresse')
        {
            $coupons = DB::table('emails')->select('emails.*');
        }

        // -> After we created query that we need,we are checking wich of the parameters are specified in filter options   <- \\

        $coupons->when(request('used_at', false), function ($q, $used_at) { 
            return $q->where('used_at', '>', $used_at);
        });
        $coupons->when(request('used_to', false), function ($q, $used_to) { 
            return $q->where('used_at', '<', $used_to);
        });         
        $coupons->when(request('created_at', false), function ($q, $created_at) { 
            return $q->where('created_at', '>', $created_at);
        });
        $coupons->when(request('created_to', false), function ($q, $created_to) { 
            return $q->where('created_at', '<', $created_to);
        });
        $coupons->when(request('type_id', false), function ($q, $type_id) { 
            return $q->where('type_id', $type_id);
        });
        $coupons->when(request('subtype_id', false), function ($q, $subtype_id) { 
            return $q->where('subtype_id', $subtype_id);
        });
        $coupons->when(request('value', false), function ($q, $value) { 
            return $q->where('value', 'LIKE',  "%$value%");
        });
        $coupons->when(request('status_id', false), function ($q, $status_id) { 
            return $q->where('status_id', $status_id);
        });
        $coupons->when(request('used_times', false), function ($q, $used_times) { 
            return $q->where('used_times', $used_times);
        });
        $coupons->when(request('coupons_used', false), function ($q, $coupons_used) { 
            return $q->where('coupons_used', $coupons_used);
        });
        $coupons->when(request('creator_email', false), function ($q, $creator_email) { 
            return $q->where('creator_email', 'LIKE', "%$creator_email%");
        });
        $coupons->when(request('email', false), function ($q, $email) { 
            return $q->where('email', 'LIKE', "%$email%");
        });
    
        $emails = $coupons->get();
        $useds = $coupons->get();
        $coupons = $coupons->get();

        $types = Type::all();
        $subtypes = Subtype::all();
        $statuses = Status::all();
        $filter = false;
    
        return view($request->current_table, compact('coupons', 'types', 'subtypes', 'statuses', 'filter', 'emails', 'useds'));

    
        }
    }

        