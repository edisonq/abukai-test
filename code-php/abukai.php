<?php
###  error displays
error_reporting(E_ALL);
ini_set('display_errors', 0);

###  session
session_start();

###  dependencies
require_once './php/library/config.php';

if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("Location: index.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Abukai testing for my skills">
  <meta name="author" content="Edison Quinones">
  <link rel="apple-touch-icon" sizes="57x57" href="assets/icon/abukai/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/icon/abukai/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/icon/abukai//apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/icon/abukai//apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/icon/abukai//apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/icon/abukai//apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/icon/abukai//apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/icon/abukai//apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/icon/abukai//apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="assets/icon/abukai//android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/icon/abukai//favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/icon/abukai//favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/icon/abukai//favicon-16x16.png">
  <link rel="manifest" href="assets/icon/abukai//manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/icon/abukai//ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">


  <title>Abukai Test -  Screen Sharing</title>

        <script>
            if(!location.hash.replace('#', '').length) {
                location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
                location.reload();
            }
        </script>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <style>
            video {
                -moz-transition: all 1s ease;
                -ms-transition: all 1s ease;
                -o-transition: all 1s ease;
                -webkit-transition: all 1s ease;
                transition: all 1s ease;
                vertical-align: top;
                width: 100%;
            }
            
        </style>
        <script>
            document.createElement('article');
            document.createElement('footer');
        </script>

        <!-- scripts used for screen-sharing -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="https://cdn.webrtc-experiment.com/socket.io.js"> </script>
        <script src="https://cdn.webrtc-experiment.com/DetectRTC.js"></script>
        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
        <script src="https://cdn.webrtc-experiment.com/CodecsHandler.js"></script>
        <script src="https://cdn.webrtc-experiment.com/BandwidthHandler.js"></script>
        <script src="https://cdn.webrtc-experiment.com/IceServersHandler.js"></script>
        <script src="js/conference.js"> </script>
    </head>

    <body>
        <article>
            



            <!-- just copy this <section> and next script -->
            <section class="experiment">
                <section class="hide-after-join" style="text-align: center;">                    
                    <input type="text" id="room-name" placeholder="Enter " style="width: 80%; text-align: center; display: none;">
                    Loading video<!-- <button id="share-screen" class="setup">Share Your Screen</button> -->
                    <br>Reload page if no activity
                </section>

                <!-- local/remote videos container -->
                <div id="videos-container"></div>

                <section id="unique-token" style="display: none; text-align: center; padding: 20px;" ></section>
            </section>

            <script>
                var config = {
                    openSocket: function(config) {
                        var SIGNALING_SERVER = 'https://webrtcweb.com:9559/';
                        config.channel = config.channel || location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                        var sender = Math.round(Math.random() * 999999999) + 999999999;
                        io.connect(SIGNALING_SERVER).emit('new-channel', {
                            channel: config.channel,
                            sender: sender
                        });
                        var socket = io.connect(SIGNALING_SERVER + config.channel);
                        socket.channel = config.channel;
                        socket.on('connect', function () {
                            if (config.callback) config.callback(socket);
                        });
                        socket.send = function (message) {
                            socket.emit('message', {
                                sender: sender,
                                data: message
                            });
                        };
                        socket.on('message', config.onmessage);
                    },
                    onRemoteStream: function(media) {
                        if(isbroadcaster) return;
                        var video = media.video;
                        videosContainer.insertBefore(video, videosContainer.firstChild);
                        document.querySelector('.hide-after-join').style.display = 'none';
                    },
                    onRoomFound: function(room) {
                        document.getElementById("viewer-only").value = "true";
                        if(isbroadcaster) return;
                        conferenceUI.joinRoom({
                            roomToken: room.roomToken,
                            joinUser: room.broadcaster
                        });
                        document.querySelector('.hide-after-join').innerHTML = '<img src="https://cdn.webrtc-experiment.com/images/key-press.gif" style="margint-top:10px; width:50%;" />';
                    },
                    onNewParticipant: function(numberOfParticipants) {
                        var text = numberOfParticipants + ' users are viewing your screen!';
                        
                        if(numberOfParticipants <= 0) {
                            text = 'No one is viewing your screen YET.';
                        }
                        else if(numberOfParticipants == 1) {
                            text = 'Only one user is viewing your screen!';
                        }
                        document.title = text;
                        showErrorMessage(document.title, 'green');
                    },
                    oniceconnectionstatechange: function(state) {
                        var text = '';
                        if(state == 'closed' || state == 'disconnected') {
                            text = 'One of the participants just left.';
                            document.title = text;
                            showErrorMessage(document.title);
                        }
                        if(state == 'failed') {
                            text = 'Failed to bypass Firewall rules. It seems that target user did not receive your screen. Please ask him reload the page and try again.';
                            document.title = text;
                            showErrorMessage(document.title);
                        }
                        if(state == 'connected' || state == 'completed') {
                            text = 'A user successfully received your screen.';
                            document.title = text;
                            showErrorMessage(document.title, 'green');
                        }
                        if(state == 'new' || state == 'checking') {
                            text = 'Someone is trying to join you.';
                            document.title = text;
                            showErrorMessage(document.title, 'green');
                        }
                    }
                };
                function showErrorMessage(error, color) {
                    var errorMessage = document.querySelector('#logs-message');
                    errorMessage.style.color = color || 'red';
                    errorMessage.innerHTML = error;
                    errorMessage.style.display = 'block';
                }
                function getDisplayMediaError(error) {
                    if (location.protocol === 'http:') {
                        showErrorMessage('Please test this WebRTC experiment on HTTPS.');
                    } else {
                        showErrorMessage(error.toString());
                    }
                }
                function captureUserMedia(callback) {
                    var video = document.createElement('video');
                    video.muted = true;
                    video.volume = 0;
                    try {
                        video.setAttributeNode(document.createAttribute('autoplay'));
                        video.setAttributeNode(document.createAttribute('playsinline'));
                        video.setAttributeNode(document.createAttribute('controls'));
                    } catch (e) {
                        video.setAttribute('autoplay', true);
                        video.setAttribute('playsinline', true);
                        video.setAttribute('controls', true);
                    }
                    if(navigator.getDisplayMedia || navigator.mediaDevices.getDisplayMedia) {
                        function onGettingSteam(stream) {
                            video.srcObject = stream;
                            videosContainer.insertBefore(video, videosContainer.firstChild);
                            addStreamStopListener(stream, function() {
                                location.reload();
                            });
                            config.attachStream = stream;
                            callback && callback();
                            addStreamStopListener(stream, function() {
                                location.reload();
                            });
                            showPrivateLink();
                            document.querySelector('.hide-after-join').style.display = 'none';
                        }
                        if(navigator.mediaDevices.getDisplayMedia) {
                            navigator.mediaDevices.getDisplayMedia({video: true}).then(stream => {
                                onGettingSteam(stream);
                            }, getDisplayMediaError).catch(getDisplayMediaError);
                        }
                        else if(navigator.getDisplayMedia) {
                            navigator.getDisplayMedia({video: true}).then(stream => {
                                onGettingSteam(stream);
                            }, getDisplayMediaError).catch(getDisplayMediaError);
                        }
                    }
                    else {
                        if (DetectRTC.browser.name === 'Chrome') {
                            if (DetectRTC.browser.version == 71) {
                                showErrorMessage('Please enable "Experimental WebPlatform" flag via chrome://flags.');
                            } else if (DetectRTC.browser.version < 71) {
                                showErrorMessage('Please upgrade your Chrome browser.');
                            } else {
                                showErrorMessage('Please make sure that you are not using Chrome on iOS.');
                            }
                        }
                        if (DetectRTC.browser.name === 'Firefox') {
                            showErrorMessage('Please upgrade your Firefox browser.');
                        }
                        if (DetectRTC.browser.name === 'Edge') {
                            showErrorMessage('Please upgrade your Edge browser.');
                        }
                        if (DetectRTC.browser.name === 'Safari') {
                            showErrorMessage('Safari does NOT supports getDisplayMedia API yet.');
                        }
                    }
                }
                /* on page load: get public rooms */
                var conferenceUI = conference(config);
                /* UI specific */
                var videosContainer = document.getElementById("videos-container") || document.body;
                function activateSharing () {
                    var viewerOnly = document.getElementById("viewer-only").value;
                    if(viewerOnly === 'false') {
                        var roomName = document.getElementById('room-name') || { };
                        roomName.disabled = true;
                        captureUserMedia(function() {
                            conferenceUI.createRoom({
                                roomName: (roomName.value || 'Anonymous') + ' shared his screen with you'
                            });
                        });
                        this.disabled = true;
                    } else {
                        console.log('viewer only',viewerOnly);
                    }
                }
                
                
                function showPrivateLink() {
                    var uniqueToken = document.getElementById('unique-token');
                    uniqueToken.innerHTML = 'Share this url: <input readonly class="copy-text" id="share-url" type="text" value="' + location.href +'" ><button onclick="copyTextNow()" class="copy-text">Copy text</button>';
                    uniqueToken.style.display = 'block';
                }
                $( document ).ready(function() {
                    document.querySelector('.hide-after-join').innerHTML = '<img src="https://cdn.webrtc-experiment.com/images/key-press.gif" style="margint-top:10px; width:50%;" />';
                    setTimeout(() => {
                            activateSharing ();
                    }, 5000);                    
                });

                let copyTextNow = () => {
                    var copyText = document.getElementById("share-url");

                    /* Select the text field */
                    copyText.select();

                    /* Copy the text inside the text field */
                    document.execCommand("copy");

                    /* Alert the copied text */
                    alert("Share this url (copied on your clipboard): " + copyText.value);

                }
            </script>


        </article>
<input type="hidden" value="false" id="viewer-only" name="viewer-only" />

    </body>
</html>
