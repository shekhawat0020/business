@extends('admin/layouts/default')
@section('title')
<title>Edit Store</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Store</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Store</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    <form id="submitForm" class="row"  method="post" action="{{route('store-update', $store->id)}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Store Form</h3>
									</div>
									<div class="card-body">
									
									<div class="form-group">
											<label class="form-label"> Business*</label>											
											<select class="form-control select2" name="business" id="business" required>
												<option value=""> Select Business </option>
												@foreach($business as $b)
												<option @if($store->business_id == $b->id) selected @endif value="{{$b->id}}">{{$b->business_name}}</option>
												@endforeach
											</select>
										</div>
                                    
										<div class="form-group>
											<label class="form-label"> Store Name * </label>											
											<input type="text" class="form-control" name="store_name" id="store_name" value="{{$store->store_name}}">
										</div>
										
										<div class="form-group>
											<label class="form-label"> Address * </label>											
											<input type="text" class="form-control" name="address" id="address" value="{{$store->address}}">
										</div>
									
										
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        
										</div>
                                        
									</div>
                                    
								</div>
							
						
							
							</form>
        </div><!-- COL END -->
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script type="text/javascript">
        
        $(function () { 
           $('#submitForm').submit(function(){
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm')[0]),
                success: function(data) {
                    if(data.status){
						var btn = '<a href="{{route('store-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Edit Store', data.msg, btn);

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Store','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Store', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

         });
            
       
    </script>
@stop	
