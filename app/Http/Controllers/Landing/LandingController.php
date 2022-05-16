<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceAdvantage;
use App\Models\ServiceThumbnail;
use App\Models\Tagline;
use App\Models\UserAdvantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('pages.Landing.index', compact('services'));
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
    public function update(Request $request, $id)
    {
        return abort(404);
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

    public function explore()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('pages.Landing.explore', compact('services'));
    }

    public function detail($id)
    {
        $service = Service::where('id', $id)->first();

        $user_advantages = UserAdvantage::where('services_id', $service->id)->get();
        $service_advantages = ServiceAdvantage::where('services_id', $service->id)->get();
        $service_thumbnails = ServiceThumbnail::where('services_id', $service->id)->get();
        $taglines = Tagline::where('services_id', $service->id)->get();

        return view('pages.Landing.detail', compact('service', 'user_advantages', 'service_advantages', 'service_thumbnails', 'taglines'));
    }

    public function booking($id)
    {
        $service = Service::where('id', $id)->first();
        $user_buyer = Auth::user()->id;

        // Booking Validation
        if ($service->users_id == $user_buyer) {
            Alert::toast('Sorry, members cannot book their own service!', 'error');
            return back();
        }

        $order = new Order;
        $order->services_id = $service->id;
        $order->freelancer_id = $service->users_id;
        $order->buyer_id = $user_buyer;
        $order->file = NULL;
        $order->note = NULL;
        $order->expired = Date('y-m-d', strtotime('+3 days'));
        $order->order_status_id = 4;
        $order->save();

        $order_detail = Order::where('id', $order->id)->first();
        return redirect()->route('landing.detail-booking', $order->id);
    }

    public function detail_booking($id)
    {
        $order = Order::where('id', $id)->first();

        return view('pages.Landing.booking', compact('order'));
    }
}