<div>
    <div class="title-box">{!! $icon !!} {{ __('workflows::workflows.Elements.'.$elementName) }}</div>
    <div class="box">

    </div>
    <div class="footer-box" style="text-align: right; padding: 5px;">
        <i class="fas fa-cog settings-button" onclick="loadSettings('{{ $type }}', {{ isset($element) ? $element->id : 0 }}, this);"></i>
    </div>
</div>
