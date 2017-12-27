<?php
  date_default_timezone_set("Asia/Singapore");

  $countrylist = array(
  "AF" => "Afghanistan",
  "AL" => "Albania",
  "DZ" => "Algeria",
  "AS" => "American Samoa",
  "AD" => "Andorra",
  "AO" => "Angola",
  "AI" => "Anguilla",
  "AQ" => "Antarctica",
  "AG" => "Antigua and Barbuda",
  "AR" => "Argentina",
  "AM" => "Armenia",
  "AW" => "Aruba",
  "AU" => "Australia",
  "AT" => "Austria",
  "AZ" => "Azerbaijan",
  "BS" => "Bahamas",
  "BH" => "Bahrain",
  "BD" => "Bangladesh",
  "BB" => "Barbados",
  "BY" => "Belarus",
  "BE" => "Belgium",
  "BZ" => "Belize",
  "BJ" => "Benin",
  "BM" => "Bermuda",
  "BT" => "Bhutan",
  "BO" => "Bolivia",
  "BA" => "Bosnia and Herzegovina",
  "BW" => "Botswana",
  "BV" => "Bouvet Island",
  "BR" => "Brazil",
  "BQ" => "British Antarctic Territory",
  "IO" => "British Indian Ocean Territory",
  "VG" => "British Virgin Islands",
  "BN" => "Brunei",
  "BG" => "Bulgaria",
  "BF" => "Burkina Faso",
  "BI" => "Burundi",
  "KH" => "Cambodia",
  "CM" => "Cameroon",
  "CA" => "Canada",
  "CT" => "Canton and Enderbury Islands",
  "CV" => "Cape Verde",
  "KY" => "Cayman Islands",
  "CF" => "Central African Republic",
  "TD" => "Chad",
  "CL" => "Chile",
  "CN" => "China",
  "CX" => "Christmas Island",
  "CC" => "Cocos [Keeling] Islands",
  "CO" => "Colombia",
  "KM" => "Comoros",
  "CG" => "Congo - Brazzaville",
  "CD" => "Congo - Kinshasa",
  "CK" => "Cook Islands",
  "CR" => "Costa Rica",
  "HR" => "Croatia",
  "CU" => "Cuba",
  "CY" => "Cyprus",
  "CZ" => "Czech Republic",
  "CI" => "Côte d’Ivoire",
  "DK" => "Denmark",
  "DJ" => "Djibouti",
  "DM" => "Dominica",
  "DO" => "Dominican Republic",
  "NQ" => "Dronning Maud Land",
  "DD" => "East Germany",
  "EC" => "Ecuador",
  "EG" => "Egypt",
  "SV" => "El Salvador",
  "GQ" => "Equatorial Guinea",
  "ER" => "Eritrea",
  "EE" => "Estonia",
  "ET" => "Ethiopia",
  "FK" => "Falkland Islands",
  "FO" => "Faroe Islands",
  "FJ" => "Fiji",
  "FI" => "Finland",
  "FR" => "France",
  "GF" => "French Guiana",
  "PF" => "French Polynesia",
  "TF" => "French Southern Territories",
  "FQ" => "French Southern and Antarctic Territories",
  "GA" => "Gabon",
  "GM" => "Gambia",
  "GE" => "Georgia",
  "DE" => "Germany",
  "GH" => "Ghana",
  "GI" => "Gibraltar",
  "GR" => "Greece",
  "GL" => "Greenland",
  "GD" => "Grenada",
  "GP" => "Guadeloupe",
  "GU" => "Guam",
  "GT" => "Guatemala",
  "GG" => "Guernsey",
  "GN" => "Guinea",
  "GW" => "Guinea-Bissau",
  "GY" => "Guyana",
  "HT" => "Haiti",
  "HM" => "Heard Island and McDonald Islands",
  "HN" => "Honduras",
  "HK" => "Hong Kong SAR China",
  "HU" => "Hungary",
  "IS" => "Iceland",
  "IN" => "India",
  "ID" => "Indonesia",
  "IR" => "Iran",
  "IQ" => "Iraq",
  "IE" => "Ireland",
  "IM" => "Isle of Man",
  "IL" => "Israel",
  "IT" => "Italy",
  "JM" => "Jamaica",
  "JP" => "Japan",
  "JE" => "Jersey",
  "JT" => "Johnston Island",
  "JO" => "Jordan",
  "KZ" => "Kazakhstan",
  "KE" => "Kenya",
  "KI" => "Kiribati",
  "KW" => "Kuwait",
  "KG" => "Kyrgyzstan",
  "LA" => "Laos",
  "LV" => "Latvia",
  "LB" => "Lebanon",
  "LS" => "Lesotho",
  "LR" => "Liberia",
  "LY" => "Libya",
  "LI" => "Liechtenstein",
  "LT" => "Lithuania",
  "LU" => "Luxembourg",
  "MO" => "Macau SAR China",
  "MK" => "Macedonia",
  "MG" => "Madagascar",
  "MW" => "Malawi",
  "MY" => "Malaysia",
  "MV" => "Maldives",
  "ML" => "Mali",
  "MT" => "Malta",
  "MH" => "Marshall Islands",
  "MQ" => "Martinique",
  "MR" => "Mauritania",
  "MU" => "Mauritius",
  "YT" => "Mayotte",
  "FX" => "Metropolitan France",
  "MX" => "Mexico",
  "FM" => "Micronesia",
  "MI" => "Midway Islands",
  "MD" => "Moldova",
  "MC" => "Monaco",
  "MN" => "Mongolia",
  "ME" => "Montenegro",
  "MS" => "Montserrat",
  "MA" => "Morocco",
  "MZ" => "Mozambique",
  "MM" => "Myanmar [Burma]",
  "NA" => "Namibia",
  "NR" => "Nauru",
  "NP" => "Nepal",
  "NL" => "Netherlands",
  "AN" => "Netherlands Antilles",
  "NT" => "Neutral Zone",
  "NC" => "New Caledonia",
  "NZ" => "New Zealand",
  "NI" => "Nicaragua",
  "NE" => "Niger",
  "NG" => "Nigeria",
  "NU" => "Niue",
  "NF" => "Norfolk Island",
  "KP" => "North Korea",
  "VD" => "North Vietnam",
  "MP" => "Northern Mariana Islands",
  "NO" => "Norway",
  "OM" => "Oman",
  "PC" => "Pacific Islands Trust Territory",
  "PK" => "Pakistan",
  "PW" => "Palau",
  "PS" => "Palestinian Territories",
  "PA" => "Panama",
  "PZ" => "Panama Canal Zone",
  "PG" => "Papua New Guinea",
  "PY" => "Paraguay",
  "YD" => "People's Democratic Republic of Yemen",
  "PE" => "Peru",
  "PH" => "Philippines",
  "PN" => "Pitcairn Islands",
  "PL" => "Poland",
  "PT" => "Portugal",
  "PR" => "Puerto Rico",
  "QA" => "Qatar",
  "RO" => "Romania",
  "RU" => "Russia",
  "RW" => "Rwanda",
  "RE" => "Réunion",
  "BL" => "Saint Barthélemy",
  "SH" => "Saint Helena",
  "KN" => "Saint Kitts and Nevis",
  "LC" => "Saint Lucia",
  "MF" => "Saint Martin",
  "PM" => "Saint Pierre and Miquelon",
  "VC" => "Saint Vincent and the Grenadines",
  "WS" => "Samoa",
  "SM" => "San Marino",
  "SA" => "Saudi Arabia",
  "SN" => "Senegal",
  "RS" => "Serbia",
  "CS" => "Serbia and Montenegro",
  "SC" => "Seychelles",
  "SL" => "Sierra Leone",
  "SG" => "Singapore",
  "SK" => "Slovakia",
  "SI" => "Slovenia",
  "SB" => "Solomon Islands",
  "SO" => "Somalia",
  "ZA" => "South Africa",
  "GS" => "South Georgia and the South Sandwich Islands",
  "KR" => "South Korea",
  "ES" => "Spain",
  "LK" => "Sri Lanka",
  "SD" => "Sudan",
  "SR" => "Suriname",
  "SJ" => "Svalbard and Jan Mayen",
  "SZ" => "Swaziland",
  "SE" => "Sweden",
  "CH" => "Switzerland",
  "SY" => "Syria",
  "ST" => "São Tomé and Príncipe",
  "TW" => "Taiwan",
  "TJ" => "Tajikistan",
  "TZ" => "Tanzania",
  "TH" => "Thailand",
  "TL" => "Timor-Leste",
  "TG" => "Togo",
  "TK" => "Tokelau",
  "TO" => "Tonga",
  "TT" => "Trinidad and Tobago",
  "TN" => "Tunisia",
  "TR" => "Turkey",
  "TM" => "Turkmenistan",
  "TC" => "Turks and Caicos Islands",
  "TV" => "Tuvalu",
  "UM" => "U.S. Minor Outlying Islands",
  "PU" => "U.S. Miscellaneous Pacific Islands",
  "VI" => "U.S. Virgin Islands",
  "UG" => "Uganda",
  "UA" => "Ukraine",
  "SU" => "Union of Soviet Socialist Republics",
  "AE" => "United Arab Emirates",
  "GB" => "United Kingdom",
  "US" => "United States",
  "ZZ" => "Unknown or Invalid Region",
  "UY" => "Uruguay",
  "UZ" => "Uzbekistan",
  "VU" => "Vanuatu",
  "VA" => "Vatican City",
  "VE" => "Venezuela",
  "VN" => "Vietnam",
  "WK" => "Wake Island",
  "WF" => "Wallis and Futuna",
  "EH" => "Western Sahara",
  "YE" => "Yemen",
  "ZM" => "Zambia",
  "ZW" => "Zimbabwe",
  "AX" => "Åland Islands",
  );

  function post_captcha($user_response) {
      $fields_string = '';
      $fields = array(
          'secret' => '6LeCUTwUAAAAACA1Q2l6QP8OoI8mpYLqwbIJ6MMW',
          'response' => $user_response
      );
      foreach($fields as $key=>$value)
      $fields_string .= $key . '=' . $value . '&';
      $fields_string = rtrim($fields_string, '&');

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
      curl_setopt($ch, CURLOPT_POST, count($fields));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result, true);
  }

  function quote_smart($value)
  {
    $conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);

     // Stripslashes
     if (get_magic_quotes_gpc()) {
         $value = stripslashes($value);
     }
     // Quote if not integer
     if (!is_numeric($value)) {
         $value = "'" . mysqli_real_escape_string($conn, $value) . "'";
     }
     return $value;
  }

  function bCrypt($pass,$cost)
  {
    $chars='./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $salt=sprintf('$2a$%02d$',$cost);

    for($i=0;$i<22;$i++) {
      $salt.=$chars[mt_rand(0,63)];
    }

    return crypt($pass,$salt);
}

  function friendlyURL($string){
    $string = preg_replace("`\[.*\]`U","",$string);
    $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
    $string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
    return strtolower(trim($string, '-'));
  }

  function get_real_ip()
   {
        $ip = false;
        if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
             $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
             $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
             if($ip)
             {
                  array_unshift($ips, $ip);
                  $ip = false;
             }
             for($i = 0; $i < count($ips); $i++)
             {
                  if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i]))
                  {
                       if(version_compare(phpversion(), "5.0.0", ">="))
                       {
                            if(ip2long($ips[$i]) != false)
                            {
                                 $ip = $ips[$i];
                                 break;
                            }
                       }
                       else
                       {
                            if(ip2long($ips[$i]) != - 1)
                            {
                                 $ip = $ips[$i];
                                 break;
                            }
                       }
                  }
             }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
   }

  function quote_check($value)
  {
    $conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD);

     if (!(get_magic_quotes_gpc())) {
         $value = mysqli_real_escape_string($conn, $value);
     }

     return $value;
  }

  function reconstruct_url($url){
      $url_parts = parse_url($url);
      $constructed_url = $url_parts['scheme'] . '://' . $url_parts['host'] . (isset($url_parts['path'])?$url_parts['path']:'');

      return $constructed_url;
  }

  function calculate_age($birthdate) {

       $datestamp = date("Y-m-d", mktime());
       $t_arr = explode("-" , $datestamp);

       $current_year = $t_arr[0];
       $current_month = $t_arr[1];
       $current_day = $t_arr[2];

       $t_arr = explode("-" , $birthdate);

       $birth_year = $t_arr[0];
       $birth_month = $t_arr[1];
       $birth_day = $t_arr[2];


       $year_dif = $current_year - $birth_year;

       if(($birth_month > $current_month) || ($birth_month == $current_month && $current_day < $birth_day))
           $age = $year_dif - 1;
       else
           $age = $year_dif;

       return $age;
  }

  function addArray(&$array, $key, $val)
  {
     $tempArray = array($key => $val);
     $array = array_merge ($array, $tempArray);
  }

  function renderArraySelect($arrayObj, $selectedItem)
  {
    foreach (array_keys($arrayObj) as $fields)
    {

      if (is_array($selectedItem) && $selectedItem != 0) {

        if (in_array($fields, $selectedItem))
        {
          print "<option selected value=\"".$fields."\">".$arrayObj[$fields]."</option>";
        }
        else
        {
          print "<option value=\"".$fields."\">".$arrayObj[$fields]."</option>";
        }
      }
      else
      {

        if ($selectedItem == $fields && $selectedItem != "")
        {
          print "<option selected value=\"".$fields."\">".$arrayObj[$fields]."</option>";
        }
        else
        {
          print "<option value=\"".$fields."\">".$arrayObj[$fields]."</option>";
        }
      }

    }
  }

  function keygen($max){

    $items = "23456789BCDFGHJKMNPQRSTVWXYZ";
    $x = 1;
    $total = strlen($items) - 1;

    while($x <= $max){

    $rand = rand(0, $total);

    $item = substr($items, $rand, 1);
    if($x == 1){
    $key = $item;
    }
    elseif($x > 1)
    {
    $key .= $item;
    }
    $x++;
    }

    return $key;
  }

  function renderSelectMenu($lookUpList, $dbcon, $selectedOption){
      for($i=0;$i<$lookUpList;$i++){
      $row=$dbcon->data_seek($i);
        if (is_array($selectedOption) && $selectedOption != 0) {

          if (in_array($row["FieldValue"], $selectedOption))
          {
            print "<option selected value=\"".$row["FieldValue"]."\">".$row["FieldDisplay"]."</option>";
          }
          else
          {
            print "<option value=\"".$row["FieldValue"]."\">".$row["FieldDisplay"]."</option>";
          }
        }
        else
        {
          if ($selectedOption == $row["FieldValue"] && $selectedOption != "")
          {
            print "<option selected value=\"".$row["FieldValue"]."\">".$row["FieldDisplay"]."</option>";
          }
          else
          {
            print "<option value=\"".$row["FieldValue"]."\">".$row["FieldDisplay"]."</option>";
          }
        }
      }

  }

    function truncate($text, $limit = 25, $ending = '...')
    {
     $text = strip_tags($text);
     if (strlen($text) > $limit) {
       $text = substr($text, 0, $limit);
       $text = substr($text, 0, -(strlen(strrchr($text, ' '))));
       $text = $text . $ending;
     }
     return $text;
}

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function extractfile($file_json, $type = 'preview', $size = '150x150%23')
{

  if ($file_json[0] != '{') {
    $file_json = '{'.$file_json;
  }

  if (substr($file_json, -1) != '}') {
    $file_json = $file_json.'}';
  }

  $file_info = json_decode($file_json);
  $file_url = $file_info->{'path'};
  $filename = basename($file_url);

  if ($type == 'preview')
  {
    return ATTACHE_DOMAIN."/view/".substr_replace($file_url, "/".$size."/", strrpos($file_url, "/"), strlen("/"));
  }
  elseif ($type == 'file')
  {
    return ATTACHE_DOMAIN."/view/".substr_replace($file_url, "/remote/", strrpos($file_url, "/"), strlen("/"));
  }
}

$dbcon2 = new dBcon_MCI();
$dbcon2->connect();
?>