<x-app-layout>
    <x-slot name="header">
        Show Post
    </x-slot>
    <section class="content container-fluid">
    <div class="content-header">
            <div class="container-fluid ml-auto">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            
                            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Post</a></li>
                            <li class="breadcrumb-item active">Show Post</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Post</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Title:</strong>
                            {{ $post->title }}
                        </div>
                        <div class="form-group">
                            <strong>Body:</strong>
                            {{ $post->description }}
                        </div>
                        <div class="form-group">
                            <strong>Cover:</strong>
                            <img src="{{ Storage::url($post->cover) }}" width="200" height="200"/>
                        </div>
                        <div class="form-group">
                            <strong>Slug:</strong>
                            {{ $post->slug }}
                        </div>
                        <div class="form-group">
                            <strong>Created at:</strong>
                            {{ Carbon\Carbon::parse($post->created_at)->toDateTimeString() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
