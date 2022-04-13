<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt PDF</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    {{-- <link rel="stylesheet" href="/css/pdftemplate.css"> --}}

    <style>
        @include('pages/sellproducts/receipt_pdf_css');

    </style>

    @inject('converter', 'App\Http\Controllers\SellProductController')


</head>

<body>

    <div id="invoice">


        <div class="invoice overflow-auto">
            <div style="min-width: 600px">
                <header>
                    <div class="row">
                        <div class="col">

                            <img src="data:image/png;base64,{{ $profile_image }} " height="120" width="140"
                                data-holder-rendered="true" />

                        </div>
                        <div class="col company-details">
                            <h2 class="name">

                                {{ $sell_products[0]->product->shop->name }}

                            </h2>
                            <div>{{ $sell_products[0]->product->shopadmin->address }}</div>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="row contacts">
                        <div class="col invoice-to">
                            <div class="text-gray-light">INVOICE TO:</div>
                            <h2 class="to">{{ $receipt[0]->client->name }}</h2>
                            {{-- <div class="address">796 Silver Harbour, TX 79273, US</div>
                            <div class="email"><a href="mailto:john@example.com">john@example.com</a></div> --}}
                        </div>
                        <div class="col invoice-details">
                            <h1 class="invoice-id">Receipt #{{ $sell_products[0]->id }}</h1>
                            <div class="date">Date of Invoice: {{ $sell_products[0]->created_at->format('d/m/Y') }}
                            </div>

                        </div>
                    </div>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">PRODUCT NAME</th>
                                <th class="text-center">PRICE/UNIT</th>
                                <th class="text-center">QUANTITY</th>
                                <th class="text-center">GST</th>
                                <th class="text-center">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_price = 0;
                                $total_price_with_gst = 0;
                                $i = 0;
                            @endphp
                            @foreach ($sell_products as $sell_product)

                                <tr>
                                    <td class="no text-center">{{ ++$i }}</td>
                                    <td class="text-center">
                                        <h3>{{ $sell_product->product->product_name }}</h3>
                                    </td>
                                    <td class="unit text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377
                                        {{ $converter::IND_money_format($sell_product->selling_price) }}</td>
                                    <td class="qty text-center">{{ $sell_product->quantity }}</td>

                                    @if ($receipt[0]->gst == 1)
                                        <td class="qty text-center">{{ $sell_product->product->tax_slab }}%</td>
                                    @else
                                        <td class="qty text-center">-</td>
                                    @endif

                                    @php
                                        $price = $sell_product->quantity * $sell_product->selling_price;
                                        $gst_price = $price + $price * ($sell_product->product->tax_slab / 100);
                                        $total_price_with_gst = $total_price_with_gst + $gst_price;
                                        $total_price = $total_price + $price;
                                    @endphp

                                    @if ($receipt[0]->gst == 1)
                                        <td class=" total text-center" style="font-family: DejaVu Sans; sans-serif;">
                                            &#8377
                                            {{ $converter::IND_money_format($gst_price) }} </td>

                                    @else
                                        <td class="total text-center" style="font-family: DejaVu Sans; sans-serif;">
                                            &#8377
                                            {{ $converter::IND_money_format($price) }}</td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            {{-- if gst is selected --}}
                            {{-- @if ($receipt[0]->gst == 1)  --}}
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2" >Labour Charges</td>
                                <td class="text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377 {{$receipt[0]->labour_charge}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">Transportation Charges</td>
                                <td class="text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377 {{$receipt[0]->transportation_charge}}</td>
                                
                            </tr>
                            {{-- @endif --}}
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">AMOUNT PAID</td>
                                <td class="text-center">&#8377 {{  $converter::IND_money_format($receipt[0]->total_price - $receipt[0]->remaining_amount)}}</td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">AMOUNT REMAINING</td>
                                <td class="text-center">&#8377 {{  $converter::IND_money_format($receipt[0]->remaining_amount)}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="1"></td>
                                <td colspan="2">GRAND TOTAL</td>
                                @if ($receipt[0]->gst == 1)
                                    <td class="text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377
                                        {{ $converter::IND_money_format($total_price_with_gst + $receipt[0]->transportation_charge + $receipt[0]->labour_charge) }}</td>

                                @else
                                    <td class="text-center" style="font-family: DejaVu Sans; sans-serif;">&#8377
                                        {{ $converter::IND_money_format($total_price + $receipt[0]->transportation_charge + $receipt[0]->labour_charge) }}</td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                    <div class="thanks">Thank you!</div>
                    <div class="notices m-5">

                        <div class="notice"><span class="mr-3">Signature : </span><img
                                src="data:image/png;base64,{{ $signature_image}}" height="120" width="140"
                                data-holder-rendered="true" />
                        </div>
                    </div>
                </main>

            </div>
            <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
            <div></div>
        </div>
    </div>


    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</body>

</html>
