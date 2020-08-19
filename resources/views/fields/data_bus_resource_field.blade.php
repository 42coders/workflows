<select class="form-control" type="text" name="{{ $field }}->value" df-name>
    @foreach($fields as $field_name => $field_value)
        <option value="{{ $field_value }}"
                @if($value == $field_value) selected="selected" @endif>{{ $field_name }}</option>
    @endforeach
</select>
