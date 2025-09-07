<?php
// Database connection with environment variables
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'portofolio';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Sorry, we're experiencing technical difficulties. Please try again later.");
}

// Set charset
$conn->set_charset("utf8mb4");

// Initialize form feedback
$form_status = ['success' => false, 'message' => ''];

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fullname'], $_POST['email'], $_POST['message'])) {
    $fullname = filter_var(trim($_POST['fullname']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate inputs
    if (strlen($fullname) < 2 || strlen($fullname) > 50) {
        $form_status['message'] = 'Name must be 2-50 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_status['message'] = 'Invalid email address.';
    } elseif (strlen($message) < 10) {
        $form_status['message'] = 'Message must be at least 10 characters.';
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO contact_messages (fullname, email, message) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('sss', $fullname, $email, $message);
            if ($stmt->execute()) {
                $form_status = ['success' => true, 'message' => 'Message sent successfully!'];
            } else {
                $form_status['message'] = 'Failed to send message. Please try again.';
                error_log("Insert failed: " . $stmt->error);
            }
            $stmt->close();
        } else {
            $form_status['message'] = 'Database error. Please try again later.';
            error_log("Prepare failed: " . $conn->error);
        }
    }
}

// Fetch only necessary data with error handling
function fetchQuery($conn, $query, $tableName) {
    $result = $conn->query($query);
    if ($result === false) {
        error_log("Query failed for $tableName: " . $conn->error);
        return [];
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $result->free();
    return $data;
}

$services = fetchQuery($conn, "SELECT * FROM services", "services");
$skills = fetchQuery($conn, "SELECT * FROM skills", "skills");
$projects = fetchQuery($conn, "SELECT * FROM projects", "projects");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="-y1KXkxsAzFscGnxsJ9lIz1rV3DdnTByMyAL9zucYSQ">
    <meta name="description" content="Inez Nurdika Irzani, a full-stack web developer from Jepara, Indonesia, specializing in SEO-friendly, scalable websites.">
    <meta name="keywords" content="web developer, portfolio, Inez Nurdika Irzani, Luddin, Indonesia, full-stack, SEO, responsive design">
    <meta name="author" content="Inez Nurdika Irzani">
    <meta property="og:title" content="Inez Nurdika Irzanin - Full-Stack Web Developer Portfolio">
    <meta property="og:description" content="Explore the professional portfolio of Inez Nurdika Irzani, showcasing web development projects and expertise from Gresik, East Java.">
    <meta property="og:image" content="assets/img/profile.jpg">
    <meta property="og:url" content="https://luddin.my.id">
    <meta property="og:type" content="website">
    <link rel="canonical" href="https://luddin.my.id">
    <link rel="icon" type="image/png" href="assets/img/profile.jpg">
    <!-- Sitemap for SEO -->
    <link rel="sitemap" type="application/xml" href="/sitemap.xml">
    <title>Inez Nurdika Irzani - Full-Stack Web Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Deferred scripts for faster page load -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fallback for GSAP and SweetAlert2 -->
    <script>window.gsap || document.write('<script src="assets/js/gsap.min.js"><\/script>');</script>
    <script>window.ScrollTrigger || document.write('<script src="assets/js/ScrollTrigger.min.js"><\/script>');</script>
    <script>window.Swal || document.write('<script src="assets/js/sweetalert2.min.js"><\/script>');</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Header -->
    <header>
        <a href="#home" class="logo">Inez <span>Nurdika Irzani</span></a>
        <div class="bx bx-menu menu-icon" id="menu-icon"></div>
        <ul class="navbar">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#achievements">Achievements</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </header>

    <!-- Main Content -->
    <main>

<section class="home" id="home">
    <div class="home-content">
        <div class="home-img">
            <?php
            function getImagePath($path, $default = 'https://via.placeholder.com/280?text=Profile+Image') {
                return file_exists($path) ? $path : $default;
            }
            ?>
            <img 
                src="<?php echo htmlspecialchars(getImagePath('assets/img/profile.jpg')); ?>" 
                srcset="<?php echo htmlspecialchars(getImagePath('assets/img/profile.jpg')); ?> 280w, <?php echo htmlspecialchars(getImagePath('assets/img/profile.jpg')); ?> 560w" 
                sizes="(max-width: 768px) 280px, 560px"
                alt="Portrait of Inez Nurdika Irzani, Backend Developer" 
                loading="lazy">
        </div>
        <div class="home-text">
            <span>Hello, I'm</span>
            <h1 class="typewrite" data-period="3000" data-type='["Inez Nurdika Irzani", "Backend Developer", "Creative Innovator"]'>
                Inez Nurdika Irzani
            </h1>
            <h2>Backend Developer</h2>
            <p>Mahasiswa Teknologi Informasi UIN Walisongo Semarang dengan pengalaman mengikuti berbagai kompetisi teknologi serta kegiatan volunteer. Memiliki minat dalam pengembangan karier di bidang teknologi informasi dengan fokus pada inovasi sosial dan keberlanjutan.</p>
            <div class="social">
                <a href="https://github.com/Inez321" target="_blank" rel="noopener noreferrer" aria-label="GitHub Profile"><i class="bx bxl-github"></i></a>
                <a href="https://instagram.com/inezirzani" target="_blank" rel="noopener noreferrer" aria-label="Instagram Profile"><i class="bx bxl-instagram"></i></a>
                <a href="https://youtube.com/@ineznurdika212" target="_blank" rel="noopener noreferrer" aria-label="YouTube Channel"><i class="bx bxl-youtube"></i></a>
                <a href="https://www.linkedin.com/in/inez-nurdika-irzani" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn Profile"><i class="bx bxl-linkedin"></i></a>
            </div>
            <a href="#contact" class="btn">Get in touch</a>
        </div>
    </div>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "Inez Nurdika Irzani",
        "jobTitle": "Backend Developer",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Semarang",
            "addressRegion": "Jawa Tengah",
            "addressCountry": "Indonesia"
        },
        "email": "ineznurdikairzani.9c.14@gmail.com",
        "telephone": "+6281228525171",
        "url": "https://yourportfolio.com",
        "sameAs": [
            "https://github.com/Inez321",
            "https://instagram.com/inezirzani",
            "https://youtube.com/@ineznurdika212",
            "https://www.linkedin.com/in/inez-nurdika-irzani"
        ]
    }
    </script>
</section>

<!-- About Section - Diperbarui -->
<section class="about" id="about">
    <div class="heading">
        <h2>About Me</h2>
        <span>Introduction</span>
    </div>
    <div class="about-container">
        <div class="about-img">
            <img 
                src="<?php echo htmlspecialchars(getImagePath('assets/img/profile.jpg')); ?>" 
                srcset="<?php echo htmlspecialchars(getImagePath('assets/img/profile.jpg')); ?> 350w, <?php echo htmlspecialchars(getImagePath('assets/img/profile.jpg')); ?> 700w" 
                sizes="(max-width: 1024px) 350px, 450px"
                alt="Inez Nurdika Irzani" 
                loading="lazy">
        </div>
        <div class="about-text">
            <p>I'm Inez Nurdika Irzani, a Backend Developer based in Semarang, Indonesia. Currently studying Information Technology at UIN Walisongo Semarang with a GPA of 3.89/4.00. I have experience in various technology competitions and volunteer activities, with a focus on social innovation and sustainability.</p>
            <p>I serve as Staff Ahli Departemen Pendidikan dan Penalaran at HMJ Teknologi Informasi, responsible for the Backend role in the SINTECH program. I'm passionate about creating efficient, scalable backend solutions using PHP, MySQL, and other technologies.</p>
            <div class="information">
                <div class="info-box"><i class="bx bx-user"></i> <span>Inez Nurdika Irzani</span></div>
                <div class="info-box"><i class="bx bxs-graduation"></i> <span>UIN Walisongo Semarang - GPA: 3.89/4.00</span></div>
                <div class="info-box"><i class="bx bxs-phone"></i> <span>+62 812-2852-5171</span></div>
                <div class="info-box"><i class="bx bxl-linkedin"></i> <span><a href="https://www.linkedin.com/in/inez-nurdika-irzani" target="_blank">inez-nurdika-irzani</a></span></div>
                <div class="info-box"><i class="bx bxs-envelope"></i> <span><a href="mailto:ineznurdikairzani.9c.14@gmail.com">ineznurdikairzani.9c.14@gmail.com</a></span></div>
                <div class="info-box"><i class="bx bx-map"></i> <span>Jl. Tanjungsari Utara VI No 8A, Semarang</span></div>
            </div>
            <a href="#contact" class="btn">Get in touch</a>
        </div>
    </div>
