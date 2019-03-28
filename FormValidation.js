"use strict";

var forename = document.getElementById("first_name_input");
forename.onclick = function(){
    forename.style.backgroundColor = "white";
};

var surname = document.getElementById("surname_input");
surname.onclick = function(){
    surname.style.backgroundColor = "white";
};

var email = document.getElementById("email_input");
email.onclick = function(){
    email.style.backgroundColor = "white";
};

var dob = document.getElementById("dob_input");
dob.onclick = function(){
    dob.style.backgroundColor = "white";
};

var password = document.getElementById("password_input");
password.onclick = function(){
    password.style.backgroundColor = "white";
};

var passwordV = document.getElementById("passwordVer_input");
passwordV.onclick = function(){
    passwordV.style.backgroundColor = "white";
};

// var mobile_number = document.getElementById("mobile_number_input");
// mobile_number.onclick = function(){
//     mobile_number.style.backgroundColor = "white";
// };

var addressName = document.getElementById("address_name_input");
addressName.onclick = function(){
    addressName.style.backgroundColor = "white";
};

var addressLine1 = document.getElementById("address_line1_input");
addressLine1.onclick = function(){
    addressLine1.style.backgroundColor = "white";
};

var addressLine2 = document.getElementById("address_line2_input");
addressLine2.onclick = function(){
    addressLine2.style.backgroundColor = "white";
};

var town = document.getElementById("town_input");
town.onclick = function(){
    town.style.backgroundColor = "white";
};

var country = document.getElementById("country_input");
country.onclick = function(){
    country.style.backgroundColor = "white";
};

var postcode = document.getElementById("postcode_input");
postcode.onclick = function(){
    postcode.style.backgroundColor = "white";
};

