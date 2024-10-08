<x-layout navbar>
    <h1 class="text-center">Create a new Blog</h1>


    <form action="/blogs" method="post" enctype="multipart/form-data">
        @csrf
        <div class="fst-italic" style="font-size:13px">Field with * symbol are required</div>
        <x-form-input label="Title" name="title" id="title" required></x-form-input>

        <x-form-textarea label="Content" name="content" id="content" required></x-form-textarea>

        <x-form-input label="Image" name="image" id="image" type="file" accept="image/*"></x-form-input>



        <x-button class="btn-success" type="submit">Publish</x-button>


    </form>
</x-layout>