<?php

echo "";  
?>
</div>
<div class="pattern-over"></div>
<!--- Body pattern--->
<?php
if ('dashboard' === $activePage) {
    echo " 
<img class=\"body-bg\" src=\"images/dark-blue-bg.jpg\" alt=\"\"><!--- Body Background---> 
";
} else {
    echo "  <img class=\"body-bg\" src=\"images/bg.jpg\" alt=\"\"><!--- Body Background---> 
";
}

echo "<!-- Movie MODAL CODE -->";
?>
<div class="modal fade movie-popup" id="movieModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    
    <!-- /.modal-content -->
    </div>
  <!-- modal-dialog --> 
 <!--  <img class="body-bg" src="images/mainBlurBG.jpg" alt=""> --><!--- Body Background--> 
</div>

<div class="modal fade movie-popup" id="accountModal1"  tabindex="-1" role="dialog" aria-labelledby="AccountModal" aria-hidden="true" style="z-index: 999;">
  <div class="modal-dialog">
   <div class="modal-content">
          <div class="modal-header" style="border:0;"> <span class="p-close" data-dismiss="modal" aria-hidden="true">x</span> </div>
          <div class="modal-body">
            <div class="popup-content t-s">
              

                   <div class="info_set clearfix" style="width:50%; position: relative; left: 25%; margin-top: 5%; color: #000; background: #fff">
<h1 class="text-center" style="color: #000;">Account Information</h1>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                         <span>Username</span>

                         <p style="width: 100%; overflow: hidden; text-overflow: ellipsis;" title="
<?php
echo $_SESSION['webTvplayer']['username'];
echo '">';
echo $_SESSION['webTvplayer']['username'];
echo "</p>
";
?>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                         <span>Status</span>

                         <p>";
<?php
echo $_SESSION['webTvplayer']['status'];
echo "</p>
";
?>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                         <span>Expiry date</span>

                         <p>
<?php
if ('null' === $_SESSION['webTvplayer']['exp_date'] || '' === $_SESSION['webTvplayer']['exp_date']) {
    echo 'Unlimited';
} else {
    echo date('F d, Y', $_SESSION['webTvplayer']['exp_date']);
}

echo "                         </p>
";
?>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                         <span>Is trial</span>

                         <p>

<?php
if ('0' === $_SESSION['webTvplayer']['is_trial']) {
    echo 'No';
} else {
    echo 'Yes';
}

echo "                         </p>
";
?>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                         <span>Active Connections</span>

                         <p>
<?php
echo $_SESSION['webTvplayer']['active_cons'];
echo "</p>
";
?>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                         <span>Created at</span>

                         <p>
<?php
echo date('F d, Y', $_SESSION['webTvplayer']['created_at']);
echo "                         </p>
";
?>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">

                         <span>Max connections</span>

                         <p>
<?php
echo $_SESSION['webTvplayer']['max_connections'];
echo "</p>
";
?>
                      </div>

                   </div>                       
              </div>
            </div>
          </div>
    <!-- /.modal-content -->
    </div>
  <!-- modal-dialog --> 
 <!--  <img class="body-bg" src="images/mainBlurBG.jpg" alt=""> --><!--- Body Background---> 
</div>
<!--Movie-popup End--> 

<!--Saerch-popup Start-->
<div id="search">
    <button type="button" class="close">×</button>
        <input type="search" value="" id="SearchData" placeholder="type keyword(s) here" />
        <button type="submit"  id="SearchBtn" class="btn btn-primary">Search</button>
</div>
<!--Saerch-popup End-->
<!-- jQuery (JavaScript plugins) --> 

<?php
echo "
<script src=\"js/offcanvas.js\"></script> 
<script src=\"js/bootstrap.js\"></script> 
<script src=\"js/classie.js\"></script> 
<script src=\"js/owl.carousel.min.js\"></script> 
<!-- <script src=\"js/scrollbar.js\"></script> --> 
<script src=\"js/plugin.js\"></script>
<script src=\"js/jquery.infinitescroll.min.js\"></script> 
<script src=\"js/freewall.js\"></script> 
<script type=\"text/javascript\" src=\"js/Manualcustom.js\"></script>
<script src=\"https://unpkg.com/sweetalert/dist/sweetalert.min.js\"></script>
<!-- <script src='https://content.jwplatform.com/libraries/fgbTqCCh.js'></script> -->
<!-- <script src=\"//cdnjs.cloudflare.com/ajax/libs/less.js/3.7.1/less.min.js\" ></script> -->
<script src=\"js/jquery.rippler.min.js\"></script>




<script>
/*-------- Load more Start  ----------*/
\$(document).ready(function() {

\$(document).find(\".rippler, li\").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  0      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });

";
if (isset($_GET['loggedout'])) {
    echo "swal({
  title: 'Logged out!',text:'You have been logged out Successfully.',icon:'success',buttons: false});
setTimeout (function(){
          swal.close();
         },2000)
";
}

echo "  \$('#accountModal').click(function(){
    \$('#accountModal1').modal('show');
  })

\$('#cbp-spmenu-s1 li a').click(function(){
  \$('#cbp-spmenu-s1 li a').removeClass('active');
  \$(this).addClass('active');

    classie.toggle( showLeft, 'active' );
    classie.toggle( menuLeft, 'cbp-spmenu-open' );
    \$('.cat-toggle').toggleClass('open');
})

\$(document).on('click','.showCast',function(){
  
  \$(this).parent('.i-cast').toggleClass('openCast');
  
  if(\$(this).text() == 'Show Cast')
  {
    \$(this).text('Hide Cast');
  }
  else
  {
    \$(this).text('Show Cast');
  }
  

})
\$('#menuModal').on('hidden.bs.modal', function () {
  clearInt();
   \$('#player-holder').html('');
   \$('.backToInfo').addClass('hideOnLoad');
   \$(document).find('.PlayerHolder div').html('').addClass('hideOnLoad');
   clearInt();
})

\$(document).on('click','.backToInfo',function(){
  if(\$('#player-holder').hasClass('flowplayer'))
  {
   var container = document.getElementById(\"player-holder\");
    flowplayer(container).shutdown(); 
  }
  
  \$('#player-holder').html('');

  \$('#player-holder, .backToInfo').addClass('hideOnLoad');

    var episID = \$(this).data('episid');
    if(episID)
    {
      \$('#epis-'+episID+'').removeClass('hideOnLoad');
    }
    else
    {
      \$('.poster-details').removeClass('hideOnLoad');
    }
    clearInt();
  })

  
  setInterval(function(){
  var date = new Date();
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  \$('.time').html(strTime);
  },1000)
  /*setInterval(function(){
  var hr = date.getHours();
  var mins = date.getMinutes();
    \$('.time').html(hr+':'+mins)
  },1000)*/
var win = \$(window);

// Each time the user scrolls
/*win.scroll(function() {
  // End of the document reached?
  if (\$(document).height() - win.height() == win.scrollTop()) {
    \$('#loading').show();

    \$.ajax({
      url: 'get-post.php',
      dataType: 'html',
      success: function(html) {
        \$('#posts ul').append(html);
        \$('#loading').hide();
      }
    });
  }
});*/
});
/*-------- Load more End ----------*/
/*-------- Grids Start ----------*/
\$(function() {
        \$(\".free-wall\").each(function() {
          var wall = new Freewall(this);
          wall.reset({
            selector: '.thumb-b',
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
        });
        \$(window).trigger(\"resize\");
      });
/*-------- Grids End ----------*/



</script>
</body>
</html>";

?>