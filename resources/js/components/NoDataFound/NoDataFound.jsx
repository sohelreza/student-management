import React from "react";

import "./NoDataFound.css";

const NoDataFound = props => {
    return (
        <>
            <img
                src={require("../../../assests/images/no-data-found.png")}
                className="mx-auto d-block no-data-image"
            />
            <h6 className="d-flex flex-row justify-content-center align-items-center text-center no-data-style mt-4">
                {props.noDataFoundMessage}
            </h6>
        </>
    );
};

export default NoDataFound;
