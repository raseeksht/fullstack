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
        <x-modal heading="Edit User" id="editUser">

            <div class="modal-body">
                <form method="post" action="/users/{{$user->id}}" id="update-form">
                    @csrf
                    @method('PATCH')
                    <x-form-error name="loginErr" id="loginErr"></x-form-error>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="namehelp"
                            value="{{$user->name}}">
                        <x-form-error name="name" id="namehelp" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{$user->email}}">
                        <x-form-error name="email" id="emailerr" />

                    </div>


                </form>
                <form method="post" action="/users/{{$user->id}}" id="delete-user-form">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" form="delete-user-form">Delete</button>

                <button type="submit" class="btn btn-primary" form="update-form">Update changes</button>
            </div>

        </x-modal>
    </div>
</x-layout>