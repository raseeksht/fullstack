<div>
    <div class="d-flex align-items-center">

        <div>
            <img src="https://api.multiavatar.com/{{$comment['comment']->user->name}}.svg" class="img-fluid"
                style="height:50px;width:50px" alt="{{$comment['comment']->user->name}}" />
        </div>
        <div class="mx-3 lh-1">
            <p class="mb-2"><strong>{{$comment['comment']->user->name}}</strong></p>
            <p class="mb-2"> {{$comment['comment']->commentContent}}</p>
            <div style="font-size:13px" class="text-decoration-underline text-primary">reply</div>



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
<hr />