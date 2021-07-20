import React, { useState } from "react";
import { Document, Page, pdfjs, View, Text } from "react-pdf";
// import Viewer, { Worker } from "@phuocng/react-pdf-viewer";
// import { Worker } from "@react-pdf-viewer/core";

// import { Viewer } from "@react-pdf-viewer/core";
// import "@react-pdf-viewer/core/lib/styles/index.css";

// import pdf from "../../../../public/lecture_sheet/1601592783TariqulAmin_Resume.pdf";
// import "./PdfViewer.css";

// pdfjs.GlobalWorkerOptions.workerSrc = `//cdnjs.cloudflare.com/ajax/libs/pdf.js/${pdfjs.version}/pdf.worker.js`;

pdfjs.GlobalWorkerOptions.workerSrc = `//cdnjs.cloudflare.com/ajax/libs/pdf.js/${pdfjs.version}/pdf.worker.js`;
const PdfViewer = props => {
    // let PDF = require("./dashboard.pdf");
    // console.log(props.match.params.fileName);
    // console.log(
    //     window.location.origin + "/content/1601431702A.'s Resume (4).pdf"
    // );
    console.log(props.location.state.pdf);
    const [numPages, setNumPages] = useState(null);

    function onDocumentLoadSuccess({ numPages }) {
        setNumPages(numPages);
    }
    return (
        <div>
            <iframe
                title="file"
                style={{ width: "100%", height: "800px" }}
                // src={require(`/lecture_sheet/${props.location.state.pdf}`)}
                src={`/lecture_sheet/${props.location.state.pdf}`}
            />
            {/* <Document
                file={props.location.state.pdf}
                options={{ workerSrc: "/pdf.worker.js" }}
                onLoadSuccess={onDocumentLoadSuccess}
            >
                {Array.from(new Array(numPages), (el, index) => (
                    <Page key={`page_${index + 1}`} pageNumber={index + 1} />
                ))}
            </Document> */}
            {/* <div className="controls">
                <p>
                    <button onClick={prevPage} disabled={pageNumber === 1}>
                        Previous Page
                    </button>
                    <span className="page-number">
                        Page {pageNumber} of {numPages}
                    </span>
                    <button
                        onClick={nextPage}
                        disabled={pageNumber === numPages}
                    >
                        Next Page
                    </button>
                </p>
            </div> */}
            {/* <Worker
                workerUrl="https://unpkg.com/pdfjs-dist@2.5.207/build/pdf.worker.min.js"
                >
                <div style={{ height: '750px' }}>
                    <Viewer fileUrl={props.location.state.pdf} />
                </div>
            </Worker> */}
            {/* <Worker workerUrl="https://unpkg.com/pdfjs-dist@2.5.207/build/pdf.worker.min.js">
                <div style={{ height: '750px' }}>
                    <Viewer fileUrl={props.location.state.pdf} />
                </div>
            </Worker> */}
        </div>
    );
};

export default PdfViewer;
