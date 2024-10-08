<div class="mb-3">
    <label for={{$id}} class="form-label">{{$label}} {{isset($required) ? "*" : ""}}</label>
    <textarea class="form-control" {{$attributes}} style="min-height:300px">


    </textarea>

    <x-form-error name={{$id}} id="{{$id}}error" />


</div>