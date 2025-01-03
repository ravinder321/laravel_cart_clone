<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        /* Container Styling */
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Header Styles */
        .cart-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .cart-header h1 {
            font-size: 2.5rem;
            color: #343a40;
            margin: 0;
            padding: 10px 0;
            border-bottom: 2px solid #007bff;
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Buttons */
        .btn {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            border: none;
            outline: none;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Empty Cart Styling */
        .empty-cart {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 20px;
        }

        .empty-cart a {
            color: #007bff;
            text-decoration: none;
        }

        .empty-cart a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cart-header">
            <h1>Your Cart</h1>
        </div>

        @if($cartItems->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->pname }}</td>
                            <td><img src="{{ asset($item->pimage) }}" alt="{{ $item->pname }}" width="80"></td>
                            <td>{{ $item->ptitle }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item->product_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="decrement">
                                    <button type="submit" class="btn btn-warning">-</button>
                                </form>
                                <span class="quantity">{{ $item->quantity }}</span>
                                <form action="{{ route('cart.update', $item->product_id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="action" value="increment">
                                    <button type="submit" class="btn btn-success">+</button>
                                </form>
                            </td>
                            <td>${{ number_format($item->product->pprice) }}</td>
                            <td>${{ number_format($item->quantity * $item->product->pprice, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty-cart">Your cart is empty. <a href="{{ route('users.home') }}">Shop now!</a></p>
        @endif
    </div>
</body>
</html>
