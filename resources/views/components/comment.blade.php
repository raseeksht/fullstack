<div>
    <div class="d-flex justify-content-between">
        <div class="d-flex align-items-center">
            <div>
                <img src="https://api.multiavatar.com/{{$comment['comment']->user->name}}.svg" class="img-fluid"
                    style="height:50px;width:50px" alt="{{$comment['comment']->user->name}}" />
            </div>
            <div class="mx-3 lh-1">
                <p class="mb-2"><strong>{{$comment['comment']->user->name}}</strong></p>
                <p class="mb-2" id="comment{{$comment['comment']->id}}"> {{$comment['comment']->commentContent}}</p>
                <div style="font-size:13px" class="text-decoration-underline text-primary"
                    onclick="handleReplyClick(this,{{$comment['comment']->id}},{{$comment['comment']->blog_id}})">
                    reply</div>



            </div>
        </div>
        <div class="threedots position-relative">
            <!-- <span>
              

            </span> -->

            <div class="position-absolute p-2" style="top:0px; right:20px">
                @if (auth()->user()->id == $comment['comment']->user->id)
                    <div class="dropdown">
                        <button class="bg-transparent border-0 dropdown-toggle dropdown-toggle-no-arr" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"
                                style="width: 20px; height: 20px;">
                                <path
                                    d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"
                                    style="fill: white; stroke: black; stroke-width: 2px;" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu">
                            <form action="/comments/{{$comment['comment']->id}}" method="post">
                                <li><a class="dropdown-item" href="#">
                                        @csrf
                                        @method("DELETE")
                                        <input type="hidden" name="blog_id" value="{{$comment['comment']->blog_id}}" />
                                        <button type="submit" class="bg-transparent border-0">
                                            <i class="fa-solid fa-xmark"></i> Delete
                                        </button>
                                    </a></li>
                            </form>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <button type="button" class="bg-transparent border-0" aria-label="Edit"
                                        onclick="handleEditClick(this,{{$comment['comment']->id}},{{$comment['comment']->blog_id}})">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                </a>
                            </li>
                        </ul>
                    </div>

                @endif
            </div>




        </div>
    </div>
    <div style="padding: 10px 0 0 60px;">
        @if ($comment['replies'])
            @foreach ($comment['replies'] as $reply)

                <x-comment :comment="$reply"></x-comment>

            @endforeach

        @endif

    </div>



</div>