<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
  /**
   * @param $product_id
   * @param \Illuminate\Http\Request $request
   * @return mixed
   */
  public function edit($product_id, Request $request)
  {
    $product = Product::findOrFail($product_id);
    $user = User::findOrFail($product->author->id);
    Auth::login($user);

    return redirect()->route('product.edit', $product);
  }

  /**
   * @param $type
   * @return mixed
   */
  public function getProductsIndex($type)
  {
    $type_name = $this->getTypeName($type);
    $items = Product::whereType($type)->get();
    if ($type == 2) {
      $items = Product::whereType($type)->where('for_sale', 1)->where('sold', 0)->get();
    }

    return view('web.admin.items.products', compact('items', 'type', 'type_name'));
  }

  public function getFilteredByStatus($type, $status)
  {
    $items = Product::whereType($type)->whereStatusId($status)->get();
    $type_name = $this->getTypeName($type);

    return view('web.admin.items.products', compact('items', 'type', 'type_name'));
  }

  /**
   * @param $type
   * @return mixed
   */
  public function getProductsNew($type)
  {
    $type_name = $this->getTypeName($type);
    $items = Product::whereType($type)->whereViewed(false)->get();

    return view('web.admin.items.products', compact('items', 'type', 'type_name'));
  }

  public function updateProductStatus(Product $product, $status)
  {
    $product->update(['status_id' => $status]);

    return redirect()->back();
  }

  /**
   * @param $type
   * @return mixed
   */
  public function getProductsFavorite($type)
  {
    $type_name = $this->getTypeName($type);
    $items = Product::whereType($type)->whereFavorite(true)->get();

    return view('web.admin.items.products', compact('items', 'type', 'type_name', 'type_name'));
  }

  /**
   * @param $type
   * @return mixed
   */
  public function getProductsRejected($type)
  {
    $type_name = $this->getTypeName($type);
    $items = Product::whereType($type)->whereRejected(true)->get();

    return view('web.admin.items.products', compact('items', 'type', 'type_name'));
  }

  /**
   * @param $type
   * @return mixed
   */
  public function getProductsTop($type)
  {
    $type_name = $this->getTypeName($type);
    $items = Product::whereType($type)->whereTop(1)->get();

    return view('web.admin.items.products', compact('items', 'type', 'type_name'));
  }

  /**
   * @param $type
   * @return mixed
   */
  public function getProductsNotForSale($type)
  {
    $type_name = $this->getTypeName($type);
    $items = Product::whereType(2)->where('for_sale', 0)->get();

    return view('web.admin.items.products', compact('items', 'type', 'type_name'));
  }

  /**
   * @param $type
   * @return mixed
   */
  public function getProductsSold($type)
  {
    $type_name = $this->getTypeName($type);
    $items = Product::whereType(2)->where('sold', 1)->get();

    return view('web.admin.items.products', compact('items', 'type', 'type_name'));
  }

  /**
   * @param $id
   * @param \Illuminate\Http\Request $request
   * @return mixed
   */
  public function toggleFavorite($id, Request $request)
  {
    $product = Product::findOrFail($id);
    $product->favorite = ! $product->favorite;
    $product->viewed = 1;
    $product->save();

    return redirect()->to($request->header('referer').'#'.$product->id);
  }

  /**
   * @param $id
   * @param \Illuminate\Http\Request $request
   * @return mixed
   */
  public function toggleRejected($id, Request $request)
  {
    $product = Product::findOrFail($id);
    $product->rejected = ! $product->rejected;
    $product->viewed = 1;
    $product->save();

    return redirect()->to($request->header('referer').'#'.$product->id);
  }

  /**
   * @param $id
   * @param \Illuminate\Http\Request $request
   * @return mixed
   */
  public function toggleTop($id, Request $request)
  {
    $product = Product::findOrFail($id);
    $product->favorite = 1;
    $product->rejected = 0;
    $product->viewed = 1;
    $product->top = ! $product->top;
    $product->save();

    return redirect()->to($request->header('referer').'#'.$product->id);
  }

  /**
   * @param $id
   * @param \Illuminate\Http\Request $request
   * @return mixed
   */
  public function toggleViewed($id, Request $request)
  {
    $product = Product::findOrFail($id);
    $product->viewed = ! $product->viewed;
    $product->save();

    return redirect()->to($request->header('referer').'#'.$product->id);
  }

  /**
   * @param $type
   * @return mixed
   */
  private function getTypeName($type)
  {
    $types = [
      1 => 'Принты',
      2 => 'Картины',
      3 => 'Предметы',
    ];
    $type_name = $types[$type];

    return $type_name;
  }
}
