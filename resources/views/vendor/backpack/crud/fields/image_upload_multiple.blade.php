<style type="text/css">
  .overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    display: none;
  }
</style>
<div class="form-group col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
  <div class="overlay">
    <i class="fa fa-refresh fa-spin"></i>
  </div>
  <input type="file" id="upload-image">
  <div class="thumbs-wrap" id="multi-upload-thumbs">
    <div class="thumb-item">
      <img src="">
    </div>
  </div>
  <script>
    document.getElementById('upload-image')
      .addEventListener('change', function(event) {
    var _this = this,
      files = this.files,
      overlay = this.previousElementSibling,
      form = new FormData(),
      xhr = new XMLHttpRequest();

    overlay.style.display = 'block';
    form.append('_token', '{{ csrf_token() }}');
    form.append('image', this.files[0]);

    xhr.onload = function() {
      overlay.style.display = 'none';
    };
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        var url = JSON.parse(xhr.responseText).url,
          thumb = document.getElementById('multi-upload-thumbs').childNodes[1];
        thumb.childNodes[1].src = url;
        // _this.files = [];
        form.reset();
      }
    }
    xhr.open('post', '/admin/upload', true);
    xhr.send(form);

  }, false);
  </script>
  <input v-model="imagesJson" type="hidden" name="images" value="{{ $field['value'] }}">
</div>
