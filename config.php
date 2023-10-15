<?php
include "includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
        <?php include"includes/css.php"; ?>
        <?php include"includes/js.php"; ?>
    </head>
    <body class="cmenu1 example-target">

        <div>
            <div>
                <?php
                if ($get_db_isLogo == 1) {
                    if ($get_db_Logo == "") {
                        echo '<img src="images/yourLogoHere.png" style="float:left; border:0px;"/>';
                    } else {
                        echo '<img src="uploads/' . $get_db_Logo . '" style="float:left; border:0px;"/>';
                    }
                } else {
                    //echo"<div class='logodiv'>$get_db_CompanyName</div>";
                }
                ?>
            </div>
            <?php
            include"includes/buttons.php";
            ?>			</div>

        <div id='main'>
            <article style="margin-bottom:70px;">
                <?php
                if ($user_GeneralSettings !== "1" and $user_IsAdmin != 1) {


                    echo'<div class="alert alert-warning text-right">
                            ' . $not_have_permission_lang . '
                            </div>';
                } else {
                    ?>
                    <div class="text-center">
    <?php include"includes/config_menu.php"; ?>
                    </div>
                    <fieldset class="clearfix">
                        <legend  align="right"><?php echo"$General_Settings_lang"; ?></legend> 

                        <?php if ($Edit_report !== "") {
                            echo'<div style="padding-bottom:20px;">' . $Edit_report . '</div>';
                        } ?>
                        <form id="myForm"  method="post"  name="myForm">

                            <table  border="0" dir="rtl" cellpadding="0" style="padding-top:0px; text-align:right; color:#009; width:100%;">
                            
                                <tr>
                                    <td class="text-right"><label><?php echo"$company_name_lang"; ?></label>
                                    </td>
                                    <td class="text-right">

                                        <div>
                                            <input type="text" name="CompanyName" value="<?php echo"" . $get_db_CompanyName . ""; ?>"   class="form-control"/>

                                        </div>
                                    </td>
                                    <td class="text-right"><label><?php echo"$time_zone_lang"; ?></label></td>
                                    <td class="text-right"><div><select class="form-control" id="TimeZone" name="TimeZone" dir="ltr">
                                                <option value="Pacific/Midway" <?php if ($get_db_TimeZone == "Pacific/Midway") {
        echo'selected="selected"';
    } ?>>(UTC-11:00) Midway Island</option>
                                                <option value="Pacific/Samoa" <?php if ($get_db_TimeZone == "Pacific/Samoa") {
        echo'selected="selected"';
    } ?>>(UTC-11:00) Samoa</option>
                                                <option value="Pacific/Honolulu" <?php if ($get_db_TimeZone == "Pacific/Honolulu") {
        echo'selected="selected"';
    } ?>>(UTC-10:00) Hawaii</option>
                                                <option value="US/Alaska" <?php if ($get_db_TimeZone == "US/Alaska") {
        echo'selected="selected"';
    } ?>>(UTC-09:00) Alaska</option>
                                                <option value="America/Los_Angeles" <?php if ($get_db_TimeZone == "America/Los_Angeles") {
        echo'selected="selected"';
    } ?>>(UTC-08:00) Pacific Time (US &amp; Canada)</option>
                                                <option value="America/Tijuana" <?php if ($get_db_TimeZone == "America/Tijuana") {
        echo'selected="selected"';
    } ?>>(UTC-08:00) Tijuana</option>
                                                <option value="US/Arizona" <?php if ($get_db_TimeZone == "US/Arizona") {
        echo'selected="selected"';
    } ?>>(UTC-07:00) Arizona</option>
                                                <option value="America/Chihuahua" <?php if ($get_db_TimeZone == "America/Chihuahua") {
        echo'selected="selected"';
    } ?>>(UTC-07:00) Chihuahua</option>
                                                <option value="America/Chihuahua" <?php if ($get_db_TimeZone == "America/Chihuahua") {
        echo'selected="selected"';
    } ?>>(UTC-07:00) La Paz</option>
                                                <option value="America/Mazatlan" <?php if ($get_db_TimeZone == "America/Mazatlan") {
        echo'selected="selected"';
    } ?>>(UTC-07:00) Mazatlan</option>
                                                <option value="US/Mountain" <?php if ($get_db_TimeZone == "US/Mountain") {
        echo'selected="selected"';
    } ?>>(UTC-07:00) Mountain Time (US &amp; Canada)</option>
                                                <option value="America/Managua" <?php if ($get_db_TimeZone == "America/Managua") {
        echo'selected="selected"';
    } ?>>(UTC-06:00) Central America</option>
                                                <option value="US/Central" <?php if ($get_db_TimeZone == "US/Central") {
        echo'selected="selected"';
    } ?>>(UTC-06:00) Central Time (US &amp; Canada)</option>
                                                <option value="America/Mexico_City" <?php if ($get_db_TimeZone == "America/Mexico_City") {
        echo'selected="selected"';
    } ?>>(UTC-06:00) Guadalajara</option>
                                                <option value="America/Mexico_City" <?php if ($get_db_TimeZone == "America/Mexico_City") {
        echo'selected="selected"';
    } ?>>(UTC-06:00) Mexico City</option>
                                                <option value="America/Monterrey" <?php if ($get_db_TimeZone == "America/Monterrey") {
        echo'selected="selected"';
    } ?>>(UTC-06:00) Monterrey</option>
                                                <option value="Canada/Saskatchewan" <?php if ($get_db_TimeZone == "Canada/Saskatchewan") {
        echo'selected="selected"';
    } ?>>(UTC-06:00) Saskatchewan</option>
                                                <option value="America/Bogota" <?php if ($get_db_TimeZone == "America/Bogota") {
        echo'selected="selected"';
    } ?>>(UTC-05:00) Bogota</option>
                                                <option value="US/Eastern" <?php if ($get_db_TimeZone == "US/Eastern") {
        echo'selected="selected"';
    } ?>>(UTC-05:00) Eastern Time (US &amp; Canada)</option>
                                                <option value="US/East-Indiana" <?php if ($get_db_TimeZone == "US/East-Indiana") {
        echo'selected="selected"';
    } ?>>(UTC-05:00) Indiana (East)</option>
                                                <option value="America/Lima" <?php if ($get_db_TimeZone == "America/Lima") {
        echo'selected="selected"';
    } ?>>(UTC-05:00) Lima</option>
                                                <option value="America/Bogota" <?php if ($get_db_TimeZone == "America/Bogota") {
        echo'selected="selected"';
    } ?>>(UTC-05:00) Quito</option>
                                                <option value="Canada/Atlantic" <?php if ($get_db_TimeZone == "Canada/Atlantic") {
        echo'selected="selected"';
    } ?>>(UTC-04:00) Atlantic Time (Canada)</option>
                                                <option value="America/Caracas" <?php if ($get_db_TimeZone == "America/Caracas") {
        echo'selected="selected"';
    } ?>>(UTC-04:30) Caracas</option>
                                                <option value="America/La_Paz" <?php if ($get_db_TimeZone == "America/La_Paz") {
        echo'selected="selected"';
    } ?>>(UTC-04:00) La Paz</option>
                                                <option value="America/Santiago" <?php if ($get_db_TimeZone == "America/Santiago") {
        echo'selected="selected"';
    } ?>>(UTC-04:00) Santiago</option>
                                                <option value="Canada/Newfoundland" <?php if ($get_db_TimeZone == "Canada/Newfoundland") {
        echo'selected="selected"';
    } ?>>(UTC-03:30) Newfoundland</option>
                                                <option value="America/Sao_Paulo" <?php if ($get_db_TimeZone == "America/Sao_Paulo") {
        echo'selected="selected"';
    } ?>>(UTC-03:00) Brasilia</option>
                                                <option value="America/Argentina/Buenos_Aires" <?php if ($get_db_TimeZone == "America/Argentina/Buenos_Aires") {
        echo'selected="selected"';
    } ?>>(UTC-03:00) Buenos Aires</option>
                                                <option value="America/Argentina/Buenos_Aires" <?php if ($get_db_TimeZone == "America/Argentina/Buenos_Aires") {
        echo'selected="selected"';
    } ?>>(UTC-03:00) Georgetown</option>
                                                <option value="America/Godthab" <?php if ($get_db_TimeZone == "America/Godthab") {
        echo'selected="selected"';
    } ?>>(UTC-03:00) Greenland</option>
                                                <option value="America/Noronha" <?php if ($get_db_TimeZone == "America/Noronha") {
        echo'selected="selected"';
    } ?>>(UTC-02:00) Mid-Atlantic</option>
                                                <option value="Atlantic/Azores" <?php if ($get_db_TimeZone == "Atlantic/Azores") {
        echo'selected="selected"';
    } ?>>(UTC-01:00) Azores</option>
                                                <option value="Atlantic/Cape_Verde" <?php if ($get_db_TimeZone == "Atlantic/Cape_Verde") {
        echo'selected="selected"';
    } ?>>(UTC-01:00) Cape Verde Is.</option>
                                                <option value="Africa/Casablanca" <?php if ($get_db_TimeZone == "Africa/Casablanca") {
        echo'selected="selected"';
    } ?>>(UTC+00:00) Casablanca</option>
                                                <option value="Europe/London" <?php if ($get_db_TimeZone == "Europe/London") {
        echo'selected="selected"';
    } ?>>(UTC+00:00) Edinburgh</option>
                                                <option value="Etc/Greenwich" <?php if ($get_db_TimeZone == "Etc/Greenwich") {
        echo'selected="selected"';
    } ?>>(UTC+00:00) Greenwich Mean Time : Dublin</option>
                                                <option value="Europe/Lisbon" <?php if ($get_db_TimeZone == "Europe/Lisbon") {
        echo'selected="selected"';
    } ?>>(UTC+00:00) Lisbon</option>
                                                <option value="Europe/London" <?php if ($get_db_TimeZone == "Europe/London") {
        echo'selected="selected"';
    } ?>>(UTC+00:00) London</option>
                                                <option value="Africa/Monrovia" <?php if ($get_db_TimeZone == "Africa/Monrovia") {
        echo'selected="selected"';
    } ?>>(UTC+00:00) Monrovia</option>
                                                <option value="UTC" <?php if ($get_db_TimeZone == "UTC") {
        echo'selected="selected"';
    } ?>>(UTC+00:00) UTC</option>
                                                <option value="Europe/Amsterdam" <?php if ($get_db_TimeZone == "Europe/Amsterdam") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Amsterdam</option>
                                                <option value="Europe/Belgrade" <?php if ($get_db_TimeZone == "Europe/Belgrade") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Belgrade</option>
                                                <option value="Europe/Berlin" <?php if ($get_db_TimeZone == "Europe/Berlin") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Berlin</option>
                                                <option value="Europe/Berlin" <?php if ($get_db_TimeZone == "Europe/Berlin") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Bern</option>
                                                <option value="Europe/Bratislava" <?php if ($get_db_TimeZone == "Europe/Bratislava") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Bratislava</option>
                                                <option value="Europe/Brussels" <?php if ($get_db_TimeZone == "Europe/Brussels") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Brussels</option>
                                                <option value="Europe/Budapest" <?php if ($get_db_TimeZone == "Europe/Budapest") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Budapest</option>
                                                <option value="Europe/Copenhagen" <?php if ($get_db_TimeZone == "Europe/Copenhagen") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Copenhagen</option>
                                                <option value="Europe/Ljubljana" <?php if ($get_db_TimeZone == "Europe/Ljubljana") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Ljubljana</option>
                                                <option value="Europe/Madrid" <?php if ($get_db_TimeZone == "Europe/Madrid") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Madrid</option>
                                                <option value="Europe/Paris" <?php if ($get_db_TimeZone == "Europe/Paris") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Paris</option>
                                                <option value="Europe/Prague" <?php if ($get_db_TimeZone == "Europe/Prague") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Prague</option>
                                                <option value="Europe/Rome" <?php if ($get_db_TimeZone == "Europe/Rome") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Rome</option>
                                                <option value="Europe/Sarajevo" <?php if ($get_db_TimeZone == "Europe/Sarajevo") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Sarajevo</option>
                                                <option value="Europe/Skopje" <?php if ($get_db_TimeZone == "Europe/Skopje") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Skopje</option>
                                                <option value="Europe/Stockholm" <?php if ($get_db_TimeZone == "Europe/Stockholm") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Stockholm</option>
                                                <option value="Europe/Vienna" <?php if ($get_db_TimeZone == "Europe/Vienna") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Vienna</option>
                                                <option value="Europe/Warsaw" <?php if ($get_db_TimeZone == "Europe/Warsaw") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Warsaw</option>
                                                <option value="Africa/Lagos" <?php if ($get_db_TimeZone == "Africa/Lagos") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) West Central Africa</option>
                                                <option value="Europe/Zagreb" <?php if ($get_db_TimeZone == "Europe/Zagreb") {
        echo'selected="selected"';
    } ?>>(UTC+01:00) Zagreb</option>
                                                <option value="Europe/Athens" <?php if ($get_db_TimeZone == "Europe/Athens") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Athens</option>
                                                <option value="Europe/Bucharest"  <?php if ($get_db_TimeZone == "Europe/Bucharest") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Bucharest</option>
                                                <option value="Africa/Cairo" <?php if ($get_db_TimeZone == "Africa/Cairo") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Cairo</option>
                                                <option value="Africa/Harare" <?php if ($get_db_TimeZone == "Africa/Harare") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Harare</option>
                                                <option value="Europe/Helsinki" <?php if ($get_db_TimeZone == "Europe/Helsinki") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Helsinki</option>
                                                <option value="Europe/Istanbul" <?php if ($get_db_TimeZone == "Europe/Istanbul") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Istanbul</option>
                                                <option value="Asia/Jerusalem" <?php if ($get_db_TimeZone == "Asia/Jerusalem") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Jerusalem</option>
                                                <option value="Europe/Helsinki" <?php if ($get_db_TimeZone == "Europe/Helsinki") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Kyiv</option>
                                                <option value="Africa/Johannesburg" <?php if ($get_db_TimeZone == "Africa/Johannesburg") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Pretoria</option>
                                                <option value="Europe/Riga" <?php if ($get_db_TimeZone == "Europe/Riga") {
                    echo'selected="selected"';
                } ?>>(UTC+02:00) Riga</option>
                                                <option value="Europe/Sofia" <?php if ($get_db_TimeZone == "Europe/Sofia") {
                    echo'selected="selected"';
                } ?>>(UTC+02:00) Sofia</option>
                                                <option value="Europe/Tallinn" <?php if ($get_db_TimeZone == "Europe/Tallinn") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Tallinn</option>
                                                <option value="Europe/Vilnius" <?php if ($get_db_TimeZone == "Europe/Vilnius") {
        echo'selected="selected"';
    } ?>>(UTC+02:00) Vilnius</option>
                                                <option value="Asia/Baghdad" <?php if ($get_db_TimeZone == "Asia/Baghdad") {
        echo'selected="selected"';
    } ?>>(UTC+03:00) Baghdad</option>
                                                <option value="Asia/Kuwait" <?php if ($get_db_TimeZone == "Asia/Kuwait") {
        echo'selected="selected"';
    } ?>>(UTC+03:00) Kuwait</option>
                                                <option value="Europe/Minsk" <?php if ($get_db_TimeZone == "Europe/Minsk") {
        echo'selected="selected"';
    } ?>>(UTC+03:00) Minsk</option>
                                                <option value="Africa/Nairobi" <?php if ($get_db_TimeZone == "Africa/Nairobi") {
        echo'selected="selected"';
    } ?>>(UTC+03:00) Nairobi</option>
                                                <option value="Asia/Riyadh" <?php if ($get_db_TimeZone == "Asia/Riyadh") {
        echo'selected="selected"';
    } ?>>(UTC+03:00) Riyadh</option>
                                                <option value="Europe/Volgograd" <?php if ($get_db_TimeZone == "Europe/Volgograd") {
        echo'selected="selected"';
    } ?>>(UTC+03:00) Volgograd</option>
                                                <option value="Asia/Tehran" <?php if ($get_db_TimeZone == "Asia/Tehran") {
        echo'selected="selected"';
    } ?>>(UTC+03:30) Tehran</option>
                                                <option value="Asia/Muscat" <?php if ($get_db_TimeZone == "Asia/Muscat") {
        echo'selected="selected"';
    } ?>>(UTC+04:00) Abu Dhabi</option>
                                                <option value="Asia/Baku" <?php if ($get_db_TimeZone == "Asia/Baku") {
        echo'selected="selected"';
    } ?>>(UTC+04:00) Baku</option>
                                                <option value="Europe/Moscow" <?php if ($get_db_TimeZone == "Europe/Moscow") {
        echo'selected="selected"';
    } ?>>(UTC+04:00) Moscow</option>
                                                <option value="Asia/Muscat" <?php if ($get_db_TimeZone == "Asia/Muscat") {
        echo'selected="selected"';
    } ?>>(UTC+04:00) Muscat</option>
                                                <option value="Europe/Moscow" <?php if ($get_db_TimeZone == "Europe/Moscow") {
        echo'selected="selected"';
    } ?>>(UTC+04:00) St. Petersburg</option>
                                                <option value="Asia/Tbilisi" <?php if ($get_db_TimeZone == "Asia/Tbilisi") {
        echo'selected="selected"';
    } ?>>(UTC+04:00) Tbilisi</option>
                                                <option value="Asia/Yerevan" <?php if ($get_db_TimeZone == "Asia/Yerevan") {
        echo'selected="selected"';
    } ?>>(UTC+04:00) Yerevan</option>
                                                <option value="Asia/Kabul" <?php if ($get_db_TimeZone == "Asia/Kabul") {
        echo'selected="selected"';
    } ?>>(UTC+04:30) Kabul</option>
                                                <option value="Asia/Karachi" <?php if ($get_db_TimeZone == "Asia/Karachi") {
        echo'selected="selected"';
    } ?>>(UTC+05:00) Islamabad</option>
                                                <option value="Asia/Karachi" <?php if ($get_db_TimeZone == "Asia/Karachi") {
        echo'selected="selected"';
    } ?>>(UTC+05:00) Karachi</option>
                                                <option value="Asia/Tashkent" <?php if ($get_db_TimeZone == "Asia/Tashkent") {
        echo'selected="selected"';
    } ?>>(UTC+05:00) Tashkent</option>
                                                <option value="Asia/Calcutta" <?php if ($get_db_TimeZone == "Asia/Calcutta") {
        echo'selected="selected"';
    } ?>>(UTC+05:30) Chennai</option>
                                                <option value="Asia/Kolkata" <?php if ($get_db_TimeZone == "Asia/Kolkata") {
        echo'selected="selected"';
    } ?>>(UTC+05:30) Kolkata</option>
                                                <option value="Asia/Calcutta" <?php if ($get_db_TimeZone == "Asia/Calcutta") {
        echo'selected="selected"';
    } ?>>(UTC+05:30) Mumbai</option>
                                                <option value="Asia/Calcutta" <?php if ($get_db_TimeZone == "Asia/Calcutta") {
        echo'selected="selected"';
    } ?>>(UTC+05:30) New Delhi</option>
                                                <option value="Asia/Calcutta" <?php if ($get_db_TimeZone == "Asia/Calcutta") {
        echo'selected="selected"';
    } ?>>(UTC+05:30) Sri Jayawardenepura</option>
                                                <option value="Asia/Katmandu" <?php if ($get_db_TimeZone == "Asia/Katmandu") {
        echo'selected="selected"';
    } ?>>(UTC+05:45) Kathmandu</option>
                                                <option value="Asia/Almaty" <?php if ($get_db_TimeZone == "Asia/Almaty") {
        echo'selected="selected"';
    } ?>>(UTC+06:00) Almaty</option>
                                                <option value="Asia/Dhaka" <?php if ($get_db_TimeZone == "Asia/Dhaka") {
        echo'selected="selected"';
    } ?>>(UTC+06:00) Astana</option>
                                                <option value="Asia/Dhaka" <?php if ($get_db_TimeZone == "Asia/Dhaka") {
        echo'selected="selected"';
    } ?>>(UTC+06:00) Dhaka</option>
                                                <option value="Asia/Yekaterinburg" <?php if ($get_db_TimeZone == "Asia/Yekaterinburg") {
        echo'selected="selected"';
    } ?>>(UTC+06:00) Ekaterinburg</option>
                                                <option value="Asia/Rangoon" <?php if ($get_db_TimeZone == "Asia/Rangoon") {
        echo'selected="selected"';
    } ?>>(UTC+06:30) Rangoon</option>
                                                <option value="Asia/Bangkok" <?php if ($get_db_TimeZone == "Asia/Bangkok") {
        echo'selected="selected"';
    } ?>>(UTC+07:00) Bangkok</option>
                                                <option value="Asia/Bangkok" <?php if ($get_db_TimeZone == "Asia/Bangkok") {
        echo'selected="selected"';
    } ?>>(UTC+07:00) Hanoi</option>
                                                <option value="Asia/Jakarta" <?php if ($get_db_TimeZone == "Asia/Jakarta") {
        echo'selected="selected"';
    } ?>>(UTC+07:00) Jakarta</option>
                                                <option value="Asia/Novosibirsk" <?php if ($get_db_TimeZone == "Asia/Novosibirsk") {
        echo'selected="selected"';
    } ?>>(UTC+07:00) Novosibirsk</option>
                                                <option value="Asia/Hong_Kong" <?php if ($get_db_TimeZone == "Asia/Hong_Kong") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Beijing</option>
                                                <option value="Asia/Chongqing" <?php if ($get_db_TimeZone == "Asia/Chongqing") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Chongqing</option>
                                                <option value="Asia/Hong_Kong" <?php if ($get_db_TimeZone == "Asia/Hong_Kong") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Hong Kong</option>
                                                <option value="Asia/Krasnoyarsk" <?php if ($get_db_TimeZone == "Asia/Krasnoyarsk") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Krasnoyarsk</option>
                                                <option value="Asia/Kuala_Lumpur" <?php if ($get_db_TimeZone == "Asia/Kuala_Lumpur") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Kuala Lumpur</option>
                                                <option value="Australia/Perth" <?php if ($get_db_TimeZone == "Australia/Perth") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Perth</option>
                                                <option value="Asia/Singapore" <?php if ($get_db_TimeZone == "Asia/Singapore") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Singapore</option>
                                                <option value="Asia/Taipei" <?php if ($get_db_TimeZone == "Asia/Taipei") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Taipei</option>
                                                <option value="Asia/Ulan_Bator" <?php if ($get_db_TimeZone == "Asia/Ulan_Bator") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Ulaan Bataar</option>
                                                <option value="Asia/Urumqi" <?php if ($get_db_TimeZone == "Asia/Urumqi") {
        echo'selected="selected"';
    } ?>>(UTC+08:00) Urumqi</option>
                                                <option value="Asia/Irkutsk" <?php if ($get_db_TimeZone == "Asia/Irkutsk") {
        echo'selected="selected"';
    } ?>>(UTC+09:00) Irkutsk</option>
                                                <option value="Asia/Tokyo" <?php if ($get_db_TimeZone == "Asia/Tokyo") {
        echo'selected="selected"';
    } ?>>(UTC+09:00) Osaka</option>
                                                <option value="Asia/Tokyo" <?php if ($get_db_TimeZone == "Asia/Tokyo") {
        echo'selected="selected"';
    } ?>>(UTC+09:00) Sapporo</option>
                                                <option value="Asia/Seoul" <?php if ($get_db_TimeZone == "Asia/Seoul") {
        echo'selected="selected"';
    } ?>>(UTC+09:00) Seoul</option>
                                                <option value="Asia/Tokyo" <?php if ($get_db_TimeZone == "Asia/Tokyo") {
        echo'selected="selected"';
    } ?>>(UTC+09:00) Tokyo</option>
                                                <option value="Australia/Adelaide" <?php if ($get_db_TimeZone == "Australia/Adelaide") {
        echo'selected="selected"';
    } ?>>(UTC+09:30) Adelaide</option>
                                                <option value="Australia/Darwin" <?php if ($get_db_TimeZone == "Australia/Darwin") {
        echo'selected="selected"';
    } ?>>(UTC+09:30) Darwin</option>
                                                <option value="Australia/Brisbane" <?php if ($get_db_TimeZone == "Australia/Brisbane") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Brisbane</option>
                                                <option value="Australia/Canberra" <?php if ($get_db_TimeZone == "Australia/Canberra") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Canberra</option>
                                                <option value="Pacific/Guam" <?php if ($get_db_TimeZone == "Pacific/Guam") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Guam</option>
                                                <option value="Australia/Hobart" <?php if ($get_db_TimeZone == "Australia/Hobart") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Hobart</option>
                                                <option value="Australia/Melbourne" <?php if ($get_db_TimeZone == "Australia/Melbourne") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Melbourne</option>
                                                <option value="Pacific/Port_Moresby" <?php if ($get_db_TimeZone == "Pacific/Port_Moresby") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Port Moresby</option>
                                                <option value="Australia/Sydney" <?php if ($get_db_TimeZone == "Australia/Sydney") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Sydney</option>
                                                <option value="Asia/Yakutsk" <?php if ($get_db_TimeZone == "Asia/Yakutsk") {
        echo'selected="selected"';
    } ?>>(UTC+10:00) Yakutsk</option>
                                                <option value="Asia/Vladivostok" <?php if ($get_db_TimeZone == "Asia/Vladivostok") {
        echo'selected="selected"';
    } ?>>(UTC+11:00) Vladivostok</option>
                                                <option value="Pacific/Auckland" <?php if ($get_db_TimeZone == "Pacific/Auckland") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) Auckland</option>
                                                <option value="Pacific/Fiji" <?php if ($get_db_TimeZone == "Pacific/Fiji") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) Fiji</option>
                                                <option value="Pacific/Kwajalein" <?php if ($get_db_TimeZone == "Pacific/Kwajalein") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) International Date Line West</option>
                                                <option value="Asia/Kamchatka" <?php if ($get_db_TimeZone == "Asia/Kamchatka") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) Kamchatka</option>
                                                <option value="Asia/Magadan" <?php if ($get_db_TimeZone == "Asia/Magadan") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) Magadan</option>
                                                <option value="Pacific/Fiji" <?php if ($get_db_TimeZone == "Pacific/Fiji") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) Marshall Is.</option>
                                                <option value="Asia/Magadan" <?php if ($get_db_TimeZone == "Asia/Magadan") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) New Caledonia</option>
                                                <option value="Asia/Magadan" <?php if ($get_db_TimeZone == "Asia/Magadan") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) Solomon Is.</option>
                                                <option value="Pacific/Auckland" <?php if ($get_db_TimeZone == "Pacific/Auckland") {
        echo'selected="selected"';
    } ?>>(UTC+12:00) Wellington</option>
                                                <option value="Pacific/Tongatapu" <?php if ($get_db_TimeZone == "Pacific/Tongatapu") {
        echo'selected="selected"';
    } ?>>(UTC+13:00) Nuku'alofa</option>
                                            </select></div></td>
                                    <td class="text-right"><label><?php echo"$Phone_number_lang"; ?></label></td>
                                    <td class="text-right"><div><input type="text" name="Phone" value="<?php echo"" . $get_db_Phone . ""; ?>" id="Phone"  class="form-control"/></div></td>
                                </tr>       
                                <tr>
                                    <td class="text-right"><label><?php echo"$Currency_lang"; ?></label></td>
                                    <td class="text-right"><div><select name="Currency"  class="form-control">
                                                <option value="1"  <?php if ($db_currency == "1") {
        echo'selected';
    } ?> >ريال</option>
                                                <option value="2" <?php if ($db_currency == "2") {
        echo'selected';
    } ?>>جنيه</option>
                                                <option value="3" <?php if ($db_currency == "3") {
        echo'selected';
    } ?>>دينار</option>
                                                <option value="4" <?php if ($db_currency == "4") {
        echo'selected';
    } ?>>Dollar</option>
                                                <option value="5" <?php if ($db_currency == "5") {
        echo'selected';
    } ?>>Euro</option>
                                            </select></div>

                                    </td>
                                    <td class="text-right"><label><?php echo"$Email_lang"; ?></label></td>
                                    <td class="text-right"><div><input type="text" name="E_mail" value="<?php echo"" . $get_db_E_mail . ""; ?>"  class="form-control" />
                                        </div>
                                    </td>
                                    <td class="text-right"><label><?php echo"$Website_lang"; ?></label></td>
                                    <td class="text-right"><input type="text" name="Website" value="<?php echo"" . $get_db_Website . ""; ?>"   class="form-control"/>

                                    </td>

                                </tr>

                                <tr>
                                    <td class="text-right"><label><?php echo"$Address_lang"; ?></label></td>
                                    <td class="text-right"><div><input type="text" name="Address"  id="Address" value="<?php echo"" . $get_db_Address . ""; ?>"    class="form-control"/></div></td>
                                    <td class="text-right"><label><?php echo"$Return_Policy_lang"; ?></label></td>
                                    <td class="text-right"><div><input type="text" name="ReturnPolicy"  id="ReturnPolicy" value="<?php echo"" . $get_db_ReturnPolicy . ""; ?>"  class="form-control"/></div></td>
                                    <td class="text-right"><label><?php echo"$tax_lang"; ?></label></td>
                                    <td class="text-right"><div><input type="text" name="tax"  id="tax" value="<?php echo"" . $db_tax . ""; ?>"  class="form-control"/></div></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><label><?php echo"$language_lang"; ?></label></td>
                                    <td class="text-right"><div><select name="Language" class="form-control" >
                                                <option value="1" <?php if ($get_db_Language == "1") {
        echo'selected="selected"';
    } ?>>العربية</option>
                                            </select></div></td>
                                    <td class="text-right"><span style="text-align:right; direction:rtl;"><label><?php echo"$Custom_Field1_lang"; ?></label></span></td>
                                    <td class="text-right"><span style="text-align:right; direction:rtl;">
                                            <div><input type="text" name="CustomField1" value="<?php echo"" . $get_db_CustomField1 . ""; ?>" id="CustomField1"  class="form-control"/></div>
                                        </span></td>
                                    <td class="text-right"><label><?php echo"$Custom_Field2_lang"; ?></label></td>
                                    <td class="text-right"><div><input type="text" name="CustomField2" value="<?php echo"" . $get_db_CustomField2 . ""; ?>" id="CustomField2" class="form-control" /></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="6" class="text-center"><div><input type="submit" name="Editconfig" id="Editconfig" value="<?php echo"$Modify_lang"; ?>" class="button"  /></div></td>
                                </tr>
                                <tr class="text-right">
                                    <td></td>
                                    <td class="text-right"></td>
                                    <td style="text-align:right; vertical-align:middle;"></td>
                                    <td style="text-align:right; direction:rtl;"></td>

                                </tr>
                        
                            </table>
                        </form>
                    </fieldset>            
<?php } ?> 
            </article>

        </div>

        <div id="toolbar">
            <footer>
<?php include"includes/scroller_container.php"; ?>
            </footer>
        </div>
    </body>

</html>
<?php include 'includes/footer.php'; ?>