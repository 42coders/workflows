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
                <a href="{{config('workflows.prefix')}}/workflows/create" class="btn btn-default">{{__('workflows::workflows.create')}}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>{{ __('workflows::workflows.Name')}}</th>
                        <th>{{ __('workflows::workflows.Tasks')}}</th>
                        <th>{{ __('workflows::workflows.Created at')}}</th>
                        <th></th>
                    </tr>
                    @foreach($workflows as $workflow)
                        <tr>
                            <td>{{ $workflow->name }}</td>
                            <td>{{ $workflow->tasks->count() }}</td>
                            <td>{{ $workflow->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{config('workflows.prefix')}}/workflows/{{$workflow->id}}"><i class="fas fa-eye"></i></a> -
                                <a href="{{config('workflows.prefix')}}/workflows/{{$workflow->id}}/edit"><i class="fas fa-edit"></i></a> -
                                <a href="{{config('workflows.prefix')}}/workflows/{{$workflow->id}}/delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $workflows->links() }}
            </div>
        </div>
    </div>
@endsection
