/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                                                  Swiping*/

let xFirst, yFirst;
let frontCard = document.getElementById("frontCard");
let acceptCard = document.getElementById("card_accept");
let rejectCard = document.getElementById("card_reject");
let statusCard = document.getElementById("card_status");
let transform = null;
let choice = null;


/* get first touch location*/
function startTouchEvent(evt){
    const firstTouch = evt.touches || evt.originalEvent.touches;
    xFirst = firstTouch[0].clientX;
    yFirst = firstTouch[0].clientY;
}


/*get where exactly they are swiping*/
function getTouchOrientation(evt) {
    /*if the either of the input is empty*/
    if(!xFirst || !yFirst){
        return;
    }
    const xSecond = evt.touches[0].clientX, ySecond = evt.touches[0].clientY;
    const xSwipe = xFirst - xSecond, ySwipe = yFirst - ySecond;

    if(Math.abs(xSwipe)>Math.abs(ySwipe)) {
        if (xSwipe > 0) { /* left swipe */
            animating = true;
            transform=transform+ySwipe;
            animate(false,ySwipe);
        } else { /* right swipe */
            animating = true;
            transform=transform-ySwipe;
            animate(true,-ySwipe);
        }
    }
};
/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                               Animations*/

let animating = false;
let link = "img/man1.jpeg",alt = "Biggie Smalls", data = "Biggie S | Swag";
let change = false;

function animate(movingLeft, pullDelta){
    /*animation loop*/
    let degree = pullDelta/10;
    let opacity = pullDelta/100;
    let rejectOpacity = (opacity >= 0) ? 0 : Math.abs(opacity);
    let likeOpacity = (opacity <= 0) ? 0 : opacity;

    frontCard.style.transform ="translateX("+ pullDelta +"px) rotate("+ degree +"deg)";
    if(!movingLeft){
        rejectCard.style.transform ="translateX("+ pullDelta +"px) rotate("+ degree +"deg)";
        rejectCard.style.opacity =  rejectOpacity + "";
        choice="accept";
    }else {
        acceptCard.style.transform ="translateX("+ pullDelta +"px) rotate("+ degree +"deg)";
        acceptCard.style.opacity =  likeOpacity + "";
        choice="reject";
    }
}

function snapBack(){
    rejectCard.style.opacity = 0 + "";
    acceptCard.style.opacity = 0 + "";
    frontCard.style.transform = "translate(.3rem) rotate(0deg)";
    acceptCard.style.transform = "translate(.3rem) rotate(0deg)";
    rejectCard.style.transform = "translate(.3rem) rotate(0deg)";
    updateData();
}

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
}

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

    ReactDOM.render(
        <UserProfilePage link = {link} alt = {alt} data = {data} />,
        document.getElementById('frontCard')
);

/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                         Action Listeners*/

document.addEventListener("load",function () {
    updateData("frontCard");
    document.body.scroll = "no";
   // statusCard.style.backgroundImage="url('img/accept.png')";
    //statusCard.style.backgroundPosition= "left top";

})

document.addEventListener("touchstart", startTouchEvent, false);
document.addEventListener("touchmove", getTouchOrientation, false);
document.addEventListener("touchend",function () {
    if (!transform) return; /*Quick Touch*/
    if(!choice)return;
    /*display choice*/

    frontCard.style.backgroundPosition = "right top;";
    frontCard.style.backgroundImage = "url('img/reject.png')";
    frontCard.style.backgroundRepeat= "no-repeat";

    snapBack();
    transform=null;
    animating = false;
    choice = null;
},false);
