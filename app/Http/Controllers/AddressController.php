<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function index()
    {
        $addresses=Address::paginate(6);

        return view('address.index',compact('addresses'));
    }

    public function create()
    {
        return view('address.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit(Address $address)
    {
        return view('address.edit',compact('address'));
    }

    public function update(Request $request,Address $address)
    {
        
    }

    public function destroy()
    {
        
    }
}
