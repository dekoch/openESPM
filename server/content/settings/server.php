<?php

	if($_POST['settingsapply'] == 'true')
	{
		$serverini = parse_ini_file('config/server.ini.php');

		$serverini['servername'] = htmlspecialchars($_POST['name']);
		//$serverini['language'] = $_POST['lang'];
		$serverini['logrequest'] = $_POST['enablereq'];
		$serverini['timezone'] = $_POST['timezone'];


		if($_POST['password'] != '')
		{
			$serverini['hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
		}
	

		write_php_ini($serverini, 'config/server.ini.php');

		// load new settings
		$_SESSION['serverini'] = '';
		$_SESSION['refresh'] = true;
	}

	if($_POST['resetpwd'] == 'true')
	{
		$serverini = parse_ini_file('config/server.ini.php');

		$serverini['hash'] = '';

		write_php_ini($serverini, 'config/server.ini.php');

		// load new settings
		$_SESSION['serverini'] = '';
	}

?>

<!-- Language:
<select id="cmbLang" name="lang">
	<option <?php if($serverini['language'] == 'en'){echo 'selected'; }?>>en</option>
	<option <?php if($serverini['language'] == 'de'){echo 'selected'; }?>>de</option>
</select>
<br>
<br> -->
Password: <input type="text" name="password"/>
<button type="submit" name="resetpwd" value="true" class="btn btn-danger">reset</button>
<br>
<!-- Login URL: -->
<?php
	if($serverini['hash'] != '')
	{
		$hashurl = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['REQUEST_URI']).'/index.php?hash='.$serverini['hash'];
		echo 'Login URL: <a href='.$hashurl.' target="_blank">'.$hashurl.'</a><br>';
	}
