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
                           onclick="insertSomethingInEditor('{{ $field }}->value', '{{ $placeholderValue }}')">{{ $placholderName }}</a>
                    @endforeach
                </div>
            </div>
    @endforeach

    <div class="col-md-12">
        <textarea id="{{ $field }}->value" class="form-control" name="{{ $field }}->value" style="height: 400px">
            {!! $value !!}
        </textarea>
    </div>
</div>
<script>
    function insertSomethingInEditor(myField, myValue) {
        console.log(myValue); console.log(myField);
        myValue = '@{{ ' + myValue + ' }}';

        // IE support
        if (document.selection) {
            document.getElementById(myField).focus();
            sel = document.selection.createRange();
            sel.text = myValue;
        }
        // MOZILLA and others
        else if (document.getElementById(myField).selectionStart || document.getElementById(myField).selectionStart == '0') {
            var startPos = document.getElementById(myField).selectionStart;
            var endPos = document.getElementById(myField).selectionEnd;
            document.getElementById(myField).value =
                document.getElementById(myField).value.substring(0, startPos)
                + myValue
                + document.getElementById(myField).value.substring(endPos, document.getElementById(myField).value.length);
        } else {
            document.getElementById(myField).value += myValue;
        }
    }
</script>
