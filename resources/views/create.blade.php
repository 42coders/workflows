@extends(config('workflows.layout'))

@section(config('workflows.section'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ __('workflows::workflows.Create a new Workflow')}}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
               <form action="{{config('workflows.prefix')}}/workflows/store" method="POST">
                   @csrf
                   <div class="col-md-12">
                   <div class="form-group">
                       <input type="text" class="form-control" id="name" name="name" aria-describedby="Name" placeholder="Name">
                   </div>
                   </div>
                   <div class="col-md-12 text-right">
                   <a href="{{config('workflows.prefix')}}/workflows" class="btn btn-warning">{{ __('workflows::workflows.Cancel')}}</a>
                   <button type="submit" class="btn btn-success">{{ __('workflows::workflows.Save')}}</button>
                   </div>
               </form>
            </div>
        </div>
    </div>
@endsection
