<?php

session_start();
if (file_exists('functions.php')) {
    include_once 'functions.php';
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

    if (isset($_POST['action']) && '' !== $_POST['action']) {
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
                    $OnlyDateVar = date('Y:m:d', strtotime($ResVal->start));
                    $ValDate = date('d/m/Y', strtotime($ResVal->start));
                    if ($CurrentDate <= $OnlyDateVar) {
                        $OnlyDates[$OnlyDateVar] = $ValDate;
                    }
                }
                if (!empty($OnlyDates)) {
                    echo "	    	<div class=\"panel-heading\">	
	    		<ul class=\"nav nav-tabs\">
		    	";
                    $TotalDates = count($OnlyDates);
                    $Counter = 1;
                    foreach ($OnlyDates as $OnlyDate => $Val) {
                        if ($Counter <= 4) {
                            echo "  
	                    <li class=\"";
                            echo 1 === $Counter ? 'active' : '';
                            echo "\">
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
	                    <a href=\"#\" data-toggle=\"dropdown\">More <span class=\"caret\"></span></a>
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
                    foreach ($OnlyDates as $OnlyDate => $Val) {
                        echo "	                    		<div class=\"tab-pane fade customTab ";
                        echo 1 === $TabCounter ? 'in active' : '';
                        echo '" id="TabNo';
                        echo $TabCounter;
                        echo "\" >
	                    			";
                        foreach ($RequestForEpg['data']->epg_listings as $ResVal) {
                            $OnlyDateVal = date('Y:m:d', strtotime($ResVal->start));
                            if ($OnlyDateVal === $OnlyDate) {
                                $ACtiveClass = '';
                                $NowPLaying = '';
                                $StartTimming = strtotime($ResVal->start);
                                $EndTimming = strtotime($ResVal->end);
                                if ($StartTimming <= $CurrentTime && $CurrentTime <= $EndTimming) {
                                    $ACtiveClass = 'NowPlayingActive';
                                    $NowPLaying = '(Now Playing)';
                                }

                                echo "		    									<div class=\"epginfo ";
                                echo $ACtiveClass;
                                echo "\">
		    										";
                                echo date($Formatis, $StartTimming);
                                echo "		    										-
		    										";
                                echo date($Formatis, $EndTimming);
                                echo "		    										&nbsp; 
		    										";
                                echo base64_decode($ResVal->title, true);
                                echo " 
		    										&nbsp;
		    										";
                                echo $NowPLaying;
                                echo "	
		    									</div>	
		    									";
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
} else {
    echo 'Please verify that functions.php file exists';
    exit();
}

?>