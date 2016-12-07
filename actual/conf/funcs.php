<?php

date_default_timezone_set("Asia/Kolkata");

function settimezone( $GMT )
{
    $timezones = "Asia/Kolkata";
    custom_timezone_set( $timezones[$GMT] );
    return true;
}

function custom_timezone_set( $tz )
{
        date_default_timezone_set('Asia/Kolkata');

}

function custom_timezone_get( )
{
        date_default_timezone_get('Asia/Kolkata');
}

function getsqlrow( $query )
{
    if ( !( $result = mysql_query( $query ) ) )
    {
        exit( mysql_error( ) );
    }
    $row = mysql_fetch_array( $result );
    mysql_free_result( $result );
    return $row;
}

function getsqlnumber( $sqlQuery )
{
    $query = @mysql_query( @$sqlQuery );
    $result = @mysql_num_rows( @$query );
    @mysql_free_result( @$query );
    return $result;
}

function getsqlfield( $sqlQuery, $field )
{
    $isQuery = getsqlnumber( $sqlQuery );
    if ( !( $query = @mysql_query( @$sqlQuery ) ) )
    {
        exit( mysql_error( )."<br>WRONG QUERY: ".$sqlQuery );
    }
    if ( 0 < $isQuery )
    {
        $result = @mysql_result( @$query, 0, @$field );
    }
    else
    {
        $result = "";
    }
    @mysql_free_result( @$query );
    return $result;
}

function insert_sql( $table, $data )
{
    $cols = "(";
    $values = "(";
    foreach ( $data as $key => $value )
    {
        $cols .= "{$key},";
        $value = safe( $value );
        $values .= "'{$value}',";
    }
    $cols = rtrim( $cols, "," ).")";
    $values = rtrim( $values, "," ).")";
    $sql = "INSERT INTO {$table} {$cols} VALUES {$values}";
    $runsql = mysql_query( $sql );
    $yeni_id = mysql_insert_id( );
    return $yeni_id;
}

function replace_sql( $table, $data )
{
    $cols = "(";
    $values = "(";
    foreach ( $data as $key => $value )
    {
        $cols .= "{$key},";
        $value = safe( $value );
        $values .= "'{$value}',";
    }
    $cols = rtrim( $cols, "," ).")";
    $values = rtrim( $values, "," ).")";
    $sql = "REPLACE INTO {$table} {$cols} VALUES {$values}";
    $runsql = mysql_query( $sql );
    $yeni_id = mysql_insert_id( );
    return $yeni_id;
}

function update_sql( $table, $data, $condition )
{
    $sql = "UPDATE {$table} SET";
    foreach ( $data as $key => $value )
    {
        $sql .= " {$key}=";
        $value = safe( $value );
        $sql .= "'{$value}',";
    }
    $sql = rtrim( $sql, "," );
    $sql .= " WHERE {$condition}";
    $runsql = mysql_query( $sql );
    return $sql;
}

function get_column_type( $table, $column )
{
    $r = mysql_query( "SELECT {$column} FROM {$table}" );
    if ( !$r )
    {
        return false;
    }
    $ret = mysql_field_type( $r, 0 );
    if ( !$ret )
    {
        mysql_free_result( $r );
        return false;
    }
    mysql_free_result( $r );
    return $ret;
}

function safe( $string )
{
    return mysql_real_escape_string( $string );
}

function htmlmail( $sender, $to, $subject, $msg )
{
    $mailheaders = "Content-Type: text/html; charset=utf-8".( "\n" );
    $mailheaders .= "Return-path: {$sender} <{$sender}>\n";
    $mailheaders .= "From: ".SITENAME." <{$sender}>\n";
    $mailheaders .= "Reply-To: ".$sender."\n";
    $mailheaders .= "X-Mailer: php/".phpversion( )."\n";
    $mailheaders .= "X-Return-Path: {$sender}\n";
    mail( $to, $subject, $msg, $mailheaders );
}

