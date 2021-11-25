TimeMe.startTimer("my-activity");
window.onbeforeunload = function (event) {
	var timeSpentOnPage = TimeMe.getTimeOnPageInSeconds("my-activity");
    var sendData = {
        time: timeSpentOnPage,
        page: window.location.pathname
    };
    $.request('onSetTime', {
        data: sendData
    })
};