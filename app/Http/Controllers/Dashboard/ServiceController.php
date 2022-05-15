<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Service;
use App\Models\UserAdvantage;
use App\Models\ServiceAdvantage;
use App\Models\ServiceThumbnail;
use App\Models\Tagline;
use App\Models\User;

class ServiceController extends Controller
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
        $services = Service::where('users_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();        

        return view('pages.Dashboard.service.index', compact('services', 'user_advantages', 'service_advantages', 'service_thumbnails', 'taglines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.Dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->all();
        $data['users_id'] = Auth::user()->id;

        // Store to service
        $service = Service::create($data);

        // Store to user advantage
        foreach ($data['advantage-user'] as $value) {
            $user_advantage = new UserAdvantage;
            $user_advantage->services_id = $service->id;
            $user_advantage->advantage = $value;
            $user_advantage->save();
        }

        // Store to service advantage
        foreach ($data['advantage-service'] as $value) {
            $service_advantage = new ServiceAdvantage;
            $service_advantage->services_id = $service->id;
            $service_advantage->advantage = $value;
            $service_advantage->save();
        }

        // Store to service thumbnails
        if ($request->hasFile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file) {
                $path = $file->store('assets/service/thumbnails', 'public');

                $thumbnail = new ServiceThumbnail;
                $thumbnail->services_id = $service->id;
                $thumbnail->thumbnail = $path;
                $thumbnail->save();
            }
        }

        // Store to taglines
        foreach ($data['tagline'] as $value) {
            $tagline = new Tagline;
            $tagline->services_id = $service->id;
            $tagline->tagline = $value;
            $tagline->save();
        }

        Alert::toast('Service has been added', 'success');
        return redirect()->route('member.service.index');
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
    public function edit(Service $service)
    {
        $user_advantages = UserAdvantage::where('services_id', $service->id)->get();
        $service_advantages = ServiceAdvantage::where('services_id', $service->id)->get();
        $service_thumbnails = ServiceThumbnail::where('services_id', $service->id)->get();
        $taglines = Tagline::where('services_id', $service->id);

        return view('pages.Dashboard.service.edit', compact('user_advantages', 'service_advantages', 'service_thumbnails', 'taglines'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->all();

        // Update to Services
        $service->update($data);

        // Update to User Advantages
        foreach ($request['advantage-user'] as $key => $value) {
            $user_advantage = UserAdvantage::find($key);    
            $user_advantage->advantage = $value;
            $user_advantage->save();
        }

        // Add new data to User Advantages
        if (isset($data['advantage-user'])) {
            foreach ($data['advantage-user'] as $key => $value) {
                $user_advantage = new UserAdvantage; 
                $user_advantage->services_id = $service->id;   
                $user_advantage->advantage = $value;
                $user_advantage->save();
            }
        }

        // Update to Service Advantages
        foreach ($request['advantage-service'] as $key => $value) {
            $service_advantage = ServiceAdvantage::find($key);    
            $service_advantage->advantage = $value;
            $service_advantage->save();
        }

        // Add new data to Service Advantages
        if (isset($data['advantage-service'])) {
            foreach ($data['advantage-service'] as $key => $value) {
                $service_advantage = new ServiceAdvantage; 
                $service_advantage->services_id = $service->id;   
                $service_advantage->advantage = $value;
                $service_advantage->save();
            }
        }

        // Update to Taglines
        foreach ($request['tagline'] as $key => $value) {
            $tagline = Tagline::find($key);    
            $tagline->tagline = $value;
            $tagline->save();
        }

        // Add new data to Taglines
        if (isset($data['tagline'])) {
            foreach ($data['tagline'] as $key => $value) {
                $tagline = new Tagline; 
                $tagline->services_id = $service->id;   
                $tagline->tagline = $value;
                $tagline->save();
            }
        }

        // Update to Service Thumbnails
        if ($request->hasfile('thumbnails')) {
            foreach ($request->file('thumbnails') as $key => $file) {
                // get old thumbnails
                $old_thumbnail_data = ServiceThumbnail::find($key);

                // store thumbnail
                $path = $file->store('assets/service/thumbnails', 'public');

                // update thumbnail
                $service_thumbnail = new ServiceThumbnail;
                $service_thumbnail->services_id = $service->id;
                $service_thumbnail->thumbnail = $path;
                
                // delete old thumbnail
                $old_thumbnail_path = 'storage/' . $old_thumbnail_data['thumbnail'];
                if (Storage::exists($old_thumbnail_path)) {
                    Storage::destroy($old_thumbnail_path);
                } else {
                    Storage::destroy('storage/app/public/' . $old_thumbnail_data['thumbnail']);
                }
            }
        }

        // Add new data to Service Thumbnails
        if ($request->hasfile('thumbnail')) {
            foreach ($request->file('thumbnail') as $file) {                
                $path = $file->store('assets/service/thumbnails', 'public');

                $new_thumbnail = new ServiceThumbnail;
                $new_thumbnail->services_id = $service->id;
                $new_thumbnail->thumbnail = $path;
                $new_thumbnail->save();
            }
        }

        Alert::toast('Thumbnails has been updated', 'success');
        return redirect()->route('member.service.index');
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
}