<div id="settings-overlay" class="settings-overlay">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 20px;">
                <div class="settings-headline">
                    <h1>{!! $element::$icon !!} {{ $element::getTranslation()  }} {{__('workflows::workflows.Settings') }}</h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="settings-body">
                    @foreach($element::$commonFields as $fieldName => $field)
                        <h4>{{ $fieldName }}</h4>
                        <div class="form-group" id="{{$field}}">
                            <input class="form-control" type="text" name="{{$field}}->value"
                                   value="{{ $element->getFieldValue($field) }}" df-name>
                        </div>
                    @endforeach
                    @foreach($element::$fields as $fieldName => $field)
                        <h4>{{ $fieldName }}</h4>
                        <div class="form-group">
                            <select class="form-control" name="{{$field}}->type"
                                    onchange="loadResourceIntelligence({{ $element->id }}, '{{ $element->family }}', '{{ $element->getFieldValue($field) }}', '{{ $field }}', this);">
                                @foreach(config('workflows.data_resources') as $resourceName => $resourceClass)
                                    <option
                                        value='{{ $resourceClass }}' {{ $element->fieldIsSelected($field, $resourceClass) }} >{{ __('workflows::workflows.Resources.'.$resourceName) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="{{$field}}">
                            {!! $element->loadResourceIntelligence($field) !!}
                        </div>
                    @endforeach
                    @foreach($element::$output as $fieldName => $field)
                        <h4>{{ $fieldName }}</h4>
                        <div class="form-group" id="{{$field}}">
                            <input class="form-control" type="text" name="{{$field}}->value"
                                   value="{{ $element->getFieldValue($field) }}" df-name>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12">
                <div class="settings-footer text-right">
                    <button class="btn btn-default"
                            onclick="closeSettings();">{{__('workflows::workflows.Close') }}</button>
                    <button class="btn btn-success"
                            onclick="saveFields({{ $element->id }}, '{{ $element->family }}');">{{__('workflows::workflows.Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
