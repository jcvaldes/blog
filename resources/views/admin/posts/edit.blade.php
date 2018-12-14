@extends('admin.layout')

@section('header')
    <h1>
        POSTS
        <small>Crear Publicación</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ route('admin.posts.index') }}"><i class="fa fa-list"></i> Posts</a></li>
        <li class="active">Crear</li>
    </ol>
@stop
@section('content')
    <div class="row">
        <form method="POST" action="{{ route('admin.posts.update', $post) }}">
            @csrf
            {{ method_field('PUT') }}
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title">Título de la publicación</label>
                            <input name="title"
                                   type="text"
                                   class="form-control"
                                   value="{{ old('title', $post->title) }}"
                                   placeholder="Ingresa aquí el título de la publicación"/>
                            {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                            <label for="body">Contenido de la publicación</label>
                            <textarea rows="10" name="body" id="editor" class="form-control"
                                      placeholder="Ingresa el contenido de la publicación">
                              {{ old('body', $post->body) }}
                            </textarea>
                            {!! $errors->first('body', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="published_at">Fecha de publicación:</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input name="published_at"
                                       type="text"
                                       value="{{ old('published_at', $post->published_at ? $post->published_at->format('m/d/Y') : null) }}"
                                       class="form-control pull-right"
                                       id="datepicker">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                            <label for="categories">Categorías</label>
                            <select name="category" id="categories" class="form-control">
                                <option value="">Selecciona una categoría</option>
                                @foreach ($categories as $category )
                                    <option value="{{ $category->id }}"
                                        {{  old('category', $post->category_id) == $category->id ? 'selected' : '' }}
                                    >{{ $category->name }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}"
                        ">
                        <label>Etiquetas</label>
                        <select name="tags[]"
                                class="form-control select2"
                                multiple
                                data-placeholder="Selecciona una o más etiquetas"
                                style="width: 100%;">
                            @foreach ($tags as $tag )
                                <option
                                    {{ collect(old('tags', $post->tags->pluck('id')))->contains($tag->id) ? 'selected' : ''  }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('tags', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                        <label for="excerpt">Extracto</label>
                        <textarea name="excerpt" class="form-control"
                                  placeholder="Ingresa un extracto de la publicación">  {{ old('excerpt', $post->excerpt) }}</textarea>
                        {!! $errors->first('excerpt', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <div class="dropzone"></div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Guardar Publicación</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminlte/bower_components/select2/dist/css/select2.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <!-- Select2 -->
    <script src="/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- CK Editor -->
    <script src="/adminlte/bower_components/ckeditor/ckeditor.js"></script>
    <!-- bootstrap datepicker -->ç
    <script src="/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();
        $('#datepicker').datepicker({
            autoclose: true
        });
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor');
        })
        var myDropzone = new Dropzone('.dropzone', {
            url: '/admin/posts/{{ $post->url }}/photos',
            paramName: 'photo',
            //maxFiles: 1,
            acceptedFiles: 'image/*',
            maxFilesize: 2,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dictDefaultMessage: 'Arrastra las fotos aquí para subirlas'
        });
        myDropzone.on('error', function(file, res) {
            var msg = res.errors.photo[0];
            //console.log(res);
            $('.dz-error-message:last > span').text(msg);
        });
        Dropzone.autoDiscover = false;
    </script>
@endpush
