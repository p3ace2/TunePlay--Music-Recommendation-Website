    // Store the survey state
    let surveyResponse = {
        selectedGenre: '',
        selectedArtists: [],
        selectedYear: ''
    };

    // Artists List By genre
    const artistsByGenre = {
        'Pop': ['Taylor Swift', 'Ed Sheeran', 'Ariana Grande', 'Justin Bieber', 'Lady Gaga', 'The Weeknd', 'Adele', 'Harry Styles', 'Dua Lipa', 'Bruno Mars'],

        'Hip Hop': ['Drake', 'Kendrick Lamar', 'J. Cole', 'Travis Scott', 'Eminem', 'Post Malone', 'Cardi B', 'Megan Thee Stallion', 'Tyler The Creator', 'Kanye West'],

        'Afrobeats': ['Wizkid', 'Burna Boy', 'Davido', 'Tems', 'Rema', 'Fireboy DML', 'Asake', 'Ayra Starr', 'Omah Lay', 'CKay'],

        'R&B': ['The Weeknd', 'H.E.R.', 'SZA', 'Chris Brown', 'Beyonce', 'John Legend', 'Usher', 'Frank Ocean', 'Daniel Caesar', 'Summer Walker'],

        'Rock': ['Foo Fighters', 'Red Hot Chili Peppers', 'Green Day', 'Imagine Dragons', 'AC/DC', 'Queen', 'The Beatles', 'Led Zeppelin', 'Pink Floyd', 'Nirvana'],

        'Country': ['Luke Combs', 'Morgan Wallen', 'Blake Shelton', 'Carrie Underwood', 'Luke Bryan', 'Miranda Lambert', 'Chris Stapleton', 'Keith Urban', 'Thomas Rhett', 'Eric Church'],

        'Metal': ['Metallica', 'Iron Maiden', 'Black Sabbath', 'Slayer', 'Megadeth', 'System of a Down', 'Rammstein', 'Tool', 'Pantera', 'Slipknot']
    };

    function selectGenre(genre) {
        if (surveyResponse.selectedGenre !== genre);{
            surveyResponse.selectedArtists = [];
        }
        
        surveyResponse.selectedGenre= genre;
        
        
        document.querySelectorAll('.optionButton1').forEach(button => {
            button.classList.remove('selected');
            if (button.textContent === genre) {
                button.classList.add('selected');
            }
        });

        // Show Navigation Buttons When Question is Completed
        document.getElementById('nextButton').style.display = 'block';
        document.getElementById('homeButton').style.display = 'block';
    }

    // Function to Display Artists Based on Selected Genre
    function displayArtists() {
        if (!surveyResponse.selectedGenre) {
            alert("Please select a genre first.");
            return;
        }

        // Hides First Question and Displays Artist Question
        document.getElementById('genreQuestion').style.display = 'none';
        const artistQuestion = document.getElementById('artistQuestion');
        artistQuestion.style.display = 'block';

        
        artistQuestion.querySelector('label').textContent = 
            `Select your top 3 favorite ${surveyResponse.selectedGenre} artists:`;

        // Display artist options
        const artistButtons = document.getElementById('artistButtons');
        artistButtons.innerHTML = '';
        
        artistsByGenre[surveyResponse.selectedGenre].forEach(artist => {
            const button = document.createElement('button');
            button.className = 'optionButton1';
            button.textContent = artist;
            
            // Check if this artist is already in the selected list and mark it as selected
            if (surveyResponse.selectedArtists.includes(artist)) {
                button.classList.add('selected');
            }
            
            button.onclick = () => selectArtist(artist, button);
            artistButtons.appendChild(button);
        });
        
        // Show or hide navigation buttons based on whether 3 artists are selected
        if (surveyResponse.selectedArtists.length === 3) {
            document.getElementById('nextButton2').style.display = 'block';
            document.getElementById('homeButton2').style.display = 'block';
            document.getElementById('backButton2').style.display = 'block';
        } 
        else {
            document.getElementById('nextButton2').style.display = 'none';
            document.getElementById('homeButton2').style.display = 'none';
            document.getElementById('backButton2').style.display = 'none';
        }
    }

    // Function to select an artist
    function selectArtist(artist, button) {
        const index = surveyResponse.selectedArtists.indexOf(artist);
        
        if (index !== -1) {
            // Artist already selected, remove it
            surveyResponse.selectedArtists.splice(index, 1);
            button.classList.remove('selected');
        } 
        else if (surveyResponse.selectedArtists.length < 3) {
            // Add artist if less than 3 are selected
            surveyResponse.selectedArtists.push(artist);
            button.classList.add('selected');
        }
         else {
            // Alert if already 3 artists selected
            alert("You can only select up to 3 artists.");
            return;
        }
        
        // Show navigation buttons ONLY if exactly 3 artists are selected
        if (surveyResponse.selectedArtists.length === 3) {
            document.getElementById('nextButton2').style.display = 'block';
            document.getElementById('homeButton2').style.display = 'block';
            document.getElementById('backButton2').style.display = 'block';
        }
        else {
            document.getElementById('nextButton2').style.display = 'none';
            document.getElementById('homeButton2').style.display = 'none';
            document.getElementById('backButton2').style.display = 'none';
        }

    }

    // Function to Display the Second and Third Question
    function displayYear() {
        if (surveyResponse.selectedArtists.length !== 3) {
            alert("Please select exactly 3 artists.");
            return;
        }
        document.getElementById('artistQuestion').style.display = 'none';
        document.getElementById('yearQuestion').style.display = 'block';
        
        // Update selected year button if there's a previous selection
        if (surveyResponse.selectedYear) {
            document.querySelectorAll('.optionButton2').forEach(button => {
                button.classList.remove('selected');
                if (button.textContent === surveyResponse.selectedYear) {
                    button.classList.add('selected');
                }
            });
            // Show submit button if year is already selected
            document.getElementById('submitButton').style.display = 'block';
        } 
        else {
            // Initially hide the submit button until a year is selected
            document.getElementById('submitButton').style.display = 'none';
        }
    }

    // Function to select year
    function selectYear(year) {
        surveyResponse.selectedYear = year;
        
        // Update button styles
        document.querySelectorAll('.optionButton2').forEach(button => {
            button.classList.remove('selected');
            if (button.textContent === year) {
                button.classList.add('selected');
            }
        });
        
        // Show submit button once a year is selected
        document.getElementById('submitButton').style.display = 'block';
        document.getElementById('backButton3').style.display = 'block';
        document.getElementById('homeButton3').style.display = 'block';

    }

    // Function to go back to previous question
    function goBack() {
        const genreQuestion = document.getElementById('genreQuestion');
        const artistQuestion = document.getElementById('artistQuestion');
        const yearQuestion = document.getElementById('yearQuestion');
        
        // Check which question is currently visible
        if (artistQuestion.style.display === 'block') {
            // Go back to genre question
            artistQuestion.style.display = 'none';
            genreQuestion.style.display = 'block';
        } 
        else if (yearQuestion.style.display === 'block') {

            // Go back to artist question
            yearQuestion.style.display = 'none';

            // Properly displays the artist question with selections
            displayArtists(); 
        }
    }

    // Function to show warning popup
    function showWarning() {
        document.getElementById('warningPopUp').style.display = 'block';
    }

    // Function to close warning popup
    document.addEventListener('DOMContentLoaded', function() {
        const cancelButton = document.querySelector('.cancel');
        if (cancelButton) {
            cancelButton.onclick = function() {
                document.getElementById('warningPopUp').style.display = 'none';
            };
        }
    });

    // Function to go to home page
    function goHome() {
        // Removes The User's Selected Answers
        surveyResponse = {
            selectedGenre: '',
            selectedArtists: [],
            selectedYear: ''
        };
        
        // Redirects to home page
        window.location.href = 'homePage.php';
    }

    
    // Function to generate recommendations
    function generateRecommendations() {
        if (!surveyResponse.selectedYear) {
            alert("Please select an era.");
            return;
        }
        
        //Seperating selected artist to 3 Seperate variables
        const [Artist1, Artist2, Artist3] = surveyResponse.selectedArtists;
        
        // Prepare data for submission
        const surveyData = {
            genre: surveyResponse.selectedGenre,
            Artist1: Artist1,
            Artist2: Artist2,  
            Artist3: Artist3,  
            year: surveyResponse.selectedYear
        };
        
        console.log("Survey completed!", surveyData);
        
        // Create a query string from the surveyData
        const queryParams = new URLSearchParams(surveyData).toString();
        
        // Navigate to the recommendation page with query parameters
        window.location.href = `recommendation.php?${queryParams}`;
    }