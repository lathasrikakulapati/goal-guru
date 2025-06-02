




<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Learn - GoalGuru</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 20px;
      background-color: #fefefe;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    nav a {
      margin-left: 15px;
      text-decoration: none;
      font-weight: bold;
      color: #333;
    }
    nav a.active {
      color: black;
      border-bottom: 2px solid black;
    }
    select, button {
      padding: 10px;
      margin: 10px 0;
      border-radius: 8px;
      font-weight: bold;
    }
    #courseContent {
      background: #f9f9f9;
      padding: 20px;
      border-radius: 16px;
      margin-top: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    #courseContent h3 {
      font-size: 1.4em;
      color: #333;
      margin-bottom: 10px;
    }
    #courseContent ul {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 12px;
      padding: 0;
      list-style: none;
    }
    #courseContent ul li {
      background: #ffffff;
      border-radius: 10px;
      padding: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    #courseContent ul li:hover {
      transform: translateY(-2px);
      background-color: #e6f7ff;
    }
    #badgeSection img {
      width: 80px;
      height: 80px;
      margin-top: 10px;
    }
    .video-layout {
      display: flex;
      gap: 20px;
      margin-top: 20px;
    }
    .video-list {
      flex: 0 0 30%;
      background: #ffffff;
      border-radius: 10px;
      padding: 10px;
      overflow-y: auto;
      max-height: 400px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .video-list ul {
      padding: 0;
      list-style: none;
    }
    .video-list li {
      cursor: pointer;
      padding: 8px;
      border-bottom: 1px solid #ccc;
    }
    .video-list li:hover {
      background-color: #eee;
    }
    .video-player {
      flex: 1;
    }
     header {
    background-color: #f5e1d8;
    box-shadow: 0 4px 8px rgba(120, 72, 0, 0.2);
    border-radius: 16px;
    padding: 10px 30px; /* Reduced vertical padding */
    margin-bottom: 20px;
  }

  .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .logo {
    font-size: 24px; /* slightly smaller */
    color: #5c3b1e;
    font-weight: bold;
    letter-spacing: 1px;
    margin: 0;
  }

  .nav-links {
    display: flex;
    gap: 20px;
  }

  .nav-links a {
    text-decoration: none;
    color: #3a2c23;
    font-weight: 600;
    padding: 6px 10px; /* Reduced padding for links */
    border-radius: 6px;
    position: relative;
    transition: background-color 0.3s;
    font-size: 15px;
  }

  .nav-links a:hover {
    background-color: #e4c5b1;
  }

  .nav-links a.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 10px;
    width: 60%;
    height: 3px;
    background-color: #3a2c23;
    border-radius: 2px;
  }

  </style>
</head>
<body>
  <header class="navbar">
  <h1 class="logo">GOAL GURU</h1>
  <nav class="nav-links">
    <a href="dashboard.php">Home</a>
  
    <a href="learn.php" class="active">Learn</a>
    <a href="connect.php">Connect</a>
    <a href="profile.php">Profile</a>
     
        <a href="logout.php">Logout</a>
  </nav>
</header>


  <main>
    <h2>Select a Course</h2>
    <select id="courseSelect" onchange="selectCourse()">
      <option value="">-- Choose a Course --</option>
      <option value="Java">Java</option>
      <option value="HTML">HTML</option>
      <option value="CSS">CSS</option>
      <option value="JavaScript">JavaScript</option>
    </select>

    <div id="courseContent"></div>
    <div id="quizSection">
  <h3>Test your Knowledge</h3>
  <button onclick="startQuiz()">Take Quiz</button>
  <div id="quizContainer" style="display:none;"></div>
</div>

  </main>

