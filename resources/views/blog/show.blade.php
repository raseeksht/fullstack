<x-layout navbar>
    @if (session('newblog'))
        <x-alert>
            Yay! you just created a brand new blog
        </x-alert>
    @endif

    <div class="container">
        <h1>{{$blog->title}}</h1>

        <div>Published: {{$blog->created_at}}</div>





        <div class="container">
            <div class="row">

                <div class="col-auto">
                    <img src="{{ asset('storage/images/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid"
                        style="max-width:200px">
                </div>
                <div class="col">
                    <p>
                        {{$blog->content}}
                    </p>
                </div>
            </div>
        </div>


    </div>







</x-layout>