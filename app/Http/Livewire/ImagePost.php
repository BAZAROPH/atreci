<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Post;

class ImagePost extends Component
{
    public $post;
    public  $listeners = ['deleteMedia'];

    public function mount()
    {
        $this->post = Post::find(request('id'));
    }

    //protected $listeners = ['postAdded' => 'incrementPostCount'];

    public function deleteMedia($id)
    {
        $mediaItems = $this->post->getMedia('image');
        //dd($mediaItems->toArray());
        $mediaItems[$id]->delete();

        //$this->refresh();
        //return $this->post;

        /* $test = Post::findOrFail(57);
        $test->delete(); */
    }

    public function render()
    {
        return view('livewire.image-post');
    }
}
