<x-layout navbar>

    <div class="d-flex justify-content-center align-items-center " style="height:100vh">

        <form class="w-30" method="post" action="/login">
            <h1 class="text-center">Login Form</h1>

            @csrf
            <x-form-error name="loginErr" id="loginErr"></x-form-error>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="text" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailhelp" :value="old('email')">
                <x-form-error name="email" id="emailhelp" />
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    :value="old('password')">
                <x-form-error name="password" id="passworderr" />

            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
            </div>
            <div>
                <div class="form-text">Don't have an account? <a href="/register"
                        class="text-decoration-none mb-3">Register</a></div>

            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

</x-layout>