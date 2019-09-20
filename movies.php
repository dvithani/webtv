<?php

include 'includes/header.php';
/*if ('Active' !== $checkLicense['status']) {
    echo "<script>window.location.href = 'oops.php';</script>";
    exit();
}*/

$FinalCategoriesArray = [];
$GetCateGories = webtvpanel_CallApiRequest($hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_vod_categories');
if (!empty($GetCateGories)) {
    $FinalCategoriesArray = $GetCateGories;
}

include 'includes/sideNav.php';
?>
<p class="SerchResult hideOnLoad">
    Search Result of <span id="searchOf">American</span>
    <span class="clearSearch">Clear Search</span>
</p>
<h1 id="NoResultFound" class="hideOnLoad">No Result Found!!</h1>

<div id="posts">

    <center id="fullLoader"><img src="images/roundloader.gif"  alt="tv image"> 
      <p class="text-center">LOADING DATA</p></center>
    <ul class="free-wall grid effect-3 videoSection hideOnLoad" id="MoviesContainer">
      
    </ul>
  </div>
<!--- Body Content End---> 
<!-- MODAL CODE -->

<div class="modal fade movie-popup" id="menuModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom">
    <div class="modal-content">
      <div class="modal-header" style="border:0;"> <span class="p-close" data-dismiss="modal" aria-hidden="true">x</span> </div>
      <div class="modal-body">
        <div class="popup-content">
          <div class="col-sm-5 col-lg-3 col-md-4 col-xs-7">
            <div class="poster">
              <div class="poster-img"><img src="img/poster.jpg" alt="" class="img-responsive"></div>
              <div class="ratting-bar row">
                <p class="pull-left">Overall rate:</p>
                <div class="stars pull-right"> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star-o"></span> </div>
              </div>
            </div>
          </div>
          <div class="col-sm-7 col-lg-9 col-md-8 col-xs-12">
            <div class="poster-details">
              <h2>SAN ANDREAS</h2>
              <ul>
                <li class="i-year">2016</li>
                <li class="i-duration">114 min</li>
                <li class="i-movie">Action</li>
                <li class="i-trailer"><a href="#">Watch trailer</a></li>
              </ul>
              <p>In the aftermath of a massive earthquake in California, a rescue-chopper pilot <br>
                makes a dangerous journey across the state in order to rescue his estranged <br>
                daughter.</p>
              <div class="fav row">
                <div class="res-list">
                  <select>
                    <option>480p</option>
                    <option selected>720p</option>
                    <option>1080p</option>
                  </select>
                </div>
                <button class="gd">3D</button>
                <button class="add-fav"></button>
              </div>
              <div class="watch-now row">
                <button class="rippler rippler-default">watch it now</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
</div>
  <?php

echo"
  <!-- /.modal-dialog --> 
<script src='https://content.jwplatform.com/libraries/fgbTqCCh.js'></script>
<!-- <script src='js/ajPlayer.js'></script> -->
<script src='js/flowplayer/flowplayer.js'></script>

<script src='js/mediaPlayers.js'></script>
<link rel=\"stylesheet\" href=\"js/flowplayer/skin/skin.css\" media=\"screen\">
  <script type=\"text/javascript\">

    \$(document).ready(function(){
      if(\$(document).find('.onloadCallCategory').length != 0)
      {
        var omLoadCategoryID = \$(document).find('.onloadCallCategory').data('categoryid');
        var parentControlData = \$(document).find('.onloadCallCategory').data('pcon');
        if(parentControlData == 1)
        {
            getData(omLoadCategoryID);
        }
        else
        {
          getData(omLoadCategoryID);
        }
        
        \$(document).find(\".rippler\").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  0      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });
      }
      \$( document ).on(\"click\", \".Playclick\", function(){
        var StreamId = \$(this).find('.streamId').val();
        var StreamType = \$(this).find('.streamId').data('streamtype');
        \$('.Playclick').removeClass('playingChanel');
        \$(this).addClass('playingChanel');
        getVideoLinkAjax(StreamId,StreamType);  
        
      });   

      \$('#SearchData').keypress(function (e) {
          var key = e.which;
          if(key == 13)  // the enter key code
          {
            callSearchFun(); 
          }
      });

       \$( document ).on(\"click\", \"#SearchBtn\", function(){
            callSearchFun();   
        });
        \$( document ).on(\"click\", \".clearSearch\", function(){
            removeSearchSec();
        });


        \$( document ).on(\"click\", \".LoadMoreBtn\", function(){
            \$('.LoadingMoreFa').removeClass('hideOnload');
            var categoryid =\$(this).data('categoryid'); 
            var dataoffset =\$(this).data('dataoffset');
            datalimit = Number(28)+Number(dataoffset);
            dataoffset = Number(dataoffset)+Number(1); 
            jQuery.ajax({
              type:\"POST\",
              url:\"includes/ajax-control.php\",
              dataType:\"text\",
              data:{
              action:'getMoviesDataFromCategoryId',
              categoryID:categoryid,
              dataoffset:dataoffset,
              datalimit:datalimit,
              hostURL: \"";
echo $XCStreamHostUrl.$bar;
echo "\"
              },  
                success:function(response2){ 
                  \$('.LoadingMoreFa').addClass('hideOnload');
                  \$('.LoadMoreBtn').remove();
                  var MoviesContainer = \$('#MoviesContainer');
                  MoviesContainer.append(response2);
                  setformatOfListsByClass('.thumb-b');
                   \$('html, body').animate({
                      scrollTop: Number(\$('.un-'+dataoffset).offset().top)-Number(140)
                    }, 1500);
                   \$(document).find(\".rippler\").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  0      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });
                }
              });   
          });   

  });

  function callSearchFun()
  {
      \$('.LoadMoreBtn').addClass('hideOnLoad');
      var SearchData = \$(\"#SearchData\").val();   
       \$('.visible-sec').removeClass('visible-sec');
       \$('.SerchResult').addClass('hideOnLoad');
       \$('#NoResultFound').addClass('hideOnLoad');
       if(SearchData != \"\")
       {
          \$('.streamList').addClass('hideOnLoad');
          var moive_namesearch = \$('.serch_key');
          filter = SearchData.toUpperCase();
          CustomIndex = 0;
          moive_namesearch.each(function( index ) {
            if (\$( this ).val().toUpperCase().indexOf(filter) > -1) {
              \$(\".\"+\$(this).data('parentliclass')).removeClass('hideOnLoad');
              \$(\".\"+\$(this).data('parentliclass')).addClass('visible-sec');
              CustomIndex = 1;
            }
          });  
          if(CustomIndex == 0)
          {
              \$('#NoResultFound').removeClass('hideOnLoad');
          }
          \$('#search').removeClass('open');
          \$('#searchOf').text(filter);
          \$('.SerchResult').removeClass('hideOnLoad');
          setformatOfListsByClass('.visible-sec');

       }
       else
       {
          swal('Enter keyword for search.',{button: false});
          setTimeout(function(){swal.close();},2000);
       }
  }

  function removeSearchSec()
  {
      \$('.LoadMoreBtn').removeClass('hideOnLoad');
     \$('.SerchResult').addClass('hideOnLoad'); 
     \$('#SearchData').val(''); 
     \$('#NoResultFound').addClass('hideOnLoad');
     \$('.streamList').removeClass('hideOnLoad'); 
      setformatOfListsByClass('.thumb-b');
  }

  function confirmparent(\$categoryID = '', \$dataoffset = '0' ,\$datalimit = '28')
  {
      getData(\$categoryID);
  }  


  function getData(\$categoryID = '', \$dataoffset = '0' ,\$datalimit = '28')
  {
    \$(\"#NoResultFound\").addClass(\"hideOnLoad\");
    removeSearchSec();
   //\$('li .active').removeClass('active');
    \$(this).addClass('active'); 
    var MoviesContainer = \$('#MoviesContainer');
    \$('#fullLoader').removeClass('hideOnLoad');
    MoviesContainer.html('');
    MoviesContainer.addClass('hideOnLoad');
   jQuery.ajax({
            type:\"POST\",
            url:\"includes/ajax-control.php\",
            dataType:\"text\",
            data:{
            action:'getMoviesDataFromCategoryId',
            categoryID:\$categoryID,
            dataoffset:\$dataoffset,
            datalimit:\$datalimit,
            hostURL: \"";
echo $XCStreamHostUrl.$bar;
echo "\"
            },  
              success:function(response2){ 
                \$('#fullLoader').addClass('hideOnLoad');
                if(response2 != \"0\")
                {
                    MoviesContainer.html('');
                    MoviesContainer.html(response2);
                    MoviesContainer.removeClass('hideOnLoad');
                    setformatOfListsByClass('.thumb-b');
                   \$(document).find(\".rippler\").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  0      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });
                }
                else
                {
                    \$(\"#NoResultFound\").removeClass(\"hideOnLoad\");
                }
                /*\$getStreamsfromCategory = response2;
                \$('.chanels').html(\$getStreamsfromCategory);
                var StreamId = \$('.Playclick').first().find('.streamId').val();
                var StreamType = \$('.Playclick').first().find('.streamId').data('streamtype');
                \$('.Playclick').first().addClass('playingChanel');
                getVideoLinkAjax(StreamId,StreamType);
                getEPGdata(StreamId);*/
              }
            });
  }

  function setformatOfListsByClass(ClassName = \"\")
  {
      \$(\".free-wall\").each(function() {
      var wall = new Freewall(this);
      wall.reset({
        selector: ClassName,
        animate: true,
        cellW: 185,
        cellH: 278,
        fixSize: 0,
        gutterY: 0,
        gutterX: -15,
        onResize: function() {
          wall.fitWidth();
        }
      })
      wall.fitWidth();
      /* \$(this).find('.iconImage').parent().parent().addClass('checkingcontrol');
        console.log(\$(this).find('.iconImage').parent().parent().attr('data-width')+\"px\");*/
        \$(this).find('.iconImage').css('width',\$(this).find('.iconImage').parent().parent().attr('data-width')+\"px\");
        \$(this).find('.iconImage').css('height',\$(this).find('.iconImage').parent().parent().attr('data-height')+\"px\");
    });
    \$(window).trigger(\"resize\");
  }

  function showInfo(\$streamID = '')
  {
    var fullDataVal = \$(\"#fullData-\"+\$streamID).val();
    /*\$('#fullLoader').removeClass('hideOnLoad');*/
    \$('.sectionNo'+\$streamID+'').addClass('InfoLoading');
    jQuery.ajax({
            type:\"POST\",
            url:\"includes/ajax-control.php\",
            dataType:\"text\",
            data:{
            action:'getMovieInfo',
            movieID:\$streamID,
            fullDataVal:fullDataVal,
            hostURL: \"";
echo $XCStreamHostUrl.$bar;
echo "\"
            },  
              success:function(response2){
               
                \$('.sectionNo'+\$streamID+'').removeClass('InfoLoading');
                \$(document).find('.modal-dialog-custom').html(response2);
                \$('#menuModal').modal('show');
                \$(document).find(\".rippler\").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  0      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });
              }
            })

  }


  function watchMovie(\$movie)
  {
    \$('#player-holder').removeClass('hideOnLoad');
    \$('.poster-details').addClass('hideOnLoad');
    \$('.backToInfo').removeClass('hideOnLoad');
    ";
$resp = webtvpanel_checkPlayer();
if ($resp) {
    $livePlayer = $resp->$username->live_player;
    $moviesPlayer = $resp->$username->movie_player;
    $seriesPlayer = $resp->$username->series_player;
    if ('JW Player' === $moviesPlayer) {
        echo '        $movieVideoLink = "';
        echo $XCStreamHostUrl.$bar;
        echo 'movie/';
        echo $username.'/'.$password;
        echo "/\"+\$movie;
        set_jwplayer(\$movieVideoLink);
        ";
    } else {
        if ('Flow player' === $moviesPlayer) {
            echo '        $movieVideoLink = "';
            echo $XCStreamHostUrl.$bar;
            echo 'movie/';
            echo $username.'/'.$password;
            echo "/\"+\$movie;
        set_flowplayer(\$movieVideoLink);
        ";
        } else {
            if ('AJ player' === $moviesPlayer) {
                echo '        $movieVideoLink = "';
                echo $XCStreamHostUrl.$bar;
                echo 'movie/';
                echo $username.'/'.$password;
                echo "/\"+\$movie;
        set_ajplayer(\$movieVideoLink);
        ";
            } else {
                echo '        $movieVideoLink = "';
                echo $XCStreamHostUrl.$bar;
                echo 'movie/';
                echo $username.'/'.$password;
                echo "/\"+\$movie;
        set_jwplayer(\$movieVideoLink);
        ";
            }
        }
    }
} else {
    echo '        $movieVideoLink = "';
    echo $XCStreamHostUrl.$bar;
    echo 'movie/';
    echo $username.'/'.$password;
    echo "/\"+\$movie;
        set_jwplayer(\$movieVideoLink);
        ";
}

echo "  }
  </script>
  
        ";
include 'includes/footer.php';

