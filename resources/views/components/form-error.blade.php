<!-- @props(['name']) -->

<div id="emailHelp" class="form-text text-danger">
    @error($name)
        {{$message}}
    @enderror
</div>