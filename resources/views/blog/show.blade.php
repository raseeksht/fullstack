<x-layout navbar>
    @if (session('newblog'))
        <x-alert>
            Yay! you just created a brand new blog
        </x-alert>
    @endif

    <div class="container">
        <h1>{{$blog->title}}

            @if ($blog->user->id == auth()->user()->id)


                <x-modal heading="Edit Your Blog" id="editBlog">
                    <div class="modal-body">
                        <form method="post" action="/blogs/{{$blog->id}}" id="update-blog">
                            @csrf
                            @method('PATCH')
                            <x-form-input id="title" name="title" label="Title" value="{{ $blog->title }}"
                                required></x-form-input>
                            <x-form-textarea id="content" name="content" label="Content" required>
                                {{$blog->content}}
                            </x-form-textarea>



                        </form>
                        <form method="post" action="/blogs/{{$blog->id}}" id="delete-blog-form">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" form="delete-blog-form">Delete</button>

                        <button type="submit" class="btn btn-primary" form="update-blog">Update changes</button>
                    </div>
                </x-modal>

                <!--prev update garda keu validation err xa vane popup kholne -->
                @if ($errors->any())
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            document.querySelector("#editBlogBtn").click()

                        });
                    </script>
                @endif
            @endif
        </h1>

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