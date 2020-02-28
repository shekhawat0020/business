<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Business;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Business::with('user_detail')->with('created_detail')
			->where(function($query){
				if(!Auth()->user()->hasRole('Super Admin')){
				   $query->where('created_by', Auth()->user()->id);
				}
				
			})->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Business Edit')){
                            $btn .= '<a href="'.route("business-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->make(true);
        }
		
        return view('admin.business.business',compact(''));
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
        return view('admin.business.business-create',compact('users'));
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
            'user' => 'required|exists:users,id',
			'business_name' => 'required|unique:business,business_name',
			'address' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $business = new Business();
        $business->user_id = $request->user;
        $business->business_name = $request->business_name;
        $business->address = $request->address;
        $business->created_by = Auth()->user()->id;
        $business->save();


        return response()->json([
            'status' => true,
            'msg' => 'Business created successfully'
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
		$users = User::permission('Business')->where('status', 1)
		->where(function($query){
			if(!Auth()->user()->hasRole('Super Admin')){
               $query->where('created_by', Auth()->user()->id);
            }
			
		})
		->get();
        $business = Business::find($id);
        return view('admin.business.business-show',compact('business', 'users'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::permission('Business')->where('status', 1)
		->where(function($query){
			if(!Auth()->user()->hasRole('Super Admin')){
               $query->where('created_by', Auth()->user()->id);
            }
			
		})
		->get();
        $business = Business::find($id);	
        return view('admin.business.business-edit',compact('business', 'users'));
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
            'user' => 'required|exists:users,id',
			'business_name' => 'required|unique:business,business_name,'.$id,
			'address' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $business = Business::find($id);
        $business->user_id = $request->user;
        $business->business_name = $request->business_name;
        $business->address = $request->address;
        $business->save();


        return response()->json([
            'status' => true,
            'msg' => 'Business updated successfully'
			]);

    }

	
    public function destroy($id)
    {
        Business::find($id)->delete();
    }


    
}