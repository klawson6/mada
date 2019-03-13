/*use strict*/

/*global view*/
var view = null;

function FindRider() {
    var display = false;
    this.init = function () {
        /*this is some dummy action listeners, for this to work well, you will add the
        action listener as a new button is created*/
        document.getElementById("co_rider1").addEventListener('click',
            function (ev) {
            if(!display) {
                document.getElementById("co-rider_pop_up").style.display = "block";
                display = true;
            }
        })

        document.getElementById("rider_pop_up_close").addEventListener('click',
            function (ev) {
                document.getElementById("co-rider_pop_up").style.display = "none";
                display = false;
            })
    };
};

view = new FindRider();
window.addEventListener('load',
    function (ev) {
        view.init();

    });