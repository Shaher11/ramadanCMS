@extends('layouts.admin')

@section('content')


    {{-- The updating & Deleting messages --}}

    @if(Session::has('updated_post'))

        <p class="bg-success">{{session('updated_post')}}</p>

    @endif

    @if(Session::has('deleted_post'))

        <p class="bg-danger">{{session('deleted_post')}}</p>

    @endif

    {{-- End messages --}}






    <h1>Posts</h1>


    <table class="table">
       <thead>
         <tr>
             <th>Id</th>
             <th>Photo</th>

             <th>Owner</th>

             <th>Category</th>

             <th>Title</th>
             <th>body</th>


             <th>Created at</th>
             <th>Update</th>
        </thead>
        <tbody>

        @if($posts)


            @foreach($posts as $post)

          <tr>
              <td>{{$post->id}}</td>
              <td><img height="50" src="{{$post->photo ? $post->photo->file : 'http://placehold.it/400x400' }} " alt=""></td>


              <td><a href="{{route('posts.edit', $post->id)}}">  {{$post->user->name}}</a></td>

              <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>

              <td>{{str_limit($post->title,15)}}</td>
              <td>{{str_limit($post->body, 20)}}</td>

              <td>{{$post->created_at->diffForhumans()}}</td>
              <td>{{$post->updated_at->diffForhumans()}}</td>

          </tr>

            @endforeach

            @endif

       </tbody>
     </table>



@stop