</section>

<!-- ... (bagian lainnya tetap sama) -->
        <!-- Skills Section -->
        <section class="skills" id="skills">
            <div class="heading">
                <h2>Skills</h2>
                <span>My Technical Expertise</span>
            </div>
            <div class="skills-container">
                <div class="bars">
                    <?php if (empty($skills)): ?>
                        <p class="text-center">No skills available at the moment.</p>
                    <?php else: ?>
                        <?php foreach ($skills as $skill): ?>
                            <div class="bars-box">
                                <h3>
                                    <?php echo htmlspecialchars($skill['name'] ?? 'Unknown Skill'); ?>
                                    <span><?php echo htmlspecialchars($skill['percentage'] ?? 0); ?>%</span>
                                </h3>
                                <div class="light-bar">
                                    <div class="percent-bar" style="width: <?php echo htmlspecialchars($skill['percentage'] ?? 0); ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services" id="services">
            <div class="heading">
                <h2>Services</h2>
                <span>What I Offer</span>
            </div>
            <div class="services-content">
                <?php if (empty($services)): ?>
                    <p class="text-center">No services available at the moment.</p>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <div class="services-box">
                            <i class="bx <?php echo htmlspecialchars($service['icon'] ?? 'bx-code-alt'); ?>"></i>
                            <h3><?php echo htmlspecialchars($service['title'] ?? 'Untitled Service'); ?></h3>
                            <p><?php echo htmlspecialchars($service['description'] ?? 'No description available.'); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

<!-- Portfolio Section -->
<section class="portfolio" id="portfolio">
    <div class="heading">
        <h2>Portfolio</h2>
        <span>My Recent Projects</span>
    </div>
    <div class="portfolio-content">
        <?php if (empty($projects)): ?>
            <p class="text-center">No projects available at the moment.</p>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
                <div class="project-item">
                    <div class="project-img">
                        <img 
                            src="assets/img/<?php echo htmlspecialchars($project['image'] ?? 'https://via.placeholder.com/600x400?text=Project+Image'); ?>" 
                            alt="<?php echo htmlspecialchars($project['title'] ?? 'Project Image'); ?>" 
                            loading="lazy"
                        >
                    </div>
                    <div class="project-content">
                        <h3><?php echo htmlspecialchars($project['title'] ?? 'Untitled Project'); ?></h3>
                        <p><?php echo htmlspecialchars($project['description'] ?? 'No description available.'); ?></p>
                        <a href="<?php echo htmlspecialchars($project['link'] ?? '#'); ?>" class="btn" target="_blank" rel="noopener noreferrer">View Project</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Achievements Section -->
<section class="achievements" id="achievements">
    <div class="achievements-container">
        <?php include 'achievements.php'; ?>
    </div>
</section>


        <!-- Contact Section - Diperbarui -->
<section class="contact" id="contact">
    <div class="heading">
        <h2>Contact</h2>
        <span>Get In Touch With Me</span>
    </div>
    <div class="contact-container">
        <div class="contact-info">
            <h3>Let's Discuss Your Project</h3>
            <p>I'm always open to discussing new projects, creative ideas, or opportunities to be part of your vision.</p>
            <div class="contact-details">
                <div class="contact-details-item">
                    <i class="bx bx-map"></i>
                    <div class="contact-details-text">
                        <h4>Location</h4>
                        <p>Semarang, Jawa Tengah, Indonesia</p>
                    </div>
                </div>
                <div class="contact-details-item">
                    <i class="bx bxs-phone"></i>
                    <div class="contact-details-text">
                        <h4>Phone</h4>
                        <p>+62 812-2852-5171</p>
                    </div>
                </div>
                <div class="contact-details-item">
                    <i class="bx bxl-linkedin"></i>
                    <div class="contact-details-text">
                        <h4>LinkedIn</h4>
                        <p>inez-nurdika-irzani</p>
                    </div>
                </div>
                <div class="contact-details-item">
                    <i class="bx bx-envelope"></i>
                    <div class="contact-details-text">
                        <h4>Email</h4>
                        <p>ineznurdikairzani.9c.14@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-form">
            <form method="POST" action="">
                <input type="text" name="fullname" placeholder="Your Name" required pattern="[A-Za-z\s]{2,50}" title="Name should be 2-50 characters" aria-label="Full Name">
                <input type="email" name="email" placeholder="Your Email" required aria-label="Email Address">
                <textarea name="message" placeholder="Your Message" required minlength="10" aria-label="Message"></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </div>
