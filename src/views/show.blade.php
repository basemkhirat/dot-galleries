@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-camera"></i>
                {{ trans("galleries::galleries.galleries") }}
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                </li>
                <li>
                    <a href="{{ route("admin.galleries.show") }}">{{ trans("galleries::galleries.galleries") }}
                        ({{ $galleries->total() }})</a>
                </li>
            </ol>
        </div>

        <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 text-right">
            <form action="" method="get" class="search_form">
                <div class="input-group">
                    <input name="q" value="{{ Request::get("q") }}" type="text" class=" form-control"
                           placeholder="{{ trans("galleries::galleries.search_galleries") }} ..."> <span
                        class="input-group-btn">
                    <button class="btn btn-primary"
                            type="button"> <i class="fa fa-search"></i> </button> </span>
                </div>
            </form>
        </div>

        <div class="col-lg-2 pull-right">
            <a href="{{ route("admin.galleries.create") }}" class="btn btn-primary btn-labeled btn-main"> <span
                    class="btn-label icon fa fa-plus"></span> {{ trans("galleries::galleries.add_new") }}
            </a>
        </div>
    </div>

    <div class="wrapper wrapper-content fadeInRight">

        @include("admin::partials.messages")

        <div class="row">

            <div class="col-md-12">

                <form action="" method="post" class="action_form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <div class="ibox float-e-margins">
                        <div class="ibox-content">

                            @if (count($galleries))

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">

                                        <select name="action" class="form-control pull-left">
                                            <option value="-1"
                                                    selected="selected">{{ trans("galleries::galleries.bulk_actions") }}</option>
                                            <option
                                                value="delete">{{ trans("galleries::galleries.delete") }}</option>
                                        </select>
                                        <button type="submit"
                                                class="btn btn-primary pull-right">{{ trans("galleries::galleries.apply") }}</button>

                                    </div>
                                    <div class="col-lg-6 col-md-4 hidden-sm hidden-xs">

                                    </div>

                                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">

                                        <select class="form-control per_page_filter">
                                            <option value="" selected="selected">
                                                -- {{ trans("galleries::galleries.per_page") }} --
                                            </option>
                                            @foreach (array(10, 20, 30, 40) as $num)
                                                <option
                                                    value="{{ $num }}"
                                                    @if ($num == $per_page) selected="selected" @endif>{{ $num }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="table-responsive">

                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped"
                                           id="jq-datatables-example">
                                        <thead>
                                        <tr>
                                            <th style="width:35px"><input type="checkbox" class="check_all i-checks"
                                                                          name="ids[]"/></th>
                                            <th>{{ trans("galleries::galleries.name") }}</th>
                                            <th>{{ trans("galleries::galleries.media_count") }}</th>
                                            <th>{{ trans("galleries::galleries.actions") }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($galleries as $gallery)
                                            <tr>
                                                <td>
                                                    <input class="i-checks" type="checkbox" name="id[]"
                                                           value="{{ $gallery->id }}"/>
                                                </td>
                                                <td>
                                                    <a class="text-navy"
                                                       href="{{ route("admin.galleries.edit", ["id" => $gallery->id]) }}">
                                                        <strong>{{ $gallery->name }}</strong>
                                                    </a>
                                                </td>
                                                <td>
                                                    <small>{{ $gallery->files()->count() }}</small>
                                                </td>
                                                <td class="center">
                                                    <a href="{{ route("admin.galleries.edit", ["id" => $gallery->id]) }}">
                                                        <i class="fa fa-pencil text-navy"></i>
                                                    </a>
                                                    <a class="ask"
                                                       message="{{ trans("galleries::galleries.sure_delete") }}"
                                                       href="{{ route("admin.galleries.delete", ["id" => $gallery->id]) }}">
                                                        <i class="fa fa-times text-navy"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>


                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        {{ trans("galleries::galleries.page") }}
                                        {{ $galleries->currentPage() }}
                                        {{ trans("galleries::galleries.of") }}
                                        {{ $galleries->lastPage() }}
                                    </div>
                                    <div class="col-lg-12 text-center">
                                        {{ $galleries->appends(Request::all())->render() }}
                                    </div>
                                </div>

                            @else
                                {{ trans("galleries::galleries.no_galleries") }}
                            @endif

                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>

    </div>


@stop


@section("footer")

    <script>
        $(document).ready(function () {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $('.check_all').on('ifChecked', function (event) {
                $("input[type=checkbox]").each(function () {
                    $(this).iCheck('check');
                    $(this).change();
                });
            });

            $('.check_all').on('ifUnchecked', function (event) {
                $("input[type=checkbox]").each(function () {
                    $(this).iCheck('uncheck');
                    $(this).change();
                });
            });

            $(".per_page_filter").change(function () {
                var base = $(this);
                var per_page = base.val();
                location.href = "{{ route("admin.galleries.show") }}?per_page=" + per_page;
            });

            $('.file-box').each(function () {
                animationHover(this, 'pulse');
            });

        });


    </script>

@stop
