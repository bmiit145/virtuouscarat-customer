@extends('backend.layouts.master')
@section('main-content')
<style>
    /* Apply a hover effect to all rows with the same data-order_id */
    .table tbody tr {
        transition: background-color 0.3s ease; /* Smooth transition effect */
    }

    .table tbody tr:hover {
        background-color: #f1f1f1; /* Light grey background on hover */
    }

    .table tbody tr.highlight-hover {
        background-color: #f1f1f1; /* Light grey background on hover */
    }
</style>
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-bordered table-hover" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
                <th>Order Date</th>
              <th>Order No.</th>
{{--              <th>Customer Name</th>--}}
                <th>Product Name</th>
{{--                <th>Vendor Name</th>--}}
                <th>Product Price</th>
              <th>Order Value</th>
              <th>Status</th>
                <!-- <th>Status</th> -->
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
    @foreach($orders as $order)
        @php
            // Calculate rowspan for cells that need to span multiple rows
            $rowspan = $order->products->filter(function($product) {
                return $product->product;
            })->count();
        @endphp

        @foreach($order->products as $index => $product)
            @if(!$product->product)
                @continue
            @endif

            @if($product->product)
                @php
                    $productAttributes = $product->product->attributes->pluck('value','name');
                    $ProdColor = $productAttributes->get('Color', '');
                    $prodClarity = $productAttributes->get('Clarity', '');
                    $prodCut = $productAttributes->get('Cut', '');
                    $prodMeasurement = $productAttributes->get('Measurement', '');
                @endphp
            @endif

            <tr data-order_id="{{ $order->order_id }}">
                @if($index == 0)
                    <td rowspan="{{ $rowspan }}">{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $order->order_id }}</td>
{{--                    <td rowspan="{{ $rowspan }}">{{ $order->billing_first_name }} {{ $order->billing_last_name }}</td>--}}
                @endif
                <td>
                    @if($product->product)
                        <span>{{ $product->product->sku ?? '' }} <br>
                        <span>{{ $product->product->name }}</span>
                        <span>( Color : {{$ProdColor . ', Clarity : ' . $prodClarity . ', Cut : ' . $prodCut . ', Measurement : ' . $prodMeasurement}} )</span> </td>
                    @endif
                </td>

{{--                <td>--}}
{{--                    <span>{{ $product->product->vendor->name ?? '' }}</span><br/>--}}
{{--                </td>--}}

                <td>
                    @if($product->product)
                        <span>₹{{ $product->price }} <sub>QTY {{ $product->quantity }}</sub></span>
                    @endif
                </td>

                @if($index == 0)
                    <td rowspan="{{ $rowspan }}">₹{{ number_format($order->total, 2) }}</td>
                @endif
                    <td>
                        @if($order->customer_status_show)
                                @if(!$product->product)
                                    @continue
                                @endif

                                    @if($product->is_fulfilled == 0)
                                        <span class="badge bg-warning-light rounded-pill" style="cursor:unset;">Pending</span>
                                    @elseif($product->is_fulfilled == 1)
                                        <span class="badge bg-success-light rounded-pill" style="cursor:unset;">Approved</span>
                                    @elseif($product->is_fulfilled == 2)
                                        <span class="badge bg-danger-light rounded-pill" style="cursor:unset;">Rejected</span>
                                    @elseif($product->is_fulfilled == 4)
                                        <span class="badge bg-danger-light rounded-pill" style="cursor:unset;">Rejected By Admin</span>
                                    @elseif($product->is_fulfilled == 5)
                                        <span class="badge bg-info-light rounded-pill" style="cursor:unset;">Cancelled</span>
                                    @else
                                    <span class="badge bg-warning-light rounded-pill" style="cursor:unset;">Pending</span>
                                @endif

                            @else

                            <span class="badge bg-warning-light rounded-pill" style="cursor:unset;">Pending</span>

                        @endif
                    </td>

                    @if($index == 0)
                    <td  rowspan="{{ $rowspan }}">
                        <!--  cancel button if no any order products status is 1 -->
                        @if($order->products->whereIn('is_fulfilled', [1 , 4 , 5])->count() == 0)
                            <form method="POST" action="{{route('order.cancel',[$order->order_id])}}">
                                @csrf
                                <button class="dltBtn" data-id="{{$order->order_id}}" style="border:0px; background-color:transparent;" title="Delete"><i class="fas fa-trash"></i></button>
                                <button class="returnBtn" data-id="{{ $order->order_id }}" style="border:0px; background-color:transparent;" title="Return">
                                    <i class="fas fa-undo-alt"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                    @endif
                  </tr>
        @endforeach
    @endforeach
</tbody>

        </table>
        <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">No orders found!!! Please order some products</h6>
        @endif
      </div>
    </div>
</div>
@endsection
@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush
@push('scripts')
  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      $('#order-dataTable').DataTable( {
        "paging": true,
            "ordering": false,
            "info": true
        } );
        // Sweet alert
        function deleteData(id){
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this order!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your order is safe!");
                    }
                });
          })
      })
  </script>
{{--  Order status--}}
    <script>
        $(document).ready(function(){
            $('.order-action-btn').click(function(){
                var action = $(this).data('action');
                var order_id = $(this).closest('tr').data('order_id');
                var status = 0;
                if(action == 'reject'){
                    status = 5;
                }else if(action == 'fullfilled') {
                    status = 3;
                }
                var url = "{{ route('order.update.status') }}";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        action: action,
                        order_id: order_id,
                        status: status
                    },
                    success: function(data){
                        if(data.status){
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('tr').hover(function() {
            var orderId = $(this).data('order_id');
            $('tr[data-order_id="' + orderId + '"]').addClass('highlight-hover');
        }, function() {
            var orderId = $(this).data('order_id');
            $('tr[data-order_id="' + orderId + '"]').removeClass('highlight-hover');
        });
    });
</script>
@endpush
