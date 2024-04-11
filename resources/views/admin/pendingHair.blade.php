@extends('admin.layout.dashboard')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Pending/Ongoing Saloon Bookings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Pending/Ongoing Saloon Bookings</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Pending/Ongoing Saloon Bookings</h4>
                    <hr>

                    <table id="datatable" class="table table-bfoodOrdered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="bg-primary text-white">SKU</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Customer Phone Number</th>
                                <th scope="col">Delivery Type</th>
                                <th scope="col">Appointment Date</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($hairOrders as $hairOrder)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="bg-primary-subtle">{{ $hairOrder->sku }}</td>
                                    <td>{{ ucwords($hairOrder->customer->lastname . ' ' . $hairOrder->customer->othernames) }}
                                    </td>
                                    <td>{{ $hairOrder->customer->phone }}</td>
                                    <td>{{ ucwords($hairOrder->delivery_type) }}</td>
                                    <td>{{ date('F d, Y', strtotime($hairOrder->booking_date)) }}</td>
                                    <td>{{ date('F d, Y h:i:s A', strtotime($hairOrder->created_at)) }}</td>
                                    <td>
                                        @if ($hairOrder->status == 'pending')
                                            <span class="btn btn-primary waves-effect waves-light">
                                                Pending
                                            </span>
                                        @elseif($hairOrder->status == 'completed')
                                            <span class="btn btn-success waves-effect waves-light">
                                                Completed
                                            </span>
                                        @else
                                            <span class="btn btn-warning waves-effect waves-light">
                                                {{ $hairOrder->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-secondary btn-sm edit" data-bs-toggle="modal"
                                            data-bs-target="#viewOrder{{ $hairOrder->id }}" title="view">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Static Backdrop Modal -->
                                        <div class="modal fade" id="viewOrder{{ $hairOrder->id }}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" role="dialog"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog .modal-dialog-scrollable modal-xl modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Order Information
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body row">
                                                        <div class="col-xl-8">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table align-middle mb-0 table-nowrap">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Product</th>
                                                                                    <th>Quantity</th>
                                                                                    <th>Price</th>
                                                                                    <th colspan="2">Total</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                                @foreach ($hairOrder->cartItems as $cartItem)
                                                                                    <tr class="product">
                                                                                        <td>{{ $loop->iteration }}</td>
                                                                                        <td>
                                                                                            <h5
                                                                                                class="font-size-14 text-truncate">
                                                                                                <a href="#"
                                                                                                    class="text-dark">{{ $cartItem->name }}</a>
                                                                                            </h5>
                                                                                            <p class="mb-0">
                                                                                                {{ $cartItem->description }}
                                                                                            </p>
                                                                                        </td>
                                                                                        <td><span
                                                                                                class="product-price">{{ $cartItem->quantity }}</span>
                                                                                        </td>
                                                                                        <td>£<span
                                                                                                class="product-line-price">{{ $cartItem->price / number_format($cartItem->quantity) }}</span>
                                                                                        </td>
                                                                                        <td>£<span
                                                                                                class="product-line-price">{{ $cartItem->price }}</span>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if ($hairOrder->address)
                                                                        <p class="mb-0">Address : <span
                                                                                class="fw-medium">{{ $hairOrder->address->address_1 . ' ' . $hairOrder->address->address_2 }}</span>
                                                                        </p>
                                                                        <p class="mb-0">Phone Number : <span
                                                                                class="fw-medium">{{ $hairOrder->address->phone_number }}</span>
                                                                        </p>
                                                                    @endif
                                                                    <p class="mb-0">Additional Information : <span
                                                                            class="fw-medium">{{ $hairOrder->additional_infomation }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title mb-3">Order Summary</h4>
                                                                    <hr>
                                                                    <div class="table-responsive">
                                                                        <table class="table mb-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Grand Total :</td>
                                                                                    <td id="cart-subtotal">
                                                                                        £{{ number_format($hairOrder->amount_paid / 100, 2) }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Discount : </td>
                                                                                    <td id="cart-discount">- £0.00</td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                        <td>Shipping Charge :</td>
                                                                        <td id="cart-shipping">$ 25</td>
                                                                    </tr> --}}
                                                                                {{-- <tr>
                                                                        <td>Estimated Tax (12.5%) :</td>
                                                                        <td id="cart-tax">$ 19.22</td>
                                                                    </tr> --}}
                                                                                <tr class="bg-light">
                                                                                    <th>Total :</th>
                                                                                    <th id="cart-total">
                                                                                        £{{ number_format($hairOrder->amount_paid / 100, 2) }}
                                                                                    </th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <!-- end table-responsive -->
                                                                </div>
                                                            </div>
                                                            <!-- end card -->
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a class="btn btn-outline-primary btn-sm edit" data-bs-toggle="modal"
                                            data-bs-target="#updateOrder{{ $hairOrder->id }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <!-- Static Backdrop Modal -->
                                        <div class="modal fade" id="updateOrder{{ $hairOrder->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Update Order</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="{{ url('/admin/updateOrder') }}">
                                                        @csrf
                                                        <div class="modal-body">

                                                            <input type="hidden" name="order_id"
                                                                value="{{ $hairOrder->id }}">

                                                            <div class="mb-3 form-floating">
                                                                <select class="form-select" name="status">
                                                                    <option
                                                                        @if ($hairOrder->status == 'pending') selected @endif
                                                                        value="pending">Pending</option>
                                                                    <option
                                                                        @if ($hairOrder->status == 'delivery ongoing') selected @endif
                                                                        value="delivery ongoing">Delivery Ongoing</option>
                                                                    <option
                                                                        @if ($hairOrder->status == 'completed') selected @endif
                                                                        value="completed">Completed</option>
                                                                </select>
                                                                <label class="col-form-label">Please Current state of
                                                                    Order</label>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
