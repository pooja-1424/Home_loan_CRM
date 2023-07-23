<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bankname;
use DB;
class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bank-list|bank-create|bank-edit|bank-delete', ['only' => ['index','store']]);
        $this->middleware('permission:bank-create', ['only' => ['create','store']]);
        $this->middleware('permission:bank-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bank-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $data=Bankname::orderBy('bank_id','DESC')->paginate(10); 
       
        return view('content.sanction.bank',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $request->validate([
            'bank_name'=> 'required|regex:/^[a-zA-Z\s]+$/|unique:bank_details|min:6|max:30',
        ]);
       
        $data = new bankname;
        $data->bank_name = $request->input('bank_name');
        $data->save();
        session()->flash('success', 'Bank added successfully.');

        return response()->json($data);
   
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit(Request $request , Bankname $bankname) 
    public function edit($id) 
    {  
        $data = Bankname::find($id);
        return response()->json([
            'status'=>200,
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
       
        public function update(Request $request)
        {   
            $request->validate([
                'bank_name'=> 'unique:bank_details|regex:/^[a-zA-Z\s]+$/|min:6|max:20',
            ]);

            $b_id = $request->input('b_id');
            $data = Bankname::find($b_id);
            // $data->bank_name = $request->input('bank_name');
            $data->update(['bank_name' => $request->bank_name]);
             
           session()->flash('success', 'Bank updated successfully.');

           return response()->json(['success' => true]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
