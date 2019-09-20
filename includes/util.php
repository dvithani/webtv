<?php
function validate( $licensekey, $localkey = "" ) {
		error_reporting( error_reporting() & ~E_NOTICE );
        $whmcsurl = "https://legazy.systems/costumer_area/";
        $licensing_secret_key = "Mhdgbghvas872634923845jkhavsd";
        $check_token = time() . md5( mt_rand( 1000000000, 9999999999 ) . $licensekey );
        $checkdate = date( "Ymd" ); // Current date
        $usersip = isset( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_ADDR'] : $_SERVER['LOCAL_ADDR'];
        $localkeydays = 30; // How long the local key is valid for in between remote checks
        $allowcheckfaildays = 5; // How many days to allow after local key expiry before blocking access if connection cannot be made
        $localkeyvalid = false;
        if ( !$localkeyvalid ) {
            $postfields["licensekey"] = $licensekey;
            $postfields["domain"] = $_SERVER['SERVER_NAME'];
            $postfields["ip"] = $usersip;
            $postfields["dir"] = dirname( __FILE__ );
            if ( $check_token )
                $postfields["check_token"] = $check_token;
            if ( function_exists( "curl_exec" ) ) {
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $whmcsurl . "modules/servers/licensing/verify.php" );
                curl_setopt( $ch, CURLOPT_POST, 1 );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $postfields );
                curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec( $ch );
                curl_close( $ch );
            } else {
                $fp = fsockopen( $whmcsurl, 80, $errno, $errstr, 5 );
                if ( $fp ) {
                    $querystring = "";
                    foreach ( $postfields as $k => $v ) {
                        $querystring .= "$k=" . urlencode( $v ) . "&";
                    }
                    $header = "POST " . $whmcsurl . "modules/servers/licensing/verify.php HTTP/1.0
";
                    $header.="Host: " . $whmcsurl . "
";
                    $header.="Content-type: application/x-www-form-urlencoded
";
                    $header.="Content-length: " . @strlen( $querystring ) . "
";
                    $header.="Connection: close

";
                    $header.=$querystring;
                    $data = "";
                    @stream_set_timeout( $fp, 20 );
                    @fputs( $fp, $header );
                    $status = @socket_get_status( $fp );
                    while ( !@feof( $fp ) && $status ) {
                        $data .= @fgets( $fp, 1024 );
                        $status = @socket_get_status( $fp );
                    }
                    @fclose( $fp );
                }
            }
            if ( !$data ) {
                $localexpiry = date( "Ymd", mktime( 0, 0, 0, date( "m" ), date( "d" ) - ( $localkeydays + $allowcheckfaildays ), date( "Y" ) ) );
                if ( $originalcheckdate > $localexpiry ) {
                    $results = $localkeyresults;
                } else {
                    $results["status"] = "Invalid";
                    $results["description"] = "Remote Check Failed";
                    return $results;
                }
            } else {
                preg_match_all( '/<(.*?)>([^<]+)<\/\\1>/i', $data, $matches );
                $results = array();
                foreach ( $matches[1] as $k => $v ) {
                    $results[$v] = $matches[2][$k];
                }
            }
            if ( $results["md5hash"] ) {
                if ( $results["md5hash"] != md5( $licensing_secret_key . $check_token ) ) {
                    $results["status"] = "Invalid";
                    $results["description"] = "MD5 Checksum Verification Failed";
                    return $results;
                }
            }
            if ( $results["status"] == "Active" ) {
                $results["checkdate"] = $checkdate;
                $data_encoded = serialize( $results );
                $data_encoded = base64_encode( $data_encoded );
                $data_encoded = md5( $checkdate . $licensing_secret_key ) . $data_encoded;
                $data_encoded = strrev( $data_encoded );
                $data_encoded = $data_encoded . md5( $data_encoded . $licensing_secret_key );
                $data_encoded = wordwrap( $data_encoded, 80, "\n", true );
                $results["localkey"] = $data_encoded;
            }
            $results["remotecheck"] = true;
        }
        unset( $postfields, $data, $matches, $whmcsurl, $licensing_secret_key, $checkdate, $usersip, $localkeydays, $allowcheckfaildays, $md5hash );



        if ( $results["status"] == "Invalid" ) {
            // Show Invalid Message
            $result = "ERROR: INVALID MODULE LICENSE";
        } elseif ( $results["status"] == "Expired" ) {
            // Show Expired Message
            $result = "ERROR: EXPIRED LICENSE";
        } elseif ( $results["status"] == "Suspended" ) {
            // Show Suspended Message
            $result = "ERROR: SUSPENDED LICENSE";
        } else {

            $result = 1;
        }

        return $result;
    

}
