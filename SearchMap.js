"use strict"

/*global view*/
var view = null;

function SearchMap() {
    var rider = {
        marker: null,
        position: {lat: 0, lng: 0},
        // Dark rider
        // icon: "https://i.imgur.com/Z8kt5nw.png"
        // Light rider
        icon: "https://i.imgur.com/VWIWNii.png",
        // Dark driver
        // icon: "https://i.imgur.com/BlCcQC8.png"
        // Light Driver
        // icon: "https://i.imgur.com/LgWloAM.png"
        searchRadius: null
    };

    var exampleDrivers = [
        {
            email: "michaeldavie182@gmail.com",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.864988, lng: -4.241522}
        },
        {
            email: "chrs@google.com",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.863028, lng: -4.246860}
        },
        {
            email: "John.Anderson@yahoo.com",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.8612451, lng: -4.246988}
        },
        {
            email: "Yip@yahoomshs.db",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.860716, lng: -4.249799}
        },
        {
            email: "nellzy2@gmail.com",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.860234, lng: -4.239542}
        },
        {
            email: "chrstph@yahoo.got",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.857031, lng: -4.246709}
        }
    ];

    var map,
        ticker;

    this.initRider = function () {
        this.setPosDevice(rider);
        view.addMarker(rider, 35, 35);
        this.refreshRadius();
    };

    this.init = function () {
        if (navigator.geolocation) {
            this.startMap();
            this.initRider();
            this.beginMapUpdater();
            document.getElementById("sliderVal").innerHTML = view.logSlider(document.getElementById("radiusSlider").value).toFixed(2).toString() + "m";
        } else {
            window.console.log("Geolocation is not supported by this browser.");
        }
        document.getElementById("searchButton").addEventListener('click', function () {
            var img = document.createElement("img");
            img.setAttribute("id", "loading");
            img.setAttribute("src", "https://www.hotelnumberfour.com/wp-content/uploads/2017/09/loading.gif")
            document.getElementById("searchDiv").appendChild(img);
            document.getElementById("searchDiv").removeChild(document.getElementById("searchButton"));
            view.getDrivers();
        });
    };

    this.getDrivers = function () {
        var load = this.loadDrivers;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "LoadLinks.php?email=michaeldavie182@gmail.com");
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    load(xmlhttp.responseText);
                    // window.console.log(xmlhttp.responseText);
                } else {
                    window.console.log("Error " + xmlhttp.status);
                }
            }
        };
        xmlhttp.send(null);
    };

    this.loadDrivers = function (json) {
        var emailArray = JSON.parse(json);
        // view.addMarker(exampleDrivers[0], 35, 20);
        // view.addMarker(exampleDrivers[1], 35, 20);
        // view.addMarker(exampleDrivers[2], 35, 20);
        // view.addMarker(exampleDrivers[3], 35, 20);
        // view.addMarker(exampleDrivers[4], 35, 20);
        // view.addMarker(exampleDrivers[5], 35, 20);
        for (var i = 0; i < emailArray.length; i++) {
            for (var j = 0; j < exampleDrivers.length; j++) {
                if (emailArray[i] === exampleDrivers[j].email) {
                    view.addMarker(exampleDrivers[j], 35, 20);
                }
            }
        }
        view.doneLoad();
    };

    this.doneLoad = function () {
        var button = document.createElement("button");
        button.setAttribute("id", "searchButton");
        button.innerHTML = "Find Co-Ride";
        document.getElementById("searchDiv").appendChild(button);
        document.getElementById("searchDiv").removeChild(document.getElementById("loading"));
        document.getElementById("searchButton").addEventListener('click', function () {
            var img = document.createElement("img");
            img.setAttribute("id", "loading");
            img.setAttribute("src", "https://www.hotelnumberfour.com/wp-content/uploads/2017/09/loading.gif")
            document.getElementById("searchDiv").appendChild(img);
            document.getElementById("searchDiv").removeChild(document.getElementById("searchButton"));
            view.getDrivers();
        });
    };

    this.beginMapUpdater = function () {
        ticker = setInterval(function () {
            // Remove rider from map
            rider.marker.setMap(null);
            // Update rider position
            view.setPosDevice(rider);

            // Dummy rider movement
            //rider.position.lat = rider.position.lat + 0.0001;
            //rider.position.lng = rider.position.lng + 0.0001;
            // Add the new rider marker to the map
            view.addMarker(rider, 35, 35);
            // Refresh the search radius to center the rider
            view.refreshRadius();
        }, 500);
        document.getElementById("radiusSlider").onchange = function () {
            document.getElementById("sliderVal").innerHTML = view.logSlider(document.getElementById("radiusSlider").value).toFixed(2).toString() + "m";
            view.refreshRadius();
        };
    };

    this.logSlider = function (value) {
        // Position on scale will be between 0 and 100
        var minp = 0;
        var maxp = 100;

        // The result should be between 500 an 5000
        var minv = Math.log(500);
        var maxv = Math.log(5000);

        // Adjustment factor
        var scale = (maxv - minv) / (maxp - minp);

        return Math.exp(minv + scale * (value - minp));

    };

    this.refreshRadius = function () {
        if (rider.searchRadius === null) {
            rider.searchRadius = new google.maps.Circle({
                map: map,
                radius: 1000,
                fillColor: '#4ca7aa',
                strokeWeight: 1
            });
            rider.searchRadius.bindTo('center', rider.marker, 'position');
        } else {
            rider.searchRadius.setMap(null);
            rider.searchRadius = new google.maps.Circle({
                map: map,
                radius: this.logSlider(parseInt(document.getElementById("radiusSlider").value)),
                fillColor: '#4ca7aa',
                strokeWeight: 1
            });
            rider.searchRadius.bindTo('center', rider.marker, 'position');
        }

    };

    this.addMarker = function (marker, size1, size2) {
        marker.marker = new google.maps.Marker({
            position: {lat: marker.position.lat, lng: marker.position.lng},
            map: map,
            icon: {url: marker.icon, scaledSize: new google.maps.Size(size1, size2)}
        });
    };

    this.setPosDevice = function (marker) {
        navigator.geolocation.getCurrentPosition(function (position) {
            marker.position.lat = position.coords.latitude;
            marker.position.lng = position.coords.longitude;
        });
    };

    // Blank map centered around the device location
    this.startMap = function () {
        navigator.geolocation.getCurrentPosition(function (position) {
            map = new google.maps.Map(document.getElementById("map_container"), {
                center: {lat: position.coords.latitude, lng: position.coords.longitude},
                zoom: 14,
                mapTypeControl: false,
                streetViewControl: false,
                styles: [
                    {
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#8ec3b9"
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1a3646"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.country",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#4b6878"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#64779e"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.province",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#4b6878"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.man_made",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#334e87"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.natural",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#023e58"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#283d6a"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#6f9ba5"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#023e58"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#3C7680"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#304a7d"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#98a5be"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#2c6675"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#255763"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#b0d5ce"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#023e58"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#98a5be"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "color": "#1d2c4d"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.line",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#283d6a"
                            }
                        ]
                    },
                    {
                        "featureType": "transit.station",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#3a4762"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#0e1626"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#4e6d70"
                            }
                        ]
                    }
                ]
            });
        });
    };
}

view = new SearchMap();
window.addEventListener('load',
    function (ev) {
        view.init();
    });