<x-layout>

    <div class="d-flex justify-content-center align-items-center " style="height:100vh">

        <form class="w-40 border p-3" method="post" action="/register">
            <h1 class="text-center">Register Form</h1>
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" id="name" aria-describedby="namehelp">

                <x-form-error name="name" id="nameerror" />


            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="text" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" :value="old('name')">

                <x-form-error name="email" id="emailerror" />


            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" :value="old('email')">

                <x-form-error name="password" id="passworderror" />
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
            </div>
            <div>
                <div class="form-text">Already registered? <a href="/login" class="text-decoration-none mb-3">Login</a>
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

    </div>

</x-layout>