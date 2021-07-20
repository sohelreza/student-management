export default {
    requiredField(x) {
        if (x === "first_name") {
            return "First Name is Required";
        } else if (x === "last_name") {
            return "Last Name is Required";
        } else if (x === "mobileNumber") {
            return "Mobile Number is Required";
        } else if (x === "std_type") {
            return "Please Select A Type";
        } else if (x === "branch") {
            return "Please Select A Branch";
        } else if (x === "class") {
            return "Please Select A Class";
        } else if (x === "batch") {
            return "Please Select A Batch";
        } else if (x === "checkedItems") {
            return "Please Select A Subject";
        }
    }
};