<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css"> --}}
    

    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}" />
    <meta id="homepage" name="homepage" content="{{ url('/') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
  </head>
  <body>
    <div id="app">
      <div class="container">
        <div class="hero is-small">
          <div class="hero-body">
            <div class="box">
              <form action="{{ url('images') }}" method="post" class="dropzone" id="dropzoneId">
                <input type="hidden" name="_token" :value="csrfToken" />
              </form>
            </div>
          </div>
        </div>

        <div class="hero is-small">
          <div class="hero-body">
            <div class="columns is-multiline is-mobile">
              <div class="column is-12-mobile is-9-desktop">
                <b-taginput
                  v-model="filters"
                  icon="label"
                  placeholder="Search Image Here...">
                </b-taginput>
              </div>
              <div class="column is-12-mobile is-3-desktop">
                <a class="button is-info is-fullwidth" @click="filterImages">Filter</a>
              </div>
              <div class="column is-4-desktop is-12-mobile" v-for="image in images">
                <image-card
                  :key="image.id"
                  :image="image"
                ></image-card>
              </div>
            </div>
          </div>
        </div>
      </div>
      <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
    </div>

    <script type="text/javascript" src="{{ asset(mix('js/app.js')) }}"></script>
    <script type="text/javascript">
      new Vue({
        el: '#app',
        data: {
          csrfToken: window.App.csrfToken,
          images: @json($images),
          isLoading: false,
          filters: []
        },

        mounted: function () {
          this.dropzone = new Dropzone('#dropzoneId', {
            dictDefaultMessage: 'Upload an Image',
            uploadMultiple: false,
            maxFiles: 1
          });

          this.dropzone.on('success', function (file, response) {
            // this.image = response;
            // console.log(response.image);
            this.images.push(response.image);
            this.$toast.open({
                message: 'Image Uploaded Successfully',
                type: 'is-success'
            })
            this.dropzone.removeAllFiles(true);
          });

          this.dropzone.on('error', function (file, errorMessage, xhr) {
            if (xhr.status != 200) {
              if (xhr.status == 413) {
                this.$toast.open({
                    message: 'The file you uploaded is too large, try uploading a smaller file.',
                    type: 'is-danger'
                })
              } else {
                this.$toast.open({
                    message: 'The file you uploaded may be too large.',
                    type: 'is-danger'
                })
              }
            } else {
              this.$toast.open({
                  message: 'Something went wrong!',
                  type: 'is-danger'
              })
            }

            this.dropzone.removeAllFiles(true);
          });
        },
        methods: {
          filterImages: function () {
            if (this.isLoading) {
              return
            }

            this.isLoading = true

            axios.post(url('images/filter'), {
              filters: this.filters
            }).then(function (response) {
              if (response.data.status == 'success') {
                this.isLoading = false
                this.images = response.data.images
              }
            }.bind(this)).catch(function (error) {
                this.isLoading = false
            }.bind(this))
          }
        }
      });
    </script>
  </body>
</html>
