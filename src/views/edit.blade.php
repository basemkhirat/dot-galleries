@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-camera"></i>
                    {{ trans("galleries::galleries.edit") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.galleries.show") }}">{{ trans("galleries::galleries.galleries") }}</a>
                    </li>
                    <li class="active">
                        <strong>{{ trans("galleries::galleries.edit") }}</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route("admin.galleries.create") }}"
                   class="btn btn-primary btn-labeled btn-main"> <span
                        class="btn-label icon fa fa-plus"></span>
                    {{ trans("galleries::galleries.add_new") }}
                </a>

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("galleries::galleries.save_gallery") }}
                </button>
            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">

                        <div class="panel-body">

                            <div class="form-group" style="position: relative;">

                                <input name="name" value="{{ @Request::old("name", $gallery->name) }}"
                                       class="form-control input-md" value=""
                                       placeholder="{{ trans("galleries::galleries.name") }}"/>


                                <button type="button" class="add-media btn-primary btn btn-flat" id="add_media">
                                    <i class="fa fa-camera"></i>
                                    {{ trans("galleries::galleries.add_media") }}
                                </button>

                            </div>

                            <div class="input-group input-group-md">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>

                                <input name="author" class="form-control "
                                       value="{{ @Request::old("author", $gallery->author) }}"
                                       placeholder="{{ trans("galleries::galleries.author") }}"/>
                            </div>
                            <br/>
                            <div class="panel">
                                <div id="collapse-media" class="panel-collapse in">
                                    <div class="panel-body">
                                        <div class="media_rows">
                                            @if ($gallery)
                                                @if (count($gallery_media))
                                                    @foreach ($gallery_media as $media)

                                                        <div class="file-box">
                                                            <input type="hidden" name="media_id[]"
                                                                   value="{{ $media->id }}"/>
                                                            <div class="file">
                                                                <a href="#">
                                                                    <span class="corner"></span>
                                                                    <a href="#" class="media_del"><i
                                                                            class="fa fa-times"></i></a>
                                                                    @if ($media->type == "image")
                                                                        <div class="image">
                                                                            <img
                                                                                src="{{ thumbnail($media->path, "small") }}"
                                                                                class="img-responsive" alt="image">
                                                                        </div>
                                                                    @elseif ($media->type == "audio")
                                                                        <div class="icon"><i class="fa fa-music"></i>
                                                                        </div>
                                                                    @elseif ($media->type == "video")
                                                                        <div class="icon"><i
                                                                                class="img-responsive fa fa-film"></i>
                                                                        </div>
                                                                    @else
                                                                        <div class="icon"><i class="fa fa-file"></i>
                                                                        </div>
                                                                    @endif

                                                                    <div class="file-name">
                                                                        {{ $media->title }}
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    @endforeach
                                                    <div
                                                        class="well text-center empty-content hidden">{{ trans("galleries::galleries.no_media") }}</div>
                                                @else
                                                    <div
                                                        class="well text-center empty-content">{{ trans("galleries::galleries.no_media") }}</div>
                                                @endif
                                            @else
                                                <div
                                                    class="well text-center empty-content">{{ trans("galleries::galleries.no_media") }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>


        </div>

    </form>

@stop

@section("head")
    <style>

        .file-box .file {
            overflow: hidden;
        }

        #add_media {
            font-size: 14px
        }

    </style>
@stop

@section("footer")
    <script>
        $(document).ready(function () {
            $("#add_media").filemanager({

                done: function (files) {
                    if (files.length) {
                        $(".empty-content").addClass("hidden");
                        files.forEach(function (file) {

                            if (file.media_provider == "") {
                                var thumbnail = file.thumbnail;
                            } else {
                                var thumbnail = file.provider_image;
                            }

                            console.log(file);

                            var html = '<div class="file-box"><input type="hidden" name="media_id[]" value="' + file.id + '" /><div class="file"><a href="#"><span class="corner"></span><a href="#" class="media_del"><i class="fa fa-times"></i></a>';

                            if (file.type == "image") {
                                html = html + '<div class="image"><img src="' + file.url + '" class="img-responsive" alt="image"></div>';

                            } else if (file.type == "audio") {
                                html = html + '<div class="icon"><i class="fa fa-music"></i></div>';
                            } else if (file.type == "video") {
                                html = html + '<div class="icon"><i class="img-responsive fa fa-film"></i></div>';
                            } else {
                                html = html + '<div class="icon"><i class="fa fa-file"></i></div>';
                            }

                            html = html + '<div class="file-name">' + file.title + '</div>';
                            html = html + ' </a></div></div>';

                            $(".media_rows").append(html);

                            $('.file-box').each(function () {
                                animationHover(this, 'pulse');
                            });


                        });
                    }

                },
                error: function (media_path) {
                    alert(media_path + "{{ trans("galleries::galleries.is_not_valid_image") }}");
                }
            });


            $("body").on("click", ".media_del", function () {
                var base = $(this);
                if (confirm("{{ trans("galleries::galleries.sure_delete") }}")) {
                    base.parents(".file-box").slideUp(function () {
                        base.parents(".file-box").remove();

                        if ($(".media_rows .file-box").length == 0) {
                            $(".empty-content").removeClass("hidden");
                        }

                    });
                }

            });

            $('.file-box').each(function () {
                animationHover(this, 'pulse');
            });

        });
    </script>
@stop
