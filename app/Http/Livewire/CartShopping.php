<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Post;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartShopping extends Component
{

    public $post;

    public function addCart($id)
    {
        $this->post = Post::findOrFail($id);
        Cart::add('293ad', 'Product 1', 1, 9.99, 550, ['size' => 'large']);
    }

    public function render()
    {
        return view('livewire.cart-shopping');
    }
}
