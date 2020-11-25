// Get all avialable question numbers
var questTot = $("div[class*='question']").length;
var questArr = Array(questTot);


function savePaper(paperid) {
    questTot = $("div[class*='question']").length;
    var questions = Array();
    for (let i = 1; i <= questTot; i++) {
        var questionId = (document.getElementsByClassName("question")[i - 1].id).substring(8);
        console.log(questionId);
        var quest = document.getElementById("quest" + questionId).value;
        var answer1 = document.getElementById("quest" + questionId + "ans1").value;
        var answer2 = document.getElementById("quest" + questionId + "ans2").value;
        var answer3 = document.getElementById("quest" + questionId + "ans3").value;
        var answer4 = document.getElementById("quest" + questionId + "ans4").value;
        var crctAns = document.getElementById("quest" + questionId + "crctansw").value;
        var question = [paperid, i, quest, answer1, answer2, answer3, answer4, crctAns];

        questions.push(question);

    }
    console.log(questions);
    $.post('savepaper.php', {
            questions: questions
        },
        function(response) {
            alert("Successfully edited");
            location.reload();
        });
}

function addQuestion() {
    var questTot = $("div[class*='question']").length + 1;
    const qstDiv = document.createElement("div");
    qstDiv.setAttribute("id", "question" + questTot);
    qstDiv.setAttribute("class", "question");

    const questioDiv = document.createElement("div");
    questioDiv.setAttribute("class", "quest");

    var h = document.createElement("H2");
    var t = document.createTextNode(questTot + ".")
    h.appendChild(t);
    var textarea = document.createElement("textarea");
    textarea.setAttribute("id", 'quest' + questTot);
    questioDiv.appendChild(h);
    questioDiv.appendChild(textarea);
    qstDiv.appendChild(questioDiv);

    // Answers 1
    var Numbers = ["I.", "II.", "III.", "IV.", "Correct Answer:"]
    var ids = ["ans1", "ans2", "ans3", "ans4", "crctansw"]
    for (let i = 0; i < Numbers.length; i++) {
        var normQuest = document.createElement("div");
        var h = document.createElement("H3");
        var t = document.createTextNode(Numbers[i])
        h.appendChild(t);
        var textarea = document.createElement("textarea");
        var textareaId = "quest" + questTot + ids[i];
        textarea.setAttribute("id", textareaId);
        normQuest.appendChild(h);
        normQuest.appendChild(textarea);
        qstDiv.appendChild(normQuest);
    }
    var delteBtn = document.createElement("button");
    var t = document.createTextNode("Delete")
    delteBtn.appendChild(t);
    delteBtn.setAttribute("onclick", "deleteQuest(" + questTot + ");");
    var delteBtnHolder = document.createElement("div");

    delteBtnHolder.appendChild(delteBtn);
    qstDiv.appendChild(delteBtnHolder);
    document.getElementById("questions").appendChild(qstDiv);
}

function deleteQuest(qno) {
    document.getElementById("question" + qno).remove();
}

function home() {
    // Simulate a mouse click:
    window.location.href = "index.php";
}