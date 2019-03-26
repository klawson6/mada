/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                                                  Swiping*/
let xFirst, yFirst;
let frontCard = document.getElementById("frontCard");
let acceptCard = document.getElementById("card_accept");
let rejectCard = document.getElementById("card_reject");
let moreDetailsCard = document.getElementById("card_moreDetails");
let choice = null;
let startTime = null;


/* get first touch location*/
function startTouchEvent(evt){
    const firstTouch = evt.touches || evt.originalEvent.touches;
    xFirst = firstTouch[0].clientX;
    yFirst = firstTouch[0].clientY;
    startTime = new Date().getTime();
}


/*get where exactly they are swiping*/
function swipe(evt) {
    /*if the either of the input is empty*/
    if(!xFirst || !yFirst || !startTime){
        return;
    }

    const currTime = new Date().getTime() - startTime;

    const xSecond = evt.touches[0].clientX,
         ySecond = evt.touches[0].clientY;
    const xSwipe = xFirst - xSecond,
          ySwipe = yFirst - ySecond;


    if(ySwipe >= 0 && ySwipe <= 6 && xSwipe >= 0 && xSwipe <= 6  && currTime >= 100){
         /*we are holding */
        alert("holding")
      //  revertChanges();
// display: none;

        ReactDOM.render(
            <DetailedUserProfile link = {link} alt = {alt} data = {data} />,
            document.getElementById('card_moreDetails')
        );

        moreDetailsCard.style.display = "block";
        frontCard.style.display = "none";
        acceptCard.style.display = "none";
        rejectCard.style.display = "none";

    }else {
        /*we are animating*/
        if (currTime < 150) return; /*we are swiping too quick*/
        if (Math.abs(xSwipe) > Math.abs(ySwipe)) {
            if (xSwipe > 0) {
                choice = "accept"
            } else {
                choice = "reject"
            }
        }

        animate(-xSwipe);
    }
};
/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                               Animations*/

let animating = false;
let link = "img/man1.jpeg",alt = "Biggie Smalls", data = "Biggie S | Swag";
let change = false;

function animate(pullDelta){
    /*animation loop*/
    if(!choice)return;

    animating = true;
    let degree = pullDelta/10;
    let opacity = (pullDelta)/100;
    let rejectOpacity = (opacity >= 0) ? 0 : Math.abs(opacity);
    let acceptOpacity = (opacity <= 0) ? 0 : opacity;

    frontCard.style.transform ="translateX("+ pullDelta +"px) rotate("+ degree +"deg)";
    if(rejectOpacity !=0) {
        rejectCard.style.transform = "translateX(" + pullDelta + "px) rotate(" + degree + "deg)";
        rejectCard.style.opacity = rejectOpacity + "";
    }
    if(acceptOpacity!=0) {
        acceptCard.style.transform = "translateX(" + pullDelta + "px) rotate(" + degree + "deg)";
        acceptCard.style.opacity = acceptOpacity + "";
    }


};

function revertChanges(){
    rejectCard.style.opacity = 0 + "";
    acceptCard.style.opacity = 0 + "";
    frontCard.style.transform = "translate(.3rem) rotate(0deg)";
    acceptCard.style.transform = "translate(.3rem) rotate(0deg)";
    rejectCard.style.transform = "translate(.3rem) rotate(0deg)";
    updateData();
};

function updateData() {
    if (animating) {
        jQuery.ajax(
            {
                type:"GET",
                url: "Home.php",
                dataType: 'json',
                data: {action: 'selectUser'},
                success: function (obj) {
                    let user = obj.result;
                    data = user.name + " | " + user.age;

                }
            });



        ReactDOM.render(
            <UserProfilePage link={link} alt={alt} data={data} />,
            document.getElementById("frontCard")
        );
    }
};

/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                          React Components*/
class UserProfilePage extends React.Component {
    render() {
        return(
            <div class = "user_profile">
                <div id = "card_photo">
                    <img src={this.props.link} alt={this.props.alt} id="image"></img>
                    <br></br><br></br>
                </div>
                <div class = "card_descriptor">
                    <label id="image_label" htmlFor="image">{this.props.data}</label>
                </div>
            </div>
    );
    }
}

