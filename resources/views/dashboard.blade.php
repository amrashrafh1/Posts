<x-app-layout>
    <x-slot name="header">
        Home - {{ now()->format('d-m-Y') }}
    </x-slot>
    <br />
    <br />
    <div class="container-fluid">
        <div class="content-header">
            <div class="mb-3 row">
                <h3 class="mb-0 page-title-head col-md-6">{{ __('Home') }}</h3>
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
                            <section class="hero">
                                <div class="container">
                                    <div class="row">
                                        @foreach ($posts as $indx => $post)
                                        <div class="col-lg-6 offset-lg-3">

                                            <div class="cardbox shadow-lg bg-white">

                                                <div class="cardbox-heading">
                                                    <!-- START dropdown-->
                                                    <!--/ dropdown -->
                                                    <div class="media m-0">
                                                        <div class="d-flex mr-3">
                                                            <a href=""><img class="img-fluid rounded-circle"
                                                                    src="{{ Storage::url($post->user->avatar) }}"
                                                                    alt="User"></a>
                                                        </div>
                                                        <div class="media-body">
                                                            <p class="m-0">{{ $post->user->name }}</p>
                                                            <small><span><i class="icon ion-md-pin"></i>
                                                                    {{$post->user->address}}</span></small>
                                                            <small><span><i class="icon ion-md-time"></i>
                                                                    {{\Carbon\Carbon::parse($post->publish_at)->diffForHumans()}}</span></small>
                                                        </div>
                                                    </div>
                                                    <!--/ media -->
                                                </div>
                                                <!--/ cardbox-heading -->

                                                <div class="cardbox-item">
                                                    <img class="img-fluid" src="{{ Storage::url($post->cover) }}"
                                                        alt="{{ $post->title }}">
                                                </div>
                                                <!--/ cardbox-item -->
                                                <div class="cardbox-base">
                                                    <ul class="float-right">
                                                        <li><a type="button" href="#" data-toggle="modal"
                                                                data-target="#comment{{ $indx }}"><i
                                                                    class="fa fa-comments"></i></a></li>
                                                        <li><a><em class="mr-5">{{ $post->comments->count() }}</em></a>
                                                        </li>
                                                    </ul>
                                                    <ul>
                                                        <li>
                                                            <a class='post_like' data-slug='{{ $post->slug }}'><i class="fa fa-thumbs-up"></i></a>
                                                        </li>
                                                        <li><a ><span class="like_count">{{ $post->likes->count() }} Likes</span></a></li>
                                                    </ul>
                                                </div>
                                                <!--/ cardbox-base -->
                                                <div class="cardbox-comments">
                                                    <span class="comment-avatar float-left">
                                                        <a href=""><img class="rounded-circle"
                                                                src="{{ Storage::url(auth()->user()->avatar) }}"
                                                                alt="..."></a>
                                                    </span>
                                                    <div class="search">
                                                        <form action="{{ route('comment.store', $post->slug) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input placeholder="Write a comment" type="text" name="comment">
                                                            <input type="file" id="myFileInput{{ $indx }}" name="image"
                                                                class="d-none">
                                                            <button type='button'
                                                                onclick="document.getElementById('myFileInput{{ $indx }}').click()"
                                                                style="margin-right: 40px !important;"><i
                                                                    class="fa fa-camera"></i></button>
                                                            <button type="submit"><i
                                                                    class="fa fa-paper-plane"></i></button>
                                                        </form>
                                                    </div>
                                                    <!--/. Search -->
                                                </div>
                                                <!--/ cardbox-like -->

                                            </div>
                                            <!--/ cardbox -->

                                        </div>
                                        @endforeach

                                        <!--/ col-lg-6 -->

                                    </div>
                                    <!--/ row -->
                                </div>
                                <!--/ container -->
                            </section>
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($posts as $index => $post)
    <div class="modal fade" id="comment{{ $index }}" tabindex="-1" role="dialog"
        aria-labelledby="comment{{ $index }}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comment{{ $index }}Label">{{ $post->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('comment.store', $post->slug) }}" method="POST">
                    <div class="modal-body">
                        @foreach($post->comments as $comment)
                        <div class="media">
                            <div class="media-body">
                                <h5 class="mt-0">{{ $comment->comment }}</h5>
                                <p>{{ $comment->user->name }}</p>
                                @if($comment->files?->first())<a target="__blank" href="{{ Storage::url($comment->files?->first()?->path) }}" class="float-right">Media</a>@endif
                                <small><span><i class="icon ion-md-time"></i>
                                        {{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</span></small>
                            </div>
                        </div>
                        @endforeach

                        @csrf
                        <input type="textarea" name="comment" class="form-control" placeholder="Write a comment">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="subimt" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @push('scripts')
    <script>
        // send comment to server
        $(document).ready(function () {
            $('.post_like').click(function () {
                $slug = $(this).data('slug');
                $span = $(this).parent().parent().find('span');
                $.ajax({
                    url: '{{ route('post.like') }}',
                    type: 'POST',
                    data: {
                        slug : $slug,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        $span.text(data.likes_count + ' Likes');

                    }
                });
            });
        });

    </script>
    @endpush
    <style>
        /*
*
* ===========================================================
*     HERO SECTION
* ===========================================================
*
*/
        .hero {
            padding: 6.25rem 0px !important;
            margin: 0px !important;
        }

        .cardbox {
            border-radius: 3px;
            margin-bottom: 20px;
            padding: 0px !important;
        }

        /* ------------------------------- */
        /* Cardbox Heading
---------------------------------- */
        .cardbox .cardbox-heading {
            padding: 16px;
            margin: 0;
        }

        .cardbox .btn-flat.btn-flat-icon {
            border-radius: 50%;
            font-size: 24px;
            height: 32px;
            width: 32px;
            padding: 0;
            overflow: hidden;
            color: #fff !important;
            background: #b5b6b6;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .cardbox .float-right .dropdown-menu {
            position: relative;
            left: 13px !important;
        }

        .cardbox .float-right a:hover {
            background: #f4f4f4 !important;
        }

        .cardbox .float-right a.dropdown-item {
            display: block;
            width: 100%;
            padding: 4px 0px 4px 10px;
            clear: both;
            font-weight: 400;
            font-family: 'Abhaya Libre', serif;
            font-size: 14px !important;
            color: #848484;
            text-align: inherit;
            white-space: nowrap;
            background: 0 0;
            border: 0;
        }

        /* ------------------------------- */
        /* Media Section
---------------------------------- */
        .media {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: start;
            align-items: flex-start;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .media .mr-3 {
            margin-right: 1rem !important;
        }

        .media img {
            width: 48px !important;
            height: 48px !important;
            padding: 2px;
            border: 2px solid #f4f4f4;
        }

        .media-body {
            -ms-flex: 1;
            flex: 1;
            padding: .4rem !important;
        }

        .media-body p {
            font-family: 'Rokkitt', serif;
            font-weight: 500 !important;
            font-size: 14px;
            color: #88898a;
        }

        .media-body small span {
            font-family: 'Rokkitt', serif;
            font-size: 12px;
            color: #aaa;
            margin-right: 10px;
        }


        /* ------------------------------- */
        /* Cardbox Item
---------------------------------- */
        .cardbox .cardbox-item {
            position: relative;
            display: block;
        }

        .cardbox .cardbox-item img {}

        .img-responsive {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .fw {
            width: 100% !important;
            height: auto;
        }


        /* ------------------------------- */
        /* Cardbox Base
---------------------------------- */
        .cardbox-base {
            border-bottom: 2px solid #f4f4f4;
        }

        .cardbox-base ul {
            margin: 10px 0px 10px 15px !important;
            padding: 10px !important;
            font-size: 0px;
            display: inline-block;
        }

        .cardbox-base li {
            list-style: none;
            margin: 0px 0px 0px -8px !important;
            padding: 0px 0px 0px 0px !important;
            display: inline-block;
        }

        .cardbox-base li a {
            margin: 0px !important;
            padding: 0px !important;
        }

        .cardbox-base li a i {
            position: relative;
            top: 4px;
            font-size: 16px;
            color: #8d8d8d;
            margin-right: 15px;
        }

        .cardbox-base li a span {
            font-family: 'Rokkitt', serif;
            font-size: 14px;
            color: #8d8d8d;
            margin-left: 7px;
            position: relative;
            top: 2px;
        }

        .cardbox-base li a em {
            font-family: 'Rokkitt', serif;
            font-size: 14px;
            color: #8d8d8d;
            position: relative;
            top: 3px;
        }

        .cardbox-base li a img {
            width: 25px;
            height: 25px;
            margin: 0px !important;
            border: 2px solid #fff;
        }


        /* ------------------------------- */
        /* Cardbox Comments
---------------------------------- */
        .cardbox-comments {
            padding: 10px 40px 20px 40px !important;
            font-size: 0px;
            text-align: center;
            display: inline-block;
        }

        .cardbox-comments .comment-avatar img {
            margin-top: 1px;
            margin-right: 10px;
            position: relative;
            display: inline-block;
            text-align: center;
            width: 40px;
            height: 40px;
        }

        .cardbox-comments .comment-body {
            overflow: auto;
        }

        .search {
            position: relative;
            right: -60px;
            top: -40px;
            margin-bottom: -40px;
            border: 2px solid #f4f4f4;
            width: 100%;
            overflow: hidden;
        }

        .search input[type="text"] {
            background-color: #fff;
            line-height: 10px;
            padding: 15px 60px 20px 10px;
            border: none;
            border-radius: 4px;
            width: 350px;
            font-family: 'Rokkitt', serif;
            font-size: 14px;
            color: #8d8d8d;
            height: inherit;
            font-weight: 700;
        }

        .search button {
            position: absolute;
            right: 0;
            top: 0px;
            border: none;
            background-color: transparent;
            color: #bbbbbb;
            padding: 15px 25px;
            cursor: pointer;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .search button i {
            font-size: 20px;
            line-height: 30px;
            display: block;
        }


        /* ------------------------------- */
        /* Author
---------------------------------- */
        .author a {
            font-family: 'Rokkitt', serif;
            font-size: 16px;
            color: #00C4CF;
        }

        .author p {
            font-family: 'Rokkitt', serif;
            font-size: 16px;
            color: #8d8d8d;
        }

    </style>
</x-app-layout>
