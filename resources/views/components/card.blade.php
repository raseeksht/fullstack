<a href="{{$href}}" class="text-decoration-none">
    <div class="card" style="">
        <img src="{{ asset('storage/images/' . $image) }}" class="card-img-top" alt="Uploaded Image">

        <div class="card-body">
            <h5 class="card-title fs-4 text-warning">{{$title}}</h5>
            <p class="card-text">{{$content}}</p>
            <div>
                Author: {{$author}}

            </div>
        </div>
    </div>

</a>