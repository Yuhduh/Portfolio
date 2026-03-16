<?php
// Initialize variables
$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_message = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Please enter a valid email address.';
    } else {
        // Email configuration
        $to = 'alex@example.com'; // Change this to your email
        $email_subject = "Portfolio Contact: $subject";
        $email_body = "You have received a new message from your portfolio contact form.\n\n";
        $email_body .= "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Subject: $subject\n\n";
        $email_body .= "Message:\n$message";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        // Send email (requires proper mail server configuration in XAMPP)
        if (mail($to, $email_subject, $email_body, $headers)) {
            $success_message = 'Thank you! Your message has been sent successfully.';
        } else {
            // For development/testing without mail server
            $success_message = 'Thank you! Your message has been received.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carl John Paul Masayon - BSIT Students</title>
    <link rel="stylesheet" href="style.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo"> </div>
            <ul class="nav-menu">
                <li><a href="#home" class="nav-link active">Home</a></li>
                <li><a href="#about" class="nav-link">About me</a></li>
                <li><a href="#portfolio" class="nav-link">Portfolio</a></li>
                <li><a href="#contact" class="nav-link">Contact me</a></li>
            </ul>
            <div class="logo"> </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section id="home" class="home-section">
        <div class="home-container">
            <div class="home-content">
                <p class="intro-text">Hi I am</p>
                <h1 class="name">Carl John Paul Masayon</h1>
                <h2 class="title">BSIT<br>Student</h2>
                
                <div class="social-links">
                    <a href="https://www.instagram.com/anak_ni_noel_ug_ni_liza/" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://github.com/Yuhduh" class="social-icon"><i class="fab fa-github"></i></a>
                    <a href="https://www.linkedin.com/in/Carl-John-Paul-Masayon" class="social-icon"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <div class="home-image">
                <div class="image-placeholder">
                    <!-- Profile image placeholder -->
                    <div class="profile-img"></div>
                </div>
            </div>
        </div>

        <div class="scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

<!-- About Section -->
    <section id="about" class="about-section">
        <div class="section-container">
            <h2 class="section-title">About <span class="highlight">Me</span></h2>
            <p class="section-subtitle">Learn more about my journey and expertise</p>

            <div class="about-content">
                <div class="about-image">
                    <div class="workspace-img"></div>
                </div>

                <div class="about-text">
                    <h3>Passionate IT Student & Developer</h3>
                    <p>I'm a dedicated IT student specializing in web development with a passion for creating innovative digital solutions. With expertise in modern web technologies, I transform complex problems into elegant, user-friendly applications.</p>
                    
                    <p>Currently pursuing my degree in Information Technology, I've worked on various projects that demonstrate my skills in PHP, MySQL, and modern web development practices.</p>

                    <div class="about-stats">
                        <div class="about-stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="stat-info">
                                <h4>PHP</h4>
                                <p>Server-Side</p>
                            </div>
                        </div>

                        <div class="about-stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="stat-info">
                                <h4>MySQL</h4>
                                <p>Database</p>
                            </div>
                        </div>

                        <div class="about-stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <div class="stat-info">
                                <h4>Web Dev</h4>
                                <p>Full Stack</p>
                            </div>
                        </div>

                        <div class="about-stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="stat-info">
                                <h4>BSIT</h4>
                                <p>Student</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio-section">
        <div class="section-container">
            <h2 class="section-title">My <span class="highlight">Portfolio</span></h2>
            <p class="section-subtitle">A selection of my recent projects showcasing my skills</p>

            <div class="portfolio-grid">
                <div class="portfolio-card">
                    <div class="portfolio-image" style="background-image: url('image-1773584651996.png'); background-size: cover; background-position: center;"></div>
                    <div class="portfolio-info">
                        <h3>Enrollment System</h3>
                        <p>A comprehensive system for managing student enrollments, and academic records.</p>
                        <div class="tech-tags">
                            <span class="tech-tag">Python</span>
                            <span class="tech-tag">MySQL</span>
                            <span class="tech-tag">CRUD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio-section">
        <div class="section-container">
            <h2 class="section-title">My <span class="highlight">Portfolio</span></h2>
            <p class="section-subtitle">A selection of my recent projects showcasing my skills and expertise</p>

            <div class="portfolio-grid">
                <div class="portfolio-card">
                    <div class="portfolio-image" style="background-image: url('image-1773584651996.png'); background-size: cover; background-position: center;"></div>
                    <div class="portfolio-info">
                        <h3>Enrollment System</h3>
                        <p>A comprehensive system for managing student enrollments, and academic records.</p>
                        <div class="tech-tags">
                            <span class="tech-tag">Python</span>
                            <span class="tech-tag">MySQL</span>
                            <span class="tech-tag">CRUD</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="section-container">
            <h2 class="section-title">Contact <span class="highlight">Me</span></h2>
            <p class="section-subtitle">Let's discuss your project and bring your ideas to life</p>

            <div class="contact-content">
                <div class="contact-info-section">
                    <h3>Get in Touch</h3>
                    <p class="contact-description">I'm always open to discussing new projects, creative ideas, or opportunities to be part of your vision. Feel free to reach out through any of these channels.</p>

                    <div class="contact-cards">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Phone</h4>
                                <p>09956140173</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <p>carljohnpaulmasayon23@gmail.com</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Location</h4>
                                <p>Davao City, Philippines</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-section">
                    <?php if ($success_message): ?>
                        <div class="alert alert-success" style="background: rgba(0, 200, 100, 0.2); border: 1px solid #00c864; color: #00c864; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                            <?php echo $success_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($error_message): ?>
                        <div class="alert alert-error" style="background: rgba(255, 50, 50, 0.2); border: 1px solid #ff3232; color: #ff3232; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form class="contact-form" method="POST" action="#contact">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" id="name" name="name" placeholder="John Doe" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input type="email" id="email" name="email" placeholder="john@example.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" placeholder="Project Inquiry" value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>" required>
                        </div>

                        <div class="form-group" style="width:100%">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Tell me about your project..." style="width: 100%;" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                        </div>

                        <button type="submit" class="btn-submit">
                            Send Message
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-about">
                    <p>BSIT Student specializing in web development. Let's create something amazing together.</p>
                </div>

                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#about">About me</a></li>
                        <li><a href="#portfolio">Portfolio</a></li>
                        <li><a href="#contact">Contact me</a></li>
                    </ul>
                </div>

                <div class="footer-connect">
                    <h4>Connect</h4>
                    <div class="footer-social">
                        <a href="https://www.instagram.com/anak_ni_noel_ug_ni_liza/" class="footer-social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="https://github.com/Yuhduh" class="footer-social-icon"><i class="fab fa-github"></i></a>
                        <a href="https://www.linkedin.com/in/Carl-John-Paul-Masayon" class="footer-social-icon"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Alex Johnson. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
