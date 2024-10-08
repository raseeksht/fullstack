<x-layout navbar>
    <div class="container">
        <h1>Individual Users</h1>

        <div class="row gap-2">

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

        </div>
        <!-- <button class="btn btn-primary"><a href="/users/{{$user->id}}/edit">Edit</a></button> -->
        <x-modal :user="$user">

        </x-modal>
    </div>
</x-layout>