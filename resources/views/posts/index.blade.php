@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <form action="{{route('posts')}}" method="post" class="mb-4">
                @csrf
                @auth
                <div class="mb-3">
                    <label for="body" class="sr-only">Body</label>
                    <textarea name="body" id="body" cols="30" rows="4" 
                    placeholder="Post Something!"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg p-3 
                    @error('body') border-red-500 @enderror" 
                    ></textarea>
                    @error('body')
                    <div class="text-red-500 mt-2 text-sm">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">
                    Post</button>
                </div>
                @endauth
            </form>

            @if($posts->count())
                @foreach ($posts as $post)
                <div class="mb-3 bg-gray-200 border-2 w-full p-3 rounded-lg">
                    <a href="" class="font-bold capitalize ">{{$post->user->name}}</a>
                    <span class="text-gray-600 text-xs mx-1">{{$post->created_at->diffForHumans()}}</span>
                    <p class="text-gray-800 mb-2">{{$post->body}}</p>

                    @can('delete',$post)
                    <div>
                        <form action="{{route('posts.destroy',$post)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-500">Delete</button>
                        </form>
                    </div>
                    @endcan
                    <div class="flex items-center">
                        @auth
                        @if(!$post->likedBy(auth()->user()))
                        <form action="{{route('posts.likes',$post)}}" method="post" class="mr-1">
                            @csrf
                            <button type="submit" class="text-blue-400">Like</button>
                        </form>
                        @else
                        <form action="{{route('posts.likes',$post)}}" method="post" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-400">Unike</button>
                        </form>
                        @endif
                        
                        @endauth
                        <span class="mx-2">
                            {{$post->likes->count()}}{{Str::plural('like',$post->likes->count())}}
                        </span>
                    </div>
                </div>
                    
                @endforeach
                {{$posts->links()}}
            @else
                <p>There are no Posts available</p>
            @endif
        </div>
    </div>
@endsection