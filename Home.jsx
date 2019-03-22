//import React from "react";

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
    <UserProfilePage link = "http://alexmcarthur.co.uk/biggie.png" alt = "Happy Man" data = "David Smith | 27"/>,
    document.getElementById('root')
);