function date_long( $thedate )
{
    $diff = 0;
    $splitted = explode( " ", $thedate );
    $ourdate = explode( "-", $splitted[0] );
    $rday = $ourdate[2];
    $rmonth = $ourdate[1];
    $ryear = $ourdate[0];
    $ourtime = explode( ":", $splitted[1] );
    $rsec = $ourtime[2];
    $rmin = $ourtime[1];
    $rhour = $ourtime[0];
    $dateu = date( "d.m.Y H:i:s", mktime( $rhour + $diff, $rmin, $rsec, $rmonth, $rday, $ryear ) );
    return $dateu;
}

function date_short( $thedate )
{
    $splitted = explode( " ", $thedate );
    $ourdate = explode( "-", $splitted[0] );
    $rday = $ourdate[2];
    $rmonth = $ourdate[1];
    $ryear = $ourdate[0];
    $ourtime = explode( ":", $splitted[1] );
    $rsec = $ourtime[2];
    $rmin = $ourtime[1];
    $rhour = $ourtime[0];
    $datek = date( "d.m.Y", mktime( $rhour, $rmin, $rsec, $rmonth, $rday, $ryear ) );
    return $datek;
}

function sqltime( $thedate )
{
    $diff = 0;
    $splitted = explode( " ", $thedate );
    $ourdate = explode( "-", $splitted[0] );
    $rday = $ourdate[2];
    $rmonth = $ourdate[1];
    $ryear = $ourdate[0];
    $ourtime = explode( ":", $splitted[1] );
    $rsec = $ourtime[2];
    $rmin = $ourtime[1];
    $rhour = $ourtime[0];
    $date = strftime( "%Y-%m-%d %H:%M:%S", mktime( $rhour + $diff, $rmin, $rsec, $rmonth, $rday, $ryear ) );
    return $date;
}

function mysqltime( )
{
    return date( "Y-m-d H:i:s" );
}


function pages( $start, $limit, $total, $filePath, $otherParams )
{
    global $lang;
    $allPages = ceil( $total / $limit );
    $currentPage = floor( $start / $limit ) + 1;
    $pagination = "";

if ( 10 < $allPages )
    {
        $maxPages = 9 < $allPages ? 9 : $allPages;
/*
        if ( 9 < $allPages )
        {
*/
            if ( 1 <= $currentPage && $currentPage <= $allPages )
            {
                $pagination .= 4 < $currentPage ? "" : "";
                $minPages = 4 < $currentPage ? $currentPage : 5;
                $maxPages = $currentPage < $allPages - 4 ? $currentPage : $allPages - 4;
                $i = $minPages - 4;
                while ( $i < $maxPages + 5 )
                {
                    $pagination .= $i == $currentPage ? "<li><a href=\"#\" class=\"currentpage\">".$i."</a></li> " : "<li><a href=\"".$filePath."?s=".( $i - 1 ) * $limit.$otherParams."\">".$i."</a></li> ";
                    ++$i;
                }
                $pagination .= $currentPage < $allPages - 4 ? "" : "";

            }
            else
            {
                $pagination .= "";
            }
/*
        }
*/

    }
    else
    {
        do
        {
            $i = 1;
        } while ( 0 );

        while ( $i < $allPages + 1 )
        {
            $pagination .= $i == $currentPage ? "<li><a href=\"#\" class=\"currentpage\">".$i."</a></li> " : "<li><a href=\"".$filePath."?s=".( $i - 1 ) * $limit.$otherParams."\">".$i."</a></li> ";
            ++$i;
            break;
        }
    }

    if ( 1 < $currentPage )
    {
        $pagination = "<li class='prevnext'><a href=\"".$filePath."?s=0".$otherParams."\">&lt;&lt;</a></li> <li class='prevnext'><a href=\"".$filePath."?s=".( $currentPage - 2 ) * $limit.$otherParams."\">&lt;</a></li> ".$pagination;
    }
    if ( $currentPage < $allPages )
    {
        $pagination .= "<li class='prevnext'><a href=\"".$filePath."?s=".$currentPage * $limit.$otherParams."\">&gt;</a></li> <li class='prevnext'><a href=\"".$filePath."?s=".( $allPages - 1 ) * $limit.$otherParams."\">&gt;&gt;</a></li> ";
    }
    echo $pagination;
}


