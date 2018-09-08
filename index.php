<?php
session_start();
$config = include("./functions/config.php");
if($config['configured']!==true) {
	header("Location: /configure.php");
}
$config = require("./functions/config.php");
$dbcon = require("./functions/dbconnect.php");
$url = $_SERVER['REQUEST_URI'];
if(strpos($url, '?') !== false) {
	$url = substr($url, 0, strpos($url, "?"));
}
if(substr($url,-1)=="/") {
	if($_SERVER['QUERY_STRING']!==""){
		header("Location: " . rtrim($url,'/') . "?" . $_SERVER['QUERY_STRING']);
	} else {
		header("Location: " . rtrim($url,'/'));
	}
}
if(isset($_GET['logout'])){
	if($_GET['logout']==true){
		session_destroy();
		header("Location: login");
	}
}
if(isset($_POST['email']) & isset($_POST['password'])){
	if($_POST['email']==$config['mail'] & $_POST['password']==$config['pass']){
		$_SESSION['user'] = $_POST['email'];
	} else {
		header("Location: login?ic");
	}
}
function uri($uri) {
	global $url;
	$length = strlen($uri);
	if ($length == 0) {
		return true;
	}
	return (substr($url, -$length) === $uri);
}
if(isset($_SESSION['user'])) {
	if(uri("/login")||uri("/")) {
		header("Location: /dashboard");
		exit();
	}
}
if(!isset($_SESSION['user'])&!uri("/login")&!isset($_POST['email'])) {
	header("Location: /login");
	exit();
}
if(isset($_GET['logout'])){
	session_destroy();
	header("Refresh:0; url=/");
}
?>
<html>
	<head>
		<link rel="shortcut icon" href="./resources/wrenchIcon.svg" />
		<title>Technic Solder</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.2.0/js/all.js" integrity="sha384-4oV5EgaV02iISL2ban6c/RmotsABqE4yZxZLcYMAdG7FAPsyHYAPpywE9PJo+Khy" crossorigin="anonymous"></script>
		<!-- Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-77751067-6"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());

			gtag('config', 'UA-77751067-6');
		</script>

		<style type="text/css">

			.nav-tabs .nav-link {
				border: 1px solid transparent;
				border-top-left-radius: .25rem;
				border-top-right-radius: .25rem;
				background: #2F363F;
			}
			.nav-tabs .nav-link.active {
				color: white;
				background-color:#3E4956 !important;
				border-color: transparent !important;
			}
			.nav-tabs .nav-link {
				border: 1px solid transparent;
				border-top-left-radius: 0rem!important;
				border-top-right-radius: 0rem!important;
				width: 100%;
				padding:12px;
				overflow: auto;
				color:#4F5F6D;
			}
			.tab-content>.active {
				display: block;
				min-height: 165px;
				overflow: auto;
			}
			.nav-tabs .nav-item {
				width:102%
			}
			.nav-tabs .nav-link:hover {
				border:1px solid transparent;
				color: white;
			}
			.nav.nav-tabs {
				float: left;
				display: block;
				border-bottom: 0;
				border-right: 1px solid transparent;
				background-color: #2F363F;
			}
			.tab-content .tab-pane .text-muted {
				padding-left: 4em;
				margin:1em;
			}
			.modpack {
				color:white;
				overflow:hidden;
				cursor: pointer;
				white-space: nowrap;
			}
			.modpack p {
				margin:16px;
			}
			.modpack:hover {
				background-color: #2776B3;
			}
			::-webkit-scrollbar {
			    width: 10px;
			    height:10px;
			}
			::-webkit-scrollbar-thumb {
			    background: #2776B3; 
			}

			::-webkit-scrollbar-thumb:hover {
				background: #1766A3; 
			}
			.info-versions .nav-item{
				margin:5px;
			}
			a:hover {
				text-decoration: none;
			}
			.main {
				margin:2em;
				margin-left: 22em;
			}
			.card {
				 padding: 2em;
				 margin: 2em 0;
			}
			.upload-mods {
				border-radius: 5px;
				width: 100%;
				height: 15em;
				background-color: #ddd;
				transition: 0.2s;
			}
			.upload-mods input{
				width: 100%;
				height: 100%;
				position:absolute;
				top:0px;
				left:0px;
				opacity: 0.0001;
				cursor: pointer;
			}
			.upload-mods center { 
				position: absolute;
				width: 20em;
				top: 8em;
				left: calc( 50% - 10em );
			}
			.upload-mods:hover{
				background-color: #ccc;
			}*/
		</style>
	</head>
	<body style="background-color: #f0f4f9">
	<?php
		if(uri("login")){
		?>
		<div class="container">
			<div style="width:25em;margin:auto;margin-top:15em;padding:0px">
				<img style="margin:auto;display:block" alt="Technic logo" height="80" src="./resources/wrenchIcon.svg">
				<legend style="text-align:center;margin:1em 0px">Technic Solder</legend>
				<form method="POST" action="dashboard">
					<?php if(isset($_GET['ic'])){ ?>
						<div class="alert alert-danger">
							Invalid Username/Password
						</div>
					<?php } ?>
					<input style="margin:1em 0px;text-align:center" class="form-control form-control-lg" type="email" name="email" placeholder="Email Address"/>
					<input style="margin:1em 0px;text-align:center" class="form-control form-control-lg" type="password" name="password" placeholder="Password"/>
					<button style="margin:1em 0px" class="btn btn-primary btn-lg btn-block" type="submit">Log In</button>
				</form>
			</div>
		</div>
		<?php
		} else {
		?>
		<nav class="navbar navbar-light sticky-top bg-white">
  			<span class="navbar-brand"  href="#"><img alt="Technic logo" class="d-inline-block align-top" height="46px" src="./resources/wrenchIcon.svg"> Technic Solder <span class="navbar-text">by TheGameSpider <?php echo(json_decode(file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/api'),true)['version'])." ".json_decode(file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/api'),true)['stream']; ?></span></span>
  			<span class="navbar-text"><?php echo $_SESSION['user'] ?> <a href="?logout=true"><button class="btn btn-outline-primary btn-sm">Log Out</button></a></span>
		</nav>
		<div class="text-white" style="width:20em;height: 100%;position:fixed;background-color: #3E4956">
			<ul class="nav nav-tabs" style="height:100%">
				<li class="nav-item">
					<a class="nav-link " href="/dashboard"><i class="fas fa-tachometer-alt fa-lg"></i></a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="#modpacks" data-toggle="tab" role="tab"><i class="fas fa-boxes fa-lg"></i></a>
				</li>
				<li class="nav-item">
					<a id="nav-mods" class="nav-link" href="#mods" data-toggle="tab" role="tab"><i class="fas fa-book fa-lg"></i></a>
				</li>
				<li class="nav-item">
					<a id="nav-settings" class="nav-link" href="#settings" data-toggle="tab" role="tab"><i class="fas fa-sliders-h fa-lg"></i></a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="modpacks" role="tabpanel">
					<div style="overflow:auto;height: calc( 100% - 62px )">
						<p class="text-muted">MODPACKS</p>
						<?php
						$result = mysqli_query($conn, "SELECT * FROM `modpacks`");
						if(mysqli_num_rows($result)!==0) {
							while($modpack=mysqli_fetch_array($result)){
								?>
								<a href="/modpack?id=<?php echo $modpack['id'] ?>">
									<div class="modpack">
										<p class="text-white"><img alt="<?php echo $modpack['display_name'] ?>" class="d-inline-block align-top" height="25px" src="<?php echo $modpack['icon'] ?>"> <?php echo $modpack['display_name'] ?></p>
									</div>
								</a>
							<?php
							}
						}
						?>
						<a href="functions/new-modpack.php"><div class="modpack">
							<p><i style="height:25px" class="d-inline-block align-top fas fa-plus-circle"></i> Add Modpack</p>
						</div></a>
					</div>
				</div>
				<div class="tab-pane" id="mods" role="tabpanel">
					<p class="text-muted">LIBRARIES</p>
					<a href="/lib-mods"><div class="modpack">
						<p><i class="fas fa-cubes fa-lg"></i> <span style="margin-left:inherit;">Mod library</span></p>
					</div></a>
					<a href="/lib-forges"><div class="modpack">
						<p><i class="fas fa-database fa-lg"></i> <span style="margin-left:inherit;">Forge versions</span> </p>
					</div></a>
					<a href="/lib-other"><div class="modpack">
						<p><i class="far fa-file-archive fa-lg"></i> <span style="margin-left:inherit;">Other files</span></p>
					</div></a>
				</div>
				<div class="tab-pane" id="settings" role="tabpanel">
					<p class="text-muted">SETTINGS</p>
					<a href="/configure.php?reconfig"><div class="modpack">
						<p><i class="fas fa-cogs fa-lg"></i> <span style="margin-left:inherit;">Solder Configuration</span></p>
					</div></a>
					<a href="/about"><div class="modpack">
						<p><i class="fas fa-info-circle fa-lg"></i> <span style="margin-left:inherit;">About TechnicSolder</span></p>
					</div></a>
				</div>
			</div>	
		</div>
		<?php
		if(uri("/dashboard")){
			?>
			<div class="main">
				<div class="card">
					<center>
						<p style="font-size: 4rem" class="display-3">Welcome to TechnicSolder</p>
						<p style="font-size: 2rem" class="display-4">The best Application to create and manage your modpacks.</p>
					</center>
					<hr />
					<h2>How to create a modpack?</h2>
					<p>With TechnicSolder, you can create a modpack in three simple steps:</p>
					<div style="margin-left: 25px">
						<h5>1. Upload your mods.</h5>
						<p>On the side panel, click the book icon <i class="fas fa-book"></i> and click Mods Library. Then, just Drag n' Drop your mods to the upload box.</p>
						<h5>2. Select Forge version.</h5>
						<p>Under the Mods Library, click Forge Versions. Click the blue button Fetch Forge Versions and wait until Versions are loaded. Then spimply add to database versions you want.</p>
						<h5>3. Save your modpack.</h5>
						<p>On the side panel, click the packs icon <i class="fas fa-boxes"></i> and click Add Modpack.</p>
						<p>Rename your modpack and click Save.</p>
						<p>Create a new empty build and in builds table click Edit.</p>
						<p>Select minecraft versions and click green button Save and Refresh.</p>
						<p>Now, you can add mods to your modpack.</p>
						<p>The final step is to go back to your modpack and in builds table click green button Set reccommended.</p>
					</div>
				</div>
			</div>
			<?php
		}
		if(uri("/modpack")){
			$mpres = mysqli_query($conn, "SELECT * FROM `modpacks` WHERE `id` = ".$_GET['id']);
			if($mpres) {
			$modpack = mysqli_fetch_array($mpres);
			?>
			<ul class="nav justify-content-end info-versions">
				<li class="nav-item">
					<a class="nav-link" href="/dashboard"><i class="fas fa-arrow-left fa-lg"></i> <?php echo $modpack['display_name'] ?></a>
				</li>
				<?php
				
				$packapi = 'http://'.$_SERVER['HTTP_HOST'].'/api/modpack/'.$modpack['name'];
				$packdata = json_decode(file_get_contents($packapi),true);
				$latest=false;
				$latestres = mysqli_query($conn, "SELECT * FROM `builds` WHERE `modpack` = ".$_GET['id']." AND `name` = '".$packdata['latest']."'");
				if(mysqli_num_rows($latestres)!==0) {
					$latest=true;
					$build = mysqli_fetch_array($latestres);
				}
				?>
				<li <?php if($latest==false){ echo "style='display:none'"; } ?> id="latest-v-li" class="nav-item">
					<span class="navbar-text"><i style="color:#2E74B2" class="fas fa-exclamation"></i> Latest: <b id="latest-name"><?php echo $build['name'] ?></b></span>
				</li>
				<li <?php if($latest==false){ echo "style='display:none'"; } ?> id="latest-mc-li" class="nav-item">
					<span class="navbar-text">MC: <b id="latest-mc"><?php echo $build['minecraft'] ?></b></span>
				</li>
				<div style="width:30px"></div>
					<?php
				$rec=false;
				$recres = mysqli_query($conn, "SELECT * FROM `builds` WHERE `modpack` = ".$_GET['id']." AND `name` = '".$packdata['recommended']."'");
				if(mysqli_num_rows($recres)!==0) {
					$rec=true;
					$build = mysqli_fetch_array($recres);
				}
				?>
				<li <?php if($rec==false){ echo "style='display:none'"; } ?> id="rec-v-li" class="nav-item">
					<span class="navbar-text"><i style="color:#329C4E" class="fas fa-check"></i> Recommended: <b id="rec-name"><?php echo $build['name'] ?></b></span>
				</li>
				<li <?php if($rec==false){ echo "style='display:none'"; } ?> id="rec-mc-li" class="nav-item">
					<span class="navbar-text">MC: <b id="rec-mc"><?php echo $build['minecraft'] ?></b></span>
				</li>
				<div style="width:30px"></div>
			</ul>
			<div class="main">
				<div class="card">
					<h2>Edit Modpack</h2>
					<form action="/functions/edit-modpack.php" method="">
						<input hidden type="text" name="id" value="<?php echo $_GET['id'] ?>">
						<input autocomplete="off" id="dn" class="form-control" type="text" name="display_name" placeholder="Modpack name" value="<?php echo $modpack['display_name'] ?>" />
						<br />
						<input autocomplete="off" id="slug" pattern="^[a-z0-9]+(?:-[a-z0-9]+)*$" class="form-control" type="text" name="name" placeholder="Modpack slug" value="<?php echo $modpack['name'] ?>" />
						<br />
						<div class="btn-group" role="group" aria-label="Actions">
							<button type="submit" name="type" value="rename" class="btn btn-primary">Save</button>
							<button data-toggle="modal" data-target="#removeModpack" type="button" class="btn btn-danger">Remove Modpack</button>
						</div>
						
					</form>
					<div class="modal fade" id="removeModpack" tabindex="-1" role="dialog" aria-labelledby="rmp" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="rmp">Delete modpack <?php echo $modpack['display_name'] ?>?</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        Are you sure you want to delete modpack <?php echo $modpack['display_name'] ?> and all it's builds?
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
					        <button onclick="window.location='/functions/rmp.php?id=<?php echo $modpack['id'] ?>'" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
					      </div>
					    </div>
					  </div>
					</div>
					<script type="text/javascript">
						$("#dn").on("keyup", function(){
							var slug = slugify($(this).val());
							console.log(slug);
							$("#slug").val(slug);
						});
						function slugify (str) {
							str = str.replace(/^\s+|\s+$/g, '');
							str = str.toLowerCase();
							var from = "àáãäâèéëêìíïîòóöôùúüûñšç·/_,:;";
							var to = "aaaaaeeeeiiiioooouuuunsc------";
							for (var i=0, l=from.length ; i<l ; i++) {
								str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
							}
							str = str.replace(/[^a-z0-9 -]/g, '')
								.replace(/\s+/g, '-')
								.replace(/-+/g, '-');
							return str;
						}
					</script>					
				</div>
				<div class="card">
					<h2>New Build</h2>
					<form action="/functions/new-build.php" method="">
						<input hidden type="text" name="id" value="<?php echo $_GET['id'] ?>">
						<input required autocomplete="off" class="form-control" type="text" name="name" placeholder="Build name (e.g. 1.0)" />
						<br />
						<button type="submit" name="type" value="new" class="btn btn-primary">Create Empty Build</button>
						<button type="submit" name="type" value="update" class="btn btn-primary">Update latest version</button>
					</form>
				</div>
				<div class="card">
					<h2>Builds</h2>
					<table class="table table-striped">
						<thead>
							<tr>
								<td style="width:25%" scope="col">Build</td>
								<td style="width:20%" scope="col">Minecraft version</td>
								<td style="width:20%" scope="col">Java version</td>
								<td style="width:30%" scope="col"></td>
								<td style="width:5%" scope="col"></td>
							</tr>
						</thead>
						<tbody id="table-builds">
							<?php
							$builds = mysqli_query($conn, "SELECT * FROM `builds` WHERE `modpack` = ".$_GET['id']." ORDER BY `id` DESC");
							while($build = mysqli_fetch_array($builds)) {
							?>
							<tr rec="<?php if($packdata['recommended']==$build['name']){ echo "true"; } else { echo "false"; } ?>" id="b-<?php echo $build['id'] ?>">
								<td scope="row"><?php echo $build['name'] ?></td>
								<td><?php echo $build['minecraft'] ?></td>
								<td><?php echo $build['java'] ?></td>
								<td>
									<div class="btn-group btn-group-sm" role="group" aria-label="Actions">
										<button onclick="edit(<?php echo $build['id'] ?>)" class="btn btn-primary">Edit</button>
										<button onclick="remove_box(<?php echo $build['id'] ?>,'<?php echo $build['name'] ?>')" data-toggle="modal" data-target="#removeModal" class="btn btn-danger">Remove</button>
										<button bid="<?php echo $build['id'] ?>" id="rec-<?php if($packdata['recommended']==$build['name']){ ?>disabled<?php } else echo $build['id'] ?>" <?php if($packdata['recommended']==$build['name']){ ?>disabled<?php } ?> onclick="set_recommended(<?php echo $build['id'] ?>)" class="btn btn-success">Set recommended </button>
									</div>
								</td>
								<td>
									<i id="cog-<?php echo $build['id'] ?>" style="display:none;margin-top: 0.5rem" class="fas fa-cog fa-lg fa-spin"></i>
								</td>
							<?php } ?>
							</tr>
						</tbody>
					</table>
					<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="removeModalLabel">Delete build <span id="build-title"></span>?</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        Are you sure you want to delete build <span id="build-text"></span>?
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
					        <button id="remove-button" onclick="" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
					      </div>
					    </div>
					  </div>
					</div>
					<script type="text/javascript">
						function edit(id) {
							window.location = "/build?id="+id;
						}
						function remove_box(id,name) {
							$("#build-title").text(name);
							$("#build-text").text(name);
							$("#remove-button").attr("onclick","remove("+id+")");
						}
						function remove(id) {
							$("#cog-"+id).show();
							var request = new XMLHttpRequest();
							request.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									response = JSON.parse(this.response);
									$("#cog-"+id).hide();
									$("#b-"+id).hide();
									if($("#b-"+id).attr("rec")=="true") {
										$("#rec-v-li").hide();
										$("#rec-mc-li").hide();
									}
									console.log(response);
									if(response['exists']==true) {
										$("#latest-v-li").show();
										$("#latest-mc-li").show();										
										$("#latest-name").text(response['name']);
										$("#latest-mc").text(response['mc']);
										if(response['name']==null) {
											$("#latest-v-li").hide();
											$("#latest-mc-li").hide();
										}
									} else {
										$("#latest-v-li").hide();
										$("#latest-mc-li").hide();
									}

								}
							};
							request.open("GET", "functions/delete-build.php?id="+id+"&pack=<?php echo $_GET['id'] ?>");
							request.send();
						}
						function set_recommended(id) {
							$("#cog-"+id).show();
							var request = new XMLHttpRequest();
							request.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
									response = JSON.parse(this.response);
									$("#rec-v-li").show();
									$("#rec-mc-li").show();
									$("#cog-"+id).hide();
									$("#rec-"+id).attr('disabled', true);
									var bid = $("#rec-disabled").attr('bid');
									$("#rec-disabled").attr('disabled', false);
									$("#rec-disabled").attr('id', 'rec-'+bid);
									$("#rec-"+id).attr('id', 'rec-disabled');
									$("#rec-name").text(response['name']);
									$("#rec-mc").text(response['mc']);
									$("#table-builds tr").attr('rec','false');
									$("#b-"+id).attr('rec','true');
								}
							};
							request.open("GET", "functions/set-recommended.php?id="+id);
							request.send();
						}
					</script>
				</div>
			</div>
			<?php
			}
		}
		if(uri('/build')) {
			if(isset($_POST['versions']) & isset($_POST['java']) & isset($_POST['memory'])) {
				mysqli_query($conn, "UPDATE `builds` SET `mods` = '".$_POST['versions']."' WHERE `id` = ".$_GET['id']);
				$minecraft = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `mods` WHERE `id` = ".$_POST['versions']));
				mysqli_query($conn, "UPDATE `builds` SET `minecraft` = '".$minecraft['mcversion']."', `java` = '".$_POST['java']."', `memory` = '".$_POST['memory']."' WHERE `id` = ".$_GET['id']);
			}
			$bres = mysqli_query($conn, "SELECT * FROM `builds` WHERE `id` = ".$_GET['id']);
			if($bres) {
				$build = mysqli_fetch_array($bres);
			}
			$modslist= explode(',', $build['mods']);
			?>
			<div class="main">
				<div class="card">
					<h2>Build <?php echo $build['name'] ?></h2>
					<form method="POST">
						<label for="versions">Select minecraft version</label>
						<select id="versions" name="versions" class="form-control">
							<?php
							$vres = mysqli_query($conn, "SELECT * FROM `mods` WHERE `type` = 'forge'");
							if(mysqli_num_rows($vres)!==0) {
								while($version = mysqli_fetch_array($vres)) {
									?><option <?php if($version['mcversion']==$build['minecraft']){ echo "selected"; } ?> value="<?php echo $version['id']?> "><?php echo $version['mcversion'] ?> - Forge <?php echo $version['version'] ?></option><?php
								}
								echo "</select>";
							} else {
								echo "</select>";
								echo "<div style='display:block' class='invalid-feedback'>There are no versions available. Please fetch versions in <a href='/lib-forges'>Forge Versions Library</a></div>";
							}
							?>
						<br />
						<label for="java">Select java version</label>
						<select name="java" class="form-control">
							<option <?php if($build['java']=="1.8"){ echo "selected"; } ?> value="1.8">1.8</option>
							<option <?php if($build['java']=="1.7"){ echo "selected"; } ?> value="1.7">1.7</option>
							<option <?php if($build['java']=="1.6"){ echo "selected"; } ?> value="1.6">1.6</option>
						</select> <br />
						<label for="memory">Memory (RAM in MB)</label>
						<input class="form-control" type="number" id="memory" name="memory" value="<?php echo $build['memory'] ?>" min="1024" max="65536" placeholder="2048" step="512">
						<br />
						<button type="submit" class="btn btn-success">Save and Refresh</button>
					</form>
				</div>
				<?php if(isset($build['minecraft'])) { ?>
					<div class="card">
						<h2>Mods in Build <?php echo $build['name'] ?></h2>
						<script type="text/javascript">
							function remove_mod(id) {
								$("#mod-"+id).remove();
								var request = new XMLHttpRequest();
								request.open("GET", "functions/remove-mod.php?bid=<?php echo $build['id'] ?>&id="+id);
								request.send();
							}
						</script>
						<table class="table table-striped">
							<thead>
								<tr>
									<td scope="col" style="width: 60%">Mod Name</td>
									<td scope="col" style="width: 15%">Version</td>
									<td scope="col" style="width: 15%"></td>
								</tr>
							</thead>
							<tbody>
								<?php foreach($modslist as $bmod) {
									$modq = mysqli_query($conn,"SELECT * FROM `mods` WHERE `id` = ".$bmod);
									$moda = mysqli_fetch_array($modq);
									?>
								<tr id="mod-<?php echo $bmod ?>">
									<td scope="row"><?php echo $moda['pretty_name'] ?></td>
									<td><?php echo $moda['version'] ?></td>
									<td><?php if($moda['name'] !== "forge"){ ?><button onclick="remove_mod(<?php echo $bmod ?>)" class="btn btn-danger"><i class="fas fa-times"></i></button><?php } ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="card">
						<h2>Mods for Minecraft <?php echo $build['minecraft'] ?></h2>
						<button onclick="window.location.href = window.location.href" class="btn btn-primary">Refresh</button>
						<br />
						<table class="table table-striped">
							<thead>
								<tr>
									<td scope="col" style="width: 55%">Mod Name</td>
									<td scope="col" style="width: 20%">Version</td>
									<td scope="col" style="width: 20%"></td>
									<td scope="col" style="width: 5%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
							$mres = mysqli_query($conn, "SELECT * FROM `mods` WHERE `type` = 'mod' AND `mcversion` = '".$build['minecraft']."'");
							if(mysqli_num_rows($mres)!==0) {
								?>
								<script type="text/javascript">
									function add(id) {
										$("#btn-add-mod-"+id).attr("disabled", true);
										$("#cog-"+id).show();
										var request = new XMLHttpRequest();
										request.onreadystatechange = function() {
											if (this.readyState == 4 && this.status == 200) {
												$("#cog-"+id).hide();
												$("#check-"+id).show();
											}
										};
										request.open("GET", "functions/add-mod.php?bid=<?php echo $build['id'] ?>&id="+id);
										request.send();
									}
								</script>
								<?php
								while($mod = mysqli_fetch_array($mres)) {
									if(!in_array($mod['id'], $modslist)) {
										?>
										<tr>
											<td scope="row"><?php echo $mod['pretty_name'] ?></td>
											<td><?php echo $mod['version'] ?></td>
											<td><button id="btn-add-mod-<?php echo $mod['id'] ?>" onclick="add(<?php echo $mod['id'] ?>)" class="btn btn-primary">Add to Build</button></td>
											<td><i id="cog-<?php echo $mod['id'] ?>" style="display:none" class="fas fa-cog fa-spin fa-2x"></i><i id="check-<?php echo $mod['id'] ?>" style="display:none" class="text-success fas fa-check fa-2x"></i></td>
										</tr>
										<?php
									}
								}
							} else {
								echo "<div style='display:block' class='invalid-feedback'>There are no mods available for version ".$build['minecraft'].". Please upload mods in <a href='/lib-mods'>Mods Library</a></div>";
							} ?>
							</tbody>
						</table>				
					</div>	
					<div class="card">
						<h2>Other Files</h2>
						<table class="table table-striped">
							<thead>
								<tr>
									<td scope="col" style="width: 55%">Mod Name</td>
									<td scope="col" style="width: 20%">Version</td>
									<td scope="col" style="width: 20%"></td>
									<td scope="col" style="width: 5%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
							$mres = mysqli_query($conn, "SELECT * FROM `mods` WHERE `type` = 'other'");
							if(mysqli_num_rows($mres)!==0) {
								?>
								<script type="text/javascript">
									function add_o(id) {
										$("#btn-add-o-"+id).attr("disabled", true);
										$("#cog-o-"+id).show();
										var request = new XMLHttpRequest();
										request.onreadystatechange = function() {
											if (this.readyState == 4 && this.status == 200) {
												$("#cog-o-"+id).hide();
												$("#check-o-"+id).show();
											}
										};
										request.open("GET", "functions/add-mod.php?bid=<?php echo $build['id'] ?>&id="+id);
										request.send();
									}
								</script>
								<?php
								while($mod = mysqli_fetch_array($mres)) {
									if(!in_array($mod['id'], $modslist)) {
										?>
										<tr>
											<td scope="row"><?php echo $mod['pretty_name'] ?></td>
											<td><?php echo $mod['version'] ?></td>
											<td><button id="btn-add-o-<?php echo $mod['id'] ?>" onclick="add_o(<?php echo $mod['id'] ?>)" class="btn btn-primary">Add to Build</button></td>
											<td><i id="cog-o-<?php echo $mod['id'] ?>" style="display:none" class="fas fa-cog fa-spin fa-2x"></i><i id="check-o-<?php echo $mod['id'] ?>" style="display:none" class="text-success fas fa-check fa-2x"></i></td>
										</tr>
										<?php
									}
								}
							} else {
								echo "<div style='display:block' class='invalid-feedback'>There are no files available. Please upload files in <a href='/lib-other'>Files Library</a></div>";
							} ?>
							</tbody>
						</table>
					</div>
				<?php } else echo "<div class='card'><h3 class='text-info'>Select minecraft version and save before editing mods.</h3></div>"; ?>
			</div>

		<?php
		}
		if(uri('/lib-mods')) {
		?>
		<div class="main">
		<script type="text/javascript">
				function remove_box(id,name) {
					$("#mod-name-title").text(name);
					$("#mod-name").text(name);
					$("#remove-button").attr("onclick","remove("+id+")");
				}
				function remove(id) {
					var request = new XMLHttpRequest();
					request.onreadystatechange = function() {
						$("#mod-row-"+id).remove();
					}
					request.open("GET", "functions/delete-mod.php?id="+id);
					request.send();
				}
			</script>
			<div id="upload-card" class="card">
				<h2>Upload mods</h2>
				<div class="card-img-bottom">
					<form id="modsform" enctype="multipart/form-data">
						<div class="upload-mods">
							<center>
								<div>
									Drag n' Drop .jar files here.
									<br />
									<i class="fas fa-upload fa-4x"></i>
								</div>									
							</center>
							<input type="file" name="fiels" multiple/>
						</div>
					</form>
				</div>
			</div>
			<div style="display: none" id="u-mods" class="card">
				<h2>New Mods</h2>
				<table class="table">
					<thead>
						<tr>
							<td style="width:25%" scope="col">Mod</td>
							<td scope="col">Status</td>
						</tr>
					</thead>
					<tbody id="table-mods">
						
					</tbody>
				</table>
				<button id="btn-done" disabled class="btn btn-success btn-block" onclick="window.location.reload();">Save Mods and Refresh</button>
			</div>
			<div class="card">
				<h2>Available Mods</h2>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<td style="width:40%" scope="col">Mod name</td>
							<td style="width:25%" scope="col">Author</td>
							<td style="width:10%" scope="col">Version</td>
							<td style="width:10%" scope="col">Minecraft version</td>
							<td style="width:15%" scope="col"></td>
						</tr>
					</thead>
					<tbody id="table-mods">
						<?php
						$mods = mysqli_query($conn, "SELECT * FROM `mods` WHERE `type` = 'mod' ORDER BY `id` DESC");
						if($mods){
							while($mod = mysqli_fetch_array($mods)){
							?>
								<tr id="mod-row-<?php echo $mod['id'] ?>">
									<td scope="row"><?php echo $mod['pretty_name'] ?></td>
									<td><?php echo $mod['author'] ?></td>
									<td><?php echo $mod['version'] ?></td>
									<td><?php echo $mod['mcversion'] ?></td>
									<td>
										<div class="btn-group btn-group-sm" role="group" aria-label="Actions">
											<button onclick="window.location='/mod?id=<?php echo $mod['id'] ?>'" class="btn btn-primary">Edit</button>
											<button onclick="remove_box(<?php echo $mod['id'].",'".$mod['name']."'" ?>)" data-toggle="modal" data-target="#removeMod" class="btn btn-danger">Remove</button>
										</div>
									</td>
								</tr>
							<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="modal fade" id="removeMod" tabindex="-1" role="dialog" aria-labelledby="rm" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="rm">Delete mod <span id="mod-name-title"></span>?</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete mod <span id="mod-name"></span>? Mod's file will be deleted too.
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			        <button id="remove-button" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

		<script type="text/javascript">
			mn = 1;
			function sendFile(file, i) {
				var formData = new FormData();
				var request = new XMLHttpRequest();
				formData.set('fiels', file);
				request.open('POST', '/functions/send_mods.php');
				request.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentage = evt.loaded / evt.total * 100;
						$("#" + i).attr('aria-valuenow', percentage + '%');
						$("#" + i).css('width', percentage + '%');
						request.onreadystatechange = function() {
							if (request.readyState == 4) {
								if (request.status == 200) {
									if ( mn == modcount ) {
										$("#btn-done").attr("disabled",false);
									} else {
										mn = mn + 1;
									}
									console.log(request.response);
									response = JSON.parse(request.response);
									switch(response.status) {
										case "succ":
										{
											$("#cog-" + i).hide();
											$("#check-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-success");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");
											break;
										}
										case "error":
										{
											$("#cog-" + i).hide();
											$("#times-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-danger");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");
											break;
										}
										case "warn":
										{
											$("#cog-" + i).hide();
											$("#exc-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-warning");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");	
											break;
										}
										case "info":
										{
											$("#cog-" + i).hide();
											$("#inf-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-info");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");	
											break;
										}
									}
								} else {
									$("#cog-" + i).hide();
									$("#times-" + i).show();
									$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
									$("#" + i).addClass("bg-danger");
									$("#info-" + i).text("An error occured: " + request.status);
									$("#" + i).attr("id", i + "-done");
								}
							}
						}
					}
				}, false);
				request.send(formData);
			}

			function showFile(file, i) {
				$("#table-mods").append('<tr><td scope="row">' + file.name + '</td> <td><i id="cog-' + i + '" class="fas fa-cog fa-spin"></i><i id="check-' + i + '" style="color:green;display:none" class="fas fa-check"></i><i id="times-' + i + '" style="color:red;display:none" class="fas fa-times"></i><i id="exc-' + i + '" style="color:orange;display:none" class="fas fa-exclamation"></i><i id="inf-' + i + '" style="color:darkcyan;display:none" class="fas fa-info"></i> <small class="text-muted" id="info-' + i + '"></small></h4><div class="progress"><div id="' + i + '" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div></td></tr>');
			}
			$(document).ready(function() {
				$(':file').change(function() {
					$("#upload-card").hide();
					$("#u-mods").show();
					modcount = this.files.length;
					for (var i = 0; i < this.files.length; i++) {
						var file = this.files[i];
						showFile(file, i);
					}
					for (var i = 0; i < this.files.length; i++) {
						var file = this.files[i];
						sendFile(file, i);
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#nav-mods").trigger('click');
			});
		</script>
		<?php
		}
		if(uri('/lib-forges')) {
		?>
		<div class="main">
			<script type="text/javascript">
				function remove_box(id,name) {
					$("#mod-name-title").text(name);
					$("#mod-name").text(name);
					$("#remove-button").attr("onclick","remove("+id+")");
				}
				function remove(id) {
					var request = new XMLHttpRequest();
					request.onreadystatechange = function() {
						$("#mod-row-"+id).remove();
					}
					request.open("GET", "functions/delete-mod.php?id="+id);
					request.send();
				}
			</script>
			<div class="card">
			<div class="modal fade" id="removeMod" tabindex="-1" role="dialog" aria-labelledby="rm" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="rm">Delete mod <span id="mod-name-title"></span>?</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete mod <span id="mod-name"></span>? Mod's file will be deleted too.
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			        <button id="remove-button" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
			      </div>
			    </div>
			  </div>
			</div>				
		<h2>Forge Versions in Database</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<td scope="col" style="width:35%">Minecraft</td>
							<td scope="col" style="width:40%">Forge Version</td>
							<td scope="col" style="width:20%"></td>
							<td scope="col" style="width:5%"></td>
						</tr>
					</thead>
					<tbody id="forge-available">
						<?php
						$mods = mysqli_query($conn, "SELECT * FROM `mods` WHERE `type` = 'forge' ORDER BY `id` DESC");
						if($mods){
							while($mod = mysqli_fetch_array($mods)){
							?>
							<tr id="mod-row-<?php echo $mod['id'] ?>">
								<td scope="row"><?php echo $mod['mcversion'] ?></td>
								<td><?php echo $mod['version'] ?></td>
								<td><button  onclick="remove_box(<?php echo $mod['id'].",'".$mod['pretty_name']." ".$mod['version']."'" ?>)" data-toggle="modal" data-target="#removeMod" class="btn btn-danger btn-sm">Remove</button></td>
								<td><i style="display: none" class="fas fa-cog fa-spin fa-sm"></i></td>
							</tr>
							<?php
							}
						}
						?>
					</tbody>
				</table>				
			</div>
			<button id="fetch" onclick="fetch()" class="btn btn-primary btn-block">Fetch Forge Versions from minecraftforge.net</button>
			<button style="display: none" id="save" onclick="window.location.reload()" class="btn btn-success btn-block">Save Forge Vesions and Refresh</button>
			<div class="card" id="fetched-mods" style="display: none">
				<script type="text/javascript">
					function fetch() {
						$("#fetch").attr("disabled",true);
						$("#fetch").html("Please wait... This can take a while. <i class='fas fa-cog fa-spin fa-sm'></i>");
						var request = new XMLHttpRequest();
						request.open('GET', '/functions/forge-links.php');
						request.onreadystatechange = function() {
							if (request.readyState == 4) {
								if (request.status == 200) {
									$("#fetched-mods").show();
									response = JSON.parse(this.response);
									console.log(response);
									$("#fetch").hide();
									$("#save").show();
									for (var key in response) {
										$("#forge-table").append('<tr id="forge-'+response[key]["id"]+'"><td scope="row">'+response[key]["mc"]+'</td><td>'+response[key]["name"]+'</td><td><a href="'+response[key]["link"]+'">'+response[key]["link"]+'</a></td><td><button id="button-add-'+response[key]["id"]+'" onclick="add(\''+response[key]["name"]+'\',\''+response[key]["link"]+'\',\''+response[key]["mc"]+'\',\''+response[key]["id"]+'\')" class="btn btn-primary btn-sm">Add to Database</button></td><td><i id="cog-'+response[key]["id"]+'" style="display:none" class="fas fa-spin fa-cog fa-2x"></i><i id="check-'+response[key]["id"]+'" style="display:none;color:green" class="fas fa-check fa-2x"></i></td></tr>');
									}
								}
							}
						}
						request.send();
					}
					function add(v,link,mcv,id) {
						$("#button-add-"+id).attr("disabled",true);
						$("#cog-"+id).show();
						var request = new XMLHttpRequest();
						request.open('GET', '/functions/add-forge.php?version='+v+'&link='+link+'&mcversion='+mcv);
						request.onreadystatechange = function() {
							if (request.readyState == 4) {
								if (request.status == 200) {
									$("#cog-"+id).hide();
									$("#check-"+id).show();
								}
							}
						}
						request.send();
					}
				</script>
				<h2>Available Forge Versions</h2>
				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<td scope="col" style="width:10%">Minecraft</td>
							<td scope="col" style="width:15%">Forge Version</td>
							<td scope="col" style="width:55%">Link</td>
							<td scope="col" style="width:15%"></td>
							<td scope="col" style="width:5%"></td>
						</tr>
					</thead>
					<tbody id="forge-table">

					</tbody>
				</table>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#nav-mods").trigger('click');
			});
		</script>
		<?php
		}
		if(uri('/lib-other')) {
		?>
		<div class="main">
		<script type="text/javascript">
				function remove_box(id,name) {
					$("#mod-name-title").text(name);
					$("#mod-name").text(name);
					$("#remove-button").attr("onclick","remove("+id+")");
				}
				function remove(id) {
					var request = new XMLHttpRequest();
					request.onreadystatechange = function() {
						$("#mod-row-"+id).remove();
					}
					request.open("GET", "functions/delete-mod.php?id="+id);
					request.send();
				}
			</script>
			<div id="upload-card" class="card">
				<h2>Upload files</h2>
				<div class="card-img-bottom">
					<form id="modsform" enctype="multipart/form-data">
						<div class="upload-mods">
							<center>
								<div>
									Drag n' Drop .zip files here.
									<br />
									<i class="fas fa-upload fa-4x"></i>
								</div>									
							</center>
							<input type="file" name="fiels" multiple accept=".zip" />
						</div>
					</form>
				</div>
				<p>Theese file will be extracted to modpack's root directory. (e.g. Config files, worlds, resource packs....)</p>
			</div>
			<div style="display: none" id="u-mods" class="card">
				<h2>New Mods</h2>
				<table class="table">
					<thead>
						<tr>
							<td style="width:25%" scope="col">Mod</td>
							<td scope="col">Status</td>
						</tr>
					</thead>
					<tbody id="table-mods">
						
					</tbody>
				</table>
				<button id="btn-done" disabled class="btn btn-success btn-block" onclick="window.location.reload();">Save Mods and Refresh</button>
			</div>
			<div class="card">
				<h2>Available Files</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<td style="width:65%" scope="col">File Name</td>
							<td style="width:35%" scope="col"></td>
						</tr>
					</thead>
					<tbody id="table-mods">
						<?php
						$mods = mysqli_query($conn, "SELECT * FROM `mods` WHERE `type` = 'other' ORDER BY `id` DESC");
						if($mods){
							while($mod = mysqli_fetch_array($mods)){
							?>
								<tr id="mod-row-<?php echo $mod['id'] ?>">
									<td scope="row"><?php echo $mod['pretty_name'] ?></td>
									<td>
										<div class="btn-group btn-group-sm" role="group" aria-label="Actions">
											<button onclick="remove_box(<?php echo $mod['id'].",'".$mod['name']."'" ?>)" data-toggle="modal" data-target="#removeMod" class="btn btn-danger">Remove</button>
										</div>
									</td>
								</tr>
							<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
			<div class="modal fade" id="removeMod" tabindex="-1" role="dialog" aria-labelledby="rm" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="rm">Delete mod <span id="mod-name-title"></span>?</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        Are you sure you want to delete file <span id="mod-name"></span>?
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
			        <button id="remove-button" type="button" class="btn btn-danger" data-dismiss="modal">Delete</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

		<script type="text/javascript">
			mn = 1;
			function sendFile(file, i) {
				var formData = new FormData();
				var request = new XMLHttpRequest();
				formData.set('fiels', file);
				request.open('POST', '/functions/send_other.php');
				request.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentage = evt.loaded / evt.total * 100;
						$("#" + i).attr('aria-valuenow', percentage + '%');
						$("#" + i).css('width', percentage + '%');
						request.onreadystatechange = function() {
							if (request.readyState == 4) {
								if (request.status == 200) {
									if ( mn == modcount ) {
										$("#btn-done").attr("disabled",false);
									} else {
										mn = mn + 1;
									}
									console.log(request.response);
									response = JSON.parse(request.response);
									switch(response.status) {
										case "succ":
										{
											$("#cog-" + i).hide();
											$("#check-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-success");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");
											break;
										}
										case "error":
										{
											$("#cog-" + i).hide();
											$("#times-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-danger");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");
											break;
										}
										case "warn":
										{
											$("#cog-" + i).hide();
											$("#exc-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-warning");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");	
											break;
										}
										case "info":
										{
											$("#cog-" + i).hide();
											$("#inf-" + i).show();
											$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
											$("#" + i).addClass("bg-info");
											$("#info-" + i).text(response.message);
											$("#" + i).attr("id", i + "-done");	
											break;
										}
									}
								} else {
									$("#cog-" + i).hide();
									$("#times-" + i).show();
									$("#" + i).removeClass("progress-bar-striped progress-bar-animated");
									$("#" + i).addClass("bg-danger");
									$("#info-" + i).text("An error occured: " + request.status);
									$("#" + i).attr("id", i + "-done");
								}
							}
						}
					}
				}, false);
				request.send(formData);
			}

			function showFile(file, i) {
				$("#table-mods").append('<tr><td scope="row">' + file.name + '</td> <td><i id="cog-' + i + '" class="fas fa-cog fa-spin"></i><i id="check-' + i + '" style="color:green;display:none" class="fas fa-check"></i><i id="times-' + i + '" style="color:red;display:none" class="fas fa-times"></i><i id="exc-' + i + '" style="color:orange;display:none" class="fas fa-exclamation"></i><i id="inf-' + i + '" style="color:darkcyan;display:none" class="fas fa-info"></i> <small class="text-muted" id="info-' + i + '"></small></h4><div class="progress"><div id="' + i + '" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div></td></tr>');
			}
			$(document).ready(function() {
				$(':file').change(function() {
					$("#upload-card").hide();
					$("#u-mods").show();
					modcount = this.files.length;
					for (var i = 0; i < this.files.length; i++) {
						var file = this.files[i];
						showFile(file, i);
					}
					for (var i = 0; i < this.files.length; i++) {
						var file = this.files[i];
						sendFile(file, i);
					}
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#nav-mods").trigger('click');
			});
		</script>
		<?php
		}
		if(uri("/mod")) {
		?>
		<div class="main">
			<?php
			$mres = mysqli_query($conn, "SELECT * FROM `mods` WHERE `id` = ".$_GET['id']);
			if($mres) {
				$mod = mysqli_fetch_array($mres);
			}
			?>
			<div class="card">
				<button onclick="window.location = '/lib-mods'" style="width: fit-content;" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</button><br />
				<form method="POST" action="./functions/edit-mod.php?id=<?php echo $_GET['id'] ?>">

					<script type="text/javascript">
						$("#pn").on("keyup", function(){
							var slug = slugify($(this).val());
							console.log(slug);
							$("#slug").val(slug);
						});
						function slugify (str) {
							str = str.replace(/^\s+|\s+$/g, '');
							str = str.toLowerCase();
							var from = "àáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
							var to = "aaaaaeeeeiiiioooouuuunc------";
							for (var i=0, l=from.length ; i<l ; i++) {
								str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
							}
							str = str.replace(/[^a-z0-9 -]/g, '')
								.replace(/\s+/g, '-')
								.replace(/-+/g, '-');
							return str;
						}
					</script>
						<input id="pn" required class="form-control" type="text" name="display_name" placeholder="Mod name" value="<?php echo $mod['pretty_name'] ?>" />
						<br />
						<input id="slug" required pattern="^[a-z0-9]+(?:-[a-z0-9]+)*$" class="form-control" type="text" name="name" placeholder="Mod slug" value="<?php echo $mod['name'] ?>" /><br />
						<input class="form-control" type="text" name="version" placeholder="Mod Version" value="<?php echo $mod['version'] ?>"><br />
						<input class="form-control" type="text" name="author" placeholder="Mod Author" value="<?php echo $mod['author'] ?>"><br />
						<input class="form-control" type="url" name="link" placeholder="Mod Website" value="<?php echo $mod['link'] ?>"><br />
						<input class="form-control" type="url" name="donlink" placeholder="Author's Website" value="<?php echo $mod['donlink'] ?>"><br />
						<input class="form-control" required type="text" name="mcversion" placeholder="Minecraft Version" value="<?php echo $mod['mcversion'] ?>"><br />
						<input type="submit" value="Save" class="btn btn-success">
				</form>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#nav-mods").trigger('click');
			});
		</script>
		<?php
		}
		if(uri("/about")) {
			?>
			<div class="main">
				<div class="card">
					<center>
						<h1 class="display-4">About TechnicSolder</h1>
					</center>
					<hr>
					<blockquote class="blockquote">
						TechnicSolder is an API that sits between a modpack repository and the TechnicLauncher. It allows you to easily manage multiple modpacks in one single location.
						<br><br>
						Using Solder also means your packs will download each mod individually. This means the launcher can check MD5's against each version of a mod and if it hasn't changed, use the cached version of the mod instead. What does this mean? Small incremental updates to your modpack doesn't mean redownloading the whole thing every time!
						<br><br>
						Solder also interfaces with the Technic Platform using an API key you can generate through your account. When Solder has this key it can directly interact with your Platform account. When creating new modpacks you will be able to import any packs you have registered in your Solder install. It will also create detailed mod lists on your Platform page!
						<footer class="blockquote-footer"><a href="https://github.com/TechnicPack/TechnicSolder">Technic</a></footer>					
					</blockquote>
					<hr>
					<p>TechnicSolder was originaly developed by <a href="https://github.com/TechnicPack">Technic</a> using the Laravel Framework. However, the application is difficult to install and use. <a href="https://github.com/TheGameSpider/TechnicSolder">TechnicSolder</a> by <a href="https://github.com/TheGameSpider">TheGameSpider</a> runs on pure PHP with zip and curl extensions and it's very easy to use. To install, you just need to install zip and curl and extract TechnicSolder to your root folder. And the usage is even easier! Just Drag n' Drop your mods.</p>
					<p>This version of TechnicSolder have 2145 lines of code.</p>
					<p>Read the licence before redistributing.</p>
					<div class="card text-white bg-info mb3" style="padding:0">
						<div class="card-header">License</div>
						<div class="card-body">
							<p class="card-text"><?php print(file_get_contents("LICENSE")); ?></p>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#nav-settings").trigger('click');
				});
			</script>
			<?php
		}
	}
	?>
	</body>
</html>