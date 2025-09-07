<!DOCTYPE html>
<html>
<head>
    <title>Shopify App</title>
    <script src="https://unpkg.com/@shopify/app-bridge"></script>
    <script src="https://unpkg.com/@shopify/app-bridge-utils"></script>
</head>
<body>
    <h1>My Shopify App</h1>

    <h3>Products:</h3>
    <ul>
        @foreach($products as $product)
            <li>{{ $product['title'] }}</li>
        @endforeach
    </ul>

    <script>
        var AppBridge = window['app-bridge'];
        var createApp = AppBridge.default;
        var app = createApp({
            apiKey: "{{ env('SHOPIFY_API_KEY') }}",
            shopOrigin: "{{ request('shop') }}",
        });
    </script>
</body>
</html>
