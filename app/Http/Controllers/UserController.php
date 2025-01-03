<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\RegistrationSuccess;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    public function login()
    {
        return view('login.login');
    }

    public function register()
    {
        return view('login.register');
    }


    public function create(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
         ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
     
         $data = $user->email;
         dispatch(new SendEmail($data));
         return redirect()->route('users.login')->with('success', 'Registration successful. Check your email!');
    }

    public function user_login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended('/');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('users.login');
    }

    public function category()
    {
        $categories = Category::all();
        return view('welcome',compact('categories'));
    }

    public function show($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id); // Find category by ID
        $posts = product::where('category_id', $id)->get(); // Get posts for that category

        return view('category.show', compact('categories','category', 'posts'));
    }

    public function product_show($id)
    {
        $post = product::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function product()
    {
        return view('products');
    }

    public function form()
    {
        return view('cart.shop');
    }

    function productsByCategory($categoryId = null) {
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json([
            'products' => $products,
        ]);
    }

    function productByproducts($productId = null) {
        $products = Product::where('id', $productId)->get();
        return response()->json([
            'products' => $products,
        ]);
    }

    public function react_register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'user' => $user,
        ]);
    }

}
