<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Blog;
use App\Tag;
use App\User;
use Auth;
use Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::orderBy('published_on', 'desc')->published()->paginate(3);
        return view('blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::pluck('name', '_id');
        return view('blog.add', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $blogs_org_dir = 'public/blogs/origional';
        Storage::makeDirectory($blogs_org_dir);

        if($blog_file = $request->blog_image->store($blogs_org_dir)) // Upload avatar
        {
            $org_blog_source = str_replace ('public', 'storage', $blog_file);
            $blog = Auth::User()->blogs()->create(
                [
                'title' => $request->title,
                'text' => $request->text,
                'published_on' => $request->published_on,
                'blog_image' => $org_blog_source,
                'deleted_at' => NULL
                ]
                );
            $blog->tags()->sync($request->tag_list);

            if($request->new_tags) {
                foreach($request->new_tags as $new_tag) {
                    $tag = Tag::create(['name' => $new_tag]);
                    if($tag) {
                        $blog->tags()->attach($tag->id);        
                    }
                }
            }
        }

        if($blog) {
            return redirect()->route('blog.index')->with(['message' => 'Your blog has been successfully posted.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view('blog.detail', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Blog $blog)
    {
        $tags = Tag::pluck('name', '_id');
        if ($request->user()->can('update', $blog)) {
            return view('blog.edit', compact('blog', 'tags'));
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        if ($request->user()->can('update', $blog)) {
            $blogs_org_dir = 'public/blogs/origional';
            Storage::makeDirectory($blogs_org_dir);

            $blog->title = $request->title;
            $blog->text = $request->text;
            $blog->published_on = $request->published_on;

            if($request->blog_image && $blog_img_file = $request->blog_image->store($blogs_org_dir)) // Upload avatar
            {
                $blog_image_source = str_replace ('public', 'storage', $blog_img_file);
                $blog->blog_image = $blog_image_source;
            }
            $blog->tags()->sync($request->tag_list);

            if($request->new_tags) {
                foreach($request->new_tags as $new_tag) {
                    $tag = Tag::create(['name' => $new_tag]);
                    if($tag) {
                        $blog->tags()->attach($tag->id);        
                    }
                }
            }
            
            $blog->save();

            return redirect()->route('blog.edit', $blog->id)->with(['message' => 'Your blog has been successfully updated.']);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Blog $blog)
    {
        if ($request->user()->can('delete', $blog)) {
            if($blog->delete()) {
                return redirect()->route('blog.index')->with(['message' => 'Your blog has been successfully deleted.']);
            }else {
                abort(403);
            }
        }
    }

    /**
     * Get the logged in user's blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function userBlogs(User $user)
    {
        $blogs = $user->blogs()->orderBy('published_on', 'desc')->paginate(3);
        return view('blog.index', compact('blogs'));
    }
}