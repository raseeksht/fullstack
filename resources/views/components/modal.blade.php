<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUser">
    Edit
</button>

<!-- Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
        </div>
    </div>
</div>