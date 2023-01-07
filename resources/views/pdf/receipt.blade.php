<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Delivery Receipt</title>
</head>
<body>
    <div>
        <img height="100px" src="https://denlee.shop/images/Icon-App-40x40@1x.png">
    </div>
    <h1>DenLee Variaty Store</h1>
    <br /><br />
    <div>
        <table>
            <tr>
              <th>SKU</th>
              <th>PRODUCT NAME</th>
              <th>QUANTITY</th>
              <th>UNIT PRICE</th>
              <th>TOTAL AMOUNT</th>
            </tr>
            @foreach ($orders as $item)
            <tr>
                <td>{{ $item->SKU }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->pivot['total'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <br />
    <div>
        Subtotal: {{ $subtotal }}
    </div>
    <hr>
    <div>
        Including 12% tax: {{ $tax }}
    </div>
    <hr>
    <div>
        <h2>Total: {{ $total }}</h2>
    </div>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

    </style>
</body>
</html>