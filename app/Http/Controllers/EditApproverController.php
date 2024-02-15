<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditApproverController extends Controller
{
   public function editApprover()
   {
    return view('EditApproverView');
   }
}
