<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private $model;

    public function __construct(Request $request)
    {
        $this->model = 'App\Models\\' . ucfirst($request->type ?? 'product');
    }

    public function home(Request $request)
    {
        if($request->has('checkout')){
            if($request->checkout == 'success'){
                $type = 'success';
                $msg = 'Payment Success';
            }else{
                $type = 'error';
                $msg = 'Payment Faild';
            }
            return redirect()->route('products')->with($type,$msg);
        }
        return view('dashboard');
    }

    public function payment(Request $request)
    {
        abort_if(!in_array($request->type, ['product']), 404);
        try{
            return view('payment', [
                'item' => $this->model::findOrFail($request->id),
                'intent' => User::findOrFail(auth()->user()->id)->createSetupIntent(),
            ]);
        }catch(Exception $e){
            return redirect()->back()->with('error','Unable to connect to Stripe Server '.$e->getMessage());
        }        
    }

    public function purchase(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        try {
            $user->charge(
                $this->model::findOrFail($request->id)->price * 100,
                $paymentMethod,
                ['return_url' => route('payment.success'),]
            );
        } catch (\Exception $e) {
            return redirect()->route('payment.faild', ['msg' => $e->getMessage()]);
        }
        return redirect()->route('payment.success');
    }

    public function paymentSuccess()
    {
        return redirect()->route('products')->with('success', 'Payment Success');
    }

    public function paymentFaild($msg = '')
    {
        return redirect()->route('products')->with('error', 'Payment Faild,' . $msg);
    }

    public function checkout(Request $request)
    {
        abort_if(!in_array($request->type, ['product']), 404);
        $item = $this->model::findOrFail($request->id);
        try{
            return $request->user()->checkoutCharge($item->price * 100, $item->name, $request->quantity ?? 1);
        }catch(Exception $e){
            return redirect()->back()->with('error','Unable to connect to Stripe Server '.$e->getMessage());
        } 
    }

    public function getUserInvoices()
    {
        return view('invoices',['invoices'=>Auth::user()->invoices()]);
    }
}