function restaurantspages( $start, $limit, $total, $filePath, $otherParams, $city, $area, $service)
{
    global $lang;
    $allPages = ceil( $total / $limit );
    $currentPage = floor( $start / $limit ) + 1;
    $pagination = "";

        $maxPages = 9 < $allPages ? 9 : $allPages;

/*
        if ( 9 < $allPages )
        {
*/
            if ( 1 <= $currentPage && $currentPage <= $allPages )
            {
                $pagination .= 4 < $currentPage ? "" : "";
                $minPages = 4 < $currentPage ? $currentPage : 5;
                $maxPages = $currentPage < $allPages - 4 ? $currentPage : $allPages - 4;
                $i = $minPages - 4;

                while ( $i < $maxPages + 5 )
                {
                    $pagination .= $i == $currentPage ? "<li><a href=\"#\" class=\"currentpage\">".$i."</a></li> " : "<li><a href=\"".$filePath."?service=".$service."&city=".$city."&area=".$area."&s=".( $i - 1 ) * $limit.$otherParams."\">".$i."</a></li> ";
                    ++$i;
                }
                $pagination .= $currentPage < $allPages - 4 ? "" : "";

            }
            else
            {
                $pagination .= "";
            }

/*
        }
*/

    if ( 2 < $currentPage )
    {
        $pagination = "<li class='prevnext'><a href=\"".$filePath."?service=".$service."&city=".$city."&area=".$area."&s=0".$otherParams."\">&lt;&lt;</a></li> <li class='prevnext'><a href=\"".$filePath."?service=".$service."&city=".$city."&area=".$area."&s=".( $currentPage - 2 ) * $limit.$otherParams."\">&lt;</a></li> ".$pagination;
    }
    if ( $currentPage < ( $allPages - 2 ) )
    {
        $pagination .= "<li class='prevnext'><a href=\"".$filePath."?service=".$service."&city=".$city."&area=".$area."&s=".$currentPage * $limit.$otherParams."\">&gt;</a></li> <li class='prevnext'><a href=\"".$filePath."?service=".$service."&city=".$city."&area=".$area."&s=".( $allPages - 1 ) * $limit.$otherParams."\">".$allPages."</a></li> ";
    }
    echo $pagination;
}

function trchar( $strContent )
{
    $chars = array( "ÄŸ" => "ğ", "Ä" => "Ğ", "Ã¼" => "ü", "Ãœ" => "Ü", "Ä°" => "İ", "Ã§" => "ç", "Ã‡" => "Ç", "Ã¶" => "ö", "Ã–" => "Ö", "Ä±" => "ı", "ÅŸ" => "ş", "Å" => "Ş" );
    return str_replace( array_keys( $chars ), $chars, $strContent );
}

function notr( $strContent )
{
    $chars = array( "ğ" => "g", "Ğ" => "G", "ü" => "u", "Ü" => "U", "İ" => "I", "ç" => "c", "Ç" => "C", "ö" => "o", "Ö" => "O", "ı" => "i", "ş" => "s", "Ş" => "S", "&" => "-" );
    return str_replace( array_keys( $chars ), $chars, $strContent );
}

