document.getElementById("location").onclick = otherLocation;
document.getElementById("question").onclick = otherQuestion;
document.getElementById("incidentReport").onclick = incidentReport;
window.onload = loadOtherBoxes;
//document.getElementById("formpg").onsubmit = submissionResults;


//This function will show other location textbox if "other" selected from dropdown
function otherLocation() {
    let location = document.getElementById("location");
    let selectedValue = location.options[location.selectedIndex].value;
    let otherLocationDiv = document.getElementById("otherLocation");
    if (selectedValue === "other") {
        otherLocationDiv.classList.remove("d-none");
    } else {
        otherLocationDiv.classList.add("d-none");
    }
}

//This function will show other question textbox if "other" is selected from dropdown
function otherQuestion() {
    let question = document.getElementById("question");
    let selectedValue = question.options[question.selectedIndex].value;
    let otherQuestionDiv = document.getElementById("otherQuestion");
    if (selectedValue === "other") {
        otherQuestionDiv.classList.remove("d-none");
    } else {
        otherQuestionDiv.classList.add("d-none");
    }
}

//This function will load the "other" boxes if there is text in them and "other" is selected in the dropdown
function loadOtherBoxes() {
    let location = document.getElementById("location");
    let selectedValueLocation = location.options[location.selectedIndex].value;
    let otherLocationDiv = document.getElementById("otherLocation");
    if (selectedValueLocation === "other") {
        if (otherLocationDiv !== "") {
            otherLocationDiv.classList.remove("d-none");
        }
    }

    let question = document.getElementById("question");
    let selectedValueQuestion = question.options[question.selectedIndex].value;
    let otherQuestionDiv = document.getElementById("otherQuestion");
    if (selectedValueQuestion === "other") {
        if (otherQuestionDiv !== "") {
            otherQuestionDiv.classList.remove("d-none");
        }
    }
}

//This function will show incident number textbox if incident report is checked
function incidentReport() {

    let incReport = document.getElementById("incidentReport");
    let incNumDiv = document.getElementById("incNumDiv");

    incNumDiv.classList.remove("d-none");
    if (!incReport.checked) {
        incNumDiv.classList.add("d-none");
    }
}

//Repopulates form page with submission results
function submissionResults() {
    document.getElementById("formpg").classList.add("d-none");
    document.getElementById("submitted-form").classList.remove("d-none");
}