@extends(config('workflows.layout'))

@section(config('workflows.section'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Workflows</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="/workflow/create" class="btn btn-default">{{__('workflows.create')}}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>{{ __('workflows.Name')}}</th>
                        <th>{{ __('workflows.Tasks')}}</th>
                        <th>{{ __('workflows.Created at')}}</th>
                        <th></th>
                    </tr>
                    @foreach($workflows as $workflow)
                        <tr>
                            <td>{{ $workflow->name }}</td>
                            <td>{{ $workflow->tasks->count() }}</td>
                            <td>{{ $workflow->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="/workflow/{{$workflow->id}}"><i class="fas fa-eye">{{ __('workflows.show')}}</i></a>
                                <a href="/workflow/{{$workflow->id}}/edit"><i class="fas fa-eye">{{ __('workflows.edit')}}</i></a>
                                <a href="/workflow/{{$workflow->id}}/delete"><i class="fas fa-trash-alt">{{ __('workflows.delete')}}</i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $workflows->links() }}
            </div>
        </div>
    </div>
@endsection
