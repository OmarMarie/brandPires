<style>
    .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
        top: -6px !important;
        z-index: 100000 !important;
    }

    .modal {
        z-index: 550 !important;
    }

    .modal-backdrop {
        z-index: 10;
    }

    ​
    #pac-input:focus {
        border-color: #4d90fe;
    }

    #map-canvas {
        height: 350px;
        margin: 20px;
        width: 900px;
        padding: 0px;
        margin-bottom: 0px;
    }

</style>
@if(isset($campaign))
    <form action="{{ route('campaigns.update', [app()->getLocale(),$campaign]) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('campaigns.store', app()->getLocale()) }}" method="POST" id="userForm">
                @endif
                @csrf
                @if(!isset($campaign))
                    <input type="hidden" name="brand_id"  value="{{ $brand_id }}">
                    @endif
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                               @if(isset($campaign)) value="{{ $campaign->name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mark Pts</label>
                        <input type="text" class="form-control" name="mark_pts"
                               placeholder="Mark Pts"
                               @if(isset($campaign)) value="{{ $campaign->mark_pts }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Gifts Numbers</label>
                        <input type="text" class="form-control" name="gifts_numbers"
                               placeholder="Total Gifts Number"
                               @if(isset($campaign)) value="{{ $campaign->gifts_numbers}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Speed</label>
                        <input type="text" class="form-control" name="speed"
                               placeholder="Speed"
                               @if(isset($campaign)) value="{{ $campaign->speed}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="date">Date</label>
                        <input name="date" id="datepicker" class="date-picker form-control" placeholder="Date"  autocomplete="off"
                               @if(isset($campaign)) value="{{ date("d-m-yy", strtotime($campaign->date))}}" @endif/>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>From Time</label>
                        <input type="text" id="timepicker" class="time-picker form-control" name="from_time"
                               placeholder="From Time" autocomplete="off"
                               @if(isset($campaign)) value="{{ $campaign->from_time}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>To Time</label>
                        <input type="text" id="timepicker2" class="time-picker form-control" name="to_time"
                               placeholder="To Time" autocomplete="off"
                               @if(isset($campaign)) value="{{ $campaign->to_time}}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Employee</label>
                        <select name="employee_id" class="form-control">
                            @if(!isset($campaign))
                                <option value="" selected disabled>Select Employee</option>
                            @endif
                            @foreach($employees  as $employee)
                                <option @if(isset($campaign) && $employee->id == $campaign->employee_id) value="{{ $employee->id }}"
                                        selected
                                        @else value="{{ $employee->id }}" @endif>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Bulk</label>
                        <select name="bulk_id" class="form-control">
                            @if(!isset($campaign))
                                <option value="" selected disabled>Select Bulk</option>
                            @endif
                            @foreach($bulks  as $bulk)
                                <option @if(isset($campaign) && $bulk->id == $campaign->bulk_id) value="{{ $bulk->id }}"
                                        selected
                                        @else value="{{ $bulk->id }}" @endif>{{ $bulk->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Available</label>
                        <select name="available" class="form-control">
                            <option value="0" @if(isset($campaign) && $campaign->available == 0) selected @endif>False
                            </option>
                            <option value="1" @if(isset($campaign) && $campaign->available == 1) selected @endif>True</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Location</label>
                        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                        <div id="map-canvas"></div>
                        <input type="hidden" name="lat" id="lat"
                               value="{{ isset($campaign) ? $campaign->lat : 24.079352 }}"
                               readonly="yes">
                        <input type="hidden" name="lng" id="lng"
                               value="{{ isset($campaign) ? $campaign->lng : 48.0031405 }}"
                               readonly="yes">
                    </div>
                    <div class="col-md-6 form-group"></div>
                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-success" style="float: right">
                    </div>
                </div>
            </form>

            <script type="text/javascript">

                $(function () {
                    $("#timepicker").timepicker();
                    $("#timepicker2").timepicker();
                });

                $("#datepicker").datepicker({
                    format: "dd-mm-yyyy",
                });


                // google maps
                var map;
                var marker = false;
                var lat;
                var lng;
                initialize();

                function initialize() {
                    if ($("#map-canvas").length != 0) {
                        @if(isset($campaign))
                            lat = parseFloat(document.getElementById('lat').value);
                        lng = parseFloat(document.getElementById('lng').value);

                        var myLocationEdit = {
                            lat: lat,
                            lng: lng
                        };
                        map = new google.maps.Map(document.getElementById('map-canvas'), {
                            center: myLocationEdit,
                            zoom: 10    ,
                            mapTypeId: 'roadmap'
                        });
                        marker = new google.maps.Marker({
                            position: myLocationEdit,
                            map: map,
                            draggable: true
                        });
                                @else
                        var markers = [];
                        map = new google.maps.Map(document.getElementById('map-canvas'), {
                            center: {lat: 24.079352, lng: 48.0031405},
                            zoom: 5
                        });
                                @endif
                        var input = /** @type {HTMLInputElement} */(
                                document.getElementById('pac-input'));
                        new google.maps.places.Autocomplete(input);
                        google.maps.event.addDomListener(window, 'load', initialize);

                        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                        var searchBox = new google.maps.places.SearchBox((input));

                        google.maps.event.addListener(searchBox, 'places_changed', function () {
                            var places = searchBox.getPlaces();
                            if (places.length == 0) {
                                return;
                            }
                            markers = [];
                            var mLatLng;
                            var bounds = new google.maps.LatLngBounds();
                            for (var i = 0, place; place = places[i]; i++) {
                                if (marker === false) {
                                    marker = new google.maps.Marker({
                                        position: place.geometry.location,
                                        map: map,
                                    });
                                    google.maps.event.addListener(marker, 'dragend', function () {
                                        markerLocation();
                                    });
                                } else {
                                    marker.setPosition(place.geometry.location);
                                }
                                mLatLng = place.geometry.location;
                            }
                            document.getElementById('lat').value = mLatLng.lat(); //latitude
                            document.getElementById('lng').value = mLatLng.lng();
                            map.setCenter(mLatLng);
                            map.setZoom(18);
                        });
                        google.maps.event.addListener(map, 'click', function (event) {

                            var clickedLocation = event.latLng;
                            if (marker === false) {
                                marker = new google.maps.Marker({
                                    position: clickedLocation,
                                    map: map,
                                });
                                google.maps.event.addListener(marker, 'dragend', function () {
                                    markerLocation();
                                });
                            } else {
                                marker.setPosition(clickedLocation);
                            }
                            markerLocation();
                        });
                    }
                }

                function markerLocation() {
                    var currentLocation = marker.getPosition();
                    document.getElementById('lat').value = currentLocation.lat(); //latitude
                    document.getElementById('lng').value = currentLocation.lng(); //longitude
                }
            </script>