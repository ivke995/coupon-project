<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\Used;
use App\Models\Email;
use App\Models\Coupon;
use App\Models\Status;
use App\Models\Subtype;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prophecy\Argument\Token\NotInArrayToken;

class CouponController extends Controller
{
    
    public function create() 
    {
        $types = Type::all();
        $subtypes = Subtype::all();
        $statuses = Status::all();
        return view('coupon.create', compact( 'types', 'subtypes', 'statuses'));
    }

    // -> Function to store new coupon  <- \\

    public function store(Request $request) 
    {

        // -> First we do multiple validations, in messages we can realize which of validations are involved  <- \\

        if($request->type_id == 1 && !isset($request->creator_email))
        {
            return redirect('coupon/create')->with('fail', 'You have to specify email address for single coupons');
        }

        if($request->type_id != 2 && isset($request->limit))
        {
           
            return redirect('coupon/create')->with('fail', 'You can set limit only with multi-limit type');

        }

        if($request->type_id == 2 && $request->limit < 1)
        {
            return redirect('coupon/create')->with('fail', 'Limit can not be under 1');
    
        }

        if(!in_array($request->type_id, [3, 4]) && isset($request->valid_until))
        {
            return redirect('coupon/create')->with('fail', 'You can set date only with single-expires or multi-expires');
        }

        if($request->type_id == 2 && !isset($request->limit))
        {
            return redirect('coupon/create')->with('fail', 'You can set limit only with multi-limit type coupon');
        }

        if(in_array($request->type_id, [3, 4]) && !isset($request->valid_until))
        {
            return redirect('coupon/create')->with('fail', 'You have to set date with expires coupons');
        }

        if(in_array($request->type_id, [3, 4]) && $request->valid_until < Carbon::now()->format('Y-m-d'))
        {
            return redirect('coupon/create')->with('fail', 'You can not set a date in the past.');
        }

        if(in_array($request->subtype_id, [1, 2]) && !isset($request->value))
        {
            return redirect('coupon/create')->with('fail', 'You must set a value');
        }

        if($request->subtype_id == 3 && isset($request->value))
        {
            return redirect('coupon/create')->with('fail', 'You can not set a value with free coupons.');
        }
        
        if($request->subtype_id == 1 && !in_array($request->value, range(5, 95)))
        {
            return redirect('coupon/create')->with('fail', 'You must set value between 5 and 95');
        }

        if(!filter_var($request->creator_email, FILTER_VALIDATE_EMAIL) && $request->type_id != 1 && $request->creator_email != null) 
        {
            return redirect('coupon/create')->with('fail', 'Email is not valid');
        }
        
        $request->validate([
            'email'=>'',
            'type_id'=>'required',
            'subtype_id'=>'required',
            // 'status_id'=>'required',
        ]);
        
        
        $code = strtoupper(Str::random(6));
        // $status_default = 1;
        
        $data = Coupon::create([
            'creator_email'=>request('creator_email'),
            'type_id'=>request('type_id'),
            'subtype_id'=>request('subtype_id'),
            // 'status_id'=>request('status_id'),
            // 'status_id' => 1,
            'code'=>$code,
            'value'=>request('value'),
            'limit'=>request('limit'),
            'valid_until'=>request('valid_until')
        ]);
        
        // dd($status_default);
        if (!$data->exists()) {
            Coupon::create($request->except('_token', 'email'));
        }

         return redirect('coupon/all')->with('success', 'You have created your coupon');
        
    }

    // -> Function to list all active coupons without single coupons  <- \\

    public function active() 
    {
        $coupons = Coupon::with('type', 'subtype', 'status')->where('status_id', '=', 1)->get();
        $types = Type::all();
        $subtypes = Subtype::all();
        $statuses = Status::all();
        return view('coupon.active', compact('coupons', 'types', 'subtypes', 'statuses'));
    }

    // -> Function to list all coupons  <- \\

    public function all() 
    {
        $coupons = Coupon::with('type', 'subtype', 'status')->get();

        $types = Type::all();
        $subtypes = Subtype::all();
        $statuses = Status::all();
        return view('coupon.all', compact('coupons', 'types', 'subtypes', 'statuses'));

    }

    // -> Function to list all used coupons with emails that used coupons  <- \\

    public function used() 
    {
        $useds = DB::table('useds')
                    ->join('coupons', 'coupons.id', '=', 'useds.coupon_id')
                    ->join('emails', 'emails.id', '=', 'useds.email_id')
                    ->join('types', 'coupons.type_id', '=', 'types.id')
                    ->join('subtypes', 'coupons.subtype_id', '=', 'subtypes.id')
                    ->join('statuses', 'coupons.status_id', '=', 'statuses.id')
                    ->select('types.type_name', 'subtypes.subtype_name', 'statuses.status_name', 'coupons.*', 'emails.*', 'useds.*')
                    ->paginate(10);
                  
    $coupons = Coupon::all();
    $types = Type::all();
    $subtypes = Subtype::all();
    $statuses = Status::all();
    $emails = Email::all();


    return view('coupon.used', compact('useds','coupons', 'types', 'subtypes', 'statuses', 'emails'));
        
    }     
    
    // -> Function to list all non-used coupons  <- \\

    public function non_used() 
    {
        $coupons = Coupon::with('type', 'subtype', 'status')->where('used_times', '=', null)->get();

        $types = Type::all();
        $subtypes = Subtype::all();
        $statuses = Status::all();
        return view('coupon.non_used', compact('coupons', 'types', 'subtypes', 'statuses'));
    }

    // -> Function to edit exists coupons  <- \\

    public function edit(Request $request)
    {
        $coupon = Coupon::where('id', $request->id)->first();

        return view('coupon.edit', compact('coupon'));
    }

    // -> Function to update exists coupons  <- \\

    public function update(Request $request)
    {
        Coupon::where('id',  $request->id)->update($request->except(['_token', '_method', 'id']));

        return redirect('coupon/all')->with('success', 'You have updated your coupon successfully');
    }

    // -> Function to delete exists coupons  <- \\

    public function delete (Request $request)
    {
        Coupon::destroy($request->id);

        return redirect('coupon/all')->with('success', 'You have deleted you coupon successfully');
    }


}
