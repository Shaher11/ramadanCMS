@extends('layouts.admin')


@section('content')


    {{-- The updating & Deleting messages --}}

    @if(Session::has('updated_category'))

        <p class="bg-success">{{session('updated_category')}}</p>

    @endif

    @if(Session::has('deleted_category'))

        <p class="bg-danger">{{session('deleted_category')}}</p>

    @endif

    {{-- End messages --}}


    <h1>Categories</h1>


    <div class="col-sm-4">

        {!! Form::open(['method'=>'POST', 'action'=> 'AdminCategoriesController@store']) !!}
             <div class="form-group">
                 {!! Form::label('name', 'Name:') !!}
                 {!! Form::text('name', null, ['class'=>'form-control'])!!}
             </div>

             <div class="form-group">
                 {!! Form::submit('Create Category', ['class'=>'btn btn-primary']) !!}
             </div>
        {!! Form::close() !!}

    </div>

    <div class="col-sm-1"></div>


    <div class="col-sm-7">


        @if($categories)


            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Created date</th>
                </tr>
                </thead>
                <tbody>

                @foreach($categories as $category)

                    <tr>
                        <td>{{$category->id}}</td>
                        <td><a href="{{route('categories.edit', $category->id)}}">{{$category->name}}</a></td>
                        <td>{{$category->created_at ? $category->created_at->diffForHumans() : 'no date'}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        @endif



    </div>





@stop