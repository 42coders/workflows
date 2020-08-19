<select class="form-control" type="text" name="{{ $field }}->value" df-name>
    @foreach($options as $optionValue => $optionName)
        <option value="{{$optionValue}}" @if($optionValue == $value) selected @endif>{{$optionName}}</option>
    @endforeach
</select>
