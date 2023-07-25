<html>
<body>
    <h1>Fatura Bilgileri</h1>

    <h2>Müşteri Bilgileri</h2>
    <p>Adı: {{ $data['customer']['name'] }}</p>
    <p>Adresi: {{ $data['customer']['address'] }}</p>

    <h2>Müşteri Numarası</h2>
    <p>{{ $data['customer_id    '] }}</p>

    <h2>Fatura Numarası</h2>
    <p>{{ $data['invoice_code'] }}</p>

    <h2>Fatura Tarihi</h2>
    <p>{{ $data['invoice_date'] }}</p>

    <h2>Ürünler</h2>
    <ul>
        @foreach($data['invoice_items'] as $item)
            <li>{{ $item['name'] }} - {{ $item['price'] }} TL</li>
        @endforeach
    </ul>
</body>
</html>
