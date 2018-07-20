<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class AuditController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>[],
        ]);
    }
    //审核
    public function audit(Request $request,Shop $shop)
    {

        $shop->update(['status'=>$request->status]);
        session()->flash('success','操作成功');
        return redirect()->route('shops.index');
    }
}
