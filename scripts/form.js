document.getElementById("location").onclick = otherLocation;
document.getElementById("question").onclick = otherQuestion;
document.getElementsByName("incidentReport").onclick = incidentReport;


//This function will show other location textbox if "other" selected from dropdown
function otherLocation() {
    let location = document.getElementById("location");
    let selectedValue = location.options[location.selectedIndex].value;
    let otherLocationDiv = document.getElementById("otherLocation");
    if (selectedValue === "otherLocation") {
        otherLocationDiv.classList.remove("d-none");
    }
    else {
        otherLocationDiv.classList.add("d-none");
    }
}

//This function will show other question textbox if "other" is selected from dropdown
function otherQuestion() {
    let question = document.getElementById("question");
    let selectedValue = question.options[question.selectedIndex].value;
    let otherQuestionDiv = document.getElementById("otherQuestion");
    if (selectedValue === "otherQuestion") {
        otherQuestionDiv.classList.remove("d-none");
    }
    else {
        otherQuestionDiv.classList.add("d-none");
    }
}

//This function will show incident number textbox if "yes" for incident reports is checked
function incidentReport() {
    alert("fgh");
    let incReport = document.getElementsByName("incidentReport");
    let incNumDiv = document.getElementById("incNumDiv");
    for (let i=0; i < incReport.length; i++) {
        if (incReport[i].checked) {
            if (incReport[i].value === "yes") {
                incNumDiv.classList.remove("d-none");
            }
            else {
                incNumDiv.classList.add("d-none");
            }
        }
    }
}