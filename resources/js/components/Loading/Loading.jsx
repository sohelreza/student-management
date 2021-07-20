import React, { Component } from "react";

import loadingGif from "./loading.gif";
import "./Loading.css";

class Loading extends Component {
    // state = {  }
    render() {
        return (
            <>
                <div className="loading">
                    <img src={loadingGif} alt="" />
                </div>
            </>
        );
    }
}

export default Loading;
