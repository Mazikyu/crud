<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use App\DataTables\PostsDataTable;
use App\Http\Requests\PostCreateUpdateRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    /**
     * Viewing index with Data Table 
     * 
     * GET request to render Data Table inside index
     * @param PostsDataTable
     * @return Json
     */
    public function index()
    {
        return response()->json(Post::all());
    }

    /**
     * Updating Status directly in index view
     * 
     * PATCH request with success response 
     * @param Post $post
     * @return Json
     */
    public function status(Post $post)
    {
        $post->status = ! $post->status;
        $post->save();

        return response()->json([
            'message' => 'Status updated successfully',
            'data' => $post
        ]);
    }



    /**
     * Create a post
     * 
     * POST request, after validating form, and ceating an image path
     * a new entry in database is being made with created post
     * 
     * @param PostCreateUpdateRequest
     * @return redirect
     */
    public function store(PostCreateUpdateRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        Post::create($data);

        // redirect to general posts page
        return redirect('/posts')->with('success', 'Created Post successfully!');
    }



    /**
     * Redirect to show view
     * 
     * GET request, fetching view of one single post
     * 
     * @param Post $post
     * @return view
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }



    /**
     * Redirect to edit view
     * 
     * GET request, fetching edit form for one single post
     * 
     * @param Post $post
     * @return view
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }



    /**
     * Update a post with form 
     * 
     * PATCH request to update a single post from database, 
     * can update image as well, then after updating, user is 
     * redirected back to index with success response 
     * 
     * @param PostCreateUpdateRequest $request
     * @return redirect
     */
    public function update(PostCreateUpdateRequest $request, Post $post)
    {
        $data = $request->validated();

        // regenerate slug if name changes
        $data['slug'] = Str::slug($data['name']);

        if ($request->hasFile('image')) {

            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect('/posts')->with('success', 'Post updated successfully');
    }


    /**
     * Delete one post 
     * 
     * DELETE request
     * User deletes one single post with success message afterwards
     * 
     * @param Post $post
     * @return Json
     */
    public function destroy(Post $post)
    {
        // delete img from folder as well
        // if ($post->image) {
        //     Storage::disk('public')->delete($post->image);
        // }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }
}
