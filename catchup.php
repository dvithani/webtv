<?php

if (!isset($_POST['dateFullData']) && '' === isset($_POST['dateFullData'])) {
?>
    <!DOCTYPE html>
    <html lang=\"en\">
        <head>
            <!-- google font link -->
            <link href=\"https://fonts.googleapis.com/css?family=Open+Sans|Raleway\" rel=\"stylesheet\">
            <!-- google font link -->
            <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\">
            <link href=\"https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css\" rel=\"stylesheet\">
            <script type=\"text/javascript\" src=\"js/jquery-1.11.2.min.js\"></script>
        </head>
        <body>
            <form method=\"POST\" id=\"FormSubmit\" action=\"\">
                <input type=\"hidden\" name=\"dateFullData\" id=\"InputFieldId\" value=\"\">
            </form>
            <script type=\"text/javascript\">
                var currentTime = new Date();
                var getDate = currentTime.getDate();
                var getMonth = currentTime.getMonth() < 12 ? currentTime.getMonth() + 1 : 1;
                var getFullYear = currentTime.getFullYear();
                var getHours = currentTime.getHours();
                var getMinutes = currentTime.getMinutes();
                var getSeconds = currentTime.getSeconds();
                var dateDatatosent = getDate + '-' + getMonth + '-' + getFullYear + ' ' + getHours + ':' + getMinutes + \":\" + getSeconds;
                \$(\"#InputFieldId\").val(dateDatatosent);
                var infputfieldvalue = \$(\"#InputFieldId\").val();
                if (infputfieldvalue != '')
                {
                    \$(\"#FormSubmit\").submit();
                }
            </script>
        </body>
    </html>


<?php
} else {
    include 'includes/header.php';
    /*if ('Active' !== $checkLicense['status']) {
        echo "<script>window.location.href = 'oops.php';</script>";
        exit();
    }*/

    $CurrentPcDateTime = new DateTime($_POST['dateFullData']);
    $CurrentTime = $CurrentPcDateTime->getTimestamp();
    if ('0' !== $ShiftedTimeEPG) {
        $CurrentTime = strtotime($ShiftedTimeEPG.' hours', $CurrentTime);
    }

    $FinalCategoriesArray = [];
    $FinalChannelsArray = [];
    $FinalChannelsArrayWithEpg = [];
    $GetLiveStreamCateGories = webtvpanel_CallApiRequest($hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_live_categories');
    if ($GetLiveStreamCateGories) {
        $FinalCategoriesArray = $GetLiveStreamCateGories;
    }

    include 'includes/sideNav.php';
	?>
    <script src='https://content.jwplatform.com/libraries/fgbTqCCh.js'></script>



<style type="text/css">
  .PlayerLoader .erroronplayer {
      position: relative;
      top: 150px;
  }
 .addredborder
  {
    border:1px solid red !important;
  }

  .modal-backdrop {
      z-index: 1040 !important;
  }
  .modal-dialog {
      z-index: 1100 !important;
  }

  .in {
    background: rgba(0, 0, 0, 0.95);
    }

    button#UpdateParentPassword {
        position: relative;
        top: 18px;
    }
    .commoncs2, .commoncs2:focus, .commoncs2:active
    {
        background: transparent;
        color: #000 !important;
        padding: 0;
        box-shadow: none;
        outline: none;
        border: 0;
        border-bottom: 1px solid #000;
        border-radius: 0;
    }
    .commoncs2::-webkit-input-placeholder {
        color: #000 !important;
      }
  a.showbtn {
      top: -22px;
      position: relative;
      left: 94%;
  } 

  a.popsbtn {
    top: -32px;
}
</style>

<div class="modal fade" id="confirmparentPopup" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm PIN</h4>
        </div>
        <div class="modal-body">
          <input type="password" id="parentPass" class="form-control commoncs2" placeholder="Enter PIN" value=""  >
          <a href="#parentPass" data-currenteye="show" data-faid="fappass" class="showbtn popsbtn" ><i class="fa fa-eye-slash" id="fappass" aria-hidden="true"></i></a>
        </div>
        <div class="modal-footer">
          <button type="button" id="confirmpasswordbtn" class="btn btn-primary">Confirm <i class="fa fa-spin fa-spinner hideOnLoad" id="checkingprocess2"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<div class="container-fluid no-reultcontainer hideOnLoad">
  <h2 style="margin-top: 30px;">Catch up | Live</h2>
  <h2 style="text-align: center;margin-top: 40px;">No Result Found!</h2>
</div>
<div class="container-fluid main-fullContainer">
  <center id="fullLoader"><img src="images/roundloader.gif"><p class="text-center">LOADING DATA</p></center>
<input type="hidden" id="CurrentTime" value="<?php
    echo $CurrentTime;
    echo '" data-temp="';
    echo date('Y M d h:i A', $CurrentTime);
    echo "\">";
	?>
	
        <!-- Live Channels -->
        <div class="col-sm-5">
          <h2 style="margin-top: 30px;">Catch up | Live <span class="clearSearch hideOnLoad">Clear Search</span></h2>

          <div class="channel-list">
            <div class="chanelLoader hideOnLoad">
              <center><img src="images/roundloader.gif"><p class="text-center">LOADING CHANNELS</p></center>
            </div>
            <ul class="free-wall chanels channels-ul">
            
            </ul>
          </div>
        </div>
        <!-- /Live Channels -->
        <!-- Video Player -->
        <div class="col-sm-7">
          <div class="video-player1">
            <div id="player-wrapper" style="text-align: center;">

                        <center class="PlayerLoader">
                             <div class="Loadicon" role="button" tabindex="0" aria-label="Loading"><svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-buffer" viewBox="0 0 240 240" focusable="false"><path id="PloaderIcon" d="M120,186.667a66.667,66.667,0,0,1,0-133.333V40a80,80,0,1,0,80,80H186.667A66.846,66.846,0,0,1,120,186.667Z"></path></svg></div> 
                             <!-- <img src="images/loader_new.gif"> -->
                        </center> 

                    </div>
                
                      </div>
                    </div>

                    <!-- EPG -->
        
        <div class="col-sm-7">
          <div class="playlist">
            <div class="epgloader hideOnLoad">
              <center><img src="images/roundloader.gif"><p class="text-center">LOADING EPG</p></center>
            </div>
            <div class="liveEPG">
            </div>
          </div>
        </div>
        <!-- /EPG -->
        
        <div class="clearfix"></div>
        <!-- List of Channels -->
        <div class="col-sm-5 hide">
          <h2 style="margin-top: 30px;">TV/All/By Numbers</h2>
          <div class="channel-list">
            <ul class="free-wall">
              <li id="video1">
                <span class="number">1</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Mega</label>
              </li>

              <li id="video2">
                <span class="number">2</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>A1</label>
              </li>

              <li id="video3">
                <span class="number">3</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Channel 1</label>
              </li>

              <li id="video4">
                <span class="number">4</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Global Channel</label>
              </li>

              <li>
                <span class="number">5</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Channel Mega</label>
              </li>

              <li>
                <span class="number">6</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Super Stop</label>
              </li>

              <li>
                <span class="number">7</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Example Channel</label>
              </li>

              <li>
                <span class="number">8</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>A1</label>
              </li>

              <li>
                <span class="number">9</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Mega Channel</label>
              </li>

              <li>
                <span class="number">10</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Custom Channel</label>
              </li>

              <li>
                <span class="number">11</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>Tune Up</label>
              </li>

              <li>
                <span class="number">12</span>
                <i class="fa fa-television" aria-hidden="true"></i>
                <i class="fa fa-star" aria-hidden="true"></i>
                <i class="fa fa-repeat" aria-hidden="true"></i>
                <label>One Channel</label>
              </li>
            </ul>
          </div>
        </div>
        <!-- /List of Channels -->
<?php
echo "        
<script>
  var reconnectInt;
  function confirmparent(categoryID = '',onload = '')
{
  if(onload == 1)
  {
    \$('.main-fullContainer').addClass('hideOnLoad');
    /*\$('.no-reultcontainer').removeClass('hideOnLoad');*/
    \$('#fullLoader').addClass('hideOnLoad');
    \$('.chanelLoader').hide();
    \$('#fullLoader').addClass('hideOnLoad');
    \$('.chanels').html(\"\")
    \$('.liveEPG').html('').hide();
    \$('#player-wrapper').addClass('noResult');
    \$('#player-wrapper').html('');
  }
 /* alert(\"Alert from function is \"+categoryID);*/
  \$(\"#confirmpasswordbtn\").data('categoryID',categoryID);
  \$('#confirmparentPopup').modal('show');

  
  
}

  function getData(\$categoryID = '')
{ 
  if(reconnectInt !== null || reconnectInt !== undefined)
          {
            clearInterval(reconnectInt);
          } 
  removeSearchSec();
  \$('.chanels').html('');
  \$('.chanelLoader').show().removeClass('hideOnLoad');
  \$('.no-reultcontainer').addClass('hideOnLoad');
  \$('.main-fullContainer').removeClass('hideOnLoad');
  \$('#player-wrapper').removeClass('noResult');
   jQuery.ajax({
            type:\"POST\",
            url:\"includes/ajax-control.php\",
            dataType:\"text\",
            data:{
            action:'getCaptchStreamsFromID',
            categoryID:\$categoryID,
            hostURL: \"";
    echo $XCStreamHostUrl.$bar;
    echo "\"
            },  
              success:function(response2){ 
                if(response2 != 0)
                {

                  \$('.liveEPG').html('').hide();
                  \$getStreamsfromCategory = response2;
                  \$('.chanelLoader').hide();
                  \$('#fullLoader').addClass('hideOnLoad');
                  
                  \$('.chanels').html(\$getStreamsfromCategory);
                  var StreamId = \$('.Playclick').first().find('.streamId').val();
                  var StreamType = \$('.Playclick').first().find('.streamId').data('streamtype');
                  \$('.Playclick').first().addClass('playingChanel');

                  \$Videolink = \"";
    echo $XCStreamHostUrl.$bar.'live/'.$username.'/'.$password;
    echo "/\"+StreamId+\".m3u8\";
                  //getVideoLinkAjax(\$Videolink);
                  getCaptchaData(StreamId);
                }
                else
                {

                  \$('.main-fullContainer').addClass('hideOnLoad');
                  \$('.no-reultcontainer').removeClass('hideOnLoad');
                  \$('#fullLoader').addClass('hideOnLoad');
                  \$('.chanelLoader').hide();
                  \$('#fullLoader').addClass('hideOnLoad');
                  \$('.chanels').html(\"\")
                  \$('.liveEPG').html('').hide();
                  \$('#player-wrapper').addClass('noResult');
                  \$('#player-wrapper').html('')
                }                
              }
            })
}


function getCaptchaData(\$streamID = '')
{
  \$('.liveEPG').html('').hide();
  \$('.epgloader').removeClass('hideOnLoad');
  var CurrentTime = \$(\"#CurrentTime\").val();
  jQuery.ajax({
    type:\"POST\",
    url:\"includes/ajax-control.php\",
    dataType:\"text\",
    data:{
    action:'GetCaptchaByStreamid',
    StreamId:\$streamID,
    CurrentTime:CurrentTime,
    hostURL : \"";
    echo $XCStreamHostUrl.$bar;
    echo "\" 
    },  
    success:function(response){
      if(response != \"0\")
      {
       \$('.liveEPG').show().html(response);
       \$('.epgloader').addClass('hideOnLoad');
       if(\$(document).find('.NowPlayingActive').length >= 1)
       {

        var scroll = \$(document).find('.NowPlayingActive').offset().top;
        var scrollHolder = \$(document).find('.liveEPG').offset().top;
        scroll = scroll-scrollHolder;
        \$(document).find('.tab-pane.active').animate({
          scrollTop: (scroll-100)
        },500); 
       } 
         if(\$(\".cp-1\").length != 0)
         {
            \$(\".cp-1\").addClass('NowPlayingActive');  
            var timedifference =  \$(\".cp-1\").data(\"timediff\"); 
            var StartTime =  \$(\".cp-1\").data(\"starttime\"); 
            var StreamId =  \$(\".cp-1\").data(\"streamid\"); 
            \$Videolink = \"";
    echo $XCStreamHostUrl.$bar.'timeshift/'.$username.'/'.$password;
    echo "/\"+timedifference+\"/\"+StartTime+\"/\"+StreamId+\".m3u8\";
            getVideoLinkAjax(\$Videolink);
         } 
      }
    }
  });
}

function getVideoLinkAjax(\$Videolink = \"\", FailCounter = \"\")
{
    //console.log(\$Videolink);
    if(\$('#player-wrapper').hasClass('noResult'))
    {
      return;
    }
    else
    {

    \$('.Loadicon').remove();
    \$LiveVideoLink = \$Videolink;
    if(reconnectInt !== null || reconnectInt !== undefined)
          {
            clearInterval(reconnectInt);
          } 
    var player = jwplayer('player-wrapper');
    // Set up the player with an HLS stream that includes timed metadata
    player.setup({
      \"file\": \$LiveVideoLink,
      \"width\":\"100%\",
      \"aspectratio\": \"16:9\"              
    });
     player.on('play',function(){
      counter = 0;
      clearInterval(reconnectInt);
    })
     player.on('error', function() {
    /*var PlayerDIvSelector = \$('#player-wrapper');
    PlayerDIvSelector.html('');
    PlayerDIvSelector.attr('class', '');
    PlayerDIvSelector.css('text-align', 'center');
    PlayerDIvSelector.html('<img src=\"webtv/images/roundloader.gif\" alt=\"tv image\">');*/
        var showText = 1;
              var PlayerDIvSelector = \$('#player-wrapper');
              PlayerDIvSelector.html('');
              PlayerDIvSelector.attr('class', '');
              PlayerDIvSelector.css('text-align', 'center');
              PlayerDIvSelector.html('<div class=\"erroronplayer\"><span>Playback error, reconnects in 5s ('+showText+'/5)</span></div>');

                
                console.log('Stream connection lose reconnecting ' +showText +\" Time\");
                console.log(\$(document).find('.jw-title-primary').text() + \$(document).find('.jw-title-secondary').text());
            reconnectLoop(\$LiveVideoLink,FailCounter);
            return false;
      
     
    });
   }
}

function reconnectLoop(Link,FailCounter)
{


  var counter = 0;
      if(FailCounter == \"new\")
            {
              counter = 0;
            } 
            console.log(counter);
            
            reconnectInt = setInterval(function()
            {
              counter++;
              if(counter < 5)
              {
                var player = jwplayer(\"player-wrapper\").setup({
                  \"file\": Link,
                  \"width\": \"100%\",
                  \"aspectratio\": \"16:9\"
                });
                player.on('play', function() {
                  counter = 0;
                  clearInterval(reconnectInt);
                });
                player.on('error', function(){
                  var showText = Number(counter)+Number(1);
                    var PlayerDIvSelector = \$('#player-wrapper');
                    PlayerDIvSelector.html('');
                    PlayerDIvSelector.attr('class', '');
                    PlayerDIvSelector.css('text-align', 'center');
                    PlayerDIvSelector.html('<div class=\"erroronplayer\"><span>Playback error, reconnects in 5s ('+showText+'/5)</span></div>');

                      //counter = Number(counter)+Number(1);
                      console.log('Stream connection lose reconnecting ' +counter +\" Time\");
                      console.log(\$(document).find('.jw-title-primary').text() + \$(document).find('.jw-title-secondary').text());
                      })
              }
              else
              {
                
                  clearInterval(reconnectInt);
                  counter = 0;
                  var PlayerDIvSelector = \$('#player-wrapper');
                  PlayerDIvSelector.html('');
                  PlayerDIvSelector.attr('class', '');
                  PlayerDIvSelector.css('text-align', 'center');
                  PlayerDIvSelector.html('<div class=\"erroronplayer\"><span>Sorry, this video can not be played.<br> Please try again or pick another video.</span></div>');
              }
              
            },5000);
              
}

\$(document).ready(function(){

  
  \$(\".showbtn\").click(function(e){
      e.preventDefault();
      var currenteye = \$(this).data('currenteye');
      var InputID = \$(this).attr('href')
      var faid = \$(this).data('faid');
      if(currenteye == \"hide\")
      {
        \$(this).data('currenteye','show');
        \$(InputID).attr('type','password');
        \$(\"#\"+faid).removeClass(\"fa fa-eye\");
        \$(\"#\"+faid).addClass(\"fa fa-eye-slash\");
      }
      else
      {
        \$(this).data('currenteye','hide')
        \$(InputID).attr('type','text');
        \$(\"#\"+faid).removeClass(\"fa fa-eye-slash\");
        \$(\"#\"+faid).addClass(\"fa fa-eye\");
      }
  });

  \$('#confirmpasswordbtn').click(function(){
    \$(\"#parentPass\").removeClass('addredborder');    
    var parentPass = \$(\"#parentPass\").val();
    var categoryid = \$(this).data('categoryID');
    if(parentPass == \"\")
    {
      \$(\"#parentPass\").addClass('addredborder');
    }
    else
    {
      \$('#checkingprocess2').removeClass('hideOnLoad');
      jQuery.ajax({
      type:\"POST\",
      url:\"includes/ajax-control.php\",
      dataType:\"text\",
      data:{
        action:'confirm_parentpassword',
        parentPass:parentPass
      },  
        success:function(response2){ 
          \$('#checkingprocess2').addClass('hideOnLoad');
           if(response2 != 0)
           {
              \$('#parentPass').val('');
              \$('#confirmparentPopup').modal('hide');   
               getData(categoryid);        
           }
           else
           {
              swal({
                  title: 'Error!',
                  text: 'Invalid PIN !!!',
                  icon: 'warning'
                 });
           }             
        }
      });
    }
      
  });

  \$('#SearchData').keypress(function (e) {
   var key = e.which;
   if(key == 13)  // the enter key code
    {
        callSearchFun(); 
    }
  });  

  var omLoadCategoryID = \$(document).find('.onloadCallCategory').data('categoryid');
  var parentControlData = \$(document).find('.onloadCallCategory').data('pcon');
  if(parentControlData == 1)
  {
      confirmparent(omLoadCategoryID,1);
  }
  else
  {
    getData(omLoadCategoryID);
  }
  
  \$( document ).on(\"click\", \".Playclick\", function(){

        \$('.epgloader').removeClass('hideOnLoad');
        \$('liveEPG').html('');
        var StreamId = \$(this).find('.streamId').val();
        var StreamType = \$(this).find('.streamId').data('streamtype');
        \$('.Playclick').removeClass('playingChanel');
        \$(this).addClass('playingChanel');
        getCaptchaData(StreamId);
         var scroll1 = \$(document).find('.video-player1').offset().top;
                \$('body, html').animate({
                  scrollTop: (scroll1-100)
                },500); 
     });

  /*jwplayer(\"player-wrapper\").setup({
        //flashplayer: \"player.swf\",
        file: \"\",
        
    });*/

     \$( document ).on(\"click\", \"#SearchBtn\", function(){
             callSearchFun();
        });

     \$( document ).on(\"click\", \".clearSearch\", function(){
            removeSearchSec();
        });

     \$( document ).on(\"click\", \".catchupclick\", function(){
          \$(\".NowPlayingActive\").removeClass(\"NowPlayingActive\");
          \$(this).addClass(\"NowPlayingActive\");
          var timedifference =  \$(this).data(\"timediff\"); 
          var StartTime =  \$(this).data(\"starttime\"); 
          var StreamId =  \$(this).data(\"streamid\"); 
          \$Videolink = \"";
    echo $XCStreamHostUrl.$bar.'timeshift/'.$username.'/'.$password;
    echo "/\"+timedifference+\"/\"+StartTime+\"/\"+StreamId+\".m3u8\";
           getVideoLinkAjax(\$Videolink);
      });
});


function callSearchFun()
{
  \$('#noResultFound').remove();
   var SearchData = \$(\"#SearchData\").val();   
   if(SearchData != \"\")
   {
      \$('.streamList').addClass('hideOnLoad');
      var moive_namesearch = \$('.serch_key');
      filter = SearchData.toUpperCase();
      CustomIndex = 0;
      moive_namesearch.each(function( index ) {
        if (\$( this ).val().toUpperCase().indexOf(filter) > -1) {
          \$(\".\"+\$(this).data('parentliclass')).removeClass('hideOnLoad');
          CustomIndex = 1;
        }
      });  
      if(CustomIndex == 0)
      {
          \$('.channels-ul').append('<li id=\"noResultFound\">No Result Found!!')
      }
      \$('#search').removeClass('open');
      \$('.clearSearch').removeClass('hideOnLoad');

   }
   else
   {
      swal('Enter keyword for search.',{button: false});
      setTimeout(function(){swal.close();},2000);
   }
}


function removeSearchSec()
{
   \$('#SearchData').val(''); 
   \$('#noResultFound').remove();
   \$('.clearSearch').addClass('hideOnLoad'); 
   \$('.streamList').removeClass('hideOnLoad'); 
}

  </script>
 
 </div>
      ";
    include 'includes/footer.php';
}

?>