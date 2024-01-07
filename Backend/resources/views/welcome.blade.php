<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f5f5f5;
            overflow: hidden;
        }

        #question-container {
            position: relative;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        p {
            margin: 0;
            padding: 5px;
        }

        .train {
            position: absolute;
            width: 100px;
            height: 50px;
            background-color: #3498db;
            animation: moveTrain 5s linear infinite;
            cursor: pointer;
        }

        .hidden-word {
            position: absolute;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            font-weight: bold;
            color: #2ecc71;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        @keyframes moveTrain {
            0% {
                left: -100px;
            }
            100% {
                left: 100%;
            }
        }

        .train:hover + .hidden-word {
            opacity: 1;
        }

        audio {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div id="question-container">
        <div class="train"></div>
        <div class="hidden-word">Hello, World!</div>
        <!-- Question data will be displayed here -->
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Wait for the DOM to be fully loaded before making the request
            fetch('http://10.126.77.252:8000/api/auth/question')
                .then(response => response.json())
                .then(data => displayQuestion(data.data))
                .catch(error => console.error('Error fetching question:', error));

            function displayQuestion(questionData) {
                const questionContainer = document.getElementById('question-container');

                // Create HTML elements to display the question data
                const wordParagraph = document.createElement('p');
                wordParagraph.textContent = 'Word: ' + questionData.word;

                const answerParagraph = document.createElement('p');
                answerParagraph.textContent = 'Answer: ' + questionData.answer.join(', ');

                const correctAnswerParagraph = document.createElement('p');
                correctAnswerParagraph.textContent = 'Correct Answer: ' + questionData.correct_answer;

                const audioElement = document.createElement('audio');
                audioElement.controls = true;
                audioElement.innerHTML = `<source src="/assets/audio_files/${questionData.audioFile}" type="audio/mp3">Your browser does not support the audio element.`;

                // Append the elements to the question container
                questionContainer.appendChild(wordParagraph);
                questionContainer.appendChild(answerParagraph);
                questionContainer.appendChild(correctAnswerParagraph);
                questionContainer.appendChild(audioElement);
            }
        });
    </script>
</body>
</html>
