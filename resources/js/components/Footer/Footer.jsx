import React, { Component } from "react";

import "./Footer.css";
class Footer extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }
    render() {
        return (
            <div id="contact" className="">
                <footer>
                    <div className="row justify-content-center">
                        <div className="col-md-4 pl-5">
                            <h4>Services</h4>
                            <div className="footer-underline"></div>
                            <ul className="footer-list">
                                <li>SSC</li>
                                <li>HSC</li>
                                <li>Engineering Admission</li>
                                <li>Medical Admission</li>
                            </ul>
                        </div>
                        <div className="col-md-4 pl-5">
                            <h4>Support</h4>
                            <div className="footer-underline"></div>
                            <ul className="footer-list">
                                <li>FAQ</li>
                                <li>Terms & Conditions</li>
                            </ul>
                        </div>
                        <div className="col-md-4 pl-5">
                            <h4>Address</h4>
                            <div className="footer-underline"></div>
                            <ul className="footer-list">
                                <li>House #7</li>
                                <li>Road #11</li>
                                <li>Sector #6</li>
                                <li>Uttara, Dhaka-1230</li>
                                <li>Terms & Conditions</li>
                            </ul>
                        </div>
                    </div>
                </footer>
            </div>
        );
    }
}
export default Footer;
