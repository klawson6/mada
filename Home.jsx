/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                                                  Swiping*/
let xFirst, yFirst;
let frontCard = document.getElementById("frontCard");
let acceptCard = document.getElementById("card_accept");
let rejectCard = document.getElementById("card_reject");
let moreDetailsCard = document.getElementById("card_moreDetails");
let slider = document.getElementById("slider_container");
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


    if(ySwipe >= 0 && ySwipe <= 100 && xSwipe >= 0 && xSwipe <= 100  && currTime >= 200){
         /*we are holding */

        popUP = true;
        ReactDOM.render(
            <DetailedUserProfile coverImg = {coverImg} alt = {alt} data = {data} bio = {bio} photo1 = {photo1} photo2 = {photo2} photo3 = {photo3} photo4 = {photo4}  />,
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
                choice = "reject"
            } else {
                choice = "accept"
            }
        }
        animate(-xSwipe);
    }
};
/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                               Animations*/

let animating = false;
let popUP = false;
let coverImg = "",alt = "", data = "",bio = "",  photo1 = "" , photo2 = "" , photo3 = "" , photo4 = "",email = "" ;
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


function getData() {
    if(!popUP) {
        jQuery.ajax(
            {
                type: "post",
                url: "HomeUtilities.php",
                dataType: 'json',
                data: {"update": "1"},
                success: function (response) {

                   // console.log(response);
                    let user = response;
                    data = user.name + " | " + user.age;
                    alt = user.name;
                    coverImg = user.coverImg;
                    bio = user.bio;
                    photo1 = user.photo1;
                    photo2 = user.photo2;
                    photo3 = user.photo3;
                    photo4 = user.photo4;

                    email = user.email;

                    ReactDOM.render(
                        <UserProfilePage link={coverImg} alt={alt} data={data}/>,
                        document.getElementById("frontCard")
                    );
                },
                error: function (e) {
                    console.log('error');
                    console.log(e);
                }
            });
    }

}

function updateData() {
    if (animating) {
        getData();
    }
};

/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                          React Components*/
let detailedRef ;

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

/*{this.photo2 != null ? <img id = "photo3" className="profileI" src={this.props.photo2} alt="Image 3"></img>  : null }
                  {this.photo3 != null ? <img id = "photo3" className="profileI" src={this.props.photo2} alt="Image 3"></img>  : null }
                  {this.photo4 != null ? <img id = "photo4" className="profileI" src={this.props.photo3} alt="Image 4"></img>  : null }*/
class DetailedUserProfile extends React.Component {
    constructor(props){
        super(props);
        this.detailedRef  = React.createRef();
    }

    render() {
        return(
            <div class = "moreDetailedUserProfile" ref = {this.detailedRef}>
                <h1>
                    <label id="image_label" htmlFor="image">{this.props.data}</label>
                </h1>
                <div id="profileImages" class="profileImages" >
                    <img id = "photo1" className="profileI" src={this.props.coverImg} alt="Image 1"></img>
                    {
                        (this.props.photo1) == null ?
                            (null)
                            :  (<img id = "photo2" className="profileI" src={this.props.photo1}  alt="Image 2"></img> )}
                    {
                        (this.props.photo2) == null ?
                            (null)
                            :  (<img id = "photo2" className="profileI" src={this.props.photo2}  alt="Image 3"></img> )}
                    {
                        (this.props.photo3) == null ?
                            (null)
                            :  (<img id = "photo2" className="profileI" src={this.props.photo3}  alt="Image 4"></img> )}
                    {
                        (this.props.photo4) == null ?
                            (null)
                            :  (<img id = "photo2" className="profileI" src={this.props.photo4}  alt="Image 5"></img> )}

                </div>
                <div class="moreDetails">
                    <h1>About ME</h1>
                    <div class="aboutMe">
                        {this.props.bio}
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
getData();
if(!popUP) {
    ReactDOM.render(
        <UserProfilePage link={coverImg} alt={alt} data={data}/>,
        document.getElementById('frontCard')
    );
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                         Action Listeners*/


function closePopUp(){
    moreDetailsCard.style.display = "none";
    frontCard.style.display = "block";
    acceptCard.style.display = "block";
    rejectCard.style.display = "block";
    popUP = false;
}

function postChange(change){
    jQuery.ajax(
        {
            type: "post",
            url: "HomeUtilities.php",
            dataType: 'json',
            data: {"change": change}
        });
}


function postLiked(likedEmail){
    jQuery.ajax(
        {
            type: "post",
            url: "HomeUtilities.php",
            dataType: 'json',
            data: {"liked": likedEmail}
        });
}



let yes_button = document.getElementById("cirlce_yes");
let no_button = document.getElementById("cirlce_no");
let redo_button = document.getElementById("cirlce_redo");

document.addEventListener("load",function () {
    getData();
    document.body.scroll = "no";
})

document.addEventListener("touchstart", startTouchEvent, false);

document.addEventListener("touchmove", swipe, false);

document.addEventListener("touchend",function () {
    if(animating) {
        if (!choice) return;
        /*display choice*/
        console.log(choice);
        if(choice === "accept"){
            postLiked(email);
        }
        revertChanges();
        animating = false;
        choice = null;
        xFirst = null;
        yFirst = null;


    }
},false);

slider.addEventListener("click", function () {

    let button = document.getElementById("isDriverSlider");
    let title = document.getElementById("headder");

    if(button.style.cssFloat == "left"){
        button.style.cssFloat = "right";

        button.style.backgroundColor = "rgb(131, 12, 127)";
        slider.style.backgroundColor = "rgb(98, 9, 95)";
        button.style.borderColor = "rgb(106, 10, 103)";
        title.innerText = "Select a Driver"

        postChange("driver");

    }else{
        button.style.cssFloat = "left";

        /*green*/
        button.style.backgroundColor = "rgb(31, 138, 82)";
        slider.style.backgroundColor = "rgb(14, 70, 45)";
        button.style.borderColor = "rgb(25, 112, 66)";
        title.innerText = "Select a Rider"

        postChange("rider");

    }

    getData();
    ReactDOM.render(
        <UserProfilePage link={coverImg} alt={alt} data={data}/>,
        document.getElementById('frontCard')
    );

});

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
