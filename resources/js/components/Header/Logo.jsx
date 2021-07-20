import React, { Component } from "react";
import { Link } from "react-router-dom";

class Logo extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }
    render() {
        return (
            <div>
                <Link to='/dashboard'>
                    <img
                        src={require("../../../assests/images/logo.png")}
                        width="150px"
                        height="50px"
                    />
                </Link>
            </div>
        );
    }
}
export { Logo };
