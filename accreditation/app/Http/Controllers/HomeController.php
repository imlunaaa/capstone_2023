<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::id())
        {
            $areachair=Auth()->user()->isAreachair;
            $areamember=Auth()->user()->isAreamember;
            $admin=Auth()->user()->isAdmin;
            $internal=Auth()->user()->isInternal;
            $external=Auth()->user()->isExternal;

            if($admin=='1')
            {
                return view('admin.adminhome');
            }
            if($areachair =='1' || $areamember == '1')
            {
                return view('area chair.areachairhome');
            }
            if($internal=='1')
            {
                return view('internal accreditor.internalhome');
            }
            if($external=='1')
            {
                return view('external accreditor.externalhome');
            }
            else
            {
                return redirect()->back();
            }
        }
    }
}
