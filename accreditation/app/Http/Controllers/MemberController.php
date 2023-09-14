<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accreditation;
use App\Models\Member;
use App\Models\User;
use DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        // $members = Member::join()->select()->where('accreditation_id', $id);
        // return view('admin.manage_user')->with('members', $members)->with('id', $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'members'=>'required',
        ];

        $customMessage = [
            'required'=>'select a user to add',
        ];

        $this->validate($request, $rules, $customMessage);

        $acc_members = $request->input('members');
        $acc_id = $request->input('acc_id');

        $members = new Member();
        foreach($acc_members AS $member)
        {
            $members = DB::insert('INSERT INTO `members` (`accreditation_id`, `user_id`, `created_at`, `updated_at`) VALUES ( ?, ?, ?, ?)', [ $acc_id, $member, NOW(), NOW()]);
        }
        if ($members) {
            // Add a flash message to indicate successful deletion
            session()->flash('success', 'User/s added successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->route('admin.manage_user.show', ['id'=>$acc_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $members = Member::join('users', 'members.user_id',  '=', 'users.id')->select('users.firstname AS fname', 'users.lastname AS lname', 'members.user_id AS uid', 'members.id AS mid', 'users.*', 'members.*')->where('accreditation_id', $id)->get();
        //$users = User::select()->where('isAdmin', '!=', 1)->get();

        $users = DB::select('SELECT * FROM users WHERE isAdmin != 1 AND NOT EXISTS (SELECT * FROM members WHERE accreditation_id = ? AND members.user_id = users.id)', [$id]);
        return view('admin.manage_user')->with('members', $members)->with('id', $id)->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($action, $id)
    {
        //
        $member = Member::find($id);
        if($member){
            $member->delete();
            session()->flash('success', 'User removed successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }
        return redirect()->back();

    }
}
