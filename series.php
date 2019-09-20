<?php

include 'includes/header.php';
/*if ('Active' !== $checkLicense['status']) {
    echo "<script>window.location.href = 'oops.php';</script>";
    exit();
}*/

$ShoAllCategories = [];
$FinalCategoriesArray = [];
$GetCateGories = webtvpanel_CallApiRequest($hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_series_categories');
if ('success' === $GetCateGories['result']) {
    $FinalCategoriesArray = $GetCateGories;
    $FinalCategoriesArray['data']['all'] = (object) ['category_id' => 'all', 'category_name' => 'All', 'parent_id' => '0'];
}

if ('success' !== $GetCateGories['result']) {
    $FetchAllSeries = webtvpanel_CallApiRequest($hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_series');
    if ('success' === $FetchAllSeries['result']) {
        $ShoAllCategories = $FetchAllSeries['data'];
        $FinalCategoriesArray['result'] = 'success';
        $FinalCategoriesArray['data'][0] = (object) ['category_id' => 'all', 'category_name' => 'All', 'parent_id' => '0'];
    }
}

include 'includes/sideNav.php';
echo "<p class=\"SerchResult hideOnLoad\">
    Search Result of <span id=\"searchOf\">American</span>
    <span class=\"clearSearch\">Clear Search</span>
</p>
<h1 id=\"NoResultFound\" class=\"hideOnLoad\">No Result Found!!</h1>
";
if (!empty($ShoAllCategories)) {
    echo "  <div id=\"posts\">
    <center id=\"fullLoader\"><img src=\"images/roundloader.gif\"  alt=\"tv image\"><p class=\"text-center\">LOADING DATA</p> </center>
      <ul class=\"free-wall grid effect-3 videoSection hideOnLoad\" id=\"SeriesContainer\" style=\"margin-bottom: 50px !important;\">
        
      </ul>
    </div>
  ";
} else {
    echo "	 <div id=\"posts\">
	 	<center id=\"fullLoader\"><img src=\"images/roundloader.gif\"  alt=\"tv image\"><p class=\"text-center\">LOADING DATA</p> </center>
	    <ul class=\"free-wall grid effect-3 videoSection hideOnLoad\" id=\"SeriesContainer\" style=\"margin-bottom: 50px !important;\">
	    	
	    </ul>
	  </div>
	";
}

?>
</div>
<div class="modal fade movie-popup" id="menuModal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-custom">
    <div class="modal-content">
      <div class="modal-header" style="border:0;"> <span class="p-close" data-dismiss="modal" aria-hidden="true">x</span> </div>
      <div class="modal-body">
        <div class="popup-content t-s">
          <div class="pull-left" style="width: 10%;">
            <div class="poster">
              <div class="poster-img"><img src="img/t-s.jpg" alt="" class="img-responsive"></div>
            </div>
          </div>
          <div class="col-sm-9 col-md-10 col-xs-12">
            <div class="poster-details">
              <h2>Vikings</h2>
              <ul>
                <li><i class="fa fa-anchor"></i>Drama</li>
                <li><i class="fa fa-clock-o"></i>44 min</li>
                <li><i class="fa fa-calendar"></i>2013-2016</li>
                <li> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star"></span> <span class="fa fa-star-o"></span></li>
              </ul>
              <p>Vikings follows the adventures of Ragnar Lothbrok, the greatest hero of his age. The series tells the sagas of Ragnar's band of Viking brothers and his family, as he rises to become King of the Viking tribes. As well as being a fearless warrior, Ragnar embodies the Norse traditions of devotion to the gods. Legend has it that he was a direct descendant of Odin, the god of war and warriors.</p>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="ts-content">
            <div class="column seasons">
              <ul>
                <li class="active"><a data-toggle="tab" href="#s-1">Season 1</a></li>
                <li><a data-toggle="tab" href="#s-2">Season 2</a></li>
                <li><a data-toggle="tab" href="#s-3">Season 3</a></li>
                <li><a data-toggle="tab" href="#s-4">Season 4</a></li>
                <li><a data-toggle="tab" href="#s-5">Season 5</a></li>
              </ul>
            </div>
            <div class="column episodes">
              <div class="tab-content">
                <ul id="s-1" class="tab-pane fade in active">
                  <li class="active"><a data-toggle="tab" href="#epis-1"><b>1 </b>Rites of Passage</a></li>
                  <li><a data-toggle="tab" href="#epis-2"><b>2 </b>Wrath of the Northmen </a></li>
                  <li><a data-toggle="tab" href="#epis-3"><b>3 </b>Dispossessed </a></li>
                  <li><a data-toggle="tab" href="#epis-4"><b>4 </b>Trial </a></li>
                  <li><a data-toggle="tab" href="#epis-5"><b>5 </b>Raid </a></li>
                  <li><a data-toggle="tab" href="#epis-6"><b>6 </b>Burial of the Dead </a></li>
                  <li><a data-toggle="tab" href="#epis-7"><b>7 </b>A King's Ransom </a></li>
                  <li><a data-toggle="tab" href="#epis-8"><b>8 </b>Sacrifice </a></li>
                  <li><a data-toggle="tab" href="#epis-9"><b>9 </b>All Change </a></li>
                </ul>
                <ul id="s-2" class="tab-pane fade">
                  <li><a data-toggle="tab" href="#epis-2"><b>2 </b>Wrath of the Northmen </a></li>
                  <li><a data-toggle="tab" href="#epis-3"><b>3 </b>Dispossessed </a></li>
                  <li><a data-toggle="tab" href="#epis-4"><b>4 </b>Trial </a></li>
                  <li><a data-toggle="tab" href="#epis-5"><b>5 </b>Raid </a></li>
                  <li><a data-toggle="tab" href="#epis-6"><b>6 </b>Burial of the Dead </a></li>
                </ul>
                <ul id="s-3" class="tab-pane fade">
                  <li><a data-toggle="tab" href="#epis-2"><b>2 </b>Wrath of the Northmen </a></li>
                  <li><a data-toggle="tab" href="#epis-3"><b>3 </b>Dispossessed </a></li>
                  <li><a data-toggle="tab" href="#epis-4"><b>4 </b>Trial </a></li>
                  <li><a data-toggle="tab" href="#epis-6"><b>6 </b>Burial of the Dead </a></li>
                </ul>
                <ul id="s-4" class="tab-pane fade">
                  <li><a data-toggle="tab" href="#epis-2"><b>2 </b>Wrath of the Northmen </a></li>
                  <li><a data-toggle="tab" href="#epis-3"><b>3 </b>Dispossessed </a></li>
                  <li><a data-toggle="tab" href="#epis-4"><b>4 </b>Trial </a></li>
                  <li><a data-toggle="tab" href="#epis-5"><b>5 </b>Raid </a></li>
                </ul>
                <ul id="s-5" class="tab-pane fade">
                  <li><a data-toggle="tab" href="#epis-7"><b>7 </b>A King's Ransom </a></li>
                  <li><a data-toggle="tab" href="#epis-8"><b>8 </b>Sacrifice </a></li>
                  <li><a data-toggle="tab" href="#epis-9"><b>9 </b>All Change </a></li>
                </ul>
              </div>
            </div>
            <div class="column w-content">
              <div class="tab-content">
                <div id="epis-1" class="tab-pane fade in active">
                  <h2>Rites of Passage</h2>
                  <h5>Episode 1</h5>
                  <p>Ragnar goes on a trip of initiation with his son. Meanwhile, he thinks he has finally found a way to sail ships to the west. However, his beliefs are seen as insane so he chooses to go against the law.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-2" class="tab-pane fade">
                  <h2>Wrath of the Northmen</h2>
                  <h5>Episode 2</h5>
                  <p>The stage is set for the first journey west by Ragnar Lothbrok as he gathers a crew willing to risk their lives to travel into the unknown.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-3" class="tab-pane fade">
                  <h2>Dispossessed</h2>
                  <h5>Episode 3</h5>
                  <p>A monastery in Lindesfarne, England is about to get a firsthand look at how the Vikings operate.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-4" class="tab-pane fade">
                  <h2>Trial</h2>
                  <h5>Episode 4</h5>
                  <p>The Vikings head back to England to see what other treasures this new world has to offer. This go round Ragnar and his crew sail out with Earl Haraldson's permission.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-5" class="tab-pane fade">
                  <h2>Raid</h2>
                  <h5>Episode 5</h5>
                  <p>In the Great Hall of Kattegat, a seer reads Earl Haraldson's future and tells him that Ragnar Lothbrok searches for his death.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-6" class="tab-pane fade">
                  <h2>Burial of the Dead</h2>
                  <h5>Episode 6</h5>
                  <p>Ragnar, weak and still hurt, must meet the Earl head-on after it comes to light that Rollo has been tortured on Haraldson's orders.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-7" class="tab-pane fade">
                  <h2>A King's Ransom</h2>
                  <h5>Episode 7</h5>
                  <p>Three Viking ships sail upriver towards the very heart of power in eastern England: the Royal Villa of King Aelle.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-8" class="tab-pane fade">
                  <h2>Sacrifice</h2>
                  <h5>Episode 8</h5>
                  <p>The traditional pilgrimage to Uppsalla to thank the gods brings a torrent of emotions for Ragnar, Lagertha, and Athelstan.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
                <div id="epis-9" class="tab-pane fade">
                  <h2>All Change</h2>
                  <h5>Episode 9</h5>
                  <p>At the behest of King Horik, Ragnar assembles a small party to travel to Gotaland (modern day Sweden) to resolve a land dispute with the area's leader, Jarl Borg.</p>
                  <div class="fav row">
                    <div class="res-list">
                      <select>
                        <option>480p</option>
                        <option selected>720p</option>
                        <option>1080p</option>
                      </select>
                    </div>
                  </div>
                  <div class="watch-now row">
                    <button>watch it now</button>
                  </div>
                </div>
              </div>
              <!--tab-content--> 
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content --> 
  </div>
  </div>
 <?php
 echo "
  <!-- /.modal-dialog --> 
<script src='https://content.jwplatform.com/libraries/fgbTqCCh.js'></script>
<script src='js/flowplayer/flowplayer.js'></script>
<script src='js/mediaPlayers.js'></script>
<link rel=\"stylesheet\" href=\"js/flowplayer/skin/skin.css\" media=\"screen\">
   <script type=\"text/javascript\">

    \$(document).ready(function(){
      var vid = '';
    	var SeriesContainer = \$(\"#SeriesContainer\");
    	var CHeckExists = SeriesContainer.length;
      if(CHeckExists != 0)
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
                action:'GetSeriesByCateGoryId',
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
                     var SeriesContainer = \$('#SeriesContainer');
                     SeriesContainer.append(response2);
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
     \$('#fullLoader').addClass('hideOnLoad');

  }


    function confirmparent(\$categoryID = '', \$dataoffset = '0' ,\$datalimit = '28')
  {
      getData(\$categoryID);
  }  

   function getData(\$categoryID = '', \$dataoffset = '0' ,\$datalimit = '28')
  {
    removeSearchSec();
  	\$(this).addClass('active'); 
    var SeriesContainer = \$('#SeriesContainer');
    SeriesContainer.html('');
    SeriesContainer.addClass('hideOnLoad');
    \$('#fullLoader').removeClass('hideOnLoad');
    SeriesContainer.html('');
    SeriesContainer.addClass('hideOnLoad');
	jQuery.ajax({
	    type:\"POST\",
	    url:\"includes/ajax-control.php\",
	    dataType:\"text\",
	    data:{
	    action:'GetSeriesByCateGoryId',
	    categoryID:\$categoryID,
      dataoffset:\$dataoffset,
      datalimit:\$datalimit,
	    hostURL: \"";
echo $XCStreamHostUrl.$bar;
echo "\"
	    },  
	      success:function(response2){
		     
		      if(response2 != '0')
		      {
		      	SeriesContainer.html('');
                SeriesContainer.html(response2);
                SeriesContainer.removeClass('hideOnLoad');
                SeriesContainer.css('margin-bottom','50px !important');
                setformatOfListsByClass('.thumb-b');

		      }
		      else
		      {
            \$('#fullLoader').addClass('hideOnLoad');
		      	\$(\"#NoResultFound\").removeClass(\"hideOnLoad\");
		      }
		      \$(document).find(\".rippler\").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  0      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });
	      }
	    });
	   
  }

  function showInfo(\$seriesID = '')
  {
    var fullDataVal = \$(\"#fullData-\"+\$seriesID).val();
    /*\$('#fullLoader').removeClass('hideOnLoad');*/
    \$('.sectionNo'+\$seriesID+'').addClass('InfoLoading');
	jQuery.ajax({
		type:\"POST\",
		url:\"includes/ajax-control.php\",
		dataType:\"text\",
		data:{
		action:'getSeriesInfo',
        seriesID:\$seriesID,
		fullDataVal:fullDataVal,
		hostURL: \"";
echo $XCStreamHostUrl.$bar;
echo "\"
		},  
		success:function(response2){ 
			if(response2 != \"0\")
			{
				\$(document).find('.modal-dialog-custom').html(response2);
        \$('.sectionNo'+\$seriesID+'').removeClass('InfoLoading');
				\$('#menuModal').modal('show');			
			}
			else
			{
				swal('No Result found!!');
        \$('.sectionNo'+\$seriesID+'').removeClass('InfoLoading');
			}
      \$(document).find(\".rippler\").rippler({
    effectClass      :  'rippler-effect'
    ,effectSize      :  0      // Default size (width & height)
    ,addElement      :  'div'   // e.g. 'svg'(feature)
    ,duration        :  400
  });
		}
	});
  }

  \$(document).on(\"click\", \".backToInfo\", function(){
    
    var episID = \$(this).data('episid');
    \$(this).addClass('hideOnLoad');
    \$('#player-holder').html('');
    \$('#player-holder').addClass('hideOnLoad');
    \$('#epis-'+episID+'').removeClass('hideOnLoad');
    
  })

  \$(document).on(\"click\", \".episodes li a\", function(){
    var episID = \$(this).data('episid');
    //\$(this).addClass('hideOnLoad');
    \$('#player-holder').html('');
    \$('#player-holder').addClass('hideOnLoad');
    \$('#epis-'+episID+'').removeClass('hideOnLoad');
    \$('.backToInfo').addClass('hideOnLoad');
    /*\$(document).find('.PlayerHolder div').html('').addClass('hideOnLoad');
    \$('.backToInfo').addClass('hideOnLoad');*/
    
  })

  function watchnow(\$movie, \$format)
  {
    \$('#player-holder').removeClass('hideOnLoad');
    \$('#epis-'+\$movie+'').addClass('hideOnLoad');
    \$('#backToInfo-'+\$movie+'').removeClass('hideOnLoad');
   
   ";
$resp = webtvpanel_checkPlayer();
if ($resp) {
    $livePlayer = $resp->$username->live_player;
    $moviesPlayer = $resp->$username->movie_player;
    $seriesPlayer = $resp->$username->series_player;
    if ('JW Player' === $seriesPlayer) {
        echo '           $movieVideoLink = "';
        echo $XCStreamHostUrl.$bar;
        echo 'series/';
        echo $username.'/'.$password;
        echo "/\"+\$movie+'.'+\$format;
          set_jwplayer(\$movieVideoLink);
        ";
    } else {
        if ('Flow player' === $seriesPlayer) {
            echo '         $movieVideoLink = "';
            echo $XCStreamHostUrl.$bar;
            echo 'series/';
            echo $username.'/'.$password;
            echo "/\"+\$movie+'.'+\$format;
          set_flowplayer(\$movieVideoLink);
        ";
        } else {
            if ('AJ player' === $seriesPlayer) {
                echo '        $movieVideoLink = "';
                echo $XCStreamHostUrl.$bar;
                echo 'series/';
                echo $username.'/'.$password;
                echo "/\"+\$movie+'.'+\$format;
          set_ajplayer(\$movieVideoLink);
        ";
            } else {
                echo '           $movieVideoLink = "';
                echo $XCStreamHostUrl.$bar;
                echo 'series/';
                echo $username.'/'.$password;
                echo "/\"+\$movie+'.'+\$format;
          set_jwplayer(\$movieVideoLink);
          ";
            }
        }
    }
} else {
    echo '         $movieVideoLink = "';
    echo $XCStreamHostUrl.$bar;
    echo 'series/';
    echo $username.'/'.$password;
    echo "/\"+\$movie+'.'+\$format;
        set_jwplayer(\$movieVideoLink);
        ";
}

echo "   
  }






  </script>

          ";
include 'includes/footer.php';

?>