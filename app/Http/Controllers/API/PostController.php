<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\API\BaseController as BaseController;

class PostController extends BaseController
{
    public function index()
    {
        $data['posts'] = Post::all();        
        return $this->sendResponse($data, 'All Posts Data');
    }

    public function store(Request $request)
    {
        $validatePost = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        if ($validatePost->fails()) {
            return $this->sendError('Validation Error', $validatePost->errors()->all());
        }

        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads', $imageName);

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return $this->sendResponse($post, 'Post Created Successfully');
    }

    public function show(string $id)
    {
        $data['post'] = Post::select('id', 'title', 'description', 'image')->where('id', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Post');
    }

    public function update(Request $request, string $id)
    {
        $validatePost = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,gif', // Make image optional for update
            ]
        );

        if ($validatePost->fails()) {
            return $this->sendError('Validation Error', $validatePost->errors()->all());
        }

        $postImage = Post::select('id', 'image')->where(['id' => $id])->first();

        if ($request->image) {
            $path = public_path() . '/uploads';

            if ($postImage->image) {
                $old_file = $path . '/' . $postImage->image;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }

            $img = $request->image;
            $ext = $img->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $img->move(public_path() . '/uploads', $imageName);
        } else {
            $imageName = $postImage->image;
        }

        $post = Post::where(['id' => $id])->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return $this->sendResponse($post, 'Post Updated Successfully');
    }

    public function destroy(string $id)
    {
        $imagePath = Post::select('image')->where('id', $id)->first();

        if ($imagePath && file_exists(public_path('/uploads/' . $imagePath->image))) {
            unlink(public_path('/uploads/' . $imagePath->image));
        }

        $post = Post::where('id', $id)->delete();

        return $this->sendResponse($post, 'Post Deleted Successfully');
    }
}