function datediff( $interval, $datefrom, $dateto, $using_timestamps = false )
{
    if ( !$using_timestamps )
    {
        $datefrom = strtotime( $datefrom, 0 );
        $dateto = strtotime( $dateto, 0 );
    }
    $difference = $dateto - $datefrom;
    switch ( $interval )
    {
        case "yyyy" :
            $years_difference = floor( $difference / 31536000 );
            if ( $dateto < mktime( date( "H", $datefrom ), date( "i", $datefrom ), date( "s", $datefrom ), date( "n", $datefrom ), date( "j", $datefrom ), date( "Y", $datefrom ) + $years_difference ) )
            {
                --$years_difference;
            }
            if ( $datefrom < mktime( date( "H", $dateto ), date( "i", $dateto ), date( "s", $dateto ), date( "n", $dateto ), date( "j", $dateto ), date( "Y", $dateto ) - ( $years_difference + 1 ) ) )
            {
                ++$years_difference;
            }
            $datediff = $years_difference;
            break;
        case "q" :
            $quarters_difference = floor( $difference / 8035200 );
            while ( mktime( date( "H", $datefrom ), date( "i", $datefrom ), date( "s", $datefrom ), date( "n", $datefrom ) + $quarters_difference * 3, date( "j", $dateto ), date( "Y", $datefrom ) ) < $dateto )
            {
                ++$months_difference;
            }
            --$quarters_difference;
            $datediff = $quarters_difference;
            break;
        case "m" :
            $months_difference = floor( $difference / 2678400 );
            while ( mktime( date( "H", $datefrom ), date( "i", $datefrom ), date( "s", $datefrom ), date( "n", $datefrom ) + $months_difference, date( "j", $dateto ), date( "Y", $datefrom ) ) < $dateto )
            {
                ++$months_difference;
            }
            --$months_difference;
            $datediff = $months_difference;
            break;
        case "y" :
            $datediff = date( "z", $dateto ) - date( "z", $datefrom );
            break;
        case "d" :
            $datediff = floor( $difference / 86400 );
            break;
        case "w" :
            $days_difference = floor( $difference / 86400 );
            $weeks_difference = floor( $days_difference / 7 );
            $first_day = date( "w", $datefrom );
            $days_remainder = floor( $days_difference % 7 );
            $odd_days = $first_day + $days_remainder;
            if ( 7 < $odd_days )
            {
                --$days_remainder;
            }
            if ( 6 < $odd_days )
            {
                --$days_remainder;
            }
            $datediff = $weeks_difference * 5 + $days_remainder;
            break;
        case "ww" :
            $datediff = floor( $difference / 604800 );
            break;
        case "h" :
            $datediff = floor( $difference / 3600 );
            break;
        case "n" :
            $datediff = floor( $difference / 60 );
            break;
    }
    $datediff = $difference;
    break;
    return $datediff;
}

function getip( )
{
    if ( getenv( HTTP_X_FORWARDED_FOR ) )
    {
        $ip = getenv( HTTP_X_FORWARDED_FOR );
    }
    else
    {
        $ip = getenv( REMOTE_ADDR );
    }
    return $ip;
}

function check_email( $email )
{
    if ( !ereg( "^[^@]{1,64}@[^@]{1,255}\$", $email ) )
    {
        return false;
    }
    $email_array = explode( "@", $email );
    $local_array = explode( ".", $email_array[0] );
    $i = 0;
    while ( $i < sizeof( $local_array ) )
    {
        if ( !ereg( "^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))\$", $local_array[$i] ) )
        {
            return false;
        }
        ++$i;
    }
    if ( !ereg( "^\\[?[0-9\\.]+\\]?\$", $email_array[1] ) )
    {
        $domain_array = explode( ".", $email_array[1] );
        if ( sizeof( $domain_array ) < 2 )
        {
            return false;
        }
        $i = 0;
        while ( $i < sizeof( $domain_array ) )
        {
            if ( !ereg( "^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))\$", $domain_array[$i] ) )
            {
                return false;
            }
            ++$i;
        }
    }
    return true;
}

function to8( $strContent )
{
    $chars = array( "ğ" => "ÄŸ", "Ğ" => "Ä", "ü" => "Ã¼", "Ü" => "Ãœ", "İ°" => "Ä°", "ç" => "Ã§", "Ç" => "Ã‡", "ö" => "Ã¶", "Ö" => "Ã–", "ı" => "Ä±", "ş" => "ÅŸ", "Ş" => "Å" );
    return str_replace( array_keys( $chars ), $chars, $strContent );
}