<script>
 
  const data = {
    "Java": {
      schedule: [
        "Introduction", "Installation", "Syntax", "Output", "Comments",
        "Variables", "Data Types", "Type Casting", "Operators", "Strings"
      ],
      videos: [
        "t54pgbVy6t0", "zTEU-9kP66c", "VR9IZcPOijY", "BP3d7meXCmc", "mgWktMxvL7g",
        "YF59k3gZeb4", "D3DqJrlckbs", "kFUqkaicfDw", "RbjB3SIaabM", "SkKmN9k5_mY"
      ]
    },
    "HTML": {
      schedule: [
        "Introduction", "Editors", "Elements", "Attributes", "Headings",
        "Paragraphs", "Styles", "Formatting", "Comments", "Colors", "CSS",
        "Links", "Images", "Tables", "Lists", "Block and Inline", "Classes",
        "Id", "Iframes", "JavaScript", "Head", "Forms", "Bloopers"
      ],
      videos: [
        "it1rTvBcfRg", "bBP0ckEln4Y", "vIoO52MdZFE", "yMX901oVtn8", "9gHPpwq6IaY",
        "qis4kAOThLw", "twdNPJfbj_8", "7FqQLqNIEY8", "229HYq40vaA", "zCrolmdqmF8",
        "cZHp-Oozg6I", "HA6bByKdAQM", "FmoYRiepmOE", "e62D-aayveY", "-QuK8taGLCs",
        "M4n-WSkehmI", "tWIkDOJo0Ts", "rZ0k516qZmc", "qP23O70ve7k", "uSgcWDkwc3U",
        "WeuVX5x2MJE", "VLeERv_dR6Q", "HHxPoYUrSQ0"
      ]
    },
    "CSS": {
      schedule: [
        "Introduction", "Syntax", "Simple Selectors", "How to add CSS to HTML",
        "Comments", "Colors Introduction", "Colors RGB & RGBA", "Colors Hex",
        "Colors HSL", "Background Colors", "Background Images",
        "Background Repeat and Position", "Background Attachment",
        "Background Shorthand"
      ],
      videos: [
        "AGDDdsiZ0Ko", "G8r00ZNopTE", "ZNskBxLVOfs", "VSwaoQ3TFkQ", "uVtEJD3vBEs",
        "q0uWmobMf6I", "6tbUo6PXc88", "LLmCr_201GU", "Vilk0BFQZ4Y", "-itttmX6HX0",
        "FMyU_h8m-0c", "k9dNFtC2F8A", "lXs8BRnrW_M", "rSEKmi5tR9E"
      ]
    },
    "JavaScript": {
      schedule: [
        "Introduction", "Where to?", "Output", "Statements", "Syntax",
        "Comments", "Variables", "Let Keyword", "const Keyword", "Arithmetic Operators"
      ],
      videos: [
        "zofMnllkVfI", "W-3vp79-d3Y", "we8YhT-NiOA", "ZjotKN861EI", "4BBlc_qDs8g",
        "8yroEebhaEk", "7xStNKTM3bE", "-rpU6z9O88o", "8UjRPL3Foh0", "yEJ94pMiT-o"
      ]
    }
  };
