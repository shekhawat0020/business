@extends('admin/layouts/default')
@section('title')
<title>Edit Business</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Business</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Business</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('business-update', $business->id)}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Business Form</h3>
									</div>
									<div class="card-body">
									
									<div class="form-group">
											<label class="form-label"> User*</label>											
											<select class="form-control select2" name="user" id="user" required>
												<option value=""> Select User </option>
												@foreach($users as $user)
												<option @if($business->user_id == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
												@endforeach
											</select>
										</div>
                                    
										<div class="form-group>
											<label class="form-label"> Business Name * </label>											
											<input type="text" class="form-control" name="business_name" id="business_name" value="{{$business->business_name}}">
										</div>
										
										<div class="form-group>
											<label class="form-label"> Address * </label>											
											<input type="text" class="form-control" name="address" id="address" value="{{$business->address}}">
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
						var btn = '<a href="{{route('business-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Edit Business', data.msg, btn);

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Business','Input error');
                    }
                    buttonLoading('reset', $this);
                    
                },
                error: function() {
                    errorMsg('Edit Business', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

         });
            
       
    </script>
@stop	
