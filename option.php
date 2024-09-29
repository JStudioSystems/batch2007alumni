<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Batch 2007 Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Your existing styles... */
        @keyframes starAnim {
            0% { transform: translate(0, 0); }
            100% { transform: translate(1000px, 500px); }
        }
        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: starAnim 50s linear infinite;
            opacity: 0.5;
        }
        .glass {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: transform 0.5s ease;
        }
        .galaxy-bg {
            background: radial-gradient(circle, rgba(34, 34, 34, 1) 0%, rgba(0, 0, 0, 1) 100%);
            overflow: hidden;
            position: relative;
            height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center bg-black galaxy-bg">

<h1 class="text-4xl font-bold text-white mb-10 text-center">Are you joining this year's Alumni Homecoming?</h1>

<div class="glass max-w-sm w-full p-8 text-center">
    <h2 class="text-2xl font-semibold text-white mb-6">Please let us know</h2>

    <form id="alumniForm" class="space-y-4">
        <div>
            <input type="text" name="fullName" placeholder="Full Name" class="w-full px-4 py-2 bg-transparent border border-gray-300 rounded-lg text-white placeholder-gray-500" required>
        </div>
        <div>
            <select name="section" class="w-full px-4 py-2 bg-transparent border border-gray-300 rounded-lg text-white" required>
                <option class="bg-transparent text-black" value="" disabled selected>Select your section</option>
                <option class="bg-transparent text-black" value="Aphrodite">Aphrodite</option>
                <option class="bg-transparent text-black" value="Minerva">Minerva</option>
                <option class="bg-transparent text-black" value="Jupiter">Jupiter</option>
            </select>
        </div>
        <div>
            <input type="text" name="contactNumber" placeholder="Contact Number" class="w-full px-4 py-2 bg-transparent border border-gray-300 rounded-lg text-white placeholder-gray-500">
        </div>

        <div>
            <button type="submit" name="decision" value="joining" class="w-full bg-gradient-to-r from-yellow-300 via-green-500 to-yellow-300 text-white px-4 py-2 rounded-lg">Yes I am joining</button>
        </div>

        <div>
            <button type="submit" name="decision" value="contributing" class="w-full bg-gradient-to-r from-blue-300 via-teal-500 to-blue-300 text-white px-4 py-2 rounded-lg">I cannot join but I want to contribute</button>
        </div>

        <div>
            <button type="submit" name="decision" value="not_joining" class="w-full bg-gradient-to-r from-red-500 via-orange-500 to-red-500 text-white px-4 py-2 rounded-lg">Sorry, I can't</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('alumniForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent the form from reloading the page

        const formData = new FormData(event.target);
        const data = {
            fullName: formData.get('fullName'),
            section: formData.get('section'),
            contactNumber: formData.get('contactNumber'),
            decision: formData.get('decision')
        };

        // Fetch existing file to get its SHA (required for updating)
        const fileResponse = await fetch('https://api.github.com/repos/JStudioSystems/batch2007alumni/contents/details.json', {
            headers: {
                'Authorization': 'token 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'
            }
        });
        const fileData = await fileResponse.json();
        const sha = fileData.sha; // Get the SHA of the current file for updates

        // Add new data to the existing content
        const existingContent = JSON.parse(atob(fileData.content));
        existingContent.push(data); // Append new data to the existing content

        // Base64 encode the updated content
        const updatedContent = btoa(JSON.stringify(existingContent));

        // Push the updated content back to GitHub
        fetch("https://api.github.com/repos/JStudioSystems/batch2007alumni/contents/details.json", {
            method: "PUT",
            headers: {
                "Authorization": "token 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",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                message: "Add new registration data",
                content: updatedContent,
                sha: sha // Required when updating an existing file
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.commit) {
                alert('Registration successful!');
            } else {
                alert('Error saving data');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving data');
        });
    });

    function createStars() {
        const starField = document.querySelector('.galaxy-bg');
        for (let i = 0; i < 100; i++) {
            const star = document.createElement('div');
            const size = Math.random() * 3 + 1;
            star.style.width = `${size}px`;
            star.style.height = `${size}px`;
            star.style.top = `${Math.random() * 100}vh`;
            star.style.left = `${Math.random() * 100}vw`;
            star.className = 'star';
            starField.appendChild(star);
        }
    }

    createStars();
</script>

</body>
</html>