const questions = {
  HTML: [
    { question: "What does HTML stand for?", options: ["HyperText Markup Language", "Home Tool Markup Language", "Hyperlinks and Text Markup Language", "Hyperlinking Text Management Language"], correct: 0 },
    { question: "Which tag is used to create a hyperlink?", options: ["<link>", "<a>", "<href>", "<hyperlink>"], correct: 1 },
    { question: "What is the correct HTML element for inserting a line break?", options: ["<break>", "<br>", "<lb>", "<line>"], correct: 1 },
    { question: "Which attribute is used to specify alternate text for an image?", options: ["alt", "title", "src", "longdesc"], correct: 0 },
    { question: "Which tag is used for the largest heading?", options: ["<head>", "<h1>", "<heading>", "<h6>"], correct: 1 },
    { question: "Which tag is used to insert an image in HTML?", options: ["<pic>", "<image>", "<img>", "<src>"], correct: 2 },
    { question: "Which HTML element is used to define emphasized text?", options: ["<italic>", "<em>", "<i>", "<strong>"], correct: 1 },
    { question: "Which doctype declaration is correct for HTML5?", options: ["<!DOCTYPE html>", "<!DOCTYPE HTML5>", "<!DOCTYPE>", "<!html>"], correct: 0 },
    { question: "What is the purpose of the <head> tag in HTML?", options: ["To define header section of the page", "To contain meta-information about the document", "To include header elements", "To store main content"], correct: 1 },
    { question: "Which tag is used to create a table row in HTML?", options: ["<td>", "<tr>", "<th>", "<table>"], correct: 1 }
  ],
  CSS: [
    { question: "What does CSS stand for?", options: ["Cascading Style Sheets", "Colorful Style Sheets", "Computer Style Sheets", "Creative Style Sheets"], correct: 0 },
    { question: "Which HTML tag is used to link an external CSS file?", options: ["<css>", "<style>", "<link>", "<stylesheet>"], correct: 2 },
    { question: "Which property is used to change the background color?", options: ["color", "bgcolor", "background", "background-color"], correct: 3 },
    { question: "How do you select an element with the id 'main'?", options: [".main", "#main", "main", "*main"], correct: 1 },
    { question: "Which property is used to change the text color of an element?", options: ["font-color", "text-color", "color", "foreground-color"], correct: 2 },
    { question: "What is the default position of an HTML element?", options: ["absolute", "relative", "static", "fixed"], correct: 2 },
    { question: "Which property controls the size of text?", options: ["font-style", "text-size", "font-size", "text-style"], correct: 2 },
    { question: "How do you make a list not display bullet points?", options: ["list-style-type: none", "text-decoration: none", "display: block", "list-type: none"], correct: 0 },
    { question: "How can you apply the same styles to multiple classes?", options: [".class1, .class2", ".class1.class2", "#class1, #class2", "class1 class2"], correct: 0 },
    { question: "Which CSS unit is relative to the font-size of the element?", options: ["px", "em", "%", "cm"], correct: 1 }
  ],
  JavaScript: [
    { question: "What is the correct syntax for referring to an external script called 'app.js'?", options: ["<script src='app.js'>", "<script href='app.js'>", "<script ref='app.js'>", "<script file='app.js'>"], correct: 0 },
    { question: "Which keyword is used to declare a variable in JavaScript?", options: ["int", "var", "let", "Both 'var' and 'let'"], correct: 3 },
    { question: "What will `typeof NaN` return?", options: ["number", "NaN", "undefined", "object"], correct: 0 },
    { question: "How do you write a comment in JavaScript?", options: ["<!-- comment -->", "// comment", "# comment", "** comment **"], correct: 1 },
    { question: "Which method is used to add a new element at the end of an array?", options: ["push()", "add()", "append()", "insert()"], correct: 0 },
    { question: "What is the output of `3 + '3'`?", options: ["6", "33", "Error", "undefined"], correct: 1 },
    { question: "Which company developed JavaScript?", options: ["Netscape", "Microsoft", "Oracle", "Sun Microsystems"], correct: 0 },
    { question: "Which symbol is used for single-line comments?", options: ["//", "/*", "#", "<!--"], correct: 0 },
    { question: "Which function converts a string to an integer?", options: ["parseInt()", "parseFloat()", "Number()", "convert()"], correct: 0 },
    { question: "Which event occurs when the user clicks on an HTML element?", options: ["onchange", "onmouseclick", "onmouseover", "onclick"], correct: 3 }
  ]
,

Java: [
  { question: "Which keyword is used to create a class in Java?", options: ["class", "Class", "define", "struct"], correct: 0 },
  { question: "What is the size of an `int` variable in Java?", options: ["2 bytes", "4 bytes", "8 bytes", "Depends on system"], correct: 1 },
  { question: "Which method is the entry point of a Java program?", options: ["start()", "main()", "run()", "init()"], correct: 1 },
  { question: "Which keyword is used to inherit a class in Java?", options: ["this", "super", "import", "extends"], correct: 3 },
  { question: "Which access modifier makes a member accessible only within its own class?", options: ["public", "private", "protected", "default"], correct: 1 },
  { question: "What is the output of `System.out.println(3 + 4 + \"Java\")`?", options: ["7Java", "34Java", "Java7", "Java34"], correct: 0 },
  { question: "Which operator is used to compare two values?", options: ["=", "==", "!=", "equals"], correct: 1 },
  { question: "Which collection class stores elements in key-value pairs?", options: ["List", "Set", "Map", "Queue"], correct: 2 },
  { question: "Which exception is thrown when a program divides by zero?", options: ["ArithmeticException", "NullPointerException", "IOException", "ArrayIndexOutOfBoundsException"], correct: 0 },
  { question: "Which of the following is not a primitive data type in Java?", options: ["int", "String", "boolean", "double"], correct: 1 }
]


  };

 function selectCourse() {
  const selectedCourse = document.getElementById("courseSelect").value;
  const courseContainer = document.getElementById("courseContent");

  if (!data[selectedCourse]) {
    courseContainer.innerHTML = "<p>Please select a valid course.</p>";
    return;
  }

  const { schedule, videos } = data[selectedCourse];

  let scheduleHTML = "<h3>Course Schedule:</h3><ul>";
  schedule.forEach(item => {
    scheduleHTML += `<li>${item}</li>`;
  });
  scheduleHTML += "</ul>";

  let videosHTML = `
    <div class="video-layout">
      <div class="video-list"><h3>Video Lessons</h3><ul>`;
  schedule.forEach((title, i) => {
    videosHTML += `<li onclick="playVideo('${videos[i]}')">${title}</li>`;
  });
  videosHTML += `</ul></div>
      <div class="video-player">
        <iframe id="videoFrame" width="560" height="315" src="https://www.youtube.com/embed/${videos[0]}" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>`;

  courseContainer.innerHTML = scheduleHTML + videosHTML;
}
  function startCourse(course) {
    const courseData = data[course];
    let layout = `
      <div class="video-layout">
        <div class="video-list">
          <ul>
            ${courseData.schedule.map((topic, index) => `<li onclick="playVideo('${courseData.videos[index]}')">${topic}</li>`).join('')}
          </ul>
        </div>
        <div class="video-player">
          <iframe id="videoFrame" width="100%" height="400" src="https://www.youtube.com/embed/${courseData.videos[0]}" allowfullscreen></iframe>
        </div>
      </div>
      <h3>Assignment</h3>
      <form id="quizForm"></form>
      <button onclick="generateQuiz('${course}');">Submit Assignment</button>
      <button id="submitAnswers" style="display:none;" onclick="checkAnswers('${course}'); return false;">Check Answers</button>
      <div id="result"></div>
      <div id="badgeSection"></div>
    `;
    document.getElementById("splitLayout").innerHTML = layout;
  }

  function playVideo(videoId) {
  document.getElementById("videoFrame").src = `https://www.youtube.com/embed/${videoId}`;
}
function startQuiz() {
  const selectedCourse = document.getElementById("courseSelect").value;
  const quizData = questions[selectedCourse];

  if (!quizData) {
    alert("No questions available for this course.");
    return;
  }

  let quizHTML = "<form id='quizForm'>";
  quizData.forEach((q, i) => {
    quizHTML += `<p>${i + 1}. ${q.question}</p>`;
    q.options.forEach((opt, j) => {
      quizHTML += `<input type="radio" name="q${i}" value="${j}" required> ${opt}<br>`;
    });
  });
  quizHTML += `<br><button type="submit">Submit Quiz</button></form>`;
  document.getElementById("quizContainer").innerHTML = quizHTML;
  document.getElementById("quizContainer").style.display = "block";

  document.getElementById("quizForm").onsubmit = function (e) {
    e.preventDefault();
    let score = 0;
    quizData.forEach((q, i) => {
      const selected = document.querySelector(`input[name=q${i}]:checked`);
      if (selected && parseInt(selected.value) === q.correct) {
        score++;
      }
    });

    const percentage = (score / quizData.length) * 100;
    alert(`You scored ${percentage.toFixed(2)}%`);

    if (percentage >= 80) {
      // Save success to localStorage (you can later fetch this in profile.html)
      sendScore(selectedCourse, Math.round(percentage));

      localStorage.setItem(`${selectedCourse}_completed`, "true");
      alert(`Great! Your progress in ${selectedCourse} has been saved to your profile.`);
    }
  };
}


  function generateQuiz(course) {
    const form = document.getElementById("quizForm");
    const quizData = questions[course];
    if (!quizData) {
      form.innerHTML = "<p>No questions available for this course.</p>";
      return;
    }
    let quizHTML = "";
    quizData.forEach((q, i) => {
      quizHTML += `<div class="question"><p><strong>Q${i+1}. ${q.question}</strong></p>`;
      q.options.forEach((opt, j) => {
        quizHTML += `<div class="options"><label><input type="radio" name="q${i}" value="${j}"> ${opt}</label></div>`;
      });
      quizHTML += `</div>`;
    });
    form.innerHTML = quizHTML;
    document.getElementById("submitAnswers").style.display = "inline-block";
  }

  function checkAnswers(course) {
    const quizData = questions[course];
    let score = 0;
    quizData.forEach((q, i) => {
      const answer = document.querySelector(`input[name="q${i}"]:checked`);
      if (answer && parseInt(answer.value) === q.correct) score++;
    });
    const percentage = (score / quizData.length) * 100;
    const result = document.getElementById("result");
    result.innerHTML = `You scored ${score} out of ${quizData.length} (${percentage.toFixed(2)}%)`;

    if (percentage >= 80) {
      showBadge();
    }
  }

  function showBadge() {
    const badgeSection = document.getElementById("badgeSection");
    badgeSection.innerHTML = `
      <p>🎉 Congratulations! You've completed the course with 80%+!</p>
      <img src="https://img.icons8.com/color/96/000000/medal.png" alt="Badge"/>
    `;
  }
function sendScore(course, score) {
  fetch('save_score.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({ course: course, score: Math.round(score) })
})

  .then(response => response.text())
  .then(result => {
    alert(result);
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

</script>
</body>
</html>

 
