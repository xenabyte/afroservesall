@extends('admin.layout.dashboard')

@section('content')
 <!-- start page title -->
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Site Setup</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Site Setup</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Business Hours</h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">Add Business Hours</button>
                </div>
            </div><!-- end card header -->
        </div>

        @if(!empty($activeHours) && $activeHours->count() > 0)
            <div class="row">
                <div class="col-sm-6 col-xl-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Hair Business Hours</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="fixed-header" class="table table-borderedless dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Week Day</th>
                                        <th scope="col">Opening Hours</th>
                                        <th scope="col">Closing Hours</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeHours->where('product_type_id', 2) as $hairActiveHour)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $hairActiveHour->week_days }} </td>
                                        <td>{{ $hairActiveHour->opening_hours }} </td>
                                        <td>{{ $hairActiveHour->closing_hours }} </td>
                                        <td>
                                            <div class="hstack gap-3 fs-15">
                                                <a class="btn btn-outline-secondary btn-sm edit" title="manage" data-bs-toggle="modal" data-bs-target="#edit{{ $hairActiveHour->id }}">
                                                    <i class="fas fas fa-edit"></i>
                                                </a> 
                    
                                                <a class="btn btn-outline-danger btn-sm edit" title="delete" data-bs-toggle="modal" data-bs-target="#delete{{ $hairActiveHour->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                
                                                <div id="delete{{$hairActiveHour->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center p-5">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                    </lord-icon>
                                                                    <h4 class="mb-3 mt-4">Are you sure you want to delete <br/> {{ $hairActiveHour->week_days }}?</h4>
                                                                    <form action="{{ url('/admin/deleteBusinessHour') }}" method="POST">
                                                                        @csrf
                                                                        <input name="active_hour_id" type="hidden" value="{{$hairActiveHour->id}}">
                                                                        <hr>
                                                                        <button type="submit" id="submit-button" class="btn btn-danger w-100">Yes, Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light p-3 justify-content-center">
                
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                
                                                <div id="edit{{$hairActiveHour->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 overflow-hidden">
                                                            <div class="modal-header p-3">
                                                                <h4 class="card-title mb-0">Edit Business Hour</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                    
                                                            <div class="modal-body">
                                                                <form action="{{ url('/admin/updateBusinessHour') }}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                
                                                                    <input name="active_hour_id" type="hidden" value="{{$hairActiveHour->id}}">
                                    
                                                                    <div class="mb-3">
                                                                        <label class="control-label">Product Type</label>
                                                                        <select class="form-control" name="product_type_id" required>
                                                                            <option value="" selected>Select Produt Type</option>
                                                                            @foreach($productTypes as $productType)<option @if($hairActiveHour->product_type_id == $productType->id) selected  @endif value="{{ $productType->id }}">{{ $productType->type }}</option>@endforeach
                                                                        </select>
                                                                    </div>    
                                                
                                                                    <div class="mb-3">
                                                                        <label for="week_days" class="form-label">Week Day</label>
                                                                        <input type="text" class="form-control" name="week_days" id="week_days" value="{{ $hairActiveHour->week_days }}">
                                                                    </div>
                                                
                                                
                                                                    <div class="mb-3">
                                                                        <label for="openingHour" class="form-label">Opening Hour</label>
                                                                        <input type="time" class="form-control" name="opening_hours" id="openingHour" value="{{ $hairActiveHour->opening_hours }}">
                                                                    </div>
                                                
                                                                    <div class="mb-3">
                                                                        <label for="closingHours" class="form-label">Closing Hour</label>
                                                                        <input type="time" class="form-control" name="closing_hours" id="closingHours" value="{{ $hairActiveHour->closing_hours }}">
                                                                    </div>
                
                                                                    <hr>
                                                                    <div class="text-end">
                                                                        <button type="submit" id="submit-button" class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end col --> 
        
                <div class="col-sm-6 col-xl-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Food Business Hours</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <table id="fixed-header" class="table table-borderedless dt-responsive nowrap table-striped align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Week Day</th>
                                        <th scope="col">Opening Hours</th>
                                        <th scope="col">Closing Hours</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeHours->where('product_type_id', 1) as $foodActiveHour)
                                    <tr>
                                        
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $foodActiveHour->week_days }} </td>
                                        <td>{{ date('h:i A', strtotime($foodActiveHour->opening_hours)) }} </td>
                                        <td>{{ date('h:i A', strtotime($foodActiveHour->closing_hours)) }} </td>
                                        <td>
                                            <div class="hstack gap-3 fs-15">
                                                <a class="btn btn-outline-secondary btn-sm edit" title="manage" data-bs-toggle="modal" data-bs-target="#edit{{ $foodActiveHour->id }}">
                                                    <i class="fas fas fa-edit"></i>
                                                </a> 
                    
                                                <a class="btn btn-outline-danger btn-sm edit" title="delete" data-bs-toggle="modal" data-bs-target="#delete{{ $foodActiveHour->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                
                                                <div id="delete{{$foodActiveHour->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center p-5">
                                                                <div class="text-end">
                                                                    <button type="button" class="btn-close text-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <lord-icon src="https://cdn.lordicon.com/wwneckwc.json" trigger="hover" style="width:150px;height:150px">
                                                                    </lord-icon>
                                                                    <h4 class="mb-3 mt-4">Are you sure you want to delete <br/> {{ $foodActiveHour->week_days }}?</h4>
                                                                    <form action="{{ url('/admin/deleteBusinessHour') }}" method="POST">
                                                                        @csrf
                                                                        <input name="active_hour_id" type="hidden" value="{{$foodActiveHour->id}}">
                                                                        <hr>
                                                                        <button type="submit" id="submit-button" class="btn btn-danger w-100">Yes, Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer bg-light p-3 justify-content-center">
                
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                
                                                <div id="edit{{$foodActiveHour->id}}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 overflow-hidden">
                                                            <div class="modal-header p-3">
                                                                <h4 class="card-title mb-0">Edit Session</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                    
                                                            <div class="modal-body">
                                                                <form action="{{ url('/admin/updateBusinessHour') }}" method="post" enctype="multipart/form-data">
                                                                    @csrf
                
                                                                    <input name="active_hour_id" type="hidden" value="{{$foodActiveHour->id}}">
                                    
                                                                    <div class="mb-3">
                                                                        <label class="control-label">Product Type</label>
                                                                        <select class="form-control" name="product_type_id" required>
                                                                            <option value="" selected>Select Produt Type</option>
                                                                            @foreach($productTypes as $productType)<option @if($foodActiveHour->product_type_id == $productType->id) selected  @endif value="{{ $productType->id }}">{{ $productType->type }}</option>@endforeach
                                                                        </select>
                                                                    </div>    
                                                
                                                                    <div class="mb-3">
                                                                        <label for="week_days" class="form-label">Week Day</label>
                                                                        <input type="text" class="form-control" name="week_days" id="week_days" value="{{ $foodActiveHour->week_days }}">
                                                                    </div>
                                                
                                                
                                                                    <div class="mb-3">
                                                                        <label for="openingHour" class="form-label">Opening Hour</label>
                                                                        <input type="time" class="form-control" name="opening_hours" id="openingHour" value="{{ $foodActiveHour->opening_hours }}">
                                                                    </div>
                                                
                                                                    <div class="mb-3">
                                                                        <label for="closingHours" class="form-label">Closing Hour</label>
                                                                        <input type="time" class="form-control" name="closing_hours" id="closingHours" value="{{ $foodActiveHour->closing_hours }}">
                                                                    </div>
                
                                                                    <hr>
                                                                    <div class="text-end">
                                                                        <button type="submit" id="submit-button" class="btn btn-primary">Save Changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end col --> 
            </div>
        @endif
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Food Section Settings</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-6 col-xl-12">
                        <form action="{{ url('/admin/updateSettings') }}" method="POST">
                            @csrf
                            <input type="hidden" name="setting_id" value="{{ !empty($pageGlobalData->setting)?$pageGlobalData->setting->id:null }}">
                            <div class="row g-3">

                                <div class="col-lg-6">
                                    <h4 class="card-title mb-0 flex-grow-1">Status: {{ !empty($pageGlobalData->setting)?$pageGlobalData->setting->food_status:'Not Set' }}</h4>
                                    <br>
                                    <div class="form-floating">
                                        <select class="form-select" id="foodStatus" name="food_status" aria-label="Food section status">
                                            <option value="" selected>--Select--</option>
                                            <option value="Open">Open</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                        <label for="foodStatus">Food Session Status</label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h4 class="card-title mb-0 flex-grow-1">Message: {{ !empty($pageGlobalData->setting)?$pageGlobalData->setting->food_message:'Not Set' }}</h4>
                                    <br>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="food_message" name="food_message" placeholder="Message as to when the store will be opened">
                                        <label for="food_message">Food Session Message</label>
                                    </div>
                                </div>

                                <hr>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" id="submit-button" class="btn btn-primary">Update Settings</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- end col -->
                </div>
            </div>
        </div><!-- end card -->
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Hair Section Settings</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-6 col-xl-12">
                        <form action="{{ url('/admin/updateSettings') }}" method="POST">
                            @csrf
                            <input type="hidden" name="setting_id" value="{{ !empty($pageGlobalData->setting)?$pageGlobalData->setting->id:null }}">
                            <div class="row g-3">

                                <div class="col-lg-6">
                                    <h4 class="card-title mb-0 flex-grow-1">Status: {{ !empty($pageGlobalData->setting)?$pageGlobalData->setting->saloon_status:'Not Set' }}</h4>
                                    <br>
                                    <div class="form-floating">
                                        <select class="form-select" id="saloon_status" name="saloon_status" aria-label="Hair section status">
                                            <option value="" selected>--Select--</option>
                                            <option value="Open">Open</option>
                                            <option value="Closed">Closed</option>
                                        </select>
                                        <label for="saloon_status">Hair Session Status</label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h4 class="card-title mb-0 flex-grow-1">Message: {{ !empty($pageGlobalData->setting)?$pageGlobalData->setting->saloon_message:'Not Set' }}</h4>
                                    <br>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="food_message" name="saloon_message" placeholder="Message as to when the store will be opened">
                                        <label for="saloon_message">Hair Session Message</label>
                                    </div>
                                </div>

                                <hr>
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" id="submit-button" class="btn btn-primary">Update Settings</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- end col -->
                </div>
            </div>
        </div><!-- end card -->
    </div>
</div>
<!-- end row -->

<div id="add" class="modal fade" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" style="display: none;">
    <!-- Fullscreen Modals -->
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header p-3">
                <h4 class="card-title mb-0">Add Business Hours</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="{{ url('/admin/addBusinessHours') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="control-label">Product Type</label>
                        <select class="form-control" name="product_type_id" required>
                            <option value="" selected>Select Produt Type</option>
                            @foreach($productTypes as $productType)<option value="{{ $productType->id }}">{{ $productType->type }}</option>@endforeach
                        </select>
                    </div>    

                    <div class="mb-3">
                        <label for="week_days" class="form-label">Week Day</label>
                        <input type="text" class="form-control" name="week_days" id="week_days">
                    </div>


                    <div class="mb-3">
                        <label for="openingHour" class="form-label">Opening Hour</label>
                        <input type="time" class="form-control" name="opening_hours" id="openingHour">
                    </div>

                    <div class="mb-3">
                        <label for="closingHours" class="form-label">Closing Hour</label>
                        <input type="time" class="form-control" name="closing_hours" id="closingHours">
                    </div>
        
                    <hr>
                    <div class="text-end">
                        <button type="submit" id="submit-button" class="btn btn-primary">Create a Session</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection