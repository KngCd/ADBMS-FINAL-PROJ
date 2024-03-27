<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pansol Integrated National High School</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header id="myHeader" class>
    <div class="head" id="header">
    <div class="h2"><img class="logo" src="images/schooal.png" alt=""><p class="sc">Pansol Integrated <br>National High School<p/></div>
            <div class="h3">
            <a class="nav-link" href="#content-container">HOME</a>
            <a class="nav-link" href="#about">ABOUT</a>
            <a class="nav-link" href="#contact">CONTACT US</a>
            </div>
            <button onclick="location.href='LoginSignup.php'" class="bn54">
                <span class="bn54span">Login</span>
            </button>
    </div>
    </header>
        <script>
            window.addEventListener('scroll', function() {
            const header = document.getElementById('myHeader');
            const scrollPosition = window.pageYOffset;

            if (scrollPosition > 50) {
                header.style.backgroundColor = 'rgba(30, 97, 243, 0.836)';
            } else {
                header.style.backgroundColor = 'transparent';
            }
            });
        </script>
<div class="content-container" id="content-container">
            <div class="h-container">
                <p class="paragraph">
                <span style="--d: 0s;">A FREE AND</span>
                <span style="--d: .1s;">SIMPLE</span>
                <span style="--d: .2s;">LEARNING</span>
                <span style="--d: .3s;">MANAGEMENT SYSTEM</span>
            </p>    
            </div>
            <div class="hh">
            <p class="paragraph">
                <span style="--d: .4s;">An LMS streamlines education</span>
                <span style="--d: .5s;">by centralizing content </span>
                <span style="--d: .6s;">and activities for improved learning.</span>
                <span style="--d: .7s;"><button class="button" onclick="location.href='LoginSignup.php'">GET STARTED </button></span>
            </p>     
        </div>
</div>
    <script>
        // Function to reset animations
        function resetAnimations() {
        const spans = document.querySelectorAll('.paragraph span');
        const hContainer = document.querySelector('.h-container');
        const hh = document.querySelector('.hh');

        spans.forEach(span => {
            span.style.animation = 'none';
            void span.offsetWidth; // Trigger reflow
            span.style.animation = null;
        });

        hContainer.style.animation = 'none';
        void hContainer.offsetWidth; // Trigger reflow
        hh.style.animation = 'none';
        void hh.offsetWidth; // Trigger reflow

        // Restore animations with a slight delay to ensure synchronization
        setTimeout(() => {
            spans.forEach(span => {
            span.style.animation = null;
            });
            hContainer.style.animation = 'border-reveal 2.5s forwards';
            hh.style.animation = 'border-reveal 2.5s forwards';
        }, 10);
        }

        // Function to check if the user has scrolled to the top of the page
        function checkScroll() {
        if (window.scrollY === 0) {
            resetAnimations();
        }
        }

        // Attach event listener for scroll event
        window.addEventListener('scroll', checkScroll);
    </script>

    <div class="container2">
        <img class="logo2" src="images/padre.png" alt="">
        <img class="logo2" src="images/sk.png" alt="">
        <img class="logo3" src="images/deped2.png" alt="">
        <img class="logo2" src="images/school.png" alt="">
        <img class="logo2" src="images/deped.png" alt="">
    </div>

    <div id="about">
        <div class="content-mission">
            <div class="front"><h1>Mission</h1></div>
            <div class="back">
            <p>To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:<br>
             Students learn in a child-friendly, gender-sensitive, safe, and motivating environment.<br>
             Teachers facilitate learning and constantly nurture every learner.<br>
             Administrators and staff, as stewards of the institution, ensure an enabling and supportive environment for effective learning to happen.<br>
             Family, community, and other stakeholders are actively engaged and share responsibility for developing life-long learners.</p>
            </div>
        </div>
        <div class="content-vision">
            <div class="front"><h1>Vision</h1></div>
            <div class="back">
            <p>We dream of Filipinos who passionately love their country and whose values and competencies
            <br>enable them to realize their full potential and contribute meaningfully to building the nation.<br>
            As a learner-centered public institution, the Department of Education 
            continuously improves itself to better serve its stakeholders.</p>
            </div>
        </div>
    </div>
        <script>
            document.querySelectorAll('.content-mission').forEach(card => {
                card.addEventListener('mouseover', () => {
                    card.style.transform = 'rotateY(180deg)';
                });
                card.addEventListener('mouseout', () => {
                    card.style.transform = 'rotateY(0deg)';
                });
            });
            document.querySelectorAll('.content-vision').forEach(card => {
                card.addEventListener('mouseover', () => {
                    card.style.transform = 'rotateY(180deg)';
                });
                card.addEventListener('mouseout', () => {
                    card.style.transform = 'rotateY(0deg)';
                });
            });
        </script>

    <div id="contact">
        <h1>Let's Talk</h1>
        <p>Use Below Form or Email me direct: pansolgarcia@yahoo.com/301132@deped.gov.ph</p>
        <div class="form">
        <div class="input-wrapper">
            <input type='text' id='input' autocomplete="off" required ></input>
           <label for='input' class='placeholder'>Name</label>
        </div>
        <div class="input-wrapper">
            <input type='email' id='input' autocomplete="off" required ></input>
            <label for='input' class='placeholder'>Email</label>
        </div>
        <div class="input-wrapper">
            <input type='text' id='input' autocomplete="off" required ></input>
            <label for='input' class='placeholder'>Contact Number</label>
        </div>
        <div class="input-wrapper-message">
            <input type='text' id='input' autocomplete="off" required ></input>
            <label for='input' class='placeholder'>Message</label>
        </div>
        <button>Submit</button>
        </div>
    </div>
