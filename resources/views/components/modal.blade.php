<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{$id}}" id="{{$id}}Btn">
    Edit
</button>

<!-- Modal -->
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="{{$id}}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserLabel">{{$heading}}</h1>
                <button type="button" class="btn-close fs-6" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{$slot}}
        </div>
    </div>
</div>