</section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <h2>Follow Me</h2>
            <div class="footer-social">
                <a href="https://youtube.com/@ineznurdika212" target="_blank" rel="noopener noreferrer" aria-label="YouTube Channel"><i class="bx bxl-youtube"></i></a>
                <a href="https://instagram.com/inezirzani" target="_blank" rel="noopener noreferrer" aria-label="Instagram Profile"><i class="bx bxl-instagram"></i></a>
                <a href="https://www.linkedin.com/in/inez-nurdika-irzani" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn Profile"><i class="bx bxl-linkedin"></i></a>
                <a href="https://github.com/Inez321" target="_blank" rel="noopener noreferrer" aria-label="GitHub Profile"><i class="bx bxl-github"></i></a>
            </div>
        </div>
    </footer>
    <div class="copyright">© 2025 Inez Nurdika Irzani. All Rights Reserved.</div>
    <button class="back-to-top" id="back-to-top" aria-label="Back to Top"><i class="bx bx-up-arrow-alt"></i></button>

    <script>
        // Display SweetAlert2 based on form status
        <?php if ($form_status['message']): ?>
            Swal.fire({
                icon: '<?php echo $form_status['success'] ? 'success' : 'error'; ?>',
                title: '<?php echo $form_status['success'] ? 'Success' : 'Error'; ?>',
                text: '<?php echo htmlspecialchars($form_status['message']); ?>',
                confirmButtonColor: '#93C5FD', // Tailwind indigo-600
                background: '#f3f4f6', // Tailwind gray-800
                color: '#1f2937' // Tailwind gray-100
            });
        <?php endif; ?>

        // Mobile menu toggle
        const menuIcon = document.getElementById('menu-icon');
        const navbar = document.querySelector('.navbar');
        menuIcon.addEventListener('click', () => {
            navbar.classList.toggle('open');
        });

        // Close menu on link click
        document.querySelectorAll('.navbar a').forEach(link => {
            link.addEventListener('click', () => {
                navbar.classList.remove('open');
            });
        });

        // Close menu on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                navbar.classList.remove('open');
            }
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            header.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            backToTopButton.classList.toggle('show', window.scrollY > 300);
        });
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Typing animation
        class TxtType {
            constructor(el, toRotate, period) {
                this.toRotate = toRotate;
                this.el = el;
                this.loopNum = 0;
                this.period = parseInt(period, 10) || 2000;
                this.txt = '';
                this.isDeleting = false;
                this.tick();
            }
            tick() {
                const i = this.loopNum % this.toRotate.length;
                const fullTxt = this.toRotate[i];
                this.txt = this.isDeleting
                    ? fullTxt.substring(0, this.txt.length - 1)
                    : fullTxt.substring(0, this.txt.length + 1);
                this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';
                const delta = this.isDeleting ? 100 : 200 - Math.random() * 100;
                if (!this.isDeleting && this.txt === fullTxt) {
                    this.isDeleting = true;
                    setTimeout(() => this.tick(), this.period);
                } else if (this.isDeleting && this.txt === '') {
                    this.isDeleting = false;
                    this.loopNum++;
                    setTimeout(() => this.tick(), 500);
                } else {
                    setTimeout(() => this.tick(), delta);
                }
            }
        }

        // Initialize animations
        window.onload = () => {
            try {
                // Typing animation
                const elements = document.getElementsByClassName('typewrite');
                for (let i = 0; i < elements.length; i++) {
                    const toRotate = elements[i].getAttribute('data-type');
                    const period = elements[i].getAttribute('data-period');
                    if (toRotate) {
                        new TxtType(elements[i], JSON.parse(toRotate), period);
                    }
                }

                // GSAP animations with fallback
                if (window.gsap && window.ScrollTrigger) {
                    gsap.registerPlugin(ScrollTrigger);
                    gsap.from('.home-img', { 
                        autoAlpha: 0, 
                        x: -50, 
                        duration: 1, 
                        delay: 0.5,
                        onComplete: () => document.querySelector('.home-img').style.visibility = 'visible'
                    });
                    gsap.from('.home-text', { 
                        autoAlpha: 0, 
                        x: 50, 
                        duration: 1, 
                        delay: 0.8,
                        onComplete: () => document.querySelector('.home-text').style.visibility = 'visible'
                    });
                    gsap.from('.social a', {
                        autoAlpha: 0,
                        y: 20,
                        duration: 0.8,
                        stagger: 0.2,
                        delay: 1.2,
                        onComplete: () => document.querySelectorAll('.social a').forEach(el => el.style.visibility = 'visible')
                    });
                    const sections = ['.about', '.skills', '.services', '.portfolio', '.contact'];
                    sections.forEach(section => {
                        gsap.from(`${section} .heading`, {
                            scrollTrigger: { trigger: section, start: 'top 80%' },
                            autoAlpha: 0,
                            y: 30,
                            duration: 0.8
                        });
                    });
                    gsap.from('.services-box', {
                        scrollTrigger: { trigger: '.services', start: 'top 60%' },
                        autoAlpha: 0,
                        y: 50,
                        duration: 0.8,
                        stagger: 0.2
                    });
                    gsap.from('.project-item', {
                        scrollTrigger: { trigger: '.portfolio', start: 'top 60%' },
                        autoAlpha: 0,
                        y: 50,
                        duration: 0.8,
                        stagger: 0.2
                    });
                    gsap.from('.percent-bar', {
                        scrollTrigger: { trigger: '.skills', start: 'top 70%' },
                        width: 0,
                        duration: 1.5,
                        stagger: 0.2,
                        ease: "power2.out"
                    });
                } else {
                    // Fallback: Ensure elements are visible
                    document.querySelector('.home-img').style.opacity = 1;
                    document.querySelector('.home-img').style.visibility = 'visible';
                    document.querySelector('.home-text').style.opacity = 1;
                    document.querySelector('.home-text').style.visibility = 'visible';
                    document.querySelectorAll('.social a').forEach(el => {
                        el.style.opacity = 1;
                        el.style.visibility = 'visible';
                    });
                }
            } catch (error) {
                console.error('Animation error:', error);
                // Ensure elements are visible on error
                document.querySelector('.home-img').style.opacity = 1;
                document.querySelector('.home-img').style.visibility = 'visible';
                document.querySelector('.home-text').style.opacity = 1;
                document.querySelector('.home-text').style.visibility = 'visible';
                document.querySelectorAll('.social a').forEach(el => {
                    el.style.opacity = 1;
                    el.style.visibility = 'visible';
                });
            }
        };
        
    </script>
</body>
</html>
<?php $conn->close(); ?>

