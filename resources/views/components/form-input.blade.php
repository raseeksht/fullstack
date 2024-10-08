<div class="mb-3">
    <label for={{$id}} class="form-label fs-6">{{$label}} {{isset($required) ? "*" : ""}}</label>
    <input class="form-control" {{$attributes}}>

    <x-form-error name={{$id}} id="{{$id}}error" />


</div>