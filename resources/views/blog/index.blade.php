<x-layout navbar>
    @if (session('message'))
        <x-alert>
            {{session('message')}}
        </x-alert>
    @endif
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>All Blogs</h1>
            </div>
            <div>
                <button class="btn btn-primary"><a href="/blogs/create" class="text-decoration-none text-light">
                        Write New Blog
                    </a></button>
            </div>

        </div>

        <div class="row">

            @foreach ($blogs as $blog)
                <div class="col col-md-4 mb-4 p-2 card-group">

                    <x-card title="{{$blog->title}}" content="{{Str::limit($blog->content, 150)}}" image="{{$blog->image}}"
                        author="{{$blog->user->name}}" href="/blogs/{{$blog->id}}" />
                </div>

            @endforeach
        </div>

        {{$blogs->links()}}

    </div>
</x-layout>