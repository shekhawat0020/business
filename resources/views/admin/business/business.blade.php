@extends('admin/layouts/default')
@section('title')
<title>Admin</title>
@stop
@section('inlinecss')

@stop
@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Business</h3>
                        <div class="ml-auto pageheader-btn">
                        
                            @can('Business Create')
							<div class="form-group pull-left" style="margin-right: 10px;">
							
							</select>
							
							</div>
								<a href="{{ route('business-create') }}" class="btn btn-success btn-icon text-white mr-2 create-link">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Business
								</a>
							
								<a href="#" class="btn btn-danger btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
                                </a>
                            @endcan
							</div>
                    </div>
                    <div class="card-body ">
                        
                    <table class="table table-bordered data-table w-100">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>User</th>
                              <th>Business Name</th>
                              <th>Address</th>
                              <th>Created By</th>
                              <th width="100px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>




</div>
@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        
    <script type="text/javascript">
        $(function () {
            $.fn.dataTable.ext.errMode = 'none';
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('business-list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'user_detail.name', name: 'user_detail.name'},
                    {data: 'business_name', name: 'business_name'},
                    {data: 'address', name: 'address'},                  
                    {data: 'created_detail.name', name: 'created_detail.name'},                  
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            
			
			
            
        });
    </script>
@stop