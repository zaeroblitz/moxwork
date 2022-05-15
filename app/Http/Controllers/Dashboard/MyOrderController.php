<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use App\Http\Requests\Dashboard\Order\UpdateOrderRequest;

use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceAdvantage;
use App\Models\ServiceThumbnail;
use App\Models\Tagline;
use App\Models\UserAdvantage;

class MyOrderController extends Controller
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
        $orders = Order::where('freelancer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('pages.Dashboard.order.index', compact('orders'));
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
    public function show(Order $order)
    {
        $service = Service::where('id', $order['service_id'])->first();

        $user_advantages = UserAdvantage::where('services_id', $service->id)->get();
        $service_advantages = ServiceAdvantage::where('services_id', $service->id)->get();
        $service_thumbnails = ServiceThumbnail::where('services_id', $service->id)->get();        
        $taglines = Tagline::where('services_id', $service->id)->get();        

        return view('pages.Dashboard.order.detail', compact('user_advantages', 'service_advantages', 'service_thumbnails', 'taglines'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('pages.Dashboard.order.edit', compact($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->all();

        if (isset($data['file'])) {
            $data['file'] = $request->file('file')->store('assets/order/attachment', 'public');
        }

        $order = Order::find($order->id);
        $order->file = $data['file'];
        $order->note = $data['note'];
        $order->save();

        Alert::toast('Order has been submitted', 'success');
        return redirect()->route('member.order.index');
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

    public function accepted($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 2;
        $order->save;

        Alert::toast('Order has been accepted', 'success');
        return back();
    }

    public function rejected($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 3;
        $order->save;

        Alert::toast('Order has been rejected', 'success');
        return back();
    }
}