"use strict";
/*jshint esversion: 6 */

(function() {
    window.k5.date = {
        secondsToHour: function(seconds) {
            let date = new Date(null);
            date.setSeconds(seconds);
            return date.toISOString().substr(11, 8);
        },
        getDates: function (startDate, stopDate, days=1) {
            var dateArray = new Array();
            var currentDate = startDate;
            while (currentDate <= stopDate) {
                dateArray.push(new Date (currentDate));
                currentDate = currentDate.addDays(days);
            }
            return dateArray;
        },
        isDayOfWeek: function (strTime,dayOfWeek=0) {
            var dt = new Date(strTime);

            if(dt.getDay() === dayOfWeek)
            {
                return true;
            } else {
                return false;
            }
        },
        getDateOfWeek: function (w, y) {
            var d = (1 + (w - 1) * 7); // 1st of January + 7 days for each week
            return new Date(y, 0, d);
        },
        getMondayOfCurrentWeek: function (d) {
            var day = d.getDay();
            return new Date(d.getFullYear(), d.getMonth(), d.getDate() + (day == 0?-6:1)-day );
        },
        getSundayOfCurrentWeek: function (d) {
            var day = d.getDay();
            return new Date(d.getFullYear(), d.getMonth(), d.getDate() + (day == 0?0:7)-day );
        },
        getAvailableHeight: function (topBarId) {
            var top_nav_height = $("#"+topBarId).height();
            var window_height = $(window).height();

            var height_of_open_space = window_height - (top_nav_height);
            return height_of_open_space;
        },
        getWeekNumber: function (d) {
            // Copy date so don't modify original
            d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
            // Set to nearest Thursday: current date + 4 - current day number
            // Make Sunday's day number 7
            d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
            // Get first day of year
            var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
            // Calculate full weeks to nearest Thursday
            var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
            // Return array of year and week number
            return [d.getUTCFullYear(), weekNo];
        },
        getYearStartAndEndUnixTimestamps : function (year) {
            // Create date objects for the start and end of the given year
            const firstDayOfYear = new Date(year, 0, 1); // January 1st
            const lastDayOfYear = new Date(year + 1, 0, 0); // December 31st (end of year)

            // Set times to the first minute of the start day (00:00:00) and last minute of the last day (23:59:59)
            const yearStart = new Date(year, 0, 1, 0, 0, 0);
            const yearEnd = new Date(year, 11, 31, 23, 59, 59);

            // Convert to Unix timestamps (seconds since epoch)
            const yearStartUnixTimestamp = Math.floor(yearStart.getTime() / 1000);
            const yearEndUnixTimestamp = Math.floor(yearEnd.getTime() / 1000);

            return {
                dateStart: yearStartUnixTimestamp,
                dateEnd: yearEndUnixTimestamp
            };
        },
        getQuarterStartAndEndDates : function (now,manuplate=0) {
            var quarter = 0;
            if(manuplate !== 0) {
                quarter = Math.floor((now.getMonth() / 3))+manuplate;
            } else {
                quarter = Math.floor((now.getMonth() / 3));
            }

            const firstDay = new Date(now.getFullYear(), quarter * 3, 1);
            const lastDay = new Date(firstDay.getFullYear(), firstDay.getMonth() + 3, 0);

            const quarterStart = new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate(), 0, 0, 0);
            const quarterEnd = new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate(), 23, 59, 59);

            return {
                dateStart: Math.floor(quarterStart.getTime() / 1000),
                dateEnd: Math.floor(quarterEnd.getTime() / 1000)
            };
        },
        getUnixTimestamps: function (dateInput) {
            const date = new Date(dateInput);

            // Set start of the day (hours, minutes, seconds, and milliseconds to 0)
            const startOfDay = new Date(date);
            startOfDay.setHours(0, 0, 0, 0);

            // Set end of the day (hours to 23, minutes to 59, seconds to 59, milliseconds to 999)
            const endOfDay = new Date(date);
            endOfDay.setHours(23, 59, 59, 999);

            return {
                dateStart: Math.floor(startOfDay.getTime() / 1000),
                dateEnd: Math.floor(endOfDay.getTime() / 1000)
            };
        },
        getCurrentYearAndWeek : function() {
            const now = new Date();

            // Get the first day of the year
            const startOfYear = new Date(now.getFullYear(), 0, 1);

            // Calculate the day of the week for January 1st (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
            let dayOfWeek = startOfYear.getDay();
            const daysToFirstMonday = dayOfWeek === 0 ? 1 : (8 - dayOfWeek) % 7;

            // Move startOfYear to the first Monday of the year
            startOfYear.setDate(startOfYear.getDate() + daysToFirstMonday);

            // Calculate the difference in days and weeks
            const dayDifference = Math.floor((now - startOfYear) / (24 * 60 * 60 * 1000));
            const weekNumber = Math.ceil((dayDifference + 1) / 7);

            return { year: now.getFullYear(), week: weekNumber };
        },
        getWeekStartEndInSeconds: function (year, weekNumber) {
            // Start from January 1st of the given year
            const jan1 = new Date(year, 0, 1);

            // Calculate the number of days to add to reach the given week, with Monday as the start of the week
            const daysToAdd = (weekNumber - 1) * 7;

            // Calculate the difference to the first Monday of the year
            const jan1Day = jan1.getDay();
            const daysToMonday = (jan1Day === 0 ? 1 : 8 - jan1Day);

            // Set the date to the start of the given week
            const startOfWeek = new Date(year, 0, 1 + daysToMonday + daysToAdd);
            startOfWeek.setHours(0, 0, 0, 0);
            const startTimestamp = Math.floor(startOfWeek.getTime() / 1000);

            // Set the date to the end of the given week (Sunday at 23:59:59)
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);
            endOfWeek.setHours(23, 59, 59, 999);
            const endTimestamp = Math.floor(endOfWeek.getTime() / 1000);
            return {
                dateStart: startTimestamp,
                dateEnd: endTimestamp
            };
        },
        getWeekStartAndEndTimestamps : function (weekInput,_alert="Lütfen bir hafta belirtin") {
            if (!weekInput) {
                alert(_alert);
                console.log("Please select a week.");
                return;
            }

            const [year, week] = weekInput.split('-W');
            const firstDayOfYear = new Date(Date.UTC(year, 0, 1));
            const daysOffset = (firstDayOfYear.getUTCDay() <= 4 ? 1 : 8) - firstDayOfYear.getUTCDay();
            const firstThursday = new Date(Date.UTC(year, 0, 1 + daysOffset));

            const weekStart = new Date(firstThursday);
            weekStart.setUTCDate(firstThursday.getUTCDate() - firstThursday.getUTCDay() + 1 + (week - 1) * 7);
            weekStart.setUTCHours(0, 0, 0, 0);

            const weekEnd = new Date(weekStart);
            weekEnd.setUTCDate(weekStart.getUTCDate() + 6);
            weekEnd.setUTCHours(23, 59, 59, 999);

            const startTimestamp = Math.floor(weekStart.getTime() / 1000);
            const endTimestamp = Math.floor(weekEnd.getTime() / 1000);

            return {
                dateStart: startTimestamp,
                dateEnd: endTimestamp
            };
        },
        getMonthStartAndEndTimestamps : function (monthInput,_alert ="Lütfen bir ay belirtin") {
            if (!monthInput) {
                alert(_alert);
                console.log("Please select a month.");
                return;
            }

            let startDate = new Date(monthInput);
            startDate.setDate(1);
            startDate.setHours(0, 0, 0, 0);

            // Create a Date object for the last day of the month
            let endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + 1);
            endDate.setDate(0);
            endDate.setHours(23, 59, 59, 999);

            // Convert to Unix timestamps
            let startTimestamp = Math.floor(startDate.getTime() / 1000);
            let endTimestamp = Math.floor(endDate.getTime() / 1000);

            return {
                dateStart: startTimestamp,
                dateEnd: endTimestamp
            };
        },
        formatMonthDate : function (date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
            return `${year}-${month}`;
        },
    };
})();


