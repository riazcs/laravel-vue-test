<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::get();
        if (empty($products)) {
            $result = [
                'response' => 'error',
                'message' => 'Product not found.',
            ];
        } else {
            $result = [
                'response' => 'success',
                'products' => $products,
            ];
        }
        return response()->json($result);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            $result['response'] = 'error';
            $result['message'] = $validator->errors();
            return response()->json($result);
        }
        $user = User::find($request->loggedInUserId);
        if (!($user && $user->type == 1)) {
            return response()->json([
                'response' => 'error',
                'message' => 'Not permission.',
            ]);
        }
        $saveData = Product::save_product($request);
        if ($saveData['response'] == 'success') {
            $result = [
                'message' => 'Product saved successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Failed.',
            ];
        }
        return response()->json($result);
    }

    public function show(Product $product)
    {
        if (empty($product)) {
            $result = [
                'response' => 'error',
                'message' => 'Product not found.',
            ];
        } else {
            $result = [
                'response' => 'success',
                'product' => $product,
            ];
        }
        return response()->json($result);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);
        if ($validator->fails()) {
            $result['response'] = 'error';
            $result['message'] = $validator->errors();
            return response()->json($result);
        }

        $user = User::find($request->loggedInUserId);
        if (!($user->type == 1 || $user->type == 2)) {
            return response()->json([
                'response' => 'error',
                'message' => 'Not permission.',
            ]);
        }
        $updateData = Product::update_product($request, $product);
        if ($updateData['response'] == 'success') {
            $result = [
                'message' => 'Product updated successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Failed.',
            ];
        }
        return response()->json($result);
    }

    public function destroy(Request $request, Product $product)
    {
        $user = User::find($request->loggedInUserId);
        if (!($user && $user->type == 1)) {
            return response()->json([
                'response' => 'error',
                'message' => 'Not permission.',
            ]);
        }
        $product = Product::find($request->id);
        if (!empty($product)) {
            $deleteData = $product->delete();
            if (!empty($deleteData)) {
                $result = [
                    'message' => 'Product deleted successfully.',
                    'response' => 'success',
                ];
            } else {
                $result = [
                    'message' => 'Product deleted failed.',
                    'response' => 'error',
                ];
            }
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Product not found.',
            ];
        }
        return response()->json($result);
    }
}
