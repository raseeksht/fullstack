<!-- @props(['name']) -->

<div id="{{$name}}" class="form-text text-danger">
    @error($name)
        {{$message}}
    @enderror
</div>