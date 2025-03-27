<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Shipping</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .print-container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        /* Hapus Header & Footer saat print */
        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 0;
                padding: 40px;
            }
        }
    </style>
</head>

<body>

    <div class="print-container">
        <input type="image" class="img-fluid" width="150" style="text-align: center;"
            src="{{ asset('assets/images/teckdor.png') }}" alt="">
        <h2 style="text-align: center;">Shipping Product</h2>
        <h2 style="text-align: center;">TeckD'or Ameublements</h2>
        <p><strong>Code Shipping:</strong> {{ $order_shipping->first()->code_shipping }}</p>
        <p><strong>Date:</strong> {{ $order_shipping->first()->created_at->format('d F Y H:i:s') }}</p>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Customer</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_shipping as $shipping)
                    <tr>
                        <td>{{ $shipping->order->code_order }}</td>
                        <td>{{ $shipping->order->product->name_product }}</td>
                        <td>{{ optional($shipping->order->user)->name ?? 'No Customer' }}</td>
                        <td>{{ $shipping->order->qty ?? '0' }} Set</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
            window.print(); // Cetak otomatis saat halaman terbuka
            window.onafterprint = function() {
                window.close(); // Menutup tab setelah proses print selesai
            };
        };
    </script>

</body>

</html>
