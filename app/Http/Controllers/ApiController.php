<?php
// Laravel ApiController
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Cart;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function datasend()
    {
        $categories = Category::all();
        return response()->json([
            'categories' => $categories,
        ]);
    }


public function login(Request $request)
{
    try {
        $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        return response()->json(['success' => true,'data'=>$credentials], 200);
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid credentials','email'=>$request->email], 401);
    }
    } catch (\Exception $e) {
        Log::error('Login error: ' . $e->getMessage(), ['exception' => $e]);
        return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
    }
}


public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
    ]);
    $data = $user->email;
    dispatch(new SendEmail($data));
    return response()->json(['message' => 'Registration successful!', 'user' => $user], 201);
}

    function product() {
     
            $products = Product::inRandomOrder()->take(6)->get();
        
        return response()->json([
            'products' => $products,
        ]);
    }
    function productsByCategory($categoryId = null) {
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json([
            'products' => $products,
        ]);
    }

    public function redirectToGoogle()
    {
          return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->token); // Get user using token
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => encrypt('dummy'),
            ]);
        }

        Auth::login($user);

        return response()->json([
            'message' => 'Successfully logged in.',
            'user' => $user, // You can return user data or a token for your frontend
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Unable to login. Please try again.'], 500);
    }
}

public function addToCart(Request $request, $id)
{
    // Ensure the user is authenticated
    if (!Auth::check()) {
        return response()->json(['error' => 'sdfsfds'], 200);
    }
    
    $user = Auth::guard('sanctum')->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Add product to the cart
    $product = Product::findOrFail($id);

    Cart::create([
        'user_id' => $user->id,
        'product_id' => $id,
        'pname' => $product->pname,
        'pimage' => $product->images,
        'ptitle' => $product->ptitle,
        'quantity' => 1,
    ]);

    return response()->json([
        'message' => 'Product added to cart successfully!',
        'success' => true,
    ]);
}


    
}