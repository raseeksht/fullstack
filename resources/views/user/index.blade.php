<x-layout navbar>
    <h1>All Users</h1>

    <div class="row gap-2">

        @foreach ($users as $user)
            <div class="col-md-3 border">
                <a href="/users/{{$user->id}}/" class="text-decoration-none">
                    <div>
                        Name: {{$user->name}}

                    </div>
                    <div>
                        Email: {{$user->email}}

                    </div>
                </a>
            </div>

        @endforeach
    </div>

</x-layout>