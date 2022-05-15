<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\Dashboard\Profile\UpdateProfileRequest;
use App\Http\Requests\Dashboard\Profile\UpdateUserDetailRequest;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserExperience;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user_experiences = UserExperience::where('user_details_id', $user->user_detail->id)
                            ->orderBy('id', 'asc')
                            ->get();

        return view('pages.Dashboard.profile', compact('user', 'user_experiences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request_profile, UpdateUserDetailRequest $request_user_detail)
    {
        $data_profile = $request_profile->all();
        $data_user_details = $request_user_detail->all();

        $user_details = UserDetail::where('users_id', Auth::user()->id)->first();

        if (isset($data_user_details['photo'])) {
            $get_photo = 'storage/' . $user_details['photo'];

            if (Storage::exists($get_photo)) {
                Storage::delete($get_photo);
            } else {
                Storage::delete('storage/app/public/' . $user_details['photo']);
            }

            $data_user_details['photo'] = $request_user_detail->file('photo')->store('assets/photo', 'public');
        }        

        // Update to User Table
        $user = User::find(Auth::user()->id);
        $user->update($data_profile);

        // Update to User Details Table
        $user_details->update($data_user_details);

        // Update to User Experiences Table
        $data_user_experience = UserExperience::where('user_details_id', $user_details->id)->first();

        if ($data_user_experience) {
            foreach ($data_profile['experience'] as $key => $value) {
                $user_experience = UserExperience::find($key);
                $user_experience->user_details_id = $user_details['id'];
                $user_experience->experience = $value;
                $user_experience->save();
            }
        } else {
            foreach ($data_profile['experience'] as $key => $value) {
                if (isset($value)) {
                    $user_experience = new UserExperience;
                    $user_experience->user_details_id = $user_details->id;
                    $user_experience->experience = $value;
                    $user_experience->save();
                }
            }
        }

        Alert::toast('Profile has been changed', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }

    public function delete_photo()
    {
        $user_detail = UserDetail::where('users_id', Auth::user()->id)->first();
        $user_photo = $user_detail['photo'];

        // Update user photo to null
        $user_detail->photo = NULL;
        $user_detail->save();

        // Delete photo from storage
        $path_photo = 'storage/' . $user_photo;
        if (Storage::exists($path_photo)) {
            Storage::delete($path_photo);
        } else {
            Storage::delete('storage/app/public', $path_photo);
        }

        Alert::toast('Photo Profile has been changed', 'success');
        return back();
    }
}