(function($){
    "use strict";
    $(document).ready(function(){

      $(document).on('change','#profile_image', function(){
        readURL(this);
      })

      reader.readAsDataURL(input.files[0]);

      function readURL(input){
        if(input.files && input.files[0]){
          var reader = new FileReader();
          var res = isImage(input.files[0].name);

          if(res==false){
            var msg = 'Image should be png/PNG, jpg/JPG & jpeg/JPG';
            Snackbar.show({text: msg, pos: 'bottom-right',backgroundColor:'#d32f2f', actionTextColor:'#fff' });
            return false;
          }

          reader.onload = function(e){
            $('.profile_image_preview').attr('src', e.target.result);
            $("imagelabel").text((input.files[0].name));
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      function getExtension(filename) {
          var parts = filename.split('.');
          return parts[parts.length - 1];
      }

      function isImage(filename) {
          var ext = getExtension(filename);
          switch (ext.toLowerCase()) {
          case 'jpg':
          case 'jpeg':
          case 'png':
          case 'gif':
              return true;
          }
          return false;
      }

    });

 })(jQuery);