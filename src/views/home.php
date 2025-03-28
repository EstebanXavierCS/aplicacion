<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Shop</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <nav class="main-nav">
            <a href="/">Home</a>
            <a href="/products">Products</a>
            <a href="/about">About Us</a>
            <?php if(isset($_SESSION['username'])): ?>
                <a href="/logout">Logout</a>
            <?php else: ?>
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            <?php endif; ?>
        </nav>

        <div class="hero-section">
            <img src="/images/banner.jpg" alt="Welcome to our store" class="hero-image">
            <div class="hero-content">
                <h1>Welcome to Our Shop</h1>
                <?php if(isset($_SESSION['username'])): ?>
                    <p class="welcome-message">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                    <a href="/products" class="cta-button">View Our Products</a>
                <?php else: ?>
                    <p class="welcome-message">Discover our amazing products</p>
                    <div class="cta-buttons">
                        <a href="/login" class="cta-button">Login</a>
                        <a href="/register" class="cta-button secondary">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>