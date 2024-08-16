@extends('backend.app')

@section('title', 'Claim Request')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/vendors/datatable/css/datatables.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Claim Request</h4>
                        <div class="table-responsive mt-4 p-4">
                            <table class="table table-hover" id="data-table">
                                @php
                                 $requests = \App\Models\ClaimRequest::all();
                                @endphp
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Request</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ;?>
                                    @foreach ($requests as $request)
                                    <tr>
                                        <td>{{$request->id}}</td>
                                        <td>{{$request->request}}</td>
                                        <td>{{date('d-M-y',strtotime($request->created_at))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- Datatable --}}
    {{-- <script src="{{ asset('backend/vendors/datatable/js/datatables.min.js') }}"></script> --}}

    {{-- <script>
        $(document).ready(function() {
            var searchable = [];
            var selectable = [];
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            if (!$.fn.DataTable.isDataTable('#data-table')) {
                let dTable = $('#data-table').DataTable({
                    order: [],
                    lengthMenu: [
                        [25, 50, 100, 200, 500, -1],
                        [25, 50, 100, 200, 500, "All"]
                    ],
                    processing: true,
                    responsive: true,
                    serverSide: true,

                    language: {
                        processing: `<div class="text-center">
                     <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                     <span class="visually-hidden">Loading...</span>
                   </div>
                     </div>`
                    },

                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('order.index') }}",
                        type: "get",
                    },

                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'order_id',
                            name: 'order_id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'products',
                            name: 'products',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'email',
                            name: 'email',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'affiliate_link',
                            name: 'affiliate_link',
                            orderable: true,
                            searchable: true
                        },

                        {
                            data: 'subtotal',
                            name: 'subtotal',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'shipping_address',
                            name: 'shipping_address',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'shipping_cost',
                            name: 'shipping_cost',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'total',
                            name: 'total',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'payment_status',
                            name: 'payment_status',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'date',
                            name: 'date',
                            orderable: true,
                            searchable: true
                        },
                    ],
                });

                dTable.buttons().container().appendTo('#file_exports');

                new DataTable('#example', {
                    responsive: true
                });
            }
        });
    </script> --}}
@endpush
