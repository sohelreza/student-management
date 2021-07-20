export default {
    uniqueText(length) {
        var randomChars =
            "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var result = "";

        for (var i = 0; i < length; i++) {
            result += randomChars.charAt(
                Math.floor(Math.random() * randomChars.length)
            );
        }

        return result;
    },

    // get the name of the day
    getTheDay(varDate) {
        let days = [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
        ];

        let d = new Date(varDate);
        let dayName = days[d.getDay()];

        return dayName;
    },

    // get the name of the Month
    getTheMonth(varDate) {
        let month = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];

        let d = new Date(varDate);
        let monthName = month[d.getMonth()];

        return monthName;
    },

    // get the date from a date input
    getTheDate(varDate) {
        let d = new Date(varDate);
        let onlyDate = d.getDate();

        return onlyDate;
    },

    // get the year from a date input
    getTheYear(varDate) {
        let d = new Date(varDate);
        let onlyYear = d.getFullYear();

        return onlyYear;
    }
};