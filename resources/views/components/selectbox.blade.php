<div class="form-group {{$col ?? ''}} {{$required ?? ''}}" >
    <label for="{{$name}}">{{$labelName}}</label>
    <select name="{{$name}}" id="{{$name}}" class="form-control {{$class ?? ''}}"  @if(!empty($onchange)) onchange="{{$onchange}}" @endif>
        {{$slot}}
    </select>
</div>
