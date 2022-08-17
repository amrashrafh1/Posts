<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('status', 1)->where('publish_at', '<=', now())->latest()->paginate(10);

        return view('dashboard', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * $posts->perPage());
    }
    
    
    public function comment_store(Request $request, $slug)
    {
        $request->validate([
            'comment' => 'required|min:2',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $post = Post::where('slug', $slug)->firstOrFail();
        
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => request('comment'),
        ]);
        if($request->hasFile('image')){
            upload_file($request->file('image'), 'comments', $comment);
        }
        return back()->with('success', 'Comment added successfully.');
    }
    
    
    public function like(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:posts,slug',
        ]);
        $post = Post::where('slug', $request->slug)->firstOrFail();
        if($post->likes()->where('user_id',auth()->user()->id)->exists()){
            $post->likes()->where('user_id',auth()->user()->id)->delete();
        } else {
            $post->likes()->create([
                'user_id' => auth()->id(),
            ]);
        }
        return response()->json(['likes_count' => $post->likes->count() ]);
    }
}