function seo_url( $url )
{
    $url = notr( $url );
    $url = trchar( trim( $url ) );
    $url = strtolower( $url );
    $find = array( "<b>", "</b>" );
    $url = str_replace( $find, "", $url );
    $url = preg_replace( "/<(\\/{0,1})img(.*?)(\\/{0,1})\\>/", "image", $url );
    $find = array( " ", "&quot;", "&amp;", "&", "\\r\\n", "\\n", "/", "\\", "+", "<", ">" );
    $url = str_replace( $find, "-", $url );
    $find = array( "é", "è", "ë", "ê", "É", "È", "Ë", "Ê" );
    $url = str_replace( $find, "e", $url );
    $find = array( "í", "ı", "ì", "î", "ï", "I", "İ", "Í", "Ì", "Î", "Ï" );
    $url = str_replace( $find, "i", $url );
    $find = array( "ó", "ö", "Ö", "ò", "ô", "Ó", "Ò", "Ô" );
    $url = str_replace( $find, "o", $url );
    $find = array( "á", "ä", "â", "à", "â", "Ä", "Â", "Á", "À", "Â" );
    $url = str_replace( $find, "a", $url );
    $find = array( "ú", "ü", "Ü", "ù", "û", "Ú", "Ù", "Û" );
    $url = str_replace( $find, "u", $url );
    $find = array( "ç", "Ç" );
    $url = str_replace( $find, "c", $url );
    $find = array( "ş", "Ş" );
    $url = str_replace( $find, "s", $url );
    $find = array( "ğ", "Ğ" );
    $url = str_replace( $find, "g", $url );
    $find = array( "/[^a-z0-9\\-<>]/", "/[\\-]+/", "/<[^>]*>/" );
    $repl = array( "", "-", "" );
    $url = preg_replace( $find, $repl, $url );
    $url = str_replace( "--", "-", $url );
    return $url;
}

function httpposter( $prmPostAddress, $prmSendData )
{
    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_URL, $prmPostAddress );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $prmSendData );
    $result = curl_exec( $ch );
    return $result;
}

function htmlspecialchars_decode_php4( $str )
{
    return strtr( $str, array_flip( get_html_translation_table( HTML_SPECIALCHARS ) ) );
}

function getval( $table, $column, $id )
{
    $val = getsqlfield( "SELECT {$column} FROM {$table} where id=".$id."", $column );
    return $val;
}

function getwhere( $table, $column, $where )
{
    $val = getsqlfield( "SELECT {$column} FROM {$table} where {$where}", $column );
    return $val;
}

function cleantmp( $dir )
{
    $seconds_old = 1 * 24 * 60 * 60;
    $directory = $_SERVER['DOCUMENT_ROOT'].$dir;
    if ( !( $dirhandle = @opendir( @$directory ) ) )
    {
    }
    else
    {
        while ( false !== ( $filename = readdir( $dirhandle ) ) )
        {
            if ( $filename != "." && $filename != ".." )
            {
                $filename = $directory."/".$filename;
                if ( @( filemtime( @$filename ) < time( ) - $seconds_old ) )
                {
                    @unlink( @$filename );
                }
            }
        }
    }
}

function convertdate( $date )
{
    $d = split( " ", $date );
    $arr = split( "/", $d[0] );
    $dd = $arr[0];
    $mm = $arr[1];
    $yy = $arr[2];
    $newdate = $yy."-".$mm."-".$dd." ".$d[1];
    return $newdate;
}

function checklogin( )
{
    if ( !$_SESSION['memberid'] )
    {
        echo "<script>document.location.href='".SITEURL."login.php?back=".$_SERVER['REQUEST_URI']."'</script>";
        exit( );
    }
}

