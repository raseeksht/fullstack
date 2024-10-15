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
                @if ($errors->has('title') || $errors->has('content') || $errors->has('image'))

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

        <h2 class="underline bold">Comments</h2>
        <div>
            <form action="/comments" method="post">
                @csrf
                <div class="d-flex align-items-center">
                    <div class="w-50">
                        <input type="hidden" value="{{$blog->id}}" name="blog_id" type="number" />
                        <x-form-input name="comment" id="commentContent" name="commentContent"
                            label="Make a new Comment" placeholder="Your Awesome Comment" required></x-form-input>

                    </div>
                    <div class="mt-3 mx-4">

                        <x-button type="submit">
                            Add Comment
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
        @foreach ($comments as $comment)

            <x-comment :comment="$comment"></x-comment>
            <hr />


        @endforeach


    </div>



    <script>
        const handleReplyClick = (element, commentId, blogId) => {
            // const csrf = document.querySelector('meta[name=csrf-token]').getAttribute('content')
            element.parentElement.insertAdjacentHTML("beforeend", `
            <form action="/comments" method="post">
                @csrf
                <input type="hidden" value="${commentId}" name="parent" />
                <input type="hidden" value="${blogId}" name="blog_id" />
                <div class="d-flex">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="commentContent" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
                    </div>

                    <div>
                        <button class='btn btn-primary' type="submit">Reply</button>
                    </div>
                </div>
            </form>
            `);
        }

        const handleEditClick = (element, commentId, blogId) => {
            const commentContainer = document.getElementById(`comment${commentId}`)
            commentContainer.innerHTML = `
            <div>
            <form action="/comments/${commentId}" method="post">
                @csrf
                @method("PATCH")
                <div class="d-flex">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="commentContent" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="${commentContainer.innerHTML}" required>
                    </div>

                    <div>
                        <button class='btn btn-primary' type="submit">Edit</button>
                    </div>
                </div>
            </div>
            `
        }
    </script>


</x-layout>