?>
<br>
Timezone:
<select id="cmbTimeZone" name="timezone">
	<option <?php if($serverini['timezone'] == 'Pacific/Midway'){echo 'selected'; }?>  value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
	<option <?php if($serverini['timezone'] == 'America/Adak'){echo 'selected'; }?>  value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
	<option <?php if($serverini['timezone'] == 'Etc/GMT+10'){echo 'selected'; }?>  value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
	<option <?php if($serverini['timezone'] == 'Pacific/Marquesas'){echo 'selected'; }?>  value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
	<option <?php if($serverini['timezone'] == 'Pacific/Gambier'){echo 'selected'; }?>  value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
	<option <?php if($serverini['timezone'] == 'America/Anchorage'){echo 'selected'; }?>  value="America/Anchorage">(GMT-09:00) Alaska</option>
	<option <?php if($serverini['timezone'] == 'America/Ensenada'){echo 'selected'; }?>  value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
	<option <?php if($serverini['timezone'] == 'Etc/GMT+8'){echo 'selected'; }?>  value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
	<option <?php if($serverini['timezone'] == 'America/Los_Angeles'){echo 'selected'; }?>  value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
	<option <?php if($serverini['timezone'] == 'America/Denver'){echo 'selected'; }?>  value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
	<option <?php if($serverini['timezone'] == 'America/Chihuahua'){echo 'selected'; }?>  value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
	<option <?php if($serverini['timezone'] == 'America/Dawson_Creek'){echo 'selected'; }?>  value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
	<option <?php if($serverini['timezone'] == 'America/Belize'){echo 'selected'; }?>  value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
	<option <?php if($serverini['timezone'] == 'America/Cancun'){echo 'selected'; }?>  value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
	<option <?php if($serverini['timezone'] == 'Chile/EasterIsland'){echo 'selected'; }?>  value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
	<option <?php if($serverini['timezone'] == 'America/Chicago'){echo 'selected'; }?>  value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
	<option <?php if($serverini['timezone'] == 'America/New_York'){echo 'selected'; }?>  value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
	<option <?php if($serverini['timezone'] == 'America/Havana'){echo 'selected'; }?>  value="America/Havana">(GMT-05:00) Cuba</option>
	<option <?php if($serverini['timezone'] == 'America/Bogota'){echo 'selected'; }?>  value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
	<option <?php if($serverini['timezone'] == 'America/Caracas'){echo 'selected'; }?>  value="America/Caracas">(GMT-04:30) Caracas</option>
	<option <?php if($serverini['timezone'] == 'America/Santiago'){echo 'selected'; }?>  value="America/Santiago">(GMT-04:00) Santiago</option>
	<option <?php if($serverini['timezone'] == 'America/La_Paz'){echo 'selected'; }?>  value="America/La_Paz">(GMT-04:00) La Paz</option>
	<option <?php if($serverini['timezone'] == 'Atlantic/Stanley'){echo 'selected'; }?>  value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
	<option <?php if($serverini['timezone'] == 'America/Campo_Grande'){echo 'selected'; }?>  value="America/Campo_Grande">(GMT-04:00) Brazil</option>
	<option <?php if($serverini['timezone'] == 'America/Goose_Bay'){echo 'selected'; }?>  value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
	<option <?php if($serverini['timezone'] == 'America/Glace_Bay'){echo 'selected'; }?>  value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
	<option <?php if($serverini['timezone'] == 'America/St_Johns'){echo 'selected'; }?>  value="America/St_Johns">(GMT-03:30) Newfoundland</option>
	<option <?php if($serverini['timezone'] == 'America/Araguaina'){echo 'selected'; }?>  value="America/Araguaina">(GMT-03:00) UTC-3</option>
	<option <?php if($serverini['timezone'] == 'America/Montevideo'){echo 'selected'; }?>  value="America/Montevideo">(GMT-03:00) Montevideo</option>
	<option <?php if($serverini['timezone'] == 'America/Miquelon'){echo 'selected'; }?>  value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
	<option <?php if($serverini['timezone'] == 'America/Godthab'){echo 'selected'; }?>  value="America/Godthab">(GMT-03:00) Greenland</option>
	<option <?php if($serverini['timezone'] == 'America/Argentina/Buenos_Aires'){echo 'selected'; }?>  value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
	<option <?php if($serverini['timezone'] == 'America/Sao_Paulo'){echo 'selected'; }?>  value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
	<option <?php if($serverini['timezone'] == 'America/Noronha'){echo 'selected'; }?>  value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
	<option <?php if($serverini['timezone'] == 'Atlantic/Cape_Verde'){echo 'selected'; }?>  value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
	<option <?php if($serverini['timezone'] == 'Atlantic/Azores'){echo 'selected'; }?>  value="Atlantic/Azores">(GMT-01:00) Azores</option>
	<option <?php if($serverini['timezone'] == 'Europe/Belfast'){echo 'selected'; }?>  value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
	<option <?php if($serverini['timezone'] == 'Europe/Dublin'){echo 'selected'; }?>  value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
	<option <?php if($serverini['timezone'] == 'Europe/Lisbon'){echo 'selected'; }?>  value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
	<option <?php if($serverini['timezone'] == 'Europe/London'){echo 'selected'; }?>  value="Europe/London">(GMT) Greenwich Mean Time : London</option>
	<option <?php if($serverini['timezone'] == 'Africa/Abidjan'){echo 'selected'; }?>  value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
	<option <?php if($serverini['timezone'] == 'Europe/Amsterdam'){echo 'selected'; }?>  value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
	<option <?php if($serverini['timezone'] == 'Europe/Belgrade'){echo 'selected'; }?>  value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
	<option <?php if($serverini['timezone'] == 'Europe/Brussels'){echo 'selected'; }?>  value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
	<option <?php if($serverini['timezone'] == 'Africa/Algiers'){echo 'selected'; }?>  value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
	<option <?php if($serverini['timezone'] == 'Africa/Windhoek'){echo 'selected'; }?>  value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
	<option <?php if($serverini['timezone'] == 'Asia/Beirut'){echo 'selected'; }?>  value="Asia/Beirut">(GMT+02:00) Beirut</option>
	<option <?php if($serverini['timezone'] == 'Africa/Cairo'){echo 'selected'; }?>  value="Africa/Cairo">(GMT+02:00) Cairo</option>
	<option <?php if($serverini['timezone'] == 'Asia/Gaza'){echo 'selected'; }?>  value="Asia/Gaza">(GMT+02:00) Gaza</option>
	<option <?php if($serverini['timezone'] == 'Africa/Blantyre'){echo 'selected'; }?>  value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
	<option <?php if($serverini['timezone'] == 'Asia/Jerusalem'){echo 'selected'; }?>  value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
	<option <?php if($serverini['timezone'] == 'Europe/Minsk'){echo 'selected'; }?>  value="Europe/Minsk">(GMT+02:00) Minsk</option>
	<option <?php if($serverini['timezone'] == 'Asia/Damascus'){echo 'selected'; }?>  value="Asia/Damascus">(GMT+02:00) Syria</option>
	<option <?php if($serverini['timezone'] == 'Europe/Moscow'){echo 'selected'; }?>  value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
	<option <?php if($serverini['timezone'] == 'Africa/Addis_Ababa'){echo 'selected'; }?>  value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
	<option <?php if($serverini['timezone'] == 'Asia/Tehran'){echo 'selected'; }?>  value="Asia/Tehran">(GMT+03:30) Tehran</option>
	<option <?php if($serverini['timezone'] == 'Asia/Dubai'){echo 'selected'; }?>  value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
	<option <?php if($serverini['timezone'] == 'Asia/Yerevan'){echo 'selected'; }?>  value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
	<option <?php if($serverini['timezone'] == 'Asia/Kabul'){echo 'selected'; }?>  value="Asia/Kabul">(GMT+04:30) Kabul</option>
	<option <?php if($serverini['timezone'] == 'Asia/Yekaterinburg'){echo 'selected'; }?>  value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
	<option <?php if($serverini['timezone'] == 'Asia/Tashkent'){echo 'selected'; }?>  value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
	<option <?php if($serverini['timezone'] == 'Asia/Kolkata'){echo 'selected'; }?>  value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
	<option <?php if($serverini['timezone'] == 'Asia/Katmandu'){echo 'selected'; }?>  value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
	<option <?php if($serverini['timezone'] == 'Asia/Dhaka'){echo 'selected'; }?>  value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
	<option <?php if($serverini['timezone'] == 'Asia/Novosibirsk'){echo 'selected'; }?>  value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
	<option <?php if($serverini['timezone'] == 'Asia/Rangoon'){echo 'selected'; }?>  value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
	<option <?php if($serverini['timezone'] == 'Asia/Bangkok'){echo 'selected'; }?>  value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
	<option <?php if($serverini['timezone'] == 'Asia/Krasnoyarsk'){echo 'selected'; }?>  value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
	<option <?php if($serverini['timezone'] == 'Asia/Hong_Kong'){echo 'selected'; }?>  value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
	<option <?php if($serverini['timezone'] == 'Asia/Irkutsk'){echo 'selected'; }?>  value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
	<option <?php if($serverini['timezone'] == 'Australia/Perth'){echo 'selected'; }?>  value="Australia/Perth">(GMT+08:00) Perth</option>
	<option <?php if($serverini['timezone'] == 'Australia/Eucla'){echo 'selected'; }?>  value="Australia/Eucla">(GMT+08:45) Eucla</option>
	<option <?php if($serverini['timezone'] == 'Asia/Tokyo'){echo 'selected'; }?>  value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
	<option <?php if($serverini['timezone'] == 'Asia/Seoul'){echo 'selected'; }?>  value="Asia/Seoul">(GMT+09:00) Seoul</option>
	<option <?php if($serverini['timezone'] == 'Asia/Yakutsk'){echo 'selected'; }?>  value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
	<option <?php if($serverini['timezone'] == 'Australia/Adelaide'){echo 'selected'; }?>  value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
	<option <?php if($serverini['timezone'] == 'Australia/Darwin'){echo 'selected'; }?>  value="Australia/Darwin">(GMT+09:30) Darwin</option>
	<option <?php if($serverini['timezone'] == 'Australia/Brisbane'){echo 'selected'; }?>  value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
	<option <?php if($serverini['timezone'] == 'Australia/Hobart'){echo 'selected'; }?>  value="Australia/Hobart">(GMT+10:00) Hobart</option>
	<option <?php if($serverini['timezone'] == 'Asia/Vladivostok'){echo 'selected'; }?>  value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
	<option <?php if($serverini['timezone'] == 'Australia/Lord_Howe'){echo 'selected'; }?>  value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
	<option <?php if($serverini['timezone'] == 'Etc/GMT-11'){echo 'selected'; }?>  value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
	<option <?php if($serverini['timezone'] == 'Asia/Magadan'){echo 'selected'; }?>  value="Asia/Magadan">(GMT+11:00) Magadan</option>
	<option <?php if($serverini['timezone'] == 'Pacific/Norfolk'){echo 'selected'; }?>  value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
	<option <?php if($serverini['timezone'] == 'Asia/Anadyr'){echo 'selected'; }?>  value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
	<option <?php if($serverini['timezone'] == 'Pacific/Auckland'){echo 'selected'; }?>  value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
	<option <?php if($serverini['timezone'] == 'Etc/GMT-12'){echo 'selected'; }?>  value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
	<option <?php if($serverini['timezone'] == 'Pacific/Chatham'){echo 'selected'; }?>  value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
	<option <?php if($serverini['timezone'] == 'Pacific/Tongatapu'){echo 'selected'; }?>  value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
	<option <?php if($serverini['timezone'] == 'Pacific/Kiritimati'){echo 'selected'; }?>  value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
</select>
<br>
Log requests:
<select id="cmbEnableReq" name="enablereq">
	<option <?php if($serverini['logrequest'] == 'on'){echo 'selected'; }?>>on</option>
	<option <?php if($serverini['logrequest'] == 'off'){echo 'selected'; }?>>off</option>
</select>
<br>
Servername: <input type="text" name="name" value="<?php echo $serverini['servername'] ?>" />
<hr>
<?php include 'serverlog.php'; ?>



