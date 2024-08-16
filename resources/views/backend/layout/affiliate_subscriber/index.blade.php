@extends('backend.app')

@section('title', 'Affiliate Subscriber')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/vendors/datatable/css/datatables.min.css') }}">
    <style>
    ul {
        padding: revert-layer;
    }
    ul, #myUL {
        list-style-type: none;
    }

    #myUL {
        margin: 0;
        padding: 0;
    }

    .caret {
        cursor: pointer;
        -webkit-user-select: none;
        /* Safari 3.1+ */
        -moz-user-select: none;
        /* Firefox 2+ */
        -ms-user-select: none;
        /* IE 10+ */
        user-select: none;
    }

    .caret::before {
        content: "\25B6";
        color: black;
        display: inline-block;
        margin-right: 6px;
    }

    .caret-down::before {
        -ms-transform: rotate(90deg); /* IE 9 */
        -webkit-transform: rotate(90deg); /* Safari */
        transform: rotate(90deg);  
    }

    .treenested {
        display: none;
    }

    .treeactive {
        display: block;
    }
</style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Affiliate Subscriber</h4>
                        <div class="table-responsive mt-4 p-4">
                            <ul id="myUL">
                                @foreach($usersTree as $user)
                                    @include('frontend.layout.extends.treerow', [
                                        'user' => $user
                                    ])
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".treenested").classList.toggle("treeactive");
                this.classList.toggle("caret-down");
            });
        }
    </script>
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