function checkadmin( )
{
    if ( !$_SESSION['admin_id'] )
    {
        echo "<script>document.location.href='./login.php'</script>";
        exit( );
    }
}

function createthumb( $name, $filename, $new_w, $new_h )
{
    $system = explode( ".", $name );
    if ( preg_match( "/jpg|jpeg/", $system[1] ) )
    {
        $src_img = imagecreatefromjpeg( $name );
    }
    if ( preg_match( "/png/", $system[1] ) )
    {
        $src_img = imagecreatefrompng( $name );
    }
    if ( preg_match( "/img/", $system[1] ) )
    {
        $src_img = imagecreatefromjpeg( $name );
    }
    $old_x = imagesx( $src_img );
    $old_y = imagesy( $src_img );
    $xscale = $old_x / $new_w;
    $yscale = $old_y / $new_h;
    if ( $xscale < $yscale )
    {
        $thumb_w = round( $old_x * ( 1 / $yscale ) );
        $thumb_h = round( $old_y * ( 1 / $yscale ) );
    }
    else
    {
        $thumb_w = round( $old_x * ( 1 / $xscale ) );
        $thumb_h = round( $old_y * ( 1 / $xscale ) );
    }
    $dst_img = imagecreatetruecolor( $thumb_w, $thumb_h );
    imagecopyresampled( $dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y );
    if ( preg_match( "/png/", $system[1] ) )
    {
        imagepng( $dst_img, $filename );
    }
    else
    {
        touch( $filename );
        imagejpeg( $dst_img, $filename );
    }
    imagedestroy( $dst_img );
    imagedestroy( $src_img );
}

function jsescape( $str )
{
    return addcslashes( $str, "\\\\'\"&\n\r<>" );
}

function setprice( $price, $birim = "" )
{
    if ( !$birim )
    {
        $birim = CURRENCY;
    }
    $newprice = number_format((double)$price, 2, DEC_POINT, THOUSANDS_SEP );
    if ( CURRENCY_POSITION == "R" )
    {
        return $newprice." ".$birim;
    }
    return $birim." ".$newprice;
}

function encrypt_phpfood( $string )
{
    $result = "";
    $key = "fzcom";
    $i = 0;
    while ( $i < strlen( $string ) )
    {
        $char = substr( $string, $i, 1 );
        $keychar = substr( $key, $i % strlen( $key ) - 1, 1 );
        $char = chr( ord( $char ) + ord( $keychar ) );
        $result .= $char;
        ++$i;
    }
    return base64_encode( $result );
}

function decrypt_phpfood( $string )
{
    $result = "";
    $key = "fzcom";
    $string = base64_decode( $string );
    $i = 0;
    while ( $i < strlen( $string ) )
    {
        $char = substr( $string, $i, 1 );
        $keychar = substr( $key, $i % strlen( $key ) - 1, 1 );
        $char = chr( ord( $char ) - ord( $keychar ) );
        $result .= $char;
        ++$i;
    }
    return $result;
}

function licencestatus( )
{ @mysql_query( "update options set option_value=':)' where option_name='PHPFOOD_LIC'" ); }

function checklic( )
{
  // Foodzoned :)
}


function getdatename( $gun )
{
    $gunler = array( 0 => SUN, 1 => MON, 2 => TUE, 3 => WED, 4 => THU, 5 => FRI, 6 => SAT );
    return $gunler[$gun];
}

function addmin( $date, $minute )
{
    $sum = strtotime( date( "Y-m-d H:i:s", strtotime( "{$date}" ) )." +{$minute} minutes" );
    $dateTo = date( "Y-m-d H:i:s", $sum );
    return $dateTo;
}

