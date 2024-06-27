<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function index(){
        $orderItemsWithOrder = OrderItem::with('order')->get();
        $orderCount = 0 ;
        $orderItems = OrderItem::all();

        // get orderCount 
        foreach ($orderItemsWithOrder as $o)
         {
            if ($o->order->user_id == Auth::id()) 
            {
                $orderCount += 1 ;
            }
        }
        // get pending orders
        $pendingCount = 0;
        foreach ($orderItems as $orderItem) 
        {
            if ($orderItem->status == 'pending' and $orderItem->order->user_id == Auth::id() ) 
            {
                    $pendingCount += 1;        
            }

            
        }
        // get wishlist count
        if (Auth::check())
        {
            $wishlistCount = Wishlist::where('user_id',Auth::id())->get('id');
            $wishlistCount = $wishlistCount->count();
            session()->put('wishlistCount', $wishlistCount);  

        }else 
        {
            session()->put('wishlistCount', 0);
        }
        

        return view('users.dashboard',['orderCount'=>$orderCount,'pendingCount'=>$pendingCount]);
    }

    public function show(){
        $user = User::find(Auth::id());
        return view('users.editUserInfo');
    }    
    
    public function edit(Request $requset){
        $user = User::find(Auth::id());
        $data = $requset->validate([
            'name'=>'required ',
            'email'=>'required|email',
            'phone'=>'numeric|digits_between:10,15',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);
        $newData = $requset->all();
        $newData =request()->except(['_token', '_method']);
        $user->update($newData);
        return view('users.editUserInfo');
    }

    public function remove(User $user)
    {
        $user->delete();
        return redirect()->route('login');
    }
}
