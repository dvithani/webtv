<?php

session_start();
if (file_exists('functions.php')) {
    include_once 'functions.php';
    if (isset($_FILES['logoImage'])) {
        $target_dir = '../images/';
        $target_file = $target_dir.basename($_FILES['logoImage']['name']);
        if (move_uploaded_file($_FILES['logoImage']['tmp_name'], $target_file)) {
            echo 'images/'.$_FILES['logoImage']['name'];
            exit();
        }

        echo 'errorImage';
        exit();
    }

    if (isset($_POST['action']) && 'SaveSortSettings' === $_POST['action']) {
        setcookie($_SESSION['webTvplayer']['username'].'_'.$_POST['SortIN'], $_POST['selectedVal'], time() + 2 * 7 * 24 * 60 * 60, '/', $_SERVER['SERVER_NAME'], false);
        exit();
    }

    if (isset($_POST['action']) && 'SaveSettings' === $_POST['action']) {
        $CookieArray[$_SESSION['webTvplayer']['username']] = ['live_player' => $_POST['live_player_val'], 'movie_player' => $_POST['movie_player_val'], 'series_player' => $_POST['series_player_val'], 'epgtimeshift' => $_POST['epgtimeshift_val'], 'timeformat' => $_POST['timeformat_val'], 'parentenable' => $_POST['parentenable'], 'parentpassword' => webtvpanel_baseEncode($_POST['parentmainpassword_val']), 'primaryColor' => $_POST['primaryColor'], 'secondryColor' => $_POST['secondryColor']];
        $CookieArray = json_encode($CookieArray);
        setcookie('settings_array', $CookieArray, time() + 2 * 7 * 24 * 60 * 60, '/', $_SERVER['SERVER_NAME'], false);
        echo '0';
        exit();
    }

    if (isset($_POST['action']) && 'confirm_parentpassword' === $_POST['action']) {
        $ReturnData = 1;
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

        $parentPass = $_POST['parentPass'];
        if (webtvpanel_baseDecode($parentpassword) !== $parentPass) {
            $ReturnData = 0;
        }

        echo $ReturnData;
        exit();
    }

    if (isset($_POST['action']) && 'StreamDetailsCheck' === $_POST['action']) {
        $returnData = 0;
        $StreamLineUsername = $_POST['unameVal'];
        $StreamLinePassword = $_POST['upassVal'];
        $StreamLineHostUrlVal = $_POST['HostUrlVal'];
        $CheckStreamDetails = webtvpanel_CheckstreamLine($StreamLineUsername, $StreamLinePassword, $StreamLineHostUrlVal);
        echo $CheckStreamDetails;
        exit();
    }

    if (isset($_POST['action']) && 'CheckLicense' === $_POST['action']) {
        $license = $_POST['licenseIsval'];
        $LicenseResponse = webtvpanel_CheckLicense($license);
        echo json_encode($LicenseResponse);
        exit();
    }

    if (isset($_POST['action']) && 'installation' === $_POST['action']) {
        $response['result'] = 'no';
        $content = "<?php \n";
        $content .= '$XCStreamHostUrl = "'.$_POST['HostUrlVal'].'";'."\n";
        $content .= '$XClogoLinkval = "'.$_POST['logoLinkval'].'";'."\n";
        $content .= '$XCcopyrighttextval = "'.$_POST['copyrighttextval'].'";'."\n";
        $content .= '$XCcontactUslinkval = "'.$_POST['contactUslinkval'].'";'."\n";
        $content .= '$XChelpLinkval = "'.$_POST['helpLinkval'].'";'."\n";
        $content .= '$XClicenseIsval = "'.$_POST['licenseIsval'].'";'."\n";
        $content .= '$XClocalKey = "'.$_POST['LocalKey'].'";'."\n";
        $content .= '$XCsitetitleval = "'.$_POST['sitetitleval'].'";'."\n";
        $content .= '?>';
        if (file_exists('../configuration.php')) {
            unlink('../configuration.php');
        }

        $fp = fopen('../configuration.php', 'w');
        fwrite($fp, $content);
        fclose($fp);
        chmod('../configuration.php', 511);
        if (file_exists('../configuration.php')) {
            $response['result'] = 'yes';
        }

        echo json_encode($response);
        exit();
    }

    if (isset($_POST['action']) && 'webtvlogin' === $_POST['action']) {
        include_once '../configuration.php';
        $bar = '/';
        if ('/' === substr($XCStreamHostUrl, -1)) {
            $bar = '';
        }

        $XCStreamHostUrl = $XCStreamHostUrl.$bar;
        $UserName = $_POST['uname'];
        $UserPassword = $_POST['upass'];
        $rememberMe = $_POST['rememberMe'];
        $returnData = [];
        $ApiLinkIs = $XCStreamHostUrl.'player_api.php?username='.$UserName.'&password='.$UserPassword;
        $checkLogin = webtvpanel_CallApiRequest($ApiLinkIs);
        $CateGoriesArray = [];
        $Catechanneldata = [];
        $Result = $checkLogin;
        if ('success' === $Result['result']) {
            if (isset($Result['data']->user_info->auth)) {
                if (0 !== $Result['data']->user_info->auth) {
                    if ('Active' === $Result['data']->user_info->status) {
                        if ('on' === $rememberMe) {
                            setcookie('username', $UserName, time() + 2 * 7 * 24 * 60 * 60, '/', $_SERVER['SERVER_NAME'], false);
                            setcookie('userpassword', base64_encode($UserPassword), time() + 2 * 7 * 24 * 60 * 60, '/', $_SERVER['SERVER_NAME'], false);
                        }

                        $SessionArray = ['username' => $Result['data']->user_info->username, 'password' => $Result['data']->user_info->password, 'auth' => $Result['data']->user_info->auth, 'status' => $Result['data']->user_info->status, 'exp_date' => $Result['data']->user_info->exp_date, 'active_cons' => $Result['data']->user_info->active_cons, 'is_trial' => $Result['data']->user_info->is_trial, 'max_connections' => $Result['data']->user_info->max_connections, 'created_at' => $Result['data']->user_info->created_at, 'allowed_output_formats' => $Result['data']->user_info->allowed_output_formats, 'url' => $Result['data']->server_info->url, 'port' => $Result['data']->server_info->port, 'rtmp_port' => $Result['data']->server_info->rtmp_port, 'timezone' => $Result['data']->server_info->timezone];
                        $_SESSION['webTvplayer'] = $SessionArray;
                        $returnData = ['result' => 'success', 'message' => $SessionArray];
                    } else {
                        $returnData = ['result' => 'error', 'message' => 'Status is '.$Result['data']->user_info->status];
                    }
                } else {
                    $returnData = ['result' => 'error', 'message' => 'Invalid Details'];
                }
            } else {
                $returnData = ['result' => 'error', 'message' => 'Invalid Details'];
            }
        } else {
            $returnData = ['result' => 'error', 'message' => $Result['data']];
        }

        echo json_encode($returnData);
    }

    if (isset($_POST['action']) && 'CheckLicense' === $_POST['action']) {
        $ReturnData = 0;
        $license = $_POST['licenseIsval'];
        $LicenseResponse = livestreaming_CheckLicense($license);
        echo json_encode($LicenseResponse);
        exit();
    }

    if (isset($_POST['action']) && 'logoutProcess' === $_POST['action']) {
        unset($_SESSION['webTvplayer']);
        session_destroy();
    }

    if (isset($_POST['action']) && 'CheckSerVerUrl' === $_POST['action']) {
        $ApiLinkIs = $_POST['HostUrlVal'];
        $http = curl_init($ApiLinkIs);
        curl_setopt($http, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($http, CURLOPT_SSL_VERIFYHOST, 0);
        $result = curl_exec($http);
        $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
        curl_close($http);
        echo $http_status;
        exit();
    }

    if (isset($_POST['action']) && 'getMoviesDataFromCategoryId' === $_POST['action']) {
        $counter = 0;
        $hostURL = $_POST['hostURL'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $dataoffset = (isset($_POST['dataoffset']) ? $_POST['dataoffset'] : 0);
        $datalimit = (isset($_POST['datalimit']) ? $_POST['datalimit'] : 28);
        $bar = '/';
        if ('/' === substr($hostURL, -1)) {
            $bar = '';
        }

        $ApiLink = $hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_vod_streams&category_id='.$_POST['categoryID'];
        $ApiData = webtvpanel_CallApiRequest($ApiLink);
        if ('success' === $ApiData['result']) {
            $MoviesSortingType = (isset($_COOKIE[$_SESSION['webTvplayer']['username'].'_movies']) && !empty($_COOKIE[$_SESSION['webTvplayer']['username'].'_movies']) ? $_COOKIE[$_SESSION['webTvplayer']['username'].'_movies'] : 'default');
            if ('default' !== $MoviesSortingType) {
                $Arrayforsorting = [];
                foreach ($ApiData['data'] as $StreamData) {
                    $Arrayforsorting[('topadded' === $MoviesSortingType ? $StreamData->added : $StreamData->name)] = (object) ['num' => $StreamData->num, 'name' => $StreamData->name, 'stream_type' => $StreamData->stream_type, 'stream_id' => $StreamData->stream_id, 'stream_icon' => $StreamData->stream_icon, 'rating' => $StreamData->rating, 'rating_5based' => $StreamData->rating_5based, 'added' => $StreamData->added, 'category_id' => $StreamData->category_id, 'container_extension' => $StreamData->container_extension, 'custom_sid' => $StreamData->custom_sid, 'direct_source' => $StreamData->direct_source];
                }
                array_multisort(array_keys($Arrayforsorting), SORT_NATURAL | SORT_FLAG_CASE, $Arrayforsorting);
                if ('desc' === $MoviesSortingType) {
                    $Arrayforsorting = array_reverse($Arrayforsorting, false);
                }

                $ApiData['data'] = $Arrayforsorting;
            }

            $TotalResultFound = count($ApiData['data']);
            foreach ($ApiData['data'] as $data) {
                $Icon = $data->stream_icon;
                if ('' === $Icon) {
                    $Icon = '';
                }

                ++$counter;
                if ($dataoffset <= $counter && $counter <= $datalimit) {
                    $QuersyData = 'moviename='.$data->name.'&StreamId='.$data->stream_id.'&CateGoryId='.$data->category_id.'&posterImage='.$Icon.'&extension='.$data->container_extension.'&rating5='.$data->rating_5based;
                    echo "				<li class=\"thumb-b animate streamList rippler rippler-default sectionNo";
                    echo $data->stream_id;
                    echo ' un-';
                    echo $counter;
                    echo "\" onclick=\"showInfo('";
                    echo $data->stream_id;
                    echo "')\" data-streamID=\"";
                    echo $data->stream_id;
                    echo "\">
					<input type=\"hidden\" class=\"serch_key\" value=\"";
                    echo $data->name;
                    echo '" data-parentliclass="sectionNo';
                    echo $data->stream_id;
                    echo "\">

					<input type=\"hidden\" id=\"fullData-";
                    echo $data->stream_id;
                    echo '" value="';
                    echo webtvpanel_baseEncode($QuersyData);
                    echo "\">
					<!-- <h2 class=\"WihthoutZoom \">";
                    echo $data->name;
                    echo "</h2> -->
					<div class=\"view view-tenth rippler rippler-default\"><img class=\"iconImage rippler rippler-img rippler-bs-primary\" src=\"";
                    echo $Icon;
                    echo "\" alt=\"\" onerror=\"this.src='images/no-poster.jpg';this.parentElement.className='view view-tenth showEI ';\" >
						<div class=\"mask \">
			<h2 >";
                    echo $data->name;
                    echo "</h2>
							<!-- <div class=\"fav\"> <a href=\"#\"><span class=\"fa fa-heart-o fa-heart\"></span></a> <span>";
                    echo $data->rating_5based;
                    echo "</span> </div> -->
							<div class=\"n-ratting\"> 
			";
                    $ratingData = $data->rating_5based;
                    $rating = webtvpanel_starRating($ratingData);
                    echo "
							<!-- <span class=\"fa fa-star\"></span> <span class=\"fa fa-star\"></span> <span class=\"fa fa-star\"></span> <span class=\"fa fa-star\"></span> <span class=\"fa fa-star-o\"></span> --> </div>
						</div>
					</div>
				</li>
				
			";
                }
            }
            if ($datalimit < $counter) {
                echo "			<center class=\"loading-loadBtn\">
				<button class=\"LoadMoreBtn btn btn-success rippler rippler-default\" data-dataoffset=\"";
                echo $datalimit;
                echo '" data-categoryID="';
                echo $_POST['categoryID'];
                echo "\">Load More <i class=\"LoadingMoreFa fa fa-spin fa-spinner hideOnload\"></i></button>
			</center>
			";
            }

            exit();
        }

        echo '0';
        exit();
    }

    if (isset($_POST['action']) && 'GetSeriesByCateGoryId' === $_POST['action']) {
        $CateGoryId = $_POST['categoryID'];
        $counter = 0;
        $hostURL = $_POST['hostURL'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $dataoffset = (isset($_POST['dataoffset']) ? $_POST['dataoffset'] : 0);
        $datalimit = (isset($_POST['datalimit']) ? $_POST['datalimit'] : 28);
        $bar = '/';
        if ('/' === substr($hostURL, -1)) {
            $bar = '';
        }

        $ApiLink = $hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_series';
        if ('all' !== $CateGoryId) {
            $ApiLink = $hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_series&category_id='.$CateGoryId;
        }

        $ApiData = webtvpanel_CallApiRequest($ApiLink);
        if ('success' === $ApiData['result']) {
            $SortingType = (isset($_COOKIE[$_SESSION['webTvplayer']['username'].'_series']) && !empty($_COOKIE[$_SESSION['webTvplayer']['username'].'_series']) ? $_COOKIE[$_SESSION['webTvplayer']['username'].'_series'] : 'default');
            if ('default' !== $SortingType) {
                $Arrayforsorting = [];
                foreach ($ApiData['data'] as $StreamData) {
                    $BackdropArray = [];
                    if (!empty($StreamData->backdrop_path)) {
                        foreach ($StreamData->backdrop_path as $backVal) {
                            $BackdropArray[] = $backVal;
                        }
                    }

                    $Arrayforsorting[('topadded' === $SortingType ? $StreamData->last_modified : $StreamData->name)] = (object) ['num' => $StreamData->num, 'name' => $StreamData->name, 'stream_type' => $StreamData->stream_type, 'series_id' => $StreamData->series_id, 'cover' => $StreamData->cover, 'plot' => $StreamData->plot, 'cast' => $StreamData->cast, 'director' => $StreamData->director, 'genre' => $StreamData->genre, 'releaseDate' => $StreamData->releaseDate, 'last_modified' => $StreamData->last_modified, 'rating' => $StreamData->rating, 'rating_5based' => $StreamData->rating_5based, 'backdrop_path' => $BackdropArray, 'youtube_trailer' => $StreamData->youtube_trailer, 'episode_run_time' => $StreamData->episode_run_time, 'category_id' => $StreamData->category_id, 'rating' => $StreamData->rating];
                }
                array_multisort(array_keys($Arrayforsorting), SORT_NATURAL | SORT_FLAG_CASE, $Arrayforsorting);
                if ('desc' === $SortingType) {
                    $Arrayforsorting = array_reverse($Arrayforsorting, false);
                }

                $ApiData['data'] = $Arrayforsorting;
            }

            foreach ($ApiData['data'] as $SeriesData) {
                $Icon = $SeriesData->cover;
                if ('' === $Icon) {
                    $Icon = '';
                }

                ++$counter;
                if ($dataoffset <= $counter && $counter <= $datalimit) {
                    $QuersyData = 'moviename='.$SeriesData->name.'&StreamId='.$SeriesData->series_id.'&CateGoryId='.$CateGoryId.'&posterImage='.$Icon.'&plot='.$SeriesData->plot.'&cast='.$SeriesData->cast.'&genre='.$SeriesData->genre.'&director='.$SeriesData->director.'&rating='.$SeriesData->rating.'&releaseDate='.$SeriesData->releaseDate;
                    echo "				<li class=\"thumb-b animate streamList rippler rippler-default sectionNo";
                    echo $SeriesData->series_id;
                    echo ' un-';
                    echo $counter;
                    echo "\"  onclick=\"showInfo('";
                    echo $SeriesData->series_id;
                    echo "')\">
				<input type=\"hidden\" id=\"fullData-";
                    echo $SeriesData->series_id;
                    echo '" value="';
                    echo webtvpanel_baseEncode($QuersyData);
                    echo "\">
					<input type=\"hidden\" class=\"serch_key\" value=\"";
                    echo $SeriesData->name;
                    echo '" data-parentliclass="sectionNo';
                    echo $SeriesData->series_id;
                    echo "\">
				<div class=\"view view-tenth rippler rippler-default\"><img class=\"iconImage\" src=\"";
                    echo $Icon;
                    echo "\" onerror=\"this.src='images/no-poster.jpg';this.parentElement.className='view view-tenth showEI ';\">
				  <div class=\"mask\">
				    <h2>";
                    echo $SeriesData->name;
                    echo "</h2>
				    <!-- <div class=\"fav\"> <a href=\"#\"><span class=\"fa fa-heart-o fa-heart\"></span></a> <span>2016</span> </div> -->
				    <div class=\"n-ratting\">
				    	";
                    $RatingIs = 0;
                    if (isset($SeriesData->rating_5based) && !empty($SeriesData->rating_5based)) {
                        $RatingIs = $SeriesData->rating_5based;
                    } else {
                        $RatingIs = $SeriesData->rating / 2;
                    }

                    echo webtvpanel_starRating($RatingIs);
                    echo "				    </div>
				  </div>
				</div>
				</li>
    		";
                }
            }
            if ($datalimit < $counter) {
                echo "			<center class=\"loading-loadBtn\">
				<button class=\"LoadMoreBtn btn btn-success rippler rippler-default\" data-dataoffset=\"";
                echo $datalimit;
                echo '" data-categoryID="';
                echo $_POST['categoryID'];
                echo "\">Load More <i class=\"LoadingMoreFa fa fa-spin fa-spinner hideOnload\"></i></button>
			</center>
			";
            }

            exit();
        }

        echo '0';
        exit();
    }

    if (isset($_POST['action']) && 'getStreamsFromID' === $_POST['action']) {
        $counter = 0;
        $hostURL = $_POST['hostURL'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $bar = '/';
        if ('/' === substr($hostURL, -1)) {
            $bar = '';
        }

        $ApiLink = $hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_live_streams&category_id='.$_POST['categoryID'];
        $StreamData = webtvpanel_CallApiRequest($ApiLink);
        if ('success' === $StreamData['result']) {
            $SortingType = (isset($_COOKIE[$_SESSION['webTvplayer']['username'].'_live']) && !empty($_COOKIE[$_SESSION['webTvplayer']['username'].'_live']) ? $_COOKIE[$_SESSION['webTvplayer']['username'].'_live'] : 'default');
            if ('default' !== $SortingType) {
                $Arrayforsorting = [];
                foreach ($StreamData['data'] as $StreamKeyIS) {
                    $BackdropArray = [];
                    if (!empty($StreamKeyIS->backdrop_path)) {
                        foreach ($StreamKeyIS->backdrop_path as $backVal) {
                            $BackdropArray[] = $backVal;
                        }
                    }

                    $Arrayforsorting[('topadded' === $SortingType ? $StreamKeyIS->added : $StreamKeyIS->name)] = (object) ['num' => $StreamKeyIS->num, 'name' => $StreamKeyIS->name, 'stream_type' => $StreamKeyIS->stream_type, 'stream_id' => $StreamKeyIS->stream_id, 'stream_icon' => $StreamKeyIS->stream_icon, 'epg_channel_id' => $StreamKeyIS->epg_channel_id, 'added' => $StreamKeyIS->added, 'category_id' => $StreamKeyIS->category_id, 'custom_sid' => $StreamKeyIS->custom_sid, 'tv_archive' => $StreamKeyIS->tv_archive, 'direct_source' => $StreamKeyIS->direct_source, 'tv_archive_duration' => $StreamKeyIS->tv_archive_duration];
                }
                array_multisort(array_keys($Arrayforsorting), SORT_NATURAL | SORT_FLAG_CASE, $Arrayforsorting);
                if ('desc' === $SortingType) {
                    $Arrayforsorting = array_reverse($Arrayforsorting, false);
                }

                $StreamData['data'] = $Arrayforsorting;
            }

            foreach ($StreamData['data'] as $chanel) {
                $chanelIcon = $chanel->stream_icon;
                if ('' === $chanelIcon) {
                    $chanelIcon = 'images/no_logo.jpg';
                }

                ++$counter;
                echo "		<li id=\"video";
                echo $counter;
                echo '" class="streamList Playclick rippler rippler-inverse sectionNo';
                echo $chanel->stream_id;
                echo "\">
			<input type=\"hidden\" class=\"streamId\" data-streamtype=\"";
                echo $chanel->stream_type;
                echo '" value="';
                echo $chanel->stream_id;
                echo "\">
				<span style=\"font-weight: bold;width: 50px;text-align: center;padding-top: 8px;\">";
                echo $chanel->num;
                echo "</span>
                <span class=\"number\"><img src=\"";
                echo $chanel->stream_icon;
                echo "\" width=\"100%\" height=\"30px\" onerror=\"this.src='images/no_logo.jpg'\"></span>
                <!-- <i class=\"fa fa-television\" aria-hidden=\"true\"></i> -->
                <!-- <i class=\"fa fa-star hide\" aria-hidden=\"true\"></i> -->
                
                <input type=\"hidden\" class=\"serch_key\" value=\"";
                echo $chanel->name;
                echo '" data-parentliclass="sectionNo';
                echo $chanel->stream_id;
                echo "\">
                <label>";
                echo $chanel->name;
                echo "</label>
                <i class=\"fa fa-repeat\" aria-hidden=\"true\" style=\"float: right;\"></i>
              </li>
		
		";
            }
            exit();
        }
    }

    if (isset($_POST['action']) && 'getRadioStreamsFromID' === $_POST['action']) {
        $counter = 0;
        $hostURL = $_POST['hostURL'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $bar = '/';
        if ('/' === substr($hostURL, -1)) {
            $bar = '';
        }

        $ApiLink = $hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_live_streams&category_id='.$_POST['categoryID'];
        $StreamData = webtvpanel_CallApiRequest($ApiLink);
        if ('success' === $StreamData['result']) {
            $SortingType = (isset($_COOKIE[$_SESSION['webTvplayer']['username'].'_radio']) && !empty($_COOKIE[$_SESSION['webTvplayer']['username'].'_radio']) ? $_COOKIE[$_SESSION['webTvplayer']['username'].'_radio'] : 'default');
            if ('default' !== $SortingType) {
                $Arrayforsorting = [];
                foreach ($StreamData['data'] as $StreamKeyIS) {
                    if ('radio_streams' === $StreamKeyIS->stream_type) {
                        $Arrayforsorting[('topadded' === $SortingType ? $StreamKeyIS->added : $StreamKeyIS->name)] = (object) ['num' => $StreamKeyIS->num, 'name' => $StreamKeyIS->name, 'stream_type' => $StreamKeyIS->stream_type, 'stream_id' => $StreamKeyIS->stream_id, 'stream_icon' => $StreamKeyIS->stream_icon, 'epg_channel_id' => $StreamKeyIS->epg_channel_id, 'added' => $StreamKeyIS->added, 'category_id' => $StreamKeyIS->category_id, 'custom_sid' => $StreamKeyIS->custom_sid, 'tv_archive' => $StreamKeyIS->tv_archive, 'direct_source' => $StreamKeyIS->direct_source, 'tv_archive_duration' => $StreamKeyIS->tv_archive_duration];
                    }
                }
                array_multisort(array_keys($Arrayforsorting), SORT_NATURAL | SORT_FLAG_CASE, $Arrayforsorting);
                if ('desc' === $SortingType) {
                    $Arrayforsorting = array_reverse($Arrayforsorting, false);
                }

                $StreamData['data'] = $Arrayforsorting;
            } else {
                $Arrayforsorting = [];
                foreach ($StreamData['data'] as $StreamKeyIS) {
                    if ('radio_streams' === $StreamKeyIS->stream_type) {
                        $Arrayforsorting[] = (object) ['num' => $StreamKeyIS->num, 'name' => $StreamKeyIS->name, 'stream_type' => $StreamKeyIS->stream_type, 'stream_id' => $StreamKeyIS->stream_id, 'stream_icon' => $StreamKeyIS->stream_icon, 'epg_channel_id' => $StreamKeyIS->epg_channel_id, 'added' => $StreamKeyIS->added, 'category_id' => $StreamKeyIS->category_id, 'custom_sid' => $StreamKeyIS->custom_sid, 'tv_archive' => $StreamKeyIS->tv_archive, 'direct_source' => $StreamKeyIS->direct_source, 'tv_archive_duration' => $StreamKeyIS->tv_archive_duration];
                    }
                }
                $StreamData['data'] = $Arrayforsorting;
            }

            foreach ($StreamData['data'] as $chanel) {
                $chanelIcon = $chanel->stream_icon;
                if ('' === $chanelIcon) {
                    $chanelIcon = 'images/no_logo.jpg';
                }

                ++$counter;
                echo "		<li id=\"video";
                echo $counter;
                echo '" class="streamList Playclick rippler rippler-inverse sectionNo';
                echo $chanel->stream_id;
                echo "\">
			<input type=\"hidden\" class=\"streamId\" data-streamtype=\"";
                echo $chanel->stream_type;
                echo '" value="';
                echo $chanel->stream_id;
                echo "\">
			<span style=\"font-weight: bold;width: 50px;text-align: center;padding-top: 8px;\">";
                echo $chanel->num;
                echo "</span>
                <span class=\"number\"><img src=\"";
                echo $chanel->stream_icon;
                echo "\" width=\"100%\" height=\"30px\" onerror=\"this.src='images/no_logo.jpg'\"></span>
                <!-- <i class=\"fa fa-television\" aria-hidden=\"true\"></i> -->
                <!-- <i class=\"fa fa-star hide\" aria-hidden=\"true\"></i> -->
                
                <input type=\"hidden\" class=\"serch_key\" value=\"";
                echo $chanel->name;
                echo '" data-parentliclass="sectionNo';
                echo $chanel->stream_id;
                echo "\">
                <label>";
                echo $chanel->name;
                echo "</label>
                <i class=\"fa fa-repeat\" aria-hidden=\"true\" style=\"float: right;\"></i>
              </li>
		
		";
            }
            exit();
        }
    }

    if (isset($_POST['action']) && 'getCaptchStreamsFromID' === $_POST['action']) {
        $counter = 0;
        $hostURL = $_POST['hostURL'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $bar = '/';
        if ('/' === substr($hostURL, -1)) {
            $bar = '';
        }

        $ApiLink = $hostURL.$bar.'player_api.php?username='.$username.'&password='.$password.'&action=get_live_streams&category_id='.$_POST['categoryID'];
        $StreamData = webtvpanel_CallApiRequest($ApiLink);
        $FinalTotalConditional = 0;
        if ('success' === $StreamData['result']) {
            $SortingType = (isset($_COOKIE[$_SESSION['webTvplayer']['username'].'_catchup']) && !empty($_COOKIE[$_SESSION['webTvplayer']['username'].'_catchup']) ? $_COOKIE[$_SESSION['webTvplayer']['username'].'_catchup'] : 'default');
            if ('default' !== $SortingType) {
                $Arrayforsorting = [];
                foreach ($StreamData['data'] as $StreamKeyIS) {
                    $BackdropArray = [];
                    if (!empty($StreamKeyIS->backdrop_path)) {
                        foreach ($StreamKeyIS->backdrop_path as $backVal) {
                            $BackdropArray[] = $backVal;
                        }
                    }

                    $Arrayforsorting[('topadded' === $SortingType ? $StreamKeyIS->added : $StreamKeyIS->name)] = (object) ['num' => $StreamKeyIS->num, 'name' => $StreamKeyIS->name, 'stream_type' => $StreamKeyIS->stream_type, 'stream_id' => $StreamKeyIS->stream_id, 'stream_icon' => $StreamKeyIS->stream_icon, 'epg_channel_id' => $StreamKeyIS->epg_channel_id, 'added' => $StreamKeyIS->added, 'category_id' => $StreamKeyIS->category_id, 'custom_sid' => $StreamKeyIS->custom_sid, 'tv_archive' => $StreamKeyIS->tv_archive, 'direct_source' => $StreamKeyIS->direct_source, 'tv_archive_duration' => $StreamKeyIS->tv_archive_duration];
                }
                array_multisort(array_keys($Arrayforsorting), SORT_NATURAL | SORT_FLAG_CASE, $Arrayforsorting);
                if ('desc' === $SortingType) {
                    $Arrayforsorting = array_reverse($Arrayforsorting, false);
                }

                $StreamData['data'] = $Arrayforsorting;
            }

            foreach ($StreamData['data'] as $chanel) {
                if (1 === $chanel->tv_archive) {
                    $chanelIcon = $chanel->stream_icon;
                    if ('' === $chanelIcon) {
                        $chanelIcon = 'images/no_logo.jpg';
                    }

                    ++$counter;
                    echo "				<li id=\"video";
                    echo $counter;
                    echo '" class="streamList Playclick rippler rippler-default sectionNo';
                    echo $chanel->stream_id;
                    echo "\">
				<input type=\"hidden\" class=\"streamId\" data-streamtype=\"";
                    echo $chanel->stream_type;
                    echo '" value="';
                    echo $chanel->stream_id;
                    echo "\">
				<span style=\"font-weight: bold;width: 50px;text-align: center;padding-top: 8px;\">";
                    echo $chanel->num;
                    echo "</span>
				<span class=\"number\"><img src=\"";
                    echo $chanel->stream_icon;
                    echo "\" width=\"100%\" height=\"30px\" onerror=\"this.src='images/no_logo.jpg'\"></span>
				<!-- <i class=\"fa fa-television\" aria-hidden=\"true\"></i> -->
				<!-- <i class=\"fa fa-star hide\" aria-hidden=\"true\"></i> -->
				<input type=\"hidden\" class=\"serch_key\" value=\"";
                    echo $chanel->name;
                    echo '" data-parentliclass="sectionNo';
                    echo $chanel->stream_id;
                    echo "\">
				<label>";
                    echo $chanel->name;
                    echo "</label>
				<i class=\"fa fa-repeat\" aria-hidden=\"true\" style=\"float: right;\"></i>
				</li>
				";
                    ++$FinalTotalConditional;
                }
            }
            if (0 === $FinalTotalConditional) {
                echo '0';
            }

            exit();
        }
    }

    if (isset($_POST['action']) && 'GetCaptchaByStreamid' === $_POST['action']) {
        $GlobalTimeFormat = '12';
        if (isset($_COOKIE['settings_array'])) {
            $SettingArray = json_decode($_COOKIE['settings_array']);
            if (isset($SettingArray->{$_SESSION['webTvplayer']['username']}) && !empty($SettingArray->{$_SESSION['webTvplayer']['username']})) {
                $GlobalTimeFormat = $SettingArray->{$_SESSION['webTvplayer']['username']}->timeformat;
            }
        }

        $Formatis = 'h:i A';
        if ('24' === $GlobalTimeFormat) {
            $Formatis = 'H:i';
        }

        $CurrentTime = $_POST['CurrentTime'];
        $StreamId = $_POST['StreamId'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $hostURL = $_POST['hostURL'];
        $ApiLink = $hostURL.'player_api.php?username='.$username.'&password='.$password.'&action=get_simple_data_table&stream_id='.$StreamId;
        $RequestForEpg = webtvpanel_CallApiRequest($ApiLink);
        if (!empty($RequestForEpg) && 'success' === $RequestForEpg['result']) {
            $CurrentDate = date('Y:m:d', $CurrentTime);
            if (!empty($RequestForEpg['data']->epg_listings)) {
                $OnlyDates = [];
                foreach ($RequestForEpg['data']->epg_listings as $ResVal) {
                    if (1 === $ResVal->has_archive) {
                        $OnlyDateVar = date('Y:m:d', strtotime($ResVal->start));
                        $ValDate = date('d/m/Y', strtotime($ResVal->start));
                        if ($OnlyDateVar <= $CurrentDate) {
                            $OnlyDates[$OnlyDateVar] = $ValDate;
                        }
                    }
                }
                if (!empty($OnlyDates)) {
                    echo "	    	<div class=\"panel-heading\">	
	    		<ul class=\"nav nav-tabs\">
		    	";
                    $OnlyDates = array_reverse($OnlyDates);
                    $TotalDates = count($OnlyDates);
                    $Counter = 1;
                    foreach ($OnlyDates as $OnlyDate => $Val) {
                        if ($Counter <= 4) {
                            echo "  
	                    <li class=\"";
                            echo 1 === $Counter ? 'active' : '';
                            echo " rippler rippler-default\">
	                    	<a href=\"#TabNo";
                            echo $Counter;
                            echo "\" data-toggle=\"tab\">
	                    		";
                            echo $Val;
                            echo "                    			
	                    	</a>
	                    </li>
		    		";
                        }

                        ++$Counter;
                    }
                    if (4 < $TotalDates) {
                        echo "		    		<li class=\"dropdown\">
	                    <a href=\"#\" data-toggle=\"dropdown\">More <span class=\"caret rippler rippler-default\"></span></a>
	                    <ul class=\"dropdown-menu\" role=\"menu\">
	                        ";
                        $Counter1 = 1;
                        foreach ($OnlyDates as $OnlyDate => $Val) {
                            if (4 < $Counter1) {
                                echo "	                					<li><a href=\"#TabNo";
                                echo $Counter1;
                                echo '" data-toggle="tab">';
                                echo $Val;
                                echo "</a></li>	
	                					";
                            }

                            ++$Counter1;
                        }
                        echo "	                    </ul>
	                </li>	
		    		";
                    }

                    echo "	    		</ul>	
	    	</div>
	    	<div class=\"panel-body\">
	            <div class=\"tab-content\">
	            		";
                    $TabCounter = 1;
                    $CaptchaCounter = 1;
                    foreach ($OnlyDates as $OnlyDate => $Val) {
                        echo "	                    		<div class=\"tab-pane fade customTab ";
                        echo 1 === $TabCounter ? 'in active' : '';
                        echo '" id="TabNo';
                        echo $TabCounter;
                        echo "\" >
	                    			";
                        foreach ($RequestForEpg['data']->epg_listings as $ResVal) {
                            if (1 === $ResVal->has_archive) {
                                $OnlyDateVal = date('Y:m:d', strtotime($ResVal->start));
                                if ($OnlyDateVal === $OnlyDate) {
                                    $ACtiveClass = '';
                                    $NowPLaying = '';
                                    $StartTimming = strtotime($ResVal->start);
                                    $EndTimming = strtotime($ResVal->end);
                                    $interval = abs($EndTimming - $StartTimming);
                                    $minutes = round($interval / 60);
                                    echo "			    									<div class=\"epginfo catchupclick ";
                                    echo $ACtiveClass;
                                    echo ' cp-';
                                    echo $CaptchaCounter;
                                    echo '" data-timediff="';
                                    echo $minutes;
                                    echo '" data-starttime="';
                                    echo date('Y-m-d:h-i', $StartTimming);
                                    echo '" data-streamid="';
                                    echo $StreamId;
                                    echo "\">
			    										";
                                    echo date($Formatis, $StartTimming);
                                    echo "			    										-
			    										";
                                    echo date($Formatis, $EndTimming);
                                    echo "			    										&nbsp; 
			    										";
                                    echo base64_decode($ResVal->title, true);
                                    echo " 
			    										&nbsp;
			    										";
                                    echo $NowPLaying;
                                    echo "	
			    									</div>	
			    									";
                                    ++$CaptchaCounter;
                                }
                            }
                        }
                        echo "	                    		</div>
	                    	";
                        ++$TabCounter;
                    }
                    echo "	
	            </div>
	        </div>	
	    	";
                    exit();
                }

                echo '';
                exit();
            }

            echo '';
            exit();
        }

        echo '';
        exit();
    }

    if (isset($_POST['action']) && 'getLiveVideoLink' === $_POST['action']) {
        $hostURL = $_POST['hostURL'];
        $streamID = $_POST['streamID'];
        $streamType = $_POST['streamType'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $bar = '/';
        if ('/' === substr($hostURL, -1)) {
            $bar = '';
        }

        $videoLink = $hostURL.$bar.'live/'.$username.'/'.$password.'/'.$streamID.'.m3u8';
        echo $videoLink;
        exit();
    }

    if (isset($_POST['action']) && 'getSeriesInfo' === $_POST['action']) {
        $SeriesId = $_POST['seriesID'];
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $hostURL = $_POST['hostURL'];
        $fullDataVal = $_POST['fullDataVal'];
        $DataSting = parse_str(webtvpanel_baseDecode($fullDataVal));
        $StreamIDIS = (isset($StreamId) && !empty($StreamId) ? $StreamId : 'n/A');
        $MainStreamName = (isset($moviename) && !empty($moviename) ? $moviename : 'n/A');
        $MainStreamCategoryID = (isset($CateGoryId) && !empty($CateGoryId) ? $CateGoryId : 'n/A');
        $MainStreamCover = (isset($posterImage) && !empty($posterImage) ? $posterImage : 'images/no-poster.jpg');
        $MainStreamPlot = (isset($plot) && !empty($plot) ? $plot : 'n/A');
        $MainStreamCast = (isset($cast) && !empty($cast) ? $cast : 'n/A');
        $MainStreamGenre = (isset($genre) && !empty($genre) ? $genre : 'n/A');
        $MainStreamDirector = (isset($director) && !empty($director) ? $director : 'n/A');
        $MainStreamRating = (isset($rating) && !empty($rating) ? $rating : '0');
        $MainStreamReleaseDate = (isset($releaseDate) && !empty($releaseDate) ? $releaseDate : 'n/A');
        $ApiLink = $hostURL.'player_api.php?username='.$username.'&password='.$password.'&action=get_series_info&series_id='.$SeriesId;
        $SeriesData = webtvpanel_CallApiRequest($ApiLink);
        if ('success' === $SeriesData['result']) {
            if (isset($SeriesData['data']->episodes) && !empty($SeriesData['data']->episodes)) {
                $AllSeasonData = (isset($SeriesData['data']->seasons) && !empty($SeriesData['data']->seasons) ? $SeriesData['data']->seasons : '');
                $SeasonCoverImage = [];
                if ('' !== $AllSeasonData) {
                    foreach ($AllSeasonData as $SeasonDataKey) {
                        $SeasonCoverImage[$SeasonDataKey->season_number] = $SeasonDataKey->cover;
                    }
                }

                $OnloadAvtiveEpisode = 0;
                $SeasonsIdData = [];
                $Appepisodes = [];
                $MainposterImage = $MainStreamCover;
                $MainMovieName = $MainStreamName;
                $MainMovieDesc = $MainStreamPlot;
                $MainMoviegenre = $MainStreamGenre;
                $MainMoviereleaseDate = $MainStreamReleaseDate;
                $MainMovierrating_5based = (0 !== $MainStreamRating ? $MainStreamRating / 2 : '0');
                $MainMovierdirector = $MainStreamDirector;
                $MainMoviercast = $MainStreamCast;
                if (!empty($SeriesData['data']->info)) {
                    $SeriesDetails = $SeriesData['data']->info;
                    if ('' !== $SeriesDetails->cover) {
                        $MainposterImage = $SeriesDetails->cover;
                    }

                    $MainMovieName = ('' !== $SeriesDetails->name ? $SeriesDetails->name : 'n/A');
                    $MainMovieDesc = ('' !== $SeriesDetails->plot ? $SeriesDetails->plot : 'n/A');
                    $MainMoviegenre = ('' !== $SeriesDetails->genre ? $SeriesDetails->genre : 'n/A');
                    $MainMoviereleaseDate = ('' !== $SeriesDetails->releaseDate ? $SeriesDetails->releaseDate : 'n/A');
                    $MainMovierrating_5based = ('' !== $SeriesDetails->rating_5based ? $SeriesDetails->rating_5based : 'n/A');
                    $MainMovierdirector = ('' !== $SeriesDetails->director ? $SeriesDetails->director : 'n/A');
                    $MainMoviercast = ('' !== $SeriesDetails->cast ? $SeriesDetails->cast : 'n/A');
                }

                if (!empty($SeriesData['data']->episodes)) {
                    $Appepisodes = $SeriesData['data']->episodes;
                    foreach ($SeriesData['data']->episodes as $episodes) {
                        foreach ($episodes as $episodesData) {
                            $SeasonsIdData[$episodesData->season] = 'season';
                        }
                    }
                }

                echo "		     <div class=\"modal-content\">
		     <div class=\"player_changeIssue alert alert-info\" style=\"position: fixed; top: -300px;left: 35%;\">
	      		Unable to play this format in Jw player trying with aj player.
	        </div>
		      <div class=\"modal-header\" style=\"border:0;\"> <span class=\"p-close rippler rippler-default\" data-dismiss=\"modal\" aria-hidden=\"true\">x</span> </div>
		      <div class=\"modal-body\">
		        <div class=\"popup-content t-s\">
		          <div class=\"pull-left\" style=\"width: 10%;\">
		            <div class=\"poster\">
		              <div class=\"poster-img\"><img src=\"";
                echo $MainposterImage;
                echo "\" alt=\"\" onerror=\"this.src='images/no-poster.jpg';\" class=\"img-responsive\"></div>
		            </div>
		            <div class=\"ts-content\">
		            <div class=\"column seasons\">
		            	";
                if (!empty($SeasonsIdData)) {
                    echo "		            		<ul>
			            		";
                    $ConditionCounter = 1;
                    foreach ($SeasonsIdData as $SeasonNumber => $val) {
                        echo "			            			<li class=\"";
                        echo 1 === $ConditionCounter ? 'active' : '';
                        echo '  rippler rippler-default"><a data-toggle="tab" href="#s-';
                        echo $SeasonNumber;
                        echo '">Season ';
                        echo $SeasonNumber;
                        echo "</a></li>
			            			";
                        ++$ConditionCounter;
                    }
                    echo "		            		</ul>	
		            		";
                }

                echo "	
		            </div>
		        </div>
		          </div>
		          <div class=\"col-sm-9 col-md-10 col-xs-12\">
		            <div class=\"poster-details1\">
		              <h2>";
                echo $MainMovieName;
                echo "</h2>
		              <ul>
		                <li><i class=\"fa fa-anchor\"></i>";
                echo $MainMoviegenre;
                echo "</li>
		                <li><i class=\"fa fa-calendar\"></i>";
                echo $MainMoviereleaseDate;
                echo "</li>
		                <li> ";
                echo webtvpanel_starRating($MainMovierrating_5based);
                echo "</li>
		              </ul>
		              
		            </div>
		          </div>
		          <!-- <div class=\"clearfix\"></div> -->
		          <div class=\"ts-content\">
		            
		            <div class=\"column episodes\">
		              <div class=\"tab-content\">
		              ";
                if (!empty($SeasonsIdData)) {
                    $ConditionCounter2 = 1;
                    foreach ($SeasonsIdData as $SeasonNumber => $val) {
                        echo "			                   <ul id=\"s-";
                        echo $SeasonNumber;
                        echo '" class="tab-pane fade in ';
                        echo 1 === $ConditionCounter2 ? 'active' : '';
                        echo "\">
			                    ";
                        $CounterCon2 = 1;
                        foreach ($Appepisodes as $episodes) {
                            foreach ($episodes as $episodesData) {
                                if ($episodesData->season === $SeasonNumber) {
                                    if (1 === $CounterCon2) {
                                        $OnloadAvtiveEpisode = $episodesData->id;
                                    }

                                    echo "	          								<li class=\"";
                                    echo 1 === $CounterCon2 ? 'active' : '';
                                    echo ' rippler rippler-default"><a data-episid="';
                                    echo $episodesData->id;
                                    echo '"  data-toggle="tab" href="#epis-';
                                    echo $episodesData->id;
                                    echo '"><b>';
                                    echo $CounterCon2;
                                    echo ' </b>';
                                    echo urldecode($episodesData->title);
                                    echo "</a></li>
	          								";
                                    ++$CounterCon2;
                                }
                            }
                        }
                        echo "			                   </ul>
		                    ";
                        ++$ConditionCounter2;
                    }
                }

                echo "		              </div>
		            </div>
		            <div class=\"column w-content\">
		              <div class=\"tab-content\">
		              	<div class=\"PlayerHolder\" data-ajplayer=\"\" data-flowplayer=\"\" data-jwplayer=\"\">
      								<div id=\"player-holder\" class=\"hideOnLoad\"  style=\"border:solid 2px #fff; height: auto !important;\"  >
      								</div>
      								</div>
		              		";
                $CounterCon3 = 1;
                foreach ($Appepisodes as $episodes) {
                    foreach ($episodes as $episodesData) {
                        echo "      								
      								<button id=\"backToInfo-";
                        echo $episodesData->id;
                        echo '" data-episid="';
                        echo $episodesData->id;
                        echo "\" class=\"backToInfo btn btn-info hideOnLoad rippler rippler-default\">Back to Info</button>
  									<div id=\"epis-";
                        echo $episodesData->id;
                        echo '" class="tab-pane fade in ';
                        echo 1 === $CounterCon3 ? 'active' : '';
                        echo "\">
  										<h2>";
                        echo urldecode($episodesData->title);
                        echo "</h2>
						                <h5>Episode ";
                        echo $episodesData->episode_num;
                        echo "</h5>
						                <div class=\"row\">
	  									  <div class=\"col-md-3 seasonIfb";
                        echo $episodesData->season;
                        echo "\">
	  									  		";
                        $EpisodesCover = $MainposterImage;
                        if (!empty($SeasonCoverImage[$episodesData->season])) {
                            $EpisodesCover = $SeasonCoverImage[$episodesData->season];
                        }

                        echo "							                  <img src=\"";
                        echo $EpisodesCover;
                        echo "\" alt=\"\" onerror=\"this.src='images/no-poster.jpg';\" class=\"img-responsive\">
						                  </div>
	  									  <div class=\"col-md-9\">
							                  <p cal>";
                        echo '' !== $episodesData->info->plot ? $episodesData->info->plot : 'n/A';
                        echo "</p>
						                  </div>
						                </div>
					                  <div class=\"watch-now row rippler rippler-default\">
					                    <button onclick=\"watchnow('";
                        echo $episodesData->id;
                        echo "','";
                        echo $episodesData->container_extension;
                        echo "')\">watch it now</button>
					                  </div>
					                </div>
      								";
                        ++$CounterCon3;
                    }
                }
                echo "		              		
		              </div>
		              <!--tab-content--> 
		            </div>
		            <div class=\"clearfix\"></div>
		            <h3 class=\"descHeading\">Description</h3>
		            <p class=\"decription\">";
                echo $MainMovieDesc;
                echo "</p>
		          </div>
		        </div>
		      </div>
		    </div>	
		     ";
                exit();
            }

            echo '0';
            exit();
        }

        echo '0';
        exit();
    }

    if (isset($_POST['action']) && 'getMovieInfo' === $_POST['action']) {
        $username = $_SESSION['webTvplayer']['username'];
        $password = $_SESSION['webTvplayer']['password'];
        $hostURL = $_POST['hostURL'];
        $movieID = $_POST['movieID'];
        $fullDataVal = $_POST['fullDataVal'];
        $DataSting = parse_str(webtvpanel_baseDecode($fullDataVal));
        $StreamIDIS = (isset($StreamId) && !empty($StreamId) ? $StreamId : 'n/A');
        $MainStreamName = (isset($moviename) && !empty($moviename) ? $moviename : 'n/A');
        $Mainextension = (isset($extension) && !empty($extension) ? $extension : 'n/A');
        $rating5 = (isset($rating5) && !empty($rating5) ? $rating5 : '');
        $ApiLink = $hostURL.'player_api.php?username='.$username.'&password='.$password.'&action=get_vod_info&vod_id='.$movieID;

        $movieData = webtvpanel_CallApiRequest($ApiLink);
        if ('success' === $movieData['result']) {
            if (isset($movieData['data']->movie_data)) {
                $MainStreamName = ('' !== $movieData['data']->movie_data->name ? $movieData['data']->movie_data->name : 'n/A');
                $Mainextension = ('' !== $movieData['data']->movie_data->container_extension ? $movieData['data']->movie_data->container_extension : 'n/A');
            }
			
?>
					<div class="modal-content">
		<div class="player_changeIssue alert alert-info" style="position: fixed; top: -300px;left: 35%;">
      		Unable to play this format in Jw player trying with aj player.
        </div>
      <div class="modal-header" style="border:0;"> <span class="p-close rippler rippler-default" data-dismiss="modal" aria-hidden="true">x</span> </div>
      <div class="modal-body">
        <div class="popup-content">
          <div class="col-sm-5 col-lg-2 col-md-2 col-xs-7">
            <div class="poster">
              <div class="poster-img"><img src="
<?php
            echo $movieData['data']->info->movie_image;
            echo "\" onerror=\"this.src='images/no-poster.jpg';\" alt=\"\" class=\"img-responsive\"></div>";
?>
				<div class="ratting-bar row">
                <div class="stars " style="text-align: center;"> ";
<?php
            $rate5 = $rating5;
            if ('' === $rating5) {
                $rate10 = explode('/', $movieData['data']->info->rating);
                $rate5 = (int) ($rate10[0]) / 5;
            }

            if (false !== strpos($rate5, '.')) {
                $rate5 = (float) $rate5;
            } else {
                $rate5 = (int) $rate5;
            }

            echo webtvpanel_starRating($rate5);
?>
</div>
              </div>
            </div>
            <button class="backToInfo btn btn-info hideOnLoad rippler rippler-inverse">Back To Info</button>
          </div>
          <div class="col-sm-7 col-lg-9 col-md-8 col-xs-12">
          	<div class="PlayerHolder" data-ajplayer="" data-flowplayer="" data-jwplayer="">
          	<div id="player-holder" class="hideOnLoad"></div>
          </div>
            <div class="poster-details">
              <h2>
<?php
            echo $MainStreamName;
            echo "</h2>
              <ul class=\"col-md-6 col-sm-12\">
                <li class=\"i-year\">";
            echo '' !== $movieData['data']->info->releasedate ? $movieData['data']->info->releasedate : 'n/A';
            echo "</li>
                <li class=\"i-duration\">";
			if(isset($movieData['data']->info->duration_secs))
			{
            echo '' !== $movieData['data']->info->duration_secs ? round((int) ($movieData['data']->info->duration_secs) / 60).' Minutes' : 'n/A';
			}
			else
			{
				echo '0 Minutes : n/A';
			}
            echo " </li>
                <li class=\"i-movie\">";
            echo '' !== $movieData['data']->info->genre ? $movieData['data']->info->genre : 'n/A';
            echo "</li>
                <!-- <li class=\"i-trailer\"><a href=\"#\">";
            echo $movieData['data']->info->releasedate;
            echo "</a></li> -->
              </ul>

              <ul class=\"col-md-6 col-sm-12\">
                <li class=\"i-cast\"><p>";
            if (40 <= strlen($movieData['data']->info->cast)) {
                echo $movieData['data']->info->cast.'</p><button class="showCast btn btn-sm btn-info rippler rippler-default">Show Cast</button>';
            } else {
                echo $movieData['data']->info->cast ? $movieData['data']->info->cast : 'n/A';
            }

            echo "</li>
                <li class=\"i-director\">";
            echo '' !== $movieData['data']->info->director ? $movieData['data']->info->director : 'n/A';
            echo "</li>
                
                <!-- <li class=\"i-trailer\"><a href=\"#\">";
            echo $movieData['data']->info->releasedate;
            echo "</a></li> -->
              </ul>
              <p class=\"pull-left\">
              	";
            $ShowDescription = 'n/A';
            if (isset($movieData['data']->info->description) && '' !== $movieData['data']->info->description) {
                $ShowDescription = $movieData['data']->info->description;
            } else {
                if (isset($movieData['data']->info->plot) && '' !== $movieData['data']->info->plot) {
                    $ShowDescription = $movieData['data']->info->plot;
                }
            }

            echo $ShowDescription;
            echo "          		
              </p>";
?>
              <div class="fav row">
                <div class="res-list hide">
                  <select>
                    <option>480p</option>
                    <option selected>720p</option>
                    <option>1080p</option>
                  </select>
                </div>
                <button class="gd hide">3D</button>
                <button class="add-fav hide"></button>
              </div>
              
              <div class="watch-now row">
                <button data-streamID="
<?php
            echo $StreamIDIS;
            echo '" data-ext="';
            echo $Mainextension;
            echo "\" onclick=\"watchMovie('";
            echo $StreamIDIS;
            echo '.';
            echo $Mainextension;
            echo "')\" class=\" rippler rippler-default\">watch it now</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
		";
        }
    }
} else {
    echo 'Please verify that function.php file exists';
    exit();
}

?>