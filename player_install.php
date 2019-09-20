<?php

include_once 'includes/functions.php';
include_once 'configuration.php';
//$checkLicense = webtvpanel_CheckLicense($XClicenseIsval);
/*if ('error' !== $configFileCheck['result'] && 'Active' === $checkLicense['status'] && 'player_install' === $activePage) {
    echo "<script>window.location.href = 'index.php';</script>";
    exit();
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>

<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/scrollbar.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="body-content">
    <div class="overlay"></div>
<script src="js/jquery-1.11.2.min.js"></script> 
<style>
    .hideOnload

    {

        display: none !important;

    }

    .section1 button, .section2 button
    {
        margin-top: 20px;
        background: #73ad88;
        margin-bottom: 20px;
    }
    .section2
    {
        padding-bottom: 20px;
    }
    .custom-formcontrol{

        border: none !important;

        border-bottom: solid 1px #ccc !important;

        border-radius: 0px;

        padding: 25px 10px;

        margin-bottom: 10px;

        box-shadow: none !important;

        -webkit-transition: 0.3s;

        -moz-transition: 0.3s;

        -o-transition: 0.3s;

        transition: 0.3s;

    }

    .custom-formcontrol:focus, .custom-formcontrol{

        border-bottom:solid 2px #212263 !important; 

        -webkit-transition: 0.3s;

        -moz-transition: 0.3s;

        -o-transition: 0.3s;

        transition: 0.3s;

        padding: 25px 10px !important;

    }

    .addborder {

        border: 1px solid red !important;

    }

    .midbox
    {
        word-wrap: break-word;
    }

    .messagePerm
    {
        position: relative;
        left: 0;
        width: 100%;
        text-align: center;
        top: 18%;
        padding-bottom: 20px;
    }
</style>
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container full-container navb-fixid">
        <div class="navbar-header">

        </div>
        <a class="" href="#"><img class="img-responsive" src="img/logo.png" alt="" width="187px"></a>

        <!--/.nav-collapse --> 
    </div>
</nav>
<div class="container-fluid">
    <!-- Login Wrapper -->
    <div class="midbox">
        <h3>Installation Details</h3>
        <!-- <form method=\"POST\" action=\"\" id=\"installation_form\"> -->
<?php
if (in_array('curl', get_loaded_extensions(), true)) {
?>
            <div class="section1">
<div class="messagePerm ";
<?php
    if ('0755' === $configFileCheck['permission'] || '0777' === $configFileCheck['permission']) {
        echo 'hide';
    }

    echo "\"><p class=\"alert alert-warning\">Please Give Permission (777 or 755) to Configuration.php to start installation.</p><center><a href=\"player_install.php\" class=\"btn btn-info\">Reload</a></center></div>

                <div class=\"row ";
    if ('0755' === $configFileCheck['permission'] || '0777' === $configFileCheck['permission']) {
        echo '';
    } else {
        echo 'hide';
    }

    echo "\">";
	?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <input type="text" id="HostUrl" name="HostUrl" class="form-control custom-formcontrol" placeholder="Server URL: Port ( example : http://yourdns.com:25461)">


                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <center><button type="button" class="btn waves-effect waves-light testURL">TEST URL <i class="fa fa-spin fa-spinner hideOnload" id="checkingprocess"></i><i id="successgprocess" class="hideOnload fa fa-check"></i></button>
                            </center>


                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <input type="text" id="sitetitle" name="sitetitle" class="form-control custom-formcontrol" placeholder="Site Title (optional)">

                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        
                        <form class="uploadlogoForm" method="post" action="" enctype="multipart/form-data">
                        <div class="imageUploader btn btn-info">
                            <p>Upload Image</p>
                            <input type="file" id="imgInp" class="uploadImage" name="logoImage">
                        </div>
                        <img src="" id="logoView">
                        <button type="submit" name="submitImage" class="uploadLogo btn btn-success hideOnload"><i class="fa fa-upload"></i> UPLOAD <i class="fa fa-spinner fa-spin hideOnload"></i></button>
                    </form>
                    <input type="text" id="logoLink" name="logoLink" class="form-control custom-formcontrol" placeholder="Logo Link Will be automatically genarated">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <input type="text" id="licenseIs" name="licenseIs" class="form-control custom-formcontrol" placeholder="License">

                        <p style="color: #000; text-align: center;">How to get the license key? 

                            <a href="https://www.whmcssmarters.com/clients/index.php?rp=/knowledgebase/63/How-to-get-the-license-key.html" target="_blank">Click here</a>

                        </p>

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <input type="text" id="copyrighttext" name="copyrighttext" class="form-control custom-formcontrol" placeholder="Copy Right Text  (optional)">

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <input type="text" id="contactUslink" name="contactUslink" class="form-control custom-formcontrol" placeholder="Contact Us Link (optional)">

                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <input type="text" id="helpLink" name="helpLink" class="form-control custom-formcontrol" placeholder="Help Link (optional)">

                    </div>









                    <!-- <button class="btn waves-effect waves-light" id="BackButton" type="button"  style="float: left;">

                        <i class="fas fa-arrow-left"></i>  

                        Back

                    </button>  -->

                    <center><button class="btn waves-effect waves-light" id="offlinedatabtn" type="button">

                        INSTALL

                        <i class="fa fa-spin fa-spinner hideOnload" id="installIcon"></i>

                    </button></center>

                    <input type="hidden" name="install_configuration" value="yes">

                </div>

            </div>

        <!-- </form> -->
        <div id="InstallationDone" style="color: green;" class="hideOnload">
            <center><img src="images/done.gif" width="100px"></center>
            <p style="text-align: center;font-weight: bold;font-size: 25px;">Installation completed</p> 

            <b>Security ! </b>

            <br> 

            <br> 

            1. Please remove the player_install.php file from your server. 

            <br>   

            <br>   

            You should now delete the  player_install.php file from your web server

            <br>   

            <b>File Path : ";
    echo __DIR__;
    echo "/player_install.php</b>

            <br>

            <br>

            <br>  

            2. Permission 

            <br>   

            <br>   

            We recommend you to change the permission of your configuration file to 0644

            <br>

            <b>File Path : ";
    echo __DIR__;
    echo "/configuration.php</b>  

            <br>

            <br>

            <center><a href="index.php" class="btn btn-primary">Client Area</a></center>
            <br />

        </div>
        <div class="message hideOnload" style="position: fixed; top: 10%; z-index: 999; width: 50%; text-align: center; left: 25%;"></div>
    </div>
<?php
} else {
    echo '
	<div class="message hideOnload" style="position: fixed; top: 10%; z-index: 999; width: 50%; text-align: center; left: 25%;">CURL is not available on your web server</div>';
}

echo "    <!-- /Login Wrapper -->
</div>
<script>
    \$(document).ready(function () {
        var nextBtn = \$('#NextButton');
        var backBtn = \$('#BackButton');
        var installBtn = \$('#offlinedatabtn');

        var section1 = \$('.section1');
        var section2 = \$('.section2');

        var message = \$('.message');


        nextBtn.click(function (e) {
            message.addClass('hideOnload');
            var xcdhost = \$('#xcdhost');
            var xcdport = \$('#xcdport');
            var xcdbname = \$('#xcdbname');
            var xcdbusername = \$('#xcdbusername');
            var xcdbpassword = \$('#xcdbpassword');
            var xcdhostval = xcdhost.val();
            var xcdportval = xcdport.val();
            var xcdbnameval = xcdbname.val();
            var xcdbusernameval = xcdbusername.val();
            var xcdbpasswordval = xcdbpassword.val();
            var uname = \$(\"#uname\");
            var upass = \$(\"#upass\");
            var HostUrl = \$(\"#HostUrl\");
            var credentialsError = \$(\"#credentialsError\");
            var correctcredentails = \$(\"#correctcredentails\");
            var CategoryError = \$(\"#CategoryError\");
            var CategoryImported = \$(\"#CategoryImported\");
            var ChannelsError = \$(\"#ChannelsError\");
            var ChannelsImported = \$(\"#ChannelsImported\");
            var EpgsError = \$(\"#EpgsError\");
            var EpgsImported = \$(\"#EpgsImported\");
            var CategoryImporting = \$(\"#CategoryImporting\");
            var ChannelsImporting = \$(\"#ChannelsImporting\");
            var EpgsImporting = \$(\"#EpgsImporting\");
            var InstallationError = \$(\"#InstallationError\");
            var InstallationDone = \$(\"#InstallationDone\");
            var unameVal = uname.val();
            var upassVal = upass.val();
            var HostUrlVal = HostUrl.val();
            \$('.addborder').removeClass('addborder');
            credentialsError.addClass('hideOnload');
            correctcredentails.addClass('hideOnload');
            CategoryError.addClass('hideOnload');
            CategoryImported.addClass('hideOnload');
            ChannelsError.addClass('hideOnload');
            ChannelsImported.addClass('hideOnload');
            EpgsError.addClass('hideOnload');
            EpgsImported.addClass('hideOnload');
            CategoryImporting.addClass('hideOnload');
            ChannelsImporting.addClass('hideOnload');
            EpgsImporting.addClass('hideOnload');
            InstallationError.addClass('hideOnload');
            InstallationDone.addClass('hideOnload');
            e.preventDefault();
            if (unameVal != \"\" && upassVal != \"\" && HostUrlVal != \"\")
            {
                \$('#nextbtn2icon').removeClass('fa-arrow-right');
                \$('#nextbtn2icon').addClass('fa-spinner fa-spin');
                jQuery.ajax({
                    type: \"POST\",
                    url: \"includes/ajax-control.php\",
                    dataType: \"text\",
                    data: {
                        action: 'StreamDetailsCheck',
                        unameVal: unameVal,
                        upassVal: upassVal,
                        HostUrlVal: HostUrlVal
                    },
                    success: function (response2) {
                        \$('#nextbtn2icon').addClass('fa-arrow-right');
                        \$('#nextbtn2icon').removeClass('fa-spinner fa-spin');
                        if (response2 != 0)
                        {
                            section1.addClass('hideOnload');
                            section2.removeClass('hideOnload');
                        } else
                        {
                            \$(\"html, body\").animate({scrollTop: 0}, \"slow\");
                            message.html('<p class=\"text-center alert alert-warning\">Wrong stream line details.</p>');
                            message.removeClass('hideOnload');

                        }

                    }

                });

            } else

            {

                if (unameVal == \"\")

                {

                    uname.addClass('addborder');

                }

                if (upassVal == \"\")

                {

                    upass.addClass('addborder');

                }

                if (HostUrlVal == \"\")

                {

                    HostUrl.addClass('addborder');

                }

            }

        });
        backBtn.click(function (e) {
            e.preventDefault();
            section2.addClass('hideOnload');
            section1.removeClass('hideOnload');
            message.addClass('hideOnload');
        })
        installBtn.click(function (e) {
           /* \$(\"html, body\").animate({scrollTop: 0}, \"slow\");
            message.removeClass('hideOnload');
            message.html('<h2 class=\"text-center alert alert-info\">INSTALLING...</h2>');*/
            \$('#offlinedatabtn i').show();
            e.preventDefault();





           // var uname = \$(\"#uname\");

            //var upass = \$(\"#upass\");

            var HostUrl = \$(\"#HostUrl\");

            var credentialsError = \$(\"#credentialsError\");

            var correctcredentails = \$(\"#correctcredentails\");

            var CategoryError = \$(\"#CategoryError\");

            var CategoryImported = \$(\"#CategoryImported\");

            var ChannelsError = \$(\"#ChannelsError\");

            var ChannelsImported = \$(\"#ChannelsImported\");

            var EpgsError = \$(\"#EpgsError\");

            var EpgsImported = \$(\"#EpgsImported\");

            var CategoryImporting = \$(\"#CategoryImporting\");

            var ChannelsImporting = \$(\"#ChannelsImporting\");

            var EpgsImporting = \$(\"#EpgsImporting\");







            var InstallationError = \$(\"#InstallationError\");

            var InstallationDone = \$(\"#InstallationDone\");



            var logoLink = \$('#logoLink');

            var copyrighttext = \$('#copyrighttext');

            var contactUslink = \$('#contactUslink');

            var helpLink = \$('#helpLink');

            var licenseIs = \$('#licenseIs');

            var sitetitle = \$('#sitetitle');



            var logoLinkval = logoLink.val();

            var copyrighttextval = copyrighttext.val();

            var contactUslinkval = contactUslink.val();

            var helpLinkval = helpLink.val();

            var licenseIsval = licenseIs.val();

            var sitetitleval = sitetitle.val();







           // var unameVal = uname.val();

           // var upassVal = upass.val();

            var HostUrlVal = HostUrl.val();

            \$('.addborder').removeClass('addborder');

            credentialsError.addClass('hideOnload');

            correctcredentails.addClass('hideOnload');

            CategoryError.addClass('hideOnload');

            CategoryImported.addClass('hideOnload');

            ChannelsError.addClass('hideOnload');

            ChannelsImported.addClass('hideOnload');

            EpgsError.addClass('hideOnload');

            EpgsImported.addClass('hideOnload');



            CategoryImporting.addClass('hideOnload');

            ChannelsImporting.addClass('hideOnload');

            EpgsImporting.addClass('hideOnload');

            InstallationError.addClass('hideOnload');

            InstallationDone.addClass('hideOnload');

            e.preventDefault();

            if (logoLinkval != \"\" && licenseIsval != \"\" && HostUrlVal != \"\")

            {

                \$('#installIcon').removeClass('hideOnload');
                \$('#BackButton, #offlinedatabtn, .custom-formcontrol').attr('disabled', true);
                jQuery.ajax({
                    type: \"POST\",
                    url: \"includes/ajax-control.php\",
                    dataType: \"text\",
                    data: {
                        action: 'CheckLicense',
                        licenseIsval: licenseIsval
                    },
                    success: function (response2) {
                        var CheckStatusLicenseResponse = jQuery.parseJSON(response2);
                        if (CheckStatusLicenseResponse.status == \"Active\")
                        {
                            var LocalKey = CheckStatusLicenseResponse.localkey;
                            jQuery.ajax({
                                type: \"POST\",
                                url: \"includes/ajax-control.php\",
                                dataType: \"text\",
                                data: {
                                    action: 'installation',
                                    //unameVal: unameVal,
                                    //upassVal: upassVal,
                                    HostUrlVal: HostUrlVal,
                                    logoLinkval: logoLinkval,
                                    copyrighttextval: copyrighttextval,
                                    contactUslinkval: contactUslinkval,
                                    helpLinkval: helpLinkval,
                                    sitetitleval: sitetitleval,
                                    licenseIsval: licenseIsval,
                                    LocalKey: LocalKey
                                },
                                success: function (response2) {
                                    \$('#installIcon').addClass('hideOnload');
                                    \$('#BackButton, #offlinedatabtn, .custom-formcontrol').attr('disabled', false);
                                    section1.addClass('hideOnload');
                                    section2.addClass('hideOnload');
                                    //section3.addClass('hideOnload');
                                    var obj = jQuery.parseJSON(response2);
                                    if (obj.result == \"yes\")
                                    {
                                        InstallationDone.removeClass('hideOnload');
                                        message.addClass('hideOnload');
                                        \$('.midbox').css('background','url(\"\"), #fff');
                                        \$('.midbox h3').text('Installation Completed').css('color','#000');


                                    } 
                                    else
                                    {
                                        var ErrorTextIs = \"Error! database details are incorrect\";
                                        var Section = \"1\";
                                        if (obj.cause == \"StreamLineDetalsError\")
                                        {
                                            ErrorTextIs = \"Error! stream lines details are incorrect\";
                                            Section = \"1\";
                                        }
                                        \$('#ErrorText').text(ErrorTextIs);
                                        \$('#checkAgainButton').data('Opentab', Section);
                                        InstallationError.removeClass('hideOnload');
                                    }
                                }
                            });
                        } else

                        {   
                            \$('#BackButton, #offlinedatabtn, .custom-formcontrol').attr('disabled', false);
                            \$('#offlinedatabtn i').hide();
                           \$(\"html, body\").animate({scrollTop: 0}, \"slow\");
                            message.html('<p class=\"text-center alert alert-warning\">' + CheckStatusLicenseResponse.status +' License</p>');
                            message.removeClass('hideOnload');
                        }



                    }

                });

            } else

            {

                if (logoLinkval == \"\")
                {
                    logoLink.addClass('addborder');
                }
                if (licenseIsval == \"\")
                {
                    licenseIs.addClass('addborder');
                }
                if (HostUrlVal == \"\")
                {
                    HostUrl.addClass('addborder');
                }

            }




        });

function readURL(input) {

  if (input.files && input.files[0]) {
    if (input.files && input.files[0] && input.files[0].name.match(/\\.(jpg|jpeg|png|gif)\$/) ) {

    var reader = new FileReader();

    reader.onload = function(e) {
      \$('#logoView').attr('src', e.target.result);
      \$('.uploadLogo').removeClass('hideOnload');
    }

    reader.readAsDataURL(input.files[0]);
}
else
  {
    \$('#imgInp').val('');
    \$('#logoView').attr('src','');
    swal({title:'Error!',text: 'Uploaded file is not Image. Please Upload Image only.', button: false, icon:'warning'});
    setTimeout(function(){swal.close()},2000)
  }
  }

}

\$('form').submit(function(e){
    e.preventDefault();
    \$('.uploadLogo .fa-spin').removeClass('hideOnload');
    var formData = new FormData(\$(this)[0]);
    jQuery.ajax({
                 type:\"POST\",
                 url:'includes/ajax-control.php',
                 processData:false,
                 contentType:false,
                 data:formData,
               success:function(response){
               \$('.uploadLogo .fa-spin').addClass('hideOnload');
                    if(response !== 'errorImage')
                    {
                        \$('#logoLink').val(response);
                        swal('Image Uploaded successfully.',{button: false, icon:'success'});
                        setTimeout(function(){swal.close();},2000)
                    }
                    else
                    {
                        swal('Image Upload Error oocured! Please try again.',{button: false});
                        setTimeout(function(){swal.close();},2000)
                    }
               }
           })

})

\$(\"#imgInp\").change(function() {
  readURL(this);
});

        \$('#HostUrl').change(function(){
          \$('#successgprocess').addClass('hideOnload');
          //\$('#offlinedatabtn').attr('disabled', true);
        })
        \$('.testURL').click(function(e){
            e.preventDefault();
            \$('#successgprocess').addClass('hideOnload');
            \$('.addborder').removeClass('addborder');
            var HostUrl = \$(\"#HostUrl\");
            var HostUrlVal = HostUrl.val();
            if(HostUrlVal != \"\")
            {
                \$('#checkingprocess').removeClass('hideOnload');
                jQuery.ajax({
                    type:\"POST\",
                    url:\"includes/ajax-control.php\",
                    dataType:\"text\",
                    data:{
                    action:'CheckSerVerUrl',
                    HostUrlVal:HostUrlVal
                    },  
                    success:function(response2){ 
                      \$('#checkingprocess').addClass('hideOnload'); 
                      var str1 = response2;
                      var str2 = \"Access Denied\";
                      if(str1.indexOf(str2) != -1){
                        \$('#successgprocess').removeClass('hideOnload');
                        //\$('#offlinedatabtn').attr('disabled', false);
                      }
                      else
                      {
                        alert(\"It seems your portal is not valid. but if you are sure then can ignore and continue the installation\");
                      }
                    }
                  });
            }
            else
            {
                HostUrl.addClass('addborder');
            }
            });

    })
</script>
";
include 'includes/footer.php';

?>