<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostsCreateRequest;
use App\Photo;
use App\Post;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::pluck('name','id')->all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(PostsCreateRequest $request)
    {
        //

        $input = $request->all();





        if($file = $request->file('photo_id')){


            $name = time() . $file->getClientOriginalName();


            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);


            $input['photo_id'] = $photo->id;


        }



        Auth::user()->posts()->create($input);

        return redirect('/admin/posts');


    }







//    public function store(PostsCreateRequest $request)
//    {
//        //
//        //assigning the request
//        $input = $request->all();
//        //get logged in user
//        $user = Auth::user();
//        $input['user_id']=$user->id;
//
//        //checking to see if we have a file
//        if($file = $request->file('photo_id')){
//
//            //if you do you will get this file name
//            $name= time() . $file->getClientOriginalName();
//
//            //move the file to images
//            $file->move('images',$name);
//
//            //then create a photo
//            $photo= Photo::create(['file'=>$name]);
//
//            //insert the photo id to post
//            $input['photo_id']= $photo->id;
//
//        }
//
////        the relationship between users and posts
//        //chaining another method
//        $user->posts()->create($input);
//
//        return redirect('/admin/posts');
//
////        $post = new Post();
////        $post->user_id = $input['user_id'];
////        $post->category_id = $input['category_id'];
////        $post->photo_id = $input['photo_id'];
////        $post->title= $input['title'];
////        $post->body= $input['body'];
////        $post->save();
//
////        return $request->all(); For test
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);

        $categories = Category::pluck('name','id')->all();

        return view('admin.posts.edit', compact('post','categories'));



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();


        if($file = $request->file('photo_id')){


            $name = time() . $file->getClientOriginalName();


            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);


            $input['photo_id'] = $photo->id;


        }

         Auth::user()->posts()->whereId($id)->first()->update($input);

        Session::flash('updated_post','The post has been updated');


        return redirect('/admin/posts');




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);

        //to delete the photo from images file
        unlink(public_path() . $post->photo->file);

        $post->delete();

        Session::flash('deleted_post','The post has been deleted');

        return redirect('/admin/posts');



    }
}
