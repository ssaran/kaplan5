function JanusWrapper(config) {
    if (typeof Janus === 'undefined') {
        console.error("Janus lib not found");
        return;
    }

    return {
        config : config,
        janus : null,
        recordPlay : '',
        opaqueId : '',
        localTracks : {},
        localVideos : 0,
        remoteTracks : {},
        remoteVideos : 0,
        selectedRecording : null,
        selectedRecordingInfo : null,
        recording : false,
        playing : false,
        myName : "nettocontact",
        Init : function () {
            try {
                if(!Janus.isWebrtcSupported()) {
                    this.Notify("No WebRTC support... ",'error');
                    return;
                }
                var self = this;

                $(document).off("click",this.config.dom.record).on("click",this.config.dom.record,function (evt){
                    self.startRecording(self);
                });
                /*$(document).off("click",this.config.dom.play).on("click",this.config.dom.play,function (evt){
                    self.startPlayout(self);
                });*/
                $(document).off("click",this.config.dom.list).on("click",this.config.dom.list,function (evt){
                    self.updateRecsList(self);
                });
                $(document).off("click",this.config.dom.stop).on("click",this.config.dom.stop,function (evt){
                    self.stop(self);
                });

                $(document).off("click","."+this.config.css.video_player_trigger).on("click","."+this.config.css.video_player_trigger,function (evt){
                    self.startPlayout(self, {"record_id":$(this).data('recid')});
                });

                Janus.init({debug:this.config.debug,callback:function (){
                        self.janus = new Janus(
                            {
                                server: self.config.server,
                                iceServers: self.config.iceServers,
                                // Should the Janus API require authentication, you can specify either the API secret or user token here too
                                //		token: "mytoken",
                                //	or
                                //		apisecret: "serversecret",
                                success: function () {// Attach to Record&Play plugin
                                    self.janus.attach(
                                        {
                                            plugin: self.config.plugin,
                                            opaqueId: self.opaqueId,
                                            success: function(pluginHandle) {
                                                $(self.config.dom.details).remove();
                                                self.recordplay = pluginHandle;
                                                Janus.log("Plugin attached! (" + self.recordplay.getPlugin() + ", id=" + self.recordplay.getId() + ")");
                                                // Prepare the name prompt
                                                $(self.config.dom.recordplay).removeClass('hide').show();
                                                /*$(self.config.dom.start).removeAttr('disabled').html("Stop").click(function() {
                                                    $(this).attr('disabled', true);
                                                    self.janus.destroy();
                                                });*/
                                                self.updateRecsList(self);
                                            },
                                            error: function(error) {
                                                Janus.error(error);
                                                self.Notify("  -- Error attaching plugin... " + error,'error');
                                            },
                                            consentDialog: function(on) {
                                                Janus.debug("Consent dialog should be " + (on ? "on" : "off") + " now");
                                            },
                                            iceState: function(state) {
                                                Janus.log("ICE state changed to " + state);
                                            },
                                            mediaState: function(medium, on, mid) {
                                                Janus.log("Janus " + (on ? "started" : "stopped") + " receiving our " + medium + " (mid=" + mid + ")");
                                            },
                                            webrtcState: function(on) {
                                                Janus.log("Janus says our WebRTC PeerConnection is " + (on ? "up" : "down") + " now");
                                                $(self.config.dom.videoBox).parent().unblock();
                                            },
                                            slowLink: function(uplink, lost, mid) {
                                                self.janus.warn("Janus reports problems " + (uplink ? "sending" : "receiving") + " packets on mid " + mid + " (" + lost + " lost packets)");
                                            },
                                            onmessage: function(msg, jsep) {
                                                Janus.debug(" ::: Got a message :::", msg);
                                                let result = msg["result"];
                                                if(result) {
                                                    if(result["status"]) {
                                                        var event = result["status"];
                                                        if(event === 'preparing' || event === 'refreshing') {
                                                            Janus.log("Preparing the recording playout");
                                                            self.recordplay.createAnswer(
                                                                {
                                                                    jsep: jsep,
                                                                    // We only specify data channels here, as this way in
                                                                    // case they were offered we'll enable them. Since we
                                                                    // don't mention audio or video tracks, we autoaccept them
                                                                    // as recvonly (since we won't capture anything ourselves)
                                                                    tracks: [
                                                                        { type: 'data' }
                                                                    ],
                                                                    success: function(jsep) {
                                                                        Janus.debug("Got SDP!", jsep);
                                                                        self.recordplay.send({ message: { request: "start" }, jsep: jsep });
                                                                    },
                                                                    error: function(error) {
                                                                        Janus.error("WebRTC error:", error);
                                                                        self.Notify("WebRTC error... " + error.message,'error')
                                                                    }
                                                                });
                                                            if(result["warning"]) {
                                                                self.Notify(result["warning"],'error');
                                                            }

                                                        } else if(event === 'recording') {
                                                            // Got an ANSWER to our recording OFFER
                                                            if(jsep) {
                                                                self.recordplay.handleRemoteJsep({ jsep: jsep });
                                                            }

                                                            if(result["id"]) {
                                                                Janus.log("The ID of the current recording is " + result["id"]);
                                                                self.recordingId = result["id"];
                                                            }
                                                        } else if(event === 'playing') {
                                                            Janus.log("Playout has started!");
                                                        } else if(event === 'stopped') {
                                                            Janus.log("Session has stopped!");
                                                            if(self.recordingId) {
                                                                if(self.recordingId !== result["id"]) {
                                                                    self.janus.warn("Not a stop to our recording?");
                                                                    return;
                                                                }
                                                                self.Notify("Recording completed! Check the list of recordings to replay it.",'error');
                                                            }
                                                            if(self.selectedRecording) {
                                                                if(self.selectedRecording !== id) {
                                                                    self.janus.warn("Not a stop to our playout?");
                                                                    return;
                                                                }
                                                            }
                                                            const that = self;
                                                            // FIXME Reset status
                                                            $(self.config.dom.videoBox).empty();
                                                            $(self.config.dom.video).hide();
                                                            self.recordingId = null;
                                                            self.recording = false;
                                                            self.playing = false;
                                                            self.recordplay.hangup();
                                                            $(self.config.dom.record).removeAttr('disabled');
                                                            $(self.config.dom.play).removeAttr('disabled');
                                                            $(self.config.dom.list).removeAttr('disabled');
                                                            $(self.config.dom.recset).removeAttr('disabled');
                                                            $(self.config.dom.recslist).removeAttr('disabled');
                                                            self.updateRecsList(self);
                                                        }
                                                    }
                                                } else {
                                                    // FIXME Error?
                                                    self.Notify("  -- Error " + msg["error"],'error');
                                                    // FIXME Reset status
                                                    $(self.config.dom.videoBox).empty();
                                                    $(self.config.dom.video).hide();
                                                    self.recording = false;
                                                    self.playing = false;
                                                    self.recordplay.hangup();
                                                    $(self.config.dom.record).removeAttr('disabled');
                                                    $(self.config.dom.play).removeAttr('disabled');
                                                    $(self.config.dom.list).removeAttr('disabled');
                                                    $(self.config.dom.recset).removeAttr('disabled');
                                                    $(self.config.dom.recslist).removeAttr('disabled');
                                                    self.updateRecsList(self);
                                                }
                                            },
                                            onlocaltrack: function(track, on) {
                                                if(self.playing === true) {
                                                    return;
                                                }

                                                Janus.debug("Local track " + (on ? "added" : "removed") + ":", track);
                                                // We use the track ID as name of the element, but it may contain invalid characters
                                                let trackId = track.id.replace(/[{}]/g, "");
                                                if(!on) {
                                                    // Track removed, get rid of the stream and the rendering
                                                    let stream = self.localTracks[trackId];
                                                    if(stream) {
                                                        try {
                                                            let tracks = stream.getTracks();
                                                            for(let i in tracks) {
                                                                if(tracks[i]) {
                                                                    mst.stop();
                                                                }
                                                            }
                                                        } catch(e) {}
                                                    }
                                                    if(track.kind === "video") {
                                                        $('#'+self.config.dom.thevideo + trackId).remove();
                                                        self.localVideos--;
                                                        if(self.localVideos === 0) {
                                                            // No video, at least for now: show a placeholder
                                                            if($(self.config.dom.videoBox+' .no-video-container').length === 0) {
                                                                $(self.config.dom.videoBox).append(
                                                                    '<div class="no-video-container">' +
                                                                    '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
                                                                    '<span class="no-video-text">No webcam available</span>' +
                                                                    '</div>'
                                                                );
                                                            }
                                                        }
                                                    }
                                                    delete self.localTracks[trackId];
                                                    return;
                                                }
                                                // If we're here, a new track was added
                                                let stream = self.localTracks[trackId];
                                                if(stream) {
                                                    // We've been here already
                                                    return;
                                                }
                                                $(self.config.dom.videotitle).html("Recording...");
                                                $(self.config.dom.stop).unbind('click');
                                                $(self.config.dom.video).removeClass('hide').show();
                                                /*if($(self.config.dom.videoBox+' video').length === 0) {
                                                    $(self.config.dom.videos).removeClass('hide').show();
                                                }*/
                                                if(track.kind === "audio") {
                                                    // We ignore local audio tracks, they'd generate echo anyway
                                                    if(self.localVideos === 0) {
                                                        // No video, at least for now: show a placeholder
                                                        if($(self.config.dom.videoBox+' .no-video-container').length === 0) {
                                                            $(self.config.dom.videoBox).append(
                                                                '<div class="no-video-container">' +
                                                                '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
                                                                '<span class="no-video-text">No webcam available</span>' +
                                                                '</div>'
                                                            );
                                                        }
                                                    }
                                                } else {
                                                    // New video track: create a stream out of it
                                                    self.localVideos++;
                                                    $(self.config.dom.videoBox+' .no-video-container').remove();
                                                    stream = new MediaStream([track]);
                                                    self.localTracks[trackId] = stream;
                                                    Janus.log("Created local stream:", stream);
                                                    $(self.config.dom.videoBox).append('<video class="rounded centered hede" id="'+self.config.dom.thevideo + trackId + '" width="100%" height="100%" autoplay playsinline muted="muted"/>');
                                                    Janus.attachMediaStream($('#'+self.config.dom.thevideo + trackId).get(0), stream);
                                                }
                                                if(self.recordplay.webrtcStuff.pc.iceConnectionState !== "completed" &&
                                                    self.recordplay.webrtcStuff.pc.iceConnectionState !== "connected") {
                                                    $(self.config.dom.videoBox).parent().block({
                                                        message: '<b>Publishing...</b>',
                                                        css: {
                                                            border: 'none',
                                                            backgroundColor: 'transparent',
                                                            color: 'white'
                                                        }
                                                    });
                                                }
                                            },
                                            onremotetrack: function(track, mid, on) {
                                                if(self.playing === false) {
                                                    return;
                                                }

                                                Janus.debug("Remote track (mid=" + mid + ") " + (on ? "added" : "removed") + ":", track);
                                                if(!on) {
                                                    // Track removed, get rid of the stream and the rendering
                                                    let stream = self.remoteTracks[mid];
                                                    if(stream) {
                                                        try {
                                                            let tracks = stream.getTracks();
                                                            for(let i in tracks) {
                                                                if(tracks[i]) {
                                                                    tracks[i].stop();
                                                                }
                                                            }
                                                        } catch(e) {}
                                                    }
                                                    $('#'+self.config.dom.thevideo + mid).remove();
                                                    if(track.kind === "video") {
                                                        self.remoteVideos--;
                                                        if(self.remoteVideos === 0) {
                                                            // No video, at least for now: show a placeholder
                                                            if($(self.config.dom.videoBox+' .no-video-container').length === 0) {
                                                                $(self.config.dom.videoBox).append(
                                                                    '<div class="no-video-container">' +
                                                                    '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
                                                                    '<span class="no-video-text">No remote video available</span>' +
                                                                    '</div>'
                                                                );
                                                            }
                                                        }
                                                    }
                                                    delete self.remoteTracks[mid];
                                                    return;
                                                }
                                                // If we're here, a new track was added
                                                if($(self.config.dom.videoBox+' audio').length === 0 && $(self.config.dom.videoBox+' video').length === 0) {
                                                    $(self.config.dom.videotitle).html(self.selectedRecordingInfo);
                                                    $(self.config.dom.stop).unbind('click');
                                                    $(self.config.dom.video).removeClass('hide').show();
                                                }
                                                if(track.kind === "audio") {
                                                    // New audio track: create a stream out of it, and use a hidden <audio> element
                                                    let stream = new MediaStream([track]);
                                                    self.remoteTracks[mid] = stream;
                                                    Janus.log("Created remote audio stream:", mid,stream);
                                                    let audioDomId = self.config.dom.theaudio +"_"+ mid;
                                                    if(!document.getElementById(audioDomId)) {
                                                        $(self.config.dom.videoBox).append('<audio class="hide" id="'+audioDomId+'" autoplay playsinline/>');
                                                    }
                                                    Janus.attachMediaStream($('#'+self.config.dom.theaudio +"_"+ mid).get(0), stream);
                                                    if(self.remoteVideos === 0) {
                                                        // No video, at least for now: show a placeholder
                                                        if($(self.config.dom.videoBox+' .no-video-container').length === 0) {
                                                            $(self.config.dom.videoBox).append(
                                                                '<div class="no-video-container">' +
                                                                '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
                                                                '<span class="no-video-text">No remote video available</span>' +
                                                                '</div>'
                                                            );
                                                        }
                                                    }
                                                } else {
                                                    // New video track: create a stream out of it
                                                        self.remoteVideos++;
                                                        $(self.config.dom.videoBox+' .no-video-container').remove();
                                                        let stream = new MediaStream([track]);
                                                        self.remoteTracks[mid] = stream;
                                                        Janus.log("Created remote video stream:", stream);
                                                        let videoDomId = self.config.dom.thevideo +"_"+ mid;
                                                        if(!document.getElementById(videoDomId)) {
                                                            $(self.config.dom.videoBox).append('<video class="rounded centered" id="'+videoDomId+'" width="100%" height="100%" autoplay playsinline/>');
                                                        }

                                                        Janus.attachMediaStream($('#'+self.config.dom.thevideo +"_"+ mid).get(0), stream);
                                                        if($('#'+self.config.dom.curres).length === 0) {
                                                            $(self.config.dom.videoBox).append(
                                                                '<span class="badge  badge-primary" id="'+self.config.dom.curres +'" style="position: absolute; bottom: 0px; left: 0px; margin: 15px;"></span>' +
                                                                '<span class="badge  badge-info" id="'+self.config.dom.curbw +'" style="position: absolute; bottom: 0px; right: 0px; margin: 15px;"></span>');
                                                            $('#'+self.config.dom.thevideo + mid).bind("playing", function () {
                                                                $('#'+self.config.dom.curres).text(this.videoWidth + 'x' + this.videoHeight);
                                                            });
                                                            self.recordplay.bitrateTimer = setInterval(function() {
                                                                // Display updated bitrate, if supported
                                                                let bitrate = self.recordplay.getBitrate();
                                                                $('#'+self.config.dom.curbw).text(bitrate);
                                                                let video = $('video').get(0);
                                                                let width = video.videoWidth;
                                                                let height = video.videoHeight;
                                                                if(width > 0 && height > 0) {
                                                                    $('#'+self.config.dom.curres).text(width + 'x' + height);
                                                                }
                                                            }, 1000);
                                                        }

                                                }
                                            },
                                            ondataopen: function(data) {
                                                Janus.log("The DataChannel is available!");
                                                /*$(self.config.dom.dataField).parent().removeClass('hide');
                                                if(self.playing === false) {
                                                    // We're recording, use this field to send data
                                                    $(self.config.dom.dataField).attr('placeholder', 'Write a message to record');
                                                    $(self.config.dom.dataField).removeAttr('disabled');
                                                }*/
                                            },
                                            ondata: function(data) {
                                                /*Janus.debug("We got data from the DataChannel!", data);
                                                if(self.playing === true) {
                                                    $(self.config.dom.dataField).val(data);
                                                }*/
                                            },
                                            oncleanup: function () {
                                                Janus.log(" ::: Got a cleanup notification :::");

                                                // FIXME Reset status
                                                $(self.config.dom.waitingVideo).remove();
                                                if(self.config.spinner) {
                                                    self.config.spinner.stop();
                                                }

                                                self.config.spinner = null;
                                                if(self.recordplay.bitrateTimer) {
                                                    clearInterval(self.recordplay.bitrateTimer);
                                                }

                                                delete self.recordplay.bitrateTimer;
                                                $(self.config.dom.videoBox).empty();
                                                $(self.config.dom.videoBox).parent().unblock();
                                                $(self.config.dom.video).hide();
                                                $(self.config.dom.dataField).attr('disabled', true).attr('placeholder', '').val('');
                                                $(self.config.dom.dataField).parent().addClass('hide');
                                                self.recording = false;
                                                self.playing = false;
                                                $(self.config.dom.record).removeAttr('disabled');
                                                $(self.config.dom.play).removeAttr('disabled');
                                                $(self.config.dom.list).removeAttr('disabled');
                                                $(self.config.dom.recset).removeAttr('disabled');
                                                $(self.config.dom.recslist).removeAttr('disabled');
                                                self.localTracks = {};
                                                self.localVideos = 0;
                                                self.remoteTracks = {};
                                                self.remoteVideos = 0;
                                                self.updateRecsList(self);
                                            }
                                        });
                                },
                                error: function (Error) {
                                    Janus.error(Error);
                                    self.Notify("  -- Error " + Error,'error');
                                },
                                destroyed: function () {
                                    console.log("Janus destroyed");
                                }
                            });
                    }
                });


            } catch (e) {
                console.error("Janus Wrapper",e);
            }
        },
        SetOpaqueId : function (opaqueId) {
            this.opaqueId = opaqueId;
        },
        SetMyName : function (myName) {
            console.info("Janus My Name a",this.myName);
            this.myName = myName;
            console.info("Janus My Name b",this.myName);
        },
        Notify : function (message,msgType="success") {
            Util.JSNotify(message,msgType);
        },
        updateRecsList : function (self) {
            $(self.config.dom.list).unbind('click');
            $(self.config.dom.update_list).addClass('fa-spin');
            var body = { request: "list" };
            Janus.debug("Sending message:", body);
            self.recordplay.send({ message: body, success: function(result) {
                    setTimeout(function() {
                        //$(self.config.dom.list).click(self.updateRecsList);
                        $(self.config.dom.update_list).removeClass('fa-spin');
                    }, 500);
                    if(!result) {
                        self.Notify("Got no response to our query for available recordings",'error');
                        return;
                    }
                    if(result["list"]) {
                        $(self.config.dom.recslist).empty();
                        $(self.config.dom.record).removeAttr('disabled');
                        $(self.config.dom.list).removeAttr('disabled');
                        var list = result["list"];
                        list.sort(function(a, b) {return (a["date"] < b["date"]) ? 1 : ((b["date"] < a["date"]) ? -1 : 0);} );
                        Janus.debug("Got a list of available recordings:", list);
                        var recordAmount = 0;
                        for(var mp in list) {
                            //Janus.debug("  >> [" + list[mp]["id"] + "] " + list[mp]["name"] + " (" + list[mp]["date"] + ")");
                            if(list[mp]["name"] == self.myName) {
                                //$(self.config.dom.recslist).append("<li><a href='#' id='" + list[mp]["id"] + "'>" + Util.EscapeXmlTags(list[mp]["name"]) + " [" + list[mp]["date"] + "]" + "</a></li>");
                                $(self.config.dom.recslist).append("<tr><td><button class='btn btn-sm btn-success btn-block "+self.config.css.video_player_trigger+"' data-recid='"+list[mp]["id"]+"'><i class='fas fa-play-circle'></i></button></td><td>" + Util.EscapeXmlTags(list[mp]["name"]) + "</td><td>"+list[mp]["date"]+"</td></tr>");
                                recordAmount++;
                            }
                        }
                        $(self.config.dom.recslist).data('total',recordAmount);
                        /*$(self.config.dom.recslist+' a').unbind('click').click(function() {
                            self.selectedRecording = $(this).attr("id");
                            self.selectedRecordingInfo = Util.EscapeXmlTags($(this).text());
                            $(self.config.dom.recset).html($(this).html()).parent().removeClass('open');
                            $(self.config.dom.play).removeAttr('disabled');
                            return false;
                        });*/
                    }
                }
            });
        },
        startRecording : function (self) {
            if(self.recording) {
                return;
            }

            // Start a recording
            self.recording = true;
            self.playing = false;

            $(self.config.dom.record).attr('disabled', true);
            $("."+self.config.css.video_player_trigger).attr('disabled', true);
            $(self.config.dom.pause_resume).removeClass('hide');

            // bitrate and keyframe interval can be set at any time:
            // before, after, during recording
            self.recordplay.send({
                message: {
                    request: 'configure',
                    'video-bitrate-max': self.config.bandwidth,		// a quarter megabit
                    'video-keyframe-interval': 15000	// 15 seconds
                }
            });

            self.recordplay.createOffer(
                {
                    // We want sendonly audio and video, since we'll just send
                    // media to Janus and not receive any back in this scenario
                    // (uncomment the data track if you want to also record data
                    // channels, even though there's no UI for that in the demo)
                    tracks: [
                        { type: 'audio', capture: true, recv: false },
                        { type: 'video', capture: true, recv: false, simulcast: self.config.doSimulcast },
                        //~ { type: 'data' },
                    ],
                    success: function(jsep) {
                        console.info("Janus My Name",self.myName);
                        Janus.debug("Got SDP!", jsep);
                        var body = { request: "record", name: self.myName };
                        // We can try and force a specific codec, by telling the plugin what we'd prefer
                        // For simplicity, you can set it via a query string (e.g., ?vcodec=vp9)
                        if(self.config.acodec) {
                            body["audiocodec"] = self.config.acodec;
                        }

                        if(self.config.vcodec) {
                            body["videocodec"] = self.config.vcodec;
                        }

                        // For the codecs that support them (VP9 and H.264) you can specify a codec
                        // profile as well (e.g., ?vprofile=2 for VP9, or ?vprofile=42e01f for H.264)
                        if(self.config.vprofile) {
                            body["videoprofile"] = self.config.vprofile;
                        }

                        // You can use RED for Opus, if the browser supports it
                        if(self.config.doOpusred) {
                            body["opusred"] = true;
                        }

                        // If we're going to send binary data, let's tell the plugin
                        if(self.config.recordData === "binary") {
                            body["textdata"] = false;
                        }

                        self.recordplay.send({ message: body, jsep: jsep });
                    },
                    error: function(error) {
                        Janus.error("WebRTC error...", error);
                        self.Notify("WebRTC error... " + error.message,'error');
                        self.recordplay.hangup();
                    }
                });

            $(self.config.dom.pause_resume).unbind('click').on('click', function() {
                if($(this).text() === 'Pause') {
                    self.recordplay.send({message: {request: 'pause'}});
                    $(this).text('Resume');
                } else {
                    self.recordplay.send({message: {request: 'resume'}});
                    $(this).text('Pause');
                }
            });
        },
        startPlayout : function (self,data) {
            if(self.playing) {
                return;
            }
            // Start a playout
            self.recording = false;
            self.playing = true;


            $(self.config.dom.record).unbind('click').attr('disabled', true);
            $("."+self.config.css.video_player_trigger).attr('disabled', true)
            $(self.config.dom.pause_resume).addClass('hide');
            self.recordplay.send({ message:{ request: "play", id: parseInt(data.record_id) }  });
        },
        stop : function (self) {
            // Stop a recording/playout
            $(self.config.dom.stop).unbind('click');
            self.recordplay.send({ message: { request: "stop" }});
            self.recordplay.hangup();
        }
    }
}





/*
var janusConfig = {
    server : 'Önceki Ay',
    iceServers : '',
    plugin : 'janus.plugin.recordplay',
    bandwidth : 1024 * 1024,
    myName : null,
    recordingId : null,
    spinner : null,
    acodec : null,
    vcodec : null,
    vprofile : null,
    doSimulcast : false,
    doOpusred : false,
    recordData : null,
    debug : "all",
    dom : {
        waitingVideo : "#waitingvideo",
        videoBox : "#videobox",
        video : "#video",
        dataField : "#datafield",
        record : "#record",
        recordPlay : "#recordplay",
        play : "#play",
        stop : "#stop",
        list : "#list",
        details : "#details",
        recset : "#recset",
        recslist : "#recslist",
        update_list : "#update-list",
        pause_resume : "#pause-resume",
        videotitle : "#videotitle",
        thevideo : "thevideo",
        curres : "curres",
        curbw : "curbw",
    }
};
*/