/*use strict*/

/*global view*/
var view = null;

function EditProfile() {
    var form = document.getElementById("EditAddress"),
        address1 =  document.getElementById("address1"),
        close_button_address = document.getElementById("closeForm")
        close_button_password = document.getElementById("closeForm_password"),
        password_button = document.getElementById("passwordChange_button"),
        password_form = document.getElementById("EditPassword");

    
    this.init = function () {
        close_button_address.addEventListener('click',
            function (ev) {
                form.style.display="none";
        });

        address1.addEventListener('click',
            function (ev) {
            if( password_form.style.display!="block") {
                form.style.display = "block";
            }
        });

        close_button_password.addEventListener('click',
            function (ev) {
                password_form.style.display="none";
            });

        password_button.addEventListener('click',
            function (ev) {
            if( form.style.display != "block") {
                password_form.style.display = "block";
            }
            });

    }


}

view = new EditProfile();
window.addEventListener('load',
    function (ev) {
        view.init();

    });