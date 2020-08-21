$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

import Drawflow from './drawflow';
window.Drawflow = Drawflow;
