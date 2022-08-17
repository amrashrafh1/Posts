<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group mb-3">
            {{ Form::label('title') }}
            {{ Form::text('title', old('title', $post->title) , ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'title']) }}
            {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('description') }}
            {{ Form::textarea('description', old('description', $post->description) , ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'description']) }}
            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        @if($post->cover)
            <div class="form-group mb-3">
                <img src="{{ asset($post->cover) }}" alt="{{ $post->title }}" class="img-fluid">
            </div>
        @endif
        <div class="mb-3 position-relative form-group">
            {{ Form::label('cover') }}
            {{ Form::file('cover',  ['class' => 'form-control' . ($errors->has('cover') ? ' is-invalid' : ''), 'placeholder' => 'cover']) }}
            {!! $errors->first('cover', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('publish_at') }}
            <input type="datetime-local" name="publish_at" class="form-control" value="{{ old('publish_at', \Carbon\Carbon::parse($post->publish_at)->format('Y-m-d\TH:i')) }}"/>
            {!! $errors->first('publish_at', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('status') }}
            {{ Form::select('status', [0 => 'Hide', 1 => 'Show'], old('status', $post->status) , ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder' => 'Status']) }}
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="mb-3 position-relative form-group">
            {{ Form::label('files') }}
            {{ Form::file('files[]',  ['multiple' => 'multiple','class' => 'form-control' . ($errors->has('files') ? ' is-invalid' : ''), 'placeholder' => 'files']) }}
            {!! $errors->first('files', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="box-footer mt20">
                <button type="submit" class="btn btn-primary @if(request()->routeIs('posts.create')) submit-btn"> Add @else ">Update @endif</button>

    </div>
</div>
