
var addresses = [];

var forename;
var surname;
var mobileNumber;
var bio;
var email;

var password;

var address_id;
var address_name;
var address_line_1;
var address_line_2;
var town;
var country;
var postcode;

    $("#editInfo").on("submit", function (event) {
        event.preventDefault();
        if (validateUpdateInfoData()) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById("forename_change").value = forename;
                    document.getElementById("surname_change").value = surname;
                    document.getElementById("mobile_number_change").value = mobileNumber;
                    document.getElementById("bio_change").value = bio;
                    document.getElementById("user_email2").value = email;
                }
            };
            xhttp.open("POST", "Edit2.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=updateInformation&forename_change=" + forename + "&surname_change=" + surname + "& mobile_number_change=" + mobileNumber + "&bio_change=" + bio + "&user_email=" + email);

        }
    });

    $("#editPassword").on("submit", function (event) {
        event.preventDefault();
        if (validateChangePasswordData()) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("edit_password").value = "";
                    document.getElementById("edit_password_verify").value = "";
                }
            };
            xhttp.open("POST", "Edit2.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=updatePassword&edit_password=" + password + "&user_email=" + email);
        }
    });

    $("#editAddress").on("submit", function (event) {
        event.preventDefault();
        if (validateEditAddressData()) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("address_name_input").value = address_name;
                    document.getElementById("address_line1_input").value = address_line_1;
                    document.getElementById("address_line2_input").value = address_line_2;
                    document.getElementById("town_input").value = town;
                    document.getElementById("country_input").value = country;
                    document.getElementById("postcode_input").value = postcode;
                    document.getElementById("address_id").value = address_id;
                }
            };
            xhttp.open("POST", "Edit2.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=updateAddress&address_id=" + address_id + "&address_name_input=" + address_name + "& address_line1_input=" + address_line_1 + "&address_line2_input=" + address_line_2 + "&town_input=" + town + "&country_input=" + country + "&postcode_input=" + postcode);
        }
    });

    var address_0_button = document.getElementById("address0");
    if (address_0_button != null) {
        address_0_button.onclick = function () {
            var passView = document.getElementById("editAddress");
            if (passView.style.display !== "block") {
                passView.style.display = "block";

                var address_name_input = document.getElementById("address_name_input");
                var address_line1_input = document.getElementById("address_line1_input");
                var address_line2_input = document.getElementById("address_line2_input");
                var town_input = document.getElementById("town_input");
                var country_input = document.getElementById("country_input");
                var postcode_input = document.getElementById("postcode_input");
                var address_id = document.getElementById("address_id");
                var address_id_delete = document.getElementById("address_id_delete");

                address_id.value = addresses[0]["address_id"];
                address_name_input.value = addresses[0]["address_name"];
                address_line1_input.value = addresses[0]["address_line_1"];
                address_line2_input.value = addresses[0]["address_line_2"];
                town_input.value = addresses[0]["town"];
                country_input.value = addresses[0]["country"];
                postcode_input.value = addresses[0]["postcode"];
                address_id_delete.value = addresses[0]["address_id"];

            }
        }
    }

    var address_1_button = document.getElementById("address1");
    if (address_1_button != null) {
        address_1_button.onclick = function () {
            var passView = document.getElementById("editAddress");
            if (passView.style.display !== "block") {
                passView.style.display = "block";

                var address_name_input = document.getElementById("address_name_input");
                var address_line1_input = document.getElementById("address_line1_input");
                var address_line2_input = document.getElementById("address_line2_input");
                var town_input = document.getElementById("town_input");
                var country_input = document.getElementById("country_input");
                var postcode_input = document.getElementById("postcode_input");
                var address_id = document.getElementById("address_id");
                var address_id_delete = document.getElementById("address_id_delete");

                address_id.value = addresses[1]["address_id"];
                address_name_input.value = addresses[1]["address_name"];
                address_line1_input.value = addresses[1]["address_line_1"];
                address_line2_input.value = addresses[1]["address_line_2"];
                town_input.value = addresses[1]["town"];
                country_input.value = addresses[1]["country"];
                postcode_input.value = addresses[1]["postcode"];
                address_id_delete.value = addresses[1]["address_id"];


            }
        }
    }

    var address_2_button = document.getElementById("address2");
    if (address_2_button != null) {
        address_2_button.onclick = function () {
            var passView = document.getElementById("editAddress");
            if (passView.style.display !== "block") {
                passView.style.display = "block";

                var address_name_input = document.getElementById("address_name_input");
                var address_line1_input = document.getElementById("address_line1_input");
                var address_line2_input = document.getElementById("address_line2_input");
                var town_input = document.getElementById("town_input");
                var country_input = document.getElementById("country_input");
                var postcode_input = document.getElementById("postcode_input");
                var address_id = document.getElementById("address_id");
                var address_id_delete = document.getElementById("address_id_delete");

                address_id.value = addresses[2]["address_id"];
                address_name_input.value = addresses[2]["address_name"];
                address_line1_input.value = addresses[2]["address_line_1"];
                address_line2_input.value = addresses[2]["address_line_2"];
                town_input.value = addresses[2]["town"];
                country_input.value = addresses[2]["country"];
                postcode_input.value = addresses[2]["postcode"];
                address_id_delete.value = addresses[2]["address_id"];

            }
        }
    }

    var address_3_button = document.getElementById("address3");
    if (address_3_button != null) {
        address_3_button.onclick = function () {
            var passView = document.getElementById("editAddress");
            if (passView.style.display !== "block") {
                passView.style.display = "block";

                var address_name_input = document.getElementById("address_name_input");
                var address_line1_input = document.getElementById("address_line1_input");
                var address_line2_input = document.getElementById("address_line2_input");
                var town_input = document.getElementById("town_input");
                var country_input = document.getElementById("country_input");
                var postcode_input = document.getElementById("postcode_input");
                var address_id = document.getElementById("address_id");
                var address_id_delete = document.getElementById("address_id_delete");

                address_id.value = addresses[3]["address_id"];
                address_name_input.value = addresses[3]["address_name"];
                address_line1_input.value = addresses[3]["address_line_1"];
                address_line2_input.value = addresses[3]["address_line_2"];
                town_input.value = addresses[3]["town"];
                country_input.value = addresses[3]["country"];
                postcode_input.value = addresses[3]["postcode"];
                address_id_delete.value = addresses[3]["address_id"];

            }
        }
    }

    var address_4_button = document.getElementById("address4");
    if (address_4_button != null) {
        address_4_button.onclick = function () {
            var passView = document.getElementById("editAddress");
            if (passView.style.display !== "block") {
                passView.style.display = "block";

                var address_name_input = document.getElementById("address_name_input");
                var address_line1_input = document.getElementById("address_line1_input");
                var address_line2_input = document.getElementById("address_line2_input");
                var town_input = document.getElementById("town_input");
                var country_input = document.getElementById("country_input");
                var postcode_input = document.getElementById("postcode_input");
                var address_id = document.getElementById("address_id");
                var address_id_delete = document.getElementById("address_id_delete");

                address_id.value = addresses[4]["address_id"];
                address_name_input.value = addresses[4]["address_name"];
                address_line1_input.value = addresses[4]["address_line_1"];
                address_line2_input.value = addresses[4]["address_line_2"];
                town_input.value = addresses[4]["town"];
                country_input.value = addresses[4]["country"];
                postcode_input.value = addresses[4]["postcode"];
                address_id_delete.value = addresses[4]["address_id"];

            }
        }
    }

    var profile_pic_1_button = document.getElementById("profile_image_1");
    profile_pic_1_button.onclick = function () {

    };

    var addressAddbutton = document.getElementById("addressAdd");
    if (addressAddbutton != null) {
        addressAddbutton.onclick = function () {
            var passView = document.getElementById("editAddress");
            if (passView.style.display !== "block") {
                passView.style.display = "block";
            }
        }
    }

    var passwordInput = document.getElementById("edit_password");
    passwordInput.onclick = function () {
        passwordInput.style.backgroundColor = "white";
    };

    var passwordV = document.getElementById("edit_password_verify");
    passwordV.onclick = function () {
        passwordV.style.backgroundColor = "white";
    };

    var forenameChange = document.getElementById("forename_change");
    forenameChange.onclick = function () {
        forenameChange.style.backgroundColor = "white";
    };

    var surnameChange = document.getElementById("surname_change");
    surnameChange.onclick = function () {
        surnameChange.style.backgroundColor = "white";
    };

    var mobileNumberChange = document.getElementById("mobile_number_change");
    mobileNumberChange.onclick = function () {
        mobileNumberChange.style.backgroundColor = "white";
    };

    var addressNameChange = document.getElementById("address_name_input");
    addressNameChange.onclick = function () {
        addressNameChange.style.backgroundColor = "white";
    };

    var addressLine1Change = document.getElementById("address_line1_input");
    addressLine1Change.onclick = function () {
        addressLine1Change.style.backgroundColor = "white";
    };

    var addressLine2Change = document.getElementById("address_line2_input");
    addressLine2Change.onclick = function () {
        addressLine2Change.style.backgroundColor = "white";
    };

    var townChange = document.getElementById("town_input");
    townChange.onclick = function () {
        townChange.style.backgroundColor = "white";
    };

    var countryChange = document.getElementById("country_input");
    countryChange.onclick = function () {
        countryChange.style.backgroundColor = "white";
    };

    var postcodeChange = document.getElementById("postcode_input");
    postcodeChange.onclick = function () {
        postcodeChange.style.backgroundColor = "white";
    };

    var close_address_view = document.getElementById("close_edit_address");
    close_address_view.onclick = function () {
        var passView = document.getElementById("editAddress");
        passView.style.display = "none";
    };

    var change_password_button = document.getElementById("password_change_button");
    change_password_button.onclick = function () {
        var passView = document.getElementById("changePassword");
        if (passView.style.display !== "block") {
            passView.style.display = "block";
        }
    };

    var close_change_password = document.getElementById("close_change_password");
    close_change_password.onclick = function () {
        var passView = document.getElementById("changePassword");
        passView.style.display = "none";
    };

    var delete_profile_pic_button = document.getElementById("delete_pic_button");
    delete_profile_pic_button.onclick = function () {
        var passView = document.getElementById("deletePic");
        if (passView.style.display !== "block") {
            passView.style.display = "block";
        }
    };

    var close_delete_pic = document.getElementById("close_delete_pic");
    close_delete_pic.onclick = function () {
        var passView = document.getElementById("deletePic");
        passView.style.display = "none";
    };

    var delete_picture_1 = document.getElementById("delete_pic_1");
    if (delete_picture_1 != null) {
        delete_picture_1.onclick = function () {
            var image = document.getElementById("profile_image_1");
            image.src = "img/blankPic.png";
            delete_picture_1.style.display = "none";
        };
    }

    var delete_picture_2 = document.getElementById("delete_pic_2");
    if (delete_picture_2 != null) {
        delete_picture_2.onclick = function () {
            var image = document.getElementById("profile_image_2");
            image.src = "img/blankPic.png";
        };
    }

    var delete_picture_3 = document.getElementById("delete_pic_3");
    if (delete_picture_3 != null) {
        delete_picture_3.onclick = function () {
            var image = document.getElementById("profile_image_3");
            image.src = "img/blankPic.png";
        };
    }

    var delete_picture_4 = document.getElementById("delete_pic_4");
    if (delete_picture_4 != null) {
        delete_picture_4.onclick = function () {
            var image = document.getElementById("profile_image_4");
            image.src = "img/blankPic.png";
        };
    }

    document.getElementById("profile_image_1").onclick = function () {
        var image_input = document.getElementById("image_input_1");
        image_input.click();
    };

    document.getElementById("profile_image_2").onclick = function () {
        var image_input = document.getElementById("image_input_2");
        image_input.click();
    };

    document.getElementById("profile_image_3").onclick = function () {
        var image_input = document.getElementById("image_input_3");
        image_input.click();
    };

    document.getElementById("profile_image_4").onclick = function () {
        var image_input = document.getElementById("image_input_4");
        image_input.click();
    };

    document.getElementById("image_input_1").onchange = function (event) {
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        var profile_image_1 = document.getElementById("profile_image_1");
        profile_image_1.title = selectedFile.name;

        reader.onload = function (event) {
            profile_image_1.src = event.target.result;
        };

        reader.readAsDataURL(selectedFile);
        var submit_image_1 = document.getElementById("submit_image_1");
        console.log(submit_image_1);
        submit_image_1.click();
    };

    document.getElementById("image_input_2").onchange = function (event) {
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        var profile_image_2 = document.getElementById("profile_image_2");
        profile_image_2.title = selectedFile.name;

        reader.onload = function (event) {
            profile_image_2.src = event.target.result;
        };

        reader.readAsDataURL(selectedFile);
        var submit_image_2 = document.getElementById("submit_image_2");
        submit_image_2.click();

    };

    document.getElementById("image_input_3").onchange = function (event) {
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        var profile_image_3 = document.getElementById("profile_image_3");
        profile_image_3.title = selectedFile.name;

        reader.onload = function (event) {
            profile_image_3.src = event.target.result;
            image = profile_image_3.src;
            image_id = document.getElementById("profile_pic_3_id");
            email = document.getElementById("user_email6");
        };

        reader.readAsDataURL(selectedFile);
        document.getElementById("submit_image_3").click();

    };

    document.getElementById("image_input_4").onchange = function (event) {
        var selectedFile = event.target.files[0];
        var reader = new FileReader();

        var profile_image_4 = document.getElementById("profile_image_4");
        profile_image_4.title = selectedFile.name;

        reader.onload = function (event) {
            profile_image_4.src = event.target.result;

        };

        reader.readAsDataURL(selectedFile);
        document.getElementById("submit_image_4").click();

    };

    function addAddress(address) {
        addresses.push(address);
    }

    function getAddress(position) {
        return addresses[position];
    }

    function getNumberOfAddresses() {
        console.log(addresses.length);
        return addresses.length;
    }

    function validateChangePasswordData() {

        var response = "";
        var pass = document.getElementById("edit_password");
        var passV = document.getElementById("edit_password_verify");
        password = pass.value;
        var passwordVer = passV.value;
        email = document.getElementById("user_email1").value;

        if ((password !== "") && (passwordVer !== "")) {
            if (!(password === passwordVer)) {
                pass.placeholder = "PASSWORDS MUST MATCH";
                pass.value = "";
                pass.style.backgroundColor = "#FF4C4C";

                passV.placeholder = "PASSWORD MUST MATCH";
                passV.value = "";
                passV.style.backgroundColor = "#FF4C4C";

                response += "PASSWORDS: MUST MATCH\n";
            }
        } else {
            if (password === "") {
                pass.placeholder = "PASSWORD REQUIRED";
                pass.style.backgroundColor = "#FF4C4C";
                response += "PASSWORD: REQUIRED\n";
            }

            if (passwordVer === "") {
                passV.placeholder = "PASSWORD REPEAT REQUIRED";
                passV.style.backgroundColor = "#FF4C4C";
                response += "PASSWORD REPEAT: REQUIRED\n";
            }
        }

        if (response !== "") {
            window.alert(response);
            return false;
        }

        return true;

    }

    function validateUpdateInfoData() {

        var fn = document.getElementById("forename_change");
        forename = fn.value.trim();

        var sn = document.getElementById("surname_change");
        surname = sn.value.trim();

        var mn = document.getElementById("mobile_number_change");
        mobileNumber = mn.value;

        var bi = document.getElementById("bio_change");
        bio = bi.value;

        var em = document.getElementById("user_email2");
        email = em.value;

        var response = "";

        //forename validation
        if (forename === "") {
            fn.placeholder = "FIRST NAME REQUIRED";
            fn.style.backgroundColor = "#FF4C4C";
            response += "FIRST NAME REQUIRED\n";
        }

        //surname validation
        if (surname === "") {
            sn.placeholder = "SURNAME REQUIRED";
            sn.style.backgroundColor = "#FF4C4C";
            response += "SURNAME REQUIRED\n";
        }

        //mobile number validation
        if (mobileNumber !== "") {
            if (!validMobileNumber(mobileNumber)) {
                mn.placeholder = "MOBILE NUMBER NOT VALID";
                mn.value = "";
                mn.style.backgroundColor = "#FF4C4C";
                response += "MOBILE NUMBER: NOT VALID FORMAT\n";
            }
        } else {
            mn.placeholder = "MOBILE NUMBER REQUIRED";
            mn.style.backgroundColor = "#FF4C4C";
            response += "MOBILE NUMBER: REQUIRED\n";
        }

        if (response !== "") {
            window.alert(response);
            return false;
        }

        return true;

    }

    function validateEditAddressData() {

        var response = "";

        address_id = document.getElementById("address_id").value;

        var an = document.getElementById("address_name_input");
        address_name = an.value.trim();

        var addl1 = document.getElementById("address_line1_input");
        address_line_1 = addl1.value.trim();

        var addl2 = document.getElementById("address_line2_input");
        address_line_2 = addl2.value.trim();

        var tn = document.getElementById("town_input");
        town = tn.value.trim();

        var cy = document.getElementById("country_input");
        country = cy.value.trim();

        var pc = document.getElementById("postcode_input");
        postcode = pc.value.trim();

        if (address_name === "") {
            an.placeholder = "ADDRESS NAME REQUIRED";
            an.style.backgroundColor = "#FF4C4C";
            response += "ADDRESS NAME: REQUIRED\n";
        }

        if (address_line_1 === "") {
            addl1.placeholder = "ADDRESS LINE 1 REQUIRED";
            addl1.style.backgroundColor = "#FF4C4C";
            response += "ADDRESS LINE 1: REQUIRED\n";
        }

        if (address_line_2 === "") {
            addl2.placeholder = "ADDRESS LINE 2 REQUIRED";
            addl2.style.backgroundColor = "#FF4C4C";
            response += "ADDRESS LINE 2: REQUIRED\n";
        }

        if (town === "") {
            tn.placeholder = "TOWN REQUIRED";
            tn.style.backgroundColor = "#FF4C4C";
            response += "TOWN: REQUIRED\n";
        }

        if (country === "") {
            cy.placeholder = "COUNTRY REQUIRED";
            cy.style.backgroundColor = "#FF4C4C";
            response += "COUNTRY: REQUIRED\n";
        }

        if (postcode !== "") {
            if (!validPostcode(postcode)) {
                pc.placeholder = "INVALID POSTCODE";
                pc.value = "";
                pc.style.backgroundColor = "#FF4C4C";
                response += "POSTCODE: INVALID\n";
            } else {
                postcode = postcode.toUpperCase();
                postcode = postcode.replace(" ", "");
                pc.value = postcode;
            }
        } else {
            pc.placeholder = "POSTCODE REQUIRED";
            pc.style.backgroundColor = "#FF4C4C";
            response += "POSTCODE REQUIRED\n";
        }

        if (response !== "") {
            window.alert(response);
            return false;
        }

        return true;
    }

    function validMobileNumber(number) {
        var numberEx = /[0-9]{11}/i;
        return numberEx.test(number);
    }

    function validPostcode(postcode) {
        var postCodeEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
        return postCodeEx.test(postcode);
    }

    document.getElementById("submit_image_1").onclick = function(){
        document.getElementById("changeImage1").submit();
    };

    document.getElementById("submit_image_2").onclick = function(){
        document.getElementById("changeImage2").submit();
    };

    document.getElementById("submit_image_3").onclick = function(){
        document.getElementById("changeImage3").submit();
    };

    document.getElementById("submit_image_4").onclick = function(){
        document.getElementById("changeImage4").submit();
    };