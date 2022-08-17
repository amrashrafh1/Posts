<x-app-layout>
    <x-slot name="header">
        Posts - {{ now()->format('d-m-Y') }}
    </x-slot>
    <br/>
    <br/>
    <div class="container-fluid">
        <div class="content-header">
            <div class="mb-3 row">
                <h3 class="mb-0 page-title-head col-md-6">{{ __('Posts') }}</h3>
                <div class="col-md-6 text-right">
                    <a href="{{ route('posts.create') }}" class="btn btn-primary"  data-placement="left">
                      {{ __('Add New Post') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="example1">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
										<th>Title</th>
										<th>Cover</th>
										<th>Slug</th>
										<th>Created at</th>

                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $post->title }}</td>
											<td><img src="{{ Storage::url($post->cover) }}" width="200" height="200"/></td>
											<td><a href="{{ route('news.show', $post->slug) }}" >{{ $post->slug }}</a></td>
                                            <td>{{ Carbon\Carbon::parse($post->created_at)->toDateTimeString() }}</td>
                                            <td nowrap>
                                                <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('posts.show',$post->id) }}"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('posts.edit',$post->id) }}"><i class="fa fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