</body>

    <footer>
        <div class="ft1">
        <h4>Follow Us</h4>
        <ul class="wrapper">
            <li class="icon facebook">
            <span><a href="https://www.facebook.com/profile.php?id=100069237878821" target="_blank"><i class="fab fa-facebook-f"></i></span>
            </li>
            <li class="icon discord">
            <span><a href="https://discord.com/" target="_blank"><i class="fab fa-discord"></i></a></span>
            </li>
            <li class="icon github">
            <span><a href="https://github.com/" target="_blank"><i class="fab fa-github"></i></a></span>
            </li>
            <li class="icon youtube">
            <span><a href="https://www.youtube.com/watch?v=zZ6vybT1HQs" target="_blank"><i class="fab fa-youtube"></i></a></span>
            </li>
        </ul>
        </div>
        <div class="ft2">
        <div class="card">
            <h4>Products</h4>
            <a href="#" class="btn">LMS for Education</a><br>
            <a href="#" class="btn">Classroom</a><br>
            <a href="#" class="btn">Assignments</a><br>
            <a href="#" class="btn">PHP Database</a><br>
        </div>
        <div class="card">
            <h4>Get Products</h4>
            <a href="#" class="btn">Contact Sales</a><br>
            <a href="#" class="btn">Apply for Cloud Credits</a><br>
            <a href="#" class="btn">Sign up</a><br>
            <a href="#" class="btn">Accesbility</a><br>
        </div>
        <div class="card">
            <h4>For Educators</h4>
            <a href="#" class="btn">Overview</a><br>
            <a href="#" class="btn">Product Guides</a><br>
            <a href="#" class="btn">Communities</a><br>
            <a href="#" class="btn">FAQ</a><br>
        </div>
        <div class="card">
            <h4>About Our LMS</h4>
            <a href="#" class="btn">Our Commitment</a><br>
            <a href="#" class="btn">For K12</a><br>
            <a href="#" class="btn">Accesbility</a><br>
            <a href="#" class="btn">Distance Learning</a><br>
        </div>
    </div>
    </footer>
    
</html>

