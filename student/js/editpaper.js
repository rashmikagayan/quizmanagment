// Get all avialable question numbers
var questTot = $("div[class*='question']").length;

function savePaper(paperid, studentId) {
    var answers = Array();

    console.log(questTot);


    for (let i = 1; i <= questTot; i++) {
        var answer = 0;
        for (let j = 1; j <= 4; j++) {
            var qid = i + '' + j;
            if (document.getElementById(qid).checked == true) {
                answer = j;
            }
        }
        var answer = [i, answer];
        answers.push(answer);
    }
    var submittionData = [paperid, studentId];

    console.log(answers);
    console.log(submittionData);
    $.post('submitpaper.php', {
            answers: answers,
            submit: submittionData
        },
        function(response) {
            alert("Successfully edited");
            location.reload();
        });
}

function home() {
    // Simulate a mouse click:
    window.location.href = "index.php";
}