<?php

include 'includes/header.php';
/*if ('Active' !== $checkLicense['status']) {
    echo "<script>window.location.href = 'oops.php';</script>";
    exit();
}*/

$LiveSection = '';
$MovieSection = '';
$SeriesSection = '';
$epgtimeshift = '0';
$timeformat = '12';
$parentenable = '';
$parentpassword = '';
if (isset($_COOKIE['settings_array'])) {
    $SettingArray = json_decode($_COOKIE['settings_array']);
    if (isset($SettingArray->{$_SESSION['webTvplayer']['username']}) && !empty($SettingArray->{$_SESSION['webTvplayer']['username']})) {
        $LiveSection = $SettingArray->{$_SESSION['webTvplayer']['username']}->live_player;
        $MovieSection = $SettingArray->{$_SESSION['webTvplayer']['username']}->movie_player;
        $SeriesSection = $SettingArray->{$_SESSION['webTvplayer']['username']}->series_player;
        $epgtimeshift = $SettingArray->{$_SESSION['webTvplayer']['username']}->epgtimeshift;
        $timeformat = $SettingArray->{$_SESSION['webTvplayer']['username']}->timeformat;
        $parentenable = $SettingArray->{$_SESSION['webTvplayer']['username']}->parentenable;
        $parentpassword = $SettingArray->{$_SESSION['webTvplayer']['username']}->parentpassword;
    }
}

echo "";
?>
<style type="text/css">
  div#SuccessMessage {
      position: fixed;
      top: -100%;
      left: 35%;
      width: 30%;
  }
  h3.SettingsHeadings {
        color: #fff;
      text-align: left;
  }

  .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {display:none;}

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
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
        
      .commoncs2::-moz-placeholder {
         color: #000 !important;
      }
      .commoncs2::-webkit-input-placeholder {
         color: #000 !important;
      }
      .commoncs2::-ms-input-placeholder{
         color: #000 !important;
      }

    td.common-td {
         width: 40%;
    }

   .disableInputs
   {
      cursor: not-allowed;
   }

   a.showbtn {
      top: -22px;
      position: relative;
      left: 94%;
  } 

  .commoncs {
    position: relative;
    top: 10px;
}


.form-control, .form-control:focus, .form-control:active {
     border-bottom: none !important; 
  }

  .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
      border: 1px solid #dadada52 !important;
      padding: 5px 10px !important;
      line-height: 30px !important;
  }

  .commoncs, .commoncs:focus, .commoncs:active 
  { 
      border-bottom: 1px solid #dadada52 !important;
  }
  .commoncs2, .commoncs2:focus, .commoncs2:active 
  { 
      border-bottom: 1px solid #000 !important;
  }


a.popsbtn {
    top: -32px;
}

.commonsectionclass table {
    border: none !important;
}

.commonsectionclass tr {
    border: none !important;
}


.commonsectionclass td {
    border: none !important;
}
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td
{
  border: none !important;
  padding:10px 10px !important
}

.main-sheading
{
      border-bottom: 1px solid #aaa;
    padding-bottom: 10px;
}

.commonsectionclass {
    border-bottom: 1px groove #aaa;
}

