<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\PostReaction;
use App\Helper\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;
use Auth;

class PostController extends Controller
{
    
//     public function __construct()
// {
//     $this->middleware('auth')->only('comment');
// }
    public function index()
    {
        $posts = Post::with('user')->orderBy("created_at", "desc")->paginate(10);
        $recentTags = $this->getRecentTags();
        return view("frontend.layout.community", compact("posts", "recentTags"));
    }


    public function like(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Need to login First'], 401);
    }

    $post = Post::find($request->post_id);

    if (!$post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    // Check if the user has already reacted to this post
    $reaction = PostReaction::where('post_id', $post->id)
                            ->where('user_id', $user->id)
                            ->first();

    if ($reaction) {
        // If already liked, remove the like
        if ($reaction->reaction_type === 'like') {
            $reaction->delete();
        } else {
            // Otherwise, change the reaction to like
            $reaction->reaction_type = 'like';
            $reaction->save();
        }
    } else {
        // Create a new reaction
        PostReaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'reaction_type' => 'like',
        ]);
    }

    // Update like and dislike counts on the post
    $post->like_post = PostReaction::where('post_id', $post->id)
                                   ->where('reaction_type', 'like')
                                   ->count();
    $post->dislike = PostReaction::where('post_id', $post->id)
                                 ->where('reaction_type', 'dislike')
                                 ->count();
    $post->save();

    return response()->json(['message' => 'Reaction updated', 'like_post' => $post->like_post, 'dislike' => $post->dislike]);
}

public function dislike(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'You need to login first'], 401);
    }

    $post = Post::find($request->post_id);

    if (!$post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    // Check if the user has already reacted to this post
    $reaction = PostReaction::where('post_id', $post->id)
                            ->where('user_id', $user->id)
                            ->first();

    if ($reaction) {
        // If already disliked, remove the dislike
        if ($reaction->reaction_type === 'dislike') {
            $reaction->delete();
        } else {
            // Otherwise, change the reaction to dislike
            $reaction->reaction_type = 'dislike';
            $reaction->save();
        }
    } else {
        // Create a new reaction
        PostReaction::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'reaction_type' => 'dislike',
        ]);
    }

    // Update like and dislike counts on the post
    $post->like_post = PostReaction::where('post_id', $post->id)
                                   ->where('reaction_type', 'like')
                                   ->count();
    $post->dislike = PostReaction::where('post_id', $post->id)
                                 ->where('reaction_type', 'dislike')
                                 ->count();
    $post->save();

    return response()->json(['message' => 'Reaction updated', 'like_post' => $post->like_post, 'dislike' => $post->dislike]);
}



public function comment(Request $request)
{
    // Check if the user is authenticated
    if (!Auth::check()) {
        // Redirect back with an error message if not logged in
        return redirect()->back()->with('t-error', 'You need to log in first.');
    }

    // Validate the request data
    $request->validate([
        'post_id' => 'required|exists:posts,id',
        'comment' => 'required|string|max:5000',
    ]);

    // Find the post by ID
    $post = Post::find($request->post_id);

    if ($post) {
        // Create a new comment
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->comment = $request->comment;

        // Save the comment
        $comment->save();

        // Redirect back with a success message
        return redirect()->back()->with('t-success', 'Comment added successfully!');
    } else {
        // If post not found, redirect back with an error message
        return redirect()->back()->with('t-error', 'Post not found.');
    }
}
    
    
public function reply(Request $request)
{
    // Validate the request data
    $request->validate([
        'comment_id' => 'required|exists:comments,id',
        'name' => 'required|string|max:255',
        'comment' => 'required|string|max:5000',
    ]);

    // Create a new reply
    $reply = new Reply();
    $reply->comment_id = $request->comment_id;
    $reply->name = $request->name;
    $reply->comment = $request->comment;
    $reply->save();

    // Redirect back with a success message
    return redirect()->back()->with('t-success', 'Reply added successfully!');
}









    public function getRecentTags()
    {
        $recentTags = Post::latest()
            ->take(10)
            ->get()
            ->pluck('tag')
            ->flatten()
            ->unique()
            ->slice(0, 10);
        return $recentTags;
    }

    public function singlepost($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('frontend.layout.singlepost', compact('post'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('t-error', 'You need to login to post.');
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required',
            'tag' => 'required',
            'message' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $slug = Helper::makeSlug(Post::class, $request->title);

            $post = new Post();
            $post->title = $request->title;
            $post->slug = $slug;
            $post->user_id = $request->user_id;

            $tags = json_decode($request->tag, true);
            $tagValues = array_map(function ($tag) {
                return $tag['value'];
            }, $tags);
            $post->tag = $tagValues;

            $post->message = $request->message;

            $randomString = Str::random(20);
            $post->image = Helper::fileUpload($request->file('image'), 'post', $slug . '_' . $randomString);

            $post->save();

            return redirect()->route('post.index')->with('t-success', 'Post created successfully');
        } catch (Exception) {
            return redirect()->route('post.index')->with('t-error', 'Post failed to create');
        }
    }
}
