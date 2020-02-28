<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Business;
use App\Store;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Store::with('business_detail')->with('created_detail')
			->where(function($query){
				if(!Auth()->user()->hasRole('Super Admin')){
				   $query->where(function($q){
					   $businessIds = Business::where('user_id', Auth()->user()->id)->pluck('id');
					   $q->whereIn('business_id', $businessIds);
					   
				   });
				}
				
			})->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Store Edit')){
                            $btn .= '<a href="'.route("store-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        return $btn;
                    })
                     ->addColumn('status',  function ($row) {
                        return ($row->status)?'Active':'InActive';
                     })
                    ->make(true);
        }
		
        return view('admin.store.store',compact(''));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$users = User::permission('Business')->where('status', 1)
		->where(function($query){
			if(!Auth()->user()->hasRole('Super Admin')){
              
					$query->where('created_by', Auth()->user()->id);
				
            }
			
		})
		->get();
		$business = Business::where('status', 1)
		->where(function($query){
			if(!Auth()->user()->hasRole('Super Admin')){
				if(Auth()->user()->can('Business')){
					$query->where('user_id', Auth()->user()->id);
				}else{
					$query->where('created_by', Auth()->user()->id);
				}
            }
			
		})
		->get();
        return view('admin.store.store-create',compact('business'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'business' => 'required|exists:business,id',
			'store_name' => 'required',
			'address' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $store = new Store();
        $store->business_id = $request->business;
        $store->store_name = $request->store_name;
        $store->address = $request->address;
        $store->created_by = Auth()->user()->id;
        $store->save();


        return response()->json([
            'status' => true,
            'msg' => 'Store created successfully'
			]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$business = Business::where('status', 1)
		->where(function($query){
			if(!Auth()->user()->hasRole('Super Admin')){
               $query->where('created_by', Auth()->user()->id);
            }
			
		})
		->get();
        $store = Store::find($id);
        return view('admin.store.store-show',compact('business', 'store'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business = Business::where('status', 1)
		->where(function($query){
			if(!Auth()->user()->hasRole('Super Admin')){
               $query->where('created_by', Auth()->user()->id);
            }
			
		})
		->get();
        $store = Store::find($id);
        return view('admin.store.store-edit',compact('business', 'store'));
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


        $validator = Validator::make($request->all(), [
            'business' => 'required|exists:business,id',
			'store_name' => 'required',
			'address' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $store = Store::find($id);
        $store->business_id = $request->business;
        $store->store_name = $request->store_name;
        $store->address = $request->address;
        $store->save();


        return response()->json([
            'status' => true,
            'msg' => 'Store updated successfully'
			]);

    }

	
    public function destroy($id)
    {
        Store::find($id)->delete();
    }


    
}