.commonsectionclass .form-control {
    border-bottom: 1px groove #aaa !important;
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
          <button type="button" id="confirmpasswordbtn" class="btn btn-primary">Confirm <i class="fa fa-spin fa-spinner hideOnLoad" id="checkingprocess3"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container full-container navb-fixid">
      <div class="navbar-header">
        <div id="showLeft" class="cat-toggle hide"> <span></span> <span></span> <span></span> <span></span> </div>
        <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="offcanvas"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <a class="brand" href="dashboard.php"><img class="img-responsive" src="
<?php
echo isset($XClogoLinkval) && !empty($XClogoLinkval) ? $XClogoLinkval : 'img/logo.png';
echo "\" alt=\"\" onerror=\"this.src='img/logo.png';\"></a>
      <div id=\"navbar\" class=\"collapse navbar-collapse sidebar-offcanvas\">
        ";
if ('index' !== $activePage) {
    echo "        <ul class=\"nav navbar-nav navbar-left main-icon\">
          <li class=\"";
    if ('index' === $activePage) {
        echo 'active';
    }

    echo "\"><a href=\"index.php\"><span class=\"da home\"></span><span>Home</span></a></li>
          <li class=\"";
    if ('live' === $activePage) {
        echo 'active';
    }

    echo "\"><a href=\"live.php\"><span class=\"da live\"></span><span>Live Tv</span></a></li>
          <li class=\"";
    if ('movies' === $activePage) {
        echo 'active';
    }

    echo "\"><a href=\"movies.php\"><span class=\"da movie\"></span><span>Movies</span></a></li>
          <li class=\"";
    if ('series' === $activePage) {
        echo 'active';
    }

    echo "\" ><a href=\"series.php\"><span class=\"da tv\"></span><span>Tv series</span></a></li>
          <li class=\"";
    if ('radio' === $activePage) {
        echo 'active';
    }

    echo "\" ><a href=\"radio.php\"><span class=\"da radio\"></span><span>Radio</span></a></li>
          <li class=\"";
    if ('catchup' === $activePage) {
        echo 'active';
    }

    echo "\"><a href=\"catchup.php\"><span class=\"da catchup\"></span><span>Catch Up</span></a></li>
          <!-- <li class=\"";
    if ('radio' === $activePage) {
        echo 'active';
    }

    echo "\"><a href=\"radio.php\"><span class=\"da radio\"></span><span>Radio</span></a></li> -->
          
        </ul>
        <ul class=\"nav navbar-nav navbar-right r-icon\">
          ";
    if ('settings' === $activePage) {
        echo "            <li class=\"r-li\"><a href=\"#\"\" class=\"logoutBtn\"><i class=\"fa fa-sign-out\"></i><span class=\"r-show\">Logout</span></a></li>
          ";
    }

    echo "        </ul>
      ";
} else {
    echo '          <p class="datetime"><span class="time"></span>  <span class="date"> ';
    echo date('d-M-Y');
    echo "</span></p>
        ";
}

echo "      </div>
      <!--/.nav-collapse --> 
    </div>
  </nav>



";
 ?> 
  <div class="modal fade" id="ConfirmParentPassword" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update PIN</h4>
        </div>
        <div class="modal-body">
              <input type="password" id="poldpassword" class="form-control commoncs2" placeholder="Old PIN" value=""  >
              <a href="#poldpassword" data-currenteye="show" data-faid="faoldpass" class="showbtn popsbtn" ><i class="fa fa-eye-slash" id="faoldpass" aria-hidden="true"></i></a>
              <br>
              <input type="password" id="pmainpassword" class="form-control commoncs2" placeholder="New PIN" value=""  >
              <a href="#pmainpassword" data-currenteye="show" data-faid="fanewpass" class="showbtn popsbtn" ><i class="fa fa-eye-slash" id="fanewpass" aria-hidden="true"></i></a>
              <br>
              <input type="password" id="pconnpassword" class="form-control commoncs2" placeholder="Confirm PIN" value=""  >
              <a href="#pconnpassword" data-currenteye="show" data-faid="faconpass" class="showbtn popsbtn" ><i class="fa fa-eye-slash" id="faconpass" aria-hidden="true"></i></a>
        </div>
        <div class="modal-footer">
          <button type="button" id="updateparentpasswordbtn" class="btn btn-primary">Update <i class="fa fa-spin fa-spinner hideOnLoad" id="checkingprocess2"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="container-fluid">
  <center id="fullLoader" class="hideOnLoad"><img src="images/roundloader.gif"><p class="text-center">LOADING DATA</p></center>
  
  <div class="col-md-12 container-holder">
    <div class="container col-md-8 col-md-offset-2">
        <h2 class="text-center heading main-sheading">SETTINGS</h2>
        <div class="col-md-12 commonsectionclass">
          <table class="table table-bordered">
            <tr>
              <td colspan="2">
                  <h3 class="SettingsHeadings">Player Settings</h3>
              </td>
            </tr>
            <tr class="hideOnLoad">
              <td class="common-td">
                Live Player
              </td>
              <td>
                <select id="live_player" class="form-control">
                  <option 
<?php
echo 'JW Player' === $LiveSection ? "selected='selected'" : '';
echo " value=\"JW Player\">JW Player</option>
                  <!-- <option ";
echo 'Flow player' === $LiveSection ? "selected='selected'" : '';
echo " value=\"Flow player\">Flow player</option> -->
                </select>
              </td>
            </tr>
            <tr>
              <td class=\"common-td\">
                Select default player for movies section
              </td>
              <td>
                <select  id=\"movie_player\" class=\"form-control\">
                  <option ";
echo 'JW Player' === $MovieSection ? "selected='selected'" : '';
echo " value=\"JW Player\">JW Player</option>
                  <option ";
echo 'Flow player' === $MovieSection ? "selected='selected'" : '';
echo " value=\"Flow player\">Flow player</option>
                  <option ";
echo 'AJ player' === $MovieSection ? "selected='selected'" : '';
echo " value=\"AJ player\">AJ player</option>
                </select>
              </td>
            </tr>
            <tr>
              <td class=\"common-td\"> 
                Select default player for Series section
              </td>
              <td>
                <select id=\"series_player\" class=\"form-control\">
                  <option ";
echo 'JW Player' === $SeriesSection ? "selected='selected'" : '';
echo " value=\"JW Player\">JW Player</option>                  
                  <option ";
echo 'Flow player' === $SeriesSection ? "selected='selected'" : '';
echo " value=\"Flow player\">Flow player</option>
                  <option ";
echo 'AJ player' === $SeriesSection ? "selected='selected'" : '';
echo " value=\"AJ player\">AJ player</option>
                </select>
              </td>
            </tr>
         </table>  
        </div>
        <div class=\"col-md-12 commonsectionclass\"> 
         <table class=\"table table-bordered\"> 
            <tr>
              <td colspan=\"2\">
                  <h3 class=\"SettingsHeadings\">Time Settings</h3>
              </td>
            </tr>
            <tr>
              <td class=\"common-td\">
                Time Format
              </td>
              <td>
                <select id=\"timeformat\" class=\"form-control\">
                    <option value=\"12\" ";
echo '12' === $timeformat || '' === $timeformat ? "selected='selected'" : '';
echo ">12 Hours Format</option>
                    <option value=\"24\" ";
echo '24' === $timeformat ? "selected='selected'" : '';
echo ">24 Hours Format</option>
                </select>
              </td>
            </tr>
            <tr>
              <td class=\"common-td\">
                Epg Time Shift
              </td>
              <td>
                <select id=\"epgtimeshift\" class=\"form-control\">
                  ";
for ($ri = 12; 1 <= $ri; --$ri) {
    echo '                      <option value="-';
    echo $ri;
    echo '" ';
    echo $epgtimeshift === '-'.$ri ? "selected='selected'" : '';
    echo '>-';
    echo $ri;
    echo "</option>
                    ";
}
echo '                  <option value="0" ';
echo 0 === $epgtimeshift ? "selected='selected'" : '';
echo ">0</option>
                  ";
for ($i = 1; $i <= 12; ++$i) {
    echo '                      <option value="+';
    echo $i;
    echo '" ';
    echo $epgtimeshift === '+'.$i ? "selected='selected'" : '';
    echo '>+';
    echo $i;
    echo "</option>
                    ";
}
echo "                </select>
              </td>
            </tr>
          </table>
        </div>
        <div class=\"col-md-12 commonsectionclass\">  
         <table class=\"table table-bordered\"> 
            <tr>
              <td colspan=\"2\">
                  <h3 class=\"SettingsHeadings\" id=\"parentheading\">Parental Control Setting</h3>
              </td>
            </tr>            
            <tr>
              <td class=\"common-td\">
                <div class=\"row\">
                  <div class=\"col-md-12\" style=\"margin-top: 16px; text-align: center;\">
                    <span id=\"showentext\" style=\"position: relative; top: -15px;\">";
echo 'on' === $parentenable ? 'Disable' : 'Enable';
echo "</span>
                    <label class=\"switch \">
                      <input type=\"checkbox\" id=\"enablecheckebox\" ";
echo 'on' === $parentenable ? 'checked' : '';
echo ' data-afterenable="';
echo '' !== $parentpassword ? '1' : '';
echo "\" >
                      <span class=\"slider round\"></span>
                    </label>
                  </div>
                </div>
              </td>
              <td style=\"height: ";
echo '' === $parentpassword ? '140px;' : '80px';
echo "\">
                  ";
if ('' === $parentpassword) {
    echo "                        <input type=\"password\" id=\"parentmainpassword\" class=\"form-control commoncs\" placeholder=\"New PIN\" value=\"\" readonly >
                        <a href=\"#parentmainpassword\" data-currenteye=\"show\" data-faid=\"fanewpassword\" class=\"showbtn hideOnLoad\" ><i class=\"fa fa-eye-slash\" id=\"fanewpassword\" aria-hidden=\"true\"></i></a>
                        <br>
                        <input type=\"password\" id=\"parentconpassword\" class=\"form-control commoncs\" placeholder=\"Confirm PIN\" value=\"\" readonly >
                        <a href=\"#parentconpassword\" data-currenteye=\"show\" data-faid=\"fanconewpassword\" class=\"showbtn hideOnLoad\" ><i class=\"fa fa-eye-slash\" id=\"fanconewpassword\" aria-hidden=\"true\"></i></a>
                    ";
} else {
    echo "                    <div class=\"row\" style=\"text-align: center;\">
                        <button id=\"UpdateParentPassword\" class=\"btn btn-primary\">Update PIN</button>
                        <input type=\"hidden\" id=\"editpassword\" >
                    </div>
                    ";
}

echo "              </td>
            </tr>
            
          </table>
        </div>
          <div class=\"col-md-12\" >
          <p style=\"text-align: right;color: #717171;margin: 0;\">V 1.5</p>
          </div>
          <div class=\"col-md-12\" style=\"margin-bottom: 10px;\">
            <center>

             <div class=\"alert alert-success \" id=\"SuccessMessage\">
                <strong>Success!</strong> Changes Saved Successfully.
             </div>
            <button class=\"btn btn-primary rippler rippler-default\" id=\"SaveSettings\">Save Changes <i class=\"fa fa-spin fa-spinner hideOnLoad\" id=\"checkingprocess\"></i></button></center>
          </div>
        </div>
    </div>
  </div>
</div>
<script type=\"text/javascript\">
   \$(document).ready(function(){
      \$(\".commoncs\").click(function(){
          if ( \$(this).is('[readonly]') ) { 
            swal({
                  title: 'Error!',
                  text: 'Please Enable First!!!',
                  icon: 'warning'
                 });
          }
      });

      \$(\".showbtn\").click(function(e){
          e.preventDefault();
          var currenteye = \$(this).data('currenteye');
          var InputID = \$(this).attr('href')
          var faid = \$(this).data('faid');
          if(currenteye == \"hide\")
          {
          \t\$(this).data('currenteye','show');
          \t\$(InputID).attr('type','password');
          \t\$(\"#\"+faid).removeClass(\"fa fa-eye\");
          \t\$(\"#\"+faid).addClass(\"fa fa-eye-slash\");
          }
          else
          {
          \t\$(this).data('currenteye','hide')
          \t\$(InputID).attr('type','text');
          \t\$(\"#\"+faid).removeClass(\"fa fa-eye-slash\");
          \t\$(\"#\"+faid).addClass(\"fa fa-eye\");
          }
      });

      checkboxfunction();
      \$('#UpdateParentPassword').click(function(){
          \$('#ConfirmParentPassword').modal('show');
      });
      \$('#enablecheckebox').click(function(e){
          if(\$(this).data('afterenable') == 1)
          {
            e.preventDefault();
/*            \$(\"#parentPass\").addClass(\"addredborder\");*/
            \$(\"#parentPass input[type=password]\").focus();
            \$('#confirmparentPopup').modal('show');

          }
          else
          {
            checkboxfunction();
          }
      });

      \$('#confirmpasswordbtn').click(function(){   
          var  parentenable = \"on\";
          var  parentenableMessage = \"Enabled\";
          if(\$('#enablecheckebox').prop('checked') == true)
          {
             parentenable = \"\";   
             parentenableMessage = \"Disabled\";  
          } 
          \$(\"#parentPass\").removeClass('addredborder');    
          var parentPass = \$(\"#parentPass\").val();
          if(parentPass == \"\")
          {
            \$(\"#parentPass\").addClass('addredborder');
          }
          else
          {
            \$('#checkingprocess3').removeClass('hideOnLoad');
            jQuery.ajax({
            type:\"POST\",
            url:\"includes/ajax-control.php\",
            dataType:\"text\",
            data:{
              action:'confirm_parentpassword',
              parentPass:parentPass
            },  
              success:function(response2){ 
                \$('#checkingprocess3').addClass('hideOnLoad');
                 if(response2 != 0)
                 {
                    var savedparentpassword = \"";
echo webtvpanel_baseDecode($parentpassword);
echo "\";
                    var live_player = \$(\"#live_player\");
                    var movie_player = \$(\"#movie_player\");
                    var series_player = \$(\"#series_player\");
                    var epgtimeshift_selector = \$(\"#epgtimeshift\");
                    var timeformat_selector = \$(\"#timeformat\");

                    var live_player_val = live_player.val();
                    var movie_player_val = movie_player.val();
                    var series_player_val = series_player.val();
                    var epgtimeshift_val = epgtimeshift_selector.val();
                    var timeformat_val = timeformat_selector.val();
                    jQuery.ajax({
                      type:\"POST\",
                      url:\"includes/ajax-control.php\",
                      dataType:\"text\",
                      data:{
                      action:'SaveSettings',
                      live_player_val:live_player_val,
                      movie_player_val:movie_player_val,
                      series_player_val:series_player_val,
                      epgtimeshift_val:epgtimeshift_val,
                      parentenable:parentenable,
                      parentmainpassword_val:savedparentpassword,
                      timeformat_val:timeformat_val
                      },  
                        success:function(response2){
                           \$('#checkingprocess2').addClass('hideOnLoad');
                           swal({
                            text: 'PIN Successfully '+parentenableMessage,
                            button:false,
                            icon: 'success'
                           });
                           setTimeout (function(){
                            swal.close();
                            location.reload();
                           },2000)
                           /*\$('#SuccessMessage').animate({'top':'67px'}, 300 );
                           setTimeout (function(){
                            \$('#SuccessMessage').animate({'top':'-100%'}, 300 );
                           },2000)*/
                        }
                    });
                    /*\$('#parentPass').val('');
                    \$('#confirmparentPopup').modal('hide'); 
                    if(\$('#enablecheckebox').prop('checked') == true)
                    {
                      \$('#showentext').text('Enable');
                      \$('#enablecheckebox').prop('checked', false);  
                      \$('#UpdateParentPassword').attr(\"disabled\", true);
                    }
                    else
                    {
                      \$('#showentext').text('Disable');
                      \$('#enablecheckebox').prop('checked', true);
                      \$('#UpdateParentPassword').attr(\"disabled\", false);
                    } */
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

      //Update Parent Password Section..
      \$('#updateparentpasswordbtn').click(function(){
          var updatevalidationcondition = 1;
          var savedparentpassword = \"";
echo webtvpanel_baseDecode($parentpassword);
echo "\";
          \$(\".commoncs2\").removeClass(\"addredborder\");
          var live_player = \$(\"#live_player\");
          var movie_player = \$(\"#movie_player\");
          var series_player = \$(\"#series_player\");
          var epgtimeshift_selector = \$(\"#epgtimeshift\");
          var timeformat_selector = \$(\"#timeformat\");

          var poldpassword = \$(\"#poldpassword\");
          var pmainpassword = \$(\"#pmainpassword\");
          var pconnpassword = \$(\"#pconnpassword\");

          var live_player_val = live_player.val();
          var movie_player_val = movie_player.val();
          var series_player_val = series_player.val();
          var epgtimeshift_val = epgtimeshift_selector.val();
          var timeformat_val = timeformat_selector.val();

          var poldpassword_val = poldpassword.val();
          var pmainpassword_val = pmainpassword.val();
          var pconnpassword_val = pconnpassword.val();

          if(poldpassword_val == \"\")
          {
            updatevalidationcondition = 0;
            \$(\"#poldpassword\").addClass('addredborder');
          }
          if(pmainpassword_val == \"\")
          {
            updatevalidationcondition = 0;
            \$(\"#pmainpassword\").addClass('addredborder');
          }
          if(pconnpassword_val == \"\")
          {
            updatevalidationcondition = 0;
            \$(\"#pconnpassword\").addClass('addredborder');
          }

          if(updatevalidationcondition == 1)
          {
              if(poldpassword_val != savedparentpassword)
              {
                swal({
                  title: 'Error!',
                  text: 'Old PIN is incorrect !!!',
                  icon: 'warning'
                 });
                 updatevalidationcondition = 0;
              }
          }

          if(updatevalidationcondition == 1)
          {
              if(pmainpassword_val != pconnpassword_val)
                  {
                    swal({
                      title: 'Error!',
                      text: 'New PIN does not matach with confirm PIN !!!',
                      icon: 'warning'
                     });
                    updatevalidationcondition = 0;
                  }
          }
          
          if(updatevalidationcondition == 1)
          {
            \$('#checkingprocess2').removeClass('hideOnLoad');
            jQuery.ajax({
              type:\"POST\",
              url:\"includes/ajax-control.php\",
              dataType:\"text\",
              data:{
              action:'SaveSettings',
              live_player_val:live_player_val,
              movie_player_val:movie_player_val,
              series_player_val:series_player_val,
              epgtimeshift_val:epgtimeshift_val,
              parentenable:\"on\",
              parentmainpassword_val:pmainpassword_val,
              timeformat_val:timeformat_val
              },  
                success:function(response2){
                   \$('#checkingprocess2').addClass('hideOnLoad');
                   swal({
                    text: 'PIN Successfully Upadeted',
                    button:false,
                    icon: 'success'
                   });
                   setTimeout (function(){
                    swal.close();
                    location.reload();
                   },2000)
                   /*\$('#SuccessMessage').animate({'top':'67px'}, 300 );
                   setTimeout (function(){
                    \$('#SuccessMessage').animate({'top':'-100%'}, 300 );
                   },2000)*/
                }
              });
          }


      });
      \$(document).on(\"click\", \"#SaveSettings\", function(){
        SaveSettingsFunction();
      });
    });

   function checkboxfunction()
   {
      \$(\".commoncs\").removeClass(\"addredborder\");
      if(\$('#enablecheckebox').prop('checked') == true)
          {
            \$('.showbtn').removeClass('hideOnLoad');
            \$('#showentext').text('Disable');
            \$('.commoncs').removeClass('disableInputs');
            \$('.commoncs').attr(\"readonly\", false);
            \$('#UpdateParentPassword').attr(\"disabled\", false);
          }
          else
          {
            \$('.showbtn').removeClass('hideOnLoad');
            \$('#showentext').text('Enable');
            \$('.commoncs').addClass('disableInputs');
            \$('.commoncs').attr(\"readonly\", true);
            \$('#UpdateParentPassword').attr(\"disabled\", true);
          }
   }

function SaveSettingsFunction()
{
  \$(\".commoncs\").removeClass(\"addredborder\");
  var parentenable = \"\";
  var validationcondition = 1;
  var parentmainpassword_val = \"";
echo webtvpanel_baseDecode($parentpassword);
echo "\";
   
  if(\$('#enablecheckebox').prop('checked') == true)
  {
      parentenable = \"on\";
      if(\$(\"#UpdateParentPassword\").length == 0)
      {
        parentmainpassword_val = \$(\"#parentmainpassword\").val();
        parentconpassword_val = \$(\"#parentconpassword\").val();
        if(parentmainpassword_val == \"\")
        {
          validationcondition = 0;
          \$(\"#parentmainpassword\").addClass('addredborder');
        }

        if(parentconpassword_val == \"\")
        {
          validationcondition = 0;
          \$(\"#parentconpassword\").addClass('addredborder');
        }
        if(parentmainpassword_val != parentconpassword_val)
        {
          swal({
            title: 'Error!',
            text: 'New PIN does not matach with confirm PIN !!!',
            icon: 'warning'
           });
          validationcondition = 0;
        } 
      }
  }

  if(validationcondition == 1)
  {
    
    \$('#checkingprocess').removeClass('hideOnLoad');
    var live_player = \$(\"#live_player\");
    var movie_player = \$(\"#movie_player\");
    var series_player = \$(\"#series_player\");
    var epgtimeshift_selector = \$(\"#epgtimeshift\");
    var timeformat_selector = \$(\"#timeformat\");

    var live_player_val = live_player.val();
    var movie_player_val = movie_player.val();
    var series_player_val = series_player.val();
    var epgtimeshift_val = epgtimeshift_selector.val();
    var timeformat_val = timeformat_selector.val();

    jQuery.ajax({
      type:\"POST\",
      url:\"includes/ajax-control.php\",
      dataType:\"text\",
      data:{
      action:'SaveSettings',
      live_player_val:live_player_val,
      movie_player_val:movie_player_val,
      series_player_val:series_player_val,
      epgtimeshift_val:epgtimeshift_val,
      parentenable:parentenable,
      parentmainpassword_val:parentmainpassword_val,
      timeformat_val:timeformat_val
      },  
        success:function(response2){
           \$('#checkingprocess').addClass('hideOnLoad');
           swal({
            text: 'Settings saved',
            button:false,
            icon: 'success'
           });
           setTimeout (function(){
            swal.close();
            location.reload();
           },2000)
           /*\$('#SuccessMessage').animate({'top':'67px'}, 300 );
           setTimeout (function(){
            \$('#SuccessMessage').animate({'top':'-100%'}, 300 );
           },2000)*/
        }
      });  
  }
}   
</script>
  ";
include 'includes/footer.php';

?>