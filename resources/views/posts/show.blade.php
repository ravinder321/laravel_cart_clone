<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Product Details</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f4f4f9, #d6d9f2);
        }

        /* Product Card Styles */
        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            text-align: center;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* Product Image */
        .product-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Product Info */
        .product-info {
            padding: 20px;
        }

        .product-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 10px;
        }

        .product-description {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .product-price {
            font-size: 1.5rem;
            color: #6200ea;
            font-weight: bold;
        }

        /* Add to Cart Button */
        .btn {
            display: inline-block;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 12px 24px;
            margin-top: 20px;
            border: none;
            border-radius: 30px;
            background: linear-gradient(90deg, #6200ea, #9c47ff);
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            background: linear-gradient(90deg, #9c47ff, #6200ea);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="product-card">
        <div class="product-image">
            <img src="{{ asset($post->images) }}" alt="{{ $post->ptitle }}" style="width: 70%; height: auto; margin: auto;">
        </div>
        <div class="product-info">
            <h1 class="product-title">Smart Watch Pro X</h1>
            <p class="product-description">Experience the ultimate smartwatch with advanced health tracking, stunning design, and all-day battery life. Perfect for your busy lifestyle.</p>
            <p class="product-price">$249.99</p>
            <form action="{{ route('cart.add', $post->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn">Add to Cart</button>
            </form>
        </div>
    </div>
</body>
</html>
