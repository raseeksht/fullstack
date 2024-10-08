<div class="mb-3">
    <label for={{$id}} class="form-label">{{$label}} {{isset($required) ? "*" : ""}}</label>
    <input class="form-control" {{$attributes}}>

    <x-form-error name={{$id}} id="{{$id}}error" />


</div>