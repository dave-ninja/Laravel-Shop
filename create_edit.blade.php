@extends('layouts.admin.app')

@section('title', 'Pages')

@section('css')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/all.css') }}">
@endsection


@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-user"></i> {{ isset($page) ? 'Edit' : 'Add' }} Content
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ url('admin/pages') }}"><i class="fa fa-files-o"></i> Content</a></li>
            <li class="active"><i
                        class="fa {{ isset($page) ? 'fa-pencil' : 'fa-plus' }}"></i> {{ isset($user) ? 'Edit' : 'Add' }}
                Content
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Content Details Form</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                                class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form action="{{ isset($page) ? URL::to('admin/pages/'.$page->id.'/update' ) :  URL::to('admin/pages') }}" method="{{ isset($page) ? 'get' : 'post' }}" class="form-horizontal" id="validate">
                    @csrf
                    <input type="hidden" name="page_id" value="{{ isset($page) ? $page->id: null }}">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title" class="control-label col-md-2">Title *</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
                                <input class="form-control validate[required]" value="{{ isset($page) ? $page->title: null }}" placeholder="Title" name="title" type="text" id="title">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="control-label col-md-2">Slug *</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                <input class="form-control validate[required]" value="{{ isset($page) ? $page->slug: null }}" placeholder="Slug" name="slug" type="text" id="slug">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="meta_keywords" class="control-label col-md-2">Meta Keywords</label>
                        <div class="col-md-10">
                            <textarea class="form-control" rows="3" name="meta_keywords" cols="50" id="meta_keywords">
                                {{ isset($page) ? $page->meta_keywords: null }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="meta_desc" class="control-label col-md-2">Meta Description</label>
                        <div class="col-md-10">
                            <textarea class="form-control" rows="3" name="meta_desc" cols="50" id="meta_desc">
                                {{ isset($page) ? $page->meta_desc: null }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="control-label col-md-2">Content</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="editor" name="content" cols="50" rows="10" style="visibility: hidden; display: none;">
                                {{ isset($page) ? $page->content: null }}
                            </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="icon" class="control-label col-md-2">Icon</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                <input class="form-control" value="{{ isset($page) ? $page->icon: null }}" placeholder="Icon" name="icon" type="text" id="icon">
                            </div>
                            <p class="text-muted">font awesome icon eg: fa fa-automobile</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="published" class="control-label col-md-2">Published</label>
                        <div class="col-sm-10">
                            <label for="published" class="check">
                                <input class="minimal" name="published" @if( isset($page) && $page->published == 1 ) checked @endif type="checkbox" value="1" id="published">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="blog_post" class="control-label col-md-2 hover">Blog Post</label>
                        <div class="col-sm-10">
                            <label for="blog_post" class="check">
                                <input class="minimal" name="blog_post" @if( isset($page) && $page->blog_post == 1 ) checked @endif type="checkbox" value="1" id="blog_post">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-2">
                            <input class="btn btn-primary" type="submit" value="{{ (isset($page) ? 'Update': 'Add') }} Content">
                        </div>
                    </div>
                </div><!-- .col-md-12 -->
                </form>
            </div><!-- /.box-body -->
            <div class="box-footer">
            </div><!-- /.box-footer-->
        </div><!-- /.box -->
    </section><!-- /.content -->
@endsection


@section('js')
    <!-- iCheck 1.0.1 -->
    <script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/validationengine/languages/jquery.validationEngine-en.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/validationengine/jquery.validationEngine.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('input[type="checkbox"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue'
            });

            CKEDITOR.replace('editor');

            // Validation Engine init
            var prefix = 's2id_';

            $("form[id^='validate']").validationEngine('attach',
                {
                    promptPosition: "bottomRight", scroll: false,
                    prettySelect: true,
                    usePrefix: prefix
                });
        });
    </script>
@endsection
