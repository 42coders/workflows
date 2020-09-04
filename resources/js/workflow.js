

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

import queryBuilder from 'jQuery-QueryBuilder/dist/js/query-builder.standalone';
window.queryBuilder = queryBuilder;

import Drawflow from './drawflow';
window.Drawflow = Drawflow;
