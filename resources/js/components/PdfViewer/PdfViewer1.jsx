import React, { Component } from "react";

import ReactDOM from "react-dom";
import { Document, Page, pdfjs } from "react-pdf/dist/esm/entry.webpack";
// import 'react-pdf/dist/esm/Page/AnnotationLayer.css';
// // import './Sample.less';
// // pdfjs.GlobalWorkerOptions.workerSrc =
// //     `//cdnjs.cloudflare.com/ajax/libs/pdf.js/${pdfjs.version}/pdf.worker.js`;
// const options = {
//     cMapUrl: 'cmaps/',
//     cMapPacked: true,
// };
// import { Worker } from '@react-pdf-viewer/core';
// import { Viewer } from '@react-pdf-viewer/core';

// Plugins
// import { defaultLayoutPlugin } from '@react-pdf-viewer/default-layout';

// Import styles
// import '@react-pdf-viewer/core/lib/styles/index.css';
// import '@react-pdf-viewer/default-layout/lib/styles/index.css';

// Create new plugin instance
// const defaultLayoutPluginInstance = defaultLayoutPlugin();

class PdfViewer extends Component {
    constructor(props) {
        super(props);
        pdfjs.GlobalWorkerOptions.workerSrc = `//cdnjs.cloudflare.com/ajax/libs/pdf.js/${pdfjs.version}/pdf.worker.js`;
        this.state = {
            numPages: null,
            pageNumber: 1
        };
        // console.log(this.props)
    }

    onDocumentLoadSuccess(numPages) {
        this.setState({ numPages });
    }
    // const { pdf } = props;
    render() {
        const { file, numPages } = this.state;
        // const  pdf  = JSON.stringify(this.props.location.state.pdf);
        const pdf = this.props.location.state.pdf;
        // let  pdf  = '../../../../public/content/'+this.props.location.state.pdf;
        // var url = "https://docs.google.com/viewerng/viewer?url="+this.props.location.state.pdf+"&embedded=true";
        return (
            <div className="Example">
                <div className="Example__container__document">
                    {console.log(pdf)}
                    <Document
                        file={pdf}
                        options={{ workerSrc: "/pdf.worker.js" }}
                        onLoadSuccess={this.onDocumentLoadSuccess.bind(this)}
                    >
                        <Page pageNumber={this.state.pageNumber} />
                    </Document>
                </div>
                <p>
                    Page {this.state.pageNumber} of {this.state.numPages}
                </p>
            </div>
            // <div className="">
            //     <Worker workerUrl="https://unpkg.com/pdfjs-dist@2.5.207/build/pdf.worker.min.js">

            //         <Viewer

            //             fileUrl={pdf}
            //             // plugins={[
            //             //     // Register plugins
            //             //     defaultLayoutPluginInstance,
            //             // ]}
            //         />
            //     </Worker>
            // </div>
            //             <div className="">
            // {console.log(url)}
            //                 <iframe style={this.props.style} src={url}></iframe>
            //             </div>
        );
    }
}

export default PdfViewer;
