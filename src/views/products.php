<?php
require_once __DIR__ . '/../../src/controllers/ProductController.php';
$productController = new ProductController();
$products = $productController->getAllProducts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Our Products</h1>
        
        <?php if(isset($_SESSION['username'])): ?>
            <div class="add-product-form">
                <h2>Add New Product</h2>
                <form action="/products/add" method="POST">
                    <input type="text" name="name" placeholder="Product Name" required>
                    <textarea name="description" placeholder="Description" required></textarea>
                    <input type="number" name="price" step="0.01" placeholder="Price" required>
                    <input type="text" name="image_url" placeholder="Image URL">
                    <button type="submit">Add Product</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="products-grid">
            <?php if(empty($products)): ?>
                <p>No products available.</p>
            <?php else: ?>
                <?php foreach($products as $product): ?>
                    <div class="product-card">
                        <?php if($product['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <a href="/" class="back-link">Back to Home</a>
    </div>
</body>
</html>