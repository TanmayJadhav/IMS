@extends('template')

@section('main')

    @inject('converter', 'App\Http\Controllers\SellProductController')

    <div class="card mx-auto">
        <div class="card-header d-flex align-item-center justify-content-between">
            <p class="h3 m-0">Reports</p>
            {{-- <a href="/client/add" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Customer</a> --}}
        </div>
        <div class="card-body">
            {{-- @if ($errors->any())
                <div class="alert alert-danger" class="close" data-dismiss="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            <form action="/report/filter" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Start Date</label>
                            <input type="date" name="startdate" required class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">End Date</label>
                            <input type="date" name="enddate" class="form-control" required>
                        </div>
                    </div>

                    <div class=" text-center m-3">
                        <button class="btn btn-success" type="submit" name="add"><i class="fa fa-plus"></i> Filter</button>
                    </div>


                </div>
            </form>
            @if (!empty($reports))

                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead class="thead">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Category</th>
                                <th scope="col">Model</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Purchase Price</th>
                                <th scope="col">Selling Price(without GST)</th>
                                <th scope="col">Labour Charges</th>
                                <th scope="col">Transportation Charges</th>
                                <th scope="col">Amount Paid</th>
                                <th scope="col">Amount Remaining</th>
                                <th scope="col">Total Amount</th>
                                {{-- <th scope="col">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($reports as $report)
                                <tr>
                                    <th scope="row">{{ $report->created_at->format('d-m-Y') }}</th>
                                    <th scope="row">{{ $report->product->product_name }}</th>
                                    <td class="text-center">{{ $report->receipt->client->name }}</td>
                                    <td class="text-center">{{ $report->product->vendor->name }}</td>
                                    <td class="text-center">{{ $report->product->brand }}</td>
                                    <td class="text-center">{{ $report->product->product_category }}</td>
                                    <td class="text-center">{{ $report->product->model }}</td>
                                    <td class="text-center">{{ $report->quantity }}</td>
                                    <td class="text-center">&#8377
                                        {{ $converter::IND_money_format($report->product->purchase_price) }}
                                    </td>
                                    <td class="text-center">&#8377
                                        {{ $converter::IND_money_format($report->selling_price) }}
                                    </td>
                                    <td class="text-center">&#8377 
                                        {{ $converter::IND_money_format($report->receipt->labour_charge) }}
                                    </td>
                                    <td class="text-center">&#8377
                                        {{ $converter::IND_money_format($report->receipt->transportation_charge) }}
                                    </td>
                                    <td class="text-center">&#8377
                                        {{ $converter::IND_money_format($report->receipt->total_price - $report->receipt->remaining_amount) }}
                                    </td>
                                    <td class="text-center">&#8377
                                        {{ $converter::IND_money_format($report->receipt->remaining_amount) }}</td>
                                    <td class="text-center">&#8377
                                        {{ $converter::IND_money_format($report->receipt->total_price) }}</td>
                                    @php
                                        $total = $total + $report->receipt->total_price;
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{-- <tr>
                            <td rowspan="2"></td>
                        </tr> --}}
                            {{-- <tr>
                            <td rowspan="2"></td>
                        </tr> --}}

                            <tr>
                                <td colspan="12"></td>

                                {{-- <td colspan="1"></td> --}}
                                <td class="text-center" colspan="2">GRAND TOTAL</td>
                                <td class="text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377
                                    {{ $converter::IND_money_format($total) }}</td>
                                {{-- @if ($receipt[0]->gst == 1)
                                <td class="text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377
                                    {{ $converter::IND_money_format($total_price_with_gst) }}</td>

                            @else
                                <td class="text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377
                                    {{ $converter::IND_money_format($total_price) }}</td>
                            @endif --}}
                            </tr>
                        </tfoot>
                    </table>
                    {{-- <br>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Start Date</label>
                        <input type="date" name="startdate" required class="form-control">
                    </div>
                </div> --}}

                </div>
            @endif


        </div>
    </div>





@section('excel button')
    dom: 'Bfrtip',
    buttons: [
    'excel',
    ]
@endsection

@stop
