@extends('frontend.master_video')

@section('breadcrumbs')
          <div class="wrapper">
            <div class="header-breadcrumbs">
              <h2 class="right">{{$vid->title}}</h2>
              <ul>
                <li><a href="#home">Media</a></li>
                <li>Videos</li>
              </ul>
            </div>
          </div>
@endsection


@section('video')

<video id="example_video_1"  controls preload="false" width="100%" height="auto"  >
    <source src="{{url($vid->media_url)}}" type="video/mp4" />
</video>

@endsection

@section('main')
<section >
      @section('title'){{$vid->title}}@endsection
      @section('description'){!! substr(strip_tags($vid->description), 0, 250) !!}...@endsection
      @section('keywords'){{$vid->tags}}@endsection
      @section('image')@if($vid->featured_image){{$vid->featured_image}}@endif @endsection
        <!-- BEGIN .wrapper -->
        <div class="wrapper">
          
          <!-- BEGIN .with-sidebar-layout -->
          <div class="with-sidebar-layout left">


            <div class="content-panel">
              <div class="panel-block">
                
                <div class="panel-content">
                <?php 
                $anterior = $vid->id - 1;
                $siguiente = $vid->id + 1;
                ?>
                <h3><a href="{{route('video.view.one', $anterior)}}">Anterior</a>   -   <a href="{{route('video.view.one', $siguiente)}}">Siguiente</a></h3>
                  <div class="video-author">
                    <img src="images/photos/image-1.jpg" class="left" alt="" />
                    <div class="col-md-3 author-content">
                      <span>Agregado por <a href="#">{{$vid->user->name}}</a></span>
                      <span>{{$vid->created_at}}</span>
                    </div>
                    <div class="clear-float"></div>
                  </div>
                  <p>{!!$vid->description!!}</p>
                  <button onclick="capture()">Capture</button> <br/><br/>
                  <canvas id="canvas"></canvas>

                  <div class="video-footer">
                    <strong>Categorias:</strong>
                    @foreach($vid->categories()->get() as $category)
                      {{$category->name}}, 
                    @endforeach
                    <p><strong>Tags:</strong> {{$vid->tags}} </p>
                    </p>
                  </div>
                </div>

              </div>
            </div>

            
            

            <div class="content-panel">
              
              <div class="panel-block">
                <div class="short-tabs">
                  <ul>
                    <li><a href="#">Comentarios de Neuronas</a></li>
                    <li><a href="#face">Comentarios de Facebook ({{$vid->comments()->count()}})</a></li>
                    
                  </ul>
                  <div>
                    @include('comments::display', ['video_id' => $vid->id])
                  </div>
                  <div>
                    <div class="fb-comments" data-href="http://cerebrodigital.net/video/{{$vid->id}}" data-numposts="3"></div>
                    @if($vid->comments()->count() > 0)
                    <div class="panel-title">
                      <h2>{{$vid->comments()->count()}} Comentarios respaldados de Facebook</h2>
                    </div>
                    
                    @include('frontend.widgets.video.comments', ['comments' => $vid->comments()->paginate(25)])
                    

                    @endif  
                  </div>
                </div>
                
                <!-- BEGIN #comments -->
                 
                
                    
                

              </div>
              @include('frontend.widgets.video.similar')

              @include('frontend.widgets.video.latest')


          <!-- END .with-sidebar-layout -->
          </div>

          <!-- BEGIN #sidebar -->
          <aside id="sidebar" class="right">

            <!-- BEGIN .widget -->
            <div class="widget">
              <h3>Estadisticas del video</h3>
              <div class="video-stats">
                <div class="video-stat-blobs">
                  <span>
                    <strong>{{$vid->views}}</strong>
                    <i>views</i>
                  </span>
                  <span>
                    <strong>{{$vid->comments()->count()}}</strong>
                    <i>comments</i>
                  </span>
                  <span>
                    <strong>{{$vid->likes}}</strong>
                    <i>likes</i>
                  </span>
                </div>
                <div class="hr-spacer"></div>
                <h5>Acerca de uploader</h5>
                <p>Eos alii duis comprehensam ea. Ad vix sumo tim eam petentium, soluta corpora mnesarchum ex nemore everti dolorem at, eu mazim.</p>
              </div>
            <!-- END .widget -->
            </div>

            <!-- BEGIN .widget -->
            <div class="widget">
              <div class="banner-widget no-border">
                <a href="#" target="_blank"><img src="images/no-banner-300x250.jpg" width="300" height="250" alt="" /></a>
                <a href="contact-us.html" class="banner-meta"><i class="fa fa-angle-double-up"></i> Contact us about advert spaces <i class="fa fa-angle-double-up"></i></a>
              </div>
            <!-- END .widget -->
            </div>

            @include('frontend.widgets.featured_videos')

            @include('frontend.widgets.popular_videos')


          <!-- END #sidebar -->
          </aside>
          
        <!-- END .wrapper -->
        </div>
        
      <!-- BEGIN .content -->
      </section>

@endsection  
@section('bottomscripts')
    <link rel="stylesheet" href="/vendor/comments/css/bootstrapless.css">
    <link rel="stylesheet" href="/vendor/comments/css/prism-okaidia.css"> <!-- Optional -->
    <link rel="stylesheet" href="/vendor/comments/css/comments.css">
    <script src="//cdn.jsdelivr.net/vue/1.0.16/vue.min.js"></script>

    <!-- Must be included before the closing </body> tag! -->
    <script src="/vendor/comments/js/utils.js"></script> 
    <script src="/vendor/comments/js/comments.js"></script>
      
    <script>
      new Vue({el: '#comments'});
      window.onload = function() {
        var video = document.getElementById('example_video_1');
        var thecanvas = document.getElementById('thecanvas');
        var img = document.getElementById('thumbnail_img');
        var video = videojs(document.getElementById('example_video_1'));
          video.on("load", function(){
            video.bigPlayButton.show();
          });

        document.querySelector('#example_video_1').bigPlay()
      }
      function capture(){
          var canvas = document.getElementById('canvas');
          var video = document.getElementById('example_video_1');
          canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
      }
    </script>


  <style>
  li.comment.fade-transition {
      padding-right: 22px;
  }

  div.comment-content.clearfix {
      margin-left: -100px;
      width: 100%;
  }
  div.comment-text {
    margin-top: -50px;
}
video.video-js.vjs-default-skin.vjs-big-play-centered {
    margin-top: -35px;
}
div.footer {
    background-color: #292929;
}

div.item-content h4 a {
    color: #ffffff;
}

div.panel-content div h4 {
    color: #ffffff;
}



  </style>
@endsection     