<?php
// Initialize the session
session_start();

if (file_exists("userdata/accessCode.txt")) {
	// Check if the user is logged in, if not then redirect him to login page
	$myfile = fopen('tournament.txt', "r") or die("Unknown tournament. This tournament has been corrupted.");
	$tournament = trim(fgets($myfile));
	fclose($myfile);

	if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["tournament"] !== $tournament) {
		// header("location: ../../login.php");
		header("location: login.php?req=temp&header=" . $_GET["header"] . "&auth=" . $_SERVER['REQUEST_URI']);
		exit;
	}
}
date_default_timezone_set("UTC");

?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>

<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/maphilight/1.4.0/jquery.maphilight.min.js"></script>
	<title>Virtual Pits</title>

</head>

<body>
	<script>
		$(function() {
			$("#topbar").load("../../topbar.php");
		});
	</script>
	<div id="topbar" <?php if ($_GET["header"] == "hide") echo 'style="display:none;"' ?>></div><br>
	<div>
		<script>
			$(function() {
				$("#header").load("header.php");
			});
		</script>
		<?php
		if ($_GET["header"] == "hide" && strpos($_SERVER['SERVER_NAME'], "virtualopeninvitational") !== false) {
			echo '
			<a href="http://virtualopeninvitational.org/VOImainpage.html"><img src="browsers-back-button.png" class="clickable" style="background-color:white;" width="50px" height="50px"></a><br><br>
			';
		}
		?>
		<div id="header" <?php if ($_GET["header"] == "hide") echo 'style="display:none;"' ?>></div><br>
		<section style="padding: 5px 5px 5px 15px;">

			<h2>
				<script>
					function textFileToArray(filename) {
						var reader = (window.XMLHttpRequest != null) ?
							new XMLHttpRequest() :
							new ActiveXObject("Microsoft.XMLHTTP");
						reader.open("GET", filename, false);
						reader.send();
						return reader.responseText.split(/\r\n|\n|\r/); //split(/(\r\n|\n)/g)
					}
					document.write(textFileToArray('tournament.txt')[0]);

					function detectAppleWebKit() {
						userAgent = window.navigator.userAgent.toLowerCase()
						return userAgent.indexOf("applewebkit") != -1 && userAgent.indexOf("chrome") == -1
					}

					applewebkit = detectAppleWebKit()
				</script>

				Virtual Pits
			</h2>
		</section><br>
		<section>
			<div class="text-body" style="font-size: 12px;" id="allContent">
				<p style="font-size: 150%;">
					<?php
					if (!file_exists("admin/pitinfo.txt")) die("Error: Pit info not found.")
					?>
				<h1></h1>
				<div id="myModal" class="modal">

					<!-- Modal content -->
					<!-- <div class="modal-content">
						<span class="close">&times;</span>
						<p id='modal-content'>Some text in the Modal..</p>
					</div> -->

				</div>
				<style>
					img.map,
					map area {
						outline: 1px red;
					}

					/* .modal {
				display: none;
				position: fixed;
				z-index: 1;
				padding-top: 20px;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				overflow: auto;
				background-color: rgb(0, 0, 0);
				background-color: rgba(0, 0, 0, 0.4);
			}

			.modal-content {
			background-color: #fefefe;
			margin: auto;
			padding: 20px;
			border: 1px solid #888;
			width: 80%;
		}

		.close {
		color: #aaaaaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
	color: #000;
	text-decoration: none;
	cursor: pointer;
	} */


					button {
						color: white;
						background-color: transparent;
						text-decoration: none;
					}

					/* a:visited {
		color: #eeeeee;
		background-color: transparent;
		text-decoration: none;
	}
 */

					/* Common Styles */
					.content {
						color: #fff;
						font: 100 24px/100px sans-serif;
						/* height: 167px; */
						text-align: center;
					}

					.content div {
						height: 167px;
						width: 200px;
						margin: 5px;
						/* margin-bottom: 20px; */
						border: 1px solid #000000;
						padding: 3px 2px;
						/* width: 12%;
		height: 100px; */
						vertical-align: middle;
						text-align: center;
						border-radius: 15px
					}

					.red {
						background: orangered;
					}

					.green {
						background: yellowgreen;
					}

					.blue {
						background: steelblue;
					}

					/* Flexbox Styles */
					.content {
						display: flex;
						flex-wrap: wrap;
						align-items: flex-end;
					}

					.grid-cell:nth-child(2) {
						margin-top: 0px;
					}

					.myBtn {
						border-radius: 15px;
						cursor: pointer;
						width: 100%;
						height: 30%;
						border: none;
						color: black;
						font-weight: bold;
						font-size: 14px;
						word-wrap: break-word;
						background: rgba(255, 255, 255, 0.7);
						position: relative;
						bottom: 0px;
						line-height: normal !important;
					}

					.modal {
						padding: 0 !important;
					}

					.modal .modal-dialog {
						width: 100%;
						max-width: none;
						height: 100%;
						margin: 0;
						padding: 20px;
					}

					.modal .modal-content {
						height: 100%;
						border: 0;
						border-radius: 0;
					}

					.modal .modal-body {
						overflow-y: auto;
					}

					.clickable {
						-webkit-filter: brightness(100%);
					}

					.clickable:hover {
						-webkit-filter: brightness(70%);
						-webkit-transition: all 1s ease;
						-moz-transition: all 1s ease;
						-o-transition: all 1s ease;
						-ms-transition: all 1s ease;
						transition: all 1s ease;
					}
				</style>
				<!-- <table class="blueTable"> -->
				<!-- <tbody> -->
				<div class="content">
					<script>
						// Get the modal
						// var modal = document.getElementById("myModal");

						// Get the button that opens the modal
						// var btn = document.getElementById("myBtn");

						// Get the <span> element that closes the modal
						// var span = document.getElementsByClassName("close")[0];

						// When the user clicks the button, open the modal
						// btn.onclick = function () {
						// 	modal.style.display = "block";
						// }

						// When the user clicks on <span> (x), close the modal
						// span.onclick = function() {
						// 	modal.style.display = "none";
						// }

						// // When the user clicks anywhere outside of the modal, close it
						// window.onclick = function(event) {
						// 	if (event.target == modal) {
						// 		modal.style.display = "none";
						// 	}
						// }


						const csvStringToArray = (data) => {
							const re = /(,|\r?\n|\r|^)(?:"([^"]*(?:""[^"]*)*)"|([^,\r\n]*))/gi
							const result = [
								[]
							]
							let matches
							while ((matches = re.exec(data))) {
								if (matches[1].length && matches[1] !== ',') result.push([])
								result[result.length - 1].push(
									matches[2] !== undefined ? matches[2].replace(/""/g, '"') : matches[3]
								)
							}
							return result
						}

						dataRaw = `<?php echo file_get_contents("admin/pitinfo.txt"); ?>`;
						data = dataRaw.split("\n");
						parsed = csvStringToArray(dataRaw);


						meetTeams = false;

						boothsPerLine = Math.round((window.innerWidth - 150) / 200)

						function createTable(data) {
							for (i = 0; i < data.length; i++) {
								team = data[i]
								if (i % boothsPerLine == 0 && i != 0) {
									document.write(
										`
						</tr>
						<!--	</tbody>
						</table>-->
						`);
									// if (i % (boothsPerLine*2) == 0) document.write("<div class='content' style='height:80px'></div>");
									// else document.write("<div class='content' style='height:10px'></div>");
									// 		document.write(`
									// 			<div class='content'>
									// `
									// 		);
								} else if (i == 0) {
									// 		document.write(
									// 			`
									// 			<div class='content'>
									// `
									// 		);
								}

								// else if (i==data.length-1) {
								// 	document.write(
								// 		`
								// 	</tr>
								// 			</tbody>
								// 		</table>
								// 		`
								// 	);
								// }
								document.write('<div class="grid-cell clickable" onclick="loadModal(' + i + ');"  style="cursor:pointer;background-image: url(\'' + team[2] + '\');background-size: cover;width:200px;height:167px;"> <div style="height:60%;border:none;"></div><button  class="myBtn clickable"  onclick="loadModal(' + i + ');">' + team[0] + '<br>' + team[1] + '</button> ');
								// if (meetTeams) document.write("<br><a href='"+team[4]+"'>Video Chat</a>")
								document.write("</div>");
								// document.write("<img usemap='#image-map" + String(i) + "' width='100%' src='" + team[2] + "'>" + '<map name="image-map"+String(i)+"">' + team[3] + '</map>')
								if (i % boothsPerLine != boothsPerLine - 1) {
									// document.write('<div></div>');
								}

							}
						}! function() {
							"use strict";

							function r() {
								function e() {
									var r = {
											width: u.width / u.naturalWidth,
											height: u.height / u.naturalHeight
										},
										a = {
											width: parseInt(window.getComputedStyle(u, null).getPropertyValue("padding-left"), 10),
											height: parseInt(window.getComputedStyle(u, null).getPropertyValue("padding-top"), 10)
										};
									i.forEach(function(e, t) {
										var n = 0;
										o[t].coords = e.split(",").map(function(e) {
											var t = 1 == (n = 1 - n) ? "width" : "height";
											return a[t] + Math.floor(Number(e) * r[t])
										}).join(",")
									})
								}

								function t(e) {
									return e.coords.replace(/ *, */g, ",").replace(/ +/g, ",")
								}

								function n() {
									clearTimeout(d), d = setTimeout(e, 250)
								}

								function r(e) {
									return document.querySelector('img[usemap="' + e + '"]')
								}
								var a = this,
									o = null,
									i = null,
									u = null,
									d = null;
								"function" != typeof a._resize ? (o = a.getElementsByTagName("area"), i = Array.prototype.map.call(o, t), u = r("#" + a.name) || r(a.name), a._resize = e, u.addEventListener("load", e, !1), window.addEventListener("focus", e, !1), window.addEventListener("resize", n, !1), window.addEventListener("readystatechange", e, !1), document.addEventListener("fullscreenchange", e, !1), u.width === u.naturalWidth && u.height === u.naturalHeight || e()) : a._resize()
							}

							function e() {
								function t(e) {
									e && (! function(e) {
										if (!e.tagName) throw new TypeError("Object is not a valid DOM element");
										if ("MAP" !== e.tagName.toUpperCase()) throw new TypeError("Expected <MAP> tag, found <" + e.tagName + ">.")
									}(e), r.call(e), n.push(e))
								}
								var n;
								return function(e) {
									switch (n = [], typeof e) {
										case "undefined":
										case "string":
											Array.prototype.forEach.call(document.querySelectorAll(e || "map"), t);
											break;
										case "object":
											t(e);
											break;
										default:
											throw new TypeError("Unexpected data type (" + typeof e + ").")
									}
									return n
								}
							}
							"function" == typeof define && define.amd ? define([], e) : "object" == typeof module && "object" == typeof module.exports ? module.exports = e() : window.imageMapResize = e(), "jQuery" in window && (window.jQuery.fn.imageMapResize = function() {
								return this.filter("map").each(r).end()
							})
						}();

						function loadModal(index) {
							// alert("hi")
							content = parsed[index];
							// modal.style.display = "block";
							$('#exampleModal').modal('show')
							h = window.innerHeight - 100;
							document.getElementById("exampleModalLabel").innerHTML = "Team No. " + content[0] + ": " + content[1];
							if (content[3] != undefined) document.getElementById("modal-content").innerHTML = "<img id='teamimg' class='map' usemap='#image-map' style='max-width:100%;max-height:100%;' src='" + content[2] + "'>" + '<map name="image-map">' + content[3] + '</map>';
							else document.getElementById("modal-content").innerHTML = "<img id='teamimg' usemap='#image-map' style='max-width:100%;max-height:" + h + "px;' src='" + content[2] + "'>";
							if (!applewebkit) {
								$(function() {
									$('.map').maphilight();
								});
							}
							$('map').imageMapResize();
							setTimeout(function() {
								if (!applewebkit) {

									$(function() {
										// document.getElementById("teamimg").style.maxWidth="90%";
										$('.map').maphilight();
									});
								}
							}, 500);
							setTimeout(function() {
								// document.getElementById("teamimg").style.maxWidth="100%";
								$('map').imageMapResize();
							}, 600);
						}

						createTable(parsed);
					</script>
				</div>
				</tr>
				<!-- </tbody>
</table> -->
				<!-- </tbody>
</table> -->
			</div>

			<!-- Button trigger modal -->
			<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
Launch demo modal
</button> -->

			<!-- Modal -->
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
				<!-- style="overflow-x:hidden;overflow-y:hidden;" -->
					<div class="modal-content" >
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<!-- style="overflow-x:hidden;overflow-y:hidden;" -->
						<div class="modal-body" >
							<p id='modal-content'>Some text in the Modal..</p>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			</center>

			</p>
	</div>

	</section>
	<br>
	<script>
		$(function() {
			$("#footer").load("footer.html");
		});
	</script>
	<div id="footer"></div>
	</div>
	<script src='js/accordian.js'></script>
	<script>
		var styleEl = document.createElement('style');

		// Append <style> element to <head>
		document.head.appendChild(styleEl);

		// Grab style element's sheet
		var styleSheet = styleEl.sheet;

		function addStylesheetRules(rules) {

			for (var i = 0; i < rules.length; i++) {
				var j = 1,
					rule = rules[i],
					selector = rule[0],
					propStr = '';
				// If the second argument of a rule is an array of arrays, correct our variables.
				if (Array.isArray(rule[1][0])) {
					rule = rule[1];
					j = 0;
				}

				for (var pl = rule.length; j < pl; j++) {
					var prop = rule[j];
					propStr += prop[0] + ': ' + prop[1] + (prop[2] ? ' !important' : '') + ';\n';
				}

				// Insert CSS Rule
				styleSheet.insertRule(selector + '{' + propStr + '}', styleSheet.cssRules.length);
				return (styleSheet.cssRules.length);
			}
		}

		function resplit() {
			width = 2 * Math.floor(document.getElementById("allContent").offsetWidth / 210)
			prop = '.grid-cell:nth-child(' + width + 'n+2)'
			if (styleSheet.cssRules.length > 0) {
				styleSheet.deleteRule(0);
			}
			test = addStylesheetRules([
				[prop, ['margin-top', '80px']]
			]);
			// styleSheet.deleteRule(0);
			// test = addStylesheetRules([['.Grid-cell:nth-child(5n+1)', ['background', 'green'], ['margin-top','50px']]]);
			// document.getElementById("teamimg").style.maxWidth="90%";
			if (!applewebkit) {
				$(function() {
					$('.map').maphilight();
				});
			}
			// document.getElementById("teamimg").style.maxWidth="100%";

			$('map').imageMapResize();
		}

		resplit();
		window.onresize = resplit;
	</script>

</body>


</html>