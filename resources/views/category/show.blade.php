<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts in {{ $category->category_name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Header styling */
        h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            padding: 10px;
            background: linear-gradient(90deg, #ff7e5f, #feb47b);
            color: white;
            border-radius: 8px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* General container styling */
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 0 auto;
            max-width: 1200px;
        }

        /* Individual item styling */
        .col-lg-4 {
            flex: 0 0 calc(33.333% - 20px); /* 3 items per row with 20px gap */
            margin-bottom: 30px;
            position: relative;
            text-align: center;
            box-sizing: border-box;
        }

        /* Styling for the thumbnail */
        .thumb {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 100%; /* Ensures the thumbnail fits the column width */
            height: 300px; /* Fixed height for all images */
        }

        .thumb img {
            width: 100%;
            height: 100%; /* Ensures it fills the thumbnail container */
            object-fit: cover; /* Maintains aspect ratio and crops excess */
            transition: transform 0.3s ease-in-out;
        }

        .thumb:hover img {
            transform: scale(1.1); /* Zoom effect */
        }

        /* Hover content overlay */
        .hover-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            z-index: 10;
        }

        .thumb:hover .hover-content {
            display: block;
        }

        .hover-content ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 10px;
        }

        .hover-content ul li {
            background-color: #fff;
            padding: 10px;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .hover-content ul li:hover {
            background-color: #f7f7f7;
        }

        .hover-content ul li a {
            color: #000;
            text-decoration: none;
        }

        /* Down content for title and price */
        .down-content {
            margin-top: 10px;
        }

        .down-content h4 {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }

        .down-content span {
            color: #666;
            font-size: 16px;
            display: block;
            margin: 5px 0;
        }

        .stars {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .stars li {
            color: #ffc107; /* Gold for stars */
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Posts in {{ $category->category_name }}</h1>

    <div class="row">
        @foreach($posts as $post)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="item">
                    <div class="thumb">
                        <img src="{{ asset($post->images) }}" alt="{{ $post->ptitle }}" style="width: 100%; height: auto;">
                        <div class="hover-content">
                            <ul>
                                <li><a href="{{ route('product.show', $post->id) }}"><i class="fa fa-eye"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="down-content text-center">
                        <h4>{{ $post->ptitle }}</h4>
                        <span>${{ $post->price ?? 'N/A' }}</span>
                        <ul class="stars">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
