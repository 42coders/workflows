<div class="row">
    @foreach($placeholders as $placholderCategories => $placholder)
            <div class="dropdown" style="margin-left: 15px; margin-bottom: 10px;">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $placholderCategories }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($placholder as $placholderName => $placeholderValue)
                        <a class="dropdown-item" href="#"
                           onclick="insertSomethingInEditor('{{ $field }}_trix', '{{ $placeholderValue }}')">{{ $placholderName }}</a>
                    @endforeach
                </div>
            </div>
    @endforeach

    <div class="col-md-12">
        <input class="form-control" id="{{ $field }}->value" value="{!! $value !!}" type="hidden"
               name="{{ $field }}->value" df-name>
        <trix-editor input="{{ $field }}->value" id="{{ $field }}_trix" style="height: 400px"></trix-editor>
    </div>
</div>
<script>
    function insertSomethingInEditor(id, value) {
        var element = document.getElementById(id);
        element.editor.insertString('@{{ ' + value + ' }}');
    }
</script>
