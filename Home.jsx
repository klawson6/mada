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


    if(ySwipe >= 0 && ySwipe <= 3 && xSwipe >= 0 && xSwipe <= 3  && currTime >= 100){
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
        let a, b, c;
        if (!change) {
            a = "img/woman.jpeg";
            b = "Happy Lady";
            c = "Anna McD | 20";
        } else {
            a = "img/man1.jpeg";
            b = "Man";
            c = "Kenny McKennelstoun| 24";
        }
        link = a;
        alt = b;
        data = c;
        change = !change;

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
                <div className="editProfileWrapper">
                <div className={"jdj"}>
                    <div id="img_container">
                        <img className="profile_img" src="img/free_img.png" alt="Image 1"></img>
                        <img className="profile_img" src="img/free_img.png" alt="Image 2"></img>
                        <img className="profile_img" src="img/free_img.png" alt="Image 3"></img>
                        <img className="profile_img" src="img/free_img.png" alt="Image 4"></img>
                        <img className="profile_img" src="img/free_img.png" alt="Image 5"></img>
                    </div>

                </div>
                </div>

                <div className="moreDetails">
                    <h1>About ME</h1>
                    <div className="aboutMe">
                        <p>I am a friendly person</p>
                        <p>I like long walks on the beach and etc</p>
                    </div>
                    <div className="revies">
                        <h1>Reviews</h1>
                    </div>
                </div>
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

let yes_button = document.getElementById("cirlce_yes");
let no_button = document.getElementById("cirlce_no");
let redo_button = document.getElementById("cirlce_redo");

document.addEventListener("load",function () {
    updateData("frontCard");
    document.body.scroll = "no";
   // statusCard.style.backgroundImage="url('img/accept.png')";
    //statusCard.style.backgroundPosition= "left top";
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
    acceptCard.style.opacity = 0.8;

    let i = 0;
    let c = setInterval(function () {
        if(i!=30){
            clearInterval(c);
            revertChanges();
            animating = false;
            choice = null;

            acceptCard.style.backgroundColor = "rgb(26, 95, 16)";
        }
    },200)

});

no_button.addEventListener("click", function () {
    animating = true;

    rejectCard.style.backgroundColor = "transparent";
    rejectCard.style.opacity = 0.8;

    let i = 0;
    let c = setInterval(function () {
        if(i!=30){
            clearInterval(c);
            revertChanges();
            animating = false;
            choice = null;

            rejectCard.style.backgroundColor = "rgb(131, 3, 12)";
        }
    },200)


});

redo_button.addEventListener("click", function () {

});