function ValidateRegisterFormData(){

    var forename = document.getElementById("first_name_input").value.trim();
    var surname = document.getElementById("surname_input").value.trim();
    var email = document.getElementById("email_input").value.trim();
    var DOB = document.getElementById("dob_input").value;
    var password = document.getElementById("password_input").value;
    var passwordVer = document.getElementById("passwordVer_input").value;
    //var mobileNumber = document.getElementById("mobile_number_input").value;
    var addressName = document.getElementById("address_name_input").value.trim();
    var addressLine1 = document.getElementById("address_line1_input").value.trim();
    var addressLine2 = document.getElementById("address_line2_input").value.trim();
    var town = document.getElementById("town_input").value.trim();
    var country = document.getElementById("country_input").value.trim();
    var postcode = document.getElementById("postcode_input").value.trim();
    var terms = document.getElementById("agreeTerms").checked;
    var response = "";

    //forename validation
    var fn = document.getElementById("first_name_input");
    if(forename === ""){
        fn.placeholder = "FIRST NAME REQUIRED";
        fn.style.backgroundColor = "#FF4C4C";
        response += "FIRST NAME REQUIRED\n";
    }

    //surname validation
    var sn = document.getElementById("surname_input");
    if(surname === ""){
        sn.placeholder = "SURNAME REQUIRED";
        sn.style.backgroundColor = "#FF4C4C";
        response += "SURNAME REQUIRED\n";
    }

    //email validation
    var em = document.getElementById("email_input");
    if(email !== ""){
        if(!validEmail(email)){
            em.placeholder = "EMAIL NOT VALID";
            em.value = "";
            em.style.backgroundColor = "#FF4C4C";
            response += "EMAIL: NOT VALID FORMAT\n";
        }
    }
    else{
        em.placeholder = "EMAIL REQUIRED";
        em.style.backgroundColor = "#FF4C4C";
        response += "EMAIL: REQUIRED\n";
    }

    //DOB validation
    var db = document.getElementById("dob_input");
    if(DOB !== ""){
        var age = calcAge(DOB);
        if(age < 18){
            db.placeholder = "NOT OLD ENOUGH";
            db.value = "";
            db.style.backgroundColor = "#FF4C4C";
            response += "DATE OF BIRTH :NOT OLD ENOUGH\n";
        }
    }
    else{
        db.placeholder = "DATE OF BIRTH REQUIRED";
        db.style.backgroundColor = "#FF4C4C";
        response += "DATE OF BIRTH: REQUIRED\n";
    }

    //password validation
    var pass = document.getElementById("password_input");
    var passV = document.getElementById("passwordVer_input");
    if((password !== "") && (passwordVer !== "")){
        if(!(password === passwordVer)){
            pass.placeholder = "PASSWORDS MUST MATCH";
            pass.value = "";
            pass.style.backgroundColor = "#FF4C4C";

            passV.placeholder = "PASSWORD MUST MATCH";
            passV.value = "";
            passV.style.backgroundColor = "#FF4C4C";

            response += "PASSWORDS: MUST MATCH\n";
        }
    }
    else{
        if(password === ""){
            pass.placeholder = "PASSWORD REQUIRED";
            pass.style.backgroundColor = "#FF4C4C";
            response += "PASSWORD: REQUIRED\n";
        }

        if(passwordVer === ""){
            passV.placeholder = "PASSWORD REPEAT REQUIRED";
            passV.style.backgroundColor = "#FF4C4C";
            response += "PASSWORD REPEAT: REQUIRED\n";
        }
    }

    // //mobile number validation
    // var mn = document.getElementById("mobile_number_input");
    // if(mobileNumber !== ""){
    //    if(!validMobileNumber(mobileNumber)){
    //        mn.placeholder = "MOBILE NUMBER NOT VALID";
    //        mn.value = "";
    //        mn.style.backgroundColor = "#FF4C4C";
    //        response += "MOBILE NUMBER: NOT VALID FORMAT\n";
    //    }
    // }
    // else{
    //     mn.placeholder = "MOBILE NUMBER REQUIRED";
    //     mn.style.backgroundColor = "#FF4C4C";
    //     response += "MOBILE NUMBER: REQUIRED\n";
    // }

    //address line 1 validation
    var an = document.getElementById("address_name_input");
    if(addressName === ""){
        an.placeholder = "ADDRESS NAME REQUIRED";
        an.style.backgroundColor = "#FF4C4C";
        response += "ADDRESS NAME: REQUIRED\n";
    }

    //address line 1 validation
    var al1 = document.getElementById("address_line1_input");
    if(addressLine1 === ""){
        al1.placeholder = "ADDRESS LINE 1 REQUIRED";
        al1.style.backgroundColor = "#FF4C4C";
        response += "ADDRESS LINE 1: REQUIRED\n";
    }

    //address line 2 validation
    var al2 = document.getElementById("address_line2_input");
    if(addressLine2 === ""){
        al2.placeholder = "ADDRESS LINE 2 REQUIRED";
        al2.style.backgroundColor = "#FF4C4C";
        response += "ADDRESS LINE 2: REQUIRED\n";
    }

    //town validation
    var tw = document.getElementById("town_input");
    if(town === ""){
        tw.placeholder = "TOWN REQUIRED";
        tw.style.backgroundColor = "#FF4C4C";
        response += "TOWN: REQUIRED\n";
    }

    //country validation
    var cy = document.getElementById("country_input");
    if(country === ""){
        cy.placeholder = "COUNTRY REQUIRED";
        cy.style.backgroundColor = "#FF4C4C";
        response += "COUNTRY: REQUIRED\n";
    }

    //postcode validation
    var pc = document.getElementById("postcode_input");
    if(postcode !== ""){
        if(!validPostcode(postcode)){
            pc.placeholder = "INVALID POSTCODE";
            pc.value = "";
            pc.style.backgroundColor = "#FF4C4C";
            response += "POSTCODE: INVALID\n";
        }
        else{
            postcode = postcode.toUpperCase();
            postcode = postcode.replace(" ", "");
            pc.value = postcode;
        }
    }
    else{
        pc.placeholder = "POSTCODE REQUIRED";
        pc.style.backgroundColor = "#FF4C4C";
        response += "POSTCODE REQUIRED\n";
    }

    if(terms === false){
        response += "USER MUST ACCEPT CONDITIONS";
    }

    if(response !== ""){
        //window.alert(response);
        return false;
    }

    return true;
}

function validPostcode(postcode){

    var postCodeEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    return postCodeEx.test(postcode);

}

function validEmail(email){
    var emailEx = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z.]{2,15}/i;
    return emailEx.test(email);
}

// function validMobileNumber(number){
//     var numberEx = /[0-9]{11}/i;
//     return numberEx.test(number);
// }

function calcAge(dob){

    var current = new Date();
    var thisYearDrop = 0;
    var dobMonth = dob.substr(5, 2);
    var dobYear = dob.substr(0, 4);
    var dobDate = dob.substr(8, 2);

    if(current.getMonth() < dobMonth){
        thisYearDrop = 1;
    }
    else if((current.getMonth() === dobMonth) && (current.getDate() < dobDate)){
        thisYearDrop = 1;
    }

    var age = current.getFullYear() - dobYear - thisYearDrop;

    return age;

}