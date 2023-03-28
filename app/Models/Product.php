<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['title', 'descr'];

    public static function save_product($request)
    {

        $product = new product();
        $product->title = $request->title;
        $product->descr = $request->description;
        $saveData = $product->save();
        if (!empty($saveData)) {
            $result = [
                'message' => 'products saved successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Failed.',
            ];
        }
        return $result;
    }

    public static function update_product($request, $products)
    {
        if (empty($products)) {
            $result = [
                'message' => 'Not found',
                'response' => 'error',
            ];
        }
        $updateData = $products->update([
            'title' => $request->title,
            'descr' => $request->description,
        ]);
        if (!empty($updateData)) {
            $result = [
                'message' => 'products update successfully.',
                'response' => 'success',
            ];
        } else {
            $result = [
                'response' => 'error',
                'message' => 'Failed.',
            ];
        }
        return $result;
    }
}