function send_email( $to, $subject, $msg, $mailheaders = "" )
{
    if ( EMAIL_SMTP_ENABLE == "yes" )
    {
        $Var_168->PHPMailer( );
        $mail = $Var_168;
        $body = $msg;
        IsSMTP( );
        $mail->Host = EMAIL_SERVER;
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->Host = EMAIL_SERVER;
        $mail->Port = EMAIL_PORT;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASS;
        SetFrom( SITE_EMAIL, SITENAME );
        AddReplyTo( SITE_EMAIL, SITENAME );
        $mail->Subject = $subject;
        $mail->AltBody = "";
        MsgHTML( $body );
        AddAddress( $to, "" );
        if ( !Send( ) )
        {
            return false;
        }
        return true;
    }
    @mail( @$to, @$subject, @$msg, @$mailheaders );
}

function setresturl( $id, $name )
{
    $new_url = SITEURL.seo_url( $name )."-".$id.".html";
    return $new_url;
}


function checkresthour( $open1, $close1, $open2, $close2, $open3, $close3 )
{

    $date = date( "Y-m-d" );
    $now = date( "Y-m-d H:i:s" );

    $open_date1 = $date." ".$open1;
    $close_date1 = $date." ".$close1;
    $open_date2 = $date." ".$open2;
    $close_date2 = $date." ".$close2;
    $open_date3 = $date." ".$open3;
    $close_date3 = $date." ".$close3;

    if ( $open_date1 <= $now && $now <= $close_date1 ) { return true; }
    else if ( $open_date2 <= $now && $now <= $close_date2 ) { return true; }
    else if ( $open_date3 <= $now && $now <= $close_date3 ) { return true; } else { return false; }
    return false;
}



function updatekeywords( $rest_id )
{
    $rs = getsqlrow( "select * from rests where id=".safe( $rest_id )."" );
    $rs_da = getsqlrow( "select * from delivery_areas where zip='".$rs['zip']."'" );
    $data['keywords'] = $rs['name'].",".$rs_da['zip'].",".$rs_da['city'].",".$rs_da['region'];
    $getRss = mysql_query( "SELECT * FROM rest_delivery_area where rest_id=".$rest_id."" );
    while ( $rss = mysql_fetch_array( $getRss ) )
    {
        $rss_da = getsqlrow( "select * from delivery_areas where id=".$rss['da_id']."" );
        if ( $rss_da['id'] )
        {
            $data['keywords'] .= ",".$rss_da['zip'].",".$rss_da['city'].",".$rss_da['region'];
        }
    }
    $data['keywords'] = strtolower( $data['keywords'] );
    @mysql_query( @"update rests set keywords='".@safe( @$data['keywords'] )."' where id=".@safe( @$rest_id )."" );
}

mb_internal_encoding( "UTF-8" );
require_once( "class.phpmailer.php" );
$host = str_replace( "http://", "", SITEURL );
$host = str_replace( $_SERVER['HTTP_HOST'], "", $host );
$path = $host;
define( "MAIN_PATH", $path );
define( "DIR_PATH", $_SERVER['DOCUMENT_ROOT']."/".$path );
if ( !$_SESSION['phpfood_lang'] )
{
    $_SESSION['phpfood_lang'] = "en";
}
$getRss = mysql_query( "SELECT * from options" );
while ( $rss = @mysql_fetch_array( @$getRss ) )
{
    define( $rss['option_name'], $rss['option_value'] );
}
$getRss = mysql_query( "SELECT * from langs" );
while ( $rss = @mysql_fetch_array( @$getRss ) )
{
    $GLOBALS[$rss['name']] = $rss[$_SESSION['phpfood_lang']];
    if ( !$GLOBALS[$rss['name']] )
    {
        $GLOBALS[$rss['name']] = $rss['en'];
    }
}

$copyright = "&copy; 2014-".date('Y')." <a href='#'>Khicha E-Creations</a> - Developed by <a href='http://facebook.com/Hamgele' target='_blank'>Hamgele</a>";

define( "MON", "Monday" );
define( "TUE", "Tuesday" );
define( "WED", "Wednesday" );
define( "THU", "Thursday" );
define( "FRI", "Friday" );
define( "SAT", "Saturday" );
define( "SUN", "Sunday" );
define( "COPYRIGHT", "" );

?>
