import React, { Component } from "react";
import { ZoomMtg } from "@zoomus/websdk";
import { useEffect } from "react";

import "./ZoomClass.css";

const crypto = require("crypto"); // crypto comes with Node.js

function generateSignature(apiKey, apiSecret, meetingNumber, role) {
    return new Promise((res, rej) => {
        // Prevent time sync issue between client signature generation and zoom
        const timestamp = new Date().getTime() - 30000;
        const msg = Buffer.from(
            apiKey + meetingNumber + timestamp + role
        ).toString("base64");
        const hash = crypto
            .createHmac("sha256", apiSecret)
            .update(msg)
            .digest("base64");
        const signature = Buffer.from(
            `${apiKey}.${meetingNumber}.${timestamp}.${role}.${hash}`
        ).toString("base64");

        res(signature);
    });
}

var apiKey = "GsoUO88sRaKiU6cjJ7N81g";
var apiSecret = "r1fRTI73rcaoU3iUCtW452rKnVhb2UrOP45E";
var meetingNumber = 79141469047;
var leaveUrl = "http://127.0.0.1:8000/join-class"; // our redirect url
var userName = "WebSDK";
var userEmail = "test@gmail.com";
var passWord = "b7L0fs";

var signature = "";
generateSignature(apiKey, apiSecret, meetingNumber, 0).then(res => {
    signature = res;
}); // need to generate based on meeting id - using - role by default 0 = javascript

export const ZoomClass = () => {
    // loading zoom libraries before joining on component did mount
    useEffect(() => {
        showZoomDIv();
        ZoomMtg.setZoomJSLib("https://source.zoom.us/1.9.5/lib", "/av");
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareJssdk();
        initiateMeeting();
    }, []);

    const showZoomDIv = () => {
        document.getElementById("zmmtg-root").style.display = "block";
    };

    const initiateMeeting = () => {
        ZoomMtg.init({
            leaveUrl: leaveUrl,
            isSupportAV: true,
            success: success => {
                console.log(success);

                ZoomMtg.join({
                    signature: signature,
                    meetingNumber: meetingNumber,
                    userName: userName,
                    apiKey: apiKey,
                    userEmail: userEmail,
                    passWord: passWord,
                    success: success => {
                        console.log(success);
                    },
                    error: error => {
                        console.log(error);
                    }
                });
            },
            error: error => {
                console.log(error);
            }
        });
    };

    return <div className="zmmtg-root">Zoom</div>;
};
