<template>
    <v-container fluid grid-list-md>
        <div>
            Disk Space:
            <v-tooltip bottom>
                <v-progress-linear slot="activator" :value="diskSpacePercentage" color="success"></v-progress-linear>
                <span>{{diskSpaceHuman}}</span>
            </v-tooltip>

        </div>
        <v-layout row wrap>
            <v-flex xs1>
                <v-btn flat icon color="green" @click="refreshLocalVideos">
                    <v-icon>cached</v-icon>
                </v-btn>
            </v-flex>
            <v-flex xs11>
                <v-text-field
                        append-icon="search"
                        label="Search"
                        v-model="search"
                ></v-text-field>
            </v-flex>
        </v-layout>
        <v-data-iterator
                content-tag="v-layout"
                row
                wrap
                :items="items"
                :rows-per-page-items="rowsPerPageItems"
                :pagination.sync="pagination"
                :loading="true"
                :search="search"
        >
            <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
            <v-flex
                    slot="item"
                    slot-scope="props"
                    xs12
                    sm6
                    md4
                    lg3
            >
                <v-card>
                    <v-card-media
                            class="white--text"
                            height="200px"
                            :src="returnThumbnail(props.item)"
                    >
                        <v-container fill-height fluid>
                            <v-layout fill-height>
                                <v-flex xs12 align-end flexbox>
                                    <span class="headline">
                                        <v-icon v-if='props.item.state == "new"' class="material-icons">new_releases</v-icon>
                                    </span>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-media>
                    <v-card-title primary-title>
                        <div>
                            <h3 class="headline mb-0">{{ props.item.name }}</h3>
                            <div>{{ props.item.description }}</div>
                        </div>
                    </v-card-title>
                    <v-card-actions>
                        <div v-if='props.item.state == "downloaded"'>
                            <v-layout row wrap align-center>
                                <!--<v-flex class="text-center">-->
                                    <v-btn v-on:click.native='downloadVideo(this, props.item)' block flat color="green">
                                        <i class="material-icons">file_download</i>
                                        <div v-if="props.item.human_size != 0">{{ props.item.human_size }}</div>
                                    </v-btn>
                                    <v-btn v-on:click.native='updateVideoStatus(this, props.item, "watched")' block flat color="red">
                                        <i class="material-icons">delete</i>
                                        <div v-if="props.item.human_size != 0">{{ props.item.human_size }}</div>
                                    </v-btn>
                                <!--</v-flex>-->
                            </v-layout>
                        </div>
                        <div v-else-if='props.item.state == "downloading"'>
                            <!--{{ returnDownloadedPercentage(props.item) }}-->
                            {{ props.item.downloaded_percentage }}
                        </div>
                        <v-btn v-on:click.native='updateVideoStatus(this, props.item, "watched")' block v-else-if='props.item.state == "queued"' flat color="orange">
                            <v-icon left class="material-icons">cancel</v-icon>
                        </v-btn>
                        <v-btn v-on:click.native='updateVideoStatus(this, props.item, "queued")' block v-else flat color="orange">
                            <v-icon left class="material-icons">cloud_download</v-icon>
                            <div v-if="props.item.human_size != 0">{{ props.item.human_size }}</div>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <template slot="no-data">
                <v-alert :value="true" color="error" icon="warning">
                    Sorry, nothing to display here :(<br>
                    Check you have an active service in settings
                </v-alert>
            </template>
        </v-data-iterator>
    </v-container>
</template>



<script>

    export default {
        data () {
            return {
                search: '',
                rowsPerPageItems: [8, 12],
                pagination: {
                    rowsPerPage: 8
                },
                loading: true,
                items: [

                ],
                diskSpacePercentage: "",
                diskSpaceHuman: "",
            }
        },
        mounted: function () {
            this.getData();
            this.$echo.channel('video.updated').listen('VideoStateUpdated', (e) => {
                console.log(e);
                this.updateLocalVideoStatus(e.video);
            });
            this.$echo.channel('disk.space').listen('CurrentDiskSpace', (space) => {
                console.log(space);
                this.diskSpaceHuman = space.human_size;
                this.diskSpacePercentage = space.percentage;
                this.updateDownloadedPercentage(space.downloading);
            });
        }
        ,methods:{
            getData() {
                let tb = this;
                tb.loading = true;
                $.ajax({
                    url: "/api/videos/all" ,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        // alert("Success");
                        tb.items = data;
                        tb.loading = false;
                    },
                    error: function() {
                        alert('Failed!');
                    },
                });
            },
            capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
            refreshLocalVideos() {
                var self = this;
                $.ajax({
                    url: "/api/Giantbomb/fetch" ,
                    type: 'GET',
                    // dataType: 'json',
                    success: function(data) {
                        self.getData();
                    },
                    error: function() {
                        alert('Failed fetching new videos!');
                    },
                });
            },
            returnThumbnail(video) {
                if(video.thumbnail_local_url == null) {
                    return video.thumbnail_url;
                }
                return video.thumbnail_local_url;
            },
            updateVideoStatus(event, video, state) {
                $.ajax({
                    url: "/api/video/" + video.id + "/updateStatus",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'state': state
                    },
                    success: function(data, textStatus, jqXHR) {
                        video.state = state;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Failed: " + textStatus);
                    }
                })
            },
            updateLocalVideoStatus(updatedVideo) {
                let tb = this;
                // console.log(updatedVideo);
                tb.items.forEach(function(video) {
                    if(video.id == updatedVideo.id) {
                        console.log("Video updated");
                        video.human_size = updatedVideo.human_size;
                        video.state = updatedVideo.state;
                    }
                });
            },
            downloadVideo(event, video) {
                alert("Download Video");
            },
            updateDownloadedPercentage(downloadingPercentage) {
                let tb = this;
                downloadingPercentage.forEach(function (downloadingVideo) {
                    console.log(downloadingVideo);
                    tb.items.forEach(function (video) {
                        if(video.id == downloadingVideo.id) {
                            video.downloaded_percentage = downloadingVideo.download_percentage;
                        }
                    })
                });
            }
        }
    }
</script>