"use strict"

/*global view*/
var view = null;

function SearchMap() {
    var contentString = '<div id="testProfile">' +
        '<div id="profilePicTest">' +
        '<img id="profilePicTestPic" src="img/woman.jpeg"/>' +
        '</div>' +
        '<div id="profileInfoTest">' +
        '<span id="nameTest"></span>' +
        '<div class="ratings" id="rating1">' +
        '<span class= "ratingText" id="rating1text">Personality</span>' +
        '</div>' +
        '<div>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '</div>' +
        '<div class="ratings" id="rating2">' +
        '<span class= "ratingText" id="rating2text">Driving Ability</span>' +
        '</div>' +
        '<div>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '</div>' +
        '<div class="ratings" id="rating3">' +
        '<span class= "ratingText" id="rating3text">Cleanliness</span>' +
        '</div>' +
        '<div>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '<img class="ratingPic" src="img/star.png"/>' +
        '</div>' +
        '</div>' +
        '</div>';

    var infowindow = null;

    var userRider = {
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

    var userDriver = {
        marker: null,
        position: {lat: 0, lng: 0},
        // Dark rider
        // icon: "https://i.imgur.com/Z8kt5nw.png"
        // Light rider
        // icon: "https://i.imgur.com/VWIWNii.png",
        // Dark driver
        // icon: "https://i.imgur.com/BlCcQC8.png"
        // Light Driver
        icon: "https://i.imgur.com/LgWloAM.png"
    };

    var driver = null;

    var last = false;

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
            position: {lat: 55.852034, lng: -4.239542}
        },
        {
            email: "chrstph@yahoo.got",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.857031, lng: -4.246709}
        },
        {
            email: "cm@yahoo.com",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.858031, lng: -4.246609}
        },
        {
            email: "holyeee@hotmail.com",
            marker: null,
            icon: "https://i.imgur.com/LgWloAM.png",
            position: {lat: 55.856031, lng: -4.246609}
        }
    ];

    var loadedDrivers = [];

    var map,
        ticker;

    this.initRider = function () {
        this.setPosDevice(userRider);
        view.addMarker(userRider, 35, 35, false);
        this.refreshRadius();
        this.editUserType("Rider");
    };

    this.initDriver = function () {
        this.setPosDevice(userDriver);
        view.addMarker(userDriver, 35, 20, false);
        this.postRide(from, to, tod);
        this.editUserType("Driver");
    };

    this.editUserType = function (type) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "EditUserType.php?type="+type);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    var response = xmlhttp.responseText;
                    window.console.log(response);
                    // if (view.testRoute(response, index, email)) {
                    //     continueAdding(response[0], index, email);
                    // }
                    // view.testRoute(response, index, email);
                } else {
                    window.console.log("Error " + xmlhttp.status);
                }
            }
        };
        xmlhttp.send(null);
    };

    this.init = function () {
        window.console.log("type: " + type);
        if (type === "rider") {
            if (navigator.geolocation) {
                this.startMap();
                this.initRider();
                this.beginMapUpdaterRider();
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
            // infowindow = new google.maps.InfoWindow({
            //     content: contentString,
            //     maxWidth: 150
            // });
            driver = null;
            loadedDrivers = [];
        } else if (type == "driver") {
            if (navigator.geolocation) {
                this.startMap();
                this.initDriver();
                this.beginMapUpdaterDriver();
                document.getElementById("nonNav").removeChild(document.getElementById("sliderVal"));
                document.getElementById("nonNav").removeChild(document.getElementById("radiusSliderDiv"));
                document.getElementById("nonNav").removeChild(document.getElementById("searchDiv"));
            } else {
                window.console.log("Geolocation is not supported by this browser.");
            }
        }

    };

    this.postRide = function (origin, dest, time) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "PostRide.php?from="+origin+"&to="+dest+"&tod="+time);
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    var response = xmlhttp.responseText;
                    window.console.log(response);
                    // if (view.testRoute(response, index, email)) {
                    //     continueAdding(response[0], index, email);
                    // }
                    // view.testRoute(response, index, email);
                } else {
                    window.console.log("Error " + xmlhttp.status);
                }
            }
        };
        xmlhttp.send(null);
    };

    // this.getUserEmail = function () {
    //     var xmlhttp = new XMLHttpRequest();
    //     xmlhttp.open("GET", "utilities.php?action=getEmail");
    //     xmlhttp.onreadystatechange = function () {
    //         if (xmlhttp.readyState === 4) {
    //             if (xmlhttp.status === 200) {
    //                 return JSON.parse(xmlhttp.responseText).email;
    //             } else {
    //                 return null;
    //             }
    //         }
    //     };
    //     xmlhttp.send(null);
    // };

    this.getDrivers = function () {
        var load = this.loadDrivers;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "LoadLinks.php");
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    load(xmlhttp.responseText);
                    window.console.log(xmlhttp.responseText);
                } else {
                    window.console.log("Error " + xmlhttp.status);
                }
            }
        };
        xmlhttp.send(null);
    };

    this.loadDrivers = function (json) {
        // window.console.log(json);
        var emailArray = JSON.parse(json);
        // window.console.log("LOGGED IN AS: " + emailArray[emailArray.length-1]);
        // view.addMarker(exampleDrivers[0], 35, 20, true);
        // view.addMarker(exampleDrivers[1], 35, 20, true);
        // view.addMarker(exampleDrivers[2], 35, 20, true);
        // view.addMarker(exampleDrivers[3], 35, 20, true);
        // view.addMarker(exampleDrivers[4], 35, 20, true);
        // view.addMarker(exampleDrivers[5], 35, 20, true);
        for (var i = 0; i < emailArray.length; i++) {
            // for (var j = 0; j < exampleDrivers.length; j++) {
            //     if (emailArray[i] === exampleDrivers[j].email) {
            //         if (view.checkDriverLoc(exampleDrivers[j])) {
            //             view.addMarker(exampleDrivers[j], 35, 20, true);
            //         }
            //     }
            // }
            // Get the driver's route info, index 0: source pos, index 1: destination pos, index 2: time of departure, index 3: current plat, index 4: current lng
            view.addDriver(emailArray[i], i, emailArray.length);
            //view.addrToLatLng(pos[0], i, emailArray[i]);
            // loadedDrivers[i] = {
            //     email: emailArray[i],
            //     marker: null,
            //     icon: "https://i.imgur.com/LgWloAM.png",
            //     position: view.addrToLatLng(pos[0])};
        }
    };

    this.addrToLatLng = function (route, index, email, doneLim) {
        var pos = null;
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': route[0]}, function (results, status) {
            window.console.log(route[5] + "'s geocode results : " + results[0].geometry.location);
            if (status === 'OK') {
                window.console.log('Geocode was successful');
                if (view.checkLoc({
                    position: {
                        lat: results[0].geometry.location.lat(),
                        lng: results[0].geometry.location.lng()
                    }
                })) {
                    window.console.log("Origin is ok.");
                    loadedDrivers[index] = {
                        email: email,
                        marker: null,
                        icon: "https://i.imgur.com/LgWloAM.png",
                        position: {lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng()},
                        route: route
                    };
                    if (index === doneLim - 1) {
                        view.doneLoad();
                    }
                    //  view.addMarker(loadedDrivers[index], 35, 20, true);
                } else {
                    geocoder.geocode({'address': route[1]}, function (results2, status2) {
                        if (status2 == 'OK') {
                            window.console.log('Geocode was successful again');
                            if (view.checkLoc({
                                position: {
                                    lat: results2[0].geometry.location.lat(),
                                    lng: results2[0].geometry.location.lng()
                                }
                            })) {
                                window.console.log("Destination is ok.");
                                loadedDrivers[index] = {
                                    email: email,
                                    marker: null,
                                    icon: "https://i.imgur.com/LgWloAM.png",
                                    position: {
                                        lat: results[0].geometry.location.lat(),
                                        lng: results[0].geometry.location.lng()
                                    },
                                    route: route
                                };
                                if (index === doneLim - 1) {
                                    view.doneLoad();
                                }
                                //view.addMarker(loadedDrivers[index], 35, 20, true);
                            } else {
                                if (index === doneLim - 1) {
                                    view.doneLoad();
                                }
                            }
                        } else {
                            if (index === doneLim - 1) {
                                view.doneLoad();
                            }
                            window.console.log('Geocode 2 was not successful for the following reason: ' + status2);
                        }
                    });
                }
            } else {
                if (index === doneLim - 1) {
                    view.doneLoad();
                }
                window.console.log('Geocode was not successful for the following reason: ' + status);
            }
        });
        return pos;
    };

    this.addDriver = function (email, index, doneLim) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "GetDriverRoute.php?email=".concat(email));
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    var response = xmlhttp.responseText;
                    window.console.log(response);
                    if (response !== null && response !== undefined && response !== "") {
                        view.addrToLatLng(JSON.parse(response), index, email, doneLim);
                    }
                    // if (view.testRoute(response, index, email)) {
                    //     continueAdding(response[0], index, email);
                    // }
                    // view.testRoute(response, index, email);
                } else {
                    window.console.log("Error " + xmlhttp.status);
                }
            }
        };
        xmlhttp.send(null);
    };

    this.testRoute = function (route, index, email) {


        // DISPLAYS THE PATH THE ROUTE REPRESENTS ON MAP GOOD CODE NO DELETE

        // var directionsService = new google.maps.DirectionsService();
        // var directionsDisplay = new google.maps.DirectionsRenderer({markerOptions: {label: {color: "white", text: route[5]+" "+route[6]}}});
        // directionsDisplay.setMap(map);
        // var path = {
        //     origin: route[0],
        //     destination: route[1],
        //     travelMode: 'DRIVING'
        // };
        // directionsService.route(path, function (result, status) {
        //     window.console.log("Direction status: " + status);
        //     if (status == 'OK') {
        //         directionsDisplay.setDirections(result);
        //     }
        // });
    };

    this.checkLoc = function (loc) {
        var ky = 40000 / 360;
        var kx = Math.cos(Math.PI * userRider.position.lat / 180.0) * ky;
        var dx = Math.abs(userRider.position.lng - loc.position.lng) * kx;
        var dy = Math.abs(userRider.position.lat - loc.position.lat) * ky;
        return Math.sqrt(dx * dx + dy * dy) <= userRider.searchRadius.radius / 1000;
    };

    this.doneLoad = function () {
        window.console.log("WE ARE IN LOAD");
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

        var options = document.createElement("div");
        options.setAttribute("id", "driverList");
        document.getElementById("map_home").appendChild(options);

        var driveCount = 0;
        for (var i = 0; i < loadedDrivers.length; i++) {
            if (loadedDrivers[i] !== null && loadedDrivers[i] !== undefined) {
                var driverDiv = document.createElement("div");
                driverDiv.setAttribute("class", "driverDiv");
                document.getElementById("driverList").appendChild(driverDiv);
                window.console.log(loadedDrivers[i]);
                view.addBugFixListener(driverDiv, loadedDrivers[i]);
                var name = document.createElement("span");
                name.setAttribute("class", "driverName");
                name.innerHTML = loadedDrivers[i].route[5] + " " + loadedDrivers[i].route[6];
                driverDiv.appendChild(name);
                var imgDiv = document.createElement("div");
                imgDiv.setAttribute("class", "driverPicDiv");
                driverDiv.appendChild(imgDiv);
                var img = document.createElement("img");
                img.setAttribute("id", "driverPic" + driveCount);
                img.setAttribute("class", "driverPic");
                img.setAttribute("src", "img/woman.jpeg");
                imgDiv.appendChild(img);
                var ratingsDiv = document.createElement("div");
                ratingsDiv.setAttribute("class", "ratingsDiv");
                driverDiv.appendChild(ratingsDiv);

                var ratingsDiv1 = document.createElement("div");
                ratingsDiv1.setAttribute("class", "ratingsDivInner");
                ratingsDiv.appendChild(ratingsDiv1);

                var ratingsDiv1text = document.createElement("div");
                ratingsDiv1text.setAttribute("class", "ratingsDivInner");
                ratingsDiv1text.innerHTML = "Personality";
                ratingsDiv.appendChild(ratingsDiv1text);

                var ratingsDiv2 = document.createElement("div");
                ratingsDiv2.setAttribute("class", "ratingsDivInner");
                ratingsDiv.appendChild(ratingsDiv2);

                var ratingsDiv2text = document.createElement("div");
                ratingsDiv2text.setAttribute("class", "ratingsDivInner");
                ratingsDiv2text.innerHTML = "Driving Ability";
                ratingsDiv.appendChild(ratingsDiv2text);

                var ratingsDiv3 = document.createElement("div");
                ratingsDiv3.setAttribute("class", "ratingsDivInner");
                ratingsDiv.appendChild(ratingsDiv3);

                var ratingsDiv3text = document.createElement("div");
                ratingsDiv3text.setAttribute("class", "ratingsDivInner");
                ratingsDiv3text.innerHTML = "Cleanliness";
                ratingsDiv.appendChild(ratingsDiv3text);

                for (var j = 0; j < 5; j++) {
                    var picDiv = document.createElement("div");
                    picDiv.setAttribute("class", "ratingPicDiv");
                    ratingsDiv1.appendChild(picDiv);
                    var star1 = document.createElement("img");
                    star1.setAttribute("class", "ratingPic");
                    star1.setAttribute("src", "img/star.png");
                    picDiv.appendChild(star1);
                }
                for (var k = 0; k < 5; k++) {
                    var picDiv2 = document.createElement("div");
                    picDiv2.setAttribute("class", "ratingPicDiv");
                    ratingsDiv2.appendChild(picDiv2);
                    var star2 = document.createElement("img");
                    star2.setAttribute("class", "ratingPic");
                    star2.setAttribute("src", "img/star.png");
                    picDiv2.appendChild(star2);
                }
                for (var l = 0; l < 5; l++) {
                    var picDiv3 = document.createElement("div");
                    picDiv3.setAttribute("class", "ratingPicDiv");
                    ratingsDiv3.appendChild(picDiv3);
                    var star3 = document.createElement("img");
                    star3.setAttribute("class", "ratingPic");
                    star3.setAttribute("src", "img/star.png");
                    picDiv3.appendChild(star3);
                }
                driveCount++;
            }
        }
    };

    this.addBugFixListener = function (thing, info) {
        window.console.log(info);
        thing.addEventListener('click', function () {
            view.beginJourney(info);
        });
    };

    this.beginJourney = function (user) {
        window.console.log(user);
        document.getElementById("map_home").removeChild(document.getElementById("driverList"));
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer({
            preserveViewport: true,
            markerOptions: {label: {color: "white", text: user.route[5] + " " + user.route[6]}}
        });
        directionsDisplay.setMap(map);
        var path = {
            origin: user.route[0],
            destination: user.route[1],
            travelMode: 'DRIVING'
        };
        directionsService.route(path, function (result, status) {
            window.console.log("Direction status: " + status);
            if (status == 'OK') {
                directionsDisplay.setDirections(result);
            }
        });
        window.console.log("driver set to " + user);
        driver = user;
        view.addMarker(driver, 35, 20, true);
        document.getElementById("searchDiv").removeChild(document.getElementById("searchButton"));
        var button = document.createElement("button");
        button.setAttribute("id", "searchButton");
        button.innerHTML = "End Co-Ride";
        document.getElementById("searchDiv").appendChild(button);
        button.addEventListener('click', function () {
            document.getElementById("searchDiv").removeChild(document.getElementById("searchButton"));
            var button2 = document.createElement("button");
            button2.setAttribute("id", "searchButton");
            button2.innerHTML = "Find Co-Ride";
            document.getElementById("searchDiv").appendChild(button2);
            // document.getElementById("searchButton").addEventListener('click', function () {
            //     var img = document.createElement("img");
            //     img.setAttribute("id", "loading");
            //     img.setAttribute("src", "https://www.hotelnumberfour.com/wp-content/uploads/2017/09/loading.gif")
            //     document.getElementById("searchDiv").appendChild(img);
            //     document.getElementById("searchDiv").removeChild(document.getElementById("searchButton"));
            //     view.getDrivers();
            // });
            view.review();
            window.console.log("driver set to null");
            view.init();
        });
    };

    this.review = function () {
        // TODO add Michael's review
    };

    this.beginMapUpdaterRider = function () {
        ticker = setInterval(function () {
            // Remove rider from map
            userRider.marker.setMap(null);
            // Update rider position
            view.setPosDevice(userRider);

            // Dummy rider movement
            //rider.position.lat = rider.position.lat + 0.0001;
            //rider.position.lng = rider.position.lng + 0.0001;
            // Add the new rider marker to the map
            view.addMarker(userRider, 35, 35, false);
            // Refresh the search radius to center the rider
            view.refreshRadius();

            if (driver !== null && driver !== undefined) {
                view.updateDriverPos();
            }
        }, 500);
        document.getElementById("radiusSlider").onchange = function () {
            document.getElementById("sliderVal").innerHTML = view.logSlider(document.getElementById("radiusSlider").value).toFixed(2).toString() + "m";
            view.refreshRadius();
        };
    };

    this.beginMapUpdaterDriver = function () {
        ticker = setInterval(function () {
            // Remove rider from map
            userDriver.marker.setMap(null);
            // Update rider position
            view.setPosDevice(userDriver);

            // Dummy rider movement
            //rider.position.lat = rider.position.lat + 0.0001;
            //rider.position.lng = rider.position.lng + 0.0001;
            // Add the new rider marker to the map
            view.addMarker(userDriver, 35, 20, false);
            // Refresh the search radius to center the rider

            // if (driver !== null && driver !== undefined) {
            //     view.updateDriverPos();
            // }
        }, 500);
        // document.getElementById("radiusSlider").onchange = function () {
        //     document.getElementById("sliderVal").innerHTML = view.logSlider(document.getElementById("radiusSlider").value).toFixed(2).toString() + "m";
        //     view.refreshRadius();
        // };
    };

    this.updateDriverPos = function () {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "GetDriverRoute.php?email=".concat(driver.email));
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4) {
                if (xmlhttp.status === 200) {
                    var response = JSON.parse(xmlhttp.responseText);
                    window.console.log(response);
                    // if (view.testRoute(response, index, email)) {
                    //     continueAdding(response[0], index, email);
                    // }
                    view.continueUpdateDriverPos(response);
                    // view.testRoute(response, index, email);
                } else {
                    window.console.log("Error " + xmlhttp.status);
                }
            }
        };
        xmlhttp.send(null);
    };

    this.continueUpdateDriverPos = function (response) {
        window.console.log(response);
        window.console.log(driver);
        driver.marker.setMap(null);
        // driver.route = response;
        // var tempLoc = new google.maps.LatLng({lat: parseFloat(response[3]).toFixed(4), lng: parseFloat(response[4]).toFixed(4)});
        driver.route[3] = parseFloat(response[3]);
        driver.route[4] = parseFloat(response[4]);
        driver.position = {lat: driver.route[3], lng: driver.route[4]};
        view.addMarker(driver, 35, 20, true);
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
        if (userRider.searchRadius === null) {
            userRider.searchRadius = new google.maps.Circle({
                map: map,
                radius: 1000,
                fillColor: '#4ca7aa',
                strokeWeight: 1
            });
            userRider.searchRadius.bindTo('center', userRider.marker, 'position');
        } else {
            userRider.searchRadius.setMap(null);
            userRider.searchRadius = new google.maps.Circle({
                map: map,
                radius: this.logSlider(parseInt(document.getElementById("radiusSlider").value)),
                fillColor: '#4ca7aa',
                strokeWeight: 1
            });
            userRider.searchRadius.bindTo('center', userRider.marker, 'position');
        }

    };

    this.addMarker = function (marker, size1, size2, isDriver) {
        marker.marker = new google.maps.Marker({
            position: {lat: marker.position.lat, lng: marker.position.lng},
            map: map,
            icon: {url: marker.icon, scaledSize: new google.maps.Size(size1, size2)}
        });
        // if (isDriver) {
        //     marker.marker.addListener('click', function () {
        //         // var profile = document.createElement("img");
        //         // img.setAttribute("id", "loading");
        //         // img.setAttribute("src", "https://www.hotelnumberfour.com/wp-content/uploads/2017/09/loading.gif")
        //         // document.getElementById("searchDiv").appendChild(img);
        //         // document.getElementById("searchDiv").removeChild(document.getElementById("searchButton"));
        //         // view.getDrivers();
        //         infowindow.open(map, marker.marker);
        //     });
        // }
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