class DetailedUserProfile extends React.Component {
    render() {
        return(
            <div class = "moreDetailedUserProfile">
                <h1>
                    <label id="image_label" htmlFor="image">{this.props.data}</label>
                </h1>
                <div id="profileImages" class="profileImages" >

                    <img className="profileI" src="img/man1.jpeg" alt="Image 1"></img>
                    <img className="profileI" src="img/free_img.png" alt="Image 2"></img>
                    <img className="profileI" src="img/free_img.png" alt="Image 3"></img>
                    <img className="profileI" src="img/free_img.png" alt="Image 4"></img>
                    <img className="profileI" src="img/free_img.png" alt="Image 5"></img>

                </div>
                <div class="moreDetails">
                    <h1>About ME</h1>
                    <div class="aboutMe">
                        <p>I am a friendly person</p>
                        <p>I like long walks on the beach and etc</p>
                    </div>
                    <div class="reviewGroup">
                        <h1>Reviews</h1>
                        <div className="reviews">
                            <h4>Cleanliness</h4>
                            <img className="star" src="img/star.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_empty.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_empty.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_empty.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_empty.png" alt="emptyStar"></img>
                        </div>
                        <div className="reviews">
                            <h4>Politeness</h4>
                            <img className="star" src="img/star.png" alt="emptyStar"></img>
                            <img className="star" src="img/star.png" alt="emptyStar"></img>
                            <img className="star" src="img/star.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_empty.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_empty.png" alt="emptyStar"></img>
                        </div>
                        <div className="reviews">
                            <h4>Ability To Drive</h4>
                            <img className="star" src="img/star.png" alt="emptyStar"></img>
                            <img className="star" src="img/star.png" alt="emptyStar"></img>
                            <img className="star" src="img/star.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_half.png" alt="emptyStar"></img>
                            <img className="star" src="img/star_empty.png" alt="emptyStar"></img>
                        </div>
                    </div>
                </div>
                <br></br>
                <button id="close" className="closeButton" onClick={closePopUp}>Close</button>
            </div>
        );
    }
}


    ReactDOM.render(
        <UserProfilePage link = {link} alt = {alt} data = {data} />,
        document.getElementById('frontCard')
);

/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                         Action Listeners*/


function closePopUp(){
    moreDetailsCard.style.display = "none";
    frontCard.style.display = "block";
    acceptCard.style.display = "block";
    rejectCard.style.display = "block";
}

let yes_button = document.getElementById("cirlce_yes");
let no_button = document.getElementById("cirlce_no");
let redo_button = document.getElementById("cirlce_redo");

document.addEventListener("load",function () {
    updateData("frontCard");
    document.body.scroll = "no";
})

document.addEventListener("touchstart", startTouchEvent, false);

document.addEventListener("touchmove", swipe, false);

document.addEventListener("touchend",function () {
    if(animating) {
        if (!choice) return;
        /*display choice*/
        revertChanges();
        animating = false;
        choice = null;
        xFirst = null;
        yFirst = null;
    }
},false);

yes_button.addEventListener("click", function () {
    animating = true;

    acceptCard.style.backgroundColor = "transparent";
    acceptCard.style.backgroundImage="url('img/accept_colour.png')";
    // background-image: url("img/reject.png");
    acceptCard.style.opacity = 0.8;

    let i = 0;
    let c = setInterval(function () {
        if(i!=30){
            clearInterval(c);
            revertChanges();
            animating = false;
            choice = null;

            acceptCard.style.backgroundColor = "rgb(26, 95, 16)";
            acceptCard.style.backgroundImage= "url('img/accept.png')";
        }
    },200)

});

no_button.addEventListener("click", function () {
    animating = true;

    rejectCard.style.backgroundColor = "transparent";
    rejectCard.style.backgroundImage="url('img/reject_colour.png')";
    rejectCard.style.opacity = 0.8;

    let i = 0;
    let c = setInterval(function () {
        if(i!=30){
            clearInterval(c);
            revertChanges();
            animating = false;
            choice = null;

            rejectCard.style.backgroundColor = "rgb(131, 3, 12)";
            rejectCard.style.backgroundImage="url('img/reject.png')";
        }
    },200)


});

redo_button.addEventListener("click", function () {

});
