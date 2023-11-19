<div class="form-group">
    <label for="title">{{__("Title")}}: </label>
    <input id="title" class="form-control" type="text" name="title"
           value="{{old('title', optional($post ?? null)->title)}}">
</div>
{{--@error('title')--}}
{{--<div class="alert alert-danger">{{$message}}</div>--}}
{{--@enderror--}}
<div class="form-group">
    <label for="content"><br>{{__("Content")}}: </label>
    <textarea class="form-control" id="content"
              name="content">{{old('content', optional($post ?? null)->content)}}</textarea>
</div>
<div class="form-group">
    <label for="title">{{__("Thumbnail")}}: </label>
    <input id="title" class="form-control-file" name="thumbnail" type="file">
</div>
@component('components.errors')
@endcomponent

