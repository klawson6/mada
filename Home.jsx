/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                                                  Swiping*/

var xFirst, yFirst;

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
    const xSecond = evt.touches[0].clientX, ySecond = evt.touches[1].clientY;
    const xSwipe = xFirst - xSecond, ySwipe = yFirst - ySecond;

    if(Math.abs(xSwipe)>Math.abs(ySwipe)){
        if ( xSwipe > 0 ) {
            /* left swipe */
            console.log("left");
        } else {
            /* right swipe */
            console.log("right");
        }
    }
};

/* document listener */
document.addEventListener("touchstart", startTouchEvent, false);
document.addEventListener("touchmove", getTouchOrientation, false);


/*------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*                                                          React Components*/
class UserProfilePage extends React.Component {
    render() {
        return(
            <div id = "user_profile">
                <img src={this.props.link} alt={this.props.alt} id="image"></img>
                <br></br><br></br>
                <label id="image_label" htmlFor="image">{this.props.data}</label>
            </div>
    );
    }
}
    ReactDOM.render(
    <UserProfilePage link = "img/woman.jpeg" alt = "Happy Man" data = "David Smith | 27"/>,
    document.getElementById('root')
);