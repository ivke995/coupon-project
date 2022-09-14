<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class AddresseController extends Controller
{
    public function addresse() 
    {
        $emails = Email::paginate(10);

        return view('email.addresse', compact('emails'));
    }
}
