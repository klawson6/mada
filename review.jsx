class ReviewAdding extends React.Component {
    render() {
        return(
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
                        </div>g className="star" src="img/star.png" alt="emptyStar"></img>
                        </div>
        );
    }
}

Document.addEventListener("load",
ReactDOM.render(
    <ReviewAdding />,
    document.getElementById('stars')
));