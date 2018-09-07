<?php
header('Content-Type: application/json');
require("dbconnect.php");
$forge_data = file_get_contents("http://files.minecraftforge.net/maven/net/minecraftforge/forge/promotions.json");
$versions = [];
$forges = [];
$id = 0;
foreach(json_decode($forge_data, true)['promos'] as $forge => $ff) {
	$id++;
	if($forge !== "latest" & $forge !== "recommended") {
		if(strpos($forge, "latest")) {
			$fv = str_replace("-latest", "", $forge);
			$fvs = $ff['version'];
			foreach ($ff['files'] as $file) {
				$fext=$file[0];
				if($fext=="zip"||$fext=="jar") {
					$fn = str_replace("latest", $fvs, $forge);
					$versions[$fv] = "https://files.minecraftforge.net/maven/net/minecraftforge/forge/".$fn."/forge-".$fn."-universal.".$fext;
				}
			}
			$modsq = mysqli_query($conn, "SELECT * FROM `mods` WHERE `name` = 'forge' AND `version` = '".$fvs."'");
			$handle = curl_init($versions[$fv]);
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($handle);
			$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
			if($httpCode == 200 & mysqli_num_rows($modsq)==0) {
				$forges[$fv] = array(
					"id" => $id,
					"mc" => $fv,
					"name" => $fvs,
					"link" => $versions[$fv]
				);
			}
			curl_close($handle);
			
		}
	}
}
print_r(json_encode($forges, JSON_PRETTY_PRINT));