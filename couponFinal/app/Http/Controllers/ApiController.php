<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Used;
use App\Models\Email;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    // -> Function for store new created coupon via API  <- \\

    public function store(Request $request)
    {

        // -> Multiple validation to create coupons   <- \\

        if($request->type_id == 1 && !isset($request->email))
        {
            return response()->json([
                'status' => false,
                'message' => 'You have to set email address for single coupons'
            ]);
        }

        if($request->type_id != 2 && isset($request->limit))
        {
            
            return response()->json([
                'status' => false,
                'message' => 'You can set limit only with multi-limit type'
            ]);

        }

        if(!in_array($request->type_id, range(1, 5)))
        {
            return response()->json([
                'status' => false,
                'message' => 'Set valid coupon type id.'
            ]);
        }

        if(!in_array($request->subtype_id, range(1, 3)))
        {
            return response()->json([
                'status' => false,
                'message' => 'Set valid coupon subtype id.'
            ]);
        }

        if(in_array($request->type_id, [3, 4]) && !isset($request->valid_until))
        {
            return response()->json([
                'status' => false,
                'message' => 'You have to set date only with single-expires or multi-expires'
            ]);
        }

        if($request->type_id == 2 && !isset($request->limit))
        {
            return response()->json([
                'status' => false,
                'message' => 'You have to set limit only with multi-limit type coupon'
            ]);
        }

        if($request->type_id == 2 && $request->limit < 1)
        {
            return response()->json([
                'status' => false,
                'message' => 'Limit can not be under 1!'
                ]);
        }

        if(in_array($request->type_id, [3, 4]))
        {
            $format = ('Y-m-d');
            $d = DateTime::createFromFormat($format, $request->valid_until);
            $res = $d && $d->format($format) == $request->valid_until;
         
            if($res === false) {
                return response()->json([
                    'status' => false,
                    'message' => 'You must set valid date format.'
                ]);
            }
        }

        if(in_array($request->type_id, [3, 4]) && $request->valid_until < Carbon::now()->format('Y-m-d'))
        {
            return response()->json([
                'status' => false,
                'message' => 'You can not set a date in the past.'
            ]);
        }
        

        if(in_array($request->subtype_id, [1, 2]) && !isset($request->value))
        {

            return response()->json([
                'status' => false,
                'message' => 'You must set a value'
            ]);
        }

        if($request->subtype_id == 3 && isset($request->value))
        {
            return response()->json([
                'status' => false,
                'message' => 'You can not set a value with free coupons.'
            ]);
        }

        if($request->subtype_id == 1 && !in_array($request->value, range(5, 95)))
        {
            return response()->json([
                'status' => false,
                'message' => 'You must set value between 5 and 95'
            ]);
        }
        
        $code = strtoupper(Str::random(6));
        if($request->email){
            if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) 
                {
            return response()->json([
                'status'  => 'False',
                'data_error' => "Email is not valid"
            ]);
                }
}

    // -> If all upper conditions get TRUE,next step is to create new Coupon   <- \\

        $data = Coupon::create([
            'creator_email'=>request('email'),
            'type_id'=>request('type_id'),
            'subtype_id'=>request('subtype_id'),
            'status_id'=>1, 
            'code'=>$code,
            'value'=>request('value'),
            'limit'=>request('limit'),
            'valid_until'=>request('valid_until')
        ]);

        if(!$data->exists()) {
            Coupon::create($request->except('email'));
        }

        return response()->json([
            'status' => true,
            'email' => $request->email,
            'code' => $code,
            'message' => 'You created your coupon successfully'
        ]);
    }
    
    // -> Function for using coupons via API <- \\

    public function index(Request $request)
    {


        // -> First we are checking if there is CODE in our database  <- \\

        $coupon = Coupon::where([
            'code' => $request->code
        ])->first();
        
        if(!$coupon)
        {
            return response()->json([
                'status' => false,
                'message' => 'This coupon does not exists in our database'
            ]);
        }

        if($coupon->type_id == 1) 
        {
            $coupon = Coupon::where([
                'creator_email' => $request->email,
                'code' => $request->code
            ])->first();
        
                if(!$coupon)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'This email is not owner of this coupon,please try again'
                    ]);
                }

                if($coupon->status_id == 2)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Email is already used that coupon'
                    ]);
                }

                Coupon::where('id', $coupon->id)->update(['status_id' => 2]);
        
        }

        // -> Here we are checking if there is email that is connected with coupon_id  <- \\

    
        if($coupon->type_id == 1)    
        {
            $coupon_email = Email::where('email', $request->email)->where('coupon_id',$coupon->id);
            
            if($coupon_email->exists())
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'You have already used this coupon'
            ]);
        }
        
        else {
            $email = Email::create([
                'email' => $request->email,
                'coupon_id' => $coupon->id,
            ]);
            $used = Used::create([
                'coupon_id' => $coupon->id,
                'email_id' => $email->id,
                'used_at' => Carbon::now()
                ]);

            $coupon->status_id = 2;
            $coupon->update();

            $coupon_email = Email::where('email', $request->email)->first();
            
            if($coupon_email->first_coupon_used == null)
            {
                $email->update([
                    'first_coupon_used' => Carbon::now()
                ]);
            }
            else 
            {
                $email->update([
                    'last_coupon_used' => Carbon::now()
                ]);
            }
            $coupon->used_times++;
            $email->coupons_used++;
            $coupon->save();
            $email->save();
                
            return response()->json([
                    'status' => true,
                    'message' => 'You have used your coupon successfully'
                ]);
            }
        }     elseif($coupon->type_id == in_array($coupon->type_id, [2, 3])) 
        {

            $email = Email::where('email', $request->email)->first();

            if($email)
            {
                $used = Used::where('email_id', $email->id)->where('coupon_id', $coupon->id);
                
                if($used->exists())
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'You can use only one coupon per email address!'
                    ]);
                }
            }
            if($coupon->used_times == $coupon->limit && $coupon->limit != null)
            {
                $coupon->status_id = 2;
                $coupon->update();

                return response()->json([
                    'status' => false,
                    'message' => 'You can not use coupon because limit is reached'
                ]);
            }

            if(in_array($coupon->type_id, [3, 4]) && Carbon::now()->toDateString() > ($coupon->valid_until))
            {
                $coupon->status_id = 2;
                $coupon->update();

                return response()->json([
                    'status' => false,
                    'message' => 'You can not use coupon because date is expired'
                ]);
            }

            $coupon->update();
                
        } elseif($coupon->type_id == 4) 
        {
            if(Carbon::now()->toDateString() > ($coupon->valid_until))
            {
                $coupon->status_id = 3;
                $coupon->update();

                return response()->json([
                    'status' => false,
                    'message' => 'You can not use coupon because date is expired'
                ]);
            }
            $coupon->update();
        }
        $email = Email::where('email', $request->email)->first();

        if(!$email) 
        {
            $email = Email::create([
                'email' => $request->email,
                'coupon_id' => $coupon->id
            ]);
        }

        if($email->first_coupon_used == null)
        {
            $email->update([
                'first_coupon_used' => Carbon::now()
            ]);
        } else {
            $email->update([
                'last_coupon_used' => Carbon::now()
            ]);
        }
        
        $email->coupons_used++;
        $coupon->used_times++;
        $email->save();
        $coupon->save();

        Used::create([
            'coupon_id' => $coupon->id,
            'email_id' => $email->id
        ]);

        return response()->json([
            'status' => true, 
            'message' => 'THIS COUPON IS GREAT'
        ]);
    } 
}


