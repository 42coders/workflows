<div id="settings-overlay" class="settings-overlay">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 20px;">
                <div class="settings-headline">
                    <h1>{!! $element::$icon !!} {{__('workflows::workflows.Elements.'.$element->name) }} {{__('workflows::workflows.Settings') }}</h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="settings-body">

                </div>
            </div>
            <div class="col-md-12">
                <div class="settings-footer text-right">
                    <button class="btn btn-default"
                            onclick="closeConditions();">{{__('workflows::workflows.Close') }}</button>
                    <button class="btn btn-success"
                            onclick="saveFields({{ $element->id }}, '{{ $element->family }}');">{{__('workflows::workflows